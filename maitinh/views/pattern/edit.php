<?=form_open($this->mod.'/edit')?>
<input type="hidden" name="id_pattern" value="<?php echo $id_pattern;?>" />
	<table  width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>QUẢN LÝ MẪU BẢN TIN</strong></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Tên website </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="name" size="50" value="<?=$name?>" /></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Địa chỉ Website </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="website" size="50" value="<?=$website?>" /></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open lấy link</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="html_open"><?=$html_open?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close lấy link</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="html_close"><?=$html_close?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open tiêu đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_open"><?=$title_open?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close tiêu đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_close"><?=$title_close?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open xem nhanh</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_open"><?=$intro_open?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close xem nhanh</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_close"><?=$intro_close?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu open nội dung</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_open"><?=$content_open?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu close nội dung</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_close"><?=$content_close?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Hiệu chỉnh" id="button" /></td>
		</tr>
	</table>
</form>