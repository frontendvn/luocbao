<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class blocks_model extends Model {

	function blocks_model()
	{
		parent::Model();	
	}
	
	function insert($val)
	{
		if($this->db->insert("blocks", $val)){
			return TRUE;
		}
		else return FALSE;
	}
	function show($id='')
	{
		$wh = empty($id)?" ORDER BY a.type DESC":" WHERE a.id='$id' LIMIT 1";
		$res = $this->db->query("SELECT a.*,(SELECT b.title FROM block_skin b WHERE a.skin=b.id LIMIT 1) AS title_skin
		 FROM blocks a $wh");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function update($values)
	{
		if(empty($values['id'])) return FALSE;
		if( $this->db->where(array('id'=>$values['id']))&& $this->db->update("blocks", $values)){
			return TRUE;
		}
		return FALSE;
	}
	function delete($id)
	{
		if(empty($id)) return FALSE;
		
		$where['blocks_id'] = $id;
		$this->db->delete("block_pos", $where);
		
		return $this->db->delete('blocks', array('id' => $id)); 
	}
	function selete_skin($select_box_name = "skin", $selected_catid = 0)
	{
		$sql = "SELECT id, title FROM block_skin ORDER BY id DESC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
        $select_box.= "<option value=\"\" >Chọn skin</option>\n";
        foreach($res->result() as $row){
			$cid = $row->id;
			$cat_title = $row->title;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box.= "<option value=\"$cid\" $selected>".substr($cat_title,0,150).".."."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}
	function selete_cat($select_box_name = "catid", $selected_catid = 0)
	{
		$sql = "SELECT id_nwc, nwc_name FROM news_cat WHERE nwc_shown='1' AND nwc_pid!='1' ORDER BY id_nwc DESC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
       	if(is_object($res) && $res->num_rows()>0){
			foreach($res->result() as $row){
				$cid = $row->id_nwc;
				$cat_title = $row->nwc_name;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box.= "<option value=\"$cid\" $selected>".substr($cat_title,0,150).".."."</option>\n";
			}
		}else $select_box.= "<option value=\"\" >Chưa có nội dung</option>\n";
        $select_box.="</select>";
		return $select_box;
	}
	function selete_news($select_box_name = "nid", $selected_catid = 0)
	{
		$sql = "SELECT id_news, news_title FROM news WHERE news_show='Y' ORDER BY id_nwc DESC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
       	if(is_object($res) && $res->num_rows()>0){
			foreach($res->result() as $row){
				$cid = $row->id_news;
				$cat_title = $row->news_title;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box.= "<option value=\"$cid\" $selected>".substr($cat_title,0,150).".."."</option>\n";
			}
		}else $select_box.= "<option value=\"\" >Chưa có nội dung</option>\n";
        $select_box.="</select>";
		return $select_box;
	}
	function selete_ngucanh($select_box_name = "id_content", $selected_catid = 0)
	{
		$sql = "SELECT id_nwc, nwc_name FROM news_cat WHERE nwc_shown='1' AND nwc_pid!='1' ORDER BY id_nwc DESC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
		$select_box.= "<option value=\"A\" >Tất cả</option>\n";
		$select_box.= "<option value=\"C\" >Contact</option>\n";
       	if(is_object($res) && $res->num_rows()>0){
			foreach($res->result() as $row){
				$cid = $row->id_nwc;
				$cat_title = $row->nwc_name;
				if($selected_catid == $cid) $selected = "selected";
				else $selected = "";
				$select_box.= "<option value=\"$cid\" $selected>".substr($cat_title,0,150).".."."</option>\n";
			}
		}
        $select_box.="</select>";
		return $select_box;
	}
	function select_news_cat()
	{
		$sql = "SELECT id_nwc, nwc_name FROM news_cat WHERE nwc_shown='1' AND nwc_pid!='1' ORDER BY id_nwc DESC";
        $res = $this->db->query($sql);
		return $res;
	}
}
?>