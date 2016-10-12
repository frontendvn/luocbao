<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class khachhang_model extends Model {

	var $tb_class = 'khachhang';
	function khachhang_model()
	{
		parent::Model();
	}
	
	function insert($val)
	{
		if($this->db->insert($this->tb_class, $val)){
			return TRUE;
		}
		else return FALSE;
	}
	function show($id='')
	{
		$wh = empty($id)?"":"WHERE id_kh=$id";
		$res = $this->db->query("SELECT * FROM ".$this->tb_class." $wh ORDER BY id_kh DESC");
		if($res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function update($values)
	{
		if(empty($values['id_kh'])) return FALSE;
		if($this->db->update($this->tb_class, $values, array('id_kh'=>$values['id_kh']))){
			return TRUE;
		}
		return FALSE;
	}
	function delete($id)
	{
		if(empty($id)) return FALSE;
		
		if($this->db->delete($this->tb_class, array('id_kh' => $id)))
		{
			return TRUE;
		}
		return FALSE;
	}
}
?>