<?php
include(APPPATH."views/default/header.php");
?>
<body>
<b>Anggota</b><br><br>
<br><br>
<?php echo "Halaman : ";echo  strlen($total_page)==0?"1":$total_page; ?>
<?php
  if($result):
  ?>
  <table style="width:300px;">
  <tr style='font-weight:bold;padding:2px;background-color:#CCCCCC;text-align:center'>
	<td>NO.</td> 
	<td>NOMOR ANGGOTA</td>  
	<td>NAMA</td>
  </tr>	  
  <?php
  $c=1;	
  foreach($result as $row)
  {
?>
  <tr style='border-bottom:solid 1px #CCC'>
	<td align='center'><?php echo $c; ?></td> 
	<td><?php echo $row->nomor_anggota; ?></td>  
	<td><?php echo $row->nama; ?></td>
  </tr>	
<?php
	$c++;
  }
  ?>
  </table>
  <?php
  endif
?>
</body>
<?php
include(APPPATH."views/default/footer.php");
?>
</html>