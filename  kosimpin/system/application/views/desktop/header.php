<html>
<head>
<title><?php echo $this->config->item('nama_koperasi'); ?> - <?php echo $this->config->item('alamat'); ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>/assets/css/default.css"/>
<script language="javascript" src="<?php echo base_url()?>/assets/js/jquery/jquery.js"></script>
<link href="<?php echo base_url();?>/assets/images/kosim.png" rel='shortcut icon'/>
</head>
<body style='margin:0px'>
<div style='background-color:#CCCCCC;padding:5px;'>
<a href="<?php echo site_url();?>/main/logout/main~index~0~full">Logout</a>&nbsp;|
<a href="<?php echo site_url();?>/main/home">Awal</a>&nbsp;|
<a href="<?php echo site_url();?>/ctabungan">Tabungan</a>&nbsp;|
<a href="<?php echo site_url();?>/cpinjaman">Pinjaman</a>&nbsp;
</div>
<h1><?php echo $this->config->item('nama_koperasi'); ?></h1>
</body>
</html>