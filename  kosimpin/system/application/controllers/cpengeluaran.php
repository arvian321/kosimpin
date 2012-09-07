<?php
class cpengeluaran extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("pengeluaran");
		$this->load->model("user");
		$this->load->model("anggota");
		
		$this->pengeluaran->init_glaccount("001","006");
	}
	
	function index()
	{
		$this->load->helper(array('form', 'url','tanggal'));
		$this->load->library('form_validation');

		
		$data = array();

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{		
			$data["data_pengeluaran"] = $this->pengeluaran->get_total_per_month();
			$this->_load_view('pengeluaran',$data);	
		}
		else
		{
			//pengeluaran baru
			//tanggal
			$tanggal = $this->input->post("tahun")."-".$this->input->post("bulan")."-".$this->input->post("tanggal");
			
			//sukses
			$data = array(
				"jumlah" => $this->input->post("jumlah"),
				"tgl_transaksi" => "$tanggal"
				);
				
			$this->pengeluaran->save($data);
			redirect("cpengeluaran/index");		
		}
	}

}