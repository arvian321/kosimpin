<?php
/**
 * Anggota a.k.a Member
 */
class Anggota extends Base_Model {

    function __construct()
    {
        parent::__construct();
        $this->init("anggota","id");
		$this->load->model("pinjaman");
		$this->load->model("tabungan");
    }

    /**
     * Create new code number for anggota
     */
    function new_number()
    {
        
    }
	
	function get_name($id)
	{
		$rec = $this->get_by_id($id);
		if($rec)
		{
			return $rec[0]->nama;
		}
		
		return FALSE;
	}
	
	function get_array_anggota($order_by=null)
	{
		$rec = $this->get_all($order_by);
		$hasil = array();
		if($rec)
		{
			foreach($rec as $row)
			{
				$hasil["$row->id"] = "$row->nama";
			}
		}
		
		return $hasil;
	}
	
    function is_exists($user,$password)
    {
		$this->db->select("nomor_anggota,password")
				 ->from("anggota")
			 ->where("nomor_anggota","$user")
			 ->where("password",md5($password));
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
				return TRUE;
		}
			
		return FALSE;
    }
	
	function get_user($user,$password)
	{
		$this->db->select("id,nomor_anggota as 'user_name',password")
				 ->from("anggota")
			 ->where("nomor_anggota","$user")
			 ->where("password",md5($password));
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
			$result = $rec->result();
			return $result[0];
		}
			
		return FALSE;	
	}
	
	function get_total_tabungan($id_anggota,$type=null)
	{
		$saldo = $this->tabungan->get_saldo_per_anggota($type,$id_anggota);
		return $saldo;
	}
	
	function get_total_pinjaman($id_anggota)
	{
		$saldo = $this->pinjaman->get_saldo_per_anggota($id_anggota);
		return $saldo;
	}
	
}
?>
