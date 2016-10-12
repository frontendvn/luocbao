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
		<td class="maintitle" colspan="6">Danh sách khách hàng</td>
		<td align="right" class="maintitle" colspan="2"><?=anchor($this->mod.'/add','Thêm mới')?></td>
	</tr>
	<tr>
		<td colspan="8" class="tdrow3">&nbsp;Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> trong <?=$pagi?></td>
	</tr>
	<tr align="center">
		<td class="tdrow3"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3">Mã</td>
		<td class="tdrow3">Tên khách hàng</td>
		<td class="tdrow3">Địa chỉ</td>
		<td class="tdrow3">Điện thoại</td>
		<td class="tdrow3">Email</td>
		<td class="tdrow3">Ngày đăng ký</td>
		<td class="tdrow3" width="80">Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/delete.gif\" />";
	
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id_kh;
		$title = $row->ten_kh;
		$diachi = $row->diachi;
		$dienthoai = $row->dienthoai;
		$email = $row->email;
		$times = date('d-m-y',$row->times);
		$anc = anchor($this->mod.'/edit/'.$id.'/'.$page, $title, array('title' => 'Hiệu chỉnh'));
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_del()'));
		$i = (is_int($idx/2))?1:2;	
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$anc</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$diachi</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$dienthoai</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$email</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$times</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
	<tr class="tdrow3">
		<td align="left" colspan="8">
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_del();">&nbsp;&nbsp;&nbsp;<?php echo "Hiện có: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>&nbsp;<?php if($num_rows)echo $pagi?><span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add', 'Thêm mới');?></span></td>
	</tr>
</table>
</form>