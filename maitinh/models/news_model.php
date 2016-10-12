<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class news_model extends Model {
	var $_table_news = 'news';
	var $_table_news_cat = 'news_cat';
    function news_model()
    {// Call the Model constructor
        parent::Model();
    }

	function select($cid ="", $id="", $limit = 100, $offset = 0)
	{//get all introduce		
		$wh = ($cid)?"AND id_nwc = '".$cid."'":"";
		$wh .= ($id)?"AND id_news = '".$id."'":$wh;
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, news_show, news_quickview, news_audit,
					news_author, id_nwc, news_tag, news_content, news_audit, id_text, id_cattext, news_meta, news_lead, 
					news_specialtime, news_useful, news_special, news_link
				FROM news 
				WHERE  news_delete!='1' $wh 
				ORDER BY id_news DESC 
				LIMIT $offset, $limit";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_news_audit($cid ="")
	{//get all introduce		
		$wh = ($cid)?"AND id_nwc = '".$cid."'":"";
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, news_show, news_quickview, news_audit,
					news_author, id_nwc, news_tag, news_content, news_audit, id_text, news_meta, news_lead, news_specialtime
				FROM news 
				WHERE news_audit='1' AND news_delete!='1' $wh 
				ORDER BY id_news DESC";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_audit($cid ="")
	{//get all introduce		
		$wh = ($cid)?"AND id_nwc = '".$cid."'":"";
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, news_show, news_quickview, news_audit, 
					news_author, id_nwc, news_tag, news_content, news_audit, id_text, news_meta, news_lead, news_specialtime
				FROM news 
				WHERE news_audit!='1' AND news_delete!='1' $wh 
				ORDER BY id_news";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function audit($id, $show='1')
	{// on off a category
		$sql = "UPDATE ".$this->_table_news." SET news_audit= '$show' WHERE id_news=$id";
		if($this->db->query($sql))
			return true;
		return false;
	}

	function insert($table,$values)
	{// insert new introduce
		if($this->db->insert($table, $values)){
			return TRUE;
		}
		else return FALSE;
	}
	
	function _delete($id)
	{// delete new introduce				
		$c = false;
		$row = $this->db->query("SELECT news_img, news_img_thumb, news_meta, news_video, news_video_meta FROM news WHERE id_news='$id'")->row();
		if(is_object($row)){
			$image = $row->news_img;
			if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
			$image = $row->news_img_thumb;
			if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
			$news_meta = $row->news_meta;
			$ar_image = empty($news_meta) ? array() : explode('~', $news_meta);
			foreach($ar_image as $vl)
			{
				if(!empty($vl) and file_exists(ROOT.$vl)) @unlink("../".$vl);
			}
			$video = $row->news_video;
			if(!empty($video) and file_exists(ROOT.$video)) @unlink(ROOT.$video);
			$news_video_meta = $row->news_video_meta;
			$ar_video = empty($news_video_meta) ? array() : explode('~', $news_video_meta);
			foreach($ar_video as $vl)
			{
				if(!empty($vl) and file_exists(ROOT.$vl)) @unlink("../".$vl);
			}
			// Next deleted records in some tables that have relation.
			$this->db->where('id_news', $id);
			$this->db->delete('comment');
			//
			$c = $this->db->query("DELETE FROM news WHERE id_news='$id'");
		}
		return $c;
	}
	
	function delete($id)
	{// update news_delete
		$values['id_news'] = $id;
		$values['news_delete'] = '1';
		if($this->db->update("news", $values, array('id_news' => $values['id_news'])))
			return TRUE;
		else return FALSE;
	}
	
	function update($values)
	{// update new introduce
		/*$old_data = $this->db->query("SELECT news_img,news_img_thumb FROM news WHERE id_news='".$values['id_news']."'")->row();
		if(!empty($values['news_img'])) { // new images submited, remove old one
			$full_image_link = $old_data->news_img;
			if(!empty($full_image_link)) @unlink("../".$full_image_link);
			$full_image_link = $old_data->news_img_thumb;
			if(!empty($full_image_link)) @unlink("../".$full_image_link);
		}*/
		if($this->db->update("news", $values, array('id_news' => $values['id_news'])))
			return TRUE;
		else return FALSE;
	}

	function show($id)
	{// on off a category
		//lay tinh trang the hien cua ba tin va cua loai ban tin
		$sql = "SELECT a.news_show, b.nwc_shown FROM news a, news_cat b WHERE a.id_news=$id AND a.id_nwc=b.id_nwc";
		$row =$this->db->query($sql)->row();
		if(is_object($row)){
			$cshow = $row->nwc_shown;
			$nshow = $row->news_show;
			if(empty($cshow))//neu cha no ma bi an thi chinh no cung phai set bi an cho du no dang hien
				$sql = "UPDATE news SET news_show= '0' WHERE id_news=$id";
			else{
				$nshow= ($nshow=="1")?"0":"1";
				$sql = "UPDATE news SET news_show= '$nshow' WHERE id_news=$id";
			}
			if($this->db->query($sql))
				return true;
		}
		return false;
	}

	function select_news_near($id ="")
	{//get all introduce		
		$sql = "SELECT 
					id_news, id_nwc
				FROM news 
				WHERE news_audit!='1' AND news_delete!='1' AND id_news!=$id
				ORDER BY id_news DESC
				LIMIT 1";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_search($cid ="", $text='')
	{//get all introduce		
		$wh = ($cid)?"AND id_nwc = '".$cid."'":"";
		$wh1 = ($text)?"AND (news_title LIKE '%".$text."%' OR news_quickview LIKE '%".$text."%' OR news_content LIKE '%".$text."%')":"";
		$sql = "SELECT 
					id_news, news_title, news_viewcount, news_img, news_img_thumb, news_show, news_quickview, news_audit,
					news_author, id_nwc, news_tag, news_content, news_audit, id_text, news_meta, news_lead, news_specialtime,
					id_cattext, news_lead, news_useful
				FROM news 
				WHERE news_audit='1' AND news_delete!='1' $wh $wh1
				ORDER BY id_news DESC";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_news_for_lead($id)
	{//get all introduce
		if(empty($id))	return false;	
		
		$sql = "SELECT 
					id_news
				FROM news 
				WHERE news_audit='1' AND news_show='1' AND news_delete!='1' AND id_news = $id";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_count_news_for_lead()
	{//get all introduce
		$sql = "SELECT 
					count(id_news) as nums
				FROM news 
				WHERE news_lead='1' AND news_delete!='1'";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_count_news_for_useful()
	{//get all introduce
		$sql = "SELECT 
					count(id_news) as nums
				FROM news 
				WHERE news_useful='1' AND news_delete!='1'";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_old_news_for_lead()
	{//get all introduce
		$sql = "SELECT 
					id_news
				FROM news 
				WHERE news_lead='1'  AND news_delete!='1'
				ORDER BY news_lead_create_date
				LIMIT 1";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_old_news_for_useful()
	{//get all introduce
		$sql = "SELECT 
					id_news
				FROM news 
				WHERE news_useful='1'  AND news_delete!='1'
				ORDER BY news_useful_create_date
				LIMIT 1";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_special()
	{//get all introduce		
		$sql = "SELECT 
					id_news, news_title, news_viewcount, id_nwc, id_text, id_cattext, news_special_create_date, news_specialtime
				FROM news 
				WHERE news_special='1' AND news_delete!='1'
				ORDER BY news_special_create_date DESC
				LIMIT 1";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function select_lead()
	{//get all introduce		
		$sql = "SELECT 
					id_news, news_title, news_viewcount, id_nwc, id_text, id_cattext, news_lead_create_date
				FROM news 
				WHERE news_lead='1' AND news_delete!='1'
				ORDER BY news_lead_create_date DESC";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function select_useful()
	{//get all introduce		
		$sql = "SELECT 
					id_news, news_title, news_viewcount, id_nwc, id_text, id_cattext, news_useful_create_date
				FROM news 
				WHERE news_useful='1' AND news_delete!='1'
				ORDER BY news_useful_create_date DESC";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

}
?>