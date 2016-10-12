<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript" src="<?=$js?>member/check_regform.js"></script>
<style type="text/css">
.registerform {
	padding:10px 20px;
}
.reg_row {
	clear:both;
	font-size:100%;
	margin-bottom:5px;
	padding-top:10px;
	position:inherit;
}
.registerformlabel{
	color:#505050;
	float:left;
	padding:5px 5px 0 0;
	text-align:right;
	width:20%;
}
</style>
<?php
	$time_options = $this->config->item('hours');
	$attributes = array('onsubmit' => 'return checkForm(this);');//
	echo form_open($this->mod.'/create', $attributes);//
	$vl_time_start = isset($_POST['time_start'])? $this->input->post('time_start'): 8;
	$vl_time_finish = isset($_POST['time_finish'])? $this->input->post('time_finish'): 17;
	
?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr>
			<td colspan="2" class="maintitle">Thêm thành viên mới</td>
		</tr>
		<tr><td colspan="2" class="tdrow1"><div id="flashMessage"><?php echo $message.$this->session->flashdata('message');?></div></td></tr>
		<tr>
			<td class="tdrow1">Loại thành viên</td>
			<td class="tdrow1"><?=$option_type?></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên đăng nhập</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'username','size'=>'40','id'=>'username'), set_value('username', $this->input->post('username'))).form_error('username'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mật khẩu</td>
			<td class="tdrow1"><?php echo form_password(array('name'=>'password','size'=>'40','id'=>'password'), set_value('password', $this->input->post('password'))).form_error('password');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Họ tên</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'fullname','size'=>'40','id'=>'fullname'), set_value('fullname', $this->input->post('fullname'))).form_error('fullname');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Email</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'email','size'=>'40','id'=>'email'), set_value('email', $this->input->post('email'))).form_error('email');?></td>
		</tr>
		<tr>
			<td class="tdrow1" align="right" valign="top">Thời gian đăng nhập </td>
			<td class="tdrow1">Từ <?=form_dropdown('time_start', $time_options, $vl_time_start).form_error('time_start')?> đến <?=form_dropdown('time_finish', $time_options, $vl_time_finish).form_error('time_finish')?></td>
		</tr>
		<tr>
			<td class="tdrow1">Thông tin thêm</td>
			<td class="tdrow1"><?php echo form_textarea(array('name'=>'description','cols'=>'40','id'=>'description','rows'=>'5'), set_value('description', $this->input->post('description'))).form_error('description');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
		</table>
<?php echo form_close(''); ?>