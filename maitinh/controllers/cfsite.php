<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class cfsite extends Controller {
	var $mod = "cfsite";
	function cfsite()
	{		
		parent::Controller();
		$this->load->config('config_'.$this->mod);
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		// init feedback for user's actions
		$this->pre_message = "";
		$this->config_file = $this->config->item('config_file');
		// load necessary libraries
		$this->load->helper(array('file', 'html'));
		
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
	}
	function index()
	{
		$this->edit();
	}
	function edit()
	{
		$info = $this->config->item('power');
		$txt_msg = $this->config->item('txt_msg');
		$footer = $this->config->item('footer');
		$data['info'] = $info;
		$data['txt_msg'] = $txt_msg;
		$data['footer'] = $footer;
		if(!empty($_POST['btn_submit']))
		{
			$ard = array("'",'"',"\n",'\\');
			$art = array("\'",'\"',"",'');

			$val = $this->input->post('power');
			$msg = $this->input->post('txt_msg');
			$footer = $this->input->post('footer'); 
			
			$val = empty($val) ? 'FALSE' : 'TRUE';
			$txt_msg = empty($msg) ? '' : str_replace($ard, $art, $msg);
			$txt_footer = empty($footer) ? '' : str_replace($ard, $art, $footer);
			
			$strConfig = '<?php 	
/**
 * Power site.
 * Type boolean
 **/';
			$strConfig .= "\n\$config['power'] = $val;";
			$strConfig .= "\n\$config['txt_msg'] = '$txt_msg';";
			$strConfig .= "\n\$config['footer'] = '$txt_footer';";

			if (write_file($this->config_file, $strConfig))
			{
				 $this->pre_message =  "Success!";
			}
			else
			{
				 $this->pre_message =  "Error: cant not write file!";
			}
			//dang ky nhom thanh vien
			
			//
			$this->session->set_flashdata('message', '<span >'.$this->pre_message.'</span>');
			redirect($this->mod);
		}
		
		/***************************************/
		$data['heading'] = "Config website";
		$data['message'] = $this->pre_message;
		$this->load->vars($data);
		$this->view_page = $this->view_dir.'edit';
		$this->load->view($this->view_container);
	}
}
/* End of file cfpoint.php */
/* Location: ./ctrlpanel/controllers/cfpoint.php */