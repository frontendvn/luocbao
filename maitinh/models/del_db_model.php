<?php
/**
 * Class del_db_model
 * handles tables in DB
 */
 class del_db_model extends Model {
	function del_db_model()
	{// Call the Model constructor
			parent::Model();
	}

	function delete($from=0, $to=0)
	{//		
		if(empty($from) and empty($to)) return FALSE;
		// The first get images and video.
		$from = $from ? "AND news_date >=$from" : '';
		$to = $to ? "AND news_date <=$to" : '';
		
		$sql = "SELECT id_news, news_img, news_img_thumb, news_meta, news_video, news_video_meta 
				FROM news 
				WHERE id_news > 0 $from $to";
		$rs = $this->db->query($sql);
		if($rs->num_rows()>0)
		{
			$ar_id_news = array();
			foreach($rs->result() as $row)
			{// Then unlink them.
			    array_push($ar_id_news, $row->id_news);
				$image = $row->news_img;
				if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
				$image = $row->news_img_thumb;
				if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
				$news_meta = $row->news_meta;
				$ar_image = empty($news_meta) ? array() : explode('~', $news_meta);
				foreach($ar_image as $vl)
				{
					@unlink("../".$vl);
				}
				$video = $row->news_video;
				if(!empty($video) and file_exists(ROOT.$video)) @unlink(ROOT.$video);
				$news_video_meta = $row->news_video_meta;
				$ar_video = empty($news_video_meta) ? array() : explode('~', $news_video_meta);
				foreach($ar_video as $vl)
				{
					@unlink("../".$vl);
				}
			}
			
			// Next deleted records in some tables that have relation.
			$this->db->where_in('id_news', $ar_id_news);
			$this->db->delete('comment');
			// Final, do main work - deleted records in table news 
			$this->db->where_in('id_news', $ar_id_news);
			return $this->db->delete('news'); 
		}
		
		return FALSE;
	}
	
}
