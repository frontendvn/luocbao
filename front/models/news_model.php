<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class news_model extends Model {
	function news_model()
	{// Call the Model constructor
			parent::Model();
	}

	function news_detail($id)//4-8-2010
	{
		if(empty($id)) return FALSE;
		$sql = $this->db->query("SELECT id_news,id_text, news_title, news_img,news_quickview, news_author, id_nwc,id_cattext, news_tag, news_content, news_date FROM news WHERE id_text='$id' AND news_audit='1' AND news_show='1' AND news_delete!='1' LIMIT 1");
		if($sql->num_rows()>0)
			return $sql;
		else
			return false;
	}
	function news_others($id,$id_cattext)//4-8-2010
	{
		if(empty($id) || empty($id_cattext)) return FALSE;
		$sql = $this->db->query("SELECT id_news,id_text,news_title,id_cattext FROM news WHERE id_text !='$id' AND id_cattext='$id_cattext' AND news_audit='1' AND news_show='1' AND news_delete!='1' ORDER BY id_news DESC LIMIT 12");
		if($sql->num_rows()>0)
			return $sql;
		else
			return false;
	}

	function get_cat($id_cattext=0)
	{
		$res = $this->db->query("SELECT id_nwc,nwc_name,nwc_pid FROM news_cat WHERE id_cattext='".$id_cattext."'");
		if(is_object($res) && $res->num_rows()>0)
		{
			$cat = $res->row(0); 
			$cat_name = $cat->nwc_name;
			$link_str = $cat_name;
			return $link_str;
		}
		else return "";
	}
	
	function select_news_cat($ar_cid, $limit = 100, $offset = 0)//7-8-2010
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
	
	function show_comment($id_text)//2-8-2010
	{
		if(empty($id_text)) return FALSE;
		$query = $this->db->query(" SELECT fullname,content,comm_time FROM comment WHERE shown='1' AND id_text='$id_text' ORDER BY id DESC");
		if(is_object($query) && $query->num_rows()>0)
			return $query;
		else return FALSE;
	}

	function select_other_cat($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_cattext = '$cid'":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_date
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
	
	function select_random_news_other_cat($cid ="", $limit = 100, $offset = 0)
	{//
		$wh = ($cid)?"AND id_cattext != '$cid'":'';
		$sql = "SELECT 
					id_news, id_text, id_cattext, id_nwc, news_title, news_date
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $wh 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function get_name_cat($id_cattext=0)
	{
		$res = $this->db->query("SELECT nwc_name FROM news_cat WHERE id_cattext='$id_cattext'");
		if($res->num_rows()>0)
		{
			return $res->row(0)->nwc_name;
		}
		return false;
	}
	
	function news_preview($id)
	{
		if(empty($id)) return FALSE;
		$sql = $this->db->query("SELECT id_news,id_text, news_title, news_img,news_quickview, news_author, id_nwc,id_cattext, news_tag, news_content, news_date FROM news WHERE id_text='$id' AND news_delete!='1' LIMIT 1");
		if($sql->num_rows()>0)
			return $sql;
		else
			return false;
	}
	function link_tags($str_tags,$id_text,$id_cattext)
	{
		if(empty($str_tags)) return FALSE;
		$sql = $this->db->query(" SELECT id_text,id_cattext,news_title 
				FROM news WHERE news_show='1'  AND news_audit='1' AND news_delete!='1' AND ($str_tags) AND id_text!='$id_text' AND id_cattext='$id_cattext'  LIMIT 2 ");
		if(is_object($sql) && $sql->num_rows()>0)
			return $sql;
		else return FALSE; 
	}
	function select_max_view_count_news($ar_cid='', $fromtime='', $totime='', $limit = 100, $offset = 0)
	{//
		$this->db->select('id_news, id_text, id_cattext, id_nwc, news_title, news_img, news_img_thumb, news_quickview, news_viewcount, news_date');
		$this->db->from('news');
		$this->db->where('news_audit', '1');
		$this->db->where('news_show', '1');
		$this->db->where('news_delete !=', '1');
		$this->db->where('news_date >', $fromtime);
		$this->db->where('news_date <', $totime);
		$this->db->where_in('id_nwc', $ar_cid);
		$this->db->order_by('news_viewcount', 'DESC');
		$this->db->order_by('id_news', 'DESC');
		$this->db->limit($limit, $offset);
				
		$res = $this->db->get();
		
		/*$fromtime = $fromtime ? "AND news_date>=$fromtime" : '';
		$totime = $totime ? "AND news_date<=$totime" : '';
		$id_nwc = $id_nwc ? "AND id_cattext='$id_nwc'" : '';
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, id_cattext, id_text,
					news_quickview, id_nwc, news_date 
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $id_nwc $fromtime $totime 
				ORDER BY news_viewcount DESC, id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);*/
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_max_view_count_news_home($fromtime='', $totime='', $limit = 100, $offset = 0)
	{//
		$fromtime = $fromtime ? "AND news_date>=$fromtime" : '';
		$totime = $totime ? "AND news_date<=$totime" : '';
		
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, news_show, id_cattext,id_text,
					news_quickview, news_author, id_nwc, news_tag, news_content, news_date, news_audit 
				FROM 
					news
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' $fromtime $totime 
				ORDER BY news_viewcount DESC, id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function get_pid_name_cat($id_nwc='')
	{//
		$sql = "SELECT nwc_name FROM news_cat WHERE id_nwc=(SELECT 
					nwc_pid
				FROM 
					news_cat
				WHERE nwc_shown='1' AND id_nwc='$id_nwc')";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res->row()->nwc_name;
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