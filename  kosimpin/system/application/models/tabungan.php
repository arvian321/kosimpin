<?php

class Tabungan extends Base_model {

	var $kode_account;
	var $cash_account;
	
    function __construct()
    {
        parent::__construct();
        $this->init("tabungan", "id");
		$this->load->model("gl/GLedger");
    }
	
	/**
	* Setup account number
	*/
	function init_glaccount($cash_account,$tabungan_account)
	{
		$this->kode_account = $tabungan_account;
		$this->cash_account = $cash_account;
	}	
	
    function get_saldo($kode_anggota)
    {
        return 100000;
    }
	
    function get_record($tgl_awal,$tgl_sampai)
    {
        $this->db->select("*")
                 ->from("tabungan")
		 ->where("tgl_transaksi","$tgl_awal",">=")
		 ->where("tgl_transaksi","$tgl_sampai","<=");

        $rec = $this->db->get();

        if($rec->num_rows()>0)
	{
            return $rec->result();
	}
		
        return FALSE;
    }

	function get_detail_per_anggota($id_anggota,$jenis)
	{
        $this->db->select("*")
                 ->from("tabungan")
				 ->where("id_anggota",$id_anggota);
				 
				
        if($jenis!=null)
        {
            $this->db->where("tabungan.id_jenis_tabungan",$jenis);
        }
		
		$rec = $this->db->get();
		
		if($rec->num_rows()>0)
		{
			return $rec->result();
		}
		return FALSE;
	}
	
    /**
     * Data total saldo peranggota. adalah data in - out
     */
    function get_saldo_per_anggota($type=null,$id_anggota=null)
    {
        $fields = "sum(jumlah_in),sum(jumlah_out),sum(jumlah_in-jumlah_out) as 'saldo',tabungan.id_anggota,anggota.nama";
        $this->db->select($fields)
                 ->from($this->table_name)
                 ->join("anggota","anggota.id=tabungan.id_anggota","inner")
                 ->join("jenis_tabungan","jenis_tabungan.id=tabungan.id_jenis_tabungan","inner")
                 ->group_by("anggota.nama")
                ;

        if($type!=null)
        {
            $this->db->where("tabungan.id_jenis_tabungan",$type);
        }

        if($id_anggota!=null)
        {
            $this->db->where("tabungan.id_anggota",$id_anggota);
        }
        
        $rec = $this->db->get();
        
        if($rec->num_rows()>0)
        {
            return $rec->result();
        }
		/**
		paging
		$config['base_url'] 	= base_url().'index.php/tabungan/artikel/';
		$config['total_rows']	= $query->num_rows();
		$config['per_page'] 	= '30';
		$num			= $config['per_page'];
		$offset			= $this->uri->segment(3);
		$offset 		= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;
		
		if(empty($offset))
		{
			$offset=0;
		}
		
		$this->pagination->initialize($config);		
		
		$data['query']		= $this->db->query($string_query." limit $offset,$num");	
		$data['base']		= $this->config->item('base_url');		
		*/
        return FALSE;
    }

    function get_saldo_per_type()
    {
        $fields = "sum(jumlah_in),sum(jumlah_out),sum(jumlah_in-jumlah_out) as 'saldo',
                   tabungan.id_jenis_tabungan,jenis_tabungan.jenis_tabungan";
        $this->db->select($fields)
                 ->from($this->table_name)
                 ->join("jenis_tabungan","jenis_tabungan.id=tabungan.id_jenis_tabungan","inner")
                 ->group_by("tabungan.id_jenis_tabungan")
                ;

        $rec = $this->db->get();
        if($rec->num_rows()>0)
        {
            return $rec->result();
        }

        return FALSE;
    }

    function get_total_saldo($type=null)
    {
        $fields = "sum(jumlah_in),sum(jumlah_out),sum(jumlah_in-jumlah_out) as 'saldo',tabungan.id_anggota,anggota.nama";
        $this->db->select($fields)
                 ->from($this->table_name)
                 ->join("anggota","anggota.id=tabungan.id_anggota","inner")               
                ;

        if($type!=null)
        {
            
        }
        
        $rec = $this->db->get();
        if($rec->num_rows()>0)
        {
            return $rec->result();
        }

        return FALSE;   
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
		$kas->debit_value = (float)$data->jumlah_in;
		$kas->kredit_value = 0;
		$kas->tgl_transaksi = $data->tgl_transaksi;
		$kas->nomor_dokumen = "";

		$tabungan = new Jurnal_entry();
		$tabungan->nomor_account = $this->kode_account;
		$tabungan->debit_value = 0;
		$tabungan->kredit_value = (float)$data->jumlah_in;
		$tabungan->tgl_transaksi = $data->tgl_transaksi;
		$tabungan->nomor_dokumen = "";
		
		$result = $this->GLedger->write_jurnal($kas,$tabungan);		
	}




 }

/* End of file tabungan.php */
/* Location: ./system/application/models/tabungan.php */