<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Pembayaran Pinjaman : <?php echo $nama_anggota; ?></b>
    <table>
	<tr><td>Untuk Pinjaman</td><td>:</td><td><b><?php echo date("d-M-y",strtotime($pinjaman->tgl_transaksi));?></b></td></tr>
	<tr><td>Saldo Hutang</td><td>:</td><td><b><?php echo number_format($pinjaman->saldo,0); ?></b></td></tr>
	</table>
	<br/>
	<?php echo form_open("cpinjaman/bayar/$id_pinjaman/$id_anggota"); ?>
	<table>
		<tr><td>Tgl</td><td>
		<?php echo tanggal_combo("tanggal"); ?>
		<?php echo bulan_combo("bulan"); ?>
		<?php echo tahun_combo("tahun"); ?>				
		</td></tr>
		<tr><td>Jml</td><td><input type="text" name="jumlah"></td></tr>
		<tr><td>Ket.</td><td><input type="text" name="keterangan"></td></tr>
		<tr><td>Jns.</td><td><select name="jenis"><option value="1">Cicilan</option><option value="2">Jasa</option></select></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="Bayar"></td></tr>
	</table>
	</form>
	
	History Pembayaran  
	<!-- history pembayaran -->
	<table width='300px' style='border:solid 1px #CCCCCC;'>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>No.</td>
		<td align='center'>Tgl.</td>
		<td align='center'>J</td>
		<td align='center'>Jml</td>
	</tr>
	<?php 
		$total_bayar = 0;
		if($pembayaran)
		{
			$c=1;
			foreach($pembayaran as $byr)
			{
			$total_bayar += $byr->jumlah_pembayaran;
	?>
		<tr>
		<td align='center'><?php echo $c?>.</td>
		<td><?php echo date("d-M-y",strtotime($byr->tgl_transaksi)); ?></td>
		<td align='center'><?php echo $byr->jenis_pembayaran; ?></td>
		<td align='right'><?php echo number_format($byr->jumlah_pembayaran,","); ?></td>
		</tr>
		
	<?php 
			$c++;
			}
		}
	?>
	<tr style="font-weight:bold;background-color:#EEEEEE;">
		<td align='center'>&nbsp;</td>
		<td align='center'>&nbsp;</td>
		<td align='center'>&nbsp;</td>
		<td align='right'><?php echo number_format($total_bayar,","); ?></td>
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>