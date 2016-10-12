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
			<td align="left" class="maintitle"><strong>Hiệu chỉnh block  </strong></td>
			<td align="right" class="maintitle"><?=anchor($this->mod.'/add','Thêm mới blocks')?></td>
		</tr>
		<tr>
					<td align="left" valign="top" class="tdrow1">Loại </td>
					<td align="left" valign="top" class="tdrow1">
					<?php echo  form_hidden('type', $type);?>
					<p id="noidung"><?php if(!empty($meta)) echo $meta;?></p></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Tiêu đề</td>
			<td align="left" valign="top" class="tdrow1"><input type="text" name="title" value="<?=$title?>" size="80"/></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Mô tả</td>
			<td align="left" valign="top" class="tdrow1"><textarea style="width:500px;height:80px" name="mota"><?=$mota?></textarea></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Skin </td>
			<td align="left" valign="top" class="tdrow1"><?php if(isset($selete_skin)) echo $selete_skin;?></td>
		</tr>
		
		<tr>
		<td  align="left" class="tdrow1" >Thể hiện theo chủ đề</td>
		<td align="left" valign="top"  class="tdrow1"><?php if(isset($selete_ngucanh)) echo $selete_ngucanh;?></td>
		</tr>
		<tr class="tdrow1">
			<td align="right"></td>
			<td align="left"><input type="hidden" name="id" value="<?=$id?>"/><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

