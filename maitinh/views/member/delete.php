<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	echo form_open($this->mod.'/del');
	echo form_hidden('user_id', $uri);
?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr><td colspan="2" class="maintitle">Xóa thành viên "S<?=$uri?>"</td></tr>
		<tr><td colspan="2" class="tdrow1"><div id="flashMessage"><?php echo $message.$this->session->flashdata('message');?></div></td></tr>
		<tr>
			<td class="tdrow1">Chọn thành viên đảm nhận</td>
			<td class="tdrow1"><?php echo $box_all_user.form_error('re_id');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
		</table>
<?php echo form_close(); ?>