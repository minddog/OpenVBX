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

class NumbersFactoryResponse extends RestResponse
{
	public function __construct()
	{
		parent::__construct();
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
				
				$numbersJSON = new stdClass();
				$numbersJSON->Numbers = array();
				$numbersJSON->Total = $this->Total;
				$numbersJSON->Max = $this->Max;
				$numbersJSON->Page = $this->Page;
				
				foreach($this->Numbers as $number)
				{
					$numbersJSON->Numbers[] =
						array(
							  'Sid' => $number->id,
							  'Name' => $number->name,
							  'Phone' => $number->phone,
							  'Pin' => $number->pin,
							  'Sandbox' => $number->sandbox,
							  'Installed' => $number->installed,
							  'VoiceUrl' => $number->url,
							  'VoiceMethod' => $number->method,
							  'SmsUrl' => $number->smsUrl,
							  'SmsMethod' => $number->smsMethod,
							  'FlowSid' => $number->flow_id,
							  );
				}
				return json_encode($numbersJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				$numbersXml = $xml->addChild('Numbers');
				foreach($this->Numbers as $number)
				{
					$numberXml = $numbersXml->addChild('Number');
					$numberXml->addChild('Sid', $number->id);
					$numberXml->addChild('Name', $number->name);
					$numberXml->addChild('Phone', $number->phone);
					$numberXml->addChild('Pin', $number->pin);
					$numberXml->addChild('Sandbox', ($number->sandbox)? 'true': 'false');
					$numberXml->addChild('Installed', ($number->installed)? 'true' : 'false');
					$numberXml->addChild('VoiceUrl', $number->url);
					$numberXml->addChild('VoiceMethod', $number->method);
					$numberXml->addChild('SmsUrl', $number->smsUrl);
					$numberXml->addChild('SmsMethod', $number->smsMethod);
					$numberXml->addChild('FlowSid', $number->flow_id);
				}

				/* Number Factory Properties */
				$numbersXml->addAttribute('total', $this->Total);
				$numbersXml->addAttribute('max', $this->Max);
				$numbersXml->addAttribute('page', $this->Page);
			
				return $xml->asXML();

		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}