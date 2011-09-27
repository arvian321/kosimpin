<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Daftar Pinjaman : <?php echo $nama_anggota; ?></b><br/></br>
Klik Saldo untuk melihat history pembayaran.<br/>
	<table style='border:solid 1px #EEEEEE;width:300px;'>
	<?php
	  $tsaldo=0;$tpinjaman=0;$tjasa=0;
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>No.</td>
		<td align='center'>Total</td>
		<td align='center'>Jasa</td>
		<td align='center'>Total Saldo</td>
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
		<td align='right'><?php echo number_format($rp->tpinjaman,","); ?></td>		
		<td align='right'><?php echo number_format($rp->tjasa,","); ?></td>
		<td align='right'><a href='<?php echo site_url();?>/canggota/detpinjaman/<?php echo $rp->id; ?>'><?php echo number_format($rp->tsaldo,","); ?></a></td>
	</tr>
	
	<?php
		$c++;
		}		
	  }
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'></td>		
		<td align='right'><?php echo number_format($tpinjaman,","); ?></td>
		<td align='right'><?php echo number_format($tjasa,","); ?></td>
		<td align='right'><?php echo number_format($tsaldo,","); ?></td>
		<td align='center'></td>		
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>