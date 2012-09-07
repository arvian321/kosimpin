<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

if (! function_exists('digits'))
{
	function digits($number, $digits)
	{
		$number = (int) $number;
		$digits = (int) $digits;
		$prefix = '';
		
		$len = strlen($number);
		if($len < $digits)
		{
			$diff = $digits - $len;
			for($i=0; $i<$diff; $i++)
			{
				$prefix .= '0';
			}
		}
		
		return $prefix.$number;
	}
}

/* EOF */