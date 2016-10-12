<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */
 
/**
* Redux Authentication 2
*/
class redux_auth
{
	/**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;
	
	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
		$this->ci =& get_instance();
		$config['mailtype'] = 'html';
		$this->ci->load->library('email', $config);
	}
	/**
	 * Change password.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
        return $this->ci->member_model->change_password($identity, $old, $new);
	}

	/**
	 * login
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function login($identity, $password)
	{
		return $this->ci->member_model->login($identity, $password);
	}
	
	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($info=array())
	{
	    $email_activation = $this->ci->config->item('email_activation');
	    $email_folder     = $this->ci->config->item('email_templates');
			$username_column	= $this->ci->config->item('username');
			$password_column	= $this->ci->config->item('password');
			$email_column			= $this->ci->config->item('email');

			if (!$email_activation)
			{
				return $this->ci->member_model->register($info);
			}
			else
			{
				$register = $this->ci->member_model->register($info);
            
				if (!$register) { return false; }
	
				$deactivate = $this->ci->member_model->deactivate($info[$username_column]);

				if (!$deactivate){ return false; }

				$activation_code = $this->ci->member_model->activation_code;
				//
				$data = array('username' => $info[$username_column],
										'password'   => $info[$password_column],
										'email'      => $info[$email_column],
										'activation' => $activation_code);
				//
				$from_email = $this->ci->config->item('contact_email');
				$from_name 	= "Admin";
				$subject 		= "Đăng ký tài khoản";
				$to_email 	= $info[$email_column];
				$message = $this->ci->load->view($email_folder.'activation', $data, true);
				
				$this->email->from($from_email, $from_name);
				$this->email->to($to_email);
				$this->email->reply_to($from_email, $from_name);
				$this->email->subject($subject);	
				$this->email->message($message);					
				//echo $this->email->print_debugger();
				return $this->email->send(); 
			}
	}
	/**
	 * Activate user.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($code)
	{
		return $this->ci->member_model->activate($code);
	}
	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
	    $identity = $this->ci->config->item('identity');
			$this->ci->session->unset_userdata($identity);
			$this->ci->session->sess_destroy();
	}
	
	/**
	 * logged_in
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logged_in()
	{
	    $identity = $this->ci->config->item('identity');
			return ($this->ci->session->userdata($identity)) ? true : false;
	}
	
	/**
	 * forgotten password feature
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password($email)
	{
		$forgotten_password = $this->ci->member_model->forgotten_password($email);
		if ($forgotten_password)
		{

			$data = array('identity'                => $this->ci->member_model->identity,
    			          'forgotten_password_code' => $this->ci->member_model->forgotten_password_code);
			//echo $data['forgotten_password_code'];
                
			$message = $this->ci->load->view($this->ci->config->item('email_templates').'forgotten_password', $data, true);
				
			$this->ci->email->clear();
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from($this->ci->config->item('contact_email'), 'Admin');
			$this->ci->email->to($email);
			$this->ci->email->subject('Email xác nhận quên mật khẩu');
			$this->ci->email->message($message);
			$this->ci->email->send();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code)
	{
			$email_column		= $this->ci->config->item('email');
			$forgotten_password_complete = $this->ci->member_model->forgotten_password_complete($code);
	
			if ($forgotten_password_complete)
			{
				$identity = $this->ci->member_model->identity;
				
				$profile = $this->ci->member_model->profile($identity);
				
				$data = array('identity'    => $identity,
									 		'new_password' => $this->ci->member_model->new_password);
							
				$message = $this->ci->load->view($this->ci->config->item('email_templates').'new_password', $data, true);
					
				$this->ci->email->clear();
				$this->ci->email->set_newline("\r\n");
				$this->ci->email->from($this->ci->config->item('contact_email'), 'Admin');
				$this->ci->email->to($profile->$email_column);
				$this->ci->email->subject('Mật khẩu mới');
				$this->ci->email->message($message);
				$this->ci->email->send();
				//echo "Thanh cong".$data['new_password'];
				return true;
			}
			else
			{
				return false;
			}
	}
	/**
	 * Profile
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function profile()
	{
	    $session  = $this->ci->config->item('identity');
	    $identity = $this->ci->session->userdata($session);
	    return $this->ci->member_model->profile($identity);
	}
	
}