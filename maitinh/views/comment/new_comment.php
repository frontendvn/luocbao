<?php
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 

//
$total = empty($total_item)?" 0":$total_item;
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"":$page;

?>

<input type="hidden" name="page" value="<?php echo $page;?>" />
<table width="98%"  cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder" >
<tr><td class="maintitle" colspan="3">Danh sách nhận xét chưa xem</td></tr>
<?php 
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->mod.'/del_all', $attributes);

$ac_img = "<img border=\"0\" src=\"".$img."icons/small/active.gif\">";
$in_img = "<img border=\"0\" src=\"".$img."icons/small/inactive.gif\">";
$de_img = "<img border=\"0\" src=\"".$img."icons/small/no.gif\">";
	
			
if(!empty($total_item)){
	for($j = $first_item; $j < $last_item; $j++){
		$rows 			= $show->row($j); 
		$comment_id 	= $rows->id;	
		$content 		= $rows->content;	
		$comm_time 		= date(' d/m/Y H:i:s A',$rows->comm_time);
		$fullname 		= $rows->fullname;	
		$shown_comment 	= $rows->shown;	
		$email 			= $rows->email;	
		$del 			= anchor($this->mod.'/dels/'.$comment_id.'/'.$page,$de_img,array('title'=>'Xoá','onclick'=>'return verify_confirm();'));
		$id_text 		= $rows->id_text;	
		$id_cattext 	= $rows->id_cattext;	
		$news_title 	= $rows->news_title;
		switch($shown_comment) {
			case 1: $shown_ = $ac_img; break;
			case 0: $shown_ = $in_img; break;
		}
		$show_link = anchor($this->mod.'/cat_switch_state/'.$comment_id.'/'.$page, $shown_, array('title' => 'Ẩn / Hiện'));
		
		if($j%2==0) $class ='class="tdrow2"';
		else $class ='class="tdrow1"';
?>
 <tr>
 	 <td <?=$class;?> > <?=$del;?>&nbsp;<?=$show_link;?>&nbsp; &raquo; <?=$fullname;?><br /><em> (<?=$email;?> )</em></td>
	 <td align="left" <?=$class;?>><?=$content;?> &nbsp;&nbsp;<em>(<?=$comm_time;?>)<br /></em></td>
	 <td align="left" <?=$class;?>><a target="_blank" href="<?=base_url().'../index.php/detail/'.$id_cattext.'/'.$id_text;?>"><?=$news_title;?></a></td>
 </tr>

<?php
	}
}
?>
	<tr>
		<td class="tdrow3" colspan="3">
		Tổng cộng
		<span style="font-size:13px; color:#666666;"><?php echo $total;?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $pagi; ?>
		</td>
	</tr>
</table>
</form>

<script>
function verify_confirm(){
return window.confirm("Bạn muốn xoá nhận xét của tài liệu này.\nBạn có xoá không?");
}
</script>