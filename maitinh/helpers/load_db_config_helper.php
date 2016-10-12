<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function load_db_config($option_name){
	$obj =& get_instance();
	$result = $obj->db->query("SELECT option_value FROM site_options WHERE option_name = '$option_name' LIMIT 1");
	if($result->num_rows()) return $result->row()->option_value;
	return "";
}

function save_db_config($option_name, $option_value){
	$obj =& get_instance();
	// update or create new:
	$result = $obj->db->query("SELECT option_name FROM site_options WHERE option_name = '$option_name' LIMIT 1");
	if(is_object($result) && $result->num_rows()>0) 
		// update
		$obj->db->query("UPDATE site_options SET option_value = '$option_value' WHERE option_name = '$option_name' LIMIT 1");
	else // insert
		$obj->db->query("INSERT INTO site_options VALUES('','$option_name','$option_value') ");
}

?>