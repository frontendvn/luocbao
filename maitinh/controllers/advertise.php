<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class advertise extends Controller {
	var $mod = "advertise";
	function advertise()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		//resource directory
		$this->resource_dir = $this->config->item('resource_dir');
		//template directory
		$this->temp_dir = $this->config->item('temp_dir');
		// init feedback for user's actions
		$this->pre_message = "";
		// load necessary libraries
		$this->load->library('form_validation');
		$this->load->helper('text');

		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->member_model->get_userid($this->identity);
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
		$this->load->model($this->mod.'_model','pmod');
	}
	// default page
	function index()
	{
		$this->add();
	}
	function add()	
	{
		$values = array();
		$rs = $this->pmod->show_advertise();
		$nums = $rs?$rs->num_rows():1;
		if($nums){
			$data['nums'] = $nums;
			$data['rs']  = $rs;
		}
		if(!empty($_POST['save']))
		{ 
			
			$n = sizeof($_POST['adv_code']); 
			$values = array();
			$adv_code = $_POST['adv_code'];
			$adv_content = $_POST['adv_content'];
			$return = FALSE;
			for($i=0;$i<$n;$i++)
			{
				if(!empty($adv_code[$i]) && !empty($adv_content[$i]))
				{
					$values['adv_code'] 	= $adv_code[$i];
					$values['adv_content'] 	= $adv_content[$i];
					$values['adv_create'] 	= time();
					$check_adv_code = $this->pmod->check_adv_code($values['adv_code']);
					if(!$check_adv_code && $this->pmod->insert($values)) $return = TRUE; 
				}
			}
			if($return) $this->pre_message .= "Thành công";
			else $this->pre_message .= "Lỗi";
			reload($this->mod,0);
		}

		
		/***********************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function AJ_add_page()
	{
			$nums 	= $this->input->post('nums');
			$nums 	= $this->input->xss_clean($nums);
			$data['nums'] 	= (int)$nums;
			$this->load->vars($data);
			$this->load->view($this->view_dir.'AJ_add_page', $data);
	}
	function edit()
	{
		$adv_id = intval($this->uri->segment(3))?intval($this->uri->segment(3)):$_POST['adv_id'];
		if(!empty($_POST['save']))
		{ 
			$this->form_validation->set_rules('adv_content', "Nội dung","trim|required");
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				$values['adv_id'] 		= $adv_id;
				//$values['adv_code'] 	= $_POST['adv_code'];
				$values['adv_content'] 	= $this->input->post('adv_content');
				$values['adv_create'] 	= time();
				if($this->pmod->update($values))  $this->pre_message .= "Thành công";
				else $this->pre_message .= "Lỗi";
				reload($this->mod,0);
			}
		}
		$show_advertise = $this->pmod->show_advertise($adv_id);
		if(is_object($show_advertise) && $show_advertise->num_rows()>0)
		{
			$row = $show_advertise->row();
			$data['adv_id'] = $row->adv_id;
			$data['adv_code'] = $row->adv_code;
			$data['adv_content'] = $row->adv_content;
		}
		
		/***********************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function dels()
	{
		$adv_id = intval($this->uri->segment(3));
		if($adv_id)
		{
				$this->db->query("DELETE FROM advertise  WHERE adv_id='".$adv_id."'");
				redirect($this->mod);
		}
	}
}
?>