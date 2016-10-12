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
		$sql = "SELECT 
					id_news
				FROM 
					news
				WHERE news_link='$link' OR news_title='$title'";			
		$query = $this->db->query($sql);
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
	
	function select_crawler_min()
	{//get all introduce		
		$sql = "SELECT 
					min(id) as id
				FROM 
					crawler
				WHERE available!='0'";
				
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
	
	function get_a_pattern($id_crawler)
	{//get all introduce		
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.id_cattext, a.links, a.available, b.name, b.website, 
					b.link_xpath, b.link_open, b.link_close, b.link_bad, b.title_xpath, b.title_open, b.title_close, b.title_bad, 
					b.intro_xpath, b.intro_open, b.intro_close, b.intro_bad, b.content_xpath, b.content_open, b.content_close, b.content_bad, 
					b.author_xpath, b.author_open, b.author_close, b.author_bad, b.times, b.time_update 
				FROM 
					crawler a, website_pattern b
				WHERE a.id_pattern=b.id_pattern AND a.available!='0' AND a.id=$id_crawler";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
}
