<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Anggota</b><br><br>
<table>
<tr><td><b>Nama</b></td><td>: <b><?php echo $anggota[0]->nama; ?></b></td></tr>
<tr><td>Kode</td><td>: <?php echo $anggota[0]->nomor_anggota; ?></td></tr>
<tr><td>Alamat</td><td>: <?php echo $anggota[0]->alamat; ?></td></tr>
<tr><td>Telpon</td><td>: <?php echo $anggota[0]->telpon; ?></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>	
Klik pada jumlah untuk melihat rincian tabungan/pinjaman.
<br><br>
<table>
<tr><td>Saldo Total Simpanan</td><td>:</td><td align="right">&nbsp;<a href='<?php echo site_url();?>/ctabungan/detail_anggota/<?php echo $anggota[0]->id; ?>'><?php echo number_format($tabungan[0]->saldo,","); ?></a></td></tr> 
<tr><td>Total Pinjaman</td><td>:</td><td align="right">&nbsp;<a href=''><?php echo number_format($pinjaman[0]->tpinjaman,","); ?></a></td></tr>
<tr><td><B>Total Saldo Pinjaman</b></td><td>:</td><td align="right">&nbsp;<a href='<?php echo site_url(); ?>/cpinjaman/'><?php echo number_format($pinjaman[0]->tsaldo,","); ?></a></td></tr>
</table>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>