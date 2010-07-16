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

class CallsFactoryResponse extends RestResponse
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
				
				$callsJSON = new stdClass();
				$callsJSON->Calls = array();
				$callsJSON->Total = $this->Total;
				$callsJSON->Offset = $this->Offset;
				$callsJSON->Max = $this->Max;

				foreach($this->Calls as $call)
				{
					$callsJSON->Calls[] =
						array(
							  'Sid' => $call->Sid,
							  'ReplySid' => $call->ReplySid,
							  'MessageSid' => $call->MessageSid,
							  'From' => format_phone($call->Caller),
							  'To' => format_phone($call->Called),
							  'StartTime' => utc_time_rfc2822($call->StartTime),
							  'EndTime' => utc_time_rfc2822($call->EndTime),
							  );
				}
				return json_encode($callsJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				$callsXml = $xml->addChild('Calls');
				foreach($this->Calls as $call)
				{
					$callXml = $callsXml->addChild('Call');
					$callXml->addChild('Sid', $call->Sid);
					$callXml->addChild('ReplySid', $call->ReplySid);
					$callXml->addChild('MessageSid', $call->MessageSid);
					$callXml->addChild('From', format_phone($call->To));
					$callXml->addChild('To', format_phone($call->From));
					$callXml->addChild('StartTime', utc_time_rfc2822($call->StartTime));
					$callXml->addChild('EndTime', utc_time_rfc2822($call->EndTime));
				}

				/* Call Factory Properties */
				$callsXml->addAttribute('total', $this->Total);
				$callsXml->addAttribute('offset', $this->Offset);
				$callsXml->addAttribute('max', $this->Max);
				
				return $xml->asXML();

		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}
