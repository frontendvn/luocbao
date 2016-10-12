<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
	$msg = empty($mesage)?"&nbsp;":$mesage;
	$num = !$nums?1:$nums;
?>
<script language="javascript" type="text/javascript">
		$(document).ready(function(){
			var nums = <?=$num?>;
			$("#addpage").click(function(){
				nums++;
				$.ajax({
								 type: "POST",
								 url: '<?php echo site_url($this->mod.'/AJ_add_page');?>',
								 data: "nums=" + nums ,
								 success: function(msg){
										$("#appear").replaceWith(msg);
										$("#button").show('fast');
								 }
							 });
			});
		});
	</script>
<form method="post" action="<?=site_url('advertise/add');?>">
<div class="postbox close">
	<div class="inside">
			<table class="tableborder" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>HTML bổ sung </strong></td>
		</tr>
		<?php if($num){
			for($i=0; $i<$nums; $i++){
				if($rs)
				{
					$row = $rs->row($i);
					$adv_id = $row->adv_id;
					$adv_code = $row->adv_code;
					$adv_content = $row->adv_content;
		?>
		<tr>
			<td align="left" valign="top" class="tdrow1"><label><input  name="adv_code[]" value="<?=$adv_code?>" size="30"/><input type="hidden" name="adv_id[]" value="<?=$adv_id?>" size="20"/></label>
				<br /><span><?php echo anchor($this->mod.'/edit/'.$adv_id,'Hiệu chỉnh');echo '&nbsp;|&nbsp;'.anchor($this->mod.'/dels/'.$adv_id,'Xoá');?></span></td>
			<td align="left" valign="top" class="tdrow1"><textarea cols="69" rows="15" name="adv_content[]"><?=$adv_content?></textarea></td>
		</tr>
		<?php	
				}else{
		?>
		<tr>
			<td align="left" valign="top" class="tdrow1">
				<label><input  name="adv_code[]" value="" size="30"/></label></td>
			<td align="left" valign="top" class="tdrow1">
				<textarea cols="69" rows="10" name="adv_content[]"></textarea></td>
		</tr>
		<?php	
				}
			}
		}?>
		
		<tr id="appear"><td></td><td></td></tr>
		<tr class="tdrow1">
			<td align="right"><input type="button" name="next" value="Thêm mới" id="addpage" /></td>
			<td align="center"><?php if($rs) $display='style="display:none"';else $display='';?><input type="submit" name="save" value="Lưu lại" id="button" <?=$display;?> /></td>
		</tr>
	</table>
	</div>
</div>
</form>

