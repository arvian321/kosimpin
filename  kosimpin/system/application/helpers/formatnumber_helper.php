<?php
/**
* helper ini untuk format number
*/

if(!function_exists('format_number'))
{
	function format_number($number)
	{
		return number_format($number);
	}
}
?>