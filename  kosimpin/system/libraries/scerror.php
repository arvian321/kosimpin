<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Error Model
 *
 *
 * @package		library
 * @author		Ahmad Satiri
 * @since		Version 1.0
 * @filesource
 *
 * 
 * How to use this model
 * 
 * 1. Load in your Model/Controller
 *    $this->load->library("scerror");
	  $this->error = new ScError(); 
 *
 * 2. Define your last error 
 *   
 *    $this->error->set_error(Error::$ERROR_FAILED);
 *
 *    or use number
 *
 *    $this->error->set_error(13);
 *
 *
 * 3. In your controller then you can check.
 *
 *    $error = $this->[model]->error->get_last_error();
 *
 *
 * If you want to extends Error Messages simply add your key and definition to Error Model 
 * 
 *		$result = @$this->error->add_error_definition(201,"My Error");
 *		if($result){
 *			echo "Add Error Success";
 *		}else{
			//should be error 200 - Error Definition Exist 
 *			echo $this->error->get_last_error_message();
 *		}
 */
class scerror
{
	static $REQUEST_OK = 1;
	static $ERROR_UNKNOWN = 11;
	static $ERROR_BAD_REQUEST = 12;	
	static $ERROR_FAILED = 13;
	static $ERROR_SQL_FAILED = 100;
	static $ERROR_DEFINITION_EXISTS = 200;
	
	public $error_codes;
	
	function scerror() 
	{
		$this->error_codes = array();
		$this->set_error_messages();
	}
	
	protected function set_error_messages()
	{
		$this->last_error = "";
		
		$this->add_error_definition(0,"Success");
		$this->add_error_definition(self::$ERROR_FAILED,"General SQL error, Query Failed");
		$this->add_error_definition(self::$ERROR_BAD_REQUEST,"Bad request");	
		$this->add_error_definition(self::$ERROR_SQL_FAILED,"SQL Failed");
		$this->add_error_definition(self::$ERROR_DEFINITION_EXISTS,"Error Definition Exist");
	}
	
	public function def_exists($key)
	{
		$result = array_key_exists($key, $this->error_codes);
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_all_definition()
	{
		return $this->error_codes;
	}
	
	public function add_error_definition($key,$message)
	{
		if ($this->def_exists($key))
		{
			$this->set_error(self::$ERROR_DEFINITION_EXISTS);
			return FALSE;
		}
		else
		{
			$this->error_codes[$key]=$message;
			return TRUE;
		}
	}
	
	public function set_error($err)
	{
		$this->last_error=$err;
	}
	
	public  function get_last_error()
	{
		return $this->last_error;
	}
	
	public function get_last_error_message()
	{
		if(strlen($this->get_last_error())>0 && $this->get_last_error()!="0"){
			return $this->get_error_message($this->get_last_error());
		}else{
			return "NO ERROR";
		}
	}
	
	function get_error_message($error_codes)
	{
		if(array_key_exists($error_codes,$this->error_codes))
		{
			return $this->error_codes[$error_codes];
		}
		else
		{
			return "General Error";
		}
	}
	
}
/* End of file model.php */ 
/* Location: ./scm/models/error.php */ 