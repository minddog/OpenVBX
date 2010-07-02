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


class RestResponse
{
	protected $response;

	public function __construct($data = null)
	{
		$this->response = $data;
	}

	public function __get($name)
	{
		if(!isset($this->response->$name))
			return false;
		
		return $this->response->$name;
	}

	public function __set($name, $value)
	{
		$this->response->$name = $value;
	}
	
	public function encode($format)
	{
		$ci = &get_instance();
		$version = $ci->version;
		
		switch($format)
		{
			case 'json':
				if(!is_object($this->response))
					throw new Exception('Response data not an object');

				$this->response->Version = $version;
				
				return json_encode($this->response);
			case 'xml':
				$xml = new SimpleXMLElement('<Response />');
				$xml->addAttribute('version', $version);
				foreach(get_object_vars($this->response) as $prop => $val)
				{
					if(is_string($val))
						$child = $xml->addChild($prop, $val);
					if(is_object($val))
					{
						$child = $xml->addChild($prop);
						$nodes = get_object_vars($val);
						foreach($nodes as $nodeName => $nodeVal)
						{
							if(is_string($nodeVal))
								$child->addAttribute($nodeName, $nodeVal);
							if(is_object($nodeVal))
								$child->addAttribute($nodeName);
							if(is_array($nodeVal))
							{
								$sub = $child->addChild($nodeName);
								foreach($nodeVal as $__nodeName => $__nodeVal)
								{
									if(is_string($__nodeVal))
										$sub->addChild($__nodeName, $__nodeVal);
								}
							}
						}
					}
				}
				return $xml->asXML();
		}
	}
}
