<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class vote_model extends Model {
	function vote_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select_vote($id, $limit = 100, $offset = 0)
	{
		$sql = "SELECT b.id_vc, b.position_vc, b.content_vc, b.image_vc, b.id_vo, b.result_vc, a.title_vo 
						FROM vote a, vote_content b
						WHERE a.id_vo=b.id_vo AND b.id_vo=$id AND a.show_vo='1'
						ORDER BY b.position_vc, b.id_vc 
						LIMIT $offset, $limit";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function select_vote_full($id, $limit = 100, $offset = 0)
	{
		$sql = "SELECT b.*, a.* 
						FROM vote a, vote_content b
						WHERE a.id_vo=b.id_vo AND b.id_vo=$id AND a.show_vo='1'
						ORDER BY b.position_vc, b.id_vc 
						LIMIT $offset, $limit";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function update_vote_content($vl)
	{
		//return $this->db->update("vote_content", $vl, array('id_vo'=>$vl['id_vo'], 'position_vc'=>$vl['position_vc']));
		$sql = "UPDATE vote_content SET result_vc=result_vc+1 WHERE id_vo=".$vl['id_vo']." AND position_vc=".$vl['position_vc'];
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
}