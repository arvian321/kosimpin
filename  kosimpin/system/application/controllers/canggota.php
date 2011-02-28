<?php

class canggota extends Common {

	function __construct()
	{
		parent::__construct();
		$this->load->model("anggota");
		$this->load->model("pinjaman");
        $this->load->model("tabungan");
		$this->load->model("jenis_tabungan");
		
		$this->load->helper(array('form', 'url','tanggal'));
	}

	/**
	* List Anggota
	*/
	function index()
	{
		$data = array();
		$this->_load_view('anggota/home',$data);
	}
	
	/**
	* Rekap Per Anggota
	*/
	function rekap($id_anggota)
	{
		
		$data = array();
		$data["nama_anggota"] = $this->anggota->get_name($id_anggota);
		$data["anggota"] = $this->anggota->get_by_id($id_anggota);
		$data["tabungan"] = $this->tabungan->get_saldo_per_anggota(null,$id_anggota);
		$data["pinjaman"] = $this->pinjaman->get_saldo_per_anggota($id_anggota);
		$this->_load_view('anggota/per_orang',$data);
	}
	
	function tabdetail($jenis_tabungan=null)
	{
		if($jenis_tabungan!=null)
		{
			//1. sukarela,2. wajib, 3. pokok
			$id_anggota = $this->session->userdata("id_anggota");
			$detail = $this->tabungan->get_detail_per_anggota($id_anggota,$jenis_tabungan);
			
			if($jenis_tabungan!=null)
			{
				$result = $this->jenis_tabungan->get_by_id($jenis_tabungan);
				$jenis = $result[0];
			}
			else
			{
				$jdata = array("jenis_tabungan"=>"Total Simpanan");
				$jenis = (Object) $jdata;
			}
			
			$data["detail_transaksi"] = $detail;
			$data["jenis_tabungan"] = $jenis;
			$data["id_jenis"] = $jenis; 
			$data["nama_anggota"] = $this->anggota->get_name($id_anggota);
			$this->_load_view('tabungan/rinci_per_anggota',$data);			
		}
	}
	
	function pinjdetail()
	{
		$id_anggota = $this->session->userdata("id_anggota");
		$data = array();
		$data["data_pinjaman"] = $this->pinjaman->get_saldo_per_pinjaman($id_anggota);	
		$data["nama_anggota"] = $this->anggota->get_name($id_anggota); 
		$this->_load_view('pinjaman/anggota_per_anggota',$data);	
	}
	
	function simpan()
	{
		$nama = $this->input->post("nama");
		$tanggal = $this->input->post("tahun")."-".$this->input->post("bulan")."-".$this->input->post("tanggal");
		$data = array("nama"=>$nama,"tglmasuk"=>$tanggal);
		
		$this->anggota->save($data);
	}
	function add()
	{
		$data = array();
		$this->_load_view('anggota/add',$data);
	}
	
	function detpinjaman($id=null)
	{
		if($id!=null)
		{
			$id_anggota = $this->session->userdata("id_anggota");
			$data = array();
			$data["pembayaran"] = $detail_bayar = $this->pinjaman->get_detail_pembayaran($id);
			$data["pinjaman"] = $this->pinjaman->get_by_id($id);
			$data["nama_anggota"] = $this->anggota->get_name($id_anggota); 
			$this->_load_view('pinjaman/history_bayar',$data);	
		
		}
	}
}