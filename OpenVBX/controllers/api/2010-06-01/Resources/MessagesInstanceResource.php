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

class InboxMessagesInstanceResource extends RestResource
{
	private $Sid;
	
	public function __construct($params)
	{
		parent::__construct();
		$this->Sid = !empty($params['Sid'])? $params['Sid'] : null;
		
		if(!$this->Sid)
			throw new RestException('Missing Message Sid');
	}
	
	public function get()
	{
		$ci = &get_instance();
		$ci->load->model('vbx_message');
		$message = $ci->vbx_message->get_message($this->Sid);
		
		$response = new MessageInstanceResponse();
		$response->Sid = $this->Sid;
		$response->Message = $message;
		return $response;
	}

	public function post()
	{
		return new NotImplementedRestResponse();
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
