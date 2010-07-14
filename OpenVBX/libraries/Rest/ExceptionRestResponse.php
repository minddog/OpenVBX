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

class ExceptionRestResponse extends RestResponse
{
	private $ErrorCode;

	public function __construct($errmsg, $errcode)
	{
		parent::__construct(new stdClass());
		$this->response->Error = true;
		$this->response->Message = $errmsg;
		$this->ErrorCode = $errcode;
	}

	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		if($this->ErrorCode >= 200)
			header('x', TRUE, $this->ErrorCode);
		
		switch($format)
		{
			case 'json':
				if(!is_object($this->response))
					throw new Exception('Response data not an object');

				if($version != 'index')
					$this->response->Version = $version;
				
				return json_encode($this->response);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				if($version != 'index')
					$xml->addAttribute('version', $version);
				$child = $xml->addChild('Error', 'true');
				$child = $xml->addChild('Message', $this->response->Message);
				return $xml->asXML();
		}
	}			
}