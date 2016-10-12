<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
	$msg = empty($mesage)?"&nbsp;":$mesage;
	
	$drop_type = $this->config->item('type');
?>
<script>
$(document).ready(function(){
		$("select#drop_type").change(function(){
			var x = $(this).val();
			if(x=='html') $('#id_chude').show('fast');
			else $('#id_chude').hide('fast');
			 $.post('<?=site_url().'/'.$this->mod.'/option'?>',{'loai':x}, function(mess){
				$('#noidung').html(mess);
			})
		});
});
</script>
<form method="post" action="<?=site_url($this->mod.'/add');?>">
<div class="postbox close">
	<div class="inside">
		<table class="tableborder" width="100%"  cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>Tạo block mới </strong></td>
		</tr>
		<tr>
					<td align="left" valign="top" class="tdrow1">Loại </td>
					<td align="left" valign="top" class="tdrow1"><?php
					$js = 'id = "drop_type" ';
					echo  form_dropdown('type',$drop_type,'',$js);?><p id="noidung"></p></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Tiêu đề</td>
			<td align="left" valign="top" class="tdrow1"><input type="text" name="title" value="" size="80"/></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Mô tả</td>
			<td align="left" valign="top" class="tdrow1"><textarea style="width:500px;height:80px" name="mota"></textarea></td>
		</tr>
		<tr>
			<td align="left" valign="top" class="tdrow1">Skin </td>
			<td align="left" valign="top" class="tdrow1"><?php if(isset($selete_skin)) echo $selete_skin;?></td>
		</tr>
		<tr ><td colspan="2"><div id="id_chude" style="display:none" >Thể hiện theo chủ đề<?php if(isset($selete_ngucanh)) echo $selete_ngucanh;?></div>
			
		
		</td>
		</tr>
		
		<tr class="tdrow1">
			<td align="right"></td>
			<td align="left"><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

