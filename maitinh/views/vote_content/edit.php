<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	echo form_open($this->mod.'/edit');
	$page = empty($page)?"":(int)$page;
?>
	<input type="hidden" name="page" value="<?=$page;?>" />
	<input type="hidden" name="id" value="<?=$id;?>" />
	<input type="hidden" name="qid" value="<?=$qid;?>" />
	<input type="hidden" name="inner" id="inner" value="" />
	<table  width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>SỬA PHƯƠNG ÁN</strong></td>
		</tr>
		<tr><td colspan="2" class="tdrow1shaded">Cho câu: <i>(<?=word_limiter($qtitle,15)?>)</i></td></tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung </strong> <font color="#FF0000">*</font></td>
			<td class="tdrow1"><textarea cols="69" rows="2" name="content"><?=$content;?></textarea>
				<div class="txt_error"><?=form_error('content')?></div></td>
		</tr>
		
		<tr>
			<td colspan="2" align="center" class="tdrow1">
			<input type="submit" name="btn_submit" value="Hiệu chỉnh" id="button" /></td>
		</tr>
	</table></form><br />
<?php 
	$this->load->view($this->view_dir."list");
?>