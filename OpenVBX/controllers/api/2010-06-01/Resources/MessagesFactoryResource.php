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

class MessagesFactoryResource extends RestResource
{
	public function __construct($params)
	{
		parent::__construct();
		$this->LabelName = isset($params['LabelName'])? $params['LabelName'] : null;
	}
	
	public function get()
	{
		/* Available query string options: ?max=&offset= */
		$ci = &get_instance();
		$ci->load->model('vbx_message');
		$max = input_int($ci->input->get('max'), 10);
		$offset = intval($ci->input->get('offset', 0));
		$archived = input_bool($ci->input->get('archived', false));
		$from = input_array($ci->input->get('from', false));
		$to = input_array($ci->input->get('to', false));
		$body = $ci->input->get('body', false);
		$ticket_status = input_array($ci->input->get('ticket_status'), array('all'));
		$response = new MessagesFactoryResponse();
		$user = OpenVBX::getCurrentUser();
		if($this->LabelName && strtolower($this->LabelName) != 'inbox')
		{
			$group = VBX_Group::get(array('name' => $this->LabelName));
			if(!$group)
				throw new Exception('No label found by the name: '.$this->LabelName);
			
			$groups = array($group->id);
			$folders = VBX_Message::get_folders($user->id, $groups);
			
			if(!isset($folders[$group->id]))
				throw new Exception('No label found by the name: '.$this->LabelName);
			$folder = $folders[$group->id];
			
			$users = null;
			$groups = array($group->id);
		}
		else
		{
			$users = array($user->id);
			$groups = VBX_User::get_group_ids($user->id);
		}
		
		
		$message = new VBX_Message();
		$messages = $message->get_messages(array('ticket_status' => $ticket_status,
												 'archived' => $archived,
												 'from' => $from,
												 'to' => $to,
												 'body' => $body,
												 'user' => $users,
												 'group' => $groups,
												 ), $offset, $max);
		$response->Messages = $messages['messages'];
		$response->Total = $messages['total'];
		$response->Max = $messages['max'];
		$response->Offset = $messages['offset'];
		
		return $response;
	}

	public function post()
	{
		return new NotImplementedRestResponse();
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
