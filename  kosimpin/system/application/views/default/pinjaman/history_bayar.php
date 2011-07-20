<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Pembayaran Pinjaman : <?php echo $nama_anggota;  ?></b>
    <table>
	<tr><td>Untuk Pinjaman</td><td>:</td><td><b><?php echo date("d-M-y",strtotime($pinjaman->tgl_transaksi));?></b></td></tr>
	<tr><td>Jumlah Pinjaman</td><td>:</td><td align='right'><b><?php echo number_format($pinjaman->jumlah_pinjaman,0); ?></b></td></tr>	
	<tr><td>Jumlah Jasa</td><td>:</td><td align='right'><b><?php echo number_format($pinjaman->jumlah_jasa,0); ?></b></td></tr>	
	<tr><td>Saldo Hutang</td><td>:</td><td align='right'><b><?php echo number_format($pinjaman->saldo,0); ?></b></td></tr>
	</table>
	<br/>
	
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
		<td align='center' colspan='3'>Total Pembayaran</td>
		<td align='right'><?php echo number_format($total_bayar,","); ?></td>
	</tr>	
	</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>