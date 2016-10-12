<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class comment extends Controller {
	var $mod = "comment";
	function comment()
	{
		parent::Controller();	
		//
		// init feedback for user's actions
		$this->default_param_uri =  (int)$this->config->item('default_param_uri');
		$this->pre_message = "";
		// load necessary libraries
		$this->load->library(array('captcha_lib','form_validation'));
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function index()//6-8-2010
	{
		if(!empty($_POST['btn_nhanxet'])){
			$this->form_validation->set_rules('id_cattext', "Chủ đề","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('id_text', "Tiêu đề","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('fullname', "Tên bạn","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('email', "Email",'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('noidung',  "Nội dung","trim|required|min_length[5]|max_length[500]|xss_clean");
			$this->form_validation->set_rules('captcha', "mã xác nhận",'trim|exact_length[2]|required|xss_clean');
		
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				if(! $this->captcha_lib->check($this->input->post('captcha')))	
				{
					$this->pre_message .=  'Mã xác nhận chưa đúng!';
				}
				else
				{
					$values['fullname'] 	= $this->input->post('fullname');
					$values['email'] 		= $this->input->post('email');
					$values['content'] 		= $this->input->post('noidung');
					$values['id_text'] 		= $this->input->post('id_text');
					$values['id_news'] 		= $this->input->post('id_news');
					$values['comm_time'] 	= time();
					if($this->mmod->insert_comment($values)){
						$this->pre_message .=  'Đã lưu!';
					}else $this->pre_message .=  'Bạn đã tham gia bình luận cho bản tin này rồi.';
				}
			}
		}
		$this->session->set_flashdata('message', $this->pre_message);
		$this->session->unset_userdata('ss_keyword');
		redirect('news/'.$this->input->post('id_cattext').'/'.$this->input->post('id_text'));
	}
}

?>