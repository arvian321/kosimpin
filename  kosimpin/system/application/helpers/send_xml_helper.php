<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

if (! function_exists('send_xml'))
{
	function send_xml($output, $string)
	{
		$output->set_header("Cache-Control: no-cache");
		$output->set_header("Expires: -1");
		$output->set_header("Content-type: text/xml");
	
		$xml_content = "<?xml version=\"1.0\" ?>\n";
		$xml_content .= str_replace("><", ">\n<", $string);
		$output->set_output($xml_content);		
	}
}