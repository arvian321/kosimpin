<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

if (! function_exists('select_hapus'))
{
	function select_hapus()
	{
		$hapus = "<select name='hapus'>
		         <option value='N'>N</option>
				 <option value='Y'>Y</option>
				 </select>
				 ";
				 
		return $hapus;
	}
}

/* EOF */