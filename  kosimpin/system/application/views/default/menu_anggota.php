<b><?php echo $saldo_tabungan[0]->nama; ?></b><br>
<table>
<tr>
	<td>Saldo Tabungan</td>
	<td>:</td>
	<td><?php echo number_format($saldo_tabungan[0]->saldo); ?></td>
</tr>
<tr>
	<td>Pokok</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/canggota/tabdetail/3'><?php echo number_format($saldo_pokok[0]->saldo); ?></a></td>
</tr>
<tr>
	<td>Wajib</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/canggota/tabdetail/2'><?php echo number_format($saldo_wajib[0]->saldo); ?></td>
</tr>
<tr>
	<td>Sukarela</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/canggota/tabdetail/1'><?php echo number_format($saldo_sukarela[0]->saldo); ?></a></td>
</tr>
<tr>
	<td>Saldo Pinjaman</td>
	<td>:</td>
	<td align='right'><a href='<?php echo site_url(); ?>/canggota/pinjdetail'><?php echo number_format($saldo_pinjaman[0]->tsaldo);?></a></td>
</tr>
</table>