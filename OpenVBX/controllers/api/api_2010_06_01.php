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
												'Messages/{MessageSid}/Replies' =>  'MessagesRepliesFactoryResource', /* list of calls or smses <Calls>,<SmsMessages>, etc. */
												/* list of calls, POST to call back, optional callback # (call all my phones if not supplied in v2) */
												/* list of smses, POST to send an SMS reply, only <Body> is required */
												'Messages/{MessageSid}/Replies/{AnnotationType}' => 'MessagesRepliesFactoryResource',
												
												'Messages/{MessageSid}/Annotations' => 'MessagesAnnotationsFactoryResource',
												'Messages/{MessageSid}/Annotations/{AnnotationSid}' => 'MessagesAnnotationsInstanceResource',
												'Messages/{Sid}' => 'MessagesInstanceResource', /* message Detail */
												'Messages' => 'MessagesFactoryResource', /* list of all messages */

												'Calls' => 'CallsFactoryResource', /* Make outbound calls and retrieve call logs */
												'SmsMessages' => 'SmsMessagesFactoryResource', /* Make outbound calls and retrieve call logs */
												
												'Labels' => 'LabelsFactoryResource', /* list of all label resource instances */
												'Labels/{LabelName}/Messages' => 'MessagesFactoryResource', /* list of messages in label resource */
												'Labels/{LabelName}' => 'LabelsInstanceResource', /* detail about the label resource instance */
												'Numbers' => 'NumbersFactoryResource',
												'Theme' => 'ThemeInstanceResource', /* retrieves theme instance set by environment */
												);
	}
	
	public function index()
	{
		/* Strip QS and detect extension */
		$resource_path = str_replace('/api/'.$this->version.'/', '', $this->uri->uri_string());
		$resource_path = preg_replace('#\?.*#', '', $resource_path);
		$this->current_format = $this->detectFormat($resource_path);

		$response = new RestResponse();
		$response->Version = $this->version;
		
		$this->displayResponse($response);
	}

	public function resource()
	{
		
		try
		{
			/* Strip QS and detect extension */
			$resource_path = str_replace('/api/'.$this->version.'/', '', $this->uri->uri_string());
			$resource_path = preg_replace('#\?.*#', '', $resource_path);
			$this->current_format = $this->detectFormat($resource_path);

			/* Remove extension and locate resource */
			$resource_path = str_replace('.'.$this->current_format, '', $resource_path);
			$resource = $this->findResource($resource_path);
			
			/* Run HTTP Request Method GET/POST/PUT/DELETE */
			$response = $resource->run($this->request_method);
		}
		catch(Exception $e)
		{
			$response = new ExceptionRestResponse($e->getMessage(), $e->getCode());
		}
		
		/* Return in specified format */
		$this->displayResponse($response);
	}

}