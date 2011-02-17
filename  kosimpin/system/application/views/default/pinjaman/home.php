<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Pinjaman</b>
	<br/><br/>
	Input Pinjaman
	<?php echo form_open("cpinjaman/index"); ?>
	<table>
	<tr><td>Angt.</td><td><?php echo form_dropdown("anggota",$daftar_anggota); ?></td></tr>
	<tr><td>Tgl.</td><td>
		<?php echo tanggal_combo("tanggal"); ?>
		<?php echo bulan_combo("bulan"); ?>
		<?php echo tahun_combo("tahun"); ?>		
	</td></tr>
	<tr><td>Jml.</td><td><input type="text" name="jumlah"></td></tr>
	<tr><td>Ket.</td><td><input type="text" name="keterangan"></td></tr>
	<tr><td>&nbsp</td><td><input type='submit' value='Simpan'></td></tr>
	</table>
	</form>
	
	<table style='border:solid 1px #EEEEEE;'>
	<?php
	  $tsaldo=0;$tpinjaman=0;$tjasa=0;
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>No.</td>
		<td align='center'>Anggota</td>
		<td align='center'>Total</td>
		<td align='center'>Jasa</td>
		<td align='center'>Total Saldo</td>
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
		<td align='right'><?php echo number_format($pinjaman->tpinjaman,","); ?></td>		
		<td align='right'><?php echo number_format($pinjaman->tjasa,","); ?></td>
		<td align='right'><a href='<?php echo site_url()?>/cpinjaman/detail/<?php echo $pinjaman->id_anggota; ?>'><?php echo number_format($pinjaman->tsaldo,","); ?></a></td>
	</tr>
	
	<?php
		$c++;
		}		
	  }
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'></td>
		<td align='center'></td>
		<td align='right'><?php echo number_format($tpinjaman,","); ?></td>
		<td align='right'><?php echo number_format($tjasa,","); ?></td>
		<td align='right'><?php echo number_format($tsaldo,","); ?></td>		
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>