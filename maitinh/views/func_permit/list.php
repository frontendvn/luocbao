<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript" src="<?php echo $js;?>set_check_box.js"></script>
<?php
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
echo form_hidden('cid', $cid);
echo form_hidden('page', $page);
?>
<table border="0" width="770" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td class="tdrow3" width="20"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3">Code</td>
		<td class="tdrow3">Tên module</td>
		<td class="tdrow3">Tên chức năng</td>
		<td class="tdrow3">Quyền tối thiểu</td>
		<td class="tdrow3">Mô tả</td>
		<td class="tdrow3" width="70">Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/delete.gif\" />";

	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id;
		$id_class = $row->id_class;
		$class_name = $row->class_name;
		$func_name = $row->func_name;
		$required_access = $row->name;
		$note = $row->note;
		$anchor_edit = anchor($this->mod.'/edit/'.$id_class.'/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id_class.'/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_del()'));

		$i = (is_int($idx/2))?1:2;	

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$class_name</td>\n";
		echo "		<td class=\"tdrow$i\">$func_name</td>\n";
		echo "		<td class=\"tdrow$i\">$required_access</td>\n";
		echo "		<td class=\"tdrow$i\">$note</td>\n";
		echo "		<td class=\"tdrow$i\" width=\"80\" align=\"center\">$anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>
<table width="770" cellspacing="0" cellpadding="0">
	<tr class="tdrow3">
		<td align="left">
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_del();">
		</td>
		<td><?php echo "Hiện có: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>
			<?php if($num_rows)echo $pagi?></td>
		<td align="right" style="padding-right:10px; border-left:0px;"> <?php echo anchor($this->mod.'/add/'.$cid.'/0/'.$page, 'Thêm mới');?></td>
	</tr>
</table>
</form>