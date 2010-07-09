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

class InboxMessagesRepliesFactoryResource extends RestResource
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
			$annotations = array_slice($annotations, $offset, $max);
		}

		/* Build Response */
		$response = new MessageAnnotationsFactoryResponse();
		$response->MessageSid = $this->MessageSid;
		$response->Annotations = $annotations;
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
			case 'Calls':
				$response = $this->postCalls();
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

		$content = substr($ci->input->post('content'), 0, 160);
		$to = preg_replace('/[^0-9]*/','', $ci->input->post('to'));
		$from = $ci->input->post('from');
		$numbers = array();
		
		if(empty($from))
		{
			try
			{
				$numbers = $ci->vbx_incoming_numbers->get_numbers();
				if(empty($numbers))
				{
					throw new Exception("Twilio account has no SMS Enabled numbers");
				}
				$from = $numbers[0]->phone;
			}
			catch(VBX_IncomingNumberException $e)
			{
				throw new Message_TextException("Unable to retrieve numbers from twilio account: ".$e->getMessage());
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

		$ci->load->model('vbx_sms_message');
		$ci->vbx_sms_message->send_message($from, $to, $content);
		$sid = $ci->vbx_message->annotate($this->MessageSid,
													$user->id,
													"$from to ".format_phone($to).": $content",
													'sms');
		
		$response->Sid = $sid;
		$response->MessageSid = $this->MessageSid;
		$response->From = $from;
		$response->To = $to;
		$response->Body = $content;
		
		return $response;
	}
	
	private function postCalls()
	{
		$ci = &get_instance();

		$user = OpenVBX::getCurrentUser();
		
		$to = preg_replace('/[^0-9]*/','', $ci->input->post('to'));
		$callerid = preg_replace('/[^0-9]*/','', $ci->input->post('callerid'));
		$from = $ci->input->post('from');
		
		if(empty($from))
		{
			$ci->load->model('vbx_device');
			$devices = $ci->vbx_device->get_by_user($user->id);
			if(!empty($devices[0]))
			{
				$from = $devices[0]->value;
			}
		}

		/* Create a one time pass for Twilio's Rest Access */
		$ci->load->model('vbx_rest_access');
		$rest_access = $ci->vbx_rest_access->make_key($ci->session->userdata('user_id'));

		$ci->load->model('vbx_call');
		$ci->vbx_call->make_call($from, $to, $callerid, $rest_access);
		
		$sid = $ci->vbx_message->annotate($this->MessageSid,
										  $user->id,
										  'Called back from voicemail',
										  'called');

		$response->Sid = $sid;
		$response->MessageSid = $this->MessageSid;
		$response->From = $from;
		$response->To = $to;
		$response->CallerId = $callerid;
		
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
