<?php
include(APPPATH."views/default/header.php");
?>
<body>
    <b>Tabungan</b><br>
	Input Data : <a href='<?php echo site_url()?>/ctabungan/form/1'>Sukarela</a> | <a href='<?php echo site_url()?>/ctabungan/form/3'>Wajib</a> | <a href='<?php echo site_url()?>/ctabungan/form/2'>Pokok</a><br><br>
Klik pada jumlah untuk melihat rincian tabungan
per anggota.<br><br>

<table width="300px">
 <tr style="font-weight:bold;background-color:#EEEEEE;">
     <td>No.</td>
     <td>Jenis Simpanan</td><td>Saldo</td></tr>
<?php
  if($saldo_tabungan){
  $total_saldo = 0;
  $c=1;
  foreach($saldo_tabungan as $saldo)
  {

    $total_saldo += $saldo->saldo;
  ?>
    <tr>
        <td><?php echo $c; ?></td>
        <td>
            <?php echo $saldo->jenis_tabungan; ?>            
        </td>
        <td align="right">
            <a href='<?php echo site_url();?>/ctabungan/detail/<?php echo $saldo->id_jenis_tabungan; ?>'>
            <?php echo number_format($saldo->saldo,"."); ?>
            </a>
        </td>
        </tr>
  <?php
    $c++;
  }
  ?>
    <tr style="font-weight:bold;background-color:#EEEEEE;">
        <td></td>
        <td>Total</td><td align="right"> <a href='<?php echo site_url();?>/ctabungan/detail/'><?php echo number_format($total_saldo,"."); ?></a></td></tr>
  <?php
  }
?>
</table>

</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>