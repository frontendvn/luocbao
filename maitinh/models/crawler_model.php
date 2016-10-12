<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Crawler_model extends Model {
	var $_table_class = 'crawler';
    function crawler_model()
    {// Call the Model constructor
        parent::Model();
    }

	function select($cid ="", $id="")
	{//	
		$wh = ($cid) ? "AND a.id_nwc = $cid " : "";
		$wh .= ($id) ? " AND a.id = $id" : $wh;
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, b.name, a.links, a.create_time, a.update_time, a.available, c.nwc_name, c.nwc_pid
				FROM ".$this->_table_class." a, news_pattern b, news_cat c
				WHERE a.id_pattern = b.id_pattern AND a.id_nwc = c.id_nwc $wh 
				ORDER BY a.id, c.id_nwc, id_pattern";
				
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	
	function get_crawler_same_cat_level()
	{// get all categories at the same level
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.links, a.create_time, a.update_time, a.available, b.name, c.nwc_name, c.nwc_pid
				FROM ".$this->_table_class." a, news_pattern b, news_cat c
				WHERE a.id_pattern = b.id_pattern AND a.id_nwc = c.id_nwc
				ORDER BY c.id_nwc";
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
	{// delete new introduce				
		return $this->db->query("DELETE FROM ".$this->_table_class." WHERE id='$id'");
	}
	
	function update($values)
	{// update new introduce
		if($this->db->where('id', $values['id']) && $this->db->update($this->_table_class, $values))
			return TRUE;
		else return FALSE;
	}
	
	function create_select_box_pattern($select_box_name = "id_pattern", $selected_pid = 0)
	{// create a select box to browse for root categories ONLY
	// input : name of the UI
	
		$sql = "select id_pattern, name FROM news_pattern order by name";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
		$select_box .= "<option value=\"0\"> </option>\n";
		
		foreach($res->result() as $row){
			$cid = $row->id_pattern;
			$cat_title = $row->name;
			if($selected_pid == $cid) $selected = "selected";
			else $selected = "";
			$select_box.= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}
	
	function show($id)
	{// on off a category
		//lay tinh trang the hien cua ba tin va cua loai ban tin
		$sql = "SELECT available FROM ".$this->_table_class." WHERE id=$id";
		$row =$this->db->query($sql)->row();
		if(is_object($row)){
			$show = $row->available;
			$show= ($show=='1')? '0' : '1';
			$sql = "UPDATE ".$this->_table_class." SET available= '$show' WHERE id=$id";
			if($this->db->query($sql))
				return true;
		}
		return false;
	}
	
	function enabled($id, $show='1')
	{// on off a category
		$sql = "UPDATE ".$this->_table_class." SET available= '$show' WHERE id=$id";
		if($this->db->query($sql))
			return true;
		return false;
	}
	
}
?>