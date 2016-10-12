<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
//
	
	echo form_open($this->mod.'/add');
	$page = empty($page)?"":(int)$page;
	echo form_hidden('page', $page);
	
	$vl_class_name = isset($_POST['class_name'])?$this->input->post('class_name'):'';
	$vl_note = isset($_POST['note'])?$this->input->post('note'):'';
?>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" class="maintitle">Thêm module cần quản lý</td>
		</tr>
		<tr>
			<td class="tdrow1">Tên module</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'class_name','size'=>'40','id'=>'class_name'), set_value('class_name', $vl_class_name)).form_error('class_name'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Quyền tối thiểu</td>
			<td class="tdrow1"><?php echo $groups.form_error('required_access');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mô tả Module</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'note','size'=>'40','id'=>'note'), set_value('note', $vl_note)).form_error('note');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
	<br />
	<?php echo $this->load->view($this->view_dir."list");?>