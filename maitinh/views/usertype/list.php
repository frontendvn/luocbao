<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir');
//
echo $this->session->flashdata('message');
echo '<br clear="all" />';
	
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
?>

<table border="0" width="500" cellpadding="0" cellspacing="0">
	<tr><td class="maintitle" colspan="5">Danh sách loại thành viên</td></tr>
	<tr align="center">
		<td class="tdrow3">Mã</td>
		<td class="tdrow3">Tên loại</td>
		<td class="tdrow3">Cấp bậc</td>
		<td class="tdrow3">Mô tả</td>
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
		$class_name = $row->name;
		$description = $row->description;
		$required_access = $row->access_level;
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));

		$i = (is_int($idx/2))?1:2;	

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$class_name</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$required_access</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$description</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_edit</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>
<table width="500" cellspacing="0" cellpadding="0">
	<tr class="tdrow3">
		<td><?php echo "Tổng cộng: ";?> <span style="font-size:13px; color:#666666;"><?php echo $num_rows."<br>";?></span>
			<?php if($num_rows)echo $pagi?></td>
	</tr>
</table>