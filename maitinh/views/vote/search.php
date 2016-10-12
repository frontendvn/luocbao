<?php
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
?>
<div id="result">
<?php
$attributes = array('id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
	<tr><td class="maintitle" colspan="4">KẾT QUẢ</td></tr>
	<tr>
		<td class="tdrow3" width="30" align="center"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Nội dung</td>
	</tr>
<?php
if(!empty($db))
{
	$up_img = "<img src=\"".$img."icons/small/files.png\" align=\"absmiddle\" border=\"0\" />";
	$ed_img = "<img src=\"".$img."icons/small/register.gif\" align=\"absmiddle\" border=\"0\" />";
	$de_img="<img src=\"".$img."icons/small/no.gif\" align=\"absmiddle\" border=\"0\" />";
	$active_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\" title=\"Đang ở trạng thái hiển thị.\" />";
	$inactive_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\" title=\"Đang ở trạng thái ẩn.\" />";
	//, , , 
	$ard=array('&lt;html&gt;','&lt;title&gt;','&lt;head&gt;', '&lt;body&gt;','&lt;/html&gt;','&lt;/title&gt;','&lt;/head&gt;', '&lt;/body&gt;', '&lt;/title>',"'",'"',"\n");
	$art=array('','','','','','','','','',"\'",'\"',"");
	$stt = 0;
	foreach($db->result() as $row){
		$stt++;
		$id = $row->id_vo;		
		$title = str_replace($ard, $art, $row->title_vo);
		$types = $row->types_vo;
		$dtypes = $op_type[$types];
		$comment = $row->comment_vo;
		if(empty($id)) break;
		$show_vo = $row->show_vo;
		//
		switch($show_vo)
		{
			case '0': $show_img = $inactive_img; break;
			case '1': $show_img = $active_img; break;
			default: $show_img = $inactive_img;
		}
		$alt = "<script>
		var alttooltip".$id."='<table width=\"300\" cellspacing=0 cellpadding=0>";
		$alt .="<tr>";
		$alt .="<td>Loại câu hỏi: $dtypes.</td></tr>";
		$alt .="<tr><td >".str_replace($ard , $art, $comment)."</td></tr>";
		$alt .="</table>';</script>";
		echo $alt;

		$i = is_int($stt/2)? 2 : 1;
		//
		$view = anchor('vote_content/add/'.$id, $up_img, array('title' => "Thêm phương án"));
		$anc_title = anchor($this->mod.'/edit/'.$id, $title, array('title' => "Xem"));

		$str_ans = "";

		if($db_ans)
			foreach($db_ans->result() as $rw)
			{
				$aid = $rw->id_vc;
				$qid = $rw->id_vo;
				$position = $rw->position_vc;
				$content = $rw->content_vc;
				$image_ans = $rw->image_vc;
				if($qid==$id)
				{
					$edit_ans = anchor('vote_content/edit/'.$qid.'/'.$aid, $content, array('title' => "Hiệu chỉnh phương án"));
					$del_ans = anchor('vote_content/del/'.$qid.'/'.$aid, $de_img, array('title' => "Xóa phương án", 'onclick' =>'return verify_del()'));
					$str_ans .= "<p>$del_ans $position $edit_ans</p>";
				}
			}
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id<br />$view</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" onMouseOver='showtip(alttooltip".$id.");' onMouseOut='hidetip();'>$anc_title<br />$str_ans</td>\n";
		echo "	</tr>\n";
		
	}
}
?>
	<tr>
		<td colspan="3" class="tdrow3">
			<input type="submit" value="Xóa mục đã chọn" name="btn_submit" onclick="return verify_del();">
			<?php $total = empty($db)?0:$db->num_rows();echo 'Tổng cộng: '.$total;?>
			<span style="float:right; padding-right:10px;"><?=anchor($this->mod.'/add', "Thêm mới");?></span></td>
	</tr>
</table>
</form>
</div>