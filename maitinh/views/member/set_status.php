<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
	
	echo $this->session->flashdata('message');
	echo validation_errors();
	echo '<br clear="all" />';
	//
	$attributes = array('onsubmit' => 'return checkEditForm(this);');
	echo form_open($this->mod.'/set_status', $attributes);
	echo form_hidden('id', $id);
	
	$vl_fullname = empty($load['fullname'])?$this->input->post('fullname'):$load['fullname'];
	$vl_username = empty($load['username'])?$this->input->post('username'):$load['username'];
	$vl_activated = empty($load['activated'])?$this->input->post('activated'):$load['activated'];
	$activated = $vl_activated=='y'?true:false;
	
	echo form_hidden('fullname', $vl_fullname);
	echo form_hidden('username', $vl_username);
?>
	<fieldset id="fldsetabout">
		<legend><strong><?='Thành viên: '.$vl_username.' - '.$vl_fullname?></strong></legend>
		<div id="optBirthdayFld" class="regfrminput">
			<div class="registerformlabel">
				<label class="reglabel" for="activated">kích hoạt tài khoản</label>
			</div>
			<div class="registerformfield"><?=form_checkbox('activated', 'y', $activated, 'id="activated"')?></div>
		</div>
	</fieldset>
	<div class="regfrminput">
		<div class="registerformlabel">&nbsp;</div>
		<div class="registerformbtn"><?php echo form_submit('submit', 'Lưu lại'); ?></div>
	</div>
<?php echo form_close(); ?>
</div>