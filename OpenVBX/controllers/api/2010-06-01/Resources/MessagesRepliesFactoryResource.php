<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * "The contents of this file are subject to the Mozilla Public License
 *  Version 1.1 (the "License"); you may not use this file except in
 *  compliance with the License. You may obtain a copy of the License at
 *  http://www.mozilla.org/MPL/
 
 *  Software distributed under the License is distributed on an "AS IS"
 *  basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 *  License for the specific language governing rights and limitations
 *  under the License.

 *  The Original Code is OpenVBX, released June 15, 2010.

 *  The Initial Developer of the Original Code is Twilio Inc.
 *  Portions created by Twilio Inc. are Copyright (C) 2010.
 *  All Rights Reserved.

 * Contributor(s):
 **/

class MessagesRepliesFactoryResource extends RestResource
{
	const REPLY_SMS = 'sms';
	const REPLY_CALLS = 'called';
	
	private $MessageSid;
		
	public function __construct($params)
	{
		parent::__construct();
		$this->MessageSid = !empty($params['MessageSid'])? $params['MessageSid'] : null;
		if(!$this->MessageSid)
			throw new RestException('Missing Message Sid');
		$this->AnnotationType = !empty($params['AnnotationType'])? $params['AnnotationType'] : array();
	}

	private function getAnnotationTypes()
	{
		if(empty($this->AnnotationType))
			return array(self::REPLY_SMS, self::REPLY_CALLS);

		switch($this->AnnotationType)
		{
			case 'SmsMessages':
				return array(self::REPLY_SMS);
			case 'Calls':
				return array(self::REPLY_CALLS);
		}

		throw new Exception('Unsupported type of Reply: '.$this->AnnotationType);
	}

	public function get()
	{
		$ci = &get_instance();
		$max = input_int($ci->input->get('max'), 10);
		$offset = intval($ci->input->get('offset', 0));
		$ci->load->model('vbx_message');
		$message = $ci->vbx_message->get_message($this->MessageSid);

		if($message)
		{
			/* FIXME: no pagination support, we're using array_slice till we implement better domain objects */
			$annotations = $ci->vbx_message->get_message_annotations($this->MessageSid,
																	 array(
																		   'annotation_types' => $this->getAnnotationTypes()
																		   ));
			$total = count($annotations);
			$replies = array_slice($annotations, $offset, $max);
		}

		/* Build Response */
		$response = new MessageRepliesFactoryResponse();
		$response->MessageSid = $this->MessageSid;
		$response->Replies = $replies;
		$response->Offset = $offset;
		$response->Max = $max;
		$response->Total = $total;
		return $response;
	}

	public function post()
	{
		switch($this->AnnotationType)
		{
			case 'SmsMessages':
				$response = $this->postSmsMessages();
				break;
			case 'Calls':
				$response = $this->postCalls();
				break;
			default:
				return new NotImplementedRestResponse();
		}

		return $response;
	}

	private function postSmsMessages()
	{
		$ci = &get_instance();
		$user = OpenVBX::getCurrentUser();
		$response = new RestResponse();

		$body = substr($ci->input->post('Body'), 0, 160);
		$to = preg_replace('/[^0-9]*/','', $ci->input->post('To'));
		$from = $ci->input->post('From');
		$numbers = array();
		
		if(empty($from))
		{
			try
			{
				$ci->load->model('vbx_incoming_numbers');
				$numbers = VBX_Incoming_Numbers::search(array());
				foreach($numbers->Numbers as $number)
				{
					/* Pop the first number */
					/* TODO: Add preferred dialing number settings here */
					$callerid =  normalize_phone_to_E164($number->phone);
					break;
				}
				
				$from = $numbers->Numbers[0]->phone;
			}
			catch(VBX_IncomingNumberException $e)
			{
				throw new Exception("Unable to retrieve numbers from twilio account: ".$e->getMessage());
			}
		}

		if(empty($from))
		{
			$ci->load->model('device');
			$devices = $ci->device->get_by_user($user->id);
			if(!empty($devices[0]))
			{
				$from = $devices[0]->value;
			}
		}

		/* Create a one time pass for Twilio's Rest Access */
		$ci->load->model('vbx_rest_access');
		$rest_access = $ci->vbx_rest_access->make_key($ci->session->userdata('user_id'));
		$ci->load->model('vbx_message');
		$ci->load->model('vbx_sms_message');
		$sms = $ci->vbx_sms_message->send_message($from, $to, $body);
		$annotationSid = $ci->vbx_message->annotate($this->MessageSid,
													$user->id,
													"$from to ".format_phone($to).": $body",
													'sms',
													$sms->Sid
													);
		
		$response = new SmsMessageInstanceResponse();
		$response->Sid = (String)$sms->Sid;
		$response->ReplySid = $annotationSid;
		$response->MessageSid = $this->MessageSid;
		$response->DateSent = $sms->DateSent;
		$response->From = $from;
		$response->To = $to;
		$response->Body = $body;
		
		return $response;
	}
	
	private function postCalls()
	{
		$ci = &get_instance();

		$user = OpenVBX::getCurrentUser();
		
		$to = normalize_phone_to_E164($ci->input->post('To'));
		$callerid = normalize_phone_to_E164($ci->input->post('Callerid'));
		$from = normalize_phone_to_E164($ci->input->post('From'));
	
		if(empty($from))
		{
			$ci->load->model('vbx_device');
			$devices = $ci->vbx_device->get_by_user($user->id);
			if(!empty($devices[0]))
			{
				$from = $devices[0]->value;
			}
		}

		if(empty($callerid))
		{
			$ci->load->model('vbx_incoming_numbers');
			$numbers = VBX_Incoming_Numbers::search(array());
			foreach($numbers->Numbers as $number)
			{
				/* Pop the first number */
				/* TODO: Add preferred dialing number settings here */
				$callerid =  normalize_phone_to_E164($number->phone);
				break;
			}
		}

		/* Create a one time pass for Twilio's Rest Access */
		$ci->load->model('vbx_rest_access');
		$rest_access = $ci->vbx_rest_access->make_key($ci->session->userdata('user_id'));

		$ci->load->model('vbx_call');
		$ci->load->model('vbx_message');
		$call = $ci->vbx_call->make_call($from, $to, $callerid, $rest_access);
		
		$annotationSid = $ci->vbx_message->annotate($this->MessageSid,
										  $user->id,
										  'Called back from voicemail',
										  'called',
										  $call->Sid);

		$response = new CallInstanceResponse();
		$response->Sid = (String)$call->Sid;
		$response->ReplySid = $annotationSid;
		$response->MessageSid = $this->MessageSid;
		
		$response->StartTime = (String)$call->StartTime;
		$response->EndTime = (String)$call->EndTime;
		$response->Price = (String)$call->Price;
		$response->Status = (String)$call->Status;
		$response->From = $from;
		$response->To = $to;
		$response->CallerId = $callerid;
		$response->TwilioAccountSid = $ci->twilio_sid;
		
		return $response;
	}
	
	public function put()
	{
		return new NotImplementedRestResponse();
	}

	public function delete()
	{
		return new NotImplementedRestResponse();
	}

}
