<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class vote_content extends Controller {
	var $mod = "vote_content";
	function vote_content()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		//template directory
		$this->temp_dir = $this->config->item('temp_dir');
		// init feedback for user's actions
		$this->pre_message = "";
		// load necessary libraries
		$this->load->helper('text');
		
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
		$this->load->model($this->mod.'_model', 'pmod');
	}
	// default page
	function index()
	{
		$this->add();		
	}
	function lists($fn="", $cid=0, $id=0)
	{// news category front page
		//Lay ham dang target
		$fn = empty($fn) ? $this->uri->segment(2) :trim($fn);
		// get the previous processing result into this front page
		$data['message'] = $this->pre_message;
		//get data for list
		$rs = $this->pmod->select($cid);
		$num_rows = $rs?$rs->num_rows():0;
		//
		if($num_rows){
			$data['db'] = $rs;
			/*-------------------------------+
			|  CUSTOM INPUT HERE             |
			| get data, and get config       |
			+--------------------------------*/
			$total_rows = $num_rows;
			$uri_segment= 5;
			$idcat = $cid;
			$idchild = $id;
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
			$config['base_url'] = site_url().'/'.$this->mod.'/'.$functarget.'/'.$idcat.'/'.$idchild;
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
			$data['cid'] = $cid;
			$data['id'] = $id;
		}		
		return $data;
	}
	// add a news
	function add($qid="")
	{
		$data['heading'] = "Manage ".$this->mod;
		$this->load->model($this->mod.'_model','pmod');
		//The hien loai theo segment, post
		$qid = empty($_POST['qid']) ? (int)$qid : (int)$_POST['qid'];
		$data['qid'] = $qid;
		$vote = $this->pmod->get_vote_title($qid);
		if(!$vote) return false;
		$data['qtitle'] = $vote->title_vo;
		$data['qtypes'] 	= $vote->types_vo;
		//kiem tra neu nhu submit
		if(!empty($_POST['save']))
		{
			$this->form_validation->set_rules('qid', 'Câu hỏi', 'trim|required|max_length[11]|xss_clean');
				
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p >', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$ar_content = $this->input->post('content');
				$n = sizeof($ar_content);
				$return = TRUE;
				for($i=0;$i<$n;$i++)
				{
					if(!empty($ar_content[$i]))
					{
						$values['id_vo'] 			= $this->input->post('qid');
						$values['content_vc'] 		= $ar_content[$i];
						$values['position_vc']  	= 1;
						if(!$this->pmod->insert($this->mod,$values)) $return = FALSE; 
					}
				}
				$vl['id_vo'] = $this->input->post('qid');
				$vl['show_vo'] = '1';
				$this->pmod->update_vote($vl);// update cau hoi show='Y'
				$this->pre_message = ($return)?"Thêm mới thành công!":"Kiểm tra lại thông tin nhập vào!";
			}
		}
		$data['op_type'] = $this->config->item('op_type');
		$data['op_vote_content'] = $this->config->item('op_vote_content');
		$this->view_page =  $this->view_dir.'add';
		$this->load->vars(array_merge($this->lists('add',$qid),$data));
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function del()
	{// delete a news
		//Lay id cua ban tin
		$qid = (int)$this->uri->segment(3);
		$id = (int)$this->uri->segment(4);
		$page = (int)$this->uri->segment(5);
		//
		if ($id){
			$this->load->model($this->mod.'_model','pmod');
			if($this->pmod->delete($id, $qid)){
				$this->pre_message = "Xóa thành công";
			}else $this->pre_message = "Xóa chưa được, vui lòng thử lại !";
		}
		redirect($this->mod.'/add/'.$qid);
	}

	function edit()
	{
		$data['heading'] = "Manage ".$this->mod;
		$this->load->model($this->mod.'_model','pmod');
		$qid = empty($_POST['qid']) ? (int)$this->uri->segment(3) : (int)$_POST['qid'];
		//id theo segment, post
		$id = empty($_POST['id']) ? (int)$this->uri->segment(4) : (int)$_POST['id'];
		//page theo segment, post
		$page = empty($_POST['page']) ? (int)$this->uri->segment(5) : (int)$_POST['page'];
		//
		$vote = $this->pmod->get_vote_title($qid);
		if(!$vote) return false;
		$data['qtitle'] = $vote->title_vo;

		$data['id'] = $id;
		$data['qid'] = $qid;
		// replace " , '
		$ard = array("'",'"',"\n");
		$art = array("\'",'\"',"");
		//kiem tra neu nhu submit
		if(!empty($_POST['btn_submit'])){
			$this->form_validation->set_rules('qid', 'Câu hỏi', 'trim|required|max_length[11]|xss_clean');
			$this->form_validation->set_rules('content', 'Nội dung', 'trim|required|max_length[255]|xss_clean');
				
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p >', '</p>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$values['id_vc'] 				= $id;
				$values['id_vo'] 				= $this->input->post('qid');
				$values['content_vc'] 	= $this->input->post('content');
				if($this->pmod->update($values))
				{
					$this->pre_message = "Hiệu chỉnh thành công!";
				}
				else $this->pre_message = "Lỗi: không thể cập nhật dữ liệu!";
			}
		}
		$rs = $this->pmod->select("",$id);
		if($rs)
		{
			$row = $rs->row();
			$data['content'] = $row->content_vc;
		}
		else
		{
			redirect($this->mod.'/add/'.$qid.'/0/'.$page);
		}
		//
		$data['op_vote_content'] = $this->config->item('op_vote_content');
		$data['op_type'] = $this->config->item('op_type');
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars(array_merge($this->lists('edit',$qid, $id),$data));
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function dels()
	{// delete a news
		//Lay id cua ban tin
		if(!empty($_POST['btn_submit']) && !empty($_POST['wid'])){
			$qid = (int)$_POST['qid'];
			$page = (int)$_POST['page'];
			$wid = $_POST['wid'];
			$this->load->helper('url');
			$this->load->model($this->mod.'_model','pmod');
			for($i = 0; $i < sizeof($wid); $i ++) {
				if ($wid[$i]){
					if($this->pmod->delete($wid[$i], $qid))
						$this->pre_message = "Đã xóa!";
					else $this->pre_message = "Chưa xóa được, vui lòng kiểm tra lại dữ liệu!";
				}
			}
			$this->add($qid);
		}else{
			redirect($this->mod.'/add');
		}
	}
	// move a category up
	function move_up()
	{
		$qid = (int)$this->uri->segment(3);
		$nwc_id = (int)$this->uri->segment(4);
		if(is_numeric($nwc_id)){
			$this->load->model($this->mod.'_model', 'pmod');
			if($this->pmod->move_up($nwc_id)) $this->pre_message = 'Đã chuyển lên!';
		}
		$this->add($qid);
	}
	// move a category down
	function move_down()
	{
		$qid = (int)$this->uri->segment(3);
		$id = (int)$this->uri->segment(4);
		if(is_numeric($id)){
			$this->load->model($this->mod.'_model', 'pmod');
			if($this->pmod->move_down($id)) $this->pre_message = 'Đã chuyển xuống!';
		}
		$this->add($qid);
	}
	function AJ_add_page()
	{
			$nums 	= $this->input->post('nums');
			$types = $this->input->post('types');
			
			$nums 	= $this->input->xss_clean($nums);
			$types = $this->input->xss_clean($types);
			
			$data['nums'] 	= (int)$nums;
			$data['types'] 	= $types;
			$this->load->vars($data);
			$this->load->view($this->view_dir.'AJ_add_page', $data);
	}
}
?>