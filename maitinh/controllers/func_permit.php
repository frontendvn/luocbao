<?php 
class Func_permit extends Controller {
	var $mod = "func_permit";
	function func_permit()
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
		$this->add();
	}
	
	function lists($cid=0, $id=0)
	{
		$data['heading'] = "Manage ".$this->mod;
		$data['message'] = $this->pre_message;
		//Lay ham dang target
		$fn = $this->uri->segment(2);
		//
		$rs = $this->mmod->select($cid);
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
			$uri_segment= 5;
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
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget.'/'.$cid.'/'.$id;
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
		$data['cid'] = $cid;

		return $data;	
	}
	// add a cdefault
	function add()
	{
		$fid = 0;
		if(!empty($_POST['btnsubmit']))
		{
			$this->form_validation->set_rules('id_class', 'Mã module', 'required|trim|xss_clean');
			$this->form_validation->set_rules('func_name', 'Tên chức năng', 'required|trim|xss_clean');
			$this->form_validation->set_rules('required_access', 'Quyền truy cập', 'required|trim|xss_clean');
			$this->form_validation->set_rules('note', 'Ghi chú', 'trim|xss_clean');
			
			if ($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			}
			else
			{
				$values['id_class'] 				= $this->input->post('id_class');
				$values['func_name'] 				= $this->input->post('func_name');
				$values['required_access']  = $this->input->post('required_access');
				$values['note']  						= $this->input->post('note');
				// test
				$test = $this->mmod->check_func_permit($values['id_class'], $values['func_name']);
				if(!	$test){
					if($this->mmod->insert($values))
						$this->pre_message = "Thành công!";
					else $this->pre_message = "Lỗi cập nhật dữ liệu.";
				}else $this->pre_message = "Chức năng này đã thiết lập rồi!";
			}
		}
		$cid = !empty($_POST)?$this->input->post('id_class'): (int)$this->uri->segment(3);
	
		$data['id_class'] = $this->mmod->create_select_box_class("id_class", $cid, 'submit', $fid);
		$data['groups'] = $this->mmod->create_select_box_all_groups("required_access", $this->input->post('required_access'));
		if(empty($cid))
			$cid = $fid;
	
		$data['heading'] = "Manage ".$this->mod;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Register Functions on Modules";
		$this->load->vars(array_merge($this->lists($cid),$data));
		$this->content = $this->load->view($this->view_dir.'add', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	function del()
	{// delete a cdefault
		$cid = (int)$this->uri->segment(3);
		$id = (int)$this->uri->segment(4);
		$page = (int)$this->uri->segment(5);
		if($id){
			if($this->mmod->delete($id)){
				$this->pre_message = "Thành công";
				redirect($this->mod.'/add/'.$cid.'/'.$id.'/'.$page);
			}else $this->pre_message = "Lỗi cập nhật dữ liệu";
		}
	}
	
	function edit()
	{
		$cid = empty($_POST['id_class']) ? (int)$this->uri->segment(3) : (int)$this->input->post('id_class');
		$id = empty($_POST['id']) ? (int)$this->uri->segment(4) : (int)$this->input->post('id');
		//page theo segment, post
		$page = empty($_POST['page']) ? (int)$this->uri->segment(5) : (int)$this->input->post('page');
		$load = array();
		
		if(!	empty($_POST['btnsubmit']))
		{ // posted data is existing
			
			$this->form_validation->set_rules('id_class', 'Mã module', 'required|trim|xss_clean');
			$this->form_validation->set_rules('func_name', 'Tên chức năng', 'required|trim|xss_clean');
			$this->form_validation->set_rules('required_access', 'Quyền truy cập', 'required|trim|xss_clean');
			$this->form_validation->set_rules('note', 'Ghi chú', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			}
			else
			{
				$values['id']        				= $id;
				$values['id_class'] 				= $this->input->post('id_class');
				$values['func_name'] 				= $this->input->post('func_name');
				$values['required_access']  = $this->input->post('required_access');
				$values['note']  						= $this->input->post('note');
				//test
				$test = $this->mmod->check_func_permit_edit($id, $values['id_class'], $values['func_name']);
				if(!	$test)
				{
					if($this->mmod->update($values))
					{
						$this->pre_message = "Thành công!";
					}
					else
					{
						$this->pre_message = "Lỗi: cập nhật dữ liệu.";
					}
				}
				else $this->pre_message = "Module này đã thiết lập rồi!";
			}
		}
		else
		{  
			$rs = $this->mmod->select($cid, $id);		
			if($rs)
			{
				$row = $rs->row(0);
				$load['note']        			= $row->note;
				$load['id_class']     		= $row->id_class;
				$load['func_name']  			= $row->func_name;
				$load['required_access']	= $row->required_access;
			}
			else
			{
				redirect($this->mod.'/add/0/0/'.$page);
			}
		}
		$vl_group = empty($load['required_access'])?$this->input->post('required_access'):$load['required_access'];
		$data['groups'] = $this->mmod->create_select_box_all_groups("required_access", $vl_group);
		$data['id_class'] = $this->mmod->create_select_box_class("id_class", $cid, '', $fid);
		$data['load'] = $load;
		$data['id'] = $id;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Edit functions access right on modules ";
		$this->load->vars(array_merge($this->lists($cid),$data));
		$this->content = $this->load->view($this->view_dir.'edit', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	function dels()
	{//
		$cid = empty($_POST['cid'])?"":(int)$this->input->post('cid');
		$page = empty($_POST['page'])?"":(int)$this->input->post('page');
		$wid = empty($_POST['ar_id'])?"":$this->input->post('ar_id');
		if(!empty($_POST['btn_submit']) && !empty($_POST['ar_id']))
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
						$this->pre_message = "Lỗi cập nhật dữ liệu";
					}
				}
			}
		}
		redirect($this->mod.'/add/'.$cid.'/0/'.$page);
	}
}