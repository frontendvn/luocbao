<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class search_model extends Model {
	function search_model()
	{// Call the Model constructor
			parent::Model();
	}

	function show($keyword='',$numperpage=10,$page=0)//5-8-2010
	{
		/*$wh = " WHERE 1 ";
		$wh .= empty($keyword)?"":" AND (news_title LIKE '%".$keyword."%' OR news_quickview LIKE '%".$keyword."%' OR news_content LIKE '%".$keyword."%')";
		$sql = $this->db->query(" SELECT id_news,id_nwc,id_text,id_cattext,news_title,news_quickview,news_img_thumb,news_date,news_author
		 FROM news $wh AND news_show='1'  AND news_audit='1' AND news_delete!='1' ORDER BY news_date DESC  LIMIT $page,$numperpage"); 
		if(is_object($sql) && $sql->num_rows()>0)
			return $sql;
		else return FALSE;*/
		
		$this->db->select('id_news,id_nwc,id_text,id_cattext,news_title,news_quickview,news_img_thumb,news_date,news_author'); 
		$this->db->from('news');
		if(!empty($keyword))
			$this->db->like('news_title', $keyword)->or_like('news_quickview', $keyword)->or_like('news_content', $keyword);
		$this->db->order_by('news_date', 'DESC');
		$this->db->limit($numperpage, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)
			return $query;
		else return FALSE;
	}
	
	function total($keyword='')//5-8-2010
	{
		if(empty($keyword)) return FALSE;
		$wh = " WHERE news_audit='1' AND news_show='1' AND news_delete!='1' ";
		$wh .= empty($keyword)?"":" AND (news_title LIKE '%".$keyword."%' OR news_quickview LIKE '%".$keyword."%' OR news_content LIKE '%".$keyword."%')";
		$sql = $this->db->query(" SELECT count(id_news) As total_news FROM news $wh");
		
		if($sql->num_rows()>0)
		{
			return $sql->row()->total_news;
		}
		else return FALSE; 
	}
}
?>