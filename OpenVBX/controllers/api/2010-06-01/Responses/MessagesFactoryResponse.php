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

class MessagesFactoryResponse extends RestResponse
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

				$messagesJSON = new stdClass();
				$messagesJSON->Messages = array();
				$messagesJSON->Total = $this->Total;
				$messagesJSON->Offset = $this->Offset;
				$messagesJSON->Max = $this->Max;
				$messagesJSON->Version = $version;
				
				foreach($this->Messages as $message)
				{
					$messagesJSON->Messages[] =
						array(
							  'Sid' => $message->id,
							  'From' => format_phone($message->caller),
							  'To' => format_phone($message->called),
							  'Body' => $message->content_text,
							  'RecordingUrl' => preg_replace('/http:\/\//', 'https://', $message->content_url),
							  'RecordingLength' => $message->content_url? format_player_time($message->size) : null,
							  'Type' => $message->type,
							  'TicketStatus' => $message->ticket_status,
							  'Status' => $message->status,
							  'Assigned' => $message->assigned_to,
							  'Archived' => ($message->status == 'archived')? true : false,
							  'Unread' => ($message->status == 'new')? true : false,
							  'TimeReceived' => utc_time_rfc2822($message->created),
							  'LastUpdated' => utc_time_rfc2822($message->updated),
							  );
				}
				return json_encode($messagesJSON);
				
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				$messagesXml = $xml->addChild('Messages');
				foreach($this->Messages as $message)
				{
					/* Message Instance Properties */
					$messageXml = $messagesXml->addChild('Message');
					$messageXml->addChild('Sid', $message->id);
					$messageXml->addChild('From', format_phone($message->caller));
					$messageXml->addChild('To', format_phone($message->called));
					$messageXml->addChild('Body', $message->content_text);
					$messageXml->addChild('TimeReceived', utc_time_rfc2822($message->created));
					$messageXml->addChild('LastUpdated', utc_time_rfc2822($message->updated));
					$messageXml->addChild('RecordingUrl', $message->content_url);
					$messageXml->addChild('RecordingLength', $message->content_url? format_player_time($message->size) : null);
					$messageXml->addChild('Type', $message->type);
					$messageXml->addChild('TicketStatus', $message->ticket_status);
					$messageXml->addChild('Status', $message->status);
					$messageXml->addChild('Archived', ($message->status == 'archived')? 'true' : 'false');
					$messageXml->addChild('Unread', ($message->status == 'new')? 'true' : 'false');
				}

				/* Message Factory Properties */
				$messagesXml->addAttribute('total', $this->Total);
				$messagesXml->addAttribute('offset', $this->Offset);
				$messagesXml->addAttribute('max', $this->Max);
				
				return $xml->asXML();
		}
	}
}