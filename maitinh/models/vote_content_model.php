<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class vote_content_model extends Model {
	function vote_content_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($cid ="", $id="", $limit = 100, $offset = 0)
	{//get all introduce		
		$wh = ($cid)?"AND b.id_vo = '".$cid."'":"";
		$wh = ($id)?"AND b.id_vc = '".$id."'":$wh;
		$sql = "SELECT b.id_vc, b.position_vc, b.content_vc,  b.id_vo, a.types_vo as qtypes 
						FROM vote a, vote_content b
						WHERE a.id_vo=b.id_vo $wh 
						ORDER BY b.position_vc, b.id_vc 
						LIMIT $offset, $limit";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function insert($table,$values)
	{// insert new introduce
		$max_weight = $this->get_heaviest($values['id_vo']);
		$values['position_vc'] = 1 + $max_weight;
		if($this->db->insert($table, $values)){
			return TRUE;
		}
		else return FALSE;
	}
	function delete($id, $qid)
	{// delete new introduce				
		$rs = $this->select('', $id);
		if($rs) @unlink('../'.$rs->row()->image_vc);
		
		$where['id_vc'] = $id;
		$where['id_vo'] = $qid;
		if($this->db->delete("vote_content", $where)){
			$this->re_sort($qid);
			return TRUE;
		}
		return FALSE; 
	}
	function update($values)
	{//
		if($this->db->where('id_vc', $values['id_vc']) && $this->db->update("vote_content", $values))
			return TRUE;
		else return FALSE;
	}
	function update_vote($values)
	{// update vote
		if($this->db->where('id_vo', $values['id_vo']) && $this->db->update("vote", $values))
			return TRUE;
		else return FALSE;
	}
	function get_heaviest($qid)
	{// get heaviest item in a branch (qid)
		$sql = "SELECT MAX(position_vc) AS position FROM vote_content WHERE id_vo ='$qid'";
		return $this->db->query($sql)->first_row()->position;
	}
	function re_sort($qid)
	{// re-sort all items which are in the same level
	// needed when : after deleting an item
	// needed when : after moving a branch to a new node
		$result = $this->db->query("SELECT id_vc FROM vote_content WHERE id_vo=$qid ORDER BY position_vc");
		if($result->num_rows()){
			$order = 0;
			foreach($result->result() as $row):
				$order++; 
				$this->db->query("UPDATE vote_content SET position_vc=$order WHERE id_vc=".$row->id_vc." AND id_vo=$qid");
			endforeach;
		}
	}
	function move_up($id)
	{// move a category one level up
		// get this one's properties
		$this_one = $this->get_cat_info($id);
		// get this id's weight
		$this_order = $this_one->position_vc;
		$this_pid   = $this_one->id_vo;
		// do nothing if this one is the first item
		if($this_order > 1){
			// get the first nearest lighter item
			$sql = "SELECT id_vc, position_vc FROM vote_content WHERE (position_vc < '$this_order') AND id_vo = $this_pid ORDER BY position_vc DESC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_vc;
			$swap_order = $replaced->position_vc;
			$this->db->query("UPDATE vote_content SET position_vc ='$swap_order' WHERE id_vc='$id'");
			$this->db->query("UPDATE vote_content SET position_vc ='$this_order' WHERE id_vc='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	function move_down($id)
	{// move a category one level down
		// get this one's properties
		$this_one = $this->get_cat_info($id);
		// get this id's weight
		$this_order = $this_one->position_vc;
		$this_pid   = $this_one->id_vo;
		// do nothing if this one is the last item
		$heaviest = $this->get_heaviest($this_pid);
		if($this_order <  $heaviest){
			// get the first heavier item
			$sql = "SELECT id_vc, position_vc FROM vote_content WHERE (position_vc > '$this_order') AND id_vo = $this_pid ORDER BY position_vc ASC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_vc;
			$swap_order = $replaced->position_vc;
			$this->db->query("UPDATE vote_content SET position_vc ='$swap_order' WHERE id_vc='$id'");
			$this->db->query("UPDATE vote_content SET position_vc ='$this_order' WHERE id_vc='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	function get_cat_info($id)
	{// get a category info
		$search['id_vc'] = $id;
		return $this->db->getwhere("vote_content", $search, 1)->row();
	}
	function get_vote_title($id)
	{// get a category info
		$query = $this->db->select('title_vo, types_vo')->where('id_vo', $id)->limit(1)->get('vote');
		if ($query->num_rows() !== 1)
		{
		   return false;
		}
		else
			return $query->row();
	}
	
}
?>