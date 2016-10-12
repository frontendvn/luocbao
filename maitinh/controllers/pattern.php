<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pattern extends Controller {
	var $mod = "pattern";
	function pattern()
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
	
	function lists()
	{// Lay ham dang target
		$fn = 'lists';
		//get data for list
		$rs = $this->mmod->select();
		$num_rows = $rs?$rs->num_rows():0;
		//
		if($num_rows){
			$data['db'] = $rs;
			/*-------------------------------+
			|  CUSTOM INPUT HERE             |
			| get data, and get config       |
			+--------------------------------*/
			$total_rows = $num_rows;
			$uri_segment= 3;
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

		$data['message'] = $this->pre_message;
		$data['heading'] = "Quản lý mẫu bản tin";
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	// add a news
	function add()
	{
		if(!empty($_POST['btn_submit']))
		{
			$this->form_validation->set_rules('name', 'Tên website', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('website', 'Website', 'required|trim|prep_url|max_length[255]');
			$this->form_validation->set_rules('html_open', 'Mẫu open lấy link', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('html_close', 'Mẫu close lấy link', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('title_open', 'Mẫu open tiêu đề', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('title_close', 'Mẫu close tiêu đề', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('intro_open', 'Mẫu open xem nhanh', 'trim|max_length[255]');
			$this->form_validation->set_rules('intro_close', 'Mẫu close xem nhanh', 'trim|max_length[255]');
			$this->form_validation->set_rules('content_open', 'Mẫu open nội dung', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('content_close', 'Mẫu close nội dung', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('author_open', 'Mẫu open tác giả', 'trim|max_length[255]');
			$this->form_validation->set_rules('author_close', 'Mẫu close tác giả', 'trim|max_length[255]');
			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$values['name'] 			= $this->input->post('name');
				$values['website']			= $this->input->post('website');
				$values['html_open']    	= $this->input->post('html_open');
				$values['html_close'] 		= $this->input->post('html_close');
				$values['title_open'] 		= $this->input->post('title_open');
				$values['title_close']		= $this->input->post('title_close');
				$values['intro_open']    	= $this->input->post('intro_open');
				$values['intro_close']    	= $this->input->post('intro_close');
				$values['content_open'] 	= $this->input->post('content_open');
				$values['content_close']	= $this->input->post('content_close');
				$values['author_open']		= $this->input->post('author_open');
				$values['author_close']    	= $this->input->post('author_close');
				$values['weight'] 		= 0;
				$values['times'] 		= time();
				if($this->mmod->insert("news_pattern", $values))
				{// lay id cua ban tin moi them
					$this->pre_message = "Thêm mới thành công!";
			 	}
				else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
			}
		}

		$data['message'] = $this->pre_message;
		$data['heading'] = "Thêm bản tin";
		$this->view_page =  $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function del()
	{// delete a news
		$id = (int)$this->uri->segment(3);
		$page = (int)$this->uri->segment(4);
		//
		if ($id){
			if($this->mmod->delete($id))
			{
				$this->pre_message = "Xóa thành công";
				$this->mmod->re_sort();
			}
			else $this->pre_message = "Xóa chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/lists/'.$page);
	}
	
	function edit()
	{
		$post_id = $this->input->xss_clean($this->input->post('id_pattern'));
		$post_page = $this->input->xss_clean($this->input->post('page'));
		
		$id_pattern = empty($_POST['id_pattern']) ? (int)$this->uri->segment(3) : (int)$post_id;
		$page = empty($_POST['page']) ? (int)$this->uri->segment(4) : (int)$post_page;
		//
		$data['id_pattern'] = $id_pattern;
		// replace " , '
		$ard = array("'",'"',"\n");
		$art = array("\'",'\"',"");
		//
		$rs = $this->mmod->select($id_pattern);
		if($rs)
		{
			$row = $rs->row();
			$data['name'] 			= $row->name;
			$data['html_open'] 		= $row->html_open;
			$data['html_close'] 	= $row->html_close;
			$data['website'] 		= $row->website;
			$data['title_open'] 	= $row->title_open;
			$data['title_close'] 	= $row->title_close;
			$data['intro_open'] 	= $row->intro_open;
			$data['intro_close'] 	= $row->intro_close;
			$data['content_open'] 	= $row->content_open;
			$data['content_close'] 	= $row->content_close;
			$data['author_open'] 	= $row->author_open;
			$data['author_close'] 	= $row->author_close;
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
			$this->form_validation->set_rules('id_pattern', 'Mã', 'required|trim|numeric|max_length[11]|xss_clean');
			$this->form_validation->set_rules('name', 'Tên website', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('website', 'Website', 'required|trim|prep_url|max_length[255]');
			$this->form_validation->set_rules('html_open', 'Mẫu open lấy link', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('html_close', 'Mẫu close lấy link', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('title_open', 'Mẫu open tiêu đề', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('title_close', 'Mẫu close tiêu đề', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('intro_open', 'Mẫu open xem nhanh', 'trim|max_length[255]');
			$this->form_validation->set_rules('intro_close', 'Mẫu close xem nhanh', 'trim|max_length[255]');
			$this->form_validation->set_rules('content_open', 'Mẫu open nội dung', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('content_close', 'Mẫu close nội dung', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('author_open', 'Mẫu open tác giả', 'trim|max_length[255]');
			$this->form_validation->set_rules('author_close', 'Mẫu close tác giả', 'trim|max_length[255]');

			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$values['id_pattern'] 		= $this->input->post('id_pattern');
				$values['name'] 			= $this->input->post('name');
				$values['website']			= $this->input->post('website');
				$values['html_open']    	= $this->input->post('html_open');
				$values['html_close'] 		= $this->input->post('html_close');
				$values['title_open'] 		= $this->input->post('title_open');
				$values['title_close']		= $this->input->post('title_close');
				$values['intro_open']    	= $this->input->post('intro_open');
				$values['intro_close']    	= $this->input->post('intro_close');
				$values['content_open'] 	= $this->input->post('content_open');
				$values['content_close']	= $this->input->post('content_close');
				$values['author_open']		= $this->input->post('author_open');
				$values['author_close']    	= $this->input->post('author_close');
				$values['time_update'] 		= time();
				if($this->mmod->update($values))
				{
					$this->pre_message = "Hiệu chỉnh thành công!";
				 }
				else $this->pre_message = "Kiểm tra lại dữ liệu nhập!";
			}
			
			$data['name'] 			= $this->input->post('name');
			$data['html_open'] 		= $this->input->post('html_open');
			$data['html_close'] 	= $this->input->post('html_close');
			$data['website'] 		= $this->input->post('website');
			$data['title_open'] 	= $this->input->post('title_open');
			$data['title_close'] 	= $this->input->post('title_close');
			$data['intro_open'] 	= $this->input->post('intro_open');
			$data['intro_close'] 	= $this->input->post('intro_close');
			$data['content_open'] 	= $this->input->post('content_open');
			$data['content_close'] 	= $this->input->post('content_close');
			$data['author_open'] 	= $this->input->post('author_open');
			$data['author_close'] 	= $this->input->post('author_close');
		}

		$data['message'] = $this->pre_message;
		$data['heading'] = "Hiệu chỉnh Mẫu bản tin";
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function dels()
	{//
		if(!empty($_POST['btn_submit']) && !empty($_POST['ar_id'])){
			$page = (int)$_POST['page'];
			$ar_id = $_POST['ar_id'];
			for($i = 0; $i < sizeof($ar_id); $i ++) {
				if ($ar_id[$i]){
					if($this->mmod->delete($ar_id[$i]))
					{
						$this->pre_message = "Đã xóa!";
						$this->mmod->re_sort();
					}
					else $this->pre_message = "Chưa xóa được, vui lòng kiểm tra lại dữ liệu!";
				}
			}
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod);
	}
	// move a category up
	function move_up()
	{
		$nwc_id = $this->uri->segment(3);
		if(is_numeric($nwc_id)){
			if($this->mmod->move_up($nwc_id)) $this->pre_message = 'Moved up';
		}
		$this->lists();
	}
	// move a category down
	function move_down()
	{
		$nwc_id = $this->uri->segment(3);
		if(is_numeric($nwc_id)){
			if($this->mmod->move_down($nwc_id)) $this->pre_message = 'Moved down';
		}
		$this->lists();
	}
}
?>