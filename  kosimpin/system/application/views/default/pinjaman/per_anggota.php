<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Daftar Pinjaman : <?php echo $nama_anggota; ?></b>
	<table style='border:solid 1px #EEEEEE;'>
	<?php
	  $tsaldo=0;$tpinjaman=0;$tjasa=0;
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>No.</td>
		<td align='center'>Total</td>
		<td align='center'>Jasa</td>
		<td align='center'>Total Saldo</td>
		<td align='center'>&nbsp;</td>
	</tr>
	<?php
	  if($data_pinjaman)
	  {
		$c=1;
		foreach($data_pinjaman as $rp)
		{
		
		$tpinjaman += $rp->tpinjaman;
		$tjasa += $rp->tjasa;
		$tsaldo += $rp->tsaldo;
	?>

	<tr>
		<td align="center"><?php echo $c; ?>.</td>
		<td align='right'><?php echo format_number($rp->tpinjaman); ?></td>		
		<td align='right'><?php echo format_number($rp->tjasa); ?></td>
		<td align='right'><?php echo format_number($rp->tsaldo); ?></a></td>
		<td align='center'><a href='<?php echo site_url()?>/cpinjaman/bayar/<?php echo $rp->id."/".$rp->id_anggota; ?>'>Bayar</a></td>
	</tr>
	
	<?php
		$c++;
		}		
	  }
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'></td>		
		<td align='right'><?php echo format_number($tpinjaman); ?></td>
		<td align='right'><?php echo format_number($tjasa); ?></td>
		<td align='right'><?php echo format_number($tsaldo); ?></td>
		<td align='center'></td>		
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>