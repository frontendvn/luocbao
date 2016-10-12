<?php
/**
 * Class class_model
 * handles tables in DB
 */
 class usertype_model extends Model {
 	// assign table name
	var $tb_class = 'usertype';
	function usertype_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($id=false, $limit = 100)
	{//get all class	
		$this->db->select($this->tb_class.'.id, '.$this->tb_class.'.name, '.$this->tb_class.'.description, '.$this->tb_class.'.access_level');
		$this->db->from($this->tb_class);
		if($id)$this->db->where($this->tb_class.'.id', $id);
		$this->db->order_by($this->tb_class.'.access_level');
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
	
	function delete($id)
	{
		return $this->db->delete($this->tb_class, array('id' => $id)); 
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