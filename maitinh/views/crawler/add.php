<?=form_open($this->mod.'/add')?>
	<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>THÊM CRAWLER</strong></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="20%"><strong>Thuộc chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><?php echo $select_box_cat.' '.anchor($this->mod.'/lists/'.$cid, "&raquo; Danh sách crawler");?></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="20%"><strong>Mẫu</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><?php echo $select_box_pattern;?></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Link chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="links" size="50" value="<?=$this->input->post('links')?>" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Thêm mới" id="button" /></td>
		</tr>
	</table>
</form>