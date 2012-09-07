<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* datediff 
*/
if(!function_exists('format_number'))
{
	
	function format_number($number)
	{
		return number_format($number,0,",",".");
	}
	
	function format_date($tgl)
	{
		return date("d-M-Y",strtotime($tgl));
	}	

	function format_hape($hape)
	{
		$len = strlen($hape);
		if($len>4){
			$aa = substr($hape,1,4);
		}else{
			return $len;
		}
	}	
}
?>