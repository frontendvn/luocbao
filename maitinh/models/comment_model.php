<?php
 class comment_model extends Model {
	function comment_model()
	{// Call the Model constructor
			parent::Model();
	}
	
	function show($shown=0)//16-8-2010
	{ 
		$query = $this->db->query("SELECT a.id_text,a.id_cattext,a.news_title,c.* 
		 FROM news a,comment c WHERE a.id_news=c.id_news AND c.shown='$shown' ORDER BY c.comm_time DESC,a.id_news DESC"); 
		if(is_object($query) && $query->num_rows()>0)
			return $query;
		else return FALSE;
	}
	
	function delete($table,$field,$id)
	{
		if(empty($table) || empty($field) || empty($id)) return FALSE;
		return $this->db->delete($table,array($field=>$id));
	}

	function switch_state($id)//28-7-2010
	{
		$where['id'] = $id;
		$current_state = $this->db->getwhere("comment", $where, 1)->row()->shown;
		if($current_state == 0)	$this->db->query( "UPDATE  comment  SET shown= '1' WHERE id=".$id);
		else  $this->db->query("UPDATE  comment  SET shown= '0' WHERE id=".$id);
	}
	
}
?>