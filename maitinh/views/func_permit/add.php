<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	$att = array('id'=>'frmsort');
	echo form_open($this->mod.'/add', $att);
	$page = empty($page)?"":(int)$page;
	echo form_hidden('page', $page);
	
	$vl_func_name = isset($_POST['func_name'])?$this->input->post('func_name'):'';
	$vl_note = isset($_POST['note'])?$this->input->post('note'):'';?>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" class="maintitle">Thêm chức năng vào modules</td>
		</tr>
		<tr>
			<td class="tdrow1">Tên module</td>
			<td class="tdrow1"><?php echo $id_class.form_error('id_class');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Quyền tối thiểu</td>
			<td class="tdrow1"><?php echo $groups.form_error('required_access');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên chức năng</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'func_name','size'=>'40','id'=>'func_name'), set_value('func_name', $vl_func_name)).form_error('func_name');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mô tả thêm</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'note','size'=>'40','id'=>'note'), set_value('note', $vl_note)).form_error('note');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	<?php echo form_close();?>
	<br />
	<div class="clear"><?php echo $this->load->view($this->view_dir."list");?></div>