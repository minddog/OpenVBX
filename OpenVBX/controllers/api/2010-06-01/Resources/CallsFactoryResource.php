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

class CallsFactoryResource extends RestResource
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$ci = &get_instance();
		$max = input_int($ci->input->get('max'), 10);
		$offset = intval($ci->input->get('offset', 0));
		$ci->load->model('vbx_call');
		$calls = $ci->vbx_call->get_calls($offset, $max);
		
		/* Build Response */
		$response = new CallsFactoryResponse();
		
		$response->Calls = $calls->Call;
		$response->Offset = $calls['offset'];
		$response->Max = $max;
		$response->Total = $calls['total'];
		
		return $response;
	}

	public function post()
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
			
			/* Find first active device */
			foreach($devices as $device)
			{
				$from = $devices[0]->value;
				if($device->is_active)
					break;
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
		$call = $ci->vbx_call->make_call($from, $to, $callerid, $rest_access);
		$response = new CallInstanceResponse();
		$response->Sid = (String)$call->Sid;
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
