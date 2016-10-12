<?php
/**
* library: cookie online users
*/
class vote_online_lib{
	var $CI;
	var $table = "history_vote";
	const COOKIE_NAME = "vote_TimeLog";
	var $ip;
	var $timelog;
	var $time_live = 5184000;//60*60*24*60 2 thang
	//
	function  vote_online_lib($props = array()) {
			$this->initialize($props);
	}
	//
	function initialize($config = array())
	{//
		//start CI + database
		$this->CI =& get_instance();
		//load database
		$this->CI->load->database();
		//khoi tao cho class
		$this->ip 			= $_SERVER['REMOTE_ADDR'];
		$this->timelog	= empty($_COOKIE[self::COOKIE_NAME])?"":$_COOKIE[self::COOKIE_NAME];
		$this->times		= time();
		$this->timeout 	= $this->times-$this->time_live;
		//kiem tra co cookies chua
		$this->check_time_live();
	}
	
	function check_time_live()
	{//
 		// if ko ton tai thi khoi tao cookie va luu vao db
		if(empty($this->timelog))
		{
			$this->ceate_cookie();
			// luu db
			$data['ip'] 			= $this->ip;
			$data['session'] 	= $this->timelog;
			$data['times'] 		= $this->times;
			$this->insert_db($data);
		}
		else
		{// kiem tra trong db
				$times = $this->get_time();
				// neu chua qua time_live thi update time
				if($times)
				{
					if($this->times-$times < $this->time_live)	
						$this->update(array('times'=>$this->times));
				}
				else
				{// chua co trong db thi them vao
					$data['ip'] 			= $this->ip;
					$data['session'] 	= $this->timelog;
					$data['times'] 		= $this->times;
					$this->insert_db($data);
				}
		}
	}

	function ceate_cookie($value=array())
	{// 
			$value['value'] = empty($value['value']) ? md5(time($this->times)).rand(1,1000) : $value['value'];
			$value['times'] = empty($value['times']) ? $this->times+$this->time_live : $value['times'];
			$value['name'] = empty($value['name']) ? self::COOKIE_NAME : $value['name'];
			
			setcookie($value['name'], $value['value'], $value['times']);
			$this->timelog	= $value['value'];
	}

	function insert_db($data=array())
	{// 
			return $this->CI->db->insert($this->table, $data);  
	}

	function update($vl=array())
	{// 
			return $this->CI->db->update($this->table, $vl, array('ip'=>$this->ip, 'session'=>$this->timelog)); 
	}

	function get_time()
	{// 
			$query = $this->CI->db->query("SELECT times FROM ".$this->table." WHERE ip='".$this->ip."' AND session='".$this->timelog."'");
			if($query->num_rows()>0)
			{
				return $query->row(0)->times;
			}
			else return FALSE;
	}

	function get_id_vote()
	{// 
			$query = $this->CI->db->query("SELECT id_vote FROM ".$this->table." WHERE ip='".$this->ip."' AND session='".$this->timelog."'");
			if($query->num_rows()>0)
			{
				return $query->row(0)->id_vote;
			}
			else return FALSE;
	}
}
?>