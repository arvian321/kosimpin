<b><?php echo $saldo_tabungan->nama; ?></b><br>
<table width='300px'>
<tr>
	<td>Saldo Tabungan</td>
	<td>:</td>
	<td align='right'><strong><?php echo number_format($saldo_tabungan->saldo); ?></strong></td>
</tr>
<tr>
	<td>Pokok</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/ctabungan/detail_anggota/<?php echo $id_anggota; ?>/3'><?php echo number_format($saldo_pokok->saldo); ?></a></td>
</tr>
<tr>
	<td>Wajib</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/ctabungan/detail_anggota/<?php echo $id_anggota; ?>/2'><?php echo number_format($saldo_wajib->saldo); ?></td>
</tr>
<tr>
	<td>Sukarela</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/ctabungan/detail_anggota/<?php echo $id_anggota; ?>/1'><?php echo number_format($saldo_sukarela->saldo); ?></a></td>
</tr>
<tr>
	<td>Saldo Pinjaman</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/canggota/pinjdetail'><?php echo number_format($saldo_pinjaman->tsaldo);?></a></td>
</tr>
</table>