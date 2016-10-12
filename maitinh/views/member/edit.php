<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	$time_options = $this->config->item('hours');
	$attributes = array('onsubmit' => 'return checkEditForm(this);');
	echo form_open($this->mod.'/edit', $attributes);
	echo form_hidden('id', $id);
	
	$vl_fullname = empty($load['fullname'])?$this->input->post('fullname'):$load['fullname'];
	$vl_username = empty($load['username'])?$this->input->post('username'):$load['username'];
	$vl_password = empty($load['password'])?$this->input->post('password'):'password';
	$vl_email = empty($load['email'])?$this->input->post('email'):$load['email'];
	$vl_description = empty($load['description'])?$this->input->post('description'):$load['description'];
	$vl_code = empty($load['code'])?$this->input->post('code'):$load['code'];
	$vl_type_id = empty($load['type_id'])?$this->input->post('type_id'):$load['type_id'];
	$vl_time_start = empty($load['time_start'])?$this->input->post('time_start'):$load['time_start'];
	$vl_time_finish = empty($load['time_finish'])?$this->input->post('time_finish'):$load['time_finish'];
?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr>
			<td colspan="2" class="maintitle">Hiệu chỉnh thông tin thành viên</td>
		</tr>
		<tr><td colspan="2" class="tdrow1"><div id="flashMessage"><?php 	echo $message.$this->session->flashdata('message');?></div></td></tr>
		<tr>
			<td class="tdrow1">Họ tên</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'fullname','size'=>'40','id'=>'fullname','maxlength'=>'40'), set_value('fullname', $vl_fullname)).form_error('fullname'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Loại thành viên</td>
			<td class="tdrow1"><?php echo $option_type.form_error('type_id');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên đăng nhập</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'username','size'=>'30','id'=>'username'), set_value('username', $vl_username)).form_error('username');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mật khẩu</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'password','size'=>'30','id'=>'password'), set_value('password', $vl_password)).form_error('password');?> (<em>Fill in it if you want change password.</em>)</td>
		</tr>
		<tr>
			<td class="tdrow1">Email</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'email','id'=>'email','size'=>'30'), set_value('email', $vl_email)).form_error('email');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Code</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'code','id'=>'code','size'=>'30', 'readonly'=>'readonly'), set_value('code', $vl_code)).form_error('code');?></td>
		</tr>
		<tr>
			<td class="tdrow1" align="right" valign="top">Thời gian đăng nhập </td>
			<td class="tdrow1">Từ <?=form_dropdown('time_start', $time_options, $vl_time_start).form_error('time_start')?> đến <?=form_dropdown('time_finish', $time_options, $vl_time_finish).form_error('time_finish')?></td>
		</tr>
		<tr>
			<td class="tdrow1">Thông tin khác</td>
			<td class="tdrow1"><?php echo form_textarea(array('name'=>'description','id'=>'description','style'=>'width:430px;height:100px;'), set_value('description', $vl_description)).form_error('description');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
<?php echo form_close(); ?>