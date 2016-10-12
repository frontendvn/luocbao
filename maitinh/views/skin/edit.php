<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
	$msg = empty($mesage)?"&nbsp;":$mesage;
?>

<form method="post" action="<?=site_url($this->mod.'/edit/'.$id);?>">
<div class="postbox close">
	<div class="inside">
			<table class="tableborder" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class="maintitle"><strong>Hiệu chỉnh block skin </strong></td>
			<td align="right" class="maintitle"><?=anchor($this->mod.'/add','Thêm mới skin')?></td>
		</tr>

		<tr>
			<td align="left" valign="top" class="tdrow1">Tiêu đề</td>
			<td align="left" valign="top" class="tdrow1"><input  name="title" value="<?=$title?>" size="30"/></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Open tag</td>
			<td align="left" valign="top" class="tdrow1"><textarea cols="69" rows="10" name="open"><?=$open?></textarea></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Close tag</td>
			<td align="left" valign="top" class="tdrow1"><textarea cols="69" rows="10" name="close"><?=$close?></textarea></td>
		</tr>
		<tr class="tdrow1">
			<td align="right"></td>
			<td align="left"><input type="hidden" name="id" value="<?=$id?>"/><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

