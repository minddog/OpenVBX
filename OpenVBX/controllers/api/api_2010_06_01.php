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

require_once APPPATH . '/libraries/Rest/RestResponse.php';
require_once APPPATH . '/libraries/Rest/ExceptionRestResponse.php';
require_once APPPATH . '/libraries/Rest/NotImplementedRestResponse.php';
require_once APPPATH . '/libraries/Rest/RestResource.php';
require_once APPPATH . '/libraries/Rest/RestResourceFactory.php';

class Api_2010_06_01 extends Rest_Controller
{	
	public $version = '2010-06-01';
	
	public function __construct()
	{
		parent::__construct();
		RestResourceFactory::$resources = array(
												'/Inbox\/Messages\/{MessageSid}\/Annotations\/{Sid}' => 'InboxMessagesAnnotationsInstanceResource',
												'/Inbox\/Messages\/{Sid}\/Replies' =>  'InboxMessagesRepliesFactoryResource', /* list of calls or smses <Calls>,<SmsMessages>, etc. */
												'/Inbox\/Messages\/{Sid}\/Annotations' => 'InboxMessagesAnnotationsFactoryResource',
												'/Inbox\/Messages\/{Sid}' => 'InboxMessagesInstanceResource', /* message Detail */
												'/Inbox\/Messages' => 'InboxMessagesFactoryResource', /* list of all messages */

												/* list of calls, POST to call back, optional callback # (call all my phones if not supplied in v2) */
												/* list of smses, POST to send an SMS reply, only <Body> is required */
												'/Inbox\/Messages\/{MessageSid}\/Replies\/{("Calls"|"SmsMessages")}' => 'InboxMessagesRepliesFactoryResource',

												
												'/Inbox\/Labels\/{Name}\/Messages' => 'InboxLabelsMessagesFactoryResource', /* list of messages */
												'/Inbox\/Labels\/{Name}' => 'InboxLabelsInstanceResource', /* detail about the label (not much for now) */
												'/Inbox\/Labels' => 'InboxLabelsFactoryResource', /* list of labels (no counts) */
												'/Inbox' => 'InboxFactoryResource', /* lables + counts */
												);
	}
	
	public function index()
	{
		$factory = new stdClass();
		$factory->resources = RestResourceFactory::$resources;
		$response = new RestResponse( $factory );
		$this->displayResponse($response);
	}

	public function resource()
	{
		$path = str_replace('/api/'.$this->version.'/', '', $this->uri->uri_string());
		$this->current_format = $this->detectFormat($path);
		
		try
		{
			/* Strip QS and extension to clean path */
			$resource_path = str_replace('.'.$this->current_format, '', $path);
			$resource_path = preg_replace('#\?.*#', '', $resource_path);
			$resource = $this->findResource($resource_path);
			/* Run HTTP Request Method GET/POST/PUT/DELETE */
			$response = $resource->run($this->request_method);
		}
		catch(Exception $e)
		{
			$response = new ExceptionRestResponse($e->getMessage());
		}
		
		/* Return in specified format */
		$this->displayResponse($response);
	}

	private function displayResponse($response)
	{
		if(empty($this->current_format))
			$this->current_format = $this->default_format;

		try
		{
			$data = $response->encode($this->current_format);
		}
		catch(Exception $e)
		{
			$response = new ExceptionRestResponse( $e->getMessage() );
			$data = $response->encode($this->current_format);
		}

		if($this->current_format == 'json')
		{
			$pprint = $this->input->get_post('pprint', false);
			if($pprint !== false)
			{
				echo json_pprint($data);
				return;
			}
		}

		echo $data;
	}

	private function findResource($resource)
	{
		return RestResourceFactory::buildResource($resource);
	}

	private function encodeError($message)
	{
	}
}