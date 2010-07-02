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

class InboxFactoryResource extends RestResource
{
	public function get()
	{
		$user = OpenVBX::getCurrentUser();
		$groups = VBX_User::get_group_ids($user->id);
		$response = new InboxFactoryResponse();
		$folders = VBX_Message::get_folders($user->id, $groups);
		foreach($folders as $folder)
		{
			$Labels[] = array(
							  'Name' => $folder->name,
							  'Sid' => $folder->id,
							  'Archived' => $folder->archived,
							  'Type' => $folder->type,
							  'New' => $folder->new,
							  'Read' => $folder->read,
							  'Total' => $folder->total,
							  );

			$response->Total += $folder->total;
			$response->Archived += $folder->archived;
			$response->New += $folder->new;
			$response->Read += $folder->read;
		}

		$response->Labels = $Labels;
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
