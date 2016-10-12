<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class skin_model extends Model {

	function skin_model()
	{
		parent::Model();	
	}
	
	function insert_skin($val)
	{
		if($this->db->insert("block_skin", $val)){
			return TRUE;
		}
		else return FALSE;
	}
	function update($val)
	{
		if(empty($val['id'])) return FALSE;
		if($this->db->update('block_skin', $val, array('id' => $val['id'])))
			return TRUE;
		else
			return FALSE;
	}
	function show($id=''){
		$wh = empty($id)?" ORDER BY id DESC":" WHERE id='$id' LIMIT 1"; 
		$sql = $this->db->query("SELECT * FROM block_skin $wh ");
		if(is_object($sql) && $sql->num_rows()>0)
			return $sql;
		else return FALSE;
	}
	function delete($id)
	{
		if(empty($id)) return FALSE;
		$where['skin'] = $id;
		$this->db->delete("blocks", $where);
		return $this->db->delete('block_skin', array('id' => $id)); 
	}
}
?>