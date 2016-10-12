<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class printpage extends Controller {
	var $mod = "printpage";
	function printpage()
	{
		parent::Controller();	
		//
		$this->view_dir = $this->mod.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'index';
		// select page layout
		$this->view_container = 'container';
		// init feedback for user's actions
		$this->default_param_uri =  (int)$this->config->item('default_param_uri');
		$this->pre_message = "";
		// load necessary libraries
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function index()//6-8-2010
	{
		$id_text = $this->uri->segment(4-$this->default_param_uri);
		if($id_text){ 
			$data['db']	= $this->mmod->news_detail($id_text);
		}
		/*****************************/
		$data['heading'] = $data['description'] = "Lược báo - Chọn tin nhanh - Cập nhật sớm";
		$this->view_page = $this->view_dir.'printpage';
		$this->load->vars($data);
		$this->load->view($this->view_page);
	}
}

?>