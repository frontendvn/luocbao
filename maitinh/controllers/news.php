<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class news extends Controller {
	var $mod = "news";
	function news()
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
		//lay combobox danh muc tin tuc de search
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box_search'] = $this->ncmod->create_select_all("cid", '', 'Tất cả chủ đề');
		//lay combobox danh muc tin tuc
		$data['the_select_box'] = $this->ncmod->create_select_all("cid", $cid, 'Tất cả chủ đề', 'submit');
		//get data for list
		$rs = $this->mmod->select_news_audit($cid);
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
		$data['heading'] = "Quản lý bản tin";
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function list_audit($cid=0)
	{// Lay ham dang target
		$fn = 'list_audit';
		$cid = empty($_POST['cid']) ? (int)$this->uri->segment(3) : (int)$_POST['cid'];
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box'] = $this->ncmod->create_select_all("cid", $cid, 'Tất cả chủ đề', 'submit');
		//get data for list
		$rs = $this->mmod->select_audit($cid);
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
		$data['heading'] = "Quản lý bản tin";
		$this->view_page =  $this->view_dir.'list_audit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function search($cid=0)
	{// Lay ham dang target
		$fn = 'search';
		$cid = empty($_POST['cid']) ? (int)$this->uri->segment(3) : (int)$_POST['cid'];
		$this->session->keep_flashdata('keyword');
		$ss_flash_keyword = $this->session->flashdata('keyword');
		$keyword = empty($_POST['keyword']) ? $ss_flash_keyword : $_POST['keyword'];

		while(strpos($keyword, '  ')!==false)
		{
			$keyword = str_replace('  ', ' ', $keyword);
			$keyword = trim($keyword);
		}
		$this->session->set_flashdata('keyword', $keyword);
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box'] = $this->ncmod->create_select_all("cid", $cid, 'Tất cả chủ đề');
		//get data for list
		$rs = $this->mmod->select_search($cid, $keyword);
		$num_rows = $rs?$rs->num_rows():0;
		//
		if($num_rows)
		{
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
		$data['keyword'] = $keyword;
		$data['message'] = $this->pre_message;
		$data['heading'] = "Quản lý bản tin - Tìm kiếm";
		$this->view_page =  $this->view_dir.'search';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function add()
	{
		if(!empty($_POST['btn_submit']))
		{
			$this->form_validation->set_rules('news_title', 'Tiêu đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_quickview', 'Xem nhanh', 'trim|max_length[1000]|xss_clean');
			$this->form_validation->set_rules('news_content', 'Nội dung', 'trim|xss_clean');
			$this->form_validation->set_rules('news_author', 'Tác giả', 'trim|required|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_show', 'Hiển thị', 'required|trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('id_nwc', 'Thuộc chủ đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_special', 'Đặc biệt', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_lead', 'Nổi bật', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_useful', 'Tin hay', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_specialtime', 'Thời gian là tin đăc biệt', 'trim|numeric|max_length[10]|xss_clean');
			$this->form_validation->set_rules('id_text', 'Mã trên link', 'required|trim|max_length[255]|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				if(isset($_FILES['userfile']))
				{//
					$config['upload_path']   = $this->config->item('upload_dir').$this->config->item('file_dir');
					$config['allowed_types'] = $this->config->item('allowed_types');
					$config['max_size']	     = $this->config->item('img_size');
					$config['max_width']     = $this->config->item('img_width');
					$config['max_height']    = $this->config->item('img_height');
								
					$this->load->library('upload', $config);
					if ( !$this->upload->do_upload())
					{
						$this->pre_message .=  $this->upload->display_errors();
					}
					else
					{
						//get file upload
						$result = $this->upload->data();
						$values['news_img']    = substr($config['upload_path'], 3).$result['file_name'];
						$path_parts = pathinfo($values['news_img']);
						$dirname		= $path_parts['dirname'];
						$basename		= $path_parts['basename'];
						$extension		= $path_parts['extension'];
						$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
						//resize image 
						$config_resize['image_library'] = 'gd2';
						$config_resize['source_image'] = $result['full_path'];
						$config_resize['width'] = $this->config->item('img_thumb_width');
						$config_resize['height'] = $this->config->item('img_thumb_width');
						$config_resize['create_thumb'] = TRUE;
						$config_resize['maintain_ratio'] = TRUE;
						$config_resize['master_dim'] = 'width';
						$this->load->library('image_lib', $config_resize);
						
						if ( ! $this->image_lib->resize())
						{
							$this->pre_message .= $this->image_lib->display_errors();
						}
						else 
						{
							$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
						
							$path_parts 	= pathinfo($values['news_img_thumb']);
							$dirname		= $path_parts['dirname'];
							$basename		= $path_parts['basename'];
							$extension		= $path_parts['extension'];
							$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
							
							//resize image 
							$config_resize['image_library'] = 'gd2';
							$config_resize['source_image'] = ROOT.$values['news_img_thumb'];
							$config_resize['width'] = $this->config->item('img_thumb_width');
							$config_resize['height'] = $this->config->item('img_thumb_height');
							$config_resize['create_thumb'] = TRUE;
							$config_resize['maintain_ratio'] = FALSE;
							$this->image_lib->initialize($config_resize);
							
							if ( ! $this->image_lib->crop())
							{
								$this->pre_message .= $this->image_lib->display_errors();
							}
							else
							{
								$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
							}
						}
					}
				}
				
				$arf = array(' ',':','.',',',"'",'"','(',')','?','!','\\','“','”','/','%');
				$arn = array('-','','','','','','','','','','','','','-','');
				
				$post_show = $this->input->post('news_show');
				$post_lead = $this->input->post('news_lead');
				$post_special = $this->input->post('news_special');
				$post_specialtime = $this->input->post('news_specialtime');
				$post_useful = $this->input->post('news_useful');
				$ar_post = explode('|', $this->input->post('id_nwc'));
				$time = time();
				
				$values['id_nwc'] 			= $ar_post[0];
				$values['id_cattext'] 		= $ar_post[1];
				$values['news_title'] 		= trim(addslashes($this->input->post('news_title')));
				$values['news_quickview']	= addslashes($this->input->post('news_quickview'));
				$values['news_content']    	= $this->input->post('news_content');
				$values['news_author']    	= addslashes($this->input->post('news_author'));
				$values['news_show'] 		= $post_show=='1' ? '1' : '0';
				$values['news_audit'] 		= '1';
				$values['news_date'] 		= $time;
				$values['news_viewcount'] 	= 1;
				$values['news_lead'] 		= $post_lead=='1' ? '1' : '0';
				$values['news_specialtime'] = (int)$post_specialtime*3600+$time;
				$values['news_special'] 	= $post_special=='1' ? '1' : '0';
				$values['news_special_create_date'] = $post_special=='1' ? $time : '';
				$values['news_useful'] 		= $post_useful=='1' ? '1' : '0';
				$values['news_lead_create_date']   	= $post_lead=='1' ? $time : '';
				$values['news_useful_create_date']  = $post_useful=='1' ? $time : '';
				$values['id_text'] 			= url_title($this->input->post('id_text'));
				if($this->mmod->insert("news", $values))
				{// lay id cua ban tin moi them
					$this->pre_message = "Thêm mới thành công!";
					// check for total lead
					if($values['news_lead']=='1')
					{
						$query = $this->mmod->select_count_news_for_lead();
						$count = $query ? $query->row()->nums : 0;
						if($count>10)
						{
							$query = $this->mmod->select_old_news_for_lead();
							$id_old = $query ? $query->row()->id_news : 0;
							if($id_old)
							{
								$val['id_news'] 		= $id_old;
								$val['news_lead']		= '0';
								$this->mmod->update($val);
							}
						}
					}
					// check for total useful
					if($values['news_useful']=='1')
					{
						$query = $this->mmod->select_count_news_for_useful();
						$count = $query ? $query->row()->nums : 0;
						if($count>10)
						{
							$query = $this->mmod->select_old_news_for_useful();
							$id_old = $query ? $query->row()->id_news : 0;
							if($id_old)
							{
								$val1['id_news'] 		= $id_old;
								$val1['news_useful']		= '0';
								$this->mmod->update($val1);
							}
						}
					}
			 	}
				else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
			}
		}
		//The hien loai theo segment, post
		$nid = empty($values['id_nwc']) ? (int)$this->uri->segment(3) : (int)$values['id_nwc'];
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box'] = $this->ncmod->create_select_child("id_nwc", $nid);
		//
		$this->load->library('Fckeditor','fckeditor');
		//
		$this->fckeditor->Width		= 870;
		$this->fckeditor->Height	= 900;
		#$this->fckeditor->ToolbarSet= "MyToolbar";
		//
		$this->fckeditor->Value		= $this->input->post('news_content');
		$this->fckeditor->InstanceName = 'news_content';
		$data['news_content'] = $this->fckeditor->CreateHtml();
		//

		$data['time_options'] = $this->config->item('hours');

		$data['message'] = $this->pre_message;
		$data['heading'] = "Thêm bản tin";
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
			if($this->mmod->delete($id)){
				$this->pre_message = "Xóa thành công";
			}else $this->pre_message = "Xóa chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/list_audit');
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

	function edit()
	{
		$this->load->helper('removed_sign');
		$post_nid = $this->input->xss_clean($this->input->post('id_nwc'));
		$post_id = $this->input->xss_clean($this->input->post('id_news'));
		$post_page = $this->input->xss_clean($this->input->post('page'));
		
		if(!empty($post_nid))
			$ar_post = explode('|', $post_nid);

		$nid = empty($_POST['id_nwc']) ? (int)$this->uri->segment(3) : (int)$ar_post[0];
		$id_news = empty($_POST['id_news']) ? (int)$this->uri->segment(4) : (int)$post_id;
		$page = empty($_POST['page']) ? (int)$this->uri->segment(5) : (int)$post_page;
		//
		$data['id_news'] = $id_news;
		$data['id_nwc'] = $nid;
		$data['page'] = $page;
		//
		$rs = $this->mmod->select("",$id_news);
		if($rs)
		{
			$row = $rs->row();
			$data['news_title'] 	= htmlspecialchars_decode(trim($row->news_title));
			while(strpos($data['news_title'], '  ')!==false)
			{
				$data['news_title'] = str_replace('  ', ' ', $data['news_title']);
				$data['news_title'] = trim($data['news_title']);
			}
			$data['news_link'] 		= $row->news_link;
			$data['news_quickview'] = $row->news_quickview;
			$data['news_content'] 	= $row->news_content;
			$data['news_author'] 	= $row->news_author;
			$data['news_img'] 		= $row->news_img;
			$data['news_img_thumb']	= $row->news_img_thumb;
			$data['id_cattext'] 	= $row->id_cattext;
			$str_meta = $row->news_meta;
			$data['news_meta'] 		= empty($str_meta) ? array() : explode('~', $str_meta);
			$str_show = $row->news_show;
			$data['news_show'] 		= $str_show=='1'? TRUE : FALSE;
			$str_audit = $row->news_audit;
			$data['news_audit'] 	= $str_audit=='1'? TRUE : TRUE;
			$str_special = $row->news_special;
			$data['news_special'] 	= $str_special=='1'? TRUE : FALSE;
			$str_lead = $row->news_lead;
			$data['news_lead'] 		= $str_lead=='1'? TRUE : FALSE;
			$data['news_specialtime'] 	= $row->news_specialtime;
			$str_useful = $row->news_useful;
			$data['news_useful'] 	= $str_useful=='1'? TRUE : FALSE;
			$data['disabled'] 		= $data['news_special'] ? '' : 'disabled="disabled"';
			$data['id_text'] 		= url_title(removed_sign($data['news_title']));
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
			$this->form_validation->set_rules('news_title', 'Tiêu đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_quickview', 'Xem nhanh', 'trim|max_length[1000]|xss_clean');
			$this->form_validation->set_rules('news_content', 'Nội dung', 'trim');
			$this->form_validation->set_rules('news_author', 'Tác giả', 'trim|required|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_show', 'Hiển thị', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_audit', 'Duyệt', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_lead', 'Tin nóng', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_special', 'Đặc biệt', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('news_useful', 'Tin hay', 'trim|numeric|exact_length[1]|xss_clean');
			$this->form_validation->set_rules('id_news', 'Mã', 'required|trim|numeric|max_length[10]|xss_clean');
			$this->form_validation->set_rules('id_nwc', 'Thuộc chủ đề', 'required|trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_img', 'Hình chính', 'trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('news_specialtime', 'Thời gian là tin đặc biệt', 'trim|numeric|max_length[10]|xss_clean');
			$this->form_validation->set_rules('id_text', 'Mã trên link', 'required|trim|max_length[255]|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				#$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$news_meta = $this->input->post('news_meta');
				$news_meta = empty($news_meta) ? array() : $news_meta;
				$result = array_diff($data['news_meta'],$news_meta);
				foreach($result as $aval)
				{
					if(!empty($aval) and file_exists(ROOT.$aval)) @unlink(ROOT.$aval);
				}
				$values['news_meta']    = is_array($news_meta) ? implode('~', $news_meta) : '';
				
				if(!empty($_FILES['userfile']))
				{//
					$config['upload_path']   = $this->config->item('upload_dir').$this->config->item('file_dir');
					$config['allowed_types'] = $this->config->item('allowed_types');
					$config['max_size']	     = $this->config->item('img_size');
					$config['max_width']     = $this->config->item('img_width');
					$config['max_height']    = $this->config->item('img_height');
								
					$this->load->library('upload', $config);
					if ( !$this->upload->do_upload())
					{
						$this->pre_message .=  $this->upload->display_errors();
									
					}
					else
					{
						if(!empty($data['news_img_thumb'])) @unlink("../".$data['news_img_thumb']);
						//get file upload
						$result = $this->upload->data();
						$values['news_img']		= substr($config['upload_path'], 3).$result['file_name'];
						array_push($news_meta, $values['news_img']);
						$values['news_meta']    = implode('~', $news_meta);
						$data['news_img'] 		= $values['news_img'];
						
						$path_parts 	= pathinfo($values['news_img']);
						$dirname		= $path_parts['dirname'];
						$basename		= $path_parts['basename'];
						$extension		= $path_parts['extension'];
						$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
						//resize image 
						$config_resize['image_library'] = 'gd2';
						$config_resize['source_image'] = $result['full_path'];
						$config_resize['width'] = $this->config->item('img_thumb_width');
						$config_resize['height'] = $this->config->item('img_thumb_width');
						$config_resize['create_thumb'] = TRUE;
						$config_resize['maintain_ratio'] = TRUE;
						$config_resize['master_dim'] = 'width';
						$this->load->library('image_lib', $config_resize);
						
						if ( ! $this->image_lib->resize())
						{
							$this->pre_message .= $this->image_lib->display_errors();
						}
						else 
						{
							$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
						
							$path_parts 	= pathinfo($values['news_img_thumb']);
							$dirname		= $path_parts['dirname'];
							$basename		= $path_parts['basename'];
							$extension		= $path_parts['extension'];
							$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
							
							//resize image 
							$config_resize['image_library'] = 'gd2';
							$config_resize['source_image'] = ROOT.$values['news_img_thumb'];
							$config_resize['width'] = $this->config->item('img_thumb_width');
							$config_resize['height'] = $this->config->item('img_thumb_height');
							$config_resize['create_thumb'] = TRUE;
							$config_resize['maintain_ratio'] = FALSE;
							$this->image_lib->initialize($config_resize);
							
							if ( ! $this->image_lib->crop())
							{
								$this->pre_message .= $this->image_lib->display_errors();
							}
							else
							{
								$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
							}
						}
					}
				}
				
				if(empty($values['news_img']) and !empty($_POST['news_img']))
				{
					$values['news_img']    =  $this->input->post('news_img'); 
					if(!empty($data['news_img_thumb'])) @unlink("../".$data['news_img_thumb']);
					$path_parts = pathinfo($values['news_img']);
					$dirname		= $path_parts['dirname'];
					$basename		= $path_parts['basename'];
					$extension		= $path_parts['extension'];
					$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
					//resize image
					$config_resize['image_library'] = 'gd2';
					$config_resize['source_image'] = ROOT.$values['news_img'];
					$config_resize['width'] = $this->config->item('img_thumb_width');
					$config_resize['height'] = $this->config->item('img_thumb_width');
					$config_resize['create_thumb'] = TRUE;
					$config_resize['maintain_ratio'] = TRUE;
					$config_resize['master_dim'] = 'width';
					$this->load->library('image_lib', $config_resize);
					
					if ( ! $this->image_lib->resize())
					{
						$this->pre_message .= $this->image_lib->display_errors();
					}
					else
					{ 
						$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
						
						$path_parts = pathinfo($values['news_img_thumb']);
						$dirname		= $path_parts['dirname'];
						$basename		= $path_parts['basename'];
						$extension		= $path_parts['extension'];
						$filename		= substr($path_parts['basename'],0,-(strlen($extension)+1));
						//resize image
						$config_resize['image_library'] = 'gd2';
						$config_resize['source_image'] = ROOT.$values['news_img_thumb'];
						$config_resize['width'] = $this->config->item('img_thumb_width');
						$config_resize['height'] = $this->config->item('img_thumb_height');
						$config_resize['create_thumb'] = TRUE;
						$config_resize['maintain_ratio'] = FALSE;
						$this->image_lib->initialize($config_resize);
						
						if ( ! $this->image_lib->crop())
						{
							$this->pre_message .= $this->image_lib->display_errors();
						}
						else
						{ 
							$values['news_img_thumb'] = $dirname."/".$filename."_thumb.".$extension;
						}
					}
				}
				
				if(empty($values['news_img']))
				{// for del main img
					$values['news_img']    =   '';
					$values['news_img_thumb']  =   '';
					if(!empty($data['news_img_thumb'])) @unlink("../".$data['news_img_thumb']);
				}

				$post_show = $this->input->post('news_show');
				$post_audit = $this->input->post('news_audit');
				$post_lead = $this->input->post('news_lead');
				$post_special = $this->input->post('news_special');
				$post_specialtime = $this->input->post('news_specialtime');
				$post_useful = $this->input->post('news_useful');
				$ar_post = explode('|', $this->input->post('id_nwc'));
				
				$values['id_news'] 			= $this->input->post('id_news');
				$values['id_nwc'] 			= $ar_post[0];
				$values['id_cattext'] 		= $ar_post[1]; 
				$values['news_title'] 		= trim(strip_tags(addslashes($this->input->post('news_title'))));
				$values['news_quickview']	= trim(strip_tags(addslashes($this->input->post('news_quickview'))));
				while(strpos($values['news_title'], '\\\\')!==false)
				{
					$values['news_title'] = str_replace('\\\\', '\\', $values['news_title']);
				}
				
				while(strpos($values['news_quickview'], '\\\\')!==false)
				{
					$values['news_quickview'] = str_replace('\\\\', '\\', $values['news_quickview']);
				}
				
				$time = time();
				$values['news_content']   	= $this->input->post('news_content');
				$values['news_author']    	= $this->input->post('news_author');
				$values['news_specialtime'] = (int)$post_specialtime*3600+$time;
				$values['news_show'] 		= $post_show=='1' ? '1' : '0';
				$values['news_audit'] 		= $post_audit=='1' ? '1' : '0';
				$values['news_lead'] 		= $post_lead=='1' ? '1' : '0';
				$values['news_special'] 	= $post_special=='1' ? '1' : '0';
				$values['news_useful'] 		= $post_useful=='1' ? '1' : '0';
				$values['news_special_create_date'] = $post_special=='1' ? $time : '';
				$values['news_lead_create_date']   	= $post_lead=='1' ? $time : '';
				$values['news_useful_create_date']  = $post_useful=='1' ? $time : '';
				$values['id_text'] 			= url_title($this->input->post('id_text'));
				if($this->mmod->update($values))
				{
					$this->pre_message = "Hiệu chỉnh thành công!";
					// check for total lead
					if($values['news_lead']=='1')
					{
						$query = $this->mmod->select_count_news_for_lead();
						$count = $query ? $query->row()->nums : 0;
						if($count>10)
						{
							$query = $this->mmod->select_old_news_for_lead();
							$id_old = $query ? $query->row()->id_news : 0;
							if($id_old)
							{
								$val['id_news'] 		= $id_old;
								$val['news_lead']		= '0';
								$this->mmod->update($val);
							}
						}
					}
					// check for total useful
					if($values['news_useful']=='1')
					{
						$query = $this->mmod->select_count_news_for_useful();
						$count = $query ? $query->row()->nums : 0;
						if($count>10)
						{
							$query = $this->mmod->select_old_news_for_useful();
							$id_old = $query ? $query->row()->id_news : 0;
							if($id_old)
							{
								$val1['id_news'] 		= $id_old;
								$val1['news_useful']		= '0';
								$this->mmod->update($val1);
							}
						}
					}
				}
				else $this->pre_message = "Kiểm tra lại dữ liệu nhập!";
				
				$data['news_meta'] 		= $news_meta;
				$data['news_title'] 	= $values['news_title'];
				$data['news_quickview'] = $values['news_quickview'];
				$data['news_content'] 	= $values['news_content'];
				$data['news_author'] 	= $values['news_author'];
				$data['news_specialtime'] 	= $values['news_specialtime'];
				$data['news_img'] 		= $this->input->post('news_img');
				$str_show = $this->input->post('news_show');
				$data['news_show'] 		= $str_show=='1'? TRUE : FALSE;
				$str_audit = $this->input->post('news_audit');
				$data['news_audit'] 	= $str_audit=='1'? TRUE : FALSE;
				$str_lead = $this->input->post('news_lead');
				$data['news_lead'] 		= $str_lead=='1'? TRUE : FALSE;
				$str_useful = $this->input->post('news_useful');
				$data['news_useful'] 		= $str_useful=='1'? TRUE : FALSE;
				$data['id_text'] 		= $values['id_text'];
				
				$this->pre_message .= $str_audit=='1'? '' : ' <font color="#FF0000">Tin chưa duyệt.</font>';
			}
		}
		
		$rs_news_near = $this->mmod->select_news_near($id_news);
		$data['news_near'] = $rs_news_near ? anchor($this->mod.'/edit/'.$rs_news_near->row(0)->id_nwc.'/'.$rs_news_near->row(0)->id_news, '&raquo; Duyệt tiếp') : '';
		//lay combobox danh muc tin tuc
		$this->load->model('ncat_model', 'ncmod');
		$data['the_select_box'] = $this->ncmod->create_select_child("id_nwc", $nid, '');
		//
		if($data['id_nwc']!=15)
		{
			$this->load->library('Fckeditor','fckeditor');
			//
			$this->fckeditor->Width		= 870;
			$this->fckeditor->Height	= 900;
			#$this->fckeditor->ToolbarSet= "MyToolbar";
			//
			$this->fckeditor->Value		= $data['news_content'];
			$this->fckeditor->InstanceName = 'news_content';
			$data['html_news_content'] = $this->fckeditor->CreateHtml();
		}
		else
		{
			$data['html_news_content'] = '<textarea cols="106" rows="40" name="news_content">'.$data['news_content'].'</textarea>';
		}
		//

		$data['time_options'] = $this->config->item('hours');
		
		$data['message'] = $this->pre_message;
		$data['heading'] = "Hiệu chỉnh bản tin";
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function dels()
	{//
		if(!empty($_POST['ar_id']))
		{
			$cid = (int)$this->input->post('cid');
			$page = (int)$this->input->post('page');
			$ar_id = $this->input->post('ar_id');
			$list_type = $this->input->post('list_type');
			
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
			
			if(!empty($_POST['btn_audit']))
			{
				for($i = 0; $i < sizeof($ar_id); $i ++) {
					if ($ar_id[$i]){
						if($this->mmod->audit($ar_id[$i], '1'))
							$this->pre_message = "Đã duyệt!";
						else $this->pre_message = "Chưa duyệt được, vui lòng kiểm tra lại dữ liệu!";
					}
				}
			}
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/'.$list_type.'/'.$cid);
	}
	
	function add_useful($id_news='')
	{
		$return = 'Lỗi: Không thấy dữ liệu.';
		$rs = $this->mmod->select_news_for_lead($id_news);
		if($rs)
		{
			$row = $rs->row_array();
			$values['id_news'] 			= $row['id_news'];
			$values['news_useful']		= '1';
			$values['news_useful_create_date'] 		= time();
			if($this->mmod->update($values))
			{// lay id cua ban tin moi them
				$return = 'Tin hay.';
				$query = $this->mmod->select_count_news_for_useful();
				$count = $query ? $query->row()->nums : 0;
				if($count>10)
				{
					$query = $this->mmod->select_old_news_for_useful();
					$id_old = $query ? $query->row()->id_news : 0;
					if($id_old)
					{
						$val['id_news'] 		= $id_old;
						$val['news_useful']		= '0';
						$this->mmod->update($val);
					}
				}
			}
			else $return = 'Lỗi: thao tác dữ liệu.';
		}
		echo $return;
	}
	
	function add_lead($id_news='')
	{
		$return = 'Lỗi: không thấy dữ liệu.';
		$rs = $this->mmod->select_news_for_lead($id_news);
		if($rs)
		{
			$row = $rs->row_array();
			$values['id_news'] 			= $row['id_news'];
			$values['news_lead']		= '1';
			$values['news_specialtime']   	= 5;
			$values['news_lead_create_date'] 		= time();
			if($this->mmod->update($values))
			{// lay id cua ban tin moi them
				$return = 'Tin nổi bật.';
				$query = $this->mmod->select_count_news_for_lead();
				$count = $query ? $query->row()->nums : 0;
				if($count>10)
				{
					$query = $this->mmod->select_old_news_for_lead();
					$id_old = $query ? $query->row()->id_news : 0;
					if($id_old)
					{
						$val['id_news'] 		= $id_old;
						$val['news_lead']		= '0';
						$this->mmod->update($val);
					}
				}
			}
			else $return = 'Lỗi: thao tác dữ liệu.';
		}
		echo $return;
	}
	
	function list_lead()
	{//get data for list
		$db_special = $this->mmod->select_special();
		$db = $this->mmod->select_lead();
		$total_item1 = $db_special ? $db_special->num_rows() : 0;
		$total_item2 = $db ? $db->num_rows() : 0;
		$data['fn'] = 'list_lead';
		$data['db'] = $db;
		$data['db_special'] = $db_special;
		$data['total_item1'] = $total_item1;
		$data['total_item2'] = $total_item2;
		$data['total_item'] = $total_item1 + $total_item2;
		//
		$data['message'] = $this->pre_message;
		$data['heading'] = "Quản lý bản tin nổi bật";
		$this->view_page =  $this->view_dir.'list_lead';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function list_useful()
	{//get data for list
		$db = $this->mmod->select_useful();
		$total_item = $db ? $db->num_rows() : 0;
		$data['fn'] = 'list_useful';
		$data['db'] = $db;
		$data['total_item'] = $total_item ;
		//
		$data['message'] = $this->pre_message;
		$data['heading'] = "Quản lý bản tin hay";
		$this->view_page =  $this->view_dir.'list_useful';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function removed_special()
	{// delete a news
		$id = (int)$this->uri->segment(3);
		//
		if ($id){
			$val['id_news'] 	= $id;
			$val['news_special']	= '0';
			if($this->mmod->update($val)){
				$this->pre_message = "Đã xóa nhãn đặc biệt.";
			}else $this->pre_message = "Xóa nhãn chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/list_lead');
	}

	function removed_lead()
	{// delete a news
		$id = (int)$this->uri->segment(3);
		//
		if ($id){
			$val['id_news'] 	= $id;
			$val['news_lead']	= '0';
			if($this->mmod->update($val)){
				$this->pre_message = "Đã xóa nhãn nổi bật.";
			}else $this->pre_message = "Xóa nhãn chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/list_lead');
	}
	
	function removed_useful()
	{// delete a news
		$id = (int)$this->uri->segment(3);
		//
		if ($id){
			$val['id_news'] 	= $id;
			$val['news_useful']	= '0';
			if($this->mmod->update($val)){
				$this->pre_message = "Đã xóa nhãn tin hay.";
			}else $this->pre_message = "Xóa nhãn chưa được, vui lòng thử lại !";
		}
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/list_useful');
	}

}
