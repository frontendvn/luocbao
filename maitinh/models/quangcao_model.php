<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class quangcao_model extends Model {

	var $tb_class = 'quangcao';
	function quangcao_model_model()
	{
		parent::Model();
	}
	
	function insert($val)
	{
		$max_weight = $this->get_heaviest($val['id_vitri']);
		$val['weight'] = 1 + $max_weight;
		if($this->db->insert($this->tb_class, $val)){
			return TRUE;
		}
		else return FALSE;
	}
	function get_heaviest($qid)
	{// get heaviest item in a branch (qid)
		$sql = "SELECT MAX(weight) AS weight FROM ".$this->tb_class." WHERE id_vitri=$qid";
		return $this->db->query($sql)->row(0)->weight;
	}
	function re_sort($qid)
	{// re-sort all items which are in the same level
	// needed when : after deleting an item
	// needed when : after moving a branch to a new node
		$result = $this->db->query("SELECT id FROM ".$this->tb_class." WHERE id_vitri=$qid ORDER BY weight");
		if($result->num_rows()){
			$order = 0;
			foreach($result->result() as $row):
				$order++; 
				$this->db->query("UPDATE ".$this->tb_class." SET weight=$order WHERE id=".$row->id." AND id_vitri=$qid");
			endforeach;
		}
	}
	function show($id='')//19-8-2010
	{
		$wh = empty($id)?"":"AND a.id='$id'";
		$res = $this->db->query("SELECT * FROM ".$this->tb_class." a, vitri b WHERE a.id_vitri=b.id_vt  $wh ORDER BY b.id_vt DESC, a.weight ASC, a.id ASC");
		if($res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function update($values)
	{
		if(empty($values['id'])) return FALSE;
		/*if(!empty($values['image']))
		{
			$res = $this->db->query("SELECT image FROM ".$this->tb_class." WHERE id=".$values['id']);
			if($res->num_rows()>0)
				@unlink('../'.$res->row(0)->image);
		}*/
		if( $this->db->where(array('id'=>$values['id']))&& $this->db->update($this->tb_class, $values)){
			return TRUE;
		}
		return FALSE;
	}
	function delete($id)//19-8-2010
	{
		if(empty($id)) return FALSE;
		
		$res = $this->db->query("SELECT id_vitri FROM ".$this->tb_class." WHERE id=$id");
		//if($res->num_rows()>0)
		//	@unlink('../'.$res->row(0)->image);
		
		if($this->db->delete($this->tb_class, array('id' => $id)))
		{
			$this->re_sort($res->row(0)->id_vitri);
			return TRUE;
		}
		return FALSE;
	}
	function select_vitri($select_box_name = "vitri", $selected_catid = 0)
	{
		$sql = "SELECT id_vt, ten_vt FROM vitri  ORDER BY ten_vt ASC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
        $select_box.= "<option value=\"\">- Chọn -</option>\n";
        foreach($res->result() as $row){
			$cid = $row->id_vt;
			$cat_title = $row->ten_vt;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box.= "<option value=\"$cid\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}
	function select_khachhang($select_box_name = "khachhang", $selected_catid = 0)
	{
		$sql = "SELECT id_kh, ten_kh FROM khachhang ORDER BY id_kh DESC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
        $select_box.= "<option value=\"\">- Chọn -</option>\n";
        foreach($res->result() as $row){
			$cid = $row->id_kh;
			$cat_title = $row->ten_kh;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box.= "<option value=\"$cid\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}
	function show_qc($id_vt)//17-8-2010
	{
		$time = time();
		$res = $this->db->query("SELECT id,image,types,tg_hienthi,id_cattext FROM ".$this->tb_class." 
				WHERE  shown='Y' AND (ngay_hethan>=$time OR ngay_hethan=0) AND id_vitri='".$id_vt."' AND temp='0'  ORDER BY id_vitri ASC,weight ASC");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function show_vitri()
	{
		$res = $this->db->query(" SELECT id_vt,ten_vt,ngang,doc FROM vitri ORDER BY ten_vt ASC");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	
	function select_chude($select_box_name = "id_cattext", $selected_catid = '')//9-8-2010
	{
		$sql = "SELECT id_cattext, nwc_name FROM news_cat WHERE nwc_shown='1' AND nwc_pid='0' ORDER BY nwc_name ASC";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
        $select_box.= "<option value=\"\">- Chọn -</option>\n";
        foreach($res->result() as $row){
			$cid = $row->id_cattext;
			$cat_title = $row->nwc_name;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			$select_box.= "<option value=\"$cid\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}
	function show_vitri_mau()//17-8-2010
	{
		$res = $this->db->query(" SELECT id_vt,ten_vt FROM vitri WHERE ten_vt LIKE '%c%' OR ten_vt LIKE '%d%' ORDER BY ten_vt ASC");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function show_qc_mau($id_vt)//17-8-2010
	{
		$res = $this->db->query("SELECT id,image,types,id_cattext FROM ".$this->tb_class." 
				WHERE  shown='Y' AND id_vitri='".$id_vt."' AND temp='1'  ORDER BY id_vitri ASC,weight ASC LIMIT 1");
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
	function show_chude()//19-8-2010
	{
		$sql = "SELECT id_cattext, nwc_name FROM news_cat WHERE nwc_shown='1' AND nwc_pid='0' ORDER BY nwc_name ASC";
        $res = $this->db->query($sql);
		if(is_object($res) && $res->num_rows()>0)
			return $res;
		else return FALSE;
	}
}
?>