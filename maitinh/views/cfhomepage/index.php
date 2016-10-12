<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript">
var url = '<?=site_url($this->mod.'/process')?>';
$(function(){
	process();
});
function process()
{
	$('#loading').html('<img src="<?=$img?>ajax_loading.gif" />').show('fast');
	$.get(url, function (msg) {
		if(!isNaN(msg))
		{
			if(msg!='' && msg<10)
			{
				$('#process').html((msg/10)*100+'%.').show('fast', function(){
					process();
				});
			}
			else
			{
				$('#process').html((msg/10)*100+'%.').show('fast');
				$('#loading').html('completed').show('fast');
			}
		}
	});
}
	
</script>
<div>
<?php 
	echo $this->session->flashdata('message');
	echo '<br clear="all" />';
	//echo validation_errors();
?>
<table cellspacing="0" cellpadding="4" class="tableborder" width="500">
	<tr>
		<td class="maintitle" colspan="2">GHI CACHE TRANG CHỦ</td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2">Thực thi cache dữ liệu</td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2"><span id="loading"><input type="button" name="start" value="Start" onclick="process();" /></span> <span id="process"></span></td>
	</tr>
</table>
</div>