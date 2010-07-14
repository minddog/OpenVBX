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

class RestResourceException extends Exception {}
class RestResource
{
	protected $loginRequired = true;
	
	public function __construct()
	{
		/* Do Nothing */
	}	

	private function checkForValidLogin()
	{
		$ci = &get_instance();
		if(!$ci->session->userdata('loggedin'))
		{
			throw new RestResourceException("Private Rest Resource: Valid authenticated credentials required.", 401);
		}
		else
		{
			$user_id = $ci->session->userdata('user_id');
			$signature = $ci->session->userdata('signature');
			if(VBX_User::signature($user_id) != $signature)
				throw new RestResourceException("Private Rest Resource: Signature has expired", 401);
		}
	}

	private function loginUser()
	{
		$ci = &get_instance();
		$ci->attempt_digest_auth();
	}
	
	public function run($method)
	{
		/* Throws exception if login required and invalid credentials */
		if($this->loginRequired)
		{
			try
			{
				$this->checkForValidLogin();
			}
			catch(RestResourceException $e)
			{
				if($e->getCode() >= 400)
				{
					$this->loginUser();
				}
				else
				{
					throw $e;
				}
			}
		}
		
		if(method_exists($this, strtolower($method)))
			return $this->$method();
		
		return new NotImplementedRestResponse();
	}
}

