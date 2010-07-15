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

class MessageAnnotationsFactoryResponse extends RestResponse
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
		
		$annotations = $this->Annotations;
		switch($format)
		{
			case 'json':
				$annotationsJSON = new stdClass();
				$annotationsJSON->Annotations = array();
				foreach($annotations as $annotation)
				{
					$annotationsJSON->Annotations[] =
						array(
							  'Sid' => $annotation->id,
							  'SmsMessageSid' => $annotation->annotation_type == 'sms'? $annotation->action_id : null,
							  'CallSid' => $annotation->annotation_type == 'called'? $annotation->action_id : null,
							  'Type' => $annotation->annotation_type,
							  'UserSid' => $annotation->user_id,
							  'FirstName' => $annotation->first_name,
							  'LastName' => $annotation->last_name,
							  'Description' => $annotation->description,
							  'Created' => utc_time_rfc2822($annotation->created),
							  'MessageSid' => $this->MessageSid,
							  );
				}
				$annotationsJSON->Total = $this->Total;
				$annotationsJSON->Max = $this->Max;
				$annotationsJSON->Offset = $this->Offset;
				$annotationsJSON->Version = $version;
				return json_encode($annotationsJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				
				/* Message Instance Properties */
				$annotationsXml = $xml->addChild('Annotations');
				foreach($annotations as $annotation)
				{
					$annotationXml = $annotationsXml->addChild('Annotation');
					$annotationXml->addChild('Sid', $annotation->id);
					$annotationXml->addChild('SmsMessageSid', $annotation->annotation_type == 'sms'? $annotation->action_id : null);
					$annotationXml->addChild('CallSid', $annotation->annotation_type == 'called'? $annotation->action_id : null);
					$annotationXml->addChild('Type', $annotation->annotation_type);
					$annotationXml->addChild('UserSid', $annotation->user_id);
					$annotationXml->addChild('FirstName', $annotation->first_name);
					$annotationXml->addChild('LastName' , $annotation->last_name);
					$annotationXml->addChild('Description' , $annotation->description);
					$annotationXml->addChild('Created' , utc_time_rfc2822($annotation->created));
					$annotationXml->addChild('MessageSid', $this->MessageSid);
				}

				$annotationsXml->addAttribute('total', $this->Total);
				$annotationsXml->addAttribute('max', $this->Max);
				$annotationsXml->addAttribute('offset', $this->Offset);
				
				return $xml->asXML();
				
		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}

