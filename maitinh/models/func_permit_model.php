<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class func_permit_model extends Model {
 	// assign table name
	var $tb_class = 'function_permits';
	function func_permit_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($cid=false, $id=false, $limit = 100)
	{//get all class	
	  $groups_table    	= 'class_permits';
	  $usertype_table  	= 'usertype';

		$this->db->select($this->tb_class.'.id, '.$this->tb_class.'.id_class, '.$this->tb_class.'.func_name, '.$this->tb_class.'.required_access, '.$this->tb_class.'.note, '.$groups_table.'.class_name, '.$usertype_table.'.name, ');
		$this->db->from($this->tb_class);
		$this->db->join($groups_table, $this->tb_class.'.id_class = '.$groups_table.'.id', 'left');
		$this->db->join($usertype_table, $this->tb_class.'.required_access = '.$usertype_table.'.access_level');
		if($cid)$this->db->where($this->tb_class.'.id_class', $cid);
		if($id)$this->db->where($this->tb_class.'.id', $id);
		$this->db->order_by($this->tb_class.'.func_name');
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
	
	function check_func_permit($class, $func)
	{//	
		$query  = $this->db->select('id')
											 ->where('id_class', $class)
											 ->where('func_name', $func)
											 ->limit(1)
											 ->get($this->tb_class);
					
		if ($query->num_rows() == 1)
		{
				return true;
		}
		return false;
	}

	function create_select_box_class($select_box_name = "class", $selected_catid = 0, $onsubmit = false, &$fid)
	{// create a select box to browse for group
			$fisrt = false;
	    $groups_table    	= 'class_permits';
			if($onsubmit)	$onsubmit = 'onChange="this.form.submit()"';
			$res = $this->db->select('id, class_name')->order_by("id", "asc")->get($groups_table);
			
			$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
			
			foreach($res->result() as $row)
			{
				$cid = $row->id;
				$cat_title = $row->class_name;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				if(!empty($cat_title)){
					if(empty($fisrt)){
						$fid = $cid;
						$fisrt = true;
					}
				}
				$select_box .= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,5)."</option>\n";
			}
			$select_box .= "</select>";
			return $select_box;
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
	{
		return $this->db->delete($this->tb_class, array('id' => $id)); 
	}

	function check_func_permit_edit($id,$class, $func)
	{
		$query  = $this->db->select('id')
											 ->where('id_class', $class)
											 ->where('func_name', $func)
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