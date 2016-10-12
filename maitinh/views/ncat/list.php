<?php
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 
?>
<script type="text/javascript"  src="<?=$js;?>set_check_box.js" ></script>
<?php
global $mod,$lang;
$mod = $this->mod;
$lang = $this->lang->language;
if($all_root_cate->num_rows()) 
{// have some categories, ok now assign some images for use
	global $up_img, $do_img, $ed_img, $de_img, $li_img, $ac_img, $in_img, $ne_img, $ad_img;
	$up_img = "<img border=\"0\" src=\"".$img."icons/small/up.gif\" />";
	$do_img = "<img border=\"0\" src=\"".$img."icons/small/down.gif\" />";
	$ed_img = "<img border=\"0\" src=\"".$img."icons/small/register.gif\" />";
	$de_img = "<img border=\"0\" src=\"".$img."icons/small/no.gif\" />";
	$ac_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\" />";
	$in_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\" />";
	$li_img = "<img border=\"0\" src=\"".$img."icons/small/files.png\" />";
	$ne_img = "<img border=\"0\" src=\"".$img."icons/small/file_add.png\" />";
	$ad_img = "<img border=\"0\" src=\"".$img."icons/small/add.gif\" />";
	
	function draw_a_cate($row, $is_root = 1)
	{
		global $up_img, $do_img, $ed_img, $de_img, $li_img, $ac_img, $in_img, $ne_img, $ad_img,$mod,$lang;
		$id_nwc = $row->id_nwc;
		$id_cattext = $row->id_cattext;
		$titlecat = $row->nwc_name;
		$comment = $row->nwc_comment;
		$weightcat = $row->nwc_weight;
		if($is_root){
			$titlecat = "<b>".$titlecat."</b>";
		}else{
			$titlecat = "-- ".$titlecat."";
		}
		$ihomcat = $row->nwc_shown;
		$counts = $row->nwc_counts;
		$nwc_pid = $row->nwc_pid;
		switch($ihomcat) {
			case 1: $ihomicon = $ac_img; break;
			case 0: $ihomicon = $in_img; break;
		}
		$show = anchor($mod.'/cat_switch_state/'.$id_nwc, $ihomicon, array('title' => "Hiển thị / Ẩn"));
		$up   = anchor($mod.'/cat_up/'.$id_nwc, $up_img, array('title' => "Chuyển lên"));
		$down = anchor($mod.'/cat_down/'.$id_nwc, $do_img, array('title' => "Chuyển xuống"));
		$edit = anchor($mod.'/edit/'.$id_nwc, $titlecat, array('title' => "Hiệu chỉnh"));
		$del  = anchor($mod.'/del/'.$id_nwc, $de_img, array('title' => "Xóa mục này và các con của nó", 'onclick' =>'return verify_del()'));
		//
		$news = anchor('news/add/'.$id_nwc, $ad_img, array('title' => "Thêm bản tin trong mục này"));
		$list = anchor('news/lists/'.$id_nwc, $li_img, array('title' => "Danh sách bản tin trong mục này"));
		$new = anchor($mod.'/add/'.$id_nwc, $ne_img, array('title' => "Thêm chủ đề con trong mục này"));
		//
		echo "	<tr>\n";
		echo "		<td class=\"tdrow1\" title=\"$comment\">$edit</td>\n";
		echo "		<td class=\"tdrow1\">$id_cattext</td>\n";
		echo "		<td class=\"tdrow1\" width=\"60\" align=\"center\">$up <b>$weightcat</b> $down  </td>\n";
		echo "		<td class=\"tdrow1\" width=\"60\" align=\"center\">$show</td>\n";
		echo "		<td class=\"tdrow1\" width=\"70\" align=\"center\">$counts</td>\n";
		echo "		<td class=\"tdrow1\" width=\"100\" align=\"center\">$del $new $list $news</td>\n";
		echo "	</tr>\n";
	}

echo $this->session->flashdata('message');
echo '<br clear="all" />';

?>
	<table border="0" width="100%" cellpadding="5" cellspacing="0"  class="tableborder">
		<tr>
			<td colspan="6" class="maintitle">Cấu trúc chủ đề đã tạo</td>
		</tr>
		<tr>
			<td class="tdrow3">Tên chủ đề</td>
			<td class="tdrow3">Mã trên link</td>
			<td class="tdrow3" align="center">Vị trí</td>
			<td class="tdrow3" align="center">Hiển thị</td>
			<td class="tdrow3" align="center">Số bản tin</td>
			<td class="tdrow3" align="center">Chức năng</td>
		</tr>
<?php
	foreach ($all_root_cate->result() as $row)
	{
		draw_a_cate($row);
		// now check and print out if there are children cat
		$child_cate = $this->mmod->get_cat_same_level($row->id_nwc);
		if($child_cate->num_rows()>0) 
		{
			foreach ($child_cate->result() as $c_row)
				draw_a_cate($c_row, 0);
		}
	}
?>
	</table>
<?php
}
?>