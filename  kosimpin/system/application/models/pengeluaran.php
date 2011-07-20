<?php
class Pengeluaran extends Base_model 
{
	var $kode_account;
	var $cash_account;
	
    function __construct()
    {
        parent::__construct();
        $this->init("pengeluaran", "id","keterangan");
		$this->load->model("gl/GLedger");
    }
	
	function init_glaccount($cash_account,$tabungan_account)
	{
		$this->kode_account = $tabungan_account;
		$this->cash_account = $cash_account;
	}
	
	/**
	* Overload Parent
	*/
	function save($data)
	{
		parent::save($data);
		if(is_array($data))
		{
			$data = (Object)$data;
		}
				
		//save gl		
		$kas = new Jurnal_entry();
		$kas->nomor_account = $this->cash_account;
		$kas->kredit_value = (float)$data->jumlah;
		$kas->debit_value = 0;
		$kas->tgl_transaksi = $data->tgl_transaksi;
		$kas->nomor_dokumen = "";

		$pengeluaran = new Jurnal_entry();
		$pengeluaran->nomor_account = $this->kode_account;
		$pengeluaran->debit_value = (float)$data->jumlah;
		$pengeluaran->kredit_value = 0;
		$pengeluaran->tgl_transaksi = $data->tgl_transaksi;
		$pengeluaran->nomor_dokumen = "";
		
		//kas berkurang
		//pengeluaran bertambah
		$result = $this->Gledger->write_jurnal($pengeluaran,$kas);		
	}
	
	function get_total_per_month()
	{
		$fields="sum(jumlah) as sum_jumlah";
		$this->db->select($fields)->from($this->table_name)
		                          ->group_by("month(tgl_transaksi)");
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
			return $rec->result();
		}
		return FALSE;
	}
}
?>