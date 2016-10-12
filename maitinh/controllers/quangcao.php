<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class quangcao extends Controller {
	var $mod = "quangcao";
	function quangcao ()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		$this->view_dir = $this->config->item('view_dir');
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
		$this->load->helper(array('showIMG','file'));
	}
	// default page
	function index()
	{
		$this->lists();
	}

	function save()//17-8-2010
	{
		$show_vitri = $this->pmod->show_vitri();
		$config_file = '../cfg/quangcao.js';
		if(is_object($show_vitri) && $show_vitri->num_rows()>0){
			$wr ="// ".date('H:i:s A d/m/Y ',time());
			//$wr .="\n//  hinh,link,mo ta,so giay hien thi (millisec)";
			foreach($show_vitri->result() as $row){
				$show 		= $this->pmod->show_qc($row->id_vt);
				$speed = "\n var speed".$row->ten_vt."=new Array(";
				$images = "\n var images".$row->ten_vt."=new Array(";
				$types = "\n var types".$row->ten_vt."=new Array(";
				$links = "\n var links".$row->ten_vt."=new Array(";
				$cat = "\n var cat".$row->ten_vt."=new Array(";
				$str_speed ="";
				$str_images ="";
				$str_types ="";
				$str_links ="";
				$str_cat ="";
				
				if(is_object($show) && $show->num_rows()>0)
				{
					
					foreach($show->result() as $qc)
					{
						$str_speed .=$qc->tg_hienthi.",";
						$str_images .="\"".$qc->image."\",";
						$str_types .="\"".$qc->types."\",";
						$str_links .="\"".$qc->id."\",";
						$str_cat .="\"".$qc->id_cattext."\",";
					}
				}else 	$this->pre_message = 'Không thấy dữ liệu';
				$speed .=substr($str_speed,0,-1).");";
				$images .=substr($str_images,0,-1).");";
				$types .=substr($str_types,0,-1).");";
				$links .=substr($str_links,0,-1).");";
				$cat .=substr($str_cat,0,-1).");";
				$wr .=$speed .$images .$types .$links.$cat;
				$wr .= "\n var ".$row->ten_vt."=new Array(speed".$row->ten_vt.",images".$row->ten_vt.",types".$row->ten_vt.",links".$row->ten_vt.",cat".$row->ten_vt.");\n";
			}

			if (write_file($config_file, $wr))	$this->pre_message = 'Đã ghi file: ../cfg/quangcao.js ';
			else $this->pre_message =  "Error: cant not write file!";
		}
		$this->session->set_flashdata('message', $this->pre_message);
		redirect($this->mod);
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
	function add()	//19-8-2010
	{
		$this->form_validation->set_rules('ten', "Tiêu đề","trim|required|max_length[255]|xss_clean");
		$this->form_validation->set_rules('link', "Link","trim|required|prep_url|max_length[255]|xss_clean");
		$this->form_validation->set_rules('types',  "Loại","trim|required|exact_length[1]|xss_clean");
		$this->form_validation->set_rules('vitri',  "Vị trí","trim|required|numeric|max_length[11]|xss_clean");
		//$this->form_validation->set_rules('id_cattext',  "Chủ đề","trim|max_length[255]|xss_clean");
		$this->form_validation->set_rules('id_kh',  "Khách hàng","trim|numeric|max_length[11]|xss_clean");
		$this->form_validation->set_rules('ngay_hethan',  "Ngày hết hạn","trim|exact_length[10]|xss_clean");
		$this->form_validation->set_rules('link_img',  "Link hình/flash","trim|max_length[255]|xss_clean");
		$this->form_validation->set_rules('shown',  "Trạng thái","trim|required|exact_length[1]|xss_clean");
		$this->form_validation->set_rules('tg_hienthi',  "Số giây hiển thị","trim|required|min_length[4]|max_length[5]|ss_clean");
		$this->form_validation->set_rules('temp',  "Quảng cáo mặc định","trim|numeric|ss_clean");
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p>', '</p>');
			$this->pre_message .= validation_errors();
		}
		else
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$config['upload_path']   = $this->config->item('img_upload');
				$config['allowed_types'] = $this->config->item('img_type');
				$config['max_size']	     = $this->config->item('img_size');
				$config['max_width']     = $this->config->item('img_width');
				$config['max_height']    = $this->config->item('img_height');
				//$config['encrypt_name']  = $this->config->item('img_name_encrypt');
							
				$this->load->library('upload', $config);
				if ( !$this->upload->do_upload('userfile'))
				{
					$this->pre_message .=  $this->upload->display_errors();
				}
				else
				{
					//get file upload
					$result = $this->upload->data();
					$image    = substr($config['upload_path'], 3).$result['file_name'];
				}
			}

			$ngay_hethan = $this->input->post('ngay_hethan');
			if($ngay_hethan)
			{
				$fmon = (int)substr($ngay_hethan,3,2);
				$fday = (int)substr($ngay_hethan,0,2);
				$fyear = (int)substr($ngay_hethan,6,4);
				$time = mktime(0,0,0,$fmon,$fday,$fyear);
			}
			else
				$time = 0;

			$values['image']    	= empty($image)?$this->input->post('link_img'):$image;
			$values['links'] 		= $this->input->post('link');
			$values['types'] 		= $this->input->post('types');
			$values['id_vitri'] 	= $this->input->post('vitri');
			$values['id_kh'] 		= (int)$this->input->post('temp')?0:$this->input->post('id_kh');
			$values['ngay_dangky'] 	= time();
			$values['ngay_hethan']  =  $time;
			$values['shown'] 		= $this->input->post('shown');
			$values['tg_hienthi'] 	= (int)$this->input->post('tg_hienthi')?(int)$this->input->post('tg_hienthi'):2000;
			//$values['id_cattext'] 	= $this->input->post('id_cattext');
			$values['temp'] 		= (int)$this->input->post('temp')?(int)$this->input->post('temp'):0;
			$act='';
			if( !empty($_POST['id_cattext'])){
				$num_tags = sizeof($_POST['id_cattext']); 
				for($i=0;$i<$num_tags;$i++)
				{
					if(!empty($_POST['id_cattext'][$i]))
					{
						$values['id_cattext'] 	= $_POST['id_cattext'][$i];
						$values['ten'] 			= $this->input->post('ten').'-'.$values['id_cattext'];
						$this->pmod->insert($values);
						$act=TRUE;
					}
				}
				
			}else{
				$values['ten'] 			= $this->input->post('ten');
				$this->pmod->insert($values);
				$act=TRUE;
			}
			if($act)	$this->pre_message .= "Thêm mới quảng cáo thành công!";
			else $this->pre_message .= "Lỗi: Không thể cập nhật dữ liệu!";
		}	
		/***********************/
		$vitri = isset($_POST['vitri'])? $this->input->post('vitri') : (int)$this->uri->segment(3);
		$data['vitri'] = $this->pmod->select_vitri('vitri', $vitri);
		//$data['chude'] = $this->pmod->select_chude('id_cattext');
		$data['select_kh'] = $this->pmod->select_khachhang('id_kh', $this->input->post('id_kh'));
		$data ['message']  = $this->pre_message;
		$this->view_page = $this->view_dir.'add';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function edit()//17-8-2010
	{
		$id = isset($_POST['id'])?(int)$_POST['id'] : (int)$this->uri->segment(3);
		if(!empty($_POST['save']))
		{ 
			$this->form_validation->set_rules('ten', "Tiêu đề","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('link', "Link","trim|required|prep_url|max_length[255]|xss_clean");
			$this->form_validation->set_rules('types',  "Loại","trim|required|exact_length[1]|xss_clean");
			$this->form_validation->set_rules('vitri',  "Vị trí","trim|required|numeric|max_length[11]|xss_clean");
			$this->form_validation->set_rules('id_cattext',  "Chủ đề","trim|max_length[255]|xss_clean");
			$this->form_validation->set_rules('id_kh',  "Khách hàng","trim|numeric|max_length[11]|xss_clean");
			$this->form_validation->set_rules('ngay_hethan',  "Ngày hết hạn","trim|exact_length[10]|xss_clean");
			$this->form_validation->set_rules('link_img',  "Link hình/flash","trim|max_length[255]|xss_clean");
			$this->form_validation->set_rules('shown',  "Trạng thái","trim|required|exact_length[1]|xss_clean");
			$this->form_validation->set_rules('tg_hienthi',  "Số giây hiển thị","trim|required|min_length[4]|max_length[5]|ss_clean");
			$this->form_validation->set_rules('temp',  "Quảng cáo mặc định","trim|numeric|ss_clean");
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				if(is_uploaded_file($_FILES['userfile']['tmp_name']))
				{
					$config['upload_path']   = $this->config->item('img_upload');
					$config['allowed_types'] = $this->config->item('img_type');
					$config['max_size']	     = $this->config->item('img_size');
					$config['max_width']     = $this->config->item('img_width');
					$config['max_height']    = $this->config->item('img_height');
					//$config['encrypt_name']  = $this->config->item('img_name_encrypt');
								
					$this->load->library('upload', $config);
					if ( !$this->upload->do_upload())
					{
						$this->pre_message .=  $this->upload->display_errors();
					}
					else
					{
						//get file upload
						$result = $this->upload->data();
						$image    = substr($config['upload_path'], 3).$result['file_name'];
					}
				}
				
				
				$ngay_hethan = $this->input->post('ngay_hethan');
				if($ngay_hethan)
				{
					$fmon = (int)substr($ngay_hethan,3,2);
					$fday = (int)substr($ngay_hethan,0,2);
					$fyear = (int)substr($ngay_hethan,6,4);
					$time = mktime(0,0,0,$fmon,$fday,$fyear);
				}
				else
					$time = 0;
				
				if(empty($image))
				{
					if(!empty($_POST['link_img']))
						$values['image']    = $this->input->post('link_img');
				}
				else
				{
					$values['image']    = $image;
				}
				$values['id'] 			= $id;
				$values['ten'] 			= $this->input->post('ten');
				$values['links'] 		= $this->input->post('link');
				$values['types'] 		= $this->input->post('types');
				$values['id_vitri'] 	= $this->input->post('vitri');
				$values['id_kh'] 		= (int)$this->input->post('temp')?0:$this->input->post('id_kh');
				$values['ngay_hethan']  =  $time;
				$values['shown'] 		= $this->input->post('shown');
				$values['tg_hienthi'] 	= (int)$this->input->post('tg_hienthi')?(int)$this->input->post('tg_hienthi'):2000;
				$values['id_cattext'] 	= $this->input->post('id_cattext');
				$values['temp'] 		= (int)$this->input->post('temp')?(int)$this->input->post('temp'):0;
				
				if($this->pmod->update($values))
					$this->pre_message .= "Hiệu chỉnh thành công!";
				else $this->pre_message .= "Lỗi: không thể cập nhật dữ liệu!";
			}	
		}
		$show = $this->pmod->show($id);
		if($show->num_rows()>0)
		{
			$row 					= $show->row_array();
			$data['id'] 			= $row['id'];
			$data['ten'] 			= $row['ten'];
			$data['link'] 			= $row['links'];
			$data['image'] 			= $row['image'];
			$data['types'] 			= $row['types'];
			$data['id_vitri'] 		= $row['id_vitri'];
			$data['id_kh'] 			= $row['id_kh'];
			$data['ngay_hethan'] 	= $row['ngay_hethan'];
			$data['shown'] 			= $row['shown'];
			$data['tg_hienthi'] 	= $row['tg_hienthi'];
			$data['id_cattext'] 	= $row['id_cattext'];
			$data['temp'] 			= $row['temp'];
		}else redirect($this->mod);
		
		/***********************/
		$data['vitri'] = $this->pmod->select_vitri('vitri', $data['id_vitri']);
		$data['chude'] = $this->pmod->select_chude('id_cattext', $data['id_cattext']);
		$data['select_kh'] = $this->pmod->select_khachhang('id_kh', $data['id_kh']);
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
	function temp()//17-8-2010
	{
		$config_file = '../cfg/quangcao_mau.php';
		$show_vitri = $this->pmod->show_vitri_mau();
		if(is_object($show_vitri) && $show_vitri->num_rows()>0){
			$wr ="// ".date('H:i:s A d/m/Y ',time());
			$strConfig = '<?php 	
			/**
			 * '.date("d-m-Y G:i:s").'.
			 **/';
			foreach($show_vitri->result() as $row){
				$show 		= $this->pmod->show_qc_mau($row->id_vt);
				
				if(is_object($show) && $show->num_rows()>0)
				{
					
					$qc = $show->row();
					$strConfig .= "\n\$config['qc_".$row->ten_vt."'] = array('".$qc->image."','".$qc->types."',".$qc->id.");";
					
				}else 	$this->pre_message = 'Không thấy dữ liệu';
			}
			$strConfig .= '?>';
			if (write_file($config_file, $strConfig))	$this->pre_message = 'Đã ghi file: ../cfg/quangcao_mau.php ';
			else $this->pre_message =  "Error: cant not write file!";
		}
		$this->session->set_flashdata('message', $this->pre_message);
		redirect($this->mod);
	
	}
}
?>