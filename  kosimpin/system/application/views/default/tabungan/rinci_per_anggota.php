<?php
include(APPPATH."views/default/header.php");
?>
<body>
<b>Tabungan Rinci</b><br><br>
<?php echo "Halaman : ".$total_page; ?><br/><br/>

<table width='150px'>
<tr>
	<td>Tabungan</td>
	<td><?php echo $jenis_tabungan->jenis_tabungan; ?></td>
</tr>
<tr>
	<td>Nama</td>
	<td><?php echo $nama_anggota; ?></td>
</tr>
<tr>
	<td>Saldo</td>
	<td><B><?php echo format_number($total_saldo->saldo) ; ?></B></td>
</tr>
</table>

<br>

<table width="300px" cellpadding='2px'>
 <tr style="font-weight:bold;background-color:#EEEEEE;">
     <td align='center'>No.</td>
     <td align='center'>Tgl</td><td align='center'>In</td><td align='center'>Out</td></tr>
<?php
  if($detail_transaksi){
  $total_in = 0;
  $total_out = 0;
  $c=1;
  foreach($detail_transaksi as $trans)
  {

    $total_in += $trans->jumlah_in;
	$total_out += $trans->jumlah_out;
	if(($c%2)==1)
	{
		$background_color="#EEEEEE";
	}
	else
	{
		$background_color="#FFFFFF";
	}
  ?>
    <tr bgcolor="<?php echo $background_color; ?>">
        <td width='20%' align='center'><?php echo $c; ?></td>
        <td width='30%'><?php echo date("d-m-Y",strtotime($trans->tgl_transaksi)); ?></td>
        <td align="right" width='20%'><?php echo format_number($trans->jumlah_in); ?></td>
        <td align="right" width='30%'><?php echo format_number($trans->jumlah_out); ?>
        </td>		
        </tr>
  <?php
    $c++;
  }
  ?>
    <tr style="font-weight:bold;background-color:#EEEEEE;">
        <td width='20%'></td>
        <td width='30%'></td>
		<td align="right" width='20%'><?php echo format_number($total_in); ?></td>
		<td align="right" width='30%'><?php echo format_number($total_out); ?></td>
	</tr>
  <?php
  }
?>
</table>
<?php
include(APPPATH."views/default/footer.php");
?>
</body>
</html>