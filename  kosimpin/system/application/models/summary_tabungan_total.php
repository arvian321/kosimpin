<?php
class summary_tabungan_total extends Base_model 
{
    function __construct()
    {
        parent::__construct();
        $this->init("summary_tabungan_total", "id_anggota","saldo");
    }
}
?>