<?php
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?'':'Trong '.$pagi;
$page=empty($page)?0:$page;
$cid=empty($cid)?0:$cid;

echo $this->session->flashdata('message');
echo '<br clear="all" />';
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="6" class="maintitle"><form method="post">Danh sách crawler trong <?php echo $the_select_box.' '.anchor($this->mod.'/add/'.$cid, "&raquo; Thêm mới");?></form></td>
	</tr>
<?php
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="cid" value="<?php echo $cid;?>" />
<input type="hidden" name="page" value="<?php echo $page;?>" />
	<tr>
		<td colspan="6" class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi; ?></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Tên chủ đề</td>
		<td class="tdrow3" align="center">Mẫu website</td>
		<td class="tdrow3" align="center">Link chủ đề</td>
		<td class="tdrow3" width="90" align="center">Chức năng</td>
	</tr>
<?php
if(!empty($total_item)){
	$up_img = "<img border=\"0\" src=\"".$img."icons/small/past.gif\">";
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
		$id = $row->id;		
		$id_pattern = $row->id_pattern;
		$cid = $row->id_nwc;
		$nwc_name = $row->nwc_name;
		$name = str_replace($art , $ard, $row->name);
		$links = $row->links;
		$show = $row->available;
		
		if($show=='1'){
			$ihomicon = $ac_img;
		}else{
			$ihomicon = $in_img;
		}
		//
		$show = anchor($this->mod.'/show/'.$cid.'/'.$id.'/'.$page, $ihomicon, array('title' => "Enabled / Disabled"));
		$edit_ncat = anchor('ncat/edit/'.$cid, $nwc_name, array('title' => "Hiệu chỉnh chủ đề này"));
		$edit_pattern = anchor('pattern/edit/'.$id_pattern, $name, array('title' => "Hiệu chỉnh pattern này"));
		$edit_title = anchor($this->mod.'/edit/'.$cid.'/'.$id.'/'.$page, $links, array('title' => "Hiệu chỉnh crawler này"));
		$edit = anchor($this->mod.'/edit/'.$cid.'/'.$id.'/'.$page, $ed_img, array('title' => "Hiệu chỉnh"));
		$del  = anchor($this->mod.'/del/'.$cid.'/'.$id.'/'.$page, $de_img, array('title' => "Xóa record này", 'onclick' =>'return verify_del()'));
		
		$i = is_int($idx/2)? 1 : 2;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_ncat</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_pattern</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$show | $edit | $del</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>

<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tdrow3">
			<input type="submit" value="Xóa mục đã chọn" name="btn_submit" onclick="return verify_del();">
			<input type="submit" value="Enabled mục đã chọn" name="btn_ensabled" onclick="return verify_enabled();">
			<input type="submit" value="Disabled mục đã chọn" name="btn_disabled" onclick="return verify_disabled();">
			<span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add/'.$cid, "Thêm mới");?></span>
		</td>
	</tr>
	<tr>
		<td class="tdrow3">
			Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi; ?>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
function verify_enabled()
{
	return window.confirm("Bạn có muốn enabled các mục đã chọn không?\nVui lòng xác nhận.");
}
function verify_disabled()
{
	return window.confirm("Bạn có muốn disabled các mục đã chọn không?\nVui lòng xác nhận.");
}
</script>