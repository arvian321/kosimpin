<html>
<head>
<title><?php echo $this->config->item('nama_koperasi'); ?> - <?php echo $this->config->item('alamat'); ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>/assets/css/default.css"/>
<link href="<?php echo base_url();?>/assets/images/kosim.png" rel='shortcut icon'/>
</head>
<body>
<a href="<?php echo base_url();?>/index.php/main/logout">Logout</a>&nbsp;|
<a href="<?php echo base_url();?>/index.php/main/home">Awal</a>&nbsp;|
<a href="<?php echo base_url();?>/index.php/ctabungan">Tabungan</a>&nbsp;|
<a href="<?php echo base_url();?>/index.php/cpinjaman">Pinjaman</a>&nbsp;
<B><?php echo ($this->session->userdata("role")==1?"Admin":"Anggota"); ?></B>&nbsp;
<h1><?php echo $this->config->item('nama_koperasi'); ?></h1>
</body>
</html>