<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');?>
<?php
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);?>
<script>
function verify_confirm(){
return window.confirm("Nếu xóa bỏ mục này thì dữ liệu trong  mục 'Blocks' sẽ bị xoá theo.\nBạn có xóa không?");
}
</script>
<table border="0" cellpadding="0" cellspacing="0">
	<tr><td class="maintitle" colspan="2">Danh sách skin</td>
	<td align="right" class="maintitle" colspan="2"><?=anchor($this->mod.'/add','Thêm mới skin')?></td>
	</tr>
	<tr align="center">
		<td class="tdrow3"></td>
		<td class="tdrow3">Mã</td>
		<td class="tdrow3">Tiêu đề</td>
		<td class="tdrow3" width="80">Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/delete.gif\" />";
	
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id;
		$title = $row->title;
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_confirm()'));

		$i = (is_int($idx/2))?1:2;	

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"wid[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
	<tr class="tdrow3">
		<td align="left" colspan="4"><a href="#" onclick="setCheckboxes('checknew', true); return false;">Chọn hết </a> | <a href="#" onclick="setCheckboxes('checknew', false); return false;">Bỏ chọn</a>
			<input type="hidden" name="page" value="<?php echo $page;?>" />
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_confirm();">
		&nbsp;&nbsp;&nbsp;<?php echo "Hiện có: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>&nbsp;<?php if($num_rows)echo $pagi?>
		&nbsp;&nbsp;&nbsp;<?php echo anchor($this->mod.'/add', 'Thêm mới skin');?></td>
	</tr>
</table>
</form>