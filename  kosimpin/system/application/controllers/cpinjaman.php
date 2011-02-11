<?php

class cpinjaman extends Common {

	function __construct()
	{
		parent::__construct();	
		$this->load->model("pinjaman");
		$this->load->model("anggota");
		$this->load->model("user");
		
		//001 cash
		//003 pinjaman
		$this->pinjaman->init_glaccount("001","003","004");
	}

	/**
	* Halaman Utama. Menampilkan pinjaman total per anggota.
	*
	*/
	function index()
	{
		$this->load->helper(array('form', 'url','tanggal'));
		$this->load->library('form_validation');

		
		$data = array();

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('anggota', 'Anggota', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{		
			$daftar_anggota = $this->anggota->get_array_anggota("nama");
			$data["daftar_anggota"] = $daftar_anggota;			
			$data["data_pinjaman"] = $this->pinjaman->get_saldo_per_anggota();
			$this->_load_view('pinjaman/home',$data);	
		}
		else
		{
			//pinjaman baru
			//tanggal
			$tanggal = $this->input->post("tahun")."-".$this->input->post("bulan")."-".$this->input->post("tanggal");
			
			//sukses
			$data = array(
				"id_anggota" => $this->input->post("anggota"),
				"jumlah_pinjaman" => $this->input->post("jumlah"),
				"tgl_transaksi" => "$tanggal"
				);
				
			$this->pinjaman->new_pinjaman($data);
			redirect("cpinjaman/index");		
		}
	}
	
	/**
	* Daftar pinjaman2 anggota
	*/
	function detail($id_anggota=null)
	{
		if($id_anggota!=null)
		{
			$data = array();
			$data["data_pinjaman"] = $this->pinjaman->get_saldo_per_pinjaman($id_anggota);	
			$data["nama_anggota"] = $this->anggota->get_name($id_anggota); 
			$this->_load_view('pinjaman/per_anggota',$data);
		}
		else
		{
			redirect("cpinjaman/index",null);
		}
		
	}
	
	function bayar($id_pinjaman=null,$id_anggota=null)
	{
		if($this->is_admin)
		{
		$this->load->helper(array('form', 'url','tanggal'));
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('tanggal', 'tanggal', 'required');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		
		if($id_pinjaman!=null)
		{
			if ($this->form_validation->run() == FALSE)
			{
				//show the form
				$data = array();
				
				$pinjaman = $this->pinjaman->get_by_id($id_pinjaman);
				$detail_bayar = $this->pinjaman->get_detail_pembayaran($id_pinjaman);
				
				$data['pinjaman'] = $pinjaman;
				$data['pembayaran'] = $detail_bayar;
				$data["nama_anggota"] = $this->anggota->get_name($id_anggota);
				$data["id_pinjaman"] = $id_pinjaman;
				$data["id_anggota"] = $id_anggota;
				
				$this->_load_view('pinjaman/bayar',$data);	
			}
			else
			{
				//save
				//tanggal
				$tanggal = $this->input->post("tahun")."-".$this->input->post("bulan")."-".$this->input->post("tanggal");
			
				//sukses
				$data = array(
					"id_pinjaman" => $id_pinjaman,
					"jumlah_pembayaran" => $this->input->post("jumlah"),
					"keterangan" => $this->input->post("keterangan"),
					"tgl_transaksi" => "$tanggal",
					"jenis_pembayaran"=> $this->input->post("jenis")
					);
				
				$this->pinjaman->bayar_pinjaman($data);
				redirect("cpinjaman/bayar/$id_pinjaman/$id_anggota");
			}
		}
		else
		{
			redirect("cpinjaman/index",null);
		}
		
	}
}