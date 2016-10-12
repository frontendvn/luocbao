<?php
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;

echo $this->session->flashdata('message');
echo '<br clear="all" />';
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="7" class="maintitle">Danh sách Mẫu bản tin trong <?php echo anchor($this->mod.'/add/', "&raquo; Thêm mới");?></td>
	</tr>
<?php
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="page" value="<?php echo $page;?>" />
	<tr>
		<td colspan="7" class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi; ?></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Tên website</td>
		<td class="tdrow3" align="center">Địa chỉ Website</td>
		<td class="tdrow3" align="center" width="60">Weight</td>
		<td class="tdrow3" width="90" align="center">Chức năng</td>
	</tr>
<?php
if(!empty($total_item))
{
	$up_img = "<img border=\"0\" src=\"".$img."icons/small/up.gif\" />";
	$do_img = "<img border=\"0\" src=\"".$img."icons/small/down.gif\" />";
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
		$id = $row->id_pattern;		
		$name = str_replace($art , $ard, $row->name);
		$website = $row->website;
		$weight = $row->weight;
		//
		$edit_title = anchor($this->mod.'/edit/'.$id.'/'.$page, $name, array('title' => "Hiệu chỉnh"));
		$edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => "Hiệu chỉnh"));
		$del  = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => "Xóa Mẫu bản tin này", 'onclick' =>'return verify_del()'));
		$up   = anchor($this->mod.'/move_up/'.$id, $up_img, array('title' => "Chuyển lên"));
		$down = anchor($this->mod.'/move_down/'.$id, $do_img, array('title' => "Chuyển xuống"));
		
		$i = is_int($idx/2)? 1 : 2;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_title</td>\n";
		echo "		<td class=\"tdrow$i\">$website</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$up <b>$weight</b> $down  </td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"> $edit | $del</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>

<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tdrow3">
			<input type="submit" value="Xóa mục đã chọn" name="btn_submit" onclick="return verify_del();">
			Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi; ?>
			<span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add/', "Thêm mới");?></span>
		</td>
	</tr>
</table>
</form>