<html>
<head>
<title><?php echo $this->config->item('nama_koperasi'); ?> - <?php echo $this->config->item('alamat'); ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>/assets/css/default.css"/>
<link href="<?php echo base_url();?>/assets/images/kosim.png" rel='shortcut icon'/>
</head>
<body>

<h1><?php echo $this->config->item('nama_koperasi'); ?></h1>
<center>NO ENTRY</center>
<p>&nbsp;</p>
<?php 
if(isset($message)){
echo $message; 
}
?>

<center>
<small>
Lihat dalam versi : <br>
Mobile Web | <a href='<?php echo site_url();?>/main/index/0/full'>Desktop Web</a>
</small>
</center> 
<?php
include(APPPATH."views/default/footer.php");
?>
</body>
</html>