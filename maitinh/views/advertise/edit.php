<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
	$msg = empty($mesage)?"&nbsp;":$mesage;
	
	$vl_adv_code = empty($adv_code)?"":$adv_code;
	$vl_adv_content = empty($adv_content)?"":$adv_content;
?>

<form method="post" action="<?=site_url('advertise/edit');?>">
<div class="postbox close">
	<div class="inside">
			<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>Hiệu chỉnh HTML bổ sung </strong></td>
		</tr>
		<tr>
			<td class="tdrow1" valign="top"><p><strong>Mã</strong></p><label><input  name="adv_code" disabled="disabled" value="<?=$vl_adv_code?>" size="20"/><input type="hidden" name="adv_id" value="<?=$adv_id?>" size="20"/></label></td>
			<td class="tdrow1" valign="top"><p><strong>Nội dung</strong></p><textarea cols="69" rows="15" name="adv_content"><?=$vl_adv_content?></textarea>
			<span><?php echo anchor($this->mod.'/edit/'.$adv_id,'Hiệu chỉnh');echo '|&nbsp;&nbsp;'.anchor($this->mod.'/dels/'.$adv_id,'Xoá');?></span>
			</td>
		</tr>
		<tr class="tdrow1">
			
			<td align="center" colspan="2"><input type="submit" name="save" value="Lưu lại" id="button" /></td>
		</tr>
	</table>
	</div>
</div>
</form>

