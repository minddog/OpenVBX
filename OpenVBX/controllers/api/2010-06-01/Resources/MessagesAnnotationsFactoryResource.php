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

class MessagesAnnotationsFactoryResource extends RestResource
{
	private $MessageSid;

	const TYPE_NOTE = 'noted';
	const TYPE_CALL = 'called';
	const TYPE_SMS = 'sms';
	const TYPE_CHANGE = 'changed';
	
	public function __construct($params)
	{
		parent::__construct();
		$ci = &get_instance();
		$ci->load->model('vbx_message');

		$this->MessageSid = !empty($params['MessageSid'])? $params['MessageSid'] : null;
		if(!$this->MessageSid)
			throw new RestException('Missing Message Sid');
	}


	public function getAnnotationType($type)
	{
		switch($type)
		{
			case self::TYPE_NOTE:
				return "noted";
			case self::TYPE_CALL:
				return "called";
			case self::TYPE_SMS:
				return "sms";
			case self::TYPE_CHANGE:
				return "changed";
			default:
				throw new Exception("Invalid Annotation Type: $type", 500);
		}
	}
	
	public function get()
	{
		$ci = &get_instance();
		$max = input_int($ci->input->get('max'), 10);
		$offset = intval($ci->input->get('offset', 0));
		$annotationType = $ci->input->get('Type');
		$message = $ci->vbx_message->get_message($this->MessageSid);

		if($message)
		{
			/* FIXME: no pagination support, we're using array_slice till we implement better domain objects */
			if(!empty($annotationType))
				$annotations = $ci->vbx_message->get_message_annotations($this->MessageSid,
																		 array(
																			   'annotation_types' => array($this->getAnnotationType($annotationType)),
																			   )
																		 );
			else
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
		$type = $ci->input->post('type', 'note');

		$body = $ci->input->post('body', '');
		
		$message = $ci->vbx_message->get_message($this->MessageSid);
		$user = OpenVBX::getCurrentUser();
		$sid = $ci->vbx_message->annotate($this->MessageSid,
										  $user->id,
										  $body,
										  $type);

		if(!$sid)
			throw new RestException('Unable to create annotation');
		
		$response = new MessageAnnotationInstanceResponse();
		
		$response->MessageSid = $this->MessageSid;
		$response->Sid = (string)$sid;
		$response->Annotation = $ci->vbx_message->get_annotation($sid);
		
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
