<?php

class User extends Base_Model {

    function __construct()
    {
        parent::__construct();
        $this->init("user","id","user_name");
    }
	
    function is_exists($user,$password)
    {
		$this->db->select("user_name,password")
				 ->from("user")
			 ->where("user_name","$user")
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
		$this->db->select("id,user_name,password")
				 ->from("user")
			 ->where("user_name","$user")
			 ->where("password",md5($password));
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
			$result = $rec->result();
			return $result[0];
		}
			
		return FALSE;	
	}
	
    function add($user,$password,$email="",$anggota=null)
    {
            $data = array("user_name"=>$user,
                          "password"=>md5($password),
			  "email"=>$email
                	  );
					  
            $this->save($data);
    }
	
	function oke(){
	}
}

/* End of file user.php */
/* Location: ./system/application/models/tabungan.php */