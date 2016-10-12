<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class printpage_model extends Model {
	function printpage_model()
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
}
?>