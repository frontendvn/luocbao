<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class preview extends Controller {
	var $mod = "preview";
	function preview()
	{
		parent::Controller();	
		$this->load->config('config_'.$this->mod);
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
		$this->load->helper(array('file', 'showIMG', 'show_vote'));
		$this->load->library(array('captcha_lib'));
	}
	
	function index()
	{
		$this->load->model('news_model', 'mmod');
		$id_text = $this->uri->segment(4-$this->default_param_uri);
		if($id_text){ 
			$data['db']	= $this->mmod->news_preview($id_text);
			$cat_info = $this->mmod->get_cat_info($id_cattext);
			$data['name_cat'] = $cat_info ? $cat_info->nwc_name: '';
			$id_nwc = $cat_info ? $cat_info->id_nwc: 0;
			$ar_id_cat = array($id_nwc);
			$data['pid_name_cat'] = $this->mmod->get_pid_name_cat($id_nwc);
			$data['str_name_cat'] = $data['pid_name_cat'] ? $data['pid_name_cat'].' > '.$data['name_cat'] : $data['name_cat'];
		}
		/**********************************/
		$data['show_comment'] = $this->mmod->show_comment($id_text);
		
		/**********************************/
		$today = time();
		$fromtime = $today - 7 * 86400;

		$total_max_view_count_news = $this->config->item('total_max_view_count_news');
		$rs_max_view_count_news = $this->mmod->select_max_view_count_news_home($fromtime, $today, $total_max_view_count_news);
		$data['total_max_view_count_news'] = $total_max_view_count_news;
		$data['rs_max_view_count_news'] = $rs_max_view_count_news;
		/*****************************/
		$data['heading'] = 'luocbao.com';
		$data['msg'] 	= $this->pre_message;
		$data['captcha'] = $this->captcha_lib->show();
		$this->view_page = $this->view_dir.'detail';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
}

?>