<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class capnhat_model extends Model {
 	// assign table name
	var $tb_class = 'news';
	function capnhat_model()
	{// Call the Model constructor
			parent::Model();
	}

	function insert($values)
	{// insert new class
		if($this->db->insert($this->tb_class, $values))
			return TRUE;
		else return FALSE;
	}
	
	function check_news($link, $title)
	{//	
		$this->db->select('id_news');
		$this->db->from($this->tb_class);
		$this->db->where('news_link', $link);
		$this->db->or_where('news_title', $title);
		$query = $this->db->get();
					
		if ($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}

	function select_all_pattern()
	{//get all introduce		
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.id_cattext, a.links, a.available, b.name, b.html_open, b.html_close, 
					b.website, b.title_open, b.title_close, b.intro_open, b.intro_close, b.content_open, b.content_close, 
					b.author_open, b.author_close, b.times, b.time_update 
				FROM 
					crawler a, news_pattern b
				WHERE a.id_pattern=b.id_pattern AND a.available!='0'";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_crawler_next($id)
	{//get all introduce		
		$sql = "SELECT 
					id
				FROM 
					crawler
				WHERE id>$id AND available!='0'
				ORDER BY id
				LIMIT 1";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_crawler_min($id)
	{//get all introduce		
		$sql = "SELECT 
					min(id) as id
				FROM 
					crawler";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_a_pattern($id_crawler)
	{//get all introduce		
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.id_cattext, a.links, a.available, b.name, b.html_open, b.html_close, 
					b.website, b.title_open, b.title_close, b.intro_open, b.intro_close, b.content_open, b.content_close, 
					b.author_open, b.author_close, b.times, b.time_update 
				FROM 
					crawler a, news_pattern b
				WHERE a.id_pattern=b.id_pattern AND a.available!='0' AND a.id=$id_crawler";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function get_crawl_info($set_crawl_id)
	{//	
		/*$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.id_cattext, a.links, a.available, b.name, b.html_open, b.html_close, 
					b.website, b.title_open, b.title_close, b.intro_open, b.intro_close, b.content_open, b.content_close, 
					b.author_open, b.author_close, b.times, b.time_update 
				FROM 
					crawler a, news_pattern b
				WHERE a.id_pattern=b.id_pattern AND a.available!='0' AND a.id IN $set_crawl_id";
				
		$result = $this->db->query($sql);
		if ($result->num_rows()>0) {
			return $result;
		}
		return FALSE;*/
		
		if(empty($set_crawl_id)) return FALSE;
		
		$this->db->select('crawler.id, crawler.id_pattern, crawler.id_nwc, crawler.id_cattext, crawler.links, crawler.available, 
		news_pattern.name, news_pattern.html_open, news_pattern.html_close, news_pattern.website, news_pattern.title_open, 
		news_pattern.title_close, news_pattern.intro_open, news_pattern.intro_close, news_pattern.content_open, 
		news_pattern.content_close, news_pattern.author_open, news_pattern.author_close, news_pattern.times, news_pattern.time_update');
		$this->db->from('crawler');
		$this->db->join('news_pattern', 'crawler.id_pattern = news_pattern.id_pattern');
		$this->db->where_in('crawler.id', $set_crawl_id);
		$this->db->where('crawler.available !=', '0');
		$this->db->order_by('crawler.id', 'ASC');
		
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res;
		else
			return FALSE;
	}

	function get_crawl_id($is_video, $offset=0, $limit=100)
	{//	
		if($is_video)
		{
			$sql = "SELECT 
						id 
					FROM 
						crawler
					WHERE available!='0' AND is_video='1'
					LIMIT 5";
		}
		else
		{
			$sql = "SELECT 
						id 
					FROM 
						crawler
					WHERE available!='0' AND is_video!='1'
					LIMIT $offset, $limit";
		}		
		$result = $this->db->query($sql);
		if ($result->num_rows()>0) {
			return $result;
		}
		return FALSE;
	}
	
}
