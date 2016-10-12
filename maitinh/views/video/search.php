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
		<td class="tdrow3" align="center">Tiêu đề</td>
		<td class="tdrow3" align="center">Mô tả</td>
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
	$ard=array("'",'"',"\n");
	$art=array("\'",'\"',"");
	$stt = 0;
	foreach($db->result() as $row){
		$stt++;
		$id = $row->id;		
		$title = str_replace($ard, $art, $row->title);
		$comment = $row->comment;
		$str_comment = word_limiter($row->comment, 12);
		$img = $row->image;
		if(empty($id)) break;
		$show = $row->shown;
		//
		switch($show)
		{
			case 'N': $show_img = $inactive_img; break;
			case 'Y': $show_img = $active_img; break;
			default: $show_img = $inactive_img;
		}
		$alt = "<script>
		var alttooltip".$id."='<table width=\"300\" cellspacing=0 cellpadding=0>";
		$alt .="<tr>";
		if(!empty($img) && file_exists("../".$img))
			$alt .="<td>".showIMG("../".$img)."</td>";
		else
			$alt .="<td>&nbsp;</td>";
		$alt .="</tr>";
		$alt .="<tr><td colspan=\"2\">".str_replace($ard , $art, $comment)."</td></tr>";
		$alt .="</table>';</script>";
		echo $alt;

		$i = is_int($stt/2)? 2 : 1;
		//
		$anc_title = anchor($this->mod.'/edit/'.$id, $title, array('title' => "Xem"));

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" onMouseOver='showtip(alttooltip".$id.");' onMouseOut='hidetip();'>$show_img $anc_title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$str_comment</td>\n";
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