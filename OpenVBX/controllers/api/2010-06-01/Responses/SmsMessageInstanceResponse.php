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

class SmsMessageInstanceResponse extends RestResponse
{
	public function __construct()
	{
		parent::__construct();
		$this->MessageSid = null;
		$this->ReplySid = null;
		$this->To = null;
		$this->From = null;
		$this->DateSent = null;
		$this->Flags = null;
		$this->Price = null;
	}

	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		$message = $this->Message;
		switch($format)
		{
			case 'json':
				$smsMessageJSON =
					 array(
						   'Sid' => $this->Sid,
						   'ReplySid' => $this->ReplySid,
						   'MessageSid' => $this->MessageSid,
						   'From' => format_phone($this->To),
						   'To' => format_phone($this->From),
						   'Status' => $this->Status,
						   'DateSent' => utc_time_rfc2822($this->DateSent),
						   'Price' => $this->Price,
						   'Flags' => $this->Flags,
						   'Version' => $version,
						   );

				return json_encode($smsMessageJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				
				/* Call Instance Properties */
				$callXml = $xml->addChild('SmsMessage');
				$callXml->addChild('Sid', $this->Sid);
				$callXml->addChild('ReplySid', $this->ReplySid);
				$callXml->addChild('MessageSid', $this->MessageSid);
				$callXml->addChild('From', format_phone($this->To));
				$callXml->addChild('To', format_phone($this->From));
				$callXml->addChild('Status', $this->Status);
				$callXml->addChild('DateSent', utc_time_rfc2822($this->DateSent));
				$callXml->addChild('Price', $this->Price);
				$callXml->addChild('Flags', $this->Flags);
				
				return $xml->asXML();
				
		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}
