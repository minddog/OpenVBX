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

class NumbersFactoryResource extends RestResource
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$ci = &get_instance();
		
		$page = input_int($ci->input->get('page'), 0);
		$num = input_int($ci->input->get('num'), 50);
		
		$include_sandbox = input_bool($ci->input->get('with_sandbox', false));
		$ci->load->model('vbx_incoming_numbers');
		
		$numbers = VBX_Incoming_Numbers::search(array(), $page, $num);
		
		$response = new NumbersFactoryResponse();
		$response->Numbers = $numbers->Numbers;
		$response->Total = $numbers->Total;
		$response->Max = $numbers->Max;
		$response->Page = $numbers->Page;
		
		return $response;
	}

	public function post()
	{
		$ci = &get_instance();
		$ci->load->model('vbx_incoming_numbers');
		$areacode = $ci->input('areacode');
		$is_local = $this->detectTollFree($areacode);
		
		try
		{
			// $number = $ci->vbx_incoming_numbers->add_number($is_local, $areacode);
			$number = array();
		}
		catch (VBX_IncomingNumberException $e)
		{
			$code = $e->getCode();
			if($code)
			{
				throw new Exception(ErrorMessages::message('twilio_api', $code));
			}
		}

		$response = new RestResponse();
		$response->Number = $number;
		
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