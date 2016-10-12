<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

	$types = ($qtypes=="O")?"radio":"checkbox";
?>
	<script language="javascript" type="text/javascript">
		$(document).ready(function(){
			var nums = 5;
			$("#addpage").click(function(){
				nums++;
				$.ajax({
								 type: "POST",
								 url: '<?php echo site_url($this->mod.'/AJ_add_page');?>',
								 data: "nums=" + nums + "&types=<?=$types;?>",
								 success: function(msg){
										$("#appear").replaceWith(msg);
								 }
							 });
			});
		});
	</script>
<?php
	echo form_open($this->mod.'/add');
	/* default or get value*/
	$page = empty($page)?"":(int)$page;
?>
	<input type="hidden" name="page" value="<?php echo $page;?>" />
	<input type="hidden" name="qid" value="<?php echo $qid;?>" />
	<input type="hidden" name="inner" id="inner" value="" />
	<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F3F3F3">
		<tr>
			<td colspan="2" align="center" class="maintitle"><strong>THÊM PHƯƠNG ÁN</strong></td>
		</tr>
		<tr><td colspan="2" class="tdrow1shaded">Cho câu: <i><?php echo word_limiter($qtitle,12)?></i></td></tr>
		<tr>
			<td align="right" class="tdrow1" valign="top" width="150"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr>
			<td align="right" class="tdrow1" valign="top"><strong>Nội dung <font color="#FF0000">*</font></strong></td>
			<td class="tdrow1"><textarea cols="69" rows="1" name="content[]"></textarea></td>
		</tr>
		<tr id="appear"><td></td><td></td></tr>
		<tr class="tdrow1">
			<td align="right"><input type="button" name="next" value="Thêm" id="addpage" /></td>
			<td align="center"><input type="submit" name="save" value="Lưu lại" id="button" /></td>
		</tr>
	</table></form><br />
<?php $this->load->view($this->view_dir."list");?>