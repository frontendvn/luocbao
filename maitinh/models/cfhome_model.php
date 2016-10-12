<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class cfhome_model extends Model {

	function cfhome_model()
	{
		parent::Model();	
	}
	function blocks_default()
	{
		$sql = $this->db->query("SELECT id,title,mota FROM blocks WHERE id_content='A' AND  id NOT IN 
		(SELECT blocks_id FROM block_pos 
		WHERE id_column='h_1' OR  id_column='h_2'OR  id_column='h_3' OR id_column='h_4' OR id_column='h_5' OR id_column='h_6' ) 
		 ORDER BY id ASC");
		return $sql;
	}
	function block_config($blocks_name)
	{
		if(empty($blocks_name)) return FALSE;
		$sql = $this->db->query("SELECT a.id,a.blocks_id,b.title,b.mota FROM block_pos a,blocks b 
		WHERE  a.id_column='$blocks_name' AND a.blocks_id=b.id  ORDER BY a.position ASC  ");
		return $sql;
	}
	function delete_blocks($blocks_name)
	{
		if(empty($blocks_name)) return FALSE;
		return $this->db->query("DELETE FROM block_pos WHERE id_column='$blocks_name' ");
	}
	function blocks_default_detail()
	{
		$sql = $this->db->query("SELECT id,title,mota FROM blocks WHERE  id NOT IN 
		(SELECT blocks_id FROM block_pos WHERE id_column='d_1' OR  id_column='d_2' OR  id_column='d_3')  ORDER BY id ASC");
		return $sql;
	}
	function blocks_default_cat()
	{
		$sql = $this->db->query("SELECT id,title,mota FROM blocks WHERE id_content='A' AND  id NOT IN 
		(SELECT blocks_id FROM block_pos 
		WHERE id_column='c_1' OR  id_column='c_2'OR  id_column='c_3' ) 
		 ORDER BY id ASC");
		return $sql;
	}
}
?>