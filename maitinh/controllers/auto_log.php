<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auto_log extends Controller {
	var $mod = "auto_log";
	function Auto_log()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		// init feedback for user's actions
		$this->pre_message = "";
		/*-------------------------------+
		|  CPANEL LIB                    |
		|  use for manage			     |
		+--------------------------------*/
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// load necessary libraries
		$this->load->model($this->mod.'_model', 'mmod');
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
	}
	// default page
	function index()
	{
		$this->lists();		
	}
	
	function lists()
	{
		$status = $this->input->post('status');
		$time_ago = $this->input->post('time_ago');
		$time_ago = $time_ago ? $time_ago : 'A';
		
		$time = time();
		$today_first = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		switch($time_ago)
		{
			case '1': 
				$from = $time-60*60; 
				$to = $time;
			break;
			case '2': 
				$from = $time-2*60*60; 
				$to = $time;
			break;
			case '4': 
				$from = $time-4*60*60; 
				$to = $time;
			break;
			case 'T': 
				$from = $today_first;
				$to = $time;
			break;
			case 'Y': 
				$from = $today_first-24*60*60; 
				$to = $today_first;
			break;
			case '48': 
				$from = $time-2*24*60*60; 
				$to = $time;
			break;
			case 'W': 
				$from = $time-7*24*60*60; 
				$to = $time;
			break;
			case 'A': 
				$from = 0; 
				$to = 0;
			break;
			default: 
				$from = 0; 
				$to = 0;
		}
		
		$rs = $this->mmod->select_auto_log($status, $from, $to, 1000);
		$data['num_rows'] = $rs?$rs->num_rows():0;
		$data['db'] = $rs;
		$data['time_ago'] = $time_ago;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['message']  = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "view logs";
		$data['page_title']  = 'view logs';
		$this->content = $this->load->view($this->view_dir.'list', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}

	function empty_log($status='', $from=0, $to=0)
	{
		if(empty($status) and empty($from) and empty($to))
		{
			$this->mmod->empty_log();
		}
		else
		{
			$this->mmod->del_log($status, $from, $to);
		}
			
		redirect($this->mod);		
	}
}
