<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<link type="text/css" href="<?=$js?>../front/member/css/style.css" rel="Stylesheet" />
<script type="text/javascript" src="<?=$js?>../front/member/js/check_changepassform.js"></script>
<?php
	$attributes = array('onsubmit' => 'return checkChangePassForm(this);');
 	echo form_open($this->mod.'/change_password', $attributes); ?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr>
			<td colspan="2" class="maintitle">Đổi mật khẩu</td>
		</tr>
		<tr><td colspan="2" class="tdrow1"><div id="flashMessage"><?php 	echo $message.$this->session->flashdata('message');?></div></td></tr>
		<tr>
			<td class="tdrow1">Mật khẩu cũ</td>
			<td class="tdrow1"><?php echo form_password(array('name'=>'oldpass','size'=>'40','id'=>'oldpass'), set_value('oldpass')).form_error('oldpass'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mật khẩu mới</td>
			<td class="tdrow1"><?php echo form_password(array('name'=>'newpass','size'=>'40','id'=>'newpass'), set_value('newpass')).form_error('newpass');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Xác nhận mật khẩu</td>
			<td class="tdrow1"><?php echo form_password(array('name'=>'newpass_repeat','size'=>'40','id'=>'newpass_repeat'), set_value('newpass_repeat')).form_error('newpass_repeat');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
		</table>
<?php echo form_close(); ?>