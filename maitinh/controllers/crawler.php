<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Crawler extends Controller {
	var $mod = "crawler";
	function crawler()
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
	
	function lists($cid=0)
	{// Lay ham dang target
		$fn = 'lists';
		$cid = empty($_POST['cid']) ? (int)$this->uri->segment(3) : (int)$_POST['cid'];
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box'] = $this->ncmod->create_select_all("cid", $cid, 'Tất cả chủ đề', 'submit');
		//get data for list
		$rs = $this->mmod->select($cid);
		$num_rows = $rs?$rs->num_rows():0;
		//
		if($num_rows){
			$data['db'] = $rs;
			/*-------------------------------+
			|  CUSTOM INPUT HERE             |
			| get data, and get config       |
			+--------------------------------*/
			$total_rows = $num_rows;
			$uri_segment= 4;
			$idcat = $cid;
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
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget.'/'.$idcat;
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

		$data['cid'] = $cid;
		$data['message'] = $this->pre_message;
		$data['heading'] = "Quản lý crawler";
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	// add a news
	function add()
	{
		if(!empty($_POST['btn_submit']))
		{
			$this->form_validation->set_rules('id_nwc', 'Thuộc chủ đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('id_pattern', 'Mẫu', 'required|trim|numeric|max_length[11]|xss_clean');
			$this->form_validation->set_rules('links', 'URL lấy link', 'required|trim|max_length[255]|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$ar_post = explode('|', $this->input->post('id_nwc'));
				
				$values['id_nwc'] 		= $ar_post[0];
				$values['id_cattext'] 	= $ar_post[1];
				$values['id_pattern'] 	= $this->input->post('id_pattern');
				$values['links']    	= $this->input->post('links');
				$values['create_time'] 	= time();
				if($this->mmod->insert("crawler", $values))
				{// lay id cua ban tin moi them
					$this->pre_message = "Thêm mới thành công!";
			 	}
				else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
			}
		}
		//
			
		$nid = empty($values['id_nwc']) ? (int)$this->uri->segment(3) : (int)$values['id_nwc'];
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['select_box_cat'] = $this->ncmod->create_select_child("id_nwc", $nid, '');
		
		$data['select_box_pattern'] = $this->mmod->create_select_box_pattern("id_pattern", $this->input->post('id_pattern'));
		
		$data['cid'] = $nid;
		$data['message'] = $this->pre_message;
		$data['heading'] = "Thêm crawler";
		$this->view_page =  $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function del()
	{// delete a news
		$nid = (int)$this->uri->segment(3);
		$id = (int)$this->uri->segment(4);
		$page = (int)$this->uri->segment(5);
		//
		if ($id){
			$this->load->model($this->mod.'_model','mmod');
			if($this->mmod->delete($id)){
				$this->pre_message = "Xóa thành công";
			}else $this->pre_message = "Xóa chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/lists/'.$nid.'/'.$page);
	}
	
	function edit()
	{
		$post_nid = $this->input->xss_clean($this->input->post('id_nwc'));
		$post_id = $this->input->xss_clean($this->input->post('id'));
		$post_page = $this->input->xss_clean($this->input->post('page'));
		
		//
		if(!empty($post_nid))
			$ar_post = explode('|', $post_nid);
			
		$nid = empty($_POST['id_nwc']) ? (int)$this->uri->segment(3) : (int)$ar_post[0];
		$id = empty($_POST['id']) ? (int)$this->uri->segment(4) : (int)$post_id;
		$page = empty($_POST['page']) ? (int)$this->uri->segment(5) : (int)$post_page;
		//
		$data['id'] = $id;
		// replace " , '
		$ard = array("'",'"',"\n");
		$art = array("\'",'\"',"");
		//
		$rs = $this->mmod->select("", $id);
		if($rs)
		{
			$row = $rs->row();
			$data['id_pattern'] 	= $row->id_pattern;
			$data['id_nwc'] 		= $row->id_nwc;
			$data['links'] 			= $row->links;
		}
		else
		{
			$this->pre_message = 'Dữ liệu chưa đúng!';
			$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
			redirect($this->mod);
		}
		// kiem tra neu nhu submit
		if(!empty($_POST['btn_submit']))
		{
			$this->form_validation->set_rules('id', 'Mã', 'required|trim|numeric|max_length[11]|xss_clean');
			$this->form_validation->set_rules('id_pattern', 'Mẫu', 'required|trim|numeric|max_length[11]|xss_clean');
			$this->form_validation->set_rules('id_nwc', 'Thuộc chủ đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('links', 'URL lấy link', 'required|trim|max_length[255]|xss_clean');

			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$ar_post = explode('|', $this->input->post('id_nwc'));

				$values['id'] 				= $this->input->post('id');
				$values['id_pattern'] 		= $this->input->post('id_pattern');
				$values['id_nwc'] 			= $ar_post[0];
				$values['id_cattext'] 		= $ar_post[1];
				$values['links']    		= $this->input->post('links');
				$values['update_time'] 		= time();
				if($this->mmod->update($values))
				{
					$this->pre_message = "Hiệu chỉnh thành công!";
				 }
				else $this->pre_message = "Kiểm tra lại dữ liệu nhập!";
			}
			
			$data['id_pattern'] 	= $this->input->post('id_pattern');
			$data['id_nwc'] 		= $nid;
			$data['links'] 			= $this->input->post('links');
		}

		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['select_box_cat'] = $this->ncmod->create_select_child("id_nwc", $data['id_nwc'], '');
		$data['select_box_pattern'] = $this->mmod->create_select_box_pattern("id_pattern", $data['id_pattern']);

		$data['message'] = $this->pre_message;
		$data['heading'] = "Hiệu chỉnh crawler";
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function dels()
	{//
		if(!empty($_POST['ar_id']))
		{
			$nid = (int)$this->input->post('cid');
			$page = (int)$this->input->post('page');
			$ar_id = $this->input->post('ar_id');
			
			if(!empty($_POST['btn_submit']))
			{
				for($i = 0; $i < sizeof($ar_id); $i ++) {
					if ($ar_id[$i]){
						if($this->mmod->delete($ar_id[$i]))
							$this->pre_message = "Đã xóa!";
						else $this->pre_message = "Chưa xóa được, vui lòng kiểm tra lại dữ liệu!";
					}
				}
			}
			
			if(!empty($_POST['btn_ensabled']))
			{
				for($i = 0; $i < sizeof($ar_id); $i ++) {
					if ($ar_id[$i]){
						if($this->mmod->enabled($ar_id[$i], '1'))
							$this->pre_message = "Đã enabled!";
						else $this->pre_message = "Chưa enabled được, vui lòng kiểm tra lại dữ liệu!";
					}
				}
			}
			
			if(!empty($_POST['btn_disabled']))
			{
				for($i = 0; $i < sizeof($ar_id); $i ++) {
					if ($ar_id[$i]){
						if($this->mmod->enabled($ar_id[$i], '0'))
							$this->pre_message = "Đã disabled!";
						else $this->pre_message = "Chưa disabled được, vui lòng kiểm tra lại dữ liệu!";
					}
				}
			}
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/lists/'.$nid.'/'.$page);
	}
	
	function show()
	{// 
		$nid = (int)$this->uri->segment(3);
		$id = (int)$this->uri->segment(4);
		$page = (int)$this->uri->segment(5);
		//
		if ($id){
			if($this->mmod->show($id)){
				$this->pre_message = "Đã thực thi!";
			}else $this->pre_message = "Chưa thực thi được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/lists/'.$nid.'/'.$page);
	}
}
?>