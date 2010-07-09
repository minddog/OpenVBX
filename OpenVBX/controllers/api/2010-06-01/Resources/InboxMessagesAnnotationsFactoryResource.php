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

class InboxMessagesAnnotationsFactoryResource extends RestResource
{
	private $MessageSid;
		
	public function __construct($params)
	{
		parent::__construct();
		$this->MessageSid = !empty($params['MessageSid'])? $params['MessageSid'] : null;
		if(!$this->MessageSid)
			throw new RestException('Missing Message Sid');
	}
	

	public function get()
	{
		$ci = &get_instance();
		$max = input_int($ci->input->get('max'), 10);
		$offset = intval($ci->input->get('offset', 0));
		$ci->load->model('vbx_message');
		$message = $ci->vbx_message->get_message($this->MessageSid);

		if($message)
		{
			/* FIXME: no pagination support, we're using array_slice till we implement better domain objects */
			$annotations = $ci->vbx_message->get_message_annotations($this->MessageSid);
			$total = count($annotations);
			$annotations = array_slice($annotations, $offset, $max);
		}

		/* Build Response */
		$response = new MessageAnnotationsFactoryResponse();
		$response->MessageSid = $this->MessageSid;
		$response->Annotations = $annotations;
		$response->Offset = $offset;
		$response->Max = $max;
		$response->Total = $total;
		return $response;
	}

	public function post()
	{
		$ci = &get_instance();
		$type = $ci->input->post('type', 'notes');

		$body = $ci->input->post('body', '');
		
		$message = $ci->vbx_message->get_message($this->MessageSid);
		$user = OpenVBX::getCurrentUser();
		$sid = $ci->vbx_message->annotate($this->MessageSid,
										  $user->id,
										  $body,
										  $type);

		if(!$sid)
			throw new RestException('Unable to create annotation');
		
		$response = new RestResponse();
		
		$response->MessageSid = $this->MessageSid;
		$response->Sid = (string)$sid;
		
		return $response;
	}

	public function put()
	{
		return new NotImplementedRestResponse();
	}

	public function delete()
	{
		return new NotImplementedRestResponse();
	}

}
