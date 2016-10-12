<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	$attributes = array('onsubmit' => 'return checkEditForm(this);');
	echo form_open($this->mod.'/assign/'.$id, $attributes);
	echo form_hidden('id', $id);
	echo form_hidden('type_id', $type_id);
	
	$vl_fullname = empty($load['fullname'])?$this->input->post('fullname'):$load['fullname'];
?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr><td colspan="2" class="maintitle">Phân nhóm thành viên</td></tr>
		<tr><td colspan="2" class="tdrow1"><div id="flashMessage"><?php 	echo $message.$this->session->flashdata('message');?></div></td></tr>
		<tr>
			<td class="tdrow1">Tên thành viên</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'fullname','size'=>'40','id'=>'fullname','readonly'=>'readonly'), set_value('fullname', $fullname)).form_error('fullname'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Thuộc nhóm</td>
			<td class="tdrow1"><?php echo $teamleader.form_error('teamleader');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Thực thi');?></td>
		</tr>
		</table>
<?php echo form_close(); ?>