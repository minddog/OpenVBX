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

class LabelsInstanceResource extends RestResource
{
	private $Sid;
	
	public function __construct($params)
	{
		parent::__construct();
		$ci = &get_instance();
		$ci->load->model('vbx_message');
		
		$this->LabelName = !empty($params['LabelName'])? $params['LabelName'] : null;
		
		if(!$this->LabelName)
			throw new Exception('Missing LabelName', 500);
	}
	
	public function get()
	{
		$user = OpenVBX::getCurrentUser();

		$groups = array(0);
		if(strtolower($this->LabelName) != 'inbox')
		{
			$group = VBX_Group::get(array('name' => $this->LabelName));
			if(!$group)
				throw new Exception('No label found by the name: '.$this->LabelName, 404);
			
			$groups = array($group->id);
			$folders = VBX_Message::get_folders($user->id, $groups);
			
			if(!isset($folders[$group->id]))
				throw new Exception('No label found by the name: '.$this->LabelName, 404);
			$folder = $folders[$group->id];
			
		}
		else
		{
			$folders = VBX_Message::get_folders($user->id, $groups);
			$folder = $folders[0];
		}
		
		$response = new LabelInstanceResponse();
		$response->Name = $folder->name;
		$response->Sid = $folder->id;
		$response->Archived = $folder->archived;
		$response->Type = $folder->type;
		$response->New = $folder->new;
		$response->Read = $folder->read;
		$response->Total = $folder->total;

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
