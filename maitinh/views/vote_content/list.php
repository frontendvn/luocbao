<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$id=empty($id)?"":$id;
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<?php
$attributes = array('id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="page" value="<?php echo $page;?>" />
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td class="tdrow3" width="30" align="center">Chọn</td>
		<td class="tdrow3" align="center">Nội dung phương án</td>
		<td class="tdrow3" width="90" align="center">Câu hỏi</td>
		<td class="tdrow3" width="60" align="center">vị trí</td>
		<td class="tdrow3" width="70" align="center">Chức năng</td>
	</tr>
<?php
if(!empty($total_item))
{
	$up_img = "<img border=\"0\" src=\"".$img."icons/small/up.gif\">";
	$do_img = "<img border=\"0\" src=\"".$img."icons/small/down.gif\">";
	$ed_img = "<img border=\"0\" src=\"".$img."icons/small/register.gif\">";
	$de_img = "<img border=\"0\" src=\"".$img."icons/small/no.gif\">";
	$ac_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\">";
	$in_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\">";
	//, , , 
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");
	for($idx = $first_item; $idx < $last_item; $idx++)
	{
		$row = $db->row($idx); 
		$id = $row->id_vc;
		$content = $row->content_vc;	
		$title = word_limiter(str_replace($art , $ard, $content),15);
		$position = $row->position_vc;
		$qid = $row->id_vo;
		$qtypes = $op_type[$row->qtypes];
		//
		$alt = "<script>
		var alttooltip".$id."='<table width=\"300\" cellspacing=0 cellpadding=0>";
		
		$alt .="<tr><td>$content</td></tr>";
		$alt .="</table>';</script>";
		echo $alt;
		//
		$up   = anchor($this->mod.'/move_up/'.$qid.'/'.$id, $up_img, array('title' => "Chuyển lên"));
		$down = anchor($this->mod.'/move_down/'.$qid.'/'.$id, $do_img, array('title' => "Chuyển xuống"));
		$edit = anchor($this->mod.'/edit/'.$qid.'/'.$id.'/'.$page, $ed_img, array('title' => "Sửa đổi"));
		$del  = anchor($this->mod.'/del/'.$qid.'/'.$id.'/'.$page, $de_img, array('title' => "Xóa phương án này", 'onclick' =>'return verify_del()'));

		$i = is_int($idx/2)? 2 : 1;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"wid[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" onMouseOver='showtip(alttooltip".$id.");' onMouseOut='hidetip();'>$title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$qtypes</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$up <b>$position</b> $down</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"> $edit | $del</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>
<input type="hidden" name="qid" value="<?=$qid;?>" />
<table width="100%" cellspacing="0" cellpadding="0"  >
	<tr>
		<td class="tdrow3">
			<a href="#" onclick="setCheckboxes('checknew', true); return false;">Chọn hết</a> | 
			<a href="#" onclick="setCheckboxes('checknew', false); return false;">Bỏ chọn</a>
			<input type="submit" value="Xóa mục đã chọn" name="btn_submit" onclick="return verify_del();">
		</td>
		<td class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?=$total_item;?></span> trong <?=$pagi?>
		</td>
		<td class="tdrow3" align="right" style="padding-right:10px;">
		<?=anchor($this->mod.'/add/'.$qid.'/0/'.$page, "Thêm mới", array('title' => "Thêm phương án mới"));?></td>
	</tr>
	<tr><td class="tdrow2" colspan="3" align="right"><?=anchor('vote/add', "&raquo; Quản lý thăm dò", array('title' => "Trở về trang danh sách thăm dò"));?></td></tr>
</table>
</form>