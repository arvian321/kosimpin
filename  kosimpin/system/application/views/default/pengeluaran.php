<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Pengeluaran</b>
	<br/><br/>
	Input Pengeluaran
	<?php echo form_open("cpengeluaran/index"); ?>
	<table>
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
		<td align='center'>Total</td>
		<td align='center'>Total Saldo</td>
	</tr>
	<?php
	  if($data_pengeluaran)
	  {
		$c=1;
		foreach($data_pengeluaran as $p)
		{
	?>

	<tr>
		<td align="center"><?php echo $c; ?>.</td>
		<td align='right'><?php echo format_number($p->sum_jumlah); ?></td>		
		<td align='right'><?php echo format_number($p->sum_jumlah); ?></td>				
	</tr>
	
	<?php
		$c++;
		}		
	  }
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'></td>
		<td align='center'></td>
		<td align='center'></td>
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>