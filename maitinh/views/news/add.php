<?=form_open_multipart($this->mod.'/add')?>
	<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>THÊM BẢN TIN</strong> <input type="submit" name="btn_submit" value="Lưu bản tin" /></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="20%"><strong>Thuộc chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1">
				<?php echo $the_select_box;?>
				<strong>Tác giả</strong> <font color="#FF0000">*</font> <input type="text" name="news_author" size="61" value="<?=$this->input->post('news_author')?>" />
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Tiêu đề </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1">
				<input type="text" size="61" name="news_title" value="<?=$this->input->post('news_title')?>" maxlength="255" />
				<strong>Mã trên link</strong> <input type="text" size="61" name="id_text" value="<?=$this->input->post('id_text')?>" maxlength="255" />
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Hình ảnh </strong></td>
			<td class="tdrow1"><input type="file" size="40" name="userfile" />
				<label><?php echo form_checkbox('news_show', '1', $this->input->post('news_show'));?><strong>Hiển thị</strong></label>
				<label><?php echo form_checkbox('news_lead', '1', $this->input->post('news_lead'));?> <strong>Nổi bật</strong></label>
				<label><?php echo form_checkbox('news_special', '1', $this->input->post('news_special'), 'id="news_special"');?> <strong>Tin đặc biệt</strong></label>
				<label> <strong>trong</strong> <?php echo form_dropdown('news_specialtime', $time_options, $this->input->post('news_specialtime'), 'id="news_specialtime" disabled="disabled"')?> giờ.</label>
				<label><strong>Tin hay</strong> <?php echo form_checkbox('news_useful', '1', $this->input->post('news_useful'));?></label>
			</td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Xem nhanh</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="106" rows="5" name="news_quickview"><?=$this->input->post('news_quickview')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung</strong></td>
			<td class="tdrow1"><?php echo $news_content;?></td>
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
</script>