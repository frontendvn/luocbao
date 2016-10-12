<?php

class comment extends Controller {
var $mod = 'comment';
	function comment()
	{
		parent::Controller();	
		$this->config->load('config_'.$this->mod);
		$this->view_dir = $this->config->item('view_dir');
		$this->view_page =  $this->view_dir.'home';
		$this->view_container = 'adm_container';
		$this->resource_dir = $this->config->item('resource_dir');
		$this->load->helper('text');
		$this->load->model($this->mod.'_model','pmod');
		$this->pre_message = '';
		$this->load->library('form_validation');
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
	}
	
	function index()
	{
		$this->new_comment();
	}
	function lists()
	{ 
		$all_ = $this->pmod->show(1);
		$num_rows = is_object($all_)?$all_->num_rows():0;
		/***********************************/
		$functarget = 'lists';
		$item_perpage = $this->config->item('item_perpage');	
		$page = (int)$this->uri->segment(3);	
		if($num_rows){
			$data['show'] = $all_;
			$total_rows = $num_rows;
			$uri_segment= 3;
			//get config
			$config['per_page'] = $item_perpage;			
			$config['num_links'] = $this->config->item('num_links');
			$config['cur_tag_open'] = '<span style="font-size:13px; color:#666666;"> ';
			$config['cur_tag_close'] = '</span>';
			
			$config['uri_segment'] = $uri_segment;
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget;
			$config['total_rows'] = $total_rows;			
			// first item
			$page=empty($_POST['page']) ? (int)$this->uri->segment($config['uri_segment']) : (int)$_POST['page'];
			if($page==$total_rows)
				$page = $total_rows -$config['per_page'];
			if($page && $this->uri->segment(2) == $functarget)
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
			/*-------------------------------+
			|  OUT PUT HERE                  |
			+--------------------------------*/
			$data['first_item'] = $firstitem;
			$data['last_item'] = $lastitem;
			$data['total_item'] = $total_rows;			
			$data['pagi'] = $this->pagination->create_links();
			$data['page'] = $page;
		}
		/******************************/
		$data['message'] = $this->pre_message;
		$this->view_page = $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function dels()
	{
		$id = (int)$this->uri->segment(3);
		$page = (int)$this->uri->segment(4);
		if(!empty($id)){
			if($this->pmod->delete('comment','id',$id)) $this->pre_message .='Xoá thành công';
			else $this->pre_message .='Lỗi xoá dữ liệu';
		}
		redirect ($this->mod.'/new_comment/'.$page);
	}
	function cat_switch_state()//28-7-2010
	{
		$id = (int)$this->uri->segment(3);
		$page = (int)$this->uri->segment(4);
		if(is_numeric($id)){
			if($this->pmod->switch_state($id)) $this->pre_message .= 'Đã thực hiện';
		}
		redirect ($this->mod.'/new_comment/'.$page);
	}
	function new_comment()//28-7-2010
	{ 
		$all_ = $this->pmod->show(0);
		$num_rows = is_object($all_)?$all_->num_rows():0;
		/***********************************/
		$functarget = 'new_comment';
		$item_perpage = $this->config->item('item_perpage');	
		$page = (int)$this->uri->segment(3);	
		if($num_rows){
			$data['show'] = $all_;
			$total_rows = $num_rows;
			$uri_segment= 3;
			//get config
			$config['per_page'] = $item_perpage;			
			$config['num_links'] = $this->config->item('num_links');
			$config['cur_tag_open'] = '<span style="font-size:13px; color:#666666;"> ';
			$config['cur_tag_close'] = '</span>';
			
			$config['uri_segment'] = $uri_segment;
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget;
			$config['total_rows'] = $total_rows;			
			// first item
			$page=empty($_POST['page']) ? (int)$this->uri->segment($config['uri_segment']) : (int)$_POST['page'];
			if($page==$total_rows)
				$page = $total_rows -$config['per_page'];
			if($page && $this->uri->segment(2) == $functarget)
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
			/*-------------------------------+
			|  OUT PUT HERE                  |
			+--------------------------------*/
			$data['first_item'] = $firstitem;
			$data['last_item'] = $lastitem;
			$data['total_item'] = $total_rows;			
			$data['pagi'] = $this->pagination->create_links();
			$data['page'] = $page;
		}
		/******************************/
		$data['message'] = $this->pre_message;
		$this->view_page = $this->view_dir.'new_comment';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
}

?>