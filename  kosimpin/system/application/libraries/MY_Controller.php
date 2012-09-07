<?php
class MY_Controller extends Controller {
	
	var $jsonlist = array();
	var $format_date = "";
	var $excel_columns = array();
	
	function __construct()
	{
		parent::Controller();	
		$this->load->helper("form");
		$this->load->helper("html");
		$this->load->helper("formatnumber");
		$this->load->helper("hapus");
		$this->load->helper("terbilang");
		$this->load->library("parser");
		$this->format_date = $this->config->item("format_date");
		
		
		//router
		$this->dir = 	$this->router->fetch_directory();
		$this->class  = $this->router->fetch_class();
		$this->method = $this->router->fetch_method();		
		$this->path = $this->dir.$this->class."/".$this->method;


        //view dir
        $this->view_folder = "";

		//excel column
		$this->excel_columns = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
			                "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AY","AZ",
							"BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BY","BZ",
							"CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CY","CZ"
							);	
		
	}
	
	function is_admin_session($redirect_to)
	{
		if($this->session->userdata("role")!=1)
		{
			redirect("$redirect_to",null);
		}
	}	
	
	function has_access($app_id=null,$role_id=null,$action=false)
	{
		//exclude system page
		$exclude = array("noentry","logout","login","home");		
		if($this->session->userdata("username")!="")
		{
	
			if($app_id==null)
			{
				//jika app_id null maka coba cek berdasarkan path
				//
				$current_app = $this->class;
				$current_path = $this->path;
				if(strlen($this->dir)>0){
					$current_app = str_replace("/","",$this->dir);
				}
							
				//cari id dari current app
				$cp = $this->aplikasi->get_by_name($current_app);
				$admin = $this->is_admin();
			}
			else
			{
				$cp = $this->aplikasi->get_by_id($app_id);
				$br = $this->aplikasi_role->is_exists($role_id,$app_id);				
				$admin = $this->is_admin();
			}
			
			if($br || $admin)
			{
				return TRUE;
			}
			else
			{				
				if($action){
					$this->no_entry();
				}
				
				return false;
			}
		
		}
	}
	
	function write_log($sql)
	{
		$data = array("user"=>$this->session->userdata("username"),"log"=>$sql);
		$this->user_log->save($data);
	}
	

	function allowed_departemen()
	{
		$id_role = $this->session->userdata("id_role");
		$dept_role = false;
		if($id_role==1)
		{	
			$dept_role = true;
		}
		else
		{
			$dept_role = $this->role_departemen->get_in_list($id_role);
		}
		
		return $dept_role;
	}
	
	function allowed($id_departemen,$view,$data)
	{
		$allowed = $this->allowed_departemen();
		
		if(is_array($allowed))
		{
			if(in_array($id_departemen,$allowed))
			{
				$this->load->view($view,$data);
			}
			else
			{
				$this->no_entry();
			}
		}
		else
		{
			$this->load->view($view,$data);
		}		
	}
	
	function is_admin()
	{
		if($this->session->userdata("username")=='admin' || $this->session->userdata("id_role")==1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function no_entry()
	{
		redirect("main/noentry");
	}
	
	function has_write_access()
	{
		if($this->session->userdata("has_write_access")!="Y")
		redirect("main/noentry");
	}
	
	function read_post($var_name)
	{
		return strip_tags($this->input->post($var_name));
	}

    function set_view_folder($folder)
    {
        $this->view_folder = $folder;
    }

    function load_view($view,$data=null)
    {
        $this->load->view($this->view_folder."/".$view,$data);
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
	function _built_json($data)
	{
		$this->output->set_header("Cache-Control: no-cache");
		$this->output->set_header("Expires: -1");
		$this->output->set_header("Content-type: application/json");
		$this->output->set_output($data);
	}
	
	function fterbilang()
	{
		$angka = $this->input->post("angka");
		$terbilang = terbilang($angka);
		$data["terbilang"]= $terbilang;
		$this->_built_json(json_encode($data));
	}
	
	function _built_xml($xml)
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
	
	function create_excel()
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("satiri.net")
									 ->setLastModifiedBy("satiri.net")
									 ->setTitle("Laporan Transaksi Harian")
									 ->setSubject("harian")
									 ->setDescription("Laporan Harian")
									 ->setKeywords("Laporan,Transaksi,Harian")
									 ->setCategory("Laporan,Transaksi,Harian");
		return $objPHPExcel;
	}
	
	function __write_excel_header($filename="data",$the_date=null,$use_date=true)
	{
		if($the_date==null){
			$the_date = date("Y-m-d");
		}
		
		header('Content-Type: application/vnd.ms-excel');
		if($the_date=="")
		{
			header("Content-Disposition: attachment;filename=\"$filename-".date("dmY-His").".xls\"");
		}
		else
		{
			if($use_date){
				header("Content-Disposition: attachment;filename=\"$filename-".date("dmY-His",strtotime($the_date)).".xls\"");					
			}else{
				header("Content-Disposition: attachment;filename=\"$filename-".$the_date.".xls\"");					
			}
		}
		header('Cache-Control: max-age=0');

	}

	function export()
	{
		$filter = $this->session->flashdata('filter');
		
		if(array_key_exists("table_name",$this->jsonlist))
		{
			if(isset($this->jsonlist["model_folder"]) && strlen($this->jsonlist["model_folder"])>0)
			{
				if(strlen($this->jsonlist["model_name"])>0)
				{
					@$this->load->model($this->jsonlist["model_folder"]."/".$this->jsonlist["model_name"],"mdl");
				}
				else
				{
					@$this->load->model($this->jsonlist["model_folder"]."/".$this->jsonlist["table_name"],"mdl");
				}
			}
			else
			{
				if(isset($this->jsonlist["model_name"]) && strlen($this->jsonlist["model_name"])>0)
				{
					@$this->load->model($this->jsonlist["model_name"],"mdl");
				}
				else
				{
					@$this->load->model($this->jsonlist["table_name"],"mdl");
				}
			}
			
			if($this->mdl)
			{
				
				if(isset($this->jsonlist['order_by']) && $filter!=false){
					$rec = $this->mdl->get_all($this->jsonlist['order_by'],false,$filter);				
				}
				else if($filter){
					$rec = $this->mdl->get_all(null,false,$filter);
				}
				else
				{
					$rec = $this->mdl->get_all();
				}
				
				if($rec)
				{
					$this->rec_to_excel($this->jsonlist["table_name"],$rec);
				}
			}
		}
	}

	function rec_to_excel($title,$rec=null,$download=true)
	{
		if($rec!=null && $rec!=false)
		{
			$first = (array)$rec[0];
			$keys = array_keys($first);
			$column = $this->excel_columns;
			$excel = $this->create_excel();
			$sheet = $excel->setActiveSheetIndex(0);
			
			//add header
			$jkey = count($keys);
			for($x=0;$x<$jkey;$x++)
			{
				$sheet->setCellValue($column[$x]."1",$keys[$x]);
			}
			
			$cr=2;
			foreach($rec as $row)
			{
				$row = (array)$row;
				for($x=0;$x<$jkey;$x++)
				{
					$sheet->setCellValue($column[$x].$cr,$row[$keys[$x]]);
				}				
				$cr++;
			}
			
			$this->__write_excel_header($title,date("d-m-Y"));
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			$objWriter->save('php://output'); 			
			
		}
	}
	
	/**
	* get by id yang hasilnya dikeluarkan berupa json
	*/
	function get_json()
	{
		$row = array();
		$id = $this->input->post('id');
		
		if(array_key_exists("table_name",$this->jsonlist))
		{
			$sql = "select * from ".$this->jsonlist['table_name']. " where ". $this->jsonlist['field_id']."=$id";
			
			$rec = $this->db->query($sql);
			if($rec->num_rows()>0)
			{
				$row = $rec->row();
			}
		}

		$this->_built_json(json_encode($row));	
	}
	
	/**
	* Format json atau html
	* untuk html akan menjadi select
	*/
	function get_jsonlist()
	{	
		if(array_key_exists("table_name",$this->jsonlist))
		{
		
			if($this->input->post('q'))
			{
				$q = $this->input->post('q');
				
				if($this->input->post("format")){
					$format = $this->input->post("format");
				}else{
					$format = "json";
				}
				
				$sql="select * from 
					  ". $this->jsonlist['table_name'] ." where 
					  ( ".$this->jsonlist['field_title']." like '%$q%'";
					  
					if(isset($this->defaultfilter)){
						foreach($this->defaultfilter as $key => $value)
						{
							$sql.=	" and $key = $value ";
						}
					}
					  
				$sql.=")";
							
				if(array_key_exists('fields',$this->jsonlist) && is_array($this->jsonlist['fields']))
				{
					foreach($this->jsonlist['fields'] as $field)
					{
						$sql.=	" or $field like '%$q' ";
					}
					
				}
				
				$sql.=" order by ".$this->jsonlist['field_title']."";

				$rec = $this->db->query($sql);
				$line = "";
				$hasil = "";
							
				if($rec->num_rows()>0)
				{
					
					$select  = "";
					$allrow = array();
					$c = 0;
					foreach($rec->result() as $row)
					{
						$row = (array) $row;
						$jsonlist = $this->jsonlist;
						$additional_field = array_key_exists("additional_field",$jsonlist)?"-".$row[$this->jsonlist['additional_field']]:"";
						$myrow = array ($row[$this->jsonlist['field_title']].$additional_field,$row[$this->jsonlist['field_id']]
										);					
						$allrow[$c] = $myrow;
						$select .="<option value='".$row[$this->jsonlist['field_id']]."'>".$row[$this->jsonlist['field_title']].$additional_field."</option>";
						$c++;
					}				
			
					$hasil = $allrow;	
					
					if($format=="json"){	
						$this->_built_json(json_encode($hasil));
					}else{
						$this->output->set_output($select);
					}
				}
				else
				{
					echo 0;
				}
			}
		}
		else
		{
			echo 0;
		}
		
	}
	
}
?>