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
										'/Messages$/' => MessagesFactoryResource,
										);
	}

	public function index()
	{
		$response = new ExceptionRestResponse('Resource not specified');
		$this->displayResponse($response);
	}

	public function resource($path)
	{
		$this->current_format = $this->detectFormat($path);

		/* Run Method */

		try
		{
			$resource = $this->findResource(str_replace('.'.$this->current_format, '', $path));
			$response = $resource->run($this->request_method);
		}
		catch(Exception $e)
		{
			$response = new ExceptionRestResponse($e->getMessage());
		}
		
		/* Return in format */
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
			$data = $this->encodeError($e->getMessage(),
									   $this->current_format);
		}

		echo $data;
	}

	private function findResource($resource)
	{
		return RestResourceFactory::buildResource($resource);
	}

	private function encodeError($message, $format)
	{
		switch($format)
		{
			case 'json':
				$data = json_encode(array('error' => true,
										  'message' => $message));
				break;
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$error = new SimpleXMLElement('<Error />');
				$error->addChild($message);
				$xml->addAttribute('version', $this->version);
				$xml->addChild('Error', 'true');
				$xml->addChild('Message', $message);
				$data = $xml->asXML();
				break;
		}

		return $data;
	}
}