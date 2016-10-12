<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Del_db extends Controller {
	var $mod = "del_db";
	function Del_db()
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
		$this->del();		
	}
	
	function del()
	{
		echo "Chức năng này tạm khóa vì lý do an toàn dữ liệu";
		exit;
		$month = !empty($_POST['month']) ? (int)$this->input->post('month') : 1;
		$year = !empty($_POST['year']) ? (int)$this->input->post('year') : date("Y");
		
		$cfyears = $this->config->item('years');
		$aryears = array();
		$n = date("Y")-$cfyears;
		for($i=0;$i<=$n;$i++)
		{
			$key = $cfyears + $i;
			$values = $key;
			$aryears[$key] = $values;
		}
		
		if(! empty($_POST['btn_submit']))
		{
			$from = mktime(0, 0, 0, $month, 1, $year);
			$to = mktime(23, 59, 59, $month+1, 0, $year);
			#echo date('d-m-Y', $from).' đến'.date('d-m-Y', $to);
			if($this->mmod->delete($from, $to))
			{
				$this->pre_message = "Đã xóa dữ liệu tháng $month năm $year. (".$this->db->affected_rows()." records)";
			}
			else
			{
				$this->pre_message = "Lỗi: Không có dữ liệu!";
			}
		}
		
		$data['cfmonths'] = $this->config->item('months');
		$data['aryears'] = $aryears;
		$data['month'] = $month;
		$data['year'] = $year;
		$data['message']  = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = 'deleted data';
		$data['page_title']  = 'deleted data';
		$this->content = $this->load->view($this->view_dir.'list', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}

}
