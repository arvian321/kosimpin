<?php
/**
 * satiri.a@gmail.com
 * Database CRUD Model
 */
class Base_model extends Model {

    var $table_name;
    var $field_id = null;
	var $field_title = null;
	
	var $references;
	var $filters;
	var $default_order = null;
	
    function __construct()
    {
        parent::Model();
		$this->references = array();
		$this->limit = 30;
		$this->use_limit = false;
    }
	
	function set_default_order($array)
	{
		$this->default_order = $array;
	}

	/**
	* will truncate this main table
	*/
	function wipe()
	{
		$result = $this->db->query("truncate table ". $this->table_name);
		return $result;
	}
	
	function reset_status_diweb()
	{
		$data = array("sudah_diweb"=>0);
		$this->db->update($this->table_name,$data);	
	}
	
	function add_reference($table_name,$ref_field,$this_field,$join_type="inner")
	{
		$this->references[] = array($table_name,$ref_field,$this_field,$join_type);
	}
	
	function add_filter($field_name,$field_value,$type="and")
	{
		$this->filters[] = (Object) array("field"=>$field_name,"value"=>$field_value,"type"=>$type);
	}
	
	/**
	* read table structure and create arrt_pageay from it
	* this if only for mysql
	* @return $object
	*/
	function get_blank_object()
	{
		$sql = "show fields from ".$this->table_name;
		$fields = $this->db->query($sql);
		$result = $fields->result();
		
		$object = array();
		foreach($result as $field)
		{
			$object[$field->Field] = "";
		}
		$obj = (Object) $object;
		
		return $obj;
	}
	
    function init($table_name,$id_field,$title_field=null)
    {
        $this->table_name = $table_name;
        $this->field_id = $id_field;
		$this->field_title = $title_field;
    }

	/**
	* Alias untuk get_title
	*/
	function get_name($id=null)
	{
		if($id==null)
			return FALSE;
			
		$title = $this->get_title($id);
		return $title;
	}
	
	function get_title($id)
	{
		if($this->field_title==null)
		{
			return FALSE;
		}
		else
		{
			$row = $this->get_by_id($id);
			if($row)
			{
				$row = (array) $row;
				return $row[$this->field_title];
			}else{
				return FALSE;
			}
		}
	}
	
	/**
	* Berguna untuk membentuk list seperti combo
	* $top_list adalah opsi tambahan untuk diatas combo
	*/
	function get_list($top_list=null)
	{
		if($this->field_id==null && $this->field_title==null)
			return FALSE;
		
		$this->db->order_by($this->field_title);
		$all = $this->get_all();
		if($all)
		{
			
			$result = array();
			if($top_list!=null)
			{
				$result[0] = $top_list[0];
			}
			foreach($all as $row)
			{			
				$row = (array) $row;
				$result[$row[$this->field_id]] = $row[$this->field_title];
			}			
			return $result;
		}
		else
		{
			return FALSE;
		}		
	}
	
    /**
     *
     * @param array $data
     */
    function save($data)
    {
		if(is_object($data))
		{
			$data = (array)$data;
		}
		
        $data["tgl_input"] = date("Y-m-d H:i:s");
        isset($_SERVER["HTTP_HOST"])?$data["ip_input"] = $_SERVER["HTTP_HOST"]:$data["ip_input"]="CLI";
		$data["id_user"] = $this->session->userdata("id_user");
        @$this->db->insert($this->table_name,$data);
		@$id = $this->db->insert_id();
		return $id;
    }

    function delete($id)
    {
        $where = array("$this->field_id"=>$id);
        $result = $this->db->delete($this->table_name,$where);
		return $result;
    }

    function delete_where($filter)
    {
        $result = $this->db->delete($this->table_name,$filter);
		return $result;
    }
    
	function get_all($order_by=null,$use_ref=true)
	{
        $this->db->select("*")
                 ->from($this->table_name);
		
		if($order_by!=null)
		{
			$this->db->order_by($order_by,"asc");
		}
		
		if($this->filters!=null)
		{
			foreach($this->filters as $w)
			{
				switch(strtolower($w->type))
				{
					case "or":
						$this->db->or_where($w->field,$w->value);
					break;
					
					case "and";
						$this->db->where($w->field,$w->value);
					break;
					
					default:
						$this->db->where($w->field,$w->value);
					break;
				}
			}
		}
		
		if($use_ref){
		if(count($this->references)>0)
		{
			foreach($this->references as $ref)
			{
				$table_name = $ref[0];
				$join = $ref[0].".".$ref[1]."=".$this->table_name.".".$ref[2];
				$this->db->join($table_name,$join,$ref[3]);
			}
		}
		}
		
		if($this->use_limit==true)
		{
			$this->db->limit($this->limit);	
		}
		
        $rec = $this->db->get();		
		if($rec->num_rows()>0)
        {
            return $rec->result();
        }

        return FALSE;
	}
	
    /**
     * 
     * @param int $id
     * @return resultset
     */
    function get_by_id($id,$use_ref=true)
    {
        $where = array("$this->table_name.$this->field_id"=>$id);
        $this->db->select("*")
                 ->from($this->table_name)
                 ->where($where);
				 
        if($use_ref){         
		if(count($this->references)>0)
		{
			foreach($this->references as $ref)
			{
				$table_name = $ref[0];
				$join = $ref[0].".".$ref[1]."=".$this->table_name.".".$ref[2];
				$this->db->join($table_name,$join,$ref[3]);
			}
		}}
				 
        $rec = $this->db->get();

        if($rec->num_rows()>0)
        {
			$this->references = array();
            return $rec->row();
        }

        return FALSE;
    }

	function get_like($field,$value)
	{
		$this->db->like($field,$value);
		
		if(count($this->references)>0)
		{
			foreach($this->references as $ref)
			{
				$table_name = $ref[0];
				$join = $ref[0].".".$ref[1]."=".$this->table_name.".".$ref[2];
				$this->db->join($table_name,$join,$ref[3]);
			}
		}
		
		$rec = $this->db->get($this->table_name); 
		
        if($rec->num_rows()>0)
        {
            return $rec->result();
        }		
	}
	
    /**
     *
     * @param Object $data
     * @param int $id
     */
    function update($data,$id=false)
    {
    	if($id!=false)
    	{
	        $where = array("$this->field_id"=>$id);
	        $this->db->where($where);
    	}
    	
        $result = $this->db->update($this->table_name,$data);
		return $result;
    }
	
	function get_count($filter=null)
	{
		$this->db->select("count(*) as 'c'")
				 ->from($this->table_name);
				 
		if($filter!=null){
			$this->db->where($filter);
		}		 
		$rec = $this->db->get();
		if($rec)
		{
			$row = $rec->row();
			return $row->c;
		}
		else
		{
			return FALSE;
		}
	}
	
	function leading_zero($jumlah,$number)
	{
		$panjang = strlen($number);
		if($jumlah>$panjang){
			$sisa = $jumlah - $panjang;
			$hasil = str_repeat("0",$sisa) . $number;
			return $hasil;
		}
		return $number;
	}
	
	function get_paged($limit, $offset,$filter=null,$use_ref=true)
	{
		$c = $this->get_count();
		
		$this->db->select("*");
		$this->db->from($this->table_name);
		
		if($use_ref)
		{
			if(count($this->references)>0)
			{
				foreach($this->references as $ref)
				{
					$table_name = $ref[0];
					$join = $ref[0].".".$ref[1]."=".$this->table_name.".".$ref[2];
					$this->db->join($table_name,$join,$ref[3]);
				}
			}
		}

		if($this->default_order==null)
		{
			if($this->field_title)$this->db->order_by($this->field_title);
		}
		else
		{
			foreach($this->default_order as $key => $value)
			{
				$this->db->order_by($key,$value);
			}
		}
		
		if($filter!=null)
		{
			$this->db->where($filter);	
		}
		
		if($limit>$c)
		{
			$this->db->limit($limit);	
			$query = $this->db->get();
		}
		else
		{
			$this->db->limit($limit, $offset);
			$query = $this->db->get();
		}
		
		if($query)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}	
	
}
?>
