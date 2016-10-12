<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class member_model extends Model
{
	/**
	 * Holds an array of tables used in
	 * redux.
	 *
	 * @var string
	 **/
	public $tables = array();
	
	/**
	 * activation code
	 *
	 * @var string
	 **/
	public $activation_code;
	
	/**
	 * forgotten password key
	 *
	 * @var string
	 **/
	public $forgotten_password_code;
	
	/**
	 * new password
	 *
	 * @var string
	 **/
	public $new_password;
	
	/**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;
	/**
	 * is_mode
	 *
	 * @var string
	 **/
	public $is_mode;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('config_member');
		$this->tables  = $this->config->item('tables');
		$this->columns = $this->config->item('columns');
	}
	
	/**
	 * Misc functions
	 * 
	 * Hash password : Hashes the password to be stored in the database.
     * Hash password db : This function takes a password and validates it
     * against an entry in the users table.
     * Salt : Generates a random salt value.
	 *
	 * @author Mathew
	 */
	 
	/**
	 * Hashes the password to be stored in the database.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password($password = false)
	{
	    $salt_length = $this->config->item('salt_length');
	    
	    if ($password === false)
	    {
	        return false;
	    }
	    
		$salt = $this->salt();
		
		$password = $salt . substr(sha1($salt . $password), 0, -$salt_length);
		
		return $password;		
	}
	
	/**
	 * This function takes a password and validates it
   * against an entry in the users table.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password_db($identity = false, $password = false)
	{
	    $identity_column  	= $this->config->item('identity');
		$pasword_column   	= $this->config->item('password');
		$user_id_column	 	= $this->config->item('user_id');
	    $users_table     	= $this->tables['users'];
	    $salt_length      	= $this->config->item('salt_length');
	    
	    if ($identity === false || $password === false)
	    {
	        return false;
	    }
	    
	    $query  = $this->db->select($pasword_column)
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
            
        $result = $query->row();
        
		if ($query->num_rows() !== 1)
		{
				return false;
		}
			
		$salt = substr($result->$pasword_column, 0, $salt_length);

		$password = $salt . substr(sha1($salt . $password), 0, -$salt_length);
		
				
		return $password;
	}
	
	/**
	 * Generates a random salt value.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function salt()
	{
		return substr(md5(uniqid(rand(), true)), 0, $this->config->item('salt_length'));
	}
	
	/**
	 * Deactivate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($username = false)
	{
	    $users_table = $this->tables['users'];
	    $act_code_column = $this->config->item('activation_code');
	    $username_column = $this->config->item('username');
	    
	    if ($username === false)
	    {
	        return false;
	    }
	    
		$activation_code = sha1(md5(microtime()));
		$this->activation_code = $activation_code;
		
		$data = array($act_code_column => $activation_code);
        
		$update = $this->db->update($users_table, $data, array($username_column => $username));
		
		return $update;
	}
	/**
	 * activate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($code = false)
	{
	    $act_code_column = $this->config->item('activation_code');
	    $identity_column = $this->config->item('identity');
	    $users_table     = $this->tables['users'];
	    
	    if ($code === false)
	    {
	        return false;
	    }
	  
	    $query = $this->db->select($identity_column)
                	      ->where($act_code_column, $code)
                	      ->limit(1)
                	      ->get($users_table);
                	      
		$result = $query->row();
        
		if ($query->num_rows() !== 1)
		{
		    return false;
		}
	    
		$identity = $result->{$identity_column};
		
		$data = array($act_code_column => '');
        
		$update = $this->db->update($users_table, $data, array($identity_column => $identity));
		
		return $update;
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($info)
	{
		$users_table        = $this->tables['users'];
		$meta_table         = $this->tables['meta'];
		$groups_table       = $this->tables['groups'];
		$options_table      = $this->tables['options'];
		$group_join    		= $this->config->item('join_group');
		$meta_join          = $this->config->item('join');
		$option_join        = $this->config->item('join_option');
		$additional_columns = $this->config->item('columns');
		$option_columns 	= $this->config->item('columns_option');
		$identity_column	= $this->config->item('identity');
		$password_column	= $this->config->item('password');
		$email_column		= $this->config->item('email');
		$ip_address_column	= $this->config->item('ip_address');
		$user_id_column 	= $this->config->item('user_id');
		
		if (empty($info[$identity_column]) || empty($info[$password_column]))
		{
			return false;
		}
		
		// IP Address
		$ip_address = $this->input->ip_address();
		if($this->config->item('save_address_IP'))	$info[$ip_address_column] = $ip_address;
   		// hash password
		$info[$password_column] = $this->hash_password($info[$password_column]);
		// Group ID
		if($this->config->item('groups'))
		{
			if(empty($info[$group_join]))
			{
				$query    = $this->db->select('id')->where('name', $this->config->item('default_group'))->get($groups_table);
				$result   = $query->row();
				$info[group_join] = $result->id;
			}
		}
		
    	// Users table.
		$insert_user = $this->db->insert($users_table, $info);
		$id = $this->db->insert_id();
		//
    	// update code of user (S+id)
		$ar[$user_id_column] = $id;
		$ar['code'] = 'S'.$id;
		$this->update_codeofuser($ar);
		
		// Option table.
		if($this->config->item('option'))
		{
			if (!empty($option_columns))
			{
				/*foreach ($option_columns as $input)
				{
						$option[$input] = isset($_POST[$input])?'1':'0';
				}
				// check not exist in Option table yet?
				$query = $this->db->select('opt_id')->where($option)->limit(1)->get($options_table);
				if ($query->num_rows() == 1)
				{
					$opt_id = $query->row()->opt_id;
				}
				else
				{
					$this->db->insert($options_table, $option);
					$opt_id = $this->db->insert_id();
				}*/
				
				foreach ($option_columns as $input)
				{
						$option[$input] = '1~1';
				}
				$option[$option_join] = $id;
				
				$this->db->insert($options_table, $option);
				$opt_id = $this->db->insert_id();
			}
		}   
	
		// Meta table.
		if($this->config->item('meta'))
		{
			
			if (!empty($additional_columns))
			{
				foreach ($additional_columns as $input)
				{
					$data[$input] = $this->input->post($input);
				}
			}

			$data[$meta_join] = $id;
			$data[$option_join] = $opt_id;
					
			$this->db->insert($meta_table, $data);
			
			return ($this->db->affected_rows() > 0) ? true : false;
		}
		
		return $insert_user;
			
	}
    
	/**
	 * change password
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function change_password($identity = false, $old = false, $new = false)
	{
	    $identity_column	= $this->config->item('identity');
		$user_id_column 	= $this->config->item('user_id');
		$password_column 	= $this->config->item('password');
		$act_code_column 	= $this->config->item('activation_code');
	    $users_table      	= $this->tables['users'];
	    if ($identity === false || $old === false || $new === false)
	    {
	        return 0;
	    }
	    
	    $query  = $this->db->select($password_column)
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
                    	   
	    $result = $query->row();

	    $db_password = $result->$password_column; 
	    $old         = $this->hash_password_db($identity, $old);
	    $new         = $this->hash_password($new);

	    if ($db_password === $old)
	    {
	        $data = array($password_column => $new);
	        
	        $this->db->update($users_table, $data, array($identity_column => $identity));
	        
	        return ($this->db->affected_rows() == 1) ? 2 : 1;
	    }
	    
	    return 0;
	}
	
	/**
	 * Identity check
	 *
	 * @return void
	 * @author Mathew
	 **/
	protected function identity_check($identity = false)
	{
	    $identity_column	= $this->config->item('identity');
		$user_id_column		= $this->config->item('user_id');
	    $users_table     	= $this->tables['users'];
	   
	    if ($identity === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($user_id_column)
                           ->where($identity_column, $identity)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}

	/**
	 * Insert a forgotten password key.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password($email = false)
	{
	    $users_table 			= $this->tables['users'];
	    $identity_column 		= $this->config->item('identity'); 
		$email_column			= $this->config->item('email');
	    $fg_pass_code_column	= $this->config->item('forgotten_password_code');
			
	    if ($email === false)
	    {
	        return false;
	    }
	    $query = $this->db->select($identity_column.', '.$fg_pass_code_column)
                    	   ->where($email_column, $email)
                    	   ->limit(1)
                    	   ->get($users_table);
            
     	$result = $query->row();
		
		$code = is_object($result)?$result->$fg_pass_code_column:"";
		$this->identity = is_object($result)?$result->$identity_column:"";
		if ($query->num_rows()>0 and empty($code))
		{
			$key = $this->hash_password(microtime().$email);
			
			$this->forgotten_password_code = $key;
		
			$data = array($fg_pass_code_column => $key);
			
			$this->db->update($users_table, $data, array($email_column => $email));
			
			return ($this->db->affected_rows() == 1) ? true : false;
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
	public function forgotten_password_complete($code = false)
	{
	    $users_table 		= $this->tables['users'];
	    $identity_column 	= $this->config->item('identity'); 
		$email_column		= $this->config->item('email');
		$password_column 	= $this->config->item('password');
	    $fg_pass_code_column= $this->config->item('forgotten_password_code');
	    
	    if ($code === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($identity_column)
                    	   ->where($fg_pass_code_column, $code)
                           ->limit(1)
                    	   ->get($users_table);
        
        $result = $query->row();
        if ($query->num_rows() > 0)
        {
            $salt       = $this->salt();
			$password   = $this->hash_password($salt);
	
			$this->new_password = $salt;
			$this->identity = $result->$identity_column;
		    
            $data = array($password_column     => $password,
                          $fg_pass_code_column => '0');
            
            $this->db->update($users_table, $data, array($fg_pass_code_column => $code));

            return true;
        }
        
        return false;
	}
	/**
	 * Checks email.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function email_check($email = false)
	{
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$email_column		= $this->config->item('email');
	    
	    if ($email === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($user_id_column)
                           ->where($email_column, $email)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}
	/**
	 * profile
	 *
	 * @return void
	 **/
	public function profile($identity = false)
	{
	    $users_table     	= $this->tables['users'];
	    $groups_table    	= $this->tables['groups'];
	    $meta_table     	= $this->tables['meta'];
	    $meta_join       	= $this->config->item('join');
		$group_join      	= $this->config->item('join_group');
	    $identity_column	= $this->config->item('identity');
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$act_code_column	= $this->config->item('activation_code');
		$time_column 		= $this->config->item('register_time');
		$email_column 		= $this->config->item('email');
	    $group_columns		= $this->config->item('columns_groups');
			
		$options_table      = $this->tables['options'];
		$option_join        = $this->config->item('join_option');
		$option_columns 	= $this->config->item('columns_option');
		$user_columns 		= $this->config->item('columns_users');
			
	    if ($identity === false)
	    {
	        return false;
	    }
	    
		$this->db->select($users_table.'.'.$user_id_column.', '.
							$users_table.'.'.$username_column.', ' .
							$users_table.'.'.$email_column.', '.
							$users_table.'.'.$act_code_column.', '.
							$users_table.'.'.$time_column);
						
		if (!empty($user_columns))
		{
			foreach ($user_columns as $vl)
			{
				$this->db->select($users_table.'.'.$vl);
			}
		}
		
		if ($this->config->item('groups') and !empty($group_columns))
		{
			foreach ($group_columns as $vl)
			{
				if($vl=='description') $vl = $vl.' AS mota';
				$this->db->select($groups_table.'.'.$vl);
			}
		}
		
		if (!empty($this->columns))
		{
			foreach ($this->columns as $value)
			{
				$this->db->select($meta_table.'.'.$value);
			}
		}

		if (!empty($option_columns))
		{
			foreach ($option_columns as $value)
			{
			$this->db->select($options_table.'.'.$value);
			}
		}

		$this->db->from($users_table);
		
		if($this->config->item('meta'))
		{
			$this->db->join($meta_table, $users_table.'.'.$user_id_column.' = '.$meta_table.'.'.$meta_join, 'left');
		}
		
		if($this->config->item('groups'))
		{
			$this->db->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		}

		// Option table.
		if($this->config->item('option'))
		{
			$this->db->join($options_table, $users_table.'.'.$user_id_column.' = '.$options_table.'.'.$option_join, 'left');
		}   

		$this->db->where($users_table.'.'.$identity_column, $identity);
			
		$this->db->limit(1);
		$i = $this->db->get();
		
		return ($i->num_rows > 0) ? $i->row() : false;
	}
	/**
	 * login
	 * create session is $user_id_column
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function login($identity = false, $password = false)
	{
	    $identity_column	= $this->config->item('identity');
		$user_id_column 	= $this->config->item('user_id');
		$password_column 	= $this->config->item('password');
		$act_code_column 	= $this->config->item('activation_code');
	    $users_table     	= $this->tables['users'];
	    if ($identity === false || $password === false || $this->identity_check($identity) == false)
	    {
	        return 0;
	    }
	    $query = $this->db->select($identity_column.', '.$password_column.', '.$act_code_column)
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
	    
        $result = $query->row();
       
        if ($query->num_rows() == 1)
        {
            $password = $this->hash_password_db($result->$identity_column, $password);
             
            if ($result->$act_code_column!=='y') { return 1; }
            
			if ($result->$password_column === $password)
			{
				$this->session->set_userdata($identity_column,  $result->$identity_column);
				return 2;
			}
        }

		return 0;		
	}
	
	/**
	 * Checks username.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function username_check($username = false)
	{
	    $users_table = $this->tables['users'];
		$user_id_column = $this->config->item('user_id');
		$username_column = $this->config->item('username');
	    
	    if ($username === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($user_id_column)
                           ->where($username_column, $username)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}
	
	/***********************************************************************************************************/
	
	/**
	 * Update_user.
	 *
	 * @return void
	 **/
	function update_user($values = false)// to edit
	{// update users_table
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$group_join      	= $this->config->item('join_group');
	
		if 	($values === false or $values[$user_id_column] === false)	return false;
		
		if	(!empty($values['password'])) $values['password'] = $this->hash_password($values['password']);
		else unset($values['password']);
		
		if	(!empty($values[$group_join]) and $values[$group_join]>3)// ha cap tu 2 xuong hoac tu 3 xuong
		{
			$val['teamleader'] = 0;
			$this->db->update($users_table, $val, array('teamleader' => $values[$user_id_column]));
			$val['dir_admin'] = 0;
			$this->db->update($users_table, $val, array('dir_admin' => $values[$user_id_column]));
		}
		else
		{
			if($values[$group_join]==3)// ha cap tu 2 xuong 3
			{
				$val['dir_admin'] = 0;
				$this->db->update($users_table, $val, array('dir_admin' => $values[$user_id_column]));
			}
			else// thang cap tu 3 len 2
			{
				$val['teamleader'] = 0;
				$this->db->update($users_table, $val, array('dir_admin' => $values[$user_id_column]));
			}
			$values['teamleader'] = 0;
		}
		
		if	($this->db->update($users_table, $values, array($user_id_column => $values[$user_id_column])))
			return TRUE;
		else
			return FALSE;
	}
	
	function update_profile($values = false)// to edit
	{// update users_table
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$group_join      	= $this->config->item('join_group');
	
		if 	($values === false or $values[$user_id_column] === false)	return false;
		
		if	($this->db->update($users_table, $values, array($user_id_column => $values[$user_id_column])))
			return TRUE;
		else
			return FALSE;
	}
	
	function update_codeofuser($values = false)
	{// update users_table
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$group_join      	= $this->config->item('join_group');
	
		if 	($values === false or $values[$user_id_column] === false)	return false;
		
		if	($this->db->update($users_table, $values, array($user_id_column => $values[$user_id_column])))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Checks usertype.
	 *
	 * @return void
	 **/
	public function usertype_check()
	{
	    $users_table 	= $this->tables['users'];
		$user_id_column = $this->config->item('user_id');
		$group_join    	= $this->config->item('join_group');
	    $groups_table  	= $this->tables['groups'];
	    
	    $query = $this->db->select($user_id_column)
							->from($users_table)
							->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id')
							->where('access_level', 1)
							->limit(1)
							->get();
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}
	/**
	 * Checks usertype when edit, del (not del admin).
	 *
	 * @return void
	 **/
	public function usertype_check_edit_or_del($id=false)
	{
	    $users_table 	= $this->tables['users'];
	    $groups_table  	= $this->tables['groups'];
		$user_id_column = $this->config->item('user_id');
		$group_join    	= $this->config->item('join_group');
	    
	    if($id==false) return false; 
		$query = $this->db->select($users_table.'.'.$user_id_column)
							->from($users_table)
							->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id')
							->where('access_level', 1)
							->limit(1)
							->get();
	
		if ($query->num_rows() == 1)
		{
			$admin_id = $query->row()->$user_id_column;
			if($admin_id == $id) return true;
		}
		
		return false;
	}
	/**
	 * Checks usertype when del (not del admin, manager, teamleader).
	 *
	 * @return void
	 **/
	public function usertype_check_del($id=false)
	{
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
	    
	    if($id==false) return false; 
		$query = $this->db->select('type_id')
							->from($users_table)
							->where($user_id_column, $id)
							->get();
	
		if ($query->num_rows()>0)
		{
			$lvl = $query->row(0)->type_id;
			if($lvl>=4) return $lvl;
		}
		
		return false;
	}
	
	/**
	 * Checks username when edit.
	 *
	 * @return void
	 **/
	function username_check_edit($id, $username = false)
	{
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
	    
	    if ($username === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($user_id_column)
                           ->where($username_column, $username)->where($user_id_column.' !=', $id)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}

	function email_check_edit($id, $email = false)
	{
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$email_column 		= $this->config->item('email');
	    
	    if ($email === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select($user_id_column)
                           ->where($email_column, $email)->where($user_id_column.' !=', $id)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{
			return true;
		}
		
		return false;
	}
	
	function get_userid($identity = false)
	{
	    if($identity === false) return false;
			
		$users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
	    $identity_column	= $this->config->item('identity');
		
	    $query = $this->db->select($user_id_column)
                           ->where($identity_column, $identity)
                           ->limit(1)
                           ->get($users_table);
		if ($query->num_rows() == 1)
		{
			return $query->row()->$user_id_column;
		}
		
		return false;
	}

	function get_user($identity)
	{
		$identity_column	= $this->config->item('identity');
		return $this->db->get_where($this->tables['users'], array($identity_column => $identity), 1, 0);
	}
	
	public function select_user($user_id=false, $accesslvl=false, $id=false)
	{
	    $users_table     	= $this->tables['users'];
	    $groups_table    	= $this->tables['groups'];
	    $meta_table     	= $this->tables['meta'];
	    $meta_join       	= $this->config->item('join');
		$group_join      	= $this->config->item('join_group');
	    $identity_column	= $this->config->item('identity');
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$password_column 	= $this->config->item('password');
		$email_column 		= $this->config->item('email');
	    $group_columns		= $this->config->item('columns_groups');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 		= $this->config->item('register_time');
		
		$options_table      = $this->tables['options'];
		$option_join        = $this->config->item('join_option');
		$option_columns 	= $this->config->item('columns_option');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$password_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.time_start, '.
											$users_table.'.time_finish, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
							
		if ($this->config->item('groups') and !empty($group_columns))
		{
			foreach ($group_columns as $vl)
			{
				$this->db->select($groups_table.'.'.$vl);
			}
		}
		
		if (!empty($this->columns))
		{
			foreach ($this->columns as $value)
			{
				$this->db->select($meta_table.'.'.$value);
			}
		}

		if (!empty($option_columns))
		{
			foreach ($option_columns as $value)
			{
			$this->db->select($options_table.'.'.$value);
			}
		}

		$this->db->from($users_table);
		
		if($this->config->item('meta'))
		{
			$this->db->join($meta_table, $users_table.'.'.$user_id_column.' = '.$meta_table.'.'.$meta_join, 'left');
		}
		
		if($this->config->item('groups'))
		{
			$this->db->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		}

		// Option table.
		if($this->config->item('option'))
		{
			$this->db->join($options_table, $users_table.'.'.$user_id_column.' = '.$options_table.'.'.$option_join, 'left');
		} 
		// select $accesslvl  
		if($accesslvl)
		{
			#$this->db->where($groups_table.'.access_level >', $accesslvl);// Admin ko dc sua
			switch($accesslvl)
			{
				case 1:
					break;
				case 2:
					$this->db->where($users_table.'.dir_admin', $id);
					#$this->db->or_where($users_table.'.dir_admin', 0);
					break;
				case 3:
					$this->db->where($users_table.'.teamleader', $id);
					break;
			}
		}
		// select $user_id  
		if($user_id)
		{
			$this->db->where($users_table.'.'.$user_id_column, $user_id);
			$this->db->limit(1);
		}
		
		$i = $this->db->get();
		
		return ($i->num_rows > 0) ? $i : false;
	}

	function delete_user($id)
	{
	  	$users_table = $this->tables['users'];
		// delete user
		return $this->db->delete($users_table, array('id' => $id)); 
	}
	
	public function view_user($id = false)
	{
	    $users_table     	= $this->tables['users'];
	    $groups_table    	= $this->tables['groups'];
	    $meta_table     	= $this->tables['meta'];
	    $meta_join       	= $this->config->item('join');
		$group_join      	= $this->config->item('join_group');
	    $identity_column	= $this->config->item('identity');
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$act_code_column	= $this->config->item('activation_code');
		$time_column 		= $this->config->item('register_time');
		$email_column 		= $this->config->item('email');
	    $group_columns		= $this->config->item('columns_groups');
			
		$options_table      = $this->tables['options'];
		$option_join        = $this->config->item('join_option');
		$option_columns 	= $this->config->item('columns_option');
		$user_columns 		= $this->config->item('columns_users');
			
	    if ($id === false)
	    {
	        return false;
	    }
	    
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$act_code_column.', '.
											$users_table.'.'.$time_column);
						
		if (!empty($user_columns))
		{
			foreach ($user_columns as $vl)
			{
				$this->db->select($users_table.'.'.$vl);
			}
		}
		
		if ($this->config->item('groups') and !empty($group_columns))
		{
			foreach ($group_columns as $vl)
			{
				if($vl=='description') $vl = $vl.' AS mota';
				$this->db->select($groups_table.'.'.$vl);
			}
		}
		
		if (!empty($this->columns))
		{
			foreach ($this->columns as $value)
			{
				$this->db->select($meta_table.'.'.$value);
			}
		}

		if (!empty($option_columns))
		{
			foreach ($option_columns as $value)
			{
				$this->db->select($options_table.'.'.$value);
			}
		}

		$this->db->from($users_table);
		
		if($this->config->item('meta'))
		{
			$this->db->join($meta_table, $users_table.'.'.$user_id_column.' = '.$meta_table.'.'.$meta_join, 'left');
		}
		
		if($this->config->item('groups'))
		{
			$this->db->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		}

		// Option table.
		if($this->config->item('option'))
		{
			$this->db->join($options_table, $users_table.'.'.$user_id_column.' = '.$options_table.'.'.$option_join, 'left');
		}   

		$this->db->where($users_table.'.'.$user_id_column, $id);
			
		$this->db->limit(1);
		$i = $this->db->get();
		
		return ($i->num_rows > 0) ? $i->row() : false;
	}
	/********************08-01-10**********************/
	function update_user_option($vl)
	{
		$option_join        = $this->config->item('join_option');
    	$option_table     	= $this->tables['options'];
		if($this->db->update($option_table, $vl, array($option_join=>$vl[$option_join]))) return TRUE;
		return FALSE;
	}
	
	function update_khachhang($vl, $wh)
	{
		$this->db->where('id_verifier', $wh);
		$this->db->update('khachhang', array('verifier_name'=>$vl));
		
		$this->db->where('id_sampleone', $wh);
		$this->db->update('khachhang', array('sampleone_name'=>$vl));
		
		$this->db->where('id_caller', $wh);
		$this->db->update('khachhang', array('caller_name'=>$vl));
		
		$this->db->where('id_sampletwo', $wh);
		$this->db->update('khachhang', array('sampletwo_name'=>$vl));
	}
}

/* End of file member_model.php */
/* Location: ./mekongem/models/member_model.php */