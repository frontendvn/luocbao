<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<form method="post" action="<?=site_url($this->mod.'/del')?>" onsubmit="return verify_del()">
<table border="0" width="420" cellpadding="0" cellspacing="0">
	<tr class="maintitle">
		<td colspan="2" style="padding-left:5px">XÓA DỮ LIỆU</td>
	</tr>
	<tr>
		<td class="tdrow1" width="100" align="right">Tháng</td>
		<td class="tdrow1"><?=form_dropdown('month', $cfmonths, $month)?></td>
	</tr>
	<tr>
		<td class="tdrow1" align="right">Năm</td>
		<td class="tdrow1"><?=form_dropdown('year', $aryears, $year)?></td>
	</tr>
	<tr>
		<td class="tdrow1" colspan="2"><input type="submit" name="btn_submit" value="Xóa" /> <em style="color:#FF9933">(Cảnh báo: Một khi dữ liệu đã bị xóa thì không thể khôi phục lại.)</em></td>
	</tr>
</table>
</form>
<script type="text/javascript">
function verify_del()
{
	return window.confirm("Cảnh báo: Một khi dữ liệu đã bị xóa thì không thể khôi phục lại.\nBạn có thực sự muốn xóa không?\nVui lòng xác nhận.");
}
</script>