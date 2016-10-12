<?php
class Usertype extends Controller {
	var $mod = "usertype";
	function usertype()
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
		// load necessary libraries
		$this->load->helper(array('text'));
		$this->load->model($this->mod.'_model', 'mmod');
		
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
	}
	// default page
	function index()
	{	
		$this->lists();
	}
	
	protected function lists()
	{
		$data['heading'] = "Manage ".$this->mod;
		$data['message'] = $this->pre_message;
		//Lay ham dang target
		$fn = 'add';
		$id = (int)$this->uri->segment(3);
		//
		$rs = $this->mmod->select();
		$num_rows = $rs?$rs->num_rows():0;
		//
		$data['num_rows'] = $num_rows;
		if($num_rows){
			$data['db'] = $rs;
			/*-------------------------------+
			|  CUSTOM INPUT HERE             |
			| get data, and get config       |
			+--------------------------------*/
			$total_rows = $num_rows;
			$uri_segment= 4;
			$functarget	= $fn;
			//get config
			$config['per_page'] = $this->config->item('item_perpage');			
			$config['num_links'] = $this->config->item('num_links');
			$config['cur_tag_open'] = '<span style="font-size:13px; color:#666666;"> ';
			$config['cur_tag_close'] = '</span>';
			/*-------------------------------+
			|  DON'T TYPE HERE               |
			+--------------------------------*/
			$config['uri_segment'] = $uri_segment;
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget.'/'.$id;
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
		$data['controller_title'] = $this->menu_title;
		$this->load->vars($data);
		$this->content = $this->load->view($this->view_dir.'list', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	// add a cdefault
	public function _add()
	{
		if(isset($_POST))
		{
			$this->form_validation->set_rules('name', 'Tên module', 'required|trim|xss_clean');
			$this->form_validation->set_rules('access_level', 'Cấp bậc', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim|xss_clean');
			
			if ($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			}
			else
			{
				$values['name'] 		= $this->input->post('name');
				$values['access_level']	= $this->input->post('access_level');
				$values['description']	= $this->input->post('description');
				if($this->mmod->insert($values))
					$this->pre_message = "Thành công!";
				else $this->pre_message = "Có lỗi";
			}
		}
		
		$data['message'] = $this->pre_message;
		$data['heading'] = "Manage ".$this->mod;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Thêm loại thành viên";
		$this->load->vars($data);
		$this->content = $this->load->view($this->view_dir.'add', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	public function _del()
	{// delete a cdefault
		$id = (int)$this->uri->segment(3);
		$page = (int)$this->uri->segment(4);
		if($id){
			if($this->mmod->delete($id)){
				$this->pre_message = "Thành công!";
				redirect($this->mod.'/add/'.$id.'/'.$page);
			}else $this->pre_message = "Lỗi cập nhật dữ liệu!";
		}
	}
	
	public function edit()
	{
		$id = empty($_POST['id']) ? (int)$this->uri->segment(3) : (int)$this->input->post('id');
		//page theo segment, post
		$page = empty($_POST['page']) ? (int)$this->uri->segment(4) : (int)$this->input->post('page');
		$load = array();
		
		if(!	empty($_POST))
		{ // posted data is existing
			
			$this->form_validation->set_rules('name', 'Tên', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			}
			else
			{
				$values['id']    		= $id;
				$values['name'] 		= $this->input->post('name');
				$values['description']  = $this->input->post('description');
				if($this->mmod->update($values))
				{
					$this->pre_message = "Thành công!";
				}
				else
				{
					$this->pre_message = "Lỗi: cập nhật dữ liệu.";
				}
			}
		}
		else
		{  
			$rs = $this->mmod->select($id);		
			if($rs)
			{
				$row = $rs->row(0);
				$load['description'] 	= $row->description;
				$load['name']  			= $row->name;
			}
			else
			{
				redirect($this->mod);
			}
		}
		$data['load'] = $load;
		$data['id'] = $id;
		$data['message'] = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Hiệu chỉnh loại thành viên";
		$this->load->vars($data);
		$this->content = $this->load->view($this->view_dir.'edit', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	public function _dels()
	{//
		$page = empty($_POST['page'])?"":(int)$this->input->post('page');
		$wid = empty($_POST['newid'])?"":$this->input->post('newid');
		if(!empty($_POST['btn_submit']) && !empty($_POST['newid']))
		{
			$n = sizeof($wid);
			for($i = 0; $i < $n; $i++) 
			{
				if($wid[$i])
				{
					if($this->mmod->delete($wid[$i]))
					{
						$this->pre_message = "Thành công!";
					}
					else
					{
						$this->pre_message = "Lỗi cập nhật dữ liệu!";
					}
				}
			}
		}
		redirect($this->mod);
	}
}
?>