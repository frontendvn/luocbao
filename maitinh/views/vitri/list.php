<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<br />
<script type="text/javascript" src="<?=$js?>set_check_box.js"></script>
<?php
$ar_type = $this->config->item('type');
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;
$total_item=empty($total_item)?"0":$total_item;
$attributes = array('class' => 'email', 'id' => 'checknew');
echo form_open($this->mod.'/dels', $attributes);
?>
<input type="hidden" name="page" value="<?php echo $page;?>" />
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="maintitle" colspan="2">Danh sách vị trí</td>
		<td align="right" class="maintitle" colspan="2"><?=anchor($this->mod.'/add','Thêm mới')?></td>
	</tr>
	<tr>
		<td colspan="4" class="tdrow3">&nbsp;Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> trong <?=$pagi?></td>
	</tr>
	<tr align="center">
		<td class="tdrow3"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></td>
		<td class="tdrow3">Mã</td>
		<td class="tdrow3">Tên</td>
		<td class="tdrow3" width="80">Chức năng</td>
	</tr>
	<?php 
if($num_rows)
{
	$ad_img = "<img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"".$img."icons/small/add.gif\" />";
	$ed_img = "<img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"".$img."icons/small/edit.gif\" />";
	$de_img = "<img border=\"0\" alt=\"\" style=\"vertical-align:middle\" src=\"".$img."icons/small/delete.gif\" />";
	$time = time();
	$art = array("'",'"',"\n");
	$arf = array("\'",'\"',"");
	
	for($idx = $first_item; $idx < $last_item; $idx++){
		$row = $db->row($idx); 
		$id = $row->id_vt;
		$ten_vt = '<strong>'.$row->ten_vt.'</strong>';
		$ngang = $row->ngang;
		$doc = $row->doc;
		$anc = anchor($this->mod.'/edit/'.$id.'/'.$page, $ten_vt, array('title' => 'Hiệu chỉnh'));
		$anchor_add = anchor('quangcao/add/'.$id, $ad_img, array('title' => 'Thêm quảng cáo vào vị trí này'));
		$anchor_edit = anchor($this->mod.'/edit/'.$id.'/'.$page, $ed_img, array('title' => 'Hiệu chỉnh'));
		$anchor_del = anchor($this->mod.'/del/'.$id.'/'.$page, $de_img, array('title' => 'Xóa mục này', 'onclick' => 'return verify_del()'));
		$i = (is_int($idx/2))?1:2;	
		$str_ans = "";

		if($db_qc){
			foreach($db_qc->result() as $rw)
			{
				$aid = $rw->id;	
				$qid = $rw->id_vitri;
				$position = $rw->weight;
				$content = $rw->ten;
				$types = $rw->types;
				$meta = $rw->meta;
				$ten_kh = $this->pmod->khachhang($rw->id_kh);
				$ten_kh = $ten_kh?$ten_kh:"quảng cáo mặc định";
				$image_ans = $rw->image;
				$qc_mau = ($rw->temp)?"<strong style='color:#0000FF'>".$content.' ( '.$ten_kh.' )'."</strong>":$content.' ( '.$ten_kh.' )';
				
				$dk = $rw->ngay_dangky;
				$hh = $rw->ngay_hethan;
				$ngayconlai = empty($hh)?'<span style="color:#0000ff;">#</span>':ceil(($hh-$time)/86400); 
				if(is_numeric($ngayconlai) and $ngayconlai <= 0) $content = '<font style="text-decoration:line-through">'.$content.'</font>';
				
				if($image_ans)
				{
					$pos = strpos($image_ans, 'http://');
		
					#$str_img = $pos===FALSE?'<img src="'.base_url()."../".$image_ans.'" width=\"100\" style=\"vertical-align:middle\" />':'<img src="'.$image_ans.'" width=\"100\" style=\"vertical-align:middle\" />';	
					$str_image = $pos===false?'../'.$image_ans:$image_ans;
				}
				else
				{
					$str_image = '';
				}
				$display = showIMG($str_image,150);
				

				$alt = "<script>
				var alttooltip".$aid."='<table width=\"300\" cellspacing=0 cellpadding=0>";
				$alt .="<tr>";
				$alt .="<td>".$display."</td>";
				$alt .="</tr></table>';</script>";
				echo $alt;

				if($qid==$id)
				{
					$edit_ans = anchor('quangcao/edit/'.$aid, $qc_mau, array('title' => "Hiệu chỉnh quảng cáo"));
					$del_ans = anchor('quangcao/del/'.$aid, $de_img, array('title' => "Xóa quảng cáo", 'onclick' =>'return verify_del()'));
					
					$str_ans .= "<p>$del_ans $position. <span onMouseOver='showtip(alttooltip".$aid.");' onMouseOut='hidetip();'>$edit_ans</span> [$ngayconlai ngày]</p>";
				}
			}
		}
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><input type=\"checkbox\" name=\"ar_id[]\" value=\"$id\"></td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\">$anc ($ngang x $doc)<br />$str_ans</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$anchor_add $anchor_edit $anchor_del</td>\n";
		echo "	</tr>\n";
	}
}
?>
	<tr class="tdrow3">
		<td align="left" colspan="4">
			<input type="submit" name="btn_submit" value="Xóa mục đã chọn" id="button" onclick="return verify_del();">&nbsp;&nbsp;&nbsp;<?php echo "Hiện có: ";?> 
			<span style="font-size:13px; color:#666666;"><?php echo $num_rows;?></span>&nbsp;
			<?php if($num_rows)echo $pagi?>
			<span style="float:right; padding-right:10px;"><?php echo anchor($this->mod.'/add', 'Thêm mới');?></span>
			</td>
	</tr>
</table>
</form>