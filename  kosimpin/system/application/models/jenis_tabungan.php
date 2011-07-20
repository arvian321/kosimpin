<?php
/**
 * Jenis - jenis tabungan
 */
class Jenis_tabungan extends Base_Model {

    function __construct()
    {
        parent::__construct();
        $this->init("jenis_tabungan","id","jenis_tabungan");
    }
}
?>
