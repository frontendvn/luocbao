<?=form_open($this->mod.'/add')?>
	<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>QUẢN LÝ MẪU BẢN TIN</strong></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Tên website </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="name" size="50" value="<?=$this->input->post('name')?>" /></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Địa chỉ Website </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="website" size="50" value="<?=$this->input->post('website')?>" /></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open lấy link</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="html_open"><?=$this->input->post('html_open')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close lấy link</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="html_close"><?=$this->input->post('html_close')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open tiêu đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_open"><?=$this->input->post('title_open')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close tiêu đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_close"><?=$this->input->post('title_close')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open xem nhanh</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_open"><?=$this->input->post('intro_open')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close xem nhanh</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_close"><?=$this->input->post('intro_close')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open nội dung</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_open"><?=$this->input->post('content_open')?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close nội dung</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_close"><?=$this->input->post('content_close')?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Thêm mới" id="button" /></td>
		</tr>
	</table>
</form>