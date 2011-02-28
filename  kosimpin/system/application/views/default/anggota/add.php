<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Input Anggota  Baru</b>
	<?php echo form_open("canggota/simpan"); ?>
	<table>
	    <tr><td>Nama</td><td><input type="text" name="nama"></td></tr>
		<tr><td>Tgl Gabung</td><td>
		<?php echo tanggal_combo("tanggal"); ?>
		<?php echo bulan_combo("bulan"); ?>
		<?php echo tahun_combo("tahun"); ?>				
		</td></tr>
		<tr><td>Ket.</td><td><input type="text" name="keterangan"></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="Bayar"></td></tr>
	</table>
	</form>	
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>