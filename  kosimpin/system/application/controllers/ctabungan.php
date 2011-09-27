<?php

class ctabungan extends Common {

    function __construct()
    {
        parent::__construct();
		$this->load->model("tabungan");
		$this->load->model("summary_tabungan","st");	
		$this->load->model("summary_tabungan_total","stt");		
        $this->load->model("jenis_tabungan");
		$this->load->model("user");
		$this->load->model("anggota");
		
		//001 cash
		//005 pinjaman
		$this->tabungan->init_glaccount("001","005");
		
    }

    function index()
    {
        $data = array();
        $total_saldo = $this->tabungan->get_saldo_per_type();
        $data["saldo_tabungan"] = $total_saldo;
		$this->_load_view('tabungan/home',$data);	
    }

	/**
	* 1. sukarela 
	* 2. Pokok
	* 3. Wajib
	*/
	function form($type=1,$sukses=0)
	{	
		if($this->session->userdata("role")!=1)
		{
			$this->no_entry();
			return false;
		}
		
		$this->load->helper(array('form', 'url','tanggal'));
		$this->load->library('form_validation');
		
				
		$this->form_validation->set_rules('anggota', 'Anggota', 'required');
		$this->form_validation->set_rules('tanggal', 'tanggal', 'required');
		$this->form_validation->set_rules('bulan', 'Bulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('jenis_simpanan', 'Jenis_simpanan', 'required');
		
		$data = array();
		if($sukses==1)
		{
			$data["sukses"] = "Input Sukses";
		}
		else
		{
			$data["sukses"] = "";
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			//get all angota
			$daftar_anggota = $this->anggota->get_array_anggota("nama");
			$data["daftar_anggota"] = $daftar_anggota;
			switch($type)
			{
				case 1:
					$data["jenis_simpanan"]=1;
					$this->_load_view('tabungan/form',$data);
				break;
				
				case 2:
					$data["jenis_simpanan"]=2;
					$this->_load_view('tabungan/form_pokok',$data);
				break;
				
				case 3:
					$data["jenis_simpanan"]=3;
					$this->_load_view('tabungan/form_wajib',$data);
				break;
				
				default:
					$this->_load_view('tabungan/form',$data);
				break;
			}		
		}
		else
		{
			//tanggal
			$tanggal = $this->input->post("tahun")."-".$this->input->post("bulan")."-".$this->input->post("tanggal");
			
			//sukses
			$data = array(
				"id_anggota" => $this->input->post("anggota"),
				"jumlah_in" => $this->input->post("jumlah"),
				"id_jenis_tabungan" => $this->input->post("jenis_simpanan"),
				"tgl_transaksi" => "$tanggal"
				);
				
			$this->tabungan->save($data);
			redirect("ctabungan/form/".$this->input->post("jenis_simpanan")."/1");
		}
	}
	
    /**
    * Menyimpan tabungan
    */
    function save()
    {
        
    }

    /**
     * melihat detail saldo per anggota
     * @param int $id_anggota
     */
    function detail($id_jenis=0,$offset=null,$field=null,$value=null)
    {
		if($id_jenis==null)$id_jenis=1;
		
		$offset = $this->uri->segment(4); 
		$limit=10;
		
		if($id_jenis==0)
		{
			$filter = array();
		}
		else
		{
			if($field!=null & $value!=null){
				$filter = " $field like '%$value%' and id_jenis_tabungan=$id_jenis";
			}else{
				$filter = array("id_jenis_tabungan"=>$id_jenis);
			}
		}
		
        $config['base_url'] = site_url() . "/ctabungan/detail/$id_jenis";
        $config['total_rows'] = $this->st->get_count($filter);
        $config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		
        $data = array();
		if($id_jenis==0){
			$total_saldo = $this->stt->get_paged($config['per_page'],$offset,$filter);
		}else{
			$total_saldo = $this->st->get_paged($config['per_page'],$offset,$filter);
		}
        $data["saldo_tabungan"] = $total_saldo;

        $this->pagination->initialize($config);
        $paginator=$this->pagination->create_links();
		
        if($id_jenis!=null && $id_jenis!=0)
        {
            $result = $this->jenis_tabungan->get_title($id_jenis);
            $jenis = $result;
        }
        else
        {
            $jenis = "Total Simpanan";
        }
        
		$data['total_page'] = $paginator;
        $data["jenis_tabungan"] = $jenis;
		$data["id_jenis"] = $id_jenis;
		$this->_load_view('tabungan/saldo_per_anggota',$data);

    }

    function detail_anggota($id_anggota,$id_jenis=null,$offset=null,$field_search=null,$value_search=null)
    {
		if($this->session->userdata("id_anggota")!=$id_anggota)
		{
			$this->no_entry();
			return false;
		}
		
		$offset = $this->uri->segment(5); 
		$limit=10;
		
		$filter = array();
		if($field_search!=null && $value_search!=null)
		{
			$filter = " $field_search like '%$value_search%'";
			if($id_jenis!=null){
				$filter.=" and id_jenis_tabungan=$id_jenis and id_anggota=$id_anggota";
			}
		}else{
			if($id_jenis!=null){
				$filter=array("id_jenis_tabungan"=>$id_jenis,"id_anggota"=>$id_anggota);
			}		
		}
		
        $config['base_url'] = site_url()."/ctabungan/detail_anggota/$id_anggota/$id_jenis" ;
        $config['total_rows'] = $this->tabungan->get_count($filter);
        $config['per_page'] = $limit;
		$config['uri_segment'] = 5;		

		$trans = $this->tabungan->get_paged($config['per_page'],$offset,$filter);
		
        $this->pagination->initialize($config);
        $paginator=$this->pagination->create_links();
		
        if($id_jenis!=null)
        {
            $result = $this->jenis_tabungan->get_by_id($id_jenis);
            $jenis = $result;
        }
        else
        {
            $jenis = (object) array("jenis_tabungan"=>"Total Simpanan");
        }
		
		$data["total_saldo"] = $this->tabungan->get_saldo_per_anggota($id_jenis,$id_anggota);			
		$data['total_page'] = $paginator;
        $data["detail_transaksi"] = $trans;
		$data["jenis_tabungan"] = $jenis;
		$data["id_jenis"] = $jenis; 
		$data["nama_anggota"] = $this->anggota->get_name($id_anggota);
		$this->_load_view('tabungan/rinci_per_anggota',$data);		
    }
}