<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class sendmail extends Controller {
	var $mod = "sendmail";
	function sendmail()
	{
		parent::Controller();	
		$this->load->config('config_'.$this->mod);
		//
		$this->view_dir = $this->mod.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'index';
		// select page layout
		$this->view_container = 'container';
		// init feedback for user's actions
		$this->default_param_uri =  (int)$this->config->item('default_param_uri');
		$this->pre_message = "";
		// load necessary libraries
		$this->load->helper(array('file', 'showIMG', 'show_vote'));
		$this->load->library(array('captcha_lib','form_validation'));
	}
	
	function index()
	{
		
		$id_text = $this->uri->segment(4-$this->default_param_uri);
		$id_cattext = $this->uri->segment(3-$this->default_param_uri);
		if(!empty($_POST['btn_nhanxet'])){
			$this->form_validation->set_rules('nguoigui', "Tên người gửi","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('email_gui', "Email gửi",'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('nguoinhan', "Tên người nhận","trim|required|max_length[255]|xss_clean");
			$this->form_validation->set_rules('email_nhan', "Email nhận",'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('noidung',  "Nội dung","trim|required|min_length[5]|max_length[500]|xss_clean");
		
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				$this->pre_message .= validation_errors();
			}
			else
			{
				
				$values['nguoigui'] 		= $this->input->post('nguoigui');
				$values['email_gui'] 		= $this->input->post('email_gui');
				$values['nguoinhan'] 		= $this->input->post('nguoinhan');
				$values['email_nhan'] 		= $this->input->post('email_nhan');
				$values['noidung'] 			= $this->input->post('noidung');
				
				$this->load->library('email');
			
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$config['protocol'] = 'smtp';
				$config['charset']  = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['priority'] = 1;
				
				$config['smtp_host'] = 'mail.23vn.com';
				$config['smtp_user'] = 'client+23vn.com';
				$config['smtp_pass'] = 'vn23client';
				$this->email->initialize($config);
					
				$this->email->from($values['email_gui'], $values['nguoigui']);
				$this->email->to($values['email_nhan'], $values['nguoinhan']);
				
				$this->email->subject("Gửi nội dung bài viết cho bạn bè");
				
				$email_content = $values['noidung'].'<br>';
				$email_content .= anchor($this->mod.'/detail/'.$id_cattext.'/'.$id_text,$id_text);
				$email_content .= "<br><strong>Trình duyệt:</strong> ".$_SERVER['HTTP_USER_AGENT']." <br\>";
				$email_content .= "<strong>IP:</strong> ".$_SERVER['HTTP_HOST']." <br\>";
				
				$this->email->message($email_content);
				$this->email->send();//echo $this->email->print_debugger();
				$this->pre_message .= "Gửi thành công";
			}
		}
		/*****************************/
		$data['msg'] 	= $this->pre_message;
		$data['heading'] = $data['description'] = "Lược báo - Chọn tin nhanh - Cập nhật sớm";
		$this->view_page = $this->view_dir.'sendmail';
		$this->load->vars($data);
		$this->load->view($this->view_page);
	}
}

?>