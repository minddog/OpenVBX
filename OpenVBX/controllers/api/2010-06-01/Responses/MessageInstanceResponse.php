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

class MessageInstanceResponse extends RestResponse
{
	public function __construct()
	{
		parent::__construct();
	}

	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		$message = $this->Message;
		switch($format)
		{
			case 'json':
				$this->response->version = $version;
				
				$messageJSON = array(
									 'Sid' => $this->Sid,
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
									 'TimeReceived' => date('c', strtotime($message->created)),
									 'LastUpdated' => date('c', strtotime($message->updated)),
									 );

				return json_encode($messageJSON);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				
				/* Message Instance Properties */
				$messageXml = $xml->addChild('Message');
				$messageXml->addChild('Sid', $message->id);
				$messageXml->addChild('From', format_phone($message->caller));
				$messageXml->addChild('To', format_phone($message->called));
				$messageXml->addChild('Body', $message->content_text);
				$messageXml->addChild('TimeReceived', $message->created);
				$messageXml->addChild('LastUpdated', $message->updated);
				$messageXml->addChild('RecordingUrl', $message->content_url);
				$messageXml->addChild('RecordingLength', $message->content_url? format_player_time($message->size) : null);
				$messageXml->addChild('Type', $message->type);
				$messageXml->addChild('TicketStatus', $message->ticket_status);
				$messageXml->addChild('Status', $message->status);
				$messageXml->addChild('Archived', ($message->status == 'archived')? 'true' : 'false');
				$messageXml->addChild('Unread', ($message->status == 'new')? 'true' : 'false');
				
				return $xml->asXML();
				
		}
		
		throw new RestResourceException("Format not supported: $format");
	}

}