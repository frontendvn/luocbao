<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

echo $this->session->flashdata('message');
echo '<br clear="all" />';
$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?'':'Trong '.$pagi;
$page=empty($page)?0:$page;
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="5" class="maintitle"><form method="post">Danh sách bản tin trong <?php echo $the_select_box.' '.anchor($this->mod.'/add/'.$cid, "&raquo; Thêm mới")?></form></td>
	</tr>
<?php
if(!empty($total_item))
{
	global $up_img, $ed_img, $de_img, $ac_img, $in_img;
	$up_img = "<img border=\"0\" src=\"".$img."icons/small/past.gif\">";
	$ed_img = "<img border=\"0\" src=\"".$img."icons/small/register.gif\">";
	$de_img = "<img border=\"0\" src=\"".$img."icons/small/no.gif\">";
	$ac_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\">";
	$in_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\">";
	//, , , 
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");
?>
<?php
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="list_type" value="<?php echo $this->uri->segment(2);?>" />
<input type="hidden" name="cid" value="<?php echo $cid;?>" />
<input type="hidden" name="page" value="<?php echo $page;?>" />
	<tr>
		<td colspan="5" class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi; ?></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Tiêu đề</td>
		<td class="tdrow3" align="center">Tác giả</td>
		<td class="tdrow3" width="90" align="center">Chức năng</td>
	</tr>
<?php
	for($idx = $first_item; $idx < $last_item; $idx++)
	{
		$row = $db->row($idx); 
		$id = $row->id_news;
		$id_nwc = $row->id_nwc;		
		$title = str_replace($art , $ard, $row->news_title);
		$img = $row->news_img_thumb;
		$quickview = $row->news_quickview;
		$view_count = $row->news_viewcount;
		$author = $row->news_author;
		$show = $row->news_show;
		if($show=='1'){
			$ihomicon = $ac_img;
		}else{
			$ihomicon = $in_img;
		}
		//
		$edit_title = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id.'/'.$page, $title, array('title' => "Hiệu chỉnh bản tin này."));
		$show = anchor($this->mod.'/show/'.$id_nwc.'/'.$id.'/'.$page, $ihomicon, array('title' => "Hiển thị / Ẩn"));
		$edit = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id.'/'.$page, $ed_img, array('title' => "Hiệu chỉnh bản tin này."));
		$del  = anchor($this->mod.'/del/'.$id_nwc.'/'.$id.'/'.$page, $de_img, array('title' => "Xóa bản tin này", 'onclick' =>'return verify_del()'));
		
		$i = is_int($idx/2)? 1 : 2;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_title</td>\n";
		echo "		<td class=\"tdrow$i\">$author</td>\n";
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
			Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi;?>
			<span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add/'.$cid, "Thêm mới");?></span>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
function verify_audit()
{
	return window.confirm("Bạn có muốn duyệt nhanh các mục đã chọn không?\nVui lòng xác nhận.");
}
</script>