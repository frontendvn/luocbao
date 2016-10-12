<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');?>
<script type="text/javascript" src="<?php echo $js;?>set_check_box.js"></script>
<?php
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);?>

<table border="0" width="500" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td class="tdrow3"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3">Code</td>
		<td class="tdrow3">Tên module</td>
		<td class="tdrow3">Quyền tồi thiểu</td>
		<td class="tdrow3">Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/delete.gif\" />";
	$per_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/setting.gif\" />";
	
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id;
		$class_name = $row->class_name;
		$required_access = $row->name;
		$anchor_permit = anchor('func_permit/add/'.$id.'/'.$page, $per_img, array('title' => 'Phân quyền cho các chức năng'));
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_del()'));

		$i = (is_int($idx/2))?1:2;	

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\" /></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$class_name</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$required_access</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_permit $anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>
<table width="500" cellspacing="0" cellpadding="0" border="0">
	<tr class="tdrow3">
		<td align="left" width="240">
			<input type="hidden" name="page" value="<?php echo $page;?>" />
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_del();">
		</td>
		<td align="left"><?php echo "Hiện có: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>&nbsp;<?php if($num_rows)echo $pagi?></td>
		<td align="center" width="90"><?php echo anchor($this->mod.'/add/0/'.$page, 'Thêm mới');?></td>
	</tr>
</table>
</form>