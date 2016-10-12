<?=form_open($this->mod.'/edit')?>
<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table  width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>HIỆU CHỈNH CRAWLER</strong></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="20%"><strong>Thuộc chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><?php echo $select_box_cat.' '.anchor($this->mod.'/lists/'.$id_nwc, "&raquo; Danh sách crawler");?></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="20%"><strong>Mẫu</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><?php echo $select_box_pattern.' '.anchor('pattern/edit/'.$id_pattern, "&raquo; Xem lại pattern này");?></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Link chủ đề</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><input type="text" name="links" size="50" value="<?=$links?>" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Hiệu chỉnh" id="button" /></td>
		</tr>
	</table>
</form>