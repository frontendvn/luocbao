<?=form_open($this->mod.'/edit')?>
<input type="hidden" name="id_pattern" value="<?=$id_pattern;?>" />
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
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu lấy link</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="link_xpath"><?=$link_xpath?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu link xấu</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="link_bad"><?=$link_bad?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu tiêu đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_xpath"><?=$title_xpath?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu tiêu đề xấu</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title_bad"><?=$title_bad?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu xem nhanh</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_xpath"><?=$intro_xpath?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu xem nhanh xấu</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="intro_bad"><?=$intro_bad?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu nội dung</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_xpath"><?=$content_xpath?></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mẫu nội dung xấu</strong></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content_bad"><?=$content_bad?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Hiệu chỉnh" id="button" /></td>
		</tr>
	</table>
</form>