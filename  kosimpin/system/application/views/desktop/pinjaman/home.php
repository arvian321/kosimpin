<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Pinjaman</b>
	<table style='border:solid 1px #EEEEEE;'>
	<?php
	  $tsaldo=0;$tpinjaman=0;$tjasa=0;
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>No.</td>
		<td align='center'>Anggota</td>
		<td align='center'>Total</td>
		<td align='center'>Total Saldo</td>
		<td align='center'>Jasa</td>
	</tr>
	<?php
	  if($data_pinjaman)
	  {
		$c=1;
		foreach($data_pinjaman as $pinjaman)
		{
			$tjasa += $pinjaman->tjasa;
			$tsaldo += $pinjaman->tsaldo;
			$tpinjaman += $pinjaman->tpinjaman;
	?>

	<tr>
		<td align="center"><?php echo $c; ?>.</td>
		<td><a href='<?php echo site_url()?>/canggota/rekap/<?php echo $pinjaman->id_anggota; ?>'><?php echo $pinjaman->nama; ?></a></td>
		<td align='right'><?php echo format_number($pinjaman->tpinjaman,","); ?></td>
		<td align='right'><?php echo format_number($pinjaman->tsaldo,","); ?></td>
		<td align='right'><?php echo format_number($pinjaman->tjasa,","); ?></td>
	</tr>
	
	<?php
		$c++;
		}		
	  }
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'></td>
		<td align='center'></td>
		<td align='right'><?php echo format_number($tpinjaman,","); ?></td>
		<td align='right'><?php echo format_number($tsaldo,","); ?></td>
		<td align='right'><?php echo format_number($tjasa,","); ?></td>
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>