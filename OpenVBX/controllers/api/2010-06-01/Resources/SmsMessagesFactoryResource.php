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

class SmsMessagesFactoryResource extends RestResource
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		return new NotImplementedResponse();
	}

	public function post()
	{
		$ci = &get_instance();

		$user = OpenVBX::getCurrentUser();
		
		$body = $ci->input->post('Body');
		$to = normalize_phone_to_E164($ci->input->post('To'));
		$from = normalize_phone_to_E164($ci->input->post('From'));

		if(empty($body))
		{
			throw new Exception('Missing body of SMS message', 500);
		}
		
		if(empty($from))
		{
			$ci->load->model('vbx_incoming_numbers');
			$numbers = VBX_Incoming_Numbers::search(array());
			foreach($numbers->Numbers as $number)
			{
				/* Pop the first number */
				/* TODO: Add preferred dialing number settings here */
				$from = normalize_phone_to_E164($number->phone);
				break;
			}
		}

		/* Create a one time pass for Twilio's Rest Access */
		$ci->load->model('vbx_rest_access');
		$rest_access = $ci->vbx_rest_access->make_key($ci->session->userdata('user_id'));

		$ci->load->model('vbx_sms_message');
		$message = $ci->vbx_sms_message->send_message($from, $to, $body);
		$response = new SmsMessageInstanceResponse();
		$response->Sid = (String)$message->Sid;
		$response->TimeSent = (String)$message->TimeSent;
		$response->Price = (String)$message->Price;
		$response->Status = (String)$message->Status;
		$response->From = $from;
		$response->To = $to;
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
