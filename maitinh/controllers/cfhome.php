<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class cfhome extends Controller {
	var $mod = "cfhome";
	function cfhome()
	{		
		parent::Controller();
		$this->config->load('config_blocks');		
		$this->view_dir =  $this->mod.'/';
		$this->view_page =  $this->view_dir.'add';
		$this->view_container = 'adm_container';
		$this->resource_dir = $this->config->item('resource_dir');
		$this->temp_dir = $this->config->item('temp_dir');
		$this->pre_message = "";
		$this->load->helper(array('text', 'file', 'html','fix_quote','form', 'url'));
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
		$this->load->library('form_validation');
		$this->load->model($this->mod.'_model','pmod');
	}
	function index()
	{
		$this->load->helper('load_db_config');
		$data['blocks_default'] = $this->pmod->blocks_default();
		$data['h_1'] = $this->pmod->block_config('h_1');
		$data['h_2'] = $this->pmod->block_config('h_2');
		$data['h_3'] = $this->pmod->block_config('h_3');
		$data['h_4'] = $this->pmod->block_config('h_4');
		$data['h_5'] = $this->pmod->block_config('h_5');
		$data['h_6'] = $this->pmod->block_config('h_6');
		if(!empty($_POST['btn']) && !empty($_POST['hotnews'])){ 
			$value = $_POST['hotnews'];
			$this->update_or_insert('hotnews', $value);
			 $this->pre_message .= 'Lưu bản tin thành công';
		}
		/*****************************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'cfhome';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	
	function save_cfhome()
	{
		$h_1 = $this->input->post('h1');
		$h_2 = $this->input->post('h2');
		$h_3 = $this->input->post('h3');
		$h_4 = $this->input->post('h4');
		$h_5 = $this->input->post('h5');
		$h_6 = $this->input->post('h6');
		
		$h_1 = $this->input->xss_clean($h_1);
		$h_2 = $this->input->xss_clean($h_2);
		$h_3 = $this->input->xss_clean($h_3);
		$h_4 = $this->input->xss_clean($h_4);
		$h_5 = $this->input->xss_clean($h_5);
		$h_6 = $this->input->xss_clean($h_6);

		$this->pmod->delete_blocks('h_1');
		if(!empty($h_1)){
			$exp = explode(',',$h_1);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_1','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('h_2');
		if(!empty($h_2)){
			$exp = explode(',',$h_2);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_2','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('h_3');
		if(!empty($h_3)){
			$exp = explode(',',$h_3);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_3','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('h_4');
		if(!empty($h_4)){
			$exp = explode(',',$h_4);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_4','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('h_5');
		if(!empty($h_5)){
			$exp = explode(',',$h_5);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_5','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('h_6');
		if(!empty($h_6)){
			$exp = explode(',',$h_6);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','h_6','".$idx."')");
				} 
			}
		}
		
	}
	
	function cfdetail()
	{
		$data['blocks_default'] = $this->pmod->blocks_default_detail();
		$data['d_1'] = $this->pmod->block_config('d_1');
		$data['d_2'] = $this->pmod->block_config('d_2');
		$data['d_3'] = $this->pmod->block_config('d_3');
		/*****************************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'cfdetail';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function save_cfdetail()
	{
		$d_1 = $this->input->post('d1');
		$d_2 = $this->input->post('d2');
		$d_3 = $this->input->post('d3');
		
		$d_1 = $this->input->xss_clean($d_1);
		$d_2 = $this->input->xss_clean($d_2);
		$d_3 = $this->input->xss_clean($d_3);
	
		$this->pmod->delete_blocks('d_1');
		if(!empty($d_1)){
			$exp = explode(',',$d_1);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','d_1','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('d_2');
		if(!empty($d_2)){
			$exp = explode(',',$d_2);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','d_2','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('d_3');
		if(!empty($d_3)){
			$exp = explode(',',$d_3);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','d_3','".$idx."')");
				} 
			}
		}
	}
	
	function cfcat()
	{
		$this->load->helper('load_db_config');
		$data['blocks_default'] = $this->pmod->blocks_default_cat();
		$data['c_1'] = $this->pmod->block_config('c_1');
		$data['c_2'] = $this->pmod->block_config('c_2');
		$data['c_3'] = $this->pmod->block_config('c_3');
		
		/*****************************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'cfcat';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function save_cfcat()
	{
		$c_1 = $this->input->post('c1');
		$c_2 = $this->input->post('c2');
		$c_3 = $this->input->post('c3');
		
		
		$c_1 = $this->input->xss_clean($c_1);
		$c_2 = $this->input->xss_clean($c_2);
		$c_3 = $this->input->xss_clean($c_3);
		

		$this->pmod->delete_blocks('c_1');
		if(!empty($c_1)){
			$exp = explode(',',$c_1);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','c_1','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('c_2');
		if(!empty($c_2)){
			$exp = explode(',',$c_2);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','c_2','".$idx."')");
				} 
			}
		}
		
		$this->pmod->delete_blocks('c_3');
		if(!empty($c_3)){
			$exp = explode(',',$c_3);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$func_name =$exp[$idx];
				if($func_name != ''){
					$sql = $this->db->query("INSERT INTO block_pos(id,blocks_id,id_column,position) 
							VALUE('','".$func_name."','c_3','".$idx."')");
				} 
			}
		}
	}
	/***********/
	function update_or_insert($name, $value)
	{// update or insert into options table
		$num_row = $this->db->query("SELECT * FROM site_options WHERE option_name = '$name' LIMIT 1")->num_rows();
		$vl['option_name'] = $name;
		$vl['option_value'] = $value;
		if($num_row) $this->db->update("site_options", $vl,array('option_name'=>$name));
		else $this->db->query("INSERT INTO site_options VALUES ('','$name', '$value')");
	}
	
}
?>