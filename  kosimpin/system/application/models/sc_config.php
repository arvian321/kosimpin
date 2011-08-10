<?php
/**
 * Configuration Model
 *
 *  Contoh Penggunaan
 * 	
 *  $this->load->model("sc_config");
 * 
 * @package		Model
 * @author		Ahmad Satiri
 * @since		Version 1.0
 * @filesource
 */
class Sc_config extends Base_flexmodel {
	
	private $config_name;
	private $config_item_names; //array of item name
	private $config_item_values;
	
	private $search_success=false;
	
	function Sc_config()
	{
		parent::Base_flexmodel();
		$this->table_name = "conf_settings";	
		$this->load->library("scerror");	
		
		$this->error = new Scerror();
		$this->__set_error_definition();
	}
	
	function __set_error_definition()
	{
		//station diary will use 5xx as it's error codes
		$this->error->add_error_definition(501,"Configuration Not Exists.Must Save First.");
		$this->error->add_error_definition(502,"Configuration Empty");
		$this->error->add_error_definition(503,"Item not Exists");
		$this->error->add_error_definition(504,"Item Already Exists");
	}
		
	/**
	 * 
	 * Initiate configuration
	 */
	function init($config_name)
	{
		$this->config_name = $config_name;
		if($this->is_exists($this->config_name))
		{
			//populate configurations
			$this->__restore_items();
		}
	}
	
	/**
	 * 
	 * Add configuration item to configuration
	 * @param $item_name
	 * @param $item_value
	 */
	function add_config_item($item_name,$item_value)
	{
		if($this->__item_exist($item_name)==FALSE)
		{
			$this->config_item_names[] = $item_name;
			$this->config_item_values[] = $item_value;
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * 
	 * Will try to search item by name. return TRUE if success.
	 * @param $item_name
	 */
	function __item_exist($item_name)
	{
		$item_location = $this->__search_config_item($item_name);
		if($this->search_success)
		{
			return TRUE;
		}
		
		$this->error->set_error(504);//item already exist
		return FALSE;
	}
	
	/**
	 * 
	 * This function will update configuration in database.
	 * @param $item_name
	 * @param $item_value
	 */
	function update_config_item($item_name,$item_value)
	{
		$item_location = $this->__search_config_item($item_name);
		if($this->search_success)
		{
			$this->config_item_values[$item_location] = $item_value;
			$this->search_success = false;
			return TRUE;
		}
		else
		{
			//new item
			$this->add_config_item($item_name, $item_value);
		}
	}
	
	/**
	 * 
	 * restore item from database to array
	 */
	function __restore_items()
	{
		$this->db->select("config_values")
				 ->from($this->table_name)
				 ->where("config_name",$this->config_name);
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
			$result = $rec->result();
			$lines = explode(chr(13),$result->config_values);
			foreach($lines as $line)
			{
				if(strlen($line)>1)
				{
					$config_x = explode("=", $line);					
					if(count($config_x)>=2)
					{
						$this->config_item_names[] = $config_x[0];
						$this->config_item_values[] = $config_x[1];
					}
				}
			}
			
			return TRUE;
		}
		else
		{
			$this->error->set_error(502);//empty
			return FALSE;
		}
	}
	
	/**
	 * 
	 * Get your item values
	 * @param $item_name
	 */
	function get_item_values($item_name)
	{
		$item_location = $this->__search_config_item($item_name);
		if($this->search_success)
		{
			return $this->config_item_values[$item_location];
		}
		
		$this->error->set_error(503);//empty
		return FALSE;
	}
	
	/**
	 * 
	 * Find location in array of item name
	 * @param $item_name
	 */
	function __search_config_item($item_name)
	{
		for($i=0;$i<count($this->config_item_names);$i++)
		{
			if(strtolower($this->config_item_names[$i])==strtolower($item_name))
			{
				$this->search_success=TRUE;
				return $i;
				exit;
			}	
		}
		
		$this->search_success=FALSE;
		$this->error->set_error(503);//empty
		return FALSE;
	}
	
	/**
	 * 
	 * Delete configuration item
	 * @param $item_name
	 */
	function delete_config_item($item_name)
	{
		$item_location = $this->__search_config_item($item_name);
		if($this->search_success)
		{
			unset($this->config_item_names[$item_location]);
			unset($this->config_item_values[$item_location]);
		}
		
		$this->error->set_error(503);//empty
		return FALSE;
	}
	
	/**
	 * 
	 * Updating configuration
	 */
	function update_config()
	{
		if($this->is_exists($this->config_name))
		{
			$config_string = $this->__parse_config();
	
			$data = array("config_values"=>$config_string);			         
			$where = array("config_name"=>$this->config_name);
			$result = $this->update($data, $where);
		}
		else
		{
			//must save first
			$this->save_config();
		}
	}
	
	/**
	 * 
	 * Internal function which transform configuration array to text.
	 */
	function __parse_config()
	{
		$config_string = "";
		for($i=0;$i<count($this->config_item_names);$i++)
		{
			$config = $this->config_item_names[$i] . "=" . $this->config_item_values[$i];
			$config_string .= $config . chr(13);
		}
		
		return $config_string;
	}
	
	/**
	 * 
	 * Save config to database.Parse config items to paired string
	 */
	function save_config()
	{
		if($this->is_exists($this->config_name))
		{
			$this->update_config();
		}
		else
		{
			$config_string = $this->__parse_config();			
			$data = array("config_name"=>$this->config_name,
			              "config_values"=>$config_string
			             );
			 
			$result = $this->insert($data);
		}
	}
	
	/**
	 * 
	 * Check if configuration exist
	 * @param $config_name
	 */
	function is_exists($config_name)
	{
		$this->db->select("config_name")
		        ->from($this->table_name)
		        ->where("config_name",$config_name)
		        ;
		        
		$rec = $this->db->get();
		if($rec->num_rows()>0)
		{
			return TRUE;
		}        
		
		$this->error->set_error(501);//empty
		return FALSE;
	}
	
	
	function delete_config($config_name)
	{
		$this->db->where(array('config_name' => $config_name));
		$this->db->delete($this->table_name); 
	}
	
	/**
	 * 
	 * Show all configuration in memory
	 */
	function show_all_config()
	{
		for($i=0;$i<count($this->config_item_names);$i++)
		{
			echo $this->config_item_names[$i]."=".$this->config_item_values[$i]."<BR>";
		}
	}
}
