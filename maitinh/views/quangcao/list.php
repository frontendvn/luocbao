<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript" src="<?=$js?>set_check_box.js"></script>
<?php
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$total_item=empty($total_item)?"0":$total_item;
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="page" value="<?php echo $page;?>" />
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="maintitle" colspan="9">Danh sách quảng cáo</td>
		<td align="right" class="maintitle" colspan="2"><?=anchor($this->mod.'/add','Thêm mới')?></td>
	</tr>
	<tr>
		<td colspan="11" class="tdrow3">&nbsp;Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> trong <?=$pagi?></td>
	</tr>
	<tr align="center">
		<td class="tdrow3"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3">Mã</td>
		<td class="tdrow3">Tên quảng cáo</td>
		<td class="tdrow3">Vị trí</td>
		<td class="tdrow3">Chủ đề</td>
		<td class="tdrow3">Thời gian</td>
		<td class="tdrow3">Ngày đăng ký</td>
		<td class="tdrow3">Ngày hết hạn</td>
		<td class="tdrow3">Số ngày còn lại</td>
		<td class="tdrow3">Số click</td>
		<td class="tdrow3" width="80" >Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/delete.gif\" />";
	$time = time();
	$art = array("'",'"',"\n");
	$arf = array("\'",'\"',"");
	
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id;
		$temp = $row->temp;
		$title = empty($temp)?$row->ten:'<strong style="color:#0000FF">'.$row->ten.'</strong>';
		$image = $row->image;
		$types = $row->types;
		$meta = $row->meta;
		$vitri = $row->ten_vt;
		$id_cattext = $row->id_cattext;
		$dk = $row->ngay_dangky;
		$hh = $row->ngay_hethan;
		$tg_hienthi = $row->tg_hienthi;
		$ngayconlai = empty($hh)?'<span style="color:#0000ff;">không</span>':ceil(($hh-$time)/86400);
		if(is_numeric($ngayconlai) and $ngayconlai<=0) $title = '<font style="text-decoration:line-through">'.$title.'</font>';
		$ngay_dangky = date('d-m-y', $dk);
		$ngay_hethan = empty($hh)?$ngayconlai:date('d-m-y', $hh);
		$clicks = $row->clicks;
		$anc = anchor($this->mod.'/edit/'.$id.'/'.$page, $title, array('title' => 'Hiệu chỉnh'));
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_del()'));
		
		
		$i = (is_int($idx/2))?1:2;	
		
		if($image)
		{
			$pos = strpos($image, 'http://');
			$str_image = $pos===false?'../'.$image:$image;
		}
		else
		{
			$str_image = '';
		}
		$display = showIMG($str_image,150);
		
		if(empty($id)) break;
		$alt = "<script>
		var alttooltip".$id."='<table width=\"300\" cellspacing=0 cellpadding=0>";
		$alt .="<tr>";
		$alt .="<td>".$display."</td>";
		$alt .="</tr></table>';</script>";
		echo $alt;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" onMouseOver='showtip(alttooltip".$id.");' onMouseOut='hidetip();'>$anc</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$vitri</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$id_cattext</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$tg_hienthi</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$ngay_dangky</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$ngay_hethan</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$ngayconlai</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$clicks</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
	<tr class="tdrow3">
		<td align="left" colspan="11">
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_del();">&nbsp;&nbsp;&nbsp;<?php echo "Hiện có: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>&nbsp;<?php if($num_rows)echo $pagi?><span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add', 'Thêm mới');?></span></td>
	</tr>
</table>
</form>