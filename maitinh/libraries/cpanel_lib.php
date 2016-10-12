<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//
class Cpanel_lib{
	//cpanel
	var $ci;
	var $tables;
	var $query_main;
	var $account;
	var $accesslvl;
	var $thisclass;
	var $thisfunc;
	var $url_back;
	var $write_log=true;
	var $numrecord=1000;
	var $time_live	= 7200;//30 phut
	var $n = array();
	//
	function  cpanel_lib($props = array()) {
		$this->initialize($props);
	}
	//
	function initialize($config = array())
	{//
		//start CI + database + session
		$this->ci =& get_instance();
		$this->ci->load->database();$this->ci->load->model('cpanel_lib_model');
		//khoi tao cho class
		$this->tables  = $this->ci->config->item('tables');
		$this->account	= $this->ci->session->userdata($this->ci->config->item('identity'));
		$this->get_user_table($this->account);
		$this->accesslvl = empty($this->query_main)? 0: $this->query_main->access_level;
		//lay class va function
		$this->thisclass= $this->ci->uri->segment(1);
		$this->thisclass= empty($this->thisclass)? "welcome": $this->thisclass;
		$this->thisfunc	= $this->ci->uri->segment(2);
		//tao va cat du url truoc do
		$url_back		= empty($this->thisfunc)? $this->thisclass: $this->thisclass."/".$this->thisfunc;
		$this->url_back	= $this->ci->session->userdata('URLBACK');
		$this->ci->session->set_userdata('URLBACK', site_url($url_back));
		//lay thoi gian login
		$time_in	= $this->ci->session->userdata('TIMLELIVE');
		$this->ci->session->set_userdata('TIMLELIVE', time());
		//first time
		if($this->thisclass == "home"){
			return true;
		}
		//kiem tra da login chua cai da
		$this->check_login();
		// checks for login time
		$this->checkLoginTime();
		//kiem tra thoi gian dang nhap qua han chua
		$this->check_time_live($time_in);
		//kiem tra quyen quan tri cap do class, function va ghi log
		$this->check_permit();
	}

	function get_user_table($identity = false)
	{
	    if(empty($identity))
		{ 
			$this->query_main = false;
			return false;
		}
		$query = $this->ci->cpanel_lib_model->profile($identity);
		
		if ($query)
		{
			$this->query_main = $query;
		}
		else
		{
			$this->query_main = false;
		}
	}

	function check_login()
	{//
		if(empty($this->account) || empty($this->accesslvl))
		{
			redirect('home');
		}
	}
	function check_time_live($time_in)//TB01
	{//	neu nhu thang quan tri di dau, qua gio thi tu dong logout cho no
		$time_live	= time() - $time_in;
		//
		if($time_live > $this->time_live){
			$this->logout();
			$this->alert_to_login("Error code: TB01.\\nSession lost, please log in again.", 0, true);
		}
	}
	function check_permit()//TB02
	{//	kiem tra quyen truy cap cac cap do
		$fPM	= $this->check_permit_level();
		//neu co loi thi thong bao
		if(!$fPM)
		{
			$this->alert_to_back("Error code: TB02.\\nSorry, this area is limited.");
		}
		else
		{// ghi log
			if($this->write_log) $this->write_log();
		}
	}
	function check_permit_level()
	{//	kiem tra quyen truy cap cac cap do
		$fPM	= true;
		//check class permit
		$cls	= $this->check_class_name();
		if(empty($cls))
		{
			return false;
		}
		//check function permit
		$func	= $this->check_function_name();
		if(empty($func))
			return false;
		//neu co loi thi thong bao
		return $fPM;
	}
	function check_class_name()
	{//
		#if(empty($this->thisclass)) return true;
		$sql="SELECT id, required_access FROM class_permits WHERE class_name ='".$this->thisclass."' LIMIT 1";
		$query = $this->ci->db->query($sql);
		//
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			$required_access = $row->required_access;
			if($this->accesslvl<=$required_access)
			{
				return $row->id;
			}
		}
		return false;
	}
	
	function check_function_name()
	{//
		if(empty($this->thisfunc)) return true;
		$sql="SELECT a.id, a.required_access FROM function_permits a, class_permits b WHERE a.id_class=b.id AND b.class_name='".$this->thisclass."' AND func_name='".$this->thisfunc."' LIMIT 1";
		//
		$query = $this->ci->db->query($sql);
		//
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			$required_access = $row->required_access; 
			if($this->accesslvl<=$required_access)
			{
				return $row->id;
			}
		}
		return false;
	}
	
	function alert_to_login($msg="", $second=0, $exit = true)//TB03
	{//
		if($this->thisclass!="home"){
			$msg	= empty($msg)?"Error code: TB03.\\nYou did not log in or your session has expired.":$msg;
			alert($msg);
			reload('home', $second, $exit);
		}
	}
	
	function alert_to_back($msg="", $second=0, $exit = true)//TB04
	{//
		if($this->thisclass!="home"){
			$msg	= empty($msg)?"Error code: TB04.\\nSorry, access is not granted.":$msg;
			alert($msg);
			reload($this->url_back, $second, $exit);
		}
	}
	
	function get_access_level($id_user = false)
	{
	    if($id_user === false) return false;
			
		$users_table 		= $this->tables['users'];
		$groups_table 		= $this->tables['groups'];
		$group_join 		= $this->ci->config->item('join_group');
		$user_id_column 	= $this->ci->config->item('user_id');
		$accesslvl_column 	= 'access_level';

		$query = $this->ci->db->select($groups_table.'.'.$accesslvl_column)
								->from($users_table)
								->join($groups_table, $users_table.'.'.$group_join.' = '.$groups_table.'.id')
								->where($users_table.'.'.$user_id_column, $id_user)
								->limit(1)
								->get();
		if ($query->num_rows() == 1)
		{
			return $query->row()->$accesslvl_column;
		}
		
		return false;
	}
	
	function logout()
	{
			$this->account		= '';
			$this->accesslvl	= 0;
			$this->query_main	= null;
	    	$identity = $this->ci->config->item('identity');
			$this->ci->session->unset_userdata($identity);
			$this->ci->session->unset_userdata('URLBACK');
			$this->ci->session->unset_userdata('TIMLELIVE');
			$this->ci->session->sess_destroy();
			redirect('home');
	}
	// write log
	function write_log()
	{
		if(!empty($this->account))
		{// actions not save
			$ar_class = array('home', '');
			$ar_func = array('view_log', '');
			if(!in_array($this->thisclass, $ar_class) and !in_array($this->thisfunc, $ar_func))
			{
				$uid = $this->get_userid($this->account);
				if($uid)
				{
					$numrecord = (int)$this->getNumRecordOfUser($uid);
					if($numrecord>=$this->numrecord)
					{// delete
						$query = $this->ci->db->select_min('id')->from('logs')->where('id_user', $uid)->get();
						$min_id = $query->num_rows()?$query->row()->id:0;
						$this->ci->db->delete('logs', array('id'=>$min_id));
					}
					
					$action		= $this->ci->uri->uri_string();
					$data['id_user'] = $uid;
					$data['action'] = $action;
					$data['times'] = time();
					$data['ip_address'] = $this->ci->input->ip_address();

					$this->ci->db->insert('logs', $data); 
				}
				else
				{
					$action		= $this->ci->uri->uri_string().': no data found.';
					$data['id_user'] = 0;
					$data['action'] = $action;
					$data['times'] = time();
					$data['ip_address'] = $this->ci->input->ip_address();
					
					$this->ci->db->insert('logs', $data); 
				}
			}
		}
	}
	
	function getNumRecordOfUser($uid)
	{
		return $this->ci->db->from('logs')->where('id_user', $uid)->count_all_results();
	}

	function get_userid()
	{
		$user_id_column 	= $this->ci->config->item('user_id');
		return $this->query_main->$user_id_column;
	}
	// extend
	function is_directadmin($curid=false)
	{
		if($this->accesslvl == 1) return true;
		
		$neid = $this->get_userid();
		
		if($neid == $curid) return true;
		if(!$neid or $curid==false) return false;
		
		$result = $this->ci->db->query("SELECT dir_admin, teamleader FROM user WHERE id=$curid LIMIT 1");
		if($result->num_rows())
		{
			$dir_admin = $result->row()->dir_admin;
			$teamleader = $result->row()->teamleader;
			if($neid==$teamleader or $neid==$dir_admin)
				return true;
		}
		return false;
	}
	
	function get_list()// get list id of current id manage
	{
		$neid = $this->get_userid();
		
		if(!$neid) return false;
		$return = array($neid);
		
		switch($this->accesslvl)
		{
			case 1: $wh = "WHERE id!=$neid";	break;
			case 2: $wh = "WHERE dir_admin=$neid";	break;
			case 3: $wh = "WHERE teamleader=$neid";	break;
			default:$wh = "WHERE teamleader=$neid";
		}
		
		$query = $this->ci->db->query("SELECT id FROM user $wh");
		
		if($query->num_rows())
		{
			foreach($query->result() as $row)
			{
				$id = $row->id;
				array_push($return, $id);
			}
		}
		return $return;
	}
	
	function checkLoginTime()
	{//
		if ($this->ci->config->item('login_time'))
		{
			$time_start = $this->query_main->time_start;
			$time_finish = $this->query_main->time_finish; 
			$time = time();
			$hour = (int)date('H', $time);
			$h = fmod($hour-1, 24); 	
			$h = $h<0?23:$h; 	
			if(!empty($time_start) and !empty($time_finish))
			{
				if(!($time_start<=$h and $h<$time_finish))
				{
					$this->logout();
				}
			}
		}
	}
	
}