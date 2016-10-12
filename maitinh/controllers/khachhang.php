<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class khachhang extends Controller {
	var $mod = "khachhang";
	function khachhang ()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		$this->view_dir = $this->mod.'/';
		$this->view_page =  $this->view_dir.'add';
		$this->view_container = 'adm_container';
		$this->resource_dir = $this->config->item('resource_dir');
		$this->temp_dir = $this->config->item('temp_dir');
		$this->pre_message = "";
	    $this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
		$this->load->model($this->mod.'_model','pmod');
		$this->load->helper('showIMG');
	}
	// default page
	function index()
	{
		$this->lists();
	}

	function lists()
	{
		$show = $this->pmod->show();
		$functarget = 'lists';
		$num_rows = $show?$show->num_rows():0;
		//
		$data['num_rows'] = $num_rows;
		if($num_rows){
			$data['db'] = $show;
			$total_rows = $num_rows;
			$uri_segment= 3;
			$config['per_page'] = $this->config->item('item_perpage');			
			$config['num_links'] = $this->config->item('num_links');
			$config['cur_tag_open'] = '<span style="font-size:13px; color:#666666;"> ';
			$config['cur_tag_close'] = '</span>';
	
			$config['uri_segment'] = $uri_segment;
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget;
			$config['total_rows'] = $total_rows;			
			// first item
			$uri = (int)$this->uri->segment($config['uri_segment']);
			$page=empty($_POST['page']) ?$uri : (int)$_POST['page'];
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
			$config['cur_page']=$page;
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
		/***********************************/
		$data['message'] = $this->pre_message;	
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function add()	
	{
		$this->form_validation->set_rules('ten_kh',  "Tên kh","trim|required|max_length[60]|xss_clean");
		$this->form_validation->set_rules('diachi',  "Địa chỉ","trim|max_length[60]|xss_clean");
		$this->form_validation->set_rules('dienthoai',  "Điện thoại","trim|max_length[30]|xss_clean");
		$this->form_validation->set_rules('email',  "Email","trim|valid_email|max_length[60]|xss_clean");
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p >', '</p>');
			$this->pre_message .= validation_errors();
		}
		else
		{
			$values['ten_kh'] = $this->input->post('ten_kh');
			$values['diachi']   =  $this->input->post('diachi');
			$values['dienthoai'] = $this->input->post('dienthoai');
			$values['email']   =  $this->input->post('email');
			$values['times'] = time();
	
			if($this->pmod->insert($values))
				$this->pre_message .= "Thêm mới khách hàng thành công!";
			else $this->pre_message .= "Lỗi: Không thể cập nhật dữ liệu!";
		}	
		/***********************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function edit()
	{
		$id = isset($_POST['id'])?(int)$_POST['id'] : (int)$this->uri->segment(3);
		if(!empty($_POST['save']))
		{ 
			$this->form_validation->set_rules('ten_kh',  "Tên kh","trim|required|max_length[60]|xss_clean");
			$this->form_validation->set_rules('diachi',  "Địa chỉ","trim|max_length[60]|xss_clean");
			$this->form_validation->set_rules('dienthoai',  "Điện thoại","trim|max_length[30]|xss_clean");
			$this->form_validation->set_rules('email',  "Email","trim|valid_email|max_length[60]|xss_clean");
		
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p >', '</p>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				$values['id_kh'] = $id;
				$values['ten_kh'] = $this->input->post('ten_kh');
				$values['diachi']   =  $this->input->post('diachi');
				$values['dienthoai'] = $this->input->post('dienthoai');
				$values['email']   =  $this->input->post('email');
				
				if($this->pmod->update($values))
					$this->pre_message .= "Hiệu chỉnh thành công!";
				else $this->pre_message .= "Lỗi: không thể cập nhật dữ liệu!";
			}	
		}
		$show = $this->pmod->show($id);
		if($show->num_rows()>0)
		{
			$row = $show->row_array();
			$data['id'] = $row['id_kh'];
			$data['ten_kh'] = $row['ten_kh'];
			$data['diachi'] = $row['diachi'];
			$data['dienthoai'] = $row['dienthoai'];
			$data['email'] = $row['email'];
			$data['times'] = $row['times'];
		}else redirect($this->mod);
		
		/***********************/
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function del()
	{
		$id = (int)$this->uri->segment(3);
		if($id)	$this->pmod->delete($id);
		redirect($this->mod.'/lists/');
	}
	function dels()
	{
		if(!empty($_POST['btn_submit']) && !empty($_POST['ar_id']))
		{
			$wid = $this->input->post('ar_id');
			$n = sizeof($wid);
			for($i = 0; $i < $n; $i++) 
			{
				if($wid[$i])
				{
					if($this->pmod->delete($wid[$i]))
					{
						$this->pre_message = "Thành công!";
					}
					else
					{
						$this->pre_message = "Lỗi: cập nhật dữ liệu!";
					}
				}
			}
		}
		redirect($this->mod.'/lists/');
	}
}
?>