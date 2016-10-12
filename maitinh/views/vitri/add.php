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
			<td colspan="2" class="maintitle"><strong>Tạo vị trí Mới </strong></td>
		</tr>
		<tr>
			<td class="tdrow1" ><span style="color:#FF0000">*</span>Tên vị trí</td>
			<td class="tdrow1"><input type="text" name="ten_vt" value="<?=$this->input->post('ten_vt')?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1" ><span style="color:#FF0000">*</span>Kích thước</td>
			<td class="tdrow1">
				<input type="text" name="ngang" value="<?=$this->input->post('ngang')?>" size="4" /> x 
				<input type="text" name="doc" value="<?=$this->input->post('doc')?>" size="4" />
			</td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><strong>Lưu ý: tên vị trí quảng cáo và kích thước phải đặt giống 
			như bên ngoài phần thể hiện của website 
			<br />vd: vị trí thứ 1 mục Trang chủ: h1 - kích thước 735x80</strong></td></tr>
		<tr class="tdrow1">
			<td align="right">&nbsp;</td>
			<td ><input type="submit" name="save" value="Lưu lại" id="button" /></td>
		</tr>
	</table>
	</div>
</div>
</form>
<?php $this->load->view($this->view_dir.'list');?>
