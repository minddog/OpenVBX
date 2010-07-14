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

class Rest_Controller extends MY_Controller {
	protected $supported_extensions = array('xml', 'json');

	protected $default_format = 'json';
	protected $current_format = '';
	public $version = '';
	
	public function __construct()
	{
		parent::__construct();
		
		set_error_handler(array($this, 'errorHandler'), E_ALL);
			
		$resource_path = APPPATH . 'controllers/api/'.$this->version.'/Resources/';
		$response_path = APPPATH . 'controllers/api/'.$this->version.'/Responses/';
		
		foreach(scandir($response_path) as $response)
		{
			if(preg_match('/^[A-Z].*Response.php$/', $response))
				require_once($response_path.$response);
		}

		foreach(scandir($resource_path) as $resource)
		{
			if(preg_match('/^[A-Z].*Resource.php$/', $resource))
			{
				require_once($resource_path.$resource);
			}
		}

	}
	
	protected function detectFormat($path)
	{
		$current_format = $this->default_format;
		
		if(preg_match('#('.implode('|', $this->supported_extensions).')$#', $path, $matches))
		{
			$current_format =	$matches[1];
		}

		// For backwards compat with general controller interaction we set the response_type to match the detected format type
		$this->response_type = $current_format;
		
		return $current_format;
	}


	protected function responseHeaders()
	{
		$version = OpenVBX::version();
		
		/* Determine headers based on requested format */
		switch($this->current_format)
		{
			case 'xml':
				$contentType = 'application/xhtml+xml';
				break;
			default:
			case 'json':
				$contentType = 'application/json';
		}
		

		/* Emit headers */
		header("X-OpenVBX-API-Version: {$this->version}");
		header("X-OpenVBX-Version: $version");
		header("Content-type: {$contentType}");
	}


	protected function displayResponse($response)
	{
		if(empty($this->current_format))
			$this->current_format = $this->default_format;

		try
		{
			$data = $response->encode($this->current_format);
			$this->responseHeaders();
		}
		catch(Exception $e)
		{
			$this->responseHeaders();
			$response = new ExceptionRestResponse( $e->getMessage() , $e->getCode() );
			$data = $response->encode($this->current_format);
		}

		$pprint = $this->input->get_post('pprint', false);

		if($pprint != false)
		{
			
			if($this->current_format == 'json')
			{
				echo json_pprint($data);
				return;
			}
			
			if($this->current_format == 'xml')
			{
				$doc = new DOMDocument('1.0');
				$doc->formatOutput = true;

				$domnode = dom_import_simplexml(simplexml_load_string($data));
				$domnode = $doc->importNode($domnode, true);
				$doc->appendChild($domnode);
				echo $doc->saveXML();
				return;
			}
		}

		echo $data;
	}

	protected function findResource($resource)
	{
		return RestResourceFactory::buildResource($resource);
	}

	public function errorHandler($errno, $errstr, $errfile, $errline)
	{
		switch($errno)
		{
			case E_USER_NOTICE:
				error_log("$errno::$errfile:$errline::: $errstr");
				break;
			default:
				error_log("$errno::$errfile:$errline::: $errstr");
				throw new Exception("$errno::$errfile:$errline::: $errstr", $errno);
		}

		return true;
	}
}