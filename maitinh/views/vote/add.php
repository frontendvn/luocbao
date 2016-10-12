<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
	
	echo form_open($this->mod.'/add');
?>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3" class="tableborder">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>THÊM CÂU HỎI THĂM DÒ</strong></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Câu hỏi </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="title"><?=$this->input->post('title');?></textarea>
				<div class="txt_error"><?=form_error('title')?></div></td>
		</tr>
		
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Mô tả thêm</strong></td>
			<td class="tdrow1">
				<textarea cols="69" rows="2" name="comment"><?=$this->input->post('comment');?></textarea>
				<div class="txt_error"><?=form_error('comment')?></div></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Loại câu hỏi </strong><font color="#FF0000">*</font></td>
			<td class="tdrow1"><?=form_dropdown('types', $op_type, $this->input->post('types'));?>
				<div class="txt_error"><?=form_error('types')?></div></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1"><strong>Trạng thái</strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><?=form_dropdown('show', $this->config->item('show'),$this->input->post('show'));?>
				<div class="txt_error"><?=form_error('show')?></div></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="tdrow1"><input type="submit" name="btn_submit" value="Nhập đáp án" id="button" /></td>
		</tr>
</table>
<?=form_close();?>