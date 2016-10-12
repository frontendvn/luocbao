<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
//
	echo $this->session->flashdata('message');
	echo '<br clear="all" />';

	echo form_open($this->mod.'/edit');
	$page = empty($page)?"":(int)$page;
	echo form_hidden('id', $id);
	echo form_hidden('page', $page);
	
	$vl_name = empty($load['name'])?$this->input->post('name'):$load['name'];
	$vl_description = empty($load['description'])?$this->input->post('description'):$load['description'];
?>
	<table border="0" width="80%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" class="maintitle">Hiệu chỉnh loại thành viên</td>
		</tr>
		<tr>
			<td class="tdrow1">Tên loại </td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'name','size'=>'40','id'=>'name'), set_value('name', $vl_name)); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mô tả </td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'description','size'=>'40','id'=>'description'), set_value('description', $vl_description));?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>