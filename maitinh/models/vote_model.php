<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class vote_model extends Model {
	function vote_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($id="", $limit = 1000, $offset = 0)
	{//get all introduce		
		$wh = ($id)?"AND q.id_vo = '$id'":"";
		$sql = "SELECT * FROM vote WHERE id_vo > 0 $wh ORDER BY id_vo DESC LIMIT $offset, $limit";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function insert($table,$values)
	{// insert new introduce
		if($this->db->insert($table, $values)){
			return TRUE;
		}
		else return FALSE;
	}
	function delete($id)
	{// 
		
		$where_a['id_vo'] = $id;
		$this->db->delete("vote_content", $where_a);
		//
		$c = false;
		$rs1 = $this->db->query("SELECT image_vo FROM vote WHERE id_vo='$id'");
		if($rs1->num_rows()>0)
		{
			$row = $rs1->row();
			$image = $row->image_vo;
			@unlink("../".$image);
	
			$rs1->free_result();
	
			$where1['id_vo'] = $id;
			$c = $this->db->delete("vote", $where1);
		}
		return $c;
	}
	function update($values)
	{// update
		
		if($this->db->where('id_vo', $values['id_vo']) && $this->db->update("vote", $values))
			return TRUE;
		else return FALSE;
	}
	function search($key="", $id=0)
	{//	
		$wh1 = ($key)?"AND q.title_vo LIKE '%$key%'":"";
		$wh2 = ($id)?"AND q.id_vo = $id":"";
		$sql = "SELECT q.id_vo, q.title_vo, q.comment_vo, q.times_vo, q.types_vo, q.show_vo, (SELECT COUNT(a.id_vc) FROM vote_content a WHERE a.id_vo=q.id_vo) AS counts FROM vote q WHERE q.id_vo>0 $wh1 $wh2 ORDER BY q.id_vo DESC";
		$res = $this->db->query($sql);
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function select_vote_contents($array_qid)
	{
		if(empty($array_qid)) return FALSE;
		$this->db->where_in('id_vo', $array_qid);
		$this->db->order_by('id_vc asc, position_vc asc');
		$query = $this->db->get('vote_content');
		if($query->num_rows()>0)
			return $query;
		return FALSE;
	}
	
}
?>