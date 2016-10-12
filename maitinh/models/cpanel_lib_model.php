<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel_lib_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		#$this->load->config('config_member');
		$this->tables  = $this->config->item('tables');
		$this->columns = $this->config->item('columns');
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
}

/* End of file cpanel_lib_model.php */
/* Location: ./mekongem/models/cpanel_lib_model.php */