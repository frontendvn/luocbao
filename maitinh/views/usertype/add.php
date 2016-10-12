<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
//
	echo $this->session->flashdata('message');
	echo '<br clear="all" />';
	
	echo form_open($this->mod.'/add');
	$page = empty($page)?"":(int)$page;
	echo form_hidden('page', $page);
	
	$vl_name = isset($_POST['name'])?$this->input->post('name'):'';
	$vl_access_level = isset($_POST['access_level'])?$this->input->post('access_level'):'';
	$vl_description = isset($_POST['description'])?$this->input->post('description'):'';
?>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" class="maintitle">Thêm loại thành viên </td>
		</tr>
		<tr>
			<td class="tdrow1">Tên loại </td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'name','size'=>'40','id'=>'name'), set_value('name', $vl_name)); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Cấp bậc </td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'access_level','size'=>'10','id'=>'access_level'), set_value('access_level', $vl_access_level)); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Mô tả</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'description','size'=>'40','id'=>'description'), set_value('description', $vl_description));?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>