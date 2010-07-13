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

class MessageRepliesFactoryResponse extends RestResponse
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
		
		$replies = $this->Replies;
		switch($format)
		{
			case 'json':
				$this->response->version = $version;
				$repliesJSON = new stdClass();
				$repliesJSON->Replies = array();
				foreach($replies as $reply)
				{
					$repliesJSON->Replies[] =
						array(
							  'Sid' => $reply->id,
							  'SmsMessageSid' => $reply->annotation_type == 'sms'? $reply->action_id : null,
							  'CallSid' => $reply->annotation_type == 'called'? $reply->action_id : null,
							  'ActionSid' => $reply->action_id,
							  'Type' => $reply->annotation_type,
							  'UserSid' => $reply->user_id,
							  'FirstName' => $reply->first_name,
							  'LastName' => $reply->last_name,
							  'Description' => $reply->description,
							  'Created' => utc_time_rfc2822($reply->created),
							  );
				}
				$repliesJSON->MessageSid = $this->MessageSid;
				$repliesJSON->Total = $this->Total;
				$repliesJSON->Max = $this->Max;
				$repliesJSON->Offset = $this->Offset;
				
				return json_encode($repliesJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				
				/* Message Instance Properties */
				$repliesXml = $xml->addChild('Replies');
				foreach($replies as $reply)
				{
					$replyXml = $repliesXml->addChild('Reply');
					$replyXml->addChild('Sid', $reply->id);
					$replyXml->addChild('SmsMessageSid', $reply->annotation_type == 'sms'? $reply->action_id : null);
					$replyXml->addChild('CallSid', $reply->annotation_type == 'called'? $reply->action_id : null);
					$replyXml->addChild('Type', $reply->annotation_type);
					$replyXml->addChild('UserSid', $reply->user_id);
					$replyXml->addChild('FirstName', $reply->first_name);
					$replyXml->addChild('LastName' , $reply->last_name);
					$replyXml->addChild('Description' , $reply->description);
					$replyXml->addChild('Created' , utc_time_rfc2822($reply->created));
				}

				$xml->addChild('MessageSid', $this->MessageSid);
				$repliesXml->addAttribute('total', $this->Total);
				$repliesXml->addAttribute('max', $this->Max);
				$repliesXml->addAttribute('offset', $this->Offset);
				
				return $xml->asXML();
				
		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}