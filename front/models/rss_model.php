<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class rss_model extends Model {
	function rss_model()
	{// Call the Model constructor
			parent::Model();
	}

	function select_news_cat($id_cattext, $limit = 100, $offset = 0)
	{//
		$this->db->select('news.id_news, news.id_text, news.id_cattext, news.id_nwc, news.news_title, news.news_quickview, news.news_date, news_cat.nwc_name');
		$this->db->from('news');
		$this->db->join('news_cat', 'news.id_nwc=news_cat.id_nwc');
		$this->db->where('news.news_show', '1');
		$this->db->where('news.news_delete !=', '1');
		$this->db->where('news.news_audit', '1');
		$this->db->where('news.id_cattext', $id_cattext);
		$this->db->order_by('news.id_news', 'DESC');
		$this->db->limit($limit, $offset);
				
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_in_array_cat($ar_cid, $limit = 100, $offset = 0)//7-8-2010
	{//
		$this->db->select('id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_date');
		$this->db->from('news');
		$this->db->where('news_show', '1');
		$this->db->where('news_audit', '1');
		$this->db->where('news_delete !=', '1');
		$this->db->where_in('id_nwc', $ar_cid);
		$this->db->order_by('id_news', 'DESC');
		$this->db->limit($limit, $offset);
				
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_in_choose_cat_today($time, $cid ="", $limit = 10, $offset = 0)
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
	
	function get_cat_info($id_cattext=0)
	{
		$res = $this->db->query("SELECT nwc_name, id_nwc FROM news_cat WHERE id_cattext='$id_cattext'");
		if($res->num_rows()>0)
		{
			return $res->row(0);
		}
		return false;
	}
	
	function select_sub_cat($id_nwc='', $limit = 100, $offset = 0)
	{//
		$sql = "SELECT 
					id_nwc
				FROM 
					news_cat
				WHERE nwc_shown='1' AND nwc_pid=$id_nwc
				ORDER BY id_nwc
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
}
?>