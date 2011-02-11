<?php
class Common extends Controller {
	
	function __construct()
	{
		parent::Controller();	
		$this->load->library("session");
	}
	
	function _set_view_dir($versi=null)
	{
		if($versi==null)
		{
			//check in session
		}
		else
		{
			switch($versi)
			{
				case "m":
					$this->session->set_userdata('view_dir', 'default');
				break;

				case "full":
					$this->session->set_userdata('view_dir', 'desktop');
				break;
				
				default:
					$this->session->set_userdata('view_dir', 'default');
				break;
				
			}	
		}
	}
	
	/**
	* JSON Support
	*/
	private function _built_json($data)
	{
		$this->output->set_header("Cache-Control: no-cache");
		$this->output->set_header("Expires: -1");
		$this->output->set_header("Content-type: application/json");
		$this->output->set_output($data);
	}
	
	private function _built_xml($xml)
	{
		$this->output->set_header("Cache-Control: no-cache");
		$this->output->set_header("Expires: -1");
		$this->output->set_header("Content-type: text/xml");

		$xmlContent = "<?xml version=\"1.0\" ?>\n";
		$xmlContent .= str_replace("><", ">\n<", $xml);
		$this->output->set_output($xmlContent);
	}
	
	/**
	* view dispatcher
	*/
	function _load_view($view,$data)
	{
		$this->load->view($this->session->userdata('view_dir')."/$view",$data);
	}
	
	function redirect()
	{
		redirect("main/index/0",null);
	}
}
?>