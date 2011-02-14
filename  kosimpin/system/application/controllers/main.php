<?php

class main extends Common {

	function __construct()
	{
		parent::__construct();
		$this->load->model("tabungan");
		$this->load->model("user");
		$this->load->model("anggota");
	}
	
		
	function index($failed=0,$versi="m")
	{
		
		$this->_set_view_dir($versi);
		
		if($this->session->userdata('logged_in')==true && strlen($this->session->userdata('username'))>0)
		{
			//redirect to home
			redirect("main/home",null);
		}
		else
		{
			$tabungan = $this->tabungan->get_record(date("Y-m-d"),date("Y-m-d"));
			$data["message"] = "";
			if($failed==1)
			{
				$data["message"]="Login Failed. Please notice that password is case sensitive.";
			}
			
			$this->_load_view("login",$data);
		}
	}
	
	function login()
	{
		$exist = $this->user->is_exists($this->input->post("user"),$this->input->post("password"));
		$member = $this->anggota->is_exists($this->input->post("user"),$this->input->post("password"));
		if($exist)
		{
			$data_user = $this->user->get_user($this->input->post("user"),$this->input->post("password"));
			$newdata = array(
							   'username'  => $this->input->post("user"),
							   'logged_in' => TRUE,
							   'id_user' => $data_user->id,
							   'role' => 1
						   );

			$this->session->set_userdata($newdata);		
			redirect("main/home",null);
		}
		elseif($member)
		{
			$data_user = $this->anggota->get_user($this->input->post("user"),$this->input->post("password"));
			$newdata = array(
							   'username'  => $this->input->post("user"),
							   'logged_in' => TRUE,
							   'id_user' => $data_user->id,
							   'role' => 2,
							   'id_anggota' =>$data_user->id
						   );

			$this->session->set_userdata($newdata);		
			redirect("main/home",null);			
		}
		else
		{
			redirect("main/index/1",null);
		}
	}
	
	function home()
	{
		if($this->session->userdata('logged_in')==true && strlen($this->session->userdata('username'))>0)
		{
			$data = array();
			if($this->session->userdata("role")==1)
			{
				//admin
				$this->_load_view('home',$data);	
			}
			elseif($this->session->userdata("role")==2)
			{
				$saldo_tabungan = $this->anggota->get_total_tabungan($this->session->userdata("id_anggota"));
				$saldo_pinjaman = $this->anggota->get_total_pinjaman($this->session->userdata("id_anggota"));
				
				$data["saldo_tabungan"] = $saldo_tabungan;
				$data["saldo_pinjaman"] = $saldo_pinjaman;
				
				$this->_load_view('home_anggota',$data);
			}
			else
			{
				$this->session->sess_destroy();
				redirect("main/index/0",null);
			}
		}
		else
		{
			redirect("main/index/0",null);
		}
	}
	
	function logout($nextpage=null)
	{
		$newdata = array(
						   'username'  => "",
						   'logged_in' => FALSE
					   );

		$this->session->set_userdata($newdata);			
		
		if($nextpage==null)
		{
			redirect("main/index/0",null);
		}
		else
		{
			$nextpage = str_replace("~","/",$nextpage);
			redirect($nextpage,null);
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */