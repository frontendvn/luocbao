<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript" src="<?php echo $js;?>set_check_box.js"></script>
<script type="text/javascript">
function verify_del()
{
	return window.confirm("Bạn có muốn xóa người này không?\nVui lòng xác nhận.");
}
function verify_lock()
{
	return window.confirm("Bạn có muốn khóa những người đã chọn không?\nVui lòng xác nhận.");
}
function verify_unlock()
{
	return window.confirm("Bạn có muốn mở khóa những người đã chọn không?\nVui lòng xác nhận.");
}
</script>

<?php
echo $this->session->flashdata('message');
echo '<br clear="all" />';
//
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/disable', $attributes);
//
global $mod;
$mod = $this->mod;
//
if(!empty($managers))
{
	global $ed_img, $de_img, $ac_img, $lvl_img, $lock_img, $unlk_img, $view_img, $per_img, $mod;
	$ed_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/user_edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/user_remove.gif\" />";
	$ac_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/note.gif\" />";
	$lvl_img = "<img border=\"0\" alt=\"\" src=\"".$img."icons/small/assign.gif\" />";
	$lock_img = "<img border=\"0\" title=\"Kích hoạt\" src=\"".$img."icons/small/lock.gif\" />";
	$unlk_img = "<img border=\"0\" title=\"Khóa\" src=\"".$img."icons/small/unlock.gif\" />";
	$view_img = "<img border=\"0\" title=\"\" src=\"".$img."icons/small/report1_16x16.gif\" />";
	$per_img = "<img border=\"0\" title=\"\" src=\"".$img."icons/small/setting.gif\" />";
	//, , , 
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");
	
	function draw_a_cate($row){
		global $ed_img, $de_img, $ac_img, $lvl_img, $lock_img, $unlk_img, $view_img, $per_img, $mod, $box;
		
		$id = !empty($row->id)?$row->id: "";		
		$fullname = !empty($row->fullname)?$row->fullname: "";
		$name = !empty($row->username)?$row->username: "";
		$email = !empty($row->email)?$row->email: "";
		$type_id = !empty($row->type_id)?$row->type_id: "";
		$usertype = !empty($row->name)?$row->name: "";
		$activated = !empty($row->activated)?$row->activated: "";
		$mota = !empty($row->mota)?$row->mota: "";
		$code = !empty($row->code)?$row->code: "";
		$check_box = "<input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\" />";
		$fullname = anchor('member/view/'.$id, $fullname, array('title' => 'Xem thông tin'));

		switch($activated)
		{
			case 'y': $set_img = $unlk_img;break;
			case 'n': $set_img = $lock_img;break;
			default: $set_img = $lock_img;
		}
		$set_status = anchor($mod.'/set_status/'.$id, $set_img);
		$permit = anchor('permit/edit/'.$id, $per_img, array('title' => "Hạn chế quyền mặc định của người này."));
		
		switch($type_id)
		{
			case 1: $str_fullname = " ---<b>".$fullname."</b>"; $check_box = ''; $set_status = ''; $permit = ''; break;
			case 2: $str_fullname =  "&nbsp;&nbsp;&nbsp;&nbsp;|---<b>".$fullname."</b>"; break;
			case 3: $str_fullname =  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---<em>".$fullname."</em>"; break;
			case 4: $str_fullname =  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---".$fullname; break;
			case 5: $str_fullname =  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|~~~~".$fullname; break;
			default: $str_fullname =  "&nbsp;&nbsp;&nbsp;&nbsp;|---|~~~~".$fullname;
		}
		$times = date('d/m/Y', $row->times);
		$i = 2;	
		//
		if(!	in_array($type_id, array(1,2,3,5)))
			$change = anchor($mod.'/assign/'.$id, $lvl_img, array('title' => "Phân nhóm"));
		else
			$change = '';
			
		$view_log = anchor($mod.'/view_log/'.$id, $view_img, array('title' => "Xem thao tác đã lưu"));
		$edit = anchor($mod.'/edit/'.$id, $ed_img, array('title' => "Sửa đổi"));
		$del  = anchor($mod.'/del/'.$id, $de_img, array('title' => "Xóa thành viên này",'onclick' =>'return verify_del()'));
		?>
		<script>
		var alttooltip<?php echo $id;?>="";
		alttooltip<?php echo $id;?> +='<table width="300" cellspacing="0" cellpadding="0">';
		alttooltip<?php echo $id;?> +='<tr><td>Chi tiết: <?php echo $mota;?></td></tr></table>';
		</script>
<?php
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$check_box</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$code</td>\n";
		echo "		<td class=\"tdrow$i\">$str_fullname<span style='float:right' onmouseover='showtip(alttooltip".$id.");' onmouseout='hidetip();'>$ac_img</span></td>\n";
		echo "		<td class=\"tdrow$i\">$name</td>\n";
		echo "		<td class=\"tdrow$i\">$usertype</td>\n";
		echo "		<td class=\"tdrow$i\">$email</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$set_status $edit $del $view_log</td>\n";
		echo "	</tr>\n";
	}
//
	
	echo '<table cellspacing="0" cellpadding="2" class="tableborder">';
	echo '	<tr>';
	echo '		<td class="maintitle" align="center" colspan="7">Danh sách thành viên</td>';
	echo '	</tr>';
	echo '	<tr align="center">';
	echo '		<td class="tdrow3" width="40"><input type="checkbox" name="sa" id="sa" onclick="check_chose(\'sa\', \'ar_id[]\', \'checknew\')" /></td>';
	echo '		<td class="tdrow3">Code</td>';
	echo '		<td class="tdrow3">Họ tên</td>';
	echo '		<td class="tdrow3">Tên đăng nhập</td>';
	echo '		<td class="tdrow3">Loại thành viên</td>';
	echo '		<td class="tdrow3">Email</td>';
	echo '		<td class="tdrow3" width="120">Chức năng</td>';
	echo '	</tr>';

	foreach($managers->result() as $row)
	{
		draw_a_cate($row);
	}
?>
	<tr class="tdrow3">
		<td colspan="7">
			<input type="submit" name="btn_lock" value="Khóa user đã chọn" id="button" onclick="return verify_lock();" />
			<input type="submit" name="btn_unlock" value="Mở user đã chọn" id="button" onclick="return verify_unlock();" />
		</td>
	</tr>
<?php
	echo '</table>';
}
echo form_close();
?>