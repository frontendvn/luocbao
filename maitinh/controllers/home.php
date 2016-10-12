<?php
class home extends Controller {
	var $mod = "home";
	
	function home()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);
		$this->view_dir = $this->config->item('view_dir');
		$this->resource_dir = $this->config->item('resource_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'index';
		// load necessary helpers
		$this->pre_message = "";
		$this->load->helper('text');
		$this->load->library('captcha_lib');
	}
	// default page
	function index()//
	{	
		if($this->redux_auth->logged_in())redirect('welcome');
		$data['heading'] 		= "Home";
		$data['captcha'] = $this->captcha_lib->show();
		$this->load->vars($data);
		$this->view_page = $this->view_dir.'login';
		$this->load->view($this->view_page);
	}
	
	function login()
	{
	    if(	$this->redux_auth->logged_in())
		{
			if($this->session->userdata('previous_url'))
				redirect($this->session->userdata('previous_url'));
			redirect('welcome');
		}
		
		$this->form_validation->set_rules('email', 'username', 'required|trim|xss_clean');
		//$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		$this->form_validation->set_rules('captcha', 'Mã xác nhận', 'trim|exact_length[5]|required|xss_clean');
		
		if ($this->form_validation->run() == false)
		{
			$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			$this->session->set_flashdata('message', validation_errors());
			redirect($this->mod);
		}
		else
		{
			if(! $this->captcha_lib->check($this->input->post('captcha')))	
			{
				$this->pre_message =  'Mã xác nhận chưa đúng!';
				$this->session->set_flashdata('message', $this->pre_message);
				redirect($this->mod);
			}
			
			$email    = $this->db->escape_str($this->input->post('email'));
			$password = $this->db->escape_str($this->input->post('password'));
			$login = $this->redux_auth->login($email, $password);
			switch($login)
			{
				case 1: 
					$this->session->set_flashdata('message', '<p class="error">Tài khoản chưa được kích hoạt!</p>');
					redirect($this->mod);
				break;
				case 2: 
					redirect($this->mod.'/login');
				break;
				default:
					$this->session->set_flashdata('message', '<p class="error">Dữ liệu chưa chính xác!</p>');
					redirect($this->mod);
			}
		}
	}
	function logout()
	{
		$this->cpanel_lib->logout();
	}
	/**
	 * forgotten password
	 *
	 * @return void
	 * @author Mathew
	 **/
	function forgotten_password()
	{
		echo "Password recover alert, your IP is logged";
		/*
	    $this->form_validation->set_rules('email', 'Email Address', 'required|trim|xss_clean');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
			$data['message'] = $this->pre_message;
			$data['controller_title'] = '';
			$data['function_title'] = "Forgotten password";
			$data['heading']  = $this->config->item('page_title');
			$this->load->view($this->view_dir.'forgotten_password', $data);
	    }
	    else
	    {
	        $email = $this->input->post('email');
			$forgotten = $this->redux_auth->forgotten_password($email);
	
			if ($forgotten)
			{
				$this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
				redirect($this->mod.'/forgotten_password');
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
				redirect($this->mod.'/forgotten_password');
			}
	    }
			*/
	}
	
	/**
	 * forgotten_password_complete
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete()
	{
	    $code = $this->uri->segment(3);
		$code = $this->input->xss_clean($code);
		$forgotten = $this->redux_auth->forgotten_password_complete($code);
			
		if ($forgotten)
		{
			$this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
			redirect($this->mod);
		}
		else
		{
			$this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
			redirect($this->mod.'/forgotten_password');
		}
		
		/*$this->form_validation->set_rules('code', 'Verification Code', 'required|trim|xss_clean');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
			$data['message'] = $this->pre_message;
			$data['controller_title'] = '';
			$data['function_title'] = "Forgotten password complete";
			$data['heading']  = $this->config->item('page_title');
			$this->load->view($this->view_dir.'forgotten_password_complete', $data);
	    }
	    else
	    {
	        $code = $this->input->post('code');
			$forgotten = $this->redux_auth->forgotten_password_complete($code);
				
			if ($forgotten)
			{
				$this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
				redirect($this->mod.'/forgotten_password_complete');
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
				redirect($this->mod.'/forgotten_password_complete');
			}
	    }*/
	}
	
	function swapcaptcha()
	{
		echo $this->captcha_lib->show();
	}

}
/* End of file home.php */
/* Location: ./crm/controllers/home.php */