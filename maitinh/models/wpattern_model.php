<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class wpattern_model extends Model {
	var $_table_class = 'website_pattern';
    function wpattern_model()
    {// Call the Model constructor
        parent::Model();
    }

	function select($id="")
	{//get all introduce		
		$wh = ($id)?"AND id_pattern = $id":'';
		$sql = "SELECT 
					name, website, link_xpath, link_open, link_close, link_bad, title_xpath, title_open, title_close, title_bad, 
					intro_xpath, intro_open, intro_close, intro_bad, content_xpath, content_open, content_close, content_bad, 
					author_xpath, author_open, author_close, author_bad, times, time_update 
				FROM ".$this->_table_class." 
				WHERE id_pattern > 0 $wh 
				ORDER BY weight, id_pattern";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}

	function insert($table,$values)
	{// insert new introduce
		$max_weight = $this->get_heaviest();
		$values['weight'] = 1 + $max_weight;
		if($this->db->insert($table, $values)){
			return TRUE;
		}
		else return FALSE;
	}
	
	function get_heaviest()
	{// get heaviest item in a branch (nwc_pid)
		$sql = "SELECT MAX(weight) AS weight FROM ".$this->_table_class;
		return $this->db->query($sql)->row(0)->weight;
	}
	
	function delete($id)
	{// delete new introduce				
		return $this->db->query("DELETE FROM ".$this->_table_class." WHERE id_pattern='$id'");
	}
	
	function update($values)
	{// update new introduce
		if($this->db->where('id_pattern', $values['id_pattern']) && $this->db->update($this->_table_class, $values))
			return TRUE;
		else return FALSE;
	}
	
	function get_pattern_info($id_pattern)
	{// get a category info
	// input : $cat_id, single value
	// return : a row
		$search['id_pattern'] = $id_pattern;
		$rs = $this->db->getwhere($this->_table_class, $search, 1);
		return $rs->num_rows() ? $rs->row() : false;
		// to be revised: what if $id_pattern is not existing?
	}
	
	function move_up($id_pattern)
	{// move a category one level up
		// get this one's properties
		$this_one = $this->get_pattern_info($id_pattern);
		// get this id_pattern's weight
		$this_order = $this_one->weight;
		// do nothing if this one is the first item
		if($this_order > 1){
			// get the first nearest lighter item
			$sql = "SELECT id_pattern, weight FROM ".$this->_table_class." WHERE (weight < '$this_order') ORDER BY weight DESC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_pattern;
			$swap_order = $replaced->weight;
			$this->db->query("UPDATE ".$this->_table_class." SET weight ='$swap_order' WHERE id_pattern='$id_pattern'");
			$this->db->query("UPDATE ".$this->_table_class." SET weight ='$this_order' WHERE id_pattern='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	
	function move_down($id_pattern)
	{// move a category one level down
		// get this one's properties
		$this_one = $this->get_pattern_info($id_pattern);
		// get this id_pattern's weight
		$this_order = $this_one->weight;
		// do nothing if this one is the last item
		$heaviest = $this->get_heaviest();
		if($this_order <  $heaviest){
			// get the first heavier item
			$sql = "SELECT id_pattern, weight FROM ".$this->_table_class." WHERE (weight > '$this_order') ORDER BY weight ASC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_pattern;
			$swap_order = $replaced->weight;
			$this->db->query("UPDATE ".$this->_table_class." SET weight ='$swap_order' WHERE id_pattern='$id_pattern'");
			$this->db->query("UPDATE ".$this->_table_class." SET weight ='$this_order' WHERE id_pattern='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	
	function re_sort()
	{// re-sort all items which are in the same level
	// needed when : after deleting an item
	// needed when : after moving a branch to a new node
		$result = $this->db->query("SELECT id_pattern FROM ".$this->_table_class." ORDER BY weight");
		if($result->num_rows()){
			$order = 0;
			foreach($result->result() as $row):
				$order++; 
				$this->db->query("UPDATE ".$this->_table_class." SET weight='$order' WHERE id_pattern='".$row->id_pattern."'");
			endforeach;
		}
	}
}
?>