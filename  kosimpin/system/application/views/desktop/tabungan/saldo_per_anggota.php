<?php
include(APPPATH."views/default/header.php");
?>
<body>
<b>Tabungan</b><br><br>
<?php echo $jenis_tabungan; ?>
<table width="300px">
 <tr style="font-weight:bold;background-color:#EEEEEE;">
     <td>No.</td>
     <td>Anggota</td><td>Tabungan</td></tr>
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
        <td><a href='<?php echo site_url();?>/canggota/rekap/<?php echo $saldo->id_anggota; ?>'>
            <?php echo $saldo->nama; ?>
            </a>
        </td>
        <td align="right">
            <a href='<?php echo site_url();?>/ctabungan/detail_anggota/<?php echo $saldo->id_anggota."/".$id_jenis; ?>'>
            <?php echo format_number($saldo->saldo); ?>
            </a>
        </td>
        </tr>
  <?php
    $c++;
  }
  ?>
    <tr style="font-weight:bold;background-color:#EEEEEE;">
        <td></td>
        <td>Total</td><td align="right"><?php echo format_number($total_saldo); ?></td></tr>
  <?php
  }
?>
</table>
<?php
include(APPPATH."views/default/footer.php");
?>
</body>
</html>