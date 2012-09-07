<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* ahmad.satiri@streetdirectory.com
*
* This function will order multidimensional array by selecting array key and follow it
* for now it's only in ascending order. :)
*
example :
  
  $marray[0] = array("10:50","aa");
  $marray[1] = array("08:50","cc");
  
  echo "<pre>"; 
  print_r(sort_array($marray,0)); 
  echo "</pre>";
 
 Array
 (
    [0] => Array
        (
            [0] => 08:50
            [1] => cc
        )

    [1] => Array
        (
            [0] => 10:50
            [1] => aa
        )

 )
*
*/

if(!function_exists('array_sort'))
{

	function array_sort($marray=null,$int_field,$dir=1)
	{
		if(is_array($marray) && count($marray)>=1){
		
		foreach($marray as $record)
		{
			$key[]=$record[$int_field]; 	
		}
		
		if($dir==1){
			sort($key);	
		}
		else
		{
			rsort($key);
		}
		
		$result = array();
		
		foreach($key as $thekey)
		{
			for($x=0;$x<count($marray);$x++)
			{
				if(in_array($thekey,$marray[$x]))
				{
					$result[] = $marray[$x];
					$marray[$x] = array(); //replace with blank array
				}
			}			
		}
		
		return $result;
		
		}else
		{
			return false;
		}
	}

}
?>