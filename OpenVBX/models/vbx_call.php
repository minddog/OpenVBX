<?php
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
	
require_once(APPPATH . 'libraries/twilio.php');

class VBX_CallException extends Exception {}

/*
 * Call Class
 */
class VBX_Call extends Model {

	private $cache_key;

	public $total = 0;

	private static $call_statuses = array('1' => 'in-progress', '2' => 'complete', '3' => 'busy', '4' => 'error', '5' => 'no-answer');

	const CACHE_TIME_SEC = 180;

	function __construct()
	{
		parent::Model();
		$ci = &get_instance();
		$this->twilio = new TwilioRestClient($this->twilio_sid,
											 $this->twilio_token,
											 $this->twilio_endpoint);
		$this->cache_key = $this->twilio_sid . '_calls';
	}

	function get_calls($offset = 0, $page_size = 20)
	{
		$output = array();

		$page_cache_key = $this->cache_key . "_{$offset}_{$page_size}";
		$total_cache_key = $this->cache_key . '_total';

		if(function_exists('apc_fetch')) {
			$success = FALSE;

			$total = apc_fetch($total_cache_key, $success);
			if($total AND $success) $this->total = $total;

			$data = apc_fetch($page_cache_key, $success);

			if($data AND $success) {
				$calls = @json_decode($data);
				if(is_array($calls)) return $calls;
			}
		}

		$page = floor(($offset + 1) / $page_size);
		$params = array('num' => $page_size, 'page' => $page);
		$response = $this->twilio->request("Accounts/{$this->twilio_sid}/Calls", 'GET', $params);

		if($response->IsError)
		{
			throw new VBX_CallException($response->ErrorMessage, $response->HttpStatus);
		}

		$calls = $response->ResponseXml->Calls;
		
		if(function_exists('apc_store')) {
			apc_store($page_cache_key, json_encode($calls), self::CACHE_TIME_SEC);
			apc_store($total_cache_key, $this->total, self::CACHE_TIME_SEC);
		}
		
		return $calls;
	}

	function make_call($from, $to, $callerid, $rest_access)
	{
		try
		{
			PhoneNumber::validatePhoneNumber($from);
			PhoneNumber::validatePhoneNumber($to);
		}
		catch(PhoneNumberException $e)
		{
			throw new VBX_CallException($e->getMessage());
		}
		
		$twilio = new TwilioRestClient($this->twilio_sid,
									   $this->twilio_token,
									   $this->twilio_endpoint);
		
		$recording_url = site_url("twiml/dial/$callerid/$to/$rest_access");

		$response = $twilio->request("Accounts/{$this->twilio_sid}/Calls",
									 'POST',
									 array( "Caller" => $callerid,
											"Called" => $from,
											"Url" => $recording_url,
											)
									 );
		
		if($response->IsError) {
			error_log($from);
			throw new VBX_CallException($response->ErrorMessage);
		}

		/* HACK: Twilio isn't returning the start time properly on call initiation. */
		$response->ResponseXml->Call->StartTime = $response->ResponseXml->Call->DateCreated;
		return $response->ResponseXml->Call;
	}


	function make_call_path($to, $callerid, $path, $rest_access)
	{
		$twilio = new TwilioRestClient($this->twilio_sid,
									   $this->twilio_token);
		
		$recording_url = site_url("twiml/redirect/$path/$rest_access");
		$response = $twilio->request("Accounts/{$this->twilio_sid}/Calls",
									 'POST',
									 array( "Caller" => $callerid,
											"Called" => $to,
											"Url" => $recording_url,
											)
									 );
		if($response->IsError) {
			error_log($from);
			error_log(var_export($response, true));
			throw new VBX_CallException($response->ErrorMessage);
		}
	}

	static function get_status($id)
	{
		if(array_key_exists($id, Call::$call_statuses)) return Call::$call_statuses[$id];
		return $id;
	}
}