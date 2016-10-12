<?=form_open($this->mod.'/edit')?>
<table border="0" width="500" cellpadding="5" cellspacing="0" align="center" class="tableborder">
	<tr>
		<td colspan="2" class="maintitle">Hiệu chỉnh "<?=$nwc_name?>"</td>
	</tr>
	<tr>
		<td width="40%" class="tdrow1"><b>Tiêu đề</b> <font color="#FF0000">*</font></td>
		<td class="tdrow1">
			<input type="text" size="50" name="nwc_name" value="<?=$nwc_name?>" />
			<input type="hidden" name="id_nwc" value="<?=$id_nwc?>" />
		</td>
	</tr>
	<tr>
		<td width="40%" class="tdrow1"><b>Mã trên link</b> <font color="#FF0000">*</font></td>
		<td class="tdrow1">
			<input type="text" size="50" name="id_cattext" value="<?=$id_cattext?>" />
		</td>
	</tr>
	<tr>
		<td class="tdrow1"><strong>Thuộc chủ đề </strong></td>
	  	<td class="tdrow1"><?=$the_select_box?></td>
	</tr>
	<tr>
		<td width="40%" class="tdrow1"><strong>Mô tả thêm</strong></td>
	  	<td class="tdrow1"><textarea cols="47" rows="4" name="nwc_comment"><?=$nwc_comment?></textarea></td>
	</tr>
	<tr>
		<td class="tdrow1"><b>Hiển thị? </b></td>
		<td class="tdrow1">
			<label><input type="radio" name="isshown" value="1" <?=$radio_shown_1.' '.set_radio('isshown', '1')?> /> Có</label>
			<label><input type="radio" name="isshown" value="0" <?=$radio_shown_0.' '.set_radio('isshown', '0')?> /> Không</label>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="tdrow1"><input type="submit" name="submit_newcat" value="Hiệu chỉnh" id="button" /></td>
	</tr>
</table>
</form>