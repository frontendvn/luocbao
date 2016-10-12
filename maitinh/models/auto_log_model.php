<?php
/**
 * Class auto_log_model
 * handles tables in DB
 */
 class auto_log_model extends Model {
 	// assign table name
	var $tb_class = 'autonews_logs';
	function auto_log_model()
	{// Call the Model constructor
			parent::Model();
	}

	function select_auto_log($status='', $from=0, $to=0, $limit = 100, $offset = 0)
	{//get all introduce		
		$status = $status ? "AND status='$status'" : '';
		$from = $from ? "AND times>=$from" : '';
		$to = $to ? "AND times<=$to" : '';
		$sql = "SELECT 
					id, id_crawler, website, links, times, status, id_news, id_nwc, news_title, notes
				FROM 
					autonews_logs
				WHERE id>0 $status $from $to
				ORDER BY id DESC
				LIMIT  $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function empty_log()
	{//		
		$this->db->truncate($this->tb_class);
	}
	
	function del_log($status='', $from=0, $to=0)
	{//		
		if($status) $this->db->where('status', $status);
		if($from) $this->db->where('times >=', $from);
		if($to) $this->db->where('times <=', $to);
		$this->db->delete($this->tb_class); 
	}
}
