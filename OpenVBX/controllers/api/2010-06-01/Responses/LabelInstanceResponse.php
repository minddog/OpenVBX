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

class LabelInstanceResponse extends RestResponse
{
	public function __construct($properties = array())
	{
		parent::__construct();
		foreach($properties as $prop => $val)
		{
			$this->response->$prop = $val;
		}
	}

	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		switch($format)
		{
			case 'json':
				if(!is_object($this->response))
					throw new Exception('Response data not an object');

				$this->response->Version = $version;
				return json_encode($this->response);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				/* Label Properties */
				$labelXml = $xml->addChild('Label');
				
				$labelXml->addChild('Name', $this->Name);
				$labelXml->addChild('Archived', $this->Archived);
				$labelXml->addChild('Total', $this->Total);
				$labelXml->addChild('Read', $this->Read);
				$labelXml->addChild('New', $this->New);
				$labelXml->addChild('Sid', $this->Sid);
				$labelXml->addChild('Type', $this->Type);
				
				return $xml->asXML();
		}
	}
}