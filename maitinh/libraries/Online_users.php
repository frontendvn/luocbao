<?php
/**
* library: Online_users
*/
class Online_users{
	var $CI;
	var $table = "history_log_today";
	var $table_allday = "history_log_allday";
	var $ip;
	var $total_visited_allday;//
	var $total_visited;//
	var $timelog;
	var $time_live	= 600;//5 phut
	//
	function  Online_users($props = array()) {
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
		$this->timelog	= empty($_COOKIE['aca_TimeLog'])?"":$_COOKIE['aca_TimeLog'];
		$this->times		= time();
		$this->timeout 	= $this->times-$this->time_live;
		//kiem tra qua ngay moi chua de update db
		$this->chech_new_day();
		//kiem tra co cookies chua
		$this->check_time_live();
	}
	
	function chech_new_day()
	{// lay time lan truy cap cuoi hom truoc
			$query = $this->CI->db->query("SELECT MAX(times) as times FROM ".$this->table);
			if(is_object($query) && $query->num_rows()>0)
			{
				$times = $query->row()->times;
				if(date('d-m-y', $times)!==date('d-m-y', $this->times))
				{// ngay moi
					//dem so record trong table
					$count = $this->CI->db->count_all_results($this->table);
					// lay so truy cap nhieu nhat trong ngay
					$rs = $this->CI->db->query("SELECT nums_day FROM ".$this->table_allday);
					if(is_object($rs) && $rs->num_rows()>0)
					{//
						$nums_day = $rs->row()->nums_day;
						if($count>$nums_day)// so sanh so truy cap nhieu nhat trong 1 ngay va ngay hom qua
						{// neu > thi update: tong truy cap, so truy cap nhieu nhat, ngay truy cap nhieu nhat
							$dates = date('d/m/Y', $this->times-86400);
							$this->CI->db->query("UPDATE ".$this->table_allday." SET nums_visited =nums_visited +$count, nums_day=$count, dates='$dates'"); 
						}
						else
						{// neu < thi update: tong truy cap.
							$this->CI->db->query("UPDATE ".$this->table_allday." SET nums_visited =nums_visited +$count");
						}
					}
					else
					{// update: tong truy cap.
						$this->CI->db->query("UPDATE ".$this->table_allday." SET nums_visited =nums_visited +$count"); 
					}
					// empty table
					$this->CI->db->truncate($this->table);
				}
			}
	}
	function check_time_live()
	{//
		// if ko ton tai thi khoi tao cookie va luu vao db
		if(empty($this->timelog))
		{
			$value = md5(time($this->times)).rand(1,1000);
			setcookie("aca_TimeLog", $value, $this->times+$this->time_live);
			$this->timelog	= $value;
			// luu db
			$data['ip'] 			= $this->ip;
			$data['session'] 	= $value;
			$data['times'] 		= $this->times;
			$this->insert_db($data);
		}
		else
		{// kiem tra trong db
				$times = $this->get_time();
				// neu chua qua time_live thi update time
				if($times)
					if($this->times-$times < $this->time_live)	
						$this->update_times();
		}
	}
	function insert_db($data)
	{// 
			return $this->CI->db->insert($this->table, $data);  
	}
	function update_times()
	{// 
			return $this->CI->db->update($this->table, array('times'=>$this->times), array('ip'=>$this->ip, 'session'=>$this->timelog)); 
	}
	function get_time()
	{// 
			$query = $this->CI->db->query("SELECT a.times, nums_visited FROM ".$this->table." a, ".$this->table_allday." WHERE a.ip='".$this->ip."' AND a.session='".$this->timelog."'");
			if(is_object($query) && $query->num_rows()>0)
			{
				$this->total_visited_allday = $query->row(0)->nums_visited;
				return $query->row(0)->times;
			}
			else return FALSE;
	}
	//this function return the total number of total_visited_from_yesterday
	function total_visited_allday()
	{// 
			$query = $this->CI->db->query("SELECT nums_visited FROM ".$this->table_allday." LIMIT 1");
			if(is_object($query) && $query->num_rows()>0)
			{
				return $query->row(0)->nums_visited;
			}
			else return 0;
	}
	//this function return the total number of online users
	function total_users_online()
	{//
		$query = $this->CI->db->query("SELECT count(id) AS counts FROM ".$this->table." WHERE times>=".$this->timeout);
		if(is_object($query) && $query->num_rows()>0)
		{
			return $query->row()->counts;
		}
		else return 0;
	}
	//this function return the total number of total_visited_today
	function total_visited_today()
	{//
		$query = $this->CI->db->query("SELECT count(id) AS counts FROM ".$this->table);
		if(is_object($query) && $query->num_rows()>0)
		{
			$total_visited_today = $query->row()->counts;
			$total_visited_allday = $this->total_visited_allday();
			$this->total_visited = $total_visited_today + $total_visited_allday;
			
			return $total_visited_today;
		}
		else return 0;
	}

}
?>