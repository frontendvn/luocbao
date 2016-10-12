<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>	 

<form method="post" action="<?=site_url($this->mod.'/add');?>">
<div class="postbox close">
	<div class="inside">
		<table class="tableborder"  cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" class="maintitle"><strong>Thêm khách hàng</strong></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên khách hàng <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="ten_kh" value="<?=$this->input->post('ten_kh')?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Địa chỉ</td>
			<td class="tdrow1"><input type="text" name="diachi" value="<?=$this->input->post('diachi')?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Điện thoại</td>
			<td class="tdrow1"><input type="text" name="dienthoai" value="<?=$this->input->post('dienthoai')?>" size="15" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Email</td>
			<td class="tdrow1"><input type="text" name="email" value="<?=$this->input->post('email')?>" size="50" /></td>
		</tr>
		<tr class="tdrow1">
			<td align="right">&nbsp;</td>
			<td ><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

