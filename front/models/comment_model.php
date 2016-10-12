<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class comment_model extends Model {
	function comment_model()
	{// Call the Model constructor
			parent::Model();
	}

	function insert_comment($val)//2-8-2010
	{
		if($this->check_comment_exist($val['id_text'],$val['email']))
			return false;
		else{
			if($this->db->insert('comment', $val))
		{
			return TRUE;
		}
		return FALSE;
		}
	}
	
	function check_comment_exist($id_text=false,$email=false)//2-8-2010
	{
		if($id_text===false || $email===false){
			return false;
		}
		$query = $this->db->query("SELECT id FROM comment WHERE UPPER(id_text) = UPPER('$id_text') AND email='$email' LIMIT 1");
		
		if ($query->num_rows() == 1)
		{
			return $query->num_rows();
		}
		return false;
	}
}
?>