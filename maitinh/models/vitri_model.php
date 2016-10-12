<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class vitri_model extends Model {

	var $tb_class = 'vitri';
	function vitri_model()
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
		$wh = empty($id)?"":"WHERE id_vt=$id";
		$res = $this->db->query("SELECT * FROM ".$this->tb_class."   $wh ORDER BY ten_vt ASC");
		if($res->num_rows()>0)
			return $res;
		else return FALSE;
	}

	function select_list_qc($id='')//17-8-2010
	{
		$wh = empty($id)?"":" AND id_vitri=$id";
		$res = $this->db->query("SELECT * FROM quangcao WHERE temp=0  $wh ORDER BY id_vitri DESC, weight ASC");
		if($res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	
	function update($values)
	{
		if(empty($values['id_vt'])) return FALSE;
		if($this->db->update($this->tb_class, $values, array('id_vt'=>$values['id_vt']))){
			return TRUE;
		}
		return FALSE;
	}
	
	function update_qc($values)
	{
		if(empty($values['id'])) return FALSE;
		if($this->db->update('quangcao', $values, array('id'=>$values['id']))){
			return TRUE;
		}
		return FALSE;
	}
	
	function delete($id)
	{
		if(empty($id)) return FALSE;
		
		//$res = $this->db->query("SELECT image FROM quangcao WHERE id=$id");
		//if($res->num_rows()>0)
			//@unlink('../'.$res->row(0)->image);
		
		$this->db->delete('quangcao', array('id_vitri' => $id)); 
		return $this->db->delete($this->tb_class, array('id_vt' => $id)); 
	}
	function select_qc($ar_vt)//17-8-2010
	{
		if(empty($ar_vt)) return FALSE;
		$this->db->from('quangcao');
	//	$this->db->join('khachhang', 'quangcao.id_kh = khachhang.id_kh');
		$this->db->where_in('id_vitri', $ar_vt);
		$this->db->order_by('id_vitri asc, weight asc');
		$query = $this->db->get();
		if($query->num_rows()>0)
			return $query;
		return FALSE;
	}
	function new_vitri_check($title = false,$id=0)
	{
	    if ($title === false)
	    {
	        return false;
	    }
		$wh = empty($id)?"":" AND id_vt !='$id'";
	    $query = $this->db->query("SELECT * FROM vitri WHERE ten_vt = '$title'  $wh LIMIT 1");
		
		if ($query->num_rows() == 1)
		{
			return $query->num_rows();
		}
		return false;
	}
	function khachhang($id_kh)//17-8-2010
	{
		if(empty($id_kh)) return "";
		$sql = $this->db->query(" SELECT ten_kh FROM khachhang WHERE id_kh='$id_kh' LIMIT 1");
		if(is_object($sql) && $sql->num_rows()>0)
			return $sql->row()->ten_kh;
		else return "";
	}
}
?>