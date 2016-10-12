<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class search extends Controller {
	var $mod = "search";
	function search()
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
		$this->load->library(array('captcha_lib','form_validation'));
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function index()
	{// 
		//tin doc nhieu nhat
		$today = time();
		$fromtime = $today - 7 * 86400;
		
		$this->load->model('news_model', 'nmod');
		$total_max_view_count_news = $this->config->item('total_max_view_count_news');
		$rs_max_view_count_news = $this->nmod->select_max_view_count_news_home($fromtime, $today, $total_max_view_count_news);
		$data['total_max_view_count_news'] = $total_max_view_count_news;
		$data['rs_max_view_count_news'] = $rs_max_view_count_news;
		/********************************************/
		//tin tieu diem
		$total_random_news = $this->config->item('total_random_news');
		$rs_random_news_other_cat = $this->nmod->select_random_news_other_cat("", 100);
		$nums_random = $rs_random_news_other_cat ? $rs_random_news_other_cat->num_rows() : 0;
		$range = range(0,$nums_random-1);
		shuffle($range);//random vi tri
		$data['num_random_news'] = $nums_random;
		$data['total_random_news'] = $total_random_news;
		$data['range'] = $range;
		$data['rs_random_news_other_cat'] = $rs_random_news_other_cat;
		/****************************************/
		
		$page = (int)$this->uri->segment(3-$this->default_param_uri);
		$item_perpage = $this->config->item('item_perpage');
		
		/******************************/
		$key_word = $this->db->escape_str($this->input->xss_clean(trim($this->input->post('keywords'),"'")));	
		$ss_search = $this->db->escape_str($this->input->xss_clean(trim($this->session->userdata('ss_keyword'),"'")));
		$data['key_word'] = empty($key_word)?$ss_search:$key_word;
		if (strlen($data['key_word'])>=10)
		{
			if(!empty($_POST['btn_search'])) 
			{// neu submit search
				$all_ = $this->mmod->show($key_word,$item_perpage,$page);
				$total = $this->mmod->total($key_word);
				$this->session->set_userdata('ss_keyword',$key_word); 
				// luu session khi phan trang
			}
			else
			{// kiem tra co session
				$session = $this->session->userdata('ss_keyword');
				if(!empty($session))
				{
					$all_ = $this->mmod->show($session,$item_perpage,$page);
					$total = $this->mmod->total($session);
				}else{
					$all_ = $this->mmod->show($key_word,$item_perpage,$page);
					$total = $this->mmod->total($key_word);
					$this->session->unset_userdata('ss_keyword');
				} 
			}
			$num_rows = $total;
			/***********************************/
			$functarget = 'search';
			if($num_rows){
				$data['db'] = $all_;
				$total_rows = $num_rows;
				$uri_segment= 3-$this->default_param_uri;
				//get config
				$config['per_page'] = $item_perpage;			
				$config['num_links'] = $this->config->item('num_links');
			
				$config['first_link'] = 'Đầu';
				$config['last_link'] = 'Cuối';
				$config['next_link'] = 'Sau';
				$config['prev_link'] = 'Trước';
				$config['cur_tag_open'] = ' <span class="page_cur">';
				$config['cur_tag_close'] = '</span>';
				
				$config['uri_segment'] = $uri_segment;
				$config['base_url'] = site_url().'/'.$this->mod;
				$config['total_rows'] = $total_rows;			
				// first item
				$page=empty($_POST['page']) ? (int)$this->uri->segment($config['uri_segment']) : (int)$_POST['page'];
				if($page==$total_rows)
					$page = $total_rows -$config['per_page'];
				if($page && $this->uri->segment(2-$this->default_param_uri) == $functarget)
					$firstitem = $page;//uu tien Post, sement
				else $firstitem = 0;			
				// last item
				$lastitem  = ($config['total_rows'] <= $config['per_page'])? $config['total_rows'] : 
				(($firstitem + $config['per_page'] > $config['total_rows'])? $config['total_rows'] : 
				($firstitem + $config['per_page']));
				//load paging
				$config['cur_page']=$page+1;
				$this->load->library('pagination');
				$this->pagination->initialize($config);
			
				$data['first_item'] = $firstitem;
				$data['last_item'] = $lastitem;
				$data['total_item'] = $total_rows;			
				$data['pagi'] = $this->pagination->create_links();
				$data['page'] = $page;
			}
			
		}else $this->pre_message .=" Từ khoá tìm kiếm phải trên 10 ký tự";
		/******************************/
		$data['heading'] = $data['description'] = "Lược báo - Chọn tin nhanh - Cập nhật sớm";
		$data['message'] = $this->pre_message;
		$this->view_page = $this->view_dir.'search';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	
	}
}

?>