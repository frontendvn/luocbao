<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends Model
{
	public $tables = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('config_member');
		$this->tables  = $this->config->item('tables');
		$this->columns = $this->config->item('columns');
	}

	function create_select_box_groups($select_box_name = "groups", $selected_catid = 0, $accesslvl = false, $onsubmit = false)
	{// create a select box to browse for group
	    $groups_table    	= $this->tables['groups'];
			if($onsubmit)	$onsubmit = 'onChange="this.form.submit()"';
			$this->db->select('id, name, description');
			$this->db->from($groups_table);
			
			if($accesslvl)
				$this->db->where('access_level >', $accesslvl);
			
			$this->db->order_by("id", "asc");
			$res = $this->db->get();

			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
			
			foreach($res->result() as $row)
			{
				$cid = $row->id;
				$cat_title = $row->name;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title, 8)."</option>\n";
			}
			$select_box .= "</select>";
			return $select_box;
	}
	
	function create_select_box_groups_chose($select_box_name = "groups", $selected_catid = 0, $accesslvl = false, $onsubmit = false)
	{// create a select box to browse for group
	    $groups_table    	= $this->tables['groups'];
			if($onsubmit)	$onsubmit = 'onChange="this.form.submit()"';
			$this->db->select('id, name, description');
			$this->db->from($groups_table);
			
			if($accesslvl)
				$this->db->where('access_level >', $accesslvl);
			
			$this->db->order_by("id", "asc");
			$res = $this->db->get();

			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
			$select_box .= "<option value=\"\" title=\"Chọn đối tượng\">-- Chose --</option>\n";
			
			foreach($res->result() as $row)
			{
				$cid = $row->id;
				$cat_title = $row->name;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title, 8)."</option>\n";
			}
			$select_box .= "</select>";
			return $select_box;
	}

	function create_select_box_manager($select_box_name = "dir_admin", $selected_catid = 0, $type_id = false)
	{// create a select box to browse for group
	    $users_table    	= $this->tables['users'];
			$onsubmit = 'onChange="this.form.submit()"';
														
			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
			//
			if(!$type_id or !	in_array($type_id, array(1)))
			{
				if($type_id==2)
					$select_box .= "<option value=\"0\" title=\"là Manager\">is Manager</option>\n";
				else
				{
					$select_box .= "<option value=\"\" title=\"Chọn manager\">-- Chose --</option>\n";
					// get from db
					$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
					$this->db->from($users_table);
					$this->db->where($users_table.'.type_id', 2);
					$this->db->order_by($users_table.'.id', 'desc');
					$res =	$this->db->get();
					
					foreach($res->result() as $row)
					{
						$cid = $row->id;
						$cat_title = $row->fullname.' ('.$row->code.')';
						if($selected_catid == $cid) $selected = "selected";
						else $selected = "";
						$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title, 8)."</option>\n";
					}
				}
			}
			$select_box .= "</select>";
			return $select_box;
	}

	function create_select_box_teamleader($select_box_name = "teamleader", $selected_catid = 0, $accesslvl, $id_admin = false, $type_id = false)
	{// create a select box to browse for group
	    $users_table    	= $this->tables['users'];
														
			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\">\n";
			//
			if(!$type_id or !	in_array($type_id, array(1)))
			{
				if(in_array($type_id, array(2,3,5)))
					$select_box .= "<option value=\"0\" title=\"không có nhóm\">No team</option>\n";
				else
				{
					$select_box .= "<option value=\"\" title=\"Chọn teamleader\">-- Chose --</option>\n";
					// get from db
					$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
					$this->db->from($users_table);
					$this->db->where($users_table.'.dir_admin', $id_admin);
					$this->db->where($users_table.'.type_id', 3);
					$this->db->order_by($users_table.'.id', 'desc');
					$res =	$this->db->get();
					
					foreach($res->result() as $row)
					{
						$cid = $row->id;
						$cat_title = $row->fullname.' ('.$row->code.')';
						if($selected_catid == $cid) $selected = "selected";
						else $selected = "";
						$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title, 8)."</option>\n";
					}
				}
			}
			$select_box .= "</select>";
			return $select_box;
	}
	function create_select_box_teamleader_assign($select_box_name = "teamleader", $selected_catid = 0, $accesslvl, $id_admin = false, $type_id = false)
	{// chi lvl 2 dc phep
	    $users_table    	= $this->tables['users'];
														
			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\">\n";
			//
			if(!$type_id or !	in_array($type_id, array(1)))
			{
				if(in_array($type_id, array(2,3,5)))
					$select_box .= "<option value=\"0\" title=\"không có nhóm\">No team</option>\n";
				else
				{
					$select_box .= "<option value=\"\" title=\"Chọn teamleader\">-- Chose --</option>\n";
					// get from db
					$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
					$this->db->from($users_table);
					if($accesslvl!=1)
						$this->db->where($users_table.'.dir_admin', $id_admin);
					$this->db->where($users_table.'.type_id', 3);
					$this->db->order_by($users_table.'.id', 'desc');
					$res =	$this->db->get();
					
					foreach($res->result() as $row)
					{
						$cid = $row->id;
						$cat_title = $row->fullname.' ('.$row->code.')';
						if($selected_catid == $cid) $selected = "selected";
						else $selected = "";
						$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title, 8)."</option>\n";
					}
				}
			}
			$select_box .= "</select>";
			return $select_box;
	}

	function select_manager()
	{
		$users_table     	= $this->tables['users'];
		$groups_table    	= $this->tables['groups'];
		$group_join      	= $this->config->item('join_group');
		$group_columns		= $this->config->item('columns_groups');
		
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$email_column 		= $this->config->item('email');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 			= $this->config->item('register_time');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
						
		if ($this->config->item('groups') and !empty($group_columns))
		{
				foreach ($group_columns as $vl)
				{
					$this->db->select($groups_table.'.'.$vl);
				}
		}
		
		$this->db->from('user')->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left')->where('type_id <=', 2)->order_by('type_id', 'asc')->order_by('id', 'asc');
		$rs = $this->db->get();
		
		return ($rs->num_rows > 0) ? $rs : false;
	}
	
	function select_teamleader_inputer($id_manager)
	{
		$users_table     	= $this->tables['users'];
		$groups_table    	= $this->tables['groups'];
		$group_join      	= $this->config->item('join_group');
		$group_columns		= $this->config->item('columns_groups');
		
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$email_column 		= $this->config->item('email');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 			= $this->config->item('register_time');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
						
		if ($this->config->item('groups') and !empty($group_columns))
		{
				foreach ($group_columns as $vl)
				{
					$this->db->select($groups_table.'.'.$vl);
				}
		}
		
		$this->db->from('user')->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		$this->db->where('dir_admin', $id_manager)->where_in('type_id', array(3,5));
		$this->db->order_by('type_id', 'asc')->order_by('id', 'asc');
		$rs = $this->db->get();
		
		return ($rs->num_rows > 0) ? $rs : false;
	}
	
	function select_consultant($id_team)
	{
		$users_table     	= $this->tables['users'];
		$groups_table    	= $this->tables['groups'];
		$group_join      	= $this->config->item('join_group');
		$group_columns		= $this->config->item('columns_groups');
		
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$email_column 		= $this->config->item('email');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 			= $this->config->item('register_time');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
						
		if ($this->config->item('groups') and !empty($group_columns))
		{
				foreach ($group_columns as $vl)
				{
					$this->db->select($groups_table.'.'.$vl);
				}
		}
		
		$this->db->from('user')->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		$this->db->where('teamleader', $id_team)->where('type_id', 4);
		$this->db->order_by('type_id', 'asc')->order_by('id', 'asc');
		$rs = $this->db->get();
		
		return ($rs->num_rows > 0) ? $rs : false;
	}
	function create_select_box_all_user($select_box_name = "user_id", $selected_catid = 0)
	{// create a select box to browse for group
	    $users_table    	= 'user';
														
			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\">\n";
			//
			
			// get from db
			$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
			$this->db->from($users_table);
			$this->db->where($users_table.'.type_id <', 5);
			$this->db->order_by($users_table.'.type_id', 'asc');
			$res =	$this->db->get();
			
			foreach($res->result() as $row)
			{
				$cid = $row->id;
				$cat_title = $row->fullname.' ('.$row->code.')';
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,8)."</option>\n";
			}
			$select_box .= "</select>";
			return $select_box;
	}
	/**
	 * Checks usertype when del (not del admin, manager, teamleader).
	 *
	 * @return void
	 **/
	function usertype_check_del($id=false)
	{
	    $users_table 		= $this->tables['users'];
			$user_id_column = $this->config->item('user_id');
	    
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
	function delete_user($id=false)
	{
		if($id==false) return false;
	  $users_table = $this->tables['users'];
		$option_table = $this->tables['options'];
		$option_join	= $this->config->item('join_option');
		// delete option
		if($this->config->item('option'))	$this->db->delete($option_table, array($option_join => $id)); 
		// delete user
		return $this->db->delete($users_table, array('id' => $id)); 
	}
	function del_user($id=false, $reid=false)
	{
		if($id==false or $reid==false) return false;
		// update db alarm, assessment_interviews, call_candidate, call_client, candidate, congno, contract, customer, group_can, interviews, job, local_cv
		// alarm
		$this->db->update('alarm', array('id_consultant' => $reid), array('id_consultant' => $id));
		// assessment_interviews
		$this->db->update('assessment_interviews', array('id_user' => $reid), array('id_user' => $id));
		// call_candidate
		$this->db->update('call_candidate', array('id_consultant' => $reid), array('id_consultant' => $id));
		// call_client
		$this->db->update('call_client', array('id_consultant' => $reid), array('id_consultant' => $id));
		// candidate
		$this->db->update('candidate', array('user_id' => $reid), array('user_id' => $id));
		// congno
		$this->db->update('congno', array('id_user' => $reid), array('id_user' => $id));
		// contract
		$this->db->update('contract', array('id_consultant' => $reid), array('id_consultant' => $id));
		// customer
		$this->db->update('customer', array('consultant_id' => $reid), array('consultant_id' => $id));
		// group_can
		$this->db->update('group_can', array('id_consultant' => $reid), array('id_consultant' => $id));
		// interviews
		$this->db->update('interviews', array('id_consultant' => $reid), array('id_consultant' => $id));
		// job
		$this->db->update('job', array('user_id' => $reid), array('user_id' => $id));
		// local_cv
		$this->db->update('local_cv', array('id_consultant' => $reid), array('id_consultant' => $id));
		
		// delete user
		return $this->delete_user($id);
	}
	function select_user_other()
	{
		$users_table     	= $this->tables['users'];
		$groups_table    	= $this->tables['groups'];
		$group_join      	= $this->config->item('join_group');
		$group_columns		= $this->config->item('columns_groups');
		
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$email_column 		= $this->config->item('email');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 			= $this->config->item('register_time');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
						
		if ($this->config->item('groups') and !empty($group_columns))
		{
				foreach ($group_columns as $vl)
				{
					$this->db->select($groups_table.'.'.$vl);
				}
		}
		
		$this->db->from($users_table)->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		
		$where = '(type_id=4 AND teamleader=0) OR (type_id=5 AND dir_admin=0) OR (type_id=3 AND dir_admin=0) OR (type_id=4 AND dir_admin=0)';
		$this->db->where($where);
		$this->db->order_by('type_id', 'asc')->order_by('id', 'asc');
		$rs = $this->db->get();
		
		return ($rs->num_rows > 0) ? $rs : false;
	}
	function update($values = false)
	{// update
	    $users_table 			= $this->tables['users'];
			$user_id_column 	= $this->config->item('user_id');
		
		if 	($values === false or $values[$user_id_column] === false)	return false;
		
		if	($this->db->update($users_table, $values, array($user_id_column => $values[$user_id_column])))
			return TRUE;
		else
			return FALSE;
	}
	function get_directadmin($id=false)
	{
		if 	($id === false)	return false;
		$result = $this->db->query("SELECT dir_admin, teamleader FROM user WHERE id=$id LIMIT 1");
		if($result->num_rows())
		{
			$dir_admin = $result->row()->dir_admin;
			$teamleader = $result->row()->teamleader;
			return $result->row();
		}
		return false;
	}
	function view_log($id)
	{
		$users_table     	= $this->tables['users'];
		$logs_table     	= 'logs';
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		
		$this->db->select($users_table.'.fullname, '.
											$users_table.'.code, '.
											$logs_table.'.id, '.
											$logs_table.'.id_user, '.
											$logs_table.'.ip_address, '.
											$logs_table.'.action, '.
											$logs_table.'.times');
		$this->db->from($logs_table)->join($users_table, $logs_table.'.id_user = '.$users_table.'.id', 'left');
		$this->db->where('id_user', $id);
		$this->db->order_by($logs_table.'.id', 'desc');
		return $this->db->get();
	}
	function empty_log($uid)
	{
		$this->db->delete('logs', array('id_user'=>$uid));
	}
	function select_box_all_user($select_box_name = "user_id", $selected_catid = 0, $onsubmit="")
	{// create a select box to browse for group
	    $users_table    	= 'user';
		if($onsubmit)	$onsubmit = 'onChange="this.form.submit()"';
													
		$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
		
		// get from db
		$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
		$this->db->from($users_table);
		$this->db->order_by($users_table.'.type_id', 'asc');
		$res =	$this->db->get();
		
		foreach($res->result() as $row)
		{
			$cid = $row->id;
			$cat_title = $row->fullname.' ('.$row->code.')';
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,8)."</option>\n";
		}
		$select_box .= "</select>";
		return $select_box;
	}
	function create_select_box_con($select_box_name = "consultant", $selected_catid = 0, $accesslvl, $id_admin = false, $multiple="", $size=0)
	{// create a select box to browse for group
	    $users_table    	= 'user';
		$multiple = $multiple?'multiple="multiple"':'';
		$size = $size?"size='$size'":'';
													
		$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $multiple $size>\n";
		// get from db
		$this->db->select($users_table.'.id, '.$users_table.'.fullname, '.$users_table.'.code');
		$this->db->from($users_table);
		switch($accesslvl)
		{
			case 1: break;
			case 2: $this->db->where($users_table.'.dir_admin', $id_admin);break;
			case 3: $this->db->where($users_table.'.teamleader', $id_admin);#$this->db->or_where($users_table.'.id', $id_admin);break;
			case 4: $this->db->where($users_table.'.teamleader', $id_admin);break;
			case 5: $this->db->where($users_table.'.teamleader', $id_admin);break;
			default: $this->db->where($users_table.'.teamleader', $id_admin);
		}
		$this->db->where($users_table.'.type_id >=', 3);
		$this->db->where($users_table.'.type_id <', 5);
		$this->db->order_by($users_table.'.fullname', 'asc');
		$res =	$this->db->get();
			
		$select_box .= "<option value=\"0\" title=\"\"> </option>\n";
		foreach($res->result() as $row)
		{
			$cid = $row->id;
			$cat_title = $row->fullname.' ('.$row->code.')';
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,8)."</option>\n";
		}
		$select_box .= "</select>";
		return $select_box;
	}
	
	function select_user_orderby_level()
	{
		$users_table     	= $this->tables['users'];
		$groups_table    	= $this->tables['groups'];
		$group_join      	= $this->config->item('join_group');
		$group_columns		= $this->config->item('columns_groups');
		
		$user_id_column 	= $this->config->item('user_id');
		$username_column 	= $this->config->item('username');
		$email_column 		= $this->config->item('email');
		$act_code_columns	= $this->config->item('activation_code');
		$time_column 		= $this->config->item('register_time');
		
		$this->db->select($users_table.'.'.$user_id_column.', '.
											$users_table.'.'.$username_column.', ' .
											$users_table.'.'.$email_column.', '.
											$users_table.'.'.$time_column.', '.
											$users_table.'.'.$act_code_columns.', '.
											$users_table.'.code, '.
											$users_table.'.description AS mota, '.
											$users_table.'.fullname, '.
											$users_table.'.dir_admin, '.
											$users_table.'.teamleader, '.
											$users_table.'.type_id');
						
		if ($this->config->item('groups') and !empty($group_columns))
		{
				foreach ($group_columns as $vl)
				{
					$this->db->select($groups_table.'.'.$vl);
				}
		}
		
		$this->db->from('user')->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id', 'left');
		$this->db->order_by('type_id');
		$rs = $this->db->get();
		
		return ($rs->num_rows > 0) ? $rs : false;
	}
	
	function update_lock($values = false)
	{// update
	    $users_table 		= $this->tables['users'];
		$user_id_column 	= $this->config->item('user_id');
		$user_type_column 	= 'type_id';
		
		if 	($values === false or $values[$user_id_column] === false)	return false;
		
		$this->db->where($user_id_column, $values[$user_id_column]);
		$this->db->where($user_type_column.' >', '1');
		$this->db->update($users_table, $values);
		return $this->db->affected_rows()>0? true : false;
	}
	
}

/* End of file user_model.php */
/* Location: ./mekongem/models/user_model.php */