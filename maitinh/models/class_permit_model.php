<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class class_permit_model extends Model {
 	// assign table name
	var $tb_class = 'class_permits';
	function class_permit_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($id=false, $limit = 100)
	{//get all class	
	   $groups_table    	= 'usertype';

		$this->db->select($this->tb_class.'.id, '.$this->tb_class.'.class_name, '.$this->tb_class.'.required_access, '.$this->tb_class.'.note, '.$groups_table.'.name');
		$this->db->from($this->tb_class);
		$this->db->join($groups_table, $this->tb_class.'.required_access = '.$groups_table.'.access_level');
		if($id)$this->db->where($this->tb_class.'.id', $id);
		$this->db->order_by($this->tb_class.'.class_name');
		$this->db->limit($limit);
		$query = $this->db->get();
					
		if ($query->num_rows() > 0)
		{
				return $query;
		}
		return false;
	}
	
	function insert($values)
	{// insert new class
		if($this->db->insert($this->tb_class, $values))
			return TRUE;
		else return FALSE;
	}
	
	function check_class_permit($class)
	{//	
		$query  = $this->db->select('id')
							 ->where('class_name', $class)
							 ->limit(1)
							 ->get($this->tb_class);
					
		if ($query->num_rows() == 1)
		{
			return true;
		}
		return false;
	}

	function create_select_box_all_groups($select_box_name = "groups", $selected_catid = 0, $onsubmit = false)
	{// create a select box to browse for group
	    $groups_table    	= 'usertype';
		if($onsubmit)	$onsubmit = 'onChange="this.form.submit()"';
		$res = $this->db->select('id, name, description, access_level')->order_by("id", "asc")->get($groups_table);
		
		$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
		$select_box .= "<option value=\"\" title=\"chọn đối tượng\">-- chose level --</option>\n";
		
		foreach($res->result() as $row)
		{
			$cid = $row->access_level;
			$cat_title = $row->name;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,5)."</option>\n";
		}
		$select_box .= "</select>";
		return $select_box;
	}

	function delete($id)
	{// delete table function_permits
		$this->db->delete('function_permits', array('id_class' => $id)); 
		return $this->db->delete($this->tb_class, array('id' => $id)); 
	}

	function check_class_permit_edit($id,$class)
	{
		$query  = $this->db->select('id')
							 ->where('class_name', $class)
							 ->where('id !=', $id)
							 ->limit(1)
							 ->get($this->tb_class);
					
		if ($query->num_rows() == 1)
		{
			return true;
		}
		return false;
	} 

	function update($values)
	{
		if($this->db->update($this->tb_class, $values, array('id' => $values['id'])))
			return TRUE;
		else
			return FALSE;
	}

}
?>