<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Member extends Controller {
	var $mod = "member";
	function member()
	{	
		parent::Controller();
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		$this->content = 'login';
		// init feedback for user's actions
		$this->pre_message = "";
	  	$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		//
		$this->profile = $this->cpanel_lib->query_main;
		// left menu
		$this->menu_title = $this->config->item('menu_title');
		$this->menu = $this->config->item('menu');
	}
	
	function index()
	{//
		$this->lists();
	}
	
	function lists()
	{//
		$this->load->model('user_model', 'umod');
		$data['managers'] = $this->umod->select_user_orderby_level();
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Member map";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'lists', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container,$data);
	}

	function create()
	{
		$this->load->model('user_model', 'umod');
			
		if(isset($_POST['btnsubmit']))
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|callback_email_check|xss_clean');
			$this->form_validation->set_rules('username', 'Nickname', 'trim|required|min_length[5]|callback_username_check|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|xss_clean');
			$this->form_validation->set_rules('type_id', 'user type', 'trim|required|max_length[1]|callback_usertype_check|xss_clean');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');
			$this->form_validation->set_rules('time_start','Start time', 'trim|numeric|max_length[2]|xss_clean');
			$this->form_validation->set_rules('time_finish','Finish time', 'trim|numeric|max_length[2]|xss_clean');
			
			if ($this->form_validation->run() == false)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
				$this->pre_message = validation_errors();
			}
			else
			{
				$user['username'] 			= $this->input->post('username');
				$user['email']				= $this->input->post('email');
				$user['password'] 			= $this->input->post('password');
				$user['type_id'] 			= $this->input->post('type_id');
				$user['fullname'] 			= $this->input->post('fullname');
				$user['description'] 		= $this->input->post('description');
				$user['time_start'] 		= $this->input->post('time_start');
				$user['time_finish'] 		= $this->input->post('time_finish');
				$time = time();
				$user['times'] 	= $time;
				//
				$register = $this->redux_auth->register($user);
				if ($register)
				{
						$email_activation = $this->config->item('email_activation');
						if($email_activation)
							$this->pre_message .= "Còn một bước cuối trước khi tài khoản có hiệu lực, bạn cần vào hộp thư ".$user['user_email']." để xác nhận email hợp lệ.";
						else
							$this->pre_message .= "success!";
				}
				else
				{
						$this->pre_message = 'Error: can not write data!';
				}
				$this->session->set_flashdata('message', $this->pre_message);
				redirect($this->mod.'/create');
			}
		}

		$data['option_type'] = $this->umod->create_select_box_groups_chose('type_id', $this->input->post('type_id'), $this->accesslvl);

		$data['message'] = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Create member";
		$data['heading'] = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'register', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function login()
	{
	    if(	$this->redux_auth->logged_in())	redirect($this->mod.'/profile');

		$this->form_validation->set_rules('email', 'username', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
		{
			$data['controller_title'] = $this->menu_title;
			$data['function_title'] = "Login";
			$data['heading']  = $this->config->item('page_title');
			$this->content = $this->load->view($this->view_dir.'login', $data, true);
			$this->view_page =  $this->view_dir.'template';
			$this->load->view($this->content);
		}
		else
		{
			$email    = $this->db->escape_str($this->input->post('email'));
			$password = $this->db->escape_str($this->input->post('password'));
			$login = $this->redux_auth->login($email, $password);
			switch($login)
			{
				case 1: 
					$this->session->set_flashdata('message', '<p class="error">Account is not active!</p>');
					redirect($this->mod.'/login');
				break;
				case 2: 
					if($this->session->userdata('previous_url'))
						redirect($this->session->userdata('previous_url'));
					redirect($this->mod.'/profile');
				break;
				default:
					$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
					redirect($this->mod.'/login');
			}
		}
	}
	
	function logout()
	{
			//$this->redux_auth->logout();
			$this->cpanel_lib->logout();
	}
	
	public function usertype_check($str)
	{
	   	switch($str)
			{
				case 1:	$check_admin = $this->member_model->usertype_check();
						if($check_admin)
						{
							$this->form_validation->set_message('usertype_check', 'You can not create this user type.');
							return false;				
						}
						return true;
				break;
				
				default:	return true;				
			}
	}

	/**
	 * usertype_check_edit
	 *
	 * @return boolean
	 **/
	protected function usertype_check_edit($id, $str)
	{
		switch($str)
		{
			case 1:	$check_admin = $this->member_model->usertype_check_edit_or_del($id);
					if(! $check_admin)
					{
						$this->pre_message = 'You can not select this user type.';
						return false;				
					}
					return true;
			break;

			default:	$check_admin = $this->member_model->usertype_check_edit_or_del($id);
						if($check_admin)
						{
							$this->pre_message = 'You can not select this user type.';
							return false;				
						}
						return true;				
		}
	}
	
	public function email_check($email)
	{
	    if(empty($email)) return true;
			$check = $this->member_model->email_check($email);
	    
	    if ($check)
	    {
	        $this->form_validation->set_message('email_check', "The email $email already exists.");
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}

	protected function email_check_edit($id, $email)
	{
	    if(empty($id)/* || empty($email)*/)return false;
	    if(empty($email)) return true;
	    $check = $this->member_model->email_check_edit($id, $email);
	    
	    if ($check)
	    {
	        $this->pre_message = "The email $email already exists.";
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}

	public function username_check($username)
	{
	    $check = $this->member_model->username_check($username);
	    
	    if ($check)
	    {
	        $this->form_validation->set_message('username_check', "The username $username already exists.");
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}

	protected function username_check_edit($id, $username)
	{
	    if(empty($id) || empty($username))return false;
	    $check = $this->member_model->username_check_edit($id, $username);
	    
	    if ($check)
	    {
	        $this->pre_message = 'The username "'.$username.'" already exists.';
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}
	
	public function change_password()
	{	    
	    $this->form_validation->set_rules('oldpass', 'old password', 'required|trim|xss_clean');
	    $this->form_validation->set_rules('newpass', 'new password', 'required|min_length[5]|matches[newpass_repeat]|trim|xss_clean');
	    $this->form_validation->set_rules('newpass_repeat', 'repeat new password', 'required|min_length[5]|trim|xss_clean');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
			$data['message']  = $this->pre_message;
			$data['controller_title'] = $this->menu_title;
			$data['function_title'] = "Change password";
			$data['heading']  = $this->config->item('page_title');
			$this->content = $this->load->view($this->view_dir.'change_password', $data, true);
	        $this->view_page =  $this->view_dir.'template';
			$this->load->view($this->view_container);
	    }
	    else
	    {
	        $old = $this->input->post('oldpass');
	        $new = $this->input->post('newpass');
	        
	        $change = $this->redux_auth->change_password($this->identity, $old, $new);
		
    		switch($change)
			{
				case 0:
					$this->session->set_flashdata('message', '<p class="error">old password is not correct, try again please!</p>');
					redirect($this->mod.'/change_password','refresh');
					break;
				case 1:
					$this->session->set_flashdata('message', '<p class="error">Data can not write, try again please!</p>');
					redirect($this->mod.'/change_password','refresh');
					break;
				case 2:
					$this->session->set_flashdata('message', '<p class="error">password changed, log in please!</p>');
					$this->logout();
					break;
				default:
					$this->session->set_flashdata('message', '<p class="error">old password is not correct, try again please!</p>');
					redirect($this->mod.'/change_password','refresh');
			}
	    }
	}
	/**
	 * forgotten password
	 *
	 * @return void
	 * @author Mathew
	 **/
	function forgotten_password()
	{
	    $this->form_validation->set_rules('email', 'Email Address', 'required|trim|xss_clean');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
			$data['controller_title'] = $this->menu_title;
			$data['function_title'] = "Forgotten password";
			$data['heading']  = $this->config->item('page_title');
			$this->content = $this->load->view($this->view_dir.'forgotten_password', $data, true);
	        $this->view_page =  $this->view_dir.'template';
			$this->load->view($this->view_container);
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
	}
	
	/**
	 * forgotten_password_complete
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete()
	{
	    $this->form_validation->set_rules('code', 'Verification Code', 'required|trim|xss_clean');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        redirect($this->mod.'/forgotten_password');
	    }
	    else
	    {
	        $code = $this->input->post('code');
			$forgotten = $this->redux_auth->forgotten_password_complete($code);
				
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
	}
	
	/**
	 * del user
	 *
	 * not admin
	 **/
	public function del()
	{//
		$this->load->model('user_model', 'umod');
		$id = (int)$this->uri->segment(3);
		
		if($this->umod->delete_user($id))
		{
			$this->pre_message = "deleted!";
		}else $this->pre_message = "can not delete data, try again please!";
		$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
		redirect($this->mod.'/lists/');
	}
	
	public function _del()
	{//
		$uri = isset($_POST['user_id'])?$_POST['user_id']:(int)$this->uri->segment(3);
		
		$this->form_validation->set_rules('user_id', 'id', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('re_id', 'reid', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run() == false)
		{
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$this->session->set_flashdata('message', validation_errors());
		}
		else
		{
			$id = $this->input->post('user_id');
			$reid = $this->input->post('re_id');
			$this->load->model('user_model','umod');
			$lvl = $this->umod->usertype_check_del($id);
			if($lvl)
			{
				if($lvl==5)
				{
					$this->umod->delete_user($id);
				}
				else// $lvl==4
				{
					if($this->umod->del_user($id, $reid))
					{
						$this->pre_message = "deleted!";
					}else $this->pre_message = "can not delete data, try again please!";
				}
			}else $this->pre_message = "Error: can not delete CEO or manager or teamleader!";
			$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
			redirect($this->mod.'/lists/');
		}
		
		$this->load->model('user_model', 'umod');
		$data['box_all_user'] = $this->umod->create_select_box_all_user('re_id');
		$data['uri'] = $uri;
		$data['message'] = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Member map";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'delete', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container,$data);
	}

	public function edit()
	{
		$this->load->model('user_model', 'umod');
		
		$id = isset($_POST['id'])?(int)$this->input->post('id'):(int)$this->uri->segment(3);
		if(empty($id)) redirect('home');
		//
		$load = array();
		if(empty($_POST))
		{
			$rs = $this->member_model->select_user($id, $this->accesslvl, $this->id);
			if($rs)
			{
				$row = $rs->row();
				$load['fullname'] 	= $row->fullname;
				$load['username'] 	= $row->username;
				$load['password'] 	= $row->password;
				$load['email'] 		= $row->email;
				
				$load['time_start']		= $row->time_start;
				$load['time_finish']	= $row->time_finish;
				$load['description']	= $row->mota;
				$load['code'] 			= $row->code;
				$load['times']			= $row->times;
				$load['type_id'] 		= $row->type_id;
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
				redirect($this->mod,'refresh');
			}
		}
		else
		{
			$this->form_validation->set_rules('id', 'id', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
			$this->form_validation->set_rules('username', 'Nickname', 'trim|required|min_length[5]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]|xss_clean');
			$this->form_validation->set_rules('type_id', 'user type', 'trim|required|max_length[1]|xss_clean');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');
			$this->form_validation->set_rules('time_start','Start time', 'trim|numeric|max_length[2]|xss_clean');
			$this->form_validation->set_rules('time_finish','Finish time', 'trim|numeric|max_length[2]|xss_clean');

			if ($this->form_validation->run() == false)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			}
			else
			{
				$pass = $this->input->post('password');
				$user['id'] 				= $this->input->post('id');
				
				$user['username'] 			= $this->input->post('username');
				$user['password'] 			= $pass=='password'?'':$pass;
				$user['email']				= $this->input->post('email');
				$user['type_id'] 			= $this->input->post('type_id');
				$user['fullname'] 			= $this->input->post('fullname');
				$user['description'] 		= $this->input->post('description');
				$user['time_start'] 		= $this->input->post('time_start');
				$user['time_finish'] 		= $this->input->post('time_finish');

				if($this->usertype_check_edit($user['id'],$user['type_id']))
				{
					if($this->email_check_edit($user['id'],$user['email']))
					{
						if($this->username_check_edit($user['id'],$user['username']))
						{
							// edit db
							if($this->member_model->update_user($user))
							{
								$this->pre_message = 'Updated!';
								
								if($this->id==$user['id']) $this->cpanel_lib->logout();
							}
							else
							{
								$this->pre_message = 'Error: can not write data!';
							}
						}
					}
				}
				//
				$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
				redirect($this->mod.'/edit/'.$user['id']);
			}
		}
	
		$vl_type_id = empty($load['type_id'])?$this->input->post('type_id'):$load['type_id'];
		$data['option_type'] = $this->umod->create_select_box_groups('type_id', $vl_type_id);
		
		$data['id'] = $id;
		$data['message']  = $this->pre_message;
		$data['load'] = $load;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Edit member information ";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'edit', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}

	public function set_status()
	{
		if($this->accesslvl>2 or empty($this->id)) redirect('home');
		
		$id = isset($_POST['id'])?(int)$this->input->post('id'):(int)$this->uri->segment(3);
		if(empty($id)) redirect('home');
		//
		$load = array();
		if(empty($_POST))
		{
			$rs = $this->member_model->select_user($id, $this->accesslvl, $this->id);
			if($rs)
			{
				$row = $rs->row();
				$load['fullname'] 	= $row->fullname;
				$load['username'] 	= $row->username;
				
				$load['activated'] 	= $row->activated;
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
				redirect($this->mod,'refresh');
			}
		}
		else
		{
			$this->form_validation->set_rules('id', 'id', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('username', 'Nickname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('activated', 'activation', 'trim|exact_length[1]|xss_clean');

			if ($this->form_validation->run() == false)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			}
			else
			{
				$user['id'] 		= $this->input->post('id');
				
				$user['activated'] 	= $this->input->post('activated')=='y'?'y':'n';

				// edit db
				$this->load->model('user_model', 'umod');
				if($this->umod->update_lock($user))
				{
					$this->pre_message = 'Updated!';
				}
				else
				{
					$this->pre_message = 'Error: can not write data!';
				}
				//
				$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
				redirect($this->mod.'/set_status/'.$user['id']);
			}
		}
		
		$data['id'] = $id;
		$data['message']  = $this->pre_message;
		$data['load'] = $load;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Active member";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'set_status', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}

	public function view()
	{
		$this->load->model('user_model', 'umod');

		$id = !empty($_POST['view_user'])?(int)$_POST['view_user']:(int)$this->uri->segment(3);
		//
		$info = array();
		$rs = $this->member_model->view_user($id);
		if($rs)
		{
			$row = $rs;
			$info['id'] 	= $row->id;
			$info['fullname'] 	= $row->fullname;
			$info['username'] 	= $row->username;
			$info['email'] 			= $row->email;
			
			$info['activated'] 	= $row->activated;
			$info['description']= $row->mota;
			$info['code'] 			= $row->code;
			$info['times']			= $row->times;
			$info['usertype'] 	= $row->name;
			$info['teamleader'] = $row->teamleader;
			$info['dir_admin'] 	= $row->dir_admin;
		}
		else
		{
			$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
			redirect($this->mod,'refresh');
		}
		$data['select_box'] = $this->umod->select_box_all_user('view_user', $id, "submit");
		$data['select_box_con'] = $this->umod->create_select_box_con('compare_user', '', $this->accesslvl, $this->id);
		$data['message']  = $this->pre_message;
		$data['info'] = $info;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "view member infomation";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'view', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	public function profile()
	{
		// main fields
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$act_code_column	= $this->config->item('activation_code');
		$time_column 		= $this->config->item('register_time');
		$email_column 		= $this->config->item('email');
		// other fields
		$user_columns 		= $this->config->item('columns_users');
		$group_columns		= $this->config->item('columns_groups');
		$option_columns		= $this->config->item('columns_option');
		
		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('description', 'description', 'trim|max_length[5000]|xss_clean');

		if ($this->form_validation->run() == false)
		{
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		}
		else
		{
			$id = $this->id;
			$info['id']						= $id;
			
			$info['fullname'] 				= $this->input->post('fullname');
			$info['email'] 					= $this->input->post('email');
			$info['description'] 			= $this->input->post('description');

			// action db
			if($this->email_check_edit($info['id'],$info['email']))
			{
				if($this->member_model->update_profile($info))
				{
					$this->pre_message = 'Updated!';
				}
				else
				{
					$this->pre_message = 'Error: can not write data!';
				}
			}
			$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
			redirect($this->mod.'/profile');
		}

		$load = array();
		$rs = $this->member_model->profile($this->identity);
		if($rs)
		{
			$row = $rs;
			$load[$user_id_column] 		= $row->$user_id_column;
			$load[$username_column] 	= $row->$username_column;
			$load[$email_column] 		= $row->$email_column;
			
			$load[$act_code_column] 	= $row->$act_code_column;
			$load[$time_column]			= $row->$time_column;

			if (!empty($user_columns))
			{
				foreach ($user_columns as $vl)
				{
					$load[$vl]	= $row->$vl;
				}
			}
			if ($this->config->item('groups') and !empty($group_columns))
			{
				foreach ($group_columns as $vl)
				{
					if($vl=='description') $vl = 'mota';
					$load[$vl]	= $row->$vl;
				}
			}
			
			if ($this->config->item('option') and !empty($option_columns))
			{
				foreach ($option_columns as $vl)
				{
					$load[$vl]	= $row->$vl;
				}
			}
			
		}
		else
		{
			$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
			redirect($this->mod.'/create','refresh');
		}

		$data['load'] = $load;
		$data['message']  = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Edit profile";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'profile', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	
	public function _option()
	{
			$this->form_validation->set_rules('menu', 'menu', 'trim|required|xss_clean');
			$this->form_validation->set_rules('color', 'color', 'trim|required|xss_clean');

			if ($this->form_validation->run() == false)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			}
			else
			{
				$id = $this->id;
				$info['user_id']	= $id;
				$info['content']	= $this->input->post('menu').'~'.$this->input->post('color');
				// action db
				if($this->member_model->update_user_option($info))
				{
					$this->pre_message = 'Updated!';
				}
				else
				{
					$this->pre_message = 'Error: can not write data!';
				}
				$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
			}
			redirect($this->mod.'/profile');
	}
	
	public function assign()
	{
		$this->load->model('user_model', 'umod');
		
		$id = isset($_POST['id'])?(int)$this->input->post('id'):(int)$this->uri->segment(3);
		if(empty($id)) redirect('home');
		//
		$load = array();
		if(empty($_POST['btnsubmit']))
		{
			$rs = $this->member_model->select_user($id, $this->accesslvl, $this->id);
			if($rs)
			{
				$row = $rs->row();
				$load['teamleader'] = $row->teamleader;
				$load['fullname'] 	= $row->fullname;
				$load['type_id'] 		= $row->type_id;
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">Data is not correct!</p>');
				redirect($this->mod,'refresh');
			}
		}
		else
		{
			$this->form_validation->set_rules('id', 'id', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('teamleader', 'team', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[255]|xss_clean');
			$this->form_validation->set_rules('type_id', 'user type', 'trim|required|numeric|xss_clean');

			if ($this->form_validation->run() == false)
			{
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			}
			else
			{
				$user['id'] 			= $this->input->post('id');
				$user['teamleader'] 	= $this->input->post('teamleader');
				$get_admin 	= $this->umod->get_directadmin($user['teamleader']);
				$user['dir_admin'] = $get_admin? $get_admin->dir_admin: 0;
				// edit db
				if($this->umod->update($user))
				{
					$this->pre_message = 'Updated!';
				}
				else
				{
					$this->pre_message = 'Error: can not write data!';
				}
				//
				$this->session->set_flashdata('message', '<p class="error">'.$this->pre_message.'</p>');
				redirect($this->mod.'/assign/'.$user['id']);
			}
		}
	
		$vl_fullname = empty($load['fullname'])?$this->input->post('fullname'):$load['fullname'];
		$vl_type_id = empty($load['type_id'])?$this->input->post('type_id'):$load['type_id'];

		$vl_teamleader = empty($load['teamleader'])?$this->input->post('teamleader'):$load['teamleader'];
		$data['teamleader'] = $this->umod->create_select_box_teamleader_assign('teamleader', $vl_teamleader, $this->accesslvl, $this->id, $vl_type_id);
		
		$data['id'] = $id;
		$data['fullname'] = $vl_fullname;
		$data['type_id'] = $vl_type_id;
		$data['message']  = $this->pre_message;
		$data['load'] = $load;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "Assign";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'assign', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	public function view_log()
	{
		$this->load->model('user_model', 'umod');
		//
		$uid = (int)$this->uri->segment(3);
		if(empty($uid)) redirect($this->mod);
		
		$rs = $this->umod->view_log($uid);
		$data['num_rows'] = $rs?$rs->num_rows():0;
		if($data['num_rows'])
		{
			$data['db'] = $rs;
			$data['namecode'] = $rs->row(0)->fullname.'('.$rs->row(0)->code.')';
		}
		else
		{
			$rs = $this->member_model->view_user($uid);
			if($rs)
				$data['namecode'] = $rs->fullname.'('.$rs->code.')';
			else 
				redirect($this->mod);
		}
		
		$data['uid'] = $uid;
		$data['message']  = $this->pre_message;
		$data['controller_title'] = $this->menu_title;
		$data['function_title'] = "view logs";
		$data['heading']  = $this->config->item('page_title');
		$this->content = $this->load->view($this->view_dir.'view_log', $data, true);
		$this->view_page =  $this->view_dir.'template';
		$this->load->view($this->view_container);
	}
	public function empty_log()// permit CEO
	{
		$this->load->model('user_model', 'umod');
		//
		$uid = (int)$this->uri->segment(3);
		if(empty($uid)) redirect($this->mod);
		
		$rs = $this->umod->view_log($uid);
		$data['num_rows'] = $rs?$rs->num_rows():0;
		if($data['num_rows'])
		{
			$this->umod->empty_log($uid);
		}
		$this->view_log($uid);		
	}
	
	public function disable()
	{//
		$ar_id = empty($_POST['ar_id'])?"":$this->input->post('ar_id');
		if(!empty($_POST['ar_id']))
		{
			$n = sizeof($ar_id);
			$action = empty($_POST['btn_lock'])? 'y' : 'n';
			$this->pre_message = "Thành công!";
			for($i = 0; $i < $n; $i++) 
			{
				if($ar_id[$i])
				{
					$user['id'] 		= $ar_id[$i];
					$user['activated'] 	= $action;
	
					$this->load->model('user_model', 'umod');
					if(!	$this->umod->update_lock($user))
					{
						$this->pre_message = "Lỗi: không thể cập nhật dữ liệu!";
					}
				}
			}
		}
		$this->session->set_flashdata('message', '<div class="error">'.$this->pre_message.'</div>');
		redirect($this->mod.'/lists');
	}
}
/* End of file member.php */
/* Location: ./crm/controllers/member.php */