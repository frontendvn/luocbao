<?php echo form_open($this->mod.'/add');?>
<table border="0" width="500" cellpadding="5" cellspacing="0"  class="tableborder" align="center">
	<tr>
		<td colspan="2" class="maintitle">Thêm chủ đề </td>
	</tr>
	<tr>
		<td width="40%" class="tdrow1"><strong>Tiêu đề </strong> <font color="#FF0000">*</font></td>
	  	<td class="tdrow1"><input type="text" size="50" name="title" value="<?=$this->input->post('title')?>" /></td>
	</tr>
	<tr>
		<td width="40%" class="tdrow1"><strong>Mã trên link </strong> <font color="#FF0000">*</font></td>
	  	<td class="tdrow1"><input type="text" size="50" name="id_cattext" value="<?=$this->input->post('id_cattext')?>" /></td>
	</tr>
	<tr>
		<td class="tdrow1"><strong>Thuộc chủ đề </strong></td>
	  	<td class="tdrow1"><?=$the_select_box?></td>
	</tr>
	<tr>
		<td class="tdrow1"><strong>Mô tả thêm </strong></td>
	  	<td class="tdrow1"><textarea cols="47" rows="4" name="comment"><?=$this->input->post('comment')?></textarea></td>
	</tr>
	<tr>
		<td class="tdrow1"><b>Hiển thị? </b></td>
		<td class="tdrow1">
		<label><input type="radio" name="isshown" value="1" checked="checked" <?=set_radio('isshown', '1')?> /> Có</label>
		<label><input type="radio" name="isshown" value="0" <?=set_radio('isshown', '0')?> /> Không</label></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="tdrow1"><input type="submit" name="submit_newcat" value="Thêm mới" id="button" /></td>
	</tr>
</table>
</form>