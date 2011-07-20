<?php
class summary_tabungan extends Base_model 
{
    function __construct()
    {
        parent::__construct();
        $this->init("summary_tabungan", "id_anggota","saldo");
    }
}
?>