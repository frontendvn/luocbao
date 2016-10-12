<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class advertise_model extends Model {

	function advertise_model()
	{
		parent::Model();	
	}
	
	function insert($val)
	{
		if($this->db->insert("advertise", $val)){
			return TRUE;
		}
		else return FALSE;
	}
	function show_advertise($adv_id='')
	{
		$wh = empty($adv_id)?"":" WHERE adv_id='$adv_id' LIMIT 1";
		$res = $this->db->query("SELECT * FROM advertise $wh");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function update($values)
	{
		if(empty($values['adv_id'])) return FALSE;
		if( $this->db->where(array('adv_id'=>$values['adv_id']))&& $this->db->update("advertise", $values)){
			return TRUE;
		}
		return FALSE;
	}
	function check_adv_code($adv_code)
	{
		$res = $this->db->query("SELECT adv_id FROM advertise WHERE adv_code ='".$adv_code."' LIMIT 1");
		if(is_object($res) && $res->num_rows()>0)
			return TRUE;
		else return FALSE;
	}
}
?>