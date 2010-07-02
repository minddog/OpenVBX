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

class Rest_Controller extends User_Controller {
	protected $supported_extensions = array('xml', 'json');

	protected $default_format = 'json';
	protected $current_format = '';
	public $version = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$resource_path = APPPATH . 'controllers/api/'.$this->version.'/Resources/';
		$response_path = APPPATH . 'controllers/api/'.$this->version.'/Responses/';
		
		foreach(scandir($response_path) as $response)
		{
			if(preg_match('/Response.php$/', $response))
				require_once($response_path.$response);
		}

		foreach(scandir($resource_path) as $resource)
		{
			if(preg_match('/Resource.php$/', $resource))
			{
				require_once($resource_path.$resource);
			}
		}

	}
	
	protected function detectFormat($path)
	{
		$current_format = $this->default_format;
		
		if(preg_match('/('.implode('|', $this->supported_extensions).')$/', $path, $matches))
		{
			$current_format =	$matches[1];
		}

		return $current_format;
	}

}