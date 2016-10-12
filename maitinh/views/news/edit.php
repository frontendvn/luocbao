<?php
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

echo form_open_multipart($this->mod.'/edit')
?>
<input type="hidden" name="id_news" value="<?php echo $id_news;?>" />
<input type="hidden" name="id_nwc" value="<?php echo $id_nwc;?>" />
	<table  width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>HIỆU CHỈNH BẢN TIN</strong> <input type="submit" name="btn_submit" value="Lưu bản tin" />&nbsp;<?php echo '[<a href="'.SITE.'/news/preview/'.$id_cattext.'/'.stripslashes($id_text).'" target="_blank" title="">Xem trước</a>]'?><span style="float:right"><?=anchor($this->mod.'/del/'.$id_nwc.'/'.$id_news.'/'.$page, '<img src="'.base_url().ROOT.'images/icons/small/delete.gif" title="" style="vertical-align:middle" />', array('title'=>'Xóa bản tin', 'onclick'=>'return verify_del()')).'&nbsp;(Xóa bản tin)&nbsp;'.$news_near?></span></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="100"><strong>Thuộc chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1">
				<?php echo $the_select_box;?>
				<strong>Tác giả</strong> <font color="#FF0000">*</font> <input type="text" size="61" name="news_author" value="<?php echo $news_author;?>" />&nbsp;<?='[<a href="'.$news_link.'" target="_blank" title="Xem bản tin gốc">Link gốc</a>]'?>
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Tiêu đề</strong> <font color="#FF0000">*</font></td>
		<td class="tdrow1"><?=form_input(array('size'=>"61", 'name'=>"news_title", 'value'=> $news_title, 'maxlength'=>"255"))?>
				<strong>Mã trên link</strong> <input type="text" size="61" name="id_text" value="<?php echo $id_text;?>" maxlength="255" />
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Hình ảnh </strong></td>
			<td class="tdrow1">Upload <input type="file" size="40" name="userfile" />
				<label><?php echo form_checkbox('news_audit', '1', $news_audit);?> <strong>Duyệt</strong></label>
				<label><?php echo form_checkbox('news_show', '1', $news_show);?> <strong>Hiển thị</strong></label>
				<label><?php echo form_checkbox('news_lead', '1', $news_lead);?> <strong>Tin nóng</strong></label>
				<label><?php echo form_checkbox('news_special', '1', $news_special, 'id="news_special"');?> <strong>Tin đặc biệt</strong></label>
				<label> <strong>trong</strong> <?php echo form_dropdown('news_specialtime', $time_options, $news_specialtime, 'id="news_specialtime" '.$disabled)?> giờ.</label>
				<label><strong>Tin hay</strong> <?php echo form_checkbox('news_useful', '1', $news_useful);?></label><br />
				<em><?php echo '(Định dạng: '.str_replace(', flv', '', str_replace('|', ', ', $this->config->item('allowed_types'))).'. Dung lượng: '.$this->config->item('img_size').'KB. Kích thước: '.$this->config->item('img_width').'x'.$this->config->item('img_height').')';?></em><br />
		<?php
			if($news_img && file_exists(ROOT.$news_img)){
				echo '<strong><em>Hình chính</em></strong><img src="'.$img.'icons/small/del.jpg" style="cursor:pointer; vertical-align:top" onclick="del_mainimg()" title="Xóa hình chính" /><br /><span id="main_img"><img src="'.base_url().ROOT.$news_img.'" width="100" /></span><br />';
			}
			else
			{
				echo '<strong><em>Hình chính</em></strong><img src="'.$img.'icons/small/del.jpg" style="cursor:pointer; vertical-align:top" onclick="del_mainimg()" title="Xóa hình chính" /><br /><span id="main_img"></span><br />';
			}
			if($news_meta)
			{
				$n = sizeof($news_meta);
				echo '<strong><em>Hình trong nội dung bản tin.</em></strong><br /><div>';
				for($i=0; $i<$n;$i++)
				{
					$val = $news_meta[$i];
					if($val && file_exists(ROOT.$val))
						echo "<div id=\"image_$i\" style=\"float:left\"><img id=\"img$i\" src=\"".base_url().ROOT.$val."\" width=\"100\" style=\"cursor:pointer; vertical-align:top\" onclick=\"chosen('vl$i')\" /><span id=\"vl$i\" style=\"display:none\">$val</span>&nbsp;<input type=\"hidden\" name=\"news_meta[]\" id=\"val_img$i\" value=\"$val\" /><br /><div align=\"center\"><img id=\"imgdel$i\" src=\"".$img."icons/small/del.jpg\" style=\"cursor:pointer; vertical-align:top\" onclick=\"del_img('image_$i')\" title=\"Xóa hình này\" /></div></div>";
				}
				echo '</div><br clear="all" /><strong><em>Có thể click chọn những hình trên làm hình chính.</em></strong>';
			}
		?>
			<input type="hidden" name="news_img" id="news_img" value="<?php echo $news_img?>" />
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Xem nhanh</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1">
				<textarea cols="106" rows="5" name="news_quickview"><?php echo $news_quickview;?></textarea>
				</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung</strong></td>
			<td class="tdrow1"><?php echo $html_news_content;?></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Lưu bản tin" /></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
$(function(){
	$('#news_special').click(function(){
		check = $('#news_special:checked').val();
		if(check)
		{
			$('#news_specialtime').attr("disabled","");
		}
		else
		{
			$('#news_specialtime').attr("disabled","disabled");
		}
	});
})

var url = '<?php echo base_url().ROOT?>';
function chosen(id)
{
	if(id)
	{
		var vl = $('#'+id).text();
		$('#news_img').val(vl);
		$('#main_img').html('<img src="' + url + vl + '" width="100" />');
	}
	else
	{
		return false;
	}
}
function del_img(id)
{
	$("#"+id).replaceWith('');
}
function del_mainimg()
{
	$("#news_img").attr("value","");
	$('#main_img').html('');
}
function verify_del()
{
	return window.confirm("Bạn có muốn xóa bản tin này?\nVui lòng xác nhận.");
}
</script>