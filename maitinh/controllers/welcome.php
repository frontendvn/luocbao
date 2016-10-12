<?php
class Welcome extends Controller {
	var $mod = "welcome";
	function Welcome()
	{		
		parent::Controller();
		//$this->config->load('config_'.$this->mod);
		$this->view_dir = $this->mod.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'welcome';
		$this->view_container = 'adm_container';
		$this->pre_message = "";
		
	  	$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		//
		$this->profile = $this->cpanel_lib->query_main;
		// left menu
		$this->menu = array();
	}
	
	function index()
	{
		$this->load->library('online_users');
		//$data['menu'] = $this->menu;
		$data['page_title'] = "Welcome to Control Panel";
		$data['message'] = $this->pre_message;
		$this->view_page =  $this->view_dir.'index';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
}
?>