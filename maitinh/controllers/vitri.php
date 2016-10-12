<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class vitri extends Controller {
	var $mod = "vitri";
	function vitri ()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		$this->view_dir = $this->config->item('view_dir');
		$this->view_page =  $this->view_dir.'add';
		$this->view_container = 'adm_container';
		$this->resource_dir = $this->config->item('resource_dir');
		$this->temp_dir = $this->config->item('temp_dir');
		$this->pre_message = "";$this->vitri = array();
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
		$this->add();
	}
	
	function lists($fn='',$id=0)
	{
		$show = $this->pmod->show();
		$functarget = empty($fn) ? $this->uri->segment(2) :trim($fn);;
		$num_rows = $show?$show->num_rows():0;
		//
		$data['num_rows'] = $num_rows;
		if($num_rows){
			$data['db'] = $show;
			$total_rows = $num_rows;
			$uri_segment= 4;
			$config['per_page'] = $this->config->item('item_perpage');			
			$config['num_links'] = $this->config->item('num_links');
			$config['cur_tag_open'] = '<span style="font-size:13px; color:#666666;"> ';
			$config['cur_tag_close'] = '</span>';
	
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
			$ar_vt = array();
			for($idx = $firstitem; $idx < $lastitem; $idx++){
				$row = $show->row($idx); 
				$id_vt = $row->id_vt;	
				array_push($ar_vt, $id_vt);
			}
			$data['db_qc'] = $this->pmod->select_qc($ar_vt);
		}
		$data['message'] = $this->pre_message;	
		return $data;
		
	}

	function add()	
	{
		$this->form_validation->set_rules('ten_vt', "Tiêu đề","trim|required|max_length[255]|xss_clean");
		$this->form_validation->set_rules('ngang', "Chiều ngang","trim|required|numeric|max_length[4]|xss_clean");
		$this->form_validation->set_rules('doc', "Chiều cao","trim|required|numeric|max_length[4]|xss_clean");
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p>', '</p>');
			$this->pre_message .= validation_errors();
		}
		else
		{

			$values['ten_vt'] = trim($this->input->post('ten_vt'));
			$values['ngaytao_vt']   =  time();
			$values['ngang'] 	= (int)$this->input->post('ngang')?(int)$this->input->post('ngang'):300;
			$values['doc'] 		= (int)$this->input->post('doc')?(int)$this->input->post('doc'):100;
			if(!$this->pmod->new_vitri_check($values['ten_vt']))
			{
				$this->db->insert('vitri',$values);
				$this->pre_message .= "Thêm mới thành công!";
			}
			else $this->pre_message .= "Lỗi thêm mới: Tên vị trí này đã có rồi!";
		}	
		/***********************/
		$data ['message']  = $this->pre_message;
		$this->load->vars(array_merge($this->lists('add'),$data));
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function edit()
	{
		$id = isset($_POST['id'])?(int)$_POST['id'] : (int)$this->uri->segment(3);
		if(!empty($_POST['save']))
		{ 
			$this->form_validation->set_rules('ten_vt', "Tiêu đề","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('ngang', "Chiều ngang","trim|required|numeric|max_length[4]|xss_clean");
			$this->form_validation->set_rules('doc', "Chiều cao","trim|required|numeric|max_length[4]|xss_clean");
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				$values['id_vt'] 	= $id;
				$values['ten_vt'] 	= trim($this->input->post('ten_vt'));
				$values['ngang'] 	= (int)$this->input->post('ngang')?(int)$this->input->post('ngang'):300;
				$values['doc'] 		= (int)$this->input->post('doc')?(int)$this->input->post('doc'):100;
				if(!$this->pmod->new_vitri_check($values['ten_vt'],$id))
				{
					$this->pmod->update($values);
					$this->pre_message .= "Hiệu chỉnh thành công!";
				}
				else $this->pre_message .= "Lỗi: không thể cập nhật dữ liệu!";
			}	
		}
		$show = $this->pmod->show($id);
		if($show->num_rows()>0)
		{
			$row = $show->row_array();
			$data['id'] = $row['id_vt'];
			$data['ten_vt'] = $row['ten_vt'];
			$data['ngang'] 	= $row['ngang'];
			$data['doc'] 	= $row['doc'];
		}else redirect($this->mod);
		
		/***********************/
		$data['list'] = $this->pmod->select_list_qc($id);
		$data['message']  = $this->pre_message;
		$this->view_page =  $this->view_dir.'edit';
		$this->load->vars(array_merge($this->lists('edit',$id),$data));
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	function del()
	{
		$id = (int)$this->uri->segment(3);
		if($id)	$this->pmod->delete($id);
		redirect($this->mod);
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
						$this->pre_message = "Lỗi: không thể cập nhật dữ liệu!";
					}
				}
			}
		}
		redirect($this->mod);
	}
	function sorts()
	{
		$list1 = $this->input->post('list1');
		
		$list1 = $this->input->xss_clean($list1);
		$return = 1;
		if(!empty($list1)){
			$exp = explode(',',$list1);
			$n = count($exp);
			
			for($idx = 0; $idx < $n; $idx++){
				$qc_id =$exp[$idx];
				if(!empty($qc_id)){
					$val['id'] = $qc_id;
					$val['weight'] = $idx+1;
					if(! $this->pmod->update_qc($val))
						$return = 0;
				} 
			}
		}
	}
}
?>