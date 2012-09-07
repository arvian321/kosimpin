<?php
/**
* echo time_parser(10000)."<br>";
* mengkonversi jumlah detik menjadi format jam:menit
* satiri.a@gmail.com
*/
if(!function_exists('time_parser'))
{

	function time_parser($detik)
	{
		if($detik>60)
		{
			$menit = floor(($detik/60));
			
			if($menit>60)
			{
				$jam = floor($menit/60);
				$sisa = $menit % 60;
				
				return leading_zero($jam,2).":".leading_zero($sisa,2);
			}
			else
			{
				return "00:".leading_zero($menit,2);
			}
		}
		else
		{
			return "00:00";
		}
	}
	
	/**
	* merubah string menjadi time
	* 01:10 -> 70 menit -> 70*60 
	*/
	function time_convert($string_time)
	{
		$time = explode(":",$string_time);
		if(count($time)>=2)
		{
			$jam = (int)$time[0];
			$menit = (int)$time[1];
			
			$detik1 = $jam*60*60;
			$detik2 = $menit*60;
			return ($detik1+$detik2);
		}
		else
		{
			//bukan waktu
			return 0;
		}
	}



	/**
	* hasilnya berupa detik
	* detik 1
	*/
	function time_diff($timea,$timeb)
	{
		$detik1 = time_convert($timea);
		$detik2 = time_convert($timeb);
		
		$hasil = $detik2-$detik1;
		return $hasil;
	}
	
}

if(!function_exists('leading_zero'))
{

	function leading_zero($angkaku,$lebar)
	{
		$myangka = (string) $angkaku;
		if($lebar>strlen($myangka))
		{
			$hasil = str_repeat("0",$lebar-strlen($myangka)).$myangka;
			return $hasil;
		}
		else
		{
			return $angkaku;
		}
	}

}
?>