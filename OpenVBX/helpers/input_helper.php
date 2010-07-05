<?php

function input_bool($input)
{
	$input = strtolower($input);
	if($input == 'false' || $input == 0 || $input == false)
		$input = false;
	
	return $input;
}
		
function input_array($input, $default = array())
{
	if(!$input)
		return $default;

	if(empty($input))
		return $default;

	return explode(',', $input);
}

function input_int($input, $default)
{
	$input = trim($input);
	
	if(empty($input) && $input != 0)
		return $default;

	return $input;
}