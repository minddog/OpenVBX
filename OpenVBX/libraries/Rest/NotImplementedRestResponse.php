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

class NotImplementedRestResponse extends RestResponse
{
	public function __construct()
	{
		parent::__construct();
		$this->response->error = true;
		$this->response->message = 'Not Implemented';
	}

	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		switch($format)
		{
			case 'json':
				$this->response->version = $version;
				return json_encode($this->response);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				$child = $xml->addChild('Error', 'true');
				$child = $xml->addChild('Message', $this->response->message);
				return $xml->asXML();
		}
	}
}
