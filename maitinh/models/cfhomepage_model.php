<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class cfhomepage_model extends Model {
	function cfhomepage_model()
	{// Call the Model constructor
			parent::Model();
	}

	function select_news_for_homepage($cid ="")
	{// 
		$this->db->select('id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_meta, news_video');
		$this->db->from('homepage_cache');
		if($cid) $this->db->where_in('id_nwc', $cid);// $cid is array
		$this->db->order_by('id_news', 'DESC');
		
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_news_cat($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_nwc = $cid":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_meta, news_video
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $wh 
				ORDER BY id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_news_video_cat($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_nwc = $cid":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_meta, news_video
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND news_video!='' $wh 
				ORDER BY id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_useful($limit = 100, $offset = 0)
	{//
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND news_useful='1'
				ORDER BY news_useful_create_date DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_in_choose_cat($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_nwc = $cid":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_viewcount
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $wh 
				ORDER BY news_viewcount DESC, id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_have_max_view_count($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_nwc = $cid":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_viewcount
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $wh 
				ORDER BY news_viewcount DESC, id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_lead($limit = 100, $offset = 0)
	{//
		$sql = "SELECT 
					id_news, id_nwc, id_text, id_cattext, news_title, news_img, news_img_thumb, news_quickview, news_date 
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND news_lead='1'
				ORDER BY news_lead_create_date DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_news_special($limit = 100, $offset = 0)
	{//
		$sql = "SELECT 
					id_news, id_nwc, id_text, id_cattext, news_title, news_img, news_img_thumb, news_quickview, news_date, 
					news_special_create_date, news_specialtime
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND news_special='1'
				ORDER BY news_special_create_date DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function insert($table, $value)
	{
		$this->db->insert($table, $value);
	}
	
	function select_list_video($limit = 100, $offset = 0)
	{//
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_video, news_video_meta
				FROM 
					news
				WHERE id_nwc=15 AND news_audit='1' AND news_show='1' AND news_delete!='1' AND news_video!=''
				ORDER BY id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_in_choose_cat_today($time, $cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_nwc = $cid":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date, news_viewcount
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND news_date>$time $wh 
				ORDER BY news_viewcount DESC, id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
}