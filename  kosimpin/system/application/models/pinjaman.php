<?php

class Pinjaman extends Base_Model {

	var $kode_account;
	var $cash_account;
	var $jasa_account;
	
    function __construct()
    {
        parent::__construct();
        $this->init("pinjaman","id","catatan");
		$this->load->model("gl/GLedger");	
    }
		
	/**
	* Setup account number
	*/
	function init_glaccount($cash_account,$pinjaman_account,$jasa_pinjaman)
	{
		$this->kode_account = $pinjaman_account;
		$this->cash_account = $cash_account;
		$this->jasa_account = $jasa_pinjaman;
	}	
		
    function get_saldo($kode_anggota)
    {
        return 100000;
    }
	
	/**
	* id_anggota,tgl_transaksi,jumlah_pinjaman
	*/
	function new_pinjaman($data)
	{
		if(is_array($data) || is_object($data))
		{
			if(is_array($data))
			{
				$data = (Object) $data;
			}
			
			$id_anggota = (int) $data->id_anggota;
			$jumlah_pinjaman = (double) $data->jumlah_pinjaman;
			
			if($id_anggota>0 && $jumlah_pinjaman>0)
			{
				// @todo make percentage become configurable
				$jasa = (10*$jumlah_pinjaman)/100;
				$saldo = $jumlah_pinjaman + $jasa;
				
				//add to class
				$data = (array) $data;
				$data["jumlah_jasa"] = $jasa;
				$data["saldo"] = $saldo;
				
				$id = $this->save($data);
				return $id;
			}
			
			return FALSE;
		}
		
		return FALSE;
	}
	
    function get_record($tgl_awal,$tgl_sampai)
    {
        $this->db->select("*")
		 ->from("pinjaman")
		 ->where("tgl_transaksi","$tgl_awal",">=")
		 ->where("tgl_transaksi","$tgl_sampai","<=");

        $rec = $this->db->get();
		if($rec->num_rows()>0)
		{
            return $rec->result();
		}
		else
		{		
			return FALSE;
		}
	}
	
	/**
	* data is array contain id_pinjaman,jumlah_pembayaran,keterangan
	*/
    function bayar_pinjaman($data)
    {
		if(is_array($data))
		{
			$data = (Object) $data;
			//make sure have pinjaman
			$current = $this->pinjaman->get_by_id($data->id_pinjaman);
			if($current)
			{
				$new_saldo = $current[0]->saldo - $data->jumlah_pembayaran;
				$pembayaran_update = array("saldo"=>$new_saldo);
				
				//input detail
				$rec = $this->db->insert("pembayaran_pinjaman",$data);
				
				if($rec)
				{
					$this->db->where("id",$data->id_pinjaman);
					$this->db->update("pinjaman",$pembayaran_update);
					
					//new kas
					$kas = new Jurnal_entry();
					$kas->nomor_account = $this->cash_account;
					$kas->debit_value = (float)$data->jumlah_pembayaran;
					$kas->kredit_value = 0;
					$kas->tgl_transaksi = $data->tgl_transaksi;
					$kas->nomor_dokumen = "";
		

					//@TODO account harus terpilih antara pembayaran jasa atau 
					//pokok
					$pinjaman = new Jurnal_entry();
					$pinjaman->nomor_account = $this->kode_account;
					$pinjaman->debit_value = 0;
					$pinjaman->kredit_value = (float)$data->jumlah_pembayaran;
					$pinjaman->tgl_transaksi = $data->tgl_transaksi;
					$pinjaman->nomor_dokumen = "";	

					$result = $this->GLedger->write_jurnal($kas,$pinjaman);			
				}
				
				return FALSE;
			}
			return FALSE;
		}
		else
		{
			return FALSE;
		}
    }
	
    function batalkan_pinjaman()
    {
    }
	
    function get_detail_pembayaran($id_pinjaman)
    {
		$this->db->select("*")
			->from("pembayaran_pinjaman")
			->where("id_pinjaman",$id_pinjaman)
			->order_by("tgl_transaksi","asc");
		
		$rec = $this->db->get();
		
		if($rec->num_rows()>0)
		{
			return $rec->result();
		}
		else
		{
			return FALSE;
		}
    }
	
	function get_saldo_per_pinjaman($id_anggota)
	{
        $fields = "jumlah_pinjaman as 'tpinjaman',sum(saldo) as 'tsaldo',jumlah_jasa as 'tjasa',pinjaman.id,anggota.nama,pinjaman.id_anggota";
        $this->db->select($fields)
                 ->from($this->table_name)
                 ->join("anggota","anggota.id=pinjaman.id_anggota","inner")
                 ->group_by("pinjaman.id")
				 ->order_by("tsaldo","desc")
                ;
		
		$this->db->where("pinjaman.id_anggota",$id_anggota);
		
		$rec = $this->db->get();
        
        if($rec->num_rows()>0)
        {
            return $rec->result();
        }
        return FALSE;

	}
	
	function get_saldo_per_anggota($id_anggota=null)
    {
        $fields = "sum(jumlah_pinjaman) as 'tpinjaman',sum(saldo) as 'tsaldo',sum(jumlah_jasa) as 'tjasa',pinjaman.id_anggota,anggota.nama";
        $this->db->select($fields)
                 ->from($this->table_name)
                 ->join("anggota","anggota.id=pinjaman.id_anggota","inner")
                 ->group_by("anggota.nama")
				 ->order_by("tsaldo","desc")
                ;


        if($id_anggota!=null)
        {
            $this->db->where("pinjaman.id_anggota",$id_anggota);
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
		//parent::save($data);
		if(is_array($data))
		{
			$data = (Object)$data;
		}
				
				
		//save gl		
		//piutang bertambah
		$pinjaman = new Jurnal_entry();
		$pinjaman->nomor_account = $this->kode_account;
		$pinjaman->debit_value = (float)$data->jumlah_pinjaman;
		$pinjaman->kredit_value = 0;
		$pinjaman->tgl_transaksi = $data->tgl_transaksi;
		$pinjaman->nomor_dokumen = "";

		
		$jasa_pinjaman = new Jurnal_entry();
		$jasa_pinjaman->nomor_account = $this->jasa_account;
		$jasa_pinjaman->debit_value = $data->jumlah_jasa;
		$jasa_pinjaman->kredit_value = 0;
		$jasa_pinjaman->tgl_transaksi = $data->tgl_transaksi;
		$jasa_pinjaman->nomor_dokumen = "";
		
		$tpinjaman = array($pinjaman,$jasa_pinjaman);
		
		//kas berkurang
		
		$kas = new Jurnal_entry();
		$kas->nomor_account = $this->cash_account;
		$kas->debit_value = 0;
		$kas->kredit_value = (float)$data->jumlah_pinjaman;
		$kas->tgl_transaksi = $data->tgl_transaksi;
		$kas->nomor_dokumen = "";
		
		//tidak melihat nilai balance karena 
		//ada value jasa
		$result = $this->GLedger->write_jurnal($tpinjaman,$kas,false);		
	}	
	
}

/* End of file pinjaman.php */
/* Location: ./system/application/models/pinjaman.php */