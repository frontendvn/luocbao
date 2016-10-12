<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class video_model extends Model {
 
	var $tb_class = 'video';
	
	function video_model()
	{// Call the Model constructor
			parent::Model();
	}
	function select($id="", $limit = 100, $offset = 0)
	{//get all introduce		
		$wh = ($id)?"AND id = '".$id."'":"";
		$sql = "SELECT id, title, image, comment, times, shown FROM ".$this->tb_class." WHERE id > 0 $wh ORDER BY id DESC LIMIT $offset, $limit";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
	function insert($values)
	{// insert
		if($this->db->insert($this->tb_class, $values)){
			return TRUE;
		}
		return FALSE;
	}
	function delete($id)
	{// delete	
		$c = false;
		$rs = $this->db->query("SELECT image FROM ".$this->tb_class." WHERE id=$id");
		if($rs->num_rows()>0){
			$row = $rs->row();
			$image = $row->image;
			@unlink("../".$image);
			
			$where1['id'] = $id;
			$c = $this->db->delete($this->tb_class, $where1);
			$rs->free_result();
		}
		return $c;
	}
	function update($values)
	{// update new introduce
		if(!empty($values['image'])) { // new images submited, remove old one
			$old_data = $this->db->query("SELECT image FROM ".$this->tb_class." WHERE id='".$values['id']."'");
			if($old_data->num_rows()>0)
			{
				$row = $old_data->row();
				$full_image_link = $row->image;
				@unlink("../".$full_image_link);
			}
		}
		if($this->db->where('id', $values['id']) && $this->db->update($this->tb_class, $values))
			return TRUE;
		else return FALSE;
	}
	function search($key="", $id=0)
	{//	
		$wh1 = ($key)?"AND title LIKE '%$key%'":"";
		$wh2 = ($id)?"AND id = $id":"";
		$sql = "SELECT id, title, image, comment, times, shown
						FROM ".$this->tb_class." 
						WHERE id>0 $wh1 $wh2 ORDER BY id DESC";
		$res = $this->db->query($sql);
		if($res->num_rows()>0)
			return $res;
		else
			return false;
	}
}
?>