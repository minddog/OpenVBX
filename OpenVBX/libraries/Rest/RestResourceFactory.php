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


class RestResourceFactoryException extends Exception {}
class RestResourceFactory
{
	public static $resources = array(
									  );
	
	public static function buildResource($resource)
	{
		foreach(self::$resources as $resource_expr => $class)
		{
			if(preg_match($resource_expr, $resource, $matches))
			{
				return new $class();
			}

			throw new RestResourceFactoryException("Unable to locate resource: $resource");
		}
	}
}