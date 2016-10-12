<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class news extends Controller {
	var $mod = "news";
	function news()
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
		$this->pre_message = "";
		// rewrite  route
		$this->default_param_uri =  (int)$this->config->item('default_param_uri');
		
		// load necessary libraries
		$this->load->helper(array('file', 'showIMG', 'show_vote'));
		$this->load->library(array('captcha_lib'));
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function index()
	{// 
		$today = time();
		$fromtime = $today-7*86400;
		
		$total_max_view_count_news = $this->config->item('total_max_view_count_news_home');
		$rs_max_view_count_news = $this->mmod->select_max_view_count_news_home($fromtime, $today, $total_max_view_count_news);
		$data['total_max_view_count_news'] = $total_max_view_count_news;
		$data['rs_max_view_count_news'] = $rs_max_view_count_news;
		
		$data['heading'] 	= $data['description'] = 'Lược báo - Chọn tin nhanh - Cập nhật sớm';
		$data['meta_keyword'] = 'lược báo,tin tức';
		$this->view_page = $this->view_dir.'index';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function tintuc()//11-8-2010
	{
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		if(!empty($uri3))
		{
			$id_text = $this->uri->segment(4-$this->default_param_uri);
			$id_cattext = $this->uri->segment(3-$this->default_param_uri);
			$find = array("'","\\","-","_","&quot;","&Prime;","&prime;","&ldquo;","&rdquo;","&lsquo;","&rsquo;");
			$replace = array("");
			if($id_text){ 
				$data['db']	= $this->mmod->news_detail($id_text);
				$this->db->query("UPDATE news SET news_viewcount=(news_viewcount+1) WHERE id_text='$id_text'");
				if(is_object($data['db']) && $data['db']->num_rows()>0){
					$meta_keyword = stripslashes($data['db']->row()->news_title);
					$arr = explode(" ",$meta_keyword);
					
					$n = count($arr);
					$str ='';
					$tags ='';
					for($i=0; $i<$n; $i++){
						if($i%2 !=0)	 $str .= str_replace($find,$replace,$arr[$i]).",";
						else $str .=str_replace($find,$replace,$arr[$i])." ";
					}
					$data['meta_keyword'] = substr($str,0,-1);
					$arr_tag = explode(",",$data['meta_keyword']);
					$count_tags = count($arr_tag);
					for($j=0; $j<$count_tags; $j++){
						 $tags .=" OR news_title LIKE '%".str_replace($find,$replace,$arr_tag[$j])."%' ";
					}
					$key_tags =  substr($tags,3);
					$data['link_tags'] = $this->mmod->link_tags($key_tags,$id_text,$id_cattext);
					$data['heading'] = "Lược báo | ".$meta_keyword ;
					$data['description'] = $meta_keyword;
				}else $data['heading'] = "Lược báo ";
				
				$cat_info = $this->mmod->get_cat_info($id_cattext);
				$data['name_cat'] = $cat_info ? $cat_info->nwc_name: '';
				$id_nwc = $cat_info ? $cat_info->id_nwc: 0;
				$ar_id_cat = array($id_nwc);
				$data['pid_name_cat'] = $this->mmod->get_pid_name_cat($id_nwc);
				$data['str_name_cat'] = $data['pid_name_cat'] ? $data['pid_name_cat'].' > '.$data['name_cat'] : $data['name_cat'];
			}
			if(!empty($_POST['btn_nhanxet'])) $this->comment();
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
			$this->session->unset_userdata('ss_keyword');
			$ss_message = $this->session->flashdata('message');
			
			$data['msg'] 	= $this->pre_message.$ss_message;
			$data['captcha'] = $this->captcha_lib->show();
			$this->view_page = $this->view_dir.'detail';
			$this->load->vars($data);
			$this->load->view($this->view_container);
		}
		else
		{
			$id_cat = $this->uri->segment(3-$this->default_param_uri);
			$today = time();
			$fromtime = $today - 7 * 86400;
			//
			$cat_info = $this->mmod->get_cat_info($id_cat);
			$data['name_cat'] = $cat_info ? $cat_info->nwc_name: '';
			$id_nwc = $cat_info ? $cat_info->id_nwc: 0;
			$ar_id_cat = array($id_nwc);
			
			$data['pid_name_cat'] = $this->mmod->get_pid_name_cat($id_nwc);
			$data['str_name_cat'] = $data['pid_name_cat'] ? $data['pid_name_cat'].' > '.$data['name_cat'] : $data['name_cat'];
			
			$sub_cat = $this->mmod->select_sub_cat($id_nwc);
			if($sub_cat)
			{
				foreach($sub_cat->result() as $row)
				{
					$id_nwc_sub = $row->id_nwc;
					if($id_nwc_sub) array_push($ar_id_cat, $id_nwc_sub);
				}
			}
			#print_r($ar_id_cat);
			// max view
			$total_max_view_count_news = $this->config->item('total_max_view_count_news');
			$rs_max_view_count_news = $this->mmod->select_max_view_count_news($ar_id_cat, $fromtime, $today, $total_max_view_count_news);
			$data['total_max_view_count_news'] = $total_max_view_count_news;
			$data['rs_max_view_count_news'] = $rs_max_view_count_news;
			/*****************************/
			$total_cat_news = $this->config->item('total_cat_news');
			$total_random_news = $this->config->item('total_random_news');
			$total_hot_news = $this->config->item('total_hot_news');
			$relate_cat = $this->config->item('relate_cat');
			//main cat
			$rs_cat_news = $this->mmod->select_news_cat($ar_id_cat, $total_cat_news);
			$nums = $rs_cat_news ? $rs_cat_news->num_rows() : 0;
			$data['total_cat_news'] = $nums;
			$data['rs_cat_news'] = $rs_cat_news;
			// other
			$rs_other_cat_news = $this->mmod->select_other_cat($relate_cat[$id_cat], $total_hot_news);
			$nums_other = $rs_other_cat_news ? $rs_other_cat_news->num_rows() : 0;
			$data['total_other_cat_news'] = $nums_other;
			$data['rs_other_cat_news'] = $rs_other_cat_news;
			// random
			$rs_random_news_other_cat = $this->mmod->select_random_news_other_cat($id_cat, 100);
			$nums_random = $rs_random_news_other_cat ? $rs_random_news_other_cat->num_rows() : 0;
			$range = range(0,$nums_random-1);
			shuffle($range);//random vi tri
			$data['num_random_news'] = $nums_random;
			$data['total_random_news'] = $total_random_news;
			$data['range'] = $range;
			$data['rs_random_news_other_cat'] = $rs_random_news_other_cat;
			//
			
			$data['meta_keyword'] = $data['name_cat'];
			$data['heading'] = "Lược báo | ".$data['name_cat'] ;
			$data['description'] = $data['name_cat'];
			$this->view_page = $this->view_dir.'cat';
			$this->load->vars($data);
			$this->load->view($this->view_container);
		}
	}
	
}
?>