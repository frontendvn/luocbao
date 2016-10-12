<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<script type="text/javascript" src="<?=$js?>jquery-form.js"></script>
<script type="text/javascript">
	$(function() {
		$('#show_popup').click(function() {
			$('#dialog_search').show();
			$('#show_popup').hide();
		})
		$('#show_main').click(function() {
			$('#dialog_search').hide();
			$('#show_popup').show();
		})
	});
	
	function ajSearch()
	{
		$('#loading').html('<img src="<?php echo $img?>ajax_loading.gif" />').show();
		$('#frmSearch').ajaxForm({
				success: function(msg) { 
					$('#loading').hide();
					$('#result').html(msg).show();
				} 
		});
	}
</script>
<div id="dialog_search" style="display:none;">
	<form id="frmSearch" method="post" action="<?=site_url($this->mod.'/search')?>">
	<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
			<tr>
				<td colspan="2" class="maintitle"><strong>TÌM THĂM DÒ</strong><span style="float:right"><input type="button" name="show_main" id="show_main" value="Đóng lại" /></span></td>
			</tr>
			<tr>
				<td align="right" class="tdrow1" valign="top"><strong>Mã</strong></td>
				<td class="tdrow1"><input type="text" name="txt_id" /></td>
			</tr>
			<tr>
				<td align="right" class="tdrow1" valign="top"><strong>Câu hỏi </strong></td>
				<td class="tdrow1"><textarea cols="69" rows="2" name="txt_name"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="tdrow1">
				<input type="submit" name="btn_submit" value="Tìm kiếm" id="button" onclick="ajSearch()" /></td>
			</tr>
	</table>
	</form>
</div>
<p id="loading"></p>
<div id="result">
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
	<tr>
		<td colspan="3" class="maintitle"><form method="post"><strong>DANH SÁCH THĂM DÒ</strong>&nbsp;<?=anchor($this->mod.'/add', "&raquo; Thêm mới");?></span><span style="float:right"><input type="button" name="show_popup" id="show_popup" value="Tìm câu hỏi" /></span></form></td>
	</tr>
<?php
$attributes = array('id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="page" value="<?=$page;?>" />
	<tr class="tdrow3">
		<td colspan="3">&nbsp;Hiện có <span style="font-size:13px; color:#666666;"><?=$total_item;?></span> trong <?=$pagi?></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Nội dung</td>
	</tr>
<?php
if(!empty($total_item))
{
	$up_img = "<img src=\"".$img."icons/small/files.png\" align=\"absmiddle\" border=\"0\" />";
	$ed_img = "<img src=\"".$img."icons/small/register.gif\" align=\"absmiddle\" border=\"0\" />";
	$de_img="<img src=\"".$img."icons/small/no.gif\" align=\"absmiddle\" border=\"0\" />";
	$active_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\" title=\"Đang ở trạng thái hiển thị.\" />";
	$inactive_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\" title=\"Đang ở trạng thái ẩn.\" />";
	//, , , 
	$ard=array("'",'"',"\n");
	$art=array("\'",'\"',"");
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id_vo;		
		$title = str_replace($ard, $art, $row->title_vo);
		$types = $row->types_vo;
		$dtypes = $op_type[$types];
		$comment = $row->comment_vo;
		
		$show_vo = $row->show_vo;
		//
		switch($show_vo)
		{
			case '0': $show_img = $inactive_img; break;
			case '1': $show_img = $active_img; break;
			default: $show_img = $inactive_img;
		}

		if(empty($id)) break;
		$alt = "<script>
		var alttooltip".$id."='<table width=\"300\" cellspacing=0 cellpadding=0>";
		$alt .="<tr>";
		$alt .="<td>Loại câu hỏi: $dtypes.</td></tr>";
		$alt .="<tr><td >".str_replace($ard , $art, $comment)."</td></tr>";
		$alt .="</table>';</script>";
		echo $alt;

		$i = is_int($idx/2)? 2 : 1;
		//
		$view = anchor('vote_content/add/'.$id, $up_img, array('title' => "Thêm phương án"));
		$anc_title = anchor($this->mod.'/edit/'.$id.'/'.$page, $title, array('title' => "Xem"));

		$str_ans = "";

		if($db_ans)
			foreach($db_ans->result() as $rw)
			{
				$aid = $rw->id_vc;
				$qid = $rw->id_vo;
				$position = $rw->position_vc;
				$content = $rw->content_vc;
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
			&nbsp;Hiện có <span style="font-size:13px; color:#666666;"><?=$total_item;?></span> trong <?=$pagi; ?>
			<span style="float:right; padding-right:10px;"><?=anchor($this->mod.'/add', "Thêm mới");?></span></td>
	</tr>
</table>
</form>
</div>