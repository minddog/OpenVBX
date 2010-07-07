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

class Docs extends User_Controller {

	function __construct()
	{
		parent::__construct();
		$this->section = 'docs';
		$this->admin_only('docs');
		$this->template->write('title', 'Docs');
	}

	public function index()
	{
		return $this->page('');
	}

	public function page()
	{
		$page = str_replace('/docs/', '', $this->uri->uri_string());

		if(empty($page))
			$page = 'index';
		
		if($page[strlen($page) - 1] == '/')
			$page .= 'index';
		
		$this->load->helper('markdown');
		$file = APPPATH . '/../assets/docs/'.$page.'.md';
		if(!file_exists($file))
			return show_404();
		
		$contents = file_get_contents($file);
		echo markdown($contents);
	}
}
