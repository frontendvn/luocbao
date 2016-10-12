<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class ncat_model extends Model {
 	// assign table name
	var $_table_news = 'news';
	var $_table_news_cat = 'news_cat';
    function ncat_model()
    {
        // Call the Model constructor
        parent::Model();
    }
	function insert_new_cat($values)
	{// insert new category
		$max_weight = $this->get_heaviest($values['nwc_pid']);
		$values['nwc_weight'] = 1 + $max_weight;
        if($this->db->insert("news_cat", $values)) return TRUE;
		return FALSE;
	}
	function edit_cat($values)
	{// edit a category
	// interesting : move the branch from src to des, must check to avoid attaching parent to child
		// move cat branch
		$src = $values['id_nwc'];
		$des = $values['nwc_pid'];
		
		$is_child = $this->is_child($des, $src);
		if(!$is_child && $this->db->where('id_nwc', $values['id_nwc']) && $this->db->update("news_cat", $values)){
			$this->re_sort_all();
			return TRUE;
		}
		return FALSE;
	}
	function update($table, $values , $name_feild)
	{//
		if($this->db->update($table, $values, array($name_feild => $values[$name_feild]))){
			return TRUE;
		}
		return FALSE;
	}
	function delete_cat($id_nwc)
	{// delete a category
		//lay tat ca cac cat con neu co
		$sql = "SELECT id_nwc FROM news_cat WHERE nwc_pid=$id_nwc ORDER BY nwc_weight ";
		$result = $this->db->query($sql);
		if($result->num_rows()){
			foreach($result->result() as $row){
				//lay tat ca cac ban tin thuoc cat xoa luon
				$sql = "SELECT news_img, news_img_thumb, news_meta, news_video, news_video_meta FROM news WHERE id_nwc =".$row->id_nwc;
				$res = $this->db->query($sql);
				if($res->num_rows()){
					foreach($res->result() as $rw){
						$image = $rw->news_img;
						if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
						$image = $rw->news_img_thumb;
						if(!empty($image) and file_exists(ROOT.$image)) @unlink(ROOT.$image);
						$news_meta = $rw->news_meta;
						$ar_image = empty($news_meta) ? array() : explode('~', $news_meta);
						foreach($ar_image as $vl)
						{
							@unlink("../".$vl);
						}
						$video = $rw->news_video;
						if(!empty($video) and file_exists(ROOT.$video)) @unlink(ROOT.$video);
						$news_video_meta = $rw->news_video_meta;
						$ar_video = empty($news_video_meta) ? array() : explode('~', $news_video_meta);
						foreach($ar_video as $vl)
						{
							@unlink("../".$vl);
						}
					}
				}
				$where['id_nwc'] = $row->id_nwc;
				$this->db->delete("news", $where);
				//xoa cac cat con nay
				$where1['id_nwc'] = $row->id_nwc;
				$this->db->delete("news_cat", $where1);
			}
		}else{
			//lay tat ca cac ba tin thuoc cat xoa luon
			$sql = "SELECT news_img FROM news WHERE id_nwc =".$id_nwc;
				$res = $this->db->query($sql);
				if($res->num_rows()){
					foreach($res->result() as $rw){
						@unlink("../".$rw->news_img);
					}
				}
			$where['id_nwc'] = $id_nwc;
			$this->db->delete("news", $where);
		}
		
		//delete all news anh image
		$where2['id_nwc'] = $id_nwc;
		if($this->db->delete("news_cat", $where2)){
			$this->re_sort_all();
			return TRUE;
		}
		return FALSE; 
	}
	function switch_state($id_nwc)
	{// on off a category
	// input : array id_nwc['id_nwc']
		$where['id_nwc'] = $id_nwc;
		$current_state = $this->db->getwhere("news_cat", $where, 1)->row()->nwc_shown;
		
		if($current_state == 0){
			
			//Lay ma cua thang cha
			$where['id_nwc'] = $id_nwc;
			$nwc_pid = $this->db->getwhere("news_cat", $where, 1)->row()->nwc_pid;
			//Lay tinh trang cua thang cha
			$where['id_nwc'] = $nwc_pid;
			$rs = $this->db->getwhere("news_cat", $where, 1)->row();
			if($rs)
				$nwc_shown=$rs->nwc_shown;
			else
				$nwc_shown =1;
			//Neu nhu cha no hien thi thi moi update
			if($nwc_shown){
				$set_state['nwc_shown'] = 1;
				$this->db->where('id_nwc', $id_nwc);
				return $this->db->update("news_cat", $set_state);
			}
		}else{
			$set_state['nwc_shown'] = 0;
			//update tinh trang cua cac tin trong muc nay neu co
			$sql = "UPDATE news_cat, news SET news_show='N' WHERE id_nwc = id_nwc AND nwc_pid=$id_nwc";
			$this->db->query($sql);
			$sql = "UPDATE news_cat, news SET news_show= 'N' WHERE id_nwc = id_nwc AND id_nwc=$id_nwc";
			$this->db->query($sql);
			//update tinh trang cua nhung dua con neu co
			$this->db->where('nwc_pid', $id_nwc);
			$this->db->update("news_cat", $set_state);
			//update tinh trang cua chinh no
			$this->db->where('id_nwc', $id_nwc);
			return $this->db->update("news_cat", $set_state);
		}
	}
	function re_sort($nwc_pid="1")
	{// re-sort all items which are in the same level
	// needed when : after deleting an item
	// needed when : after moving a branch to a new node
		$result = $this->db->query("SELECT id_nwc FROM news_cat WHERE nwc_pid=$nwc_pid ORDER BY nwc_weight");
		if($result->num_rows()){
			$order = 0;
			foreach($result->result() as $row):
				$order++; 
				$this->db->query("UPDATE news_cat SET nwc_weight='$order' WHERE id_nwc='".$row->id_nwc."'");// AND nwc_pid='$nwc_pid'
			endforeach;
		}
	}
	function re_sort_all()
	{// re sort the whole table
		// sort the roots
		$this->re_sort(1);
		// select all, resort their children
		$result = $this->db->get("news_cat");
		if($result->num_rows()){
			foreach($result->result() as $row):
				$this->re_sort($row->id_nwc);
			endforeach;
		}
	}
	function move_up($id_nwc)
	{// move a category one level up
		// get this one's properties
		$this_one = $this->get_cat_info($id_nwc);
		// get this id_nwc's weight
		$this_order = $this_one->nwc_weight;
		$this_pid   = $this_one->nwc_pid;
		// do nothing if this one is the first item
		if($this_order > 1){
			// get the first nearest lighter item
			$sql = "SELECT id_nwc, nwc_weight FROM news_cat WHERE (nwc_weight < '$this_order') AND nwc_pid = $this_pid ORDER BY nwc_weight DESC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_nwc;
			$swap_order = $replaced->nwc_weight;
			$this->db->query("UPDATE news_cat SET nwc_weight ='$swap_order' WHERE id_nwc='$id_nwc'");
			$this->db->query("UPDATE news_cat SET nwc_weight ='$this_order' WHERE id_nwc='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	function move_down($id_nwc)
	{// move a category one level down
		// get this one's properties
		$this_one = $this->get_cat_info($id_nwc);
		// get this id_nwc's weight
		$this_order = $this_one->nwc_weight;
		$this_pid   = $this_one->nwc_pid;
		// do nothing if this one is the last item
		$heaviest = $this->get_heaviest($this_pid);
		if($this_order <  $heaviest){
			// get the first heavier item
			$sql = "SELECT id_nwc, nwc_weight FROM news_cat WHERE (nwc_weight > '$this_order') AND nwc_pid = $this_pid ORDER BY nwc_weight ASC LIMIT 0,1";
			$replaced = $this->db->query($sql)->row();
			// switch their weights
			$swap_id = $replaced->id_nwc;
			$swap_order = $replaced->nwc_weight;
			$this->db->query("UPDATE news_cat SET nwc_weight ='$swap_order' WHERE id_nwc='$id_nwc'");
			$this->db->query("UPDATE news_cat SET nwc_weight ='$this_order' WHERE id_nwc='$swap_id'");

			return TRUE;
		}
		return FALSE;
	}
	function get_cat_info($id_nwc)
	{// get a category info
	// input : $cat_id, single value
	// return : a row
		$search['id_nwc'] = $id_nwc;
		$rs = $this->db->getwhere("news_cat", $search, 1);
		return $rs->num_rows() ? $rs->row() : false;
		// to be revised: what if $id_nwc is not existing?
	}
	function get_cat_same_level($nwc_pid)
	{// get all categories at the same level
	// input: parent id
	// return: a set of rows which have the same nwc_pid
		//neu nhu lay tu root
		if($nwc_pid ==0){
			$sql = "SELECT p.id_nwc, p.id_cattext, p.nwc_name, p.nwc_comment, p.nwc_weight, p.nwc_shown, p.nwc_pid,
					 (SELECT COUNT(b.id_news) FROM news b WHERE b.id_nwc=p.id_nwc) AS nwc_counts
					 FROM news_cat p WHERE p.nwc_pid =".$nwc_pid." ORDER BY nwc_weight";
			return $this->db->query($sql);
		}else{
			$sql = "SELECT p.id_nwc, p.id_cattext,  p.nwc_name, p.nwc_comment, p.nwc_weight, p.nwc_shown, p.nwc_pid,
					 (SELECT COUNT(id_news) FROM news  WHERE id_nwc=p.id_nwc) AS nwc_counts
					 FROM news_cat p WHERE p.nwc_pid =".$nwc_pid." ORDER BY nwc_weight";
			return $this->db->query($sql);
		}
	}
	function get_heaviest($nwc_pid)
	{// get heaviest item in a branch (nwc_pid)
		$sql = "SELECT MAX(nwc_weight) AS nwc_weight FROM news_cat WHERE nwc_pid ='$nwc_pid'";
		return $this->db->query($sql)->first_row()->nwc_weight;
	}

	function create_select_box_root($select_box_name = "parentid", $selected_pid = 0)
	{// create a select box to browse for root categories ONLY
	// input : name of the UI
	
		$sql = "select id_nwc, id_cattext, nwc_name, nwc_pid FROM news_cat WHERE nwc_pid = 0 order by nwc_weight";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"news_select_box\">\n";
		$select_box .= "<option value=\"0\">Là danh mục gốc</option>\n";
		
		foreach($res->result() as $row){
			$cid = $row->id_nwc;
			$id_cattext = $row->id_cattext;
			$cat_title = $row->nwc_name;
			$nwc_pid = $row->nwc_pid;
			if($selected_pid == $cid) $selected = "selected";
			else $selected = "";
			if ($nwc_pid != 0) $cat_title = $this->get_parent_str($nwc_pid, $cat_title);
			$select_box.= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
        $select_box.="</select>";
		return $select_box;
	}

	function create_select_child($select_box_name = "parentid", $selected_catid , $onsubmit = "")
	{// create a select box to browse for catids (news)
	// input : name of the UI
		if($onsubmit)
			$onsubmit = 'onChange="this.form.submit()"';
		$sql = "select id_nwc, id_cattext, nwc_name, nwc_pid from news_cat order by nwc_pid, nwc_weight";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
        
    	foreach($res->result() as $row){
			$cid = $row->id_nwc;
			$id_cattext = $row->id_cattext;
			$cat_title = $row->nwc_name;
			$nwc_pid = $row->nwc_pid;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			if ($nwc_pid != 0){
				$cat_title = $this->get_parent_str($nwc_pid, $cat_title);
			}
			$select_box.= "<option value=\"$cid|$id_cattext\" title=\"$cat_title\" $selected>".word_limiter($cat_title,10).".."."</option>\n";
		}
   		$select_box.="</select>";
		return $select_box;
	}
		
	function create_select_box_all($name="parentid", $selected_catid=1, $root=0, $title="-- danh mục gốc --")
	{// create a select box to browse for catids (prod)
		$sql = "select id_nwc, nwc_name, nwc_pid from news_cat order by nwc_pid, id_nwc";
    	$res = $this->db->query($sql);
		$select_box = "<select name=\"$name\" id=\"$name\">\n";
		if(($root==0) || ($root==1))$select_box .= "<option value=\"$root\">$title</option>\n";    
		foreach($res->result() as $row){
			$cid = $row->id_nwc;
			$cat_title = $row->nwc_name;
			$pid = $row->nwc_pid;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			if ($pid != 0) $cat_title = $this->get_parent_str($pid, $cat_title);
			if(substr_count($cat_title, ' / ')<2)// 2 level
				$select_box.= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,10)."</option>\n";
		}
   		$select_box.="</select>";
		return $select_box;
	}
	
	function create_select_all($select_box_name = "parentid", $selected_catid , $title = '', $onsubmit = '')
	{// create a select box to browse for catids (news)
	// input : name of the UI
		if($onsubmit)
			$onsubmit = 'onChange="this.form.submit()"';
		$sql = "SELECT id_nwc, id_cattext, nwc_name, nwc_pid FROM news_cat ORDER BY nwc_pid, nwc_weight";
        $res = $this->db->query($sql);
		$select_box = "<select name=\"$select_box_name\" id=\"$select_box_name\" $onsubmit>\n";
		$select_box .= "<option value=\"0\">$title</option>\n";
        
    	foreach($res->result() as $row){
			$cid = $row->id_nwc;
			$id_cattext = $row->id_cattext;
			$cat_title = $row->nwc_name;
			$nwc_pid = $row->nwc_pid;
			if($selected_catid == $cid) $selected = "selected";
			else $selected = "";
			if ($nwc_pid != 0){
				$cat_title = $this->get_parent_str($nwc_pid, $cat_title);
			}
			$select_box.= "<option value=\"$cid\" title=\"$cat_title\" $selected>".word_limiter($cat_title,10).".."."</option>\n";
		}
   		$select_box.="</select>";
		return $select_box;
	}
	
	function is_child($des, $src)
	{// check if 'des' is a child of 'src' by
	// tracing {get nwc_pid of current id_nwc} until root reaching (yes) or parent reaching (no)
	// consider the 'root' is those which has 'nwc_pid' = 1
	// consider $des = $src ?

		//if($des == $src) return 0; // i'm not my son
		if($des == 0) return 0; // No, 'des' is not child, 'des' is at root
		if($src == 1) return 1; // Yes, 'des' is 'src's child, obviously, because 'src' is at root while $des is not
		
		while($des != 0 && $des != $src){
			$des = $this->get_cat_info($des)->nwc_pid;
		}
		if($des > 0) return 1; // Daddy reach: Yes, 'des' is 'src' child. $src = $des after the trace
		return 0; // root reach, No 'des' is not child of 'src'
	}	
	function get_parent_str($pid, $title) 
	{// recursively get parent title then attach to the front
		$sql = "SELECT id_nwc, nwc_name, nwc_pid FROM news_cat WHERE id_nwc='".$pid."' ";
		$res = $this->db->query($sql);
		if(is_object($res) && $res->num_rows()>0)
		{
			$row = $res->row_array();
			$cid = $row['id_nwc'];
			$ptitle = $row['nwc_name'];
			$pparentid = $row['nwc_pid'];
			if ($ptitle != "") $title = $ptitle." / ".$title;
			if ($pparentid !=0) {
				$title = $this->get_parent_str($pparentid,$title);
			}
			return $title."\n";
		}
		return;
	}
	
}
?>