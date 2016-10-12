<?php
class ncat extends Controller {
	var $mod = "ncat";
	function ncat()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'news_home';
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
		$this->load->model($this->mod.'_model','mmod');
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
	{// get all main categories
		$data['all_root_cate'] = $this->mmod->get_cat_same_level(0);
		
		$data['heading'] = "Quan Ly Danh Muc Tin Tuc";
		// get the previous processing result into this front page
		$data['message'] = $this->pre_message;
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	// add a category
	function add()
	{
		$this->form_validation->set_rules('title', 'Tiêu đề', 'required|trim|max_length[255]|xss_clean');
		$this->form_validation->set_rules('comment', 'Mô tả thêm', 'trim|xss_clean');
		$this->form_validation->set_rules('isshown', 'Hiển thị', 'required|trim|numeric|exact_length[1]|xss_clean');
		$this->form_validation->set_rules('nwc_pid', 'Thuộc', 'trim|numeric|max_length[10]|xss_clean');
		$this->form_validation->set_rules('id_cattext', 'Mã trên link', 'trim|required|max_length[255]|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			$this->pre_message = validation_errors();
		}
		else
		{
			$values['id_nwc']      = "";
			$values['id_cattext']  = trim($this->input->post('id_cattext'));
			$values['nwc_name']    = $this->input->post('title');
			$values['nwc_comment'] = $this->input->post('comment');
			$values['nwc_shown']   = $this->input->post('isshown');
			$values['nwc_weight']  = 0;
			$values['nwc_pid']     = $this->input->post('nwc_pid');
			if($this->mmod->insert_new_cat($values))
				$this->pre_message = "Thêm mới thành công!";
			else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
		}
		
		$post = $this->input->xss_clean($this->input->post('nwc_pid'));
		$nwc_pid = empty($_POST['nwc_pid']) ? (int)$this->uri->segment(3) : (int)$post;

		$data['the_select_box'] = $this->mmod->create_select_box_root("nwc_pid", $nwc_pid);
		$data['heading'] = "Thêm Danh Mục Tin Tức";
		$data['message'] = $this->pre_message;
		$this->view_page =  $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function edit()
	{
		$post = $this->input->xss_clean($this->input->post('id_nwc'));
		$id_nwc = empty($_POST['id_nwc']) ? (int)$this->uri->segment(3) : (int)$post;
		
		$cat_info = $this->mmod->get_cat_info($id_nwc);
		if($cat_info)
		{		
			$data['nwc_name']   	= $cat_info->nwc_name;
			$data['nwc_comment']	= $cat_info->nwc_comment;
			$data['id_nwc']   		= $id_nwc;
			$data['isshown'] 		= $cat_info->nwc_shown;
			$data['nwc_pid']     	= $cat_info->nwc_pid;
			$data['id_cattext']     	= $cat_info->id_cattext;
			if($cat_info->nwc_shown)
			{
				$data['radio_shown_1'] = 'checked = "checked"';
				$data['radio_shown_0'] = '';
			}
			else
			{
				$data['radio_shown_1'] = '';
				$data['radio_shown_0'] = 'checked = "checked"';
			}
		}
		else
		{
			redirect($this->mod);
		}
		//
		if(!	empty($_POST))
		{
			$this->form_validation->set_rules('nwc_name', 'Tiêu đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('nwc_comment', 'Mô tả thêm', 'trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('isshown', 'Hiển thị', 'required|trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('id_nwc', 'Mã', 'required|trim|numeric|max_length[10]|xss_clean');
			$this->form_validation->set_rules('nwc_pid', 'Thuộc', 'trim|numeric|max_length[10]|xss_clean');
			$this->form_validation->set_rules('id_cattext', 'Mã trên link', 'required|trim|max_length[255]|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
	
				$values['id_nwc']      = $this->input->post('id_nwc');
				$values['id_cattext']  = trim($this->input->post('id_cattext'));
				$values['nwc_comment'] = $this->input->post('nwc_comment');
				$values['nwc_name']    = $this->input->post('nwc_name');
				$values['nwc_shown']   = $this->input->post('isshown');
				$values['nwc_pid']     = $this->input->post('nwc_pid');
				if($this->mmod->edit_cat($values))
				{
					$this->pre_message = "Đã sửa thành công!";
					//
					$val['id_nwc']      = $values['id_nwc'];
					$val['id_cattext']  = $values['id_cattext'];
					$this->mmod->update('news', $val, 'id_nwc');
					$this->mmod->update('crawler', $val, 'id_nwc');
				}
				else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
	
			}
			
			$data['nwc_pid']   		= $this->input->post('nwc_pid');
			$data['id_cattext']   	= $this->input->post('id_cattext');
			$data['nwc_name']   	= $this->input->post('nwc_name');
			$data['nwc_comment']	= $this->input->post('nwc_comment');
			$data['isshown'] 		= $this->input->post('nwc_pid');
		}
		
		$data['id_nwc']   		= $id_nwc;
		$data['message'] = $this->pre_message;
		$data['the_select_box'] = $this->mmod->create_select_box_root("nwc_pid", $data['nwc_pid']);
		$data['heading'] = "Sua Danh Muc Ban Tin";
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	// remove a category
	function del()
	{
		$nwc_id = (int)$this->uri->segment(3);
		if(!empty($nwc_id)){
			if($this->mmod->delete_cat($nwc_id)) $this->pre_message = 'Removed';
		}
		// reload the front page
		$this->lists();
	}
	// on off the category
	function cat_switch_state()
	{
		$nwc_id = $this->uri->segment(3);
		if(is_numeric($nwc_id)){
			if($this->mmod->switch_state($nwc_id)) $this->pre_message = 'Applied';
		}
		$this->lists();
	}
	// move a category up
	function cat_up()
	{
		$nwc_id = $this->uri->segment(3);
		if(is_numeric($nwc_id)){
			if($this->mmod->move_up($nwc_id)) $this->pre_message = 'Moved up';
		}
		$this->lists();
	}
	// move a category down
	function cat_down()
	{
		$nwc_id = $this->uri->segment(3);
		if(is_numeric($nwc_id)){
			if($this->mmod->move_down($nwc_id)) $this->pre_message = 'Moved down';
		}
		$this->lists();
	}
}
?>