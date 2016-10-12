<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	echo form_open('cfsite/edit');
?>
<table cellspacing="0" cellpadding="4" class="tableborder" width="500">
	<?php echo '<tr><td colspan="2">'.$this->session->flashdata('message').'</td></tr>';?>
	<tr>
		<td class="maintitle" colspan="2">T&#7855;t / M&#7903; website</td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2"><label>Cho ph&eacute;p th&#7875; hi&#7879;n&nbsp;<?php echo form_checkbox(array('name'=>'power','value'=>'1','checked'=>$info))?></label></td>
	</tr>
	<tr>
		<td class="tdrow1">Th&ocirc;ng b&aacute;o</td><td class="tdrow1"><textarea name="txt_msg" cols="50" rows="5"><?=$txt_msg?></textarea></td>
	</tr>
	
</table>
<br/>
<table cellspacing="0" cellpadding="4" class="tableborder" width="500">
	<tr>
		<td class="maintitle" colspan="2">Th&ocirc;ng tin ch&acirc;n trang</td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2"><textarea name="footer" cols="58" rows="5"><?=$footer;?></textarea></td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2"><?php echo form_submit('btn_submit', 'Luu l?i'); ?></td>
	</tr>
</table>
<?php echo form_close();?>