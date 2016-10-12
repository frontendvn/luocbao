<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class vote extends Controller {
	var $mod = "vote";
	function vote()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		//resource directory
		$this->resource_dir = $this->config->item('resource_dir');
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
		$this->lists();		
	}
	function lists()
	{// news category front page
		//Lay ham dang target
		$fn = 'lists';
		//get data for list
		$rs = $this->pmod->select();
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
			$array_ques = array();
			for($idx = $firstitem; $idx < $lastitem; $idx++){
				$row = $rs->row($idx); 
				$id_ques = $row->id_vo;	
				array_push($array_ques, $id_ques);
			}
			$data['db_ans'] = $this->pmod->select_vote_contents($array_ques);
			//
		}		
		$data['op_type'] = $this->config->item('op_type');
		$data['heading'] = "Manage ".$this->mod;
		// get the previous processing result into this front page
		$data['message'] = $this->pre_message;
		$this->view_page =  $this->view_dir.'list';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	// add a news
	function add()
	{
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|min_length[5]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('comment', 'Mô tả', 'trim|min_length[5]|max_length[500]|xss_clean');
		$this->form_validation->set_rules('types', 'Loại câu hỏi', 'trim|required|exact_length[1]|xss_clean');
		$this->form_validation->set_rules('show', 'Trạng thái', 'trim|required|exact_length[1]|xss_clean');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p >', '</p>');
			$this->pre_message = validation_errors();
		}
		else
		{
			// replace " , '
			$ard = array("'",'"',"\n");
			$art = array("\'",'\"',"");
			
			$values['title_vo'] 		= str_replace($ard , $art, $this->input->post('title'));
			$values['comment_vo'] 	= str_replace($ard , $art, $this->input->post('comment'));
			$values['types_vo']  		= $this->input->post('types');
			$values['show_vo']  		= $this->input->post('show');
			if($this->pmod->insert("vote",$values))
			{// lay id cua ban tin moi them
				$this->pre_message = "Thêm mới thành công!";
				redirect('vote_content/add/'.$this->db->insert_id(), 'refresh');
			}
			else $this->pre_message = "Kiểm tra lại thông tin nhập vào!";
		}
		$data['op_type'] = $this->config->item('op_type');
		// get the previous processing result into this front page
		$data['message'] = $this->pre_message;
		$data['heading'] = "Manage ".$this->mod;
		$this->view_page =  $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function edit()
	{
		$id = empty($_POST['id']) ? (int)$this->uri->segment(3) : (int)$_POST['id'];
		//
		$data['id'] = $id;
		//kiem tra neu nhu submit
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('comment', 'Mô tả', 'trim|min_length[5]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('types', 'Loại câu hỏi', 'trim|required|exact_length[1]|xss_clean');
		$this->form_validation->set_rules('id', 'Mã', 'trim|required|max_length[11]|xss_clean');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p >', '</p>');
			$this->pre_message = validation_errors();
		}
		else
		{
			// replace " , '
			$ard = array("'",'"',"\n");
			$art = array("\'",'\"',"");

			$values['id_vo'] 			= $this->input->post('id');
			$values['title_vo'] 		= str_replace($ard , $art, $this->input->post('title'));
			$values['comment_vo'] 		= str_replace($ard , $art, $this->input->post('comment'));
			$values['types_vo']  		= $this->input->post('types');
			$values['show_vo']  		= $this->input->post('show');
			if($this->pmod->update($values))
			{
				$this->pre_message = "Hiệu chỉnh thành công!";
			}
			else $this->pre_message = "Kiểm tra lại dữ liệu nhập!";
		}
		$rs = $this->pmod->select("",$id);
		if($rs)
		{
			$row = $rs->row();
			$data['title'] = $row->title_vo;
			$data['comment'] = $row->comment_vo;
			$data['types'] = $row->types_vo;
			$data['show'] = $row->show_vo;
		}
		else
		{
			redirect($this->mod.'/lists/');
		}
		//
		$data['op_type'] = $this->config->item('op_type');
		// get the previous processing result into this front page
		$data['message'] = $this->pre_message;
		$data['heading'] = "Manage ".$this->mod;
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function del()
	{// delete a news
		//Lay id cua ban tin
		$id = (int)$this->uri->segment(3);
		$page = (int)$this->uri->segment(4);
		//
		if ($id){
			if($this->pmod->delete($id)){
				$this->pre_message = "Xóa thành công";
				redirect($this->mod.'/lists/'.$page);
			}else $this->pre_message = "Xóa chưa được, vui lòng thử lại !";
		}
	}
	function dels()
	{// delete a news
		//Lay id cua ban tin
		if(!empty($_POST['btn_submit']) && !empty($_POST['ar_id']))
		{
			$page = (int)$_POST['page'];
			$wid = $_POST['ar_id'];
			for($i = 0; $i < sizeof($wid); $i ++)
			{
				if ($wid[$i])
				{
					if($this->pmod->delete($wid[$i]))
						$this->pre_message = "Đã xóa!";
					else
						$this->pre_message = "Chưa xóa được, vui lòng kiểm tra lại dữ liệu!";
				}
			}
			redirect($this->mod.'/lists');
		}
		else
		{
			redirect($this->mod.'/lists');
		}
	}

	function search()
	{// delete a news
		//Lay id cua ban tin
		$key = $this->input->post('txt_name');
		$id = $this->input->post('txt_id');
		
		$key = $this->input->xss_clean($key);
		$id = $this->input->xss_clean($id);

		$ard=array("-","'",'"',"\n");
		$art=array('','','','');
		
		$key = str_replace($ard , $art, $key);
		$id = str_replace($ard , $art, $id);
		
		$rs = $this->pmod->search($key, $id);
		if(!$rs) 
		{
			echo 'Không tìm thấy dữ liệu!';
			return;
		}
		// get vote_content
		$array_ques = array();
		foreach($rs->result() as $row){
			$id_ques = $row->id_vo;	
			array_push($array_ques, $id_ques);
		}
		$data['db_ans'] = $this->pmod->select_vote_contents($array_ques);

		$data['op_type'] = $this->config->item('op_type');
		$data['db'] = $rs;
		$this->load->vars($data);
		$this->load->view($this->view_dir.'search');
	}
}
?>