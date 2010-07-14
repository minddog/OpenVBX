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

class ApiVersionFactoryResource extends RestResource
{
	public function __construct()
	{
		parent::__construct();
		$this->loginRequired = false;
	}

	public function get()
	{
		$supportedVersions = array(
								   '2010-06-01',
								   );
		
		$response = new ApiVersionFactoryResponse();
		
		$response->Versions = $supportedVersions;
		$response->ClientConfiguration = new stdClass();
		$response->ClientConfiguration->RequireTrustedCertificate = true;
		
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
