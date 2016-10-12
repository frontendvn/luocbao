<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
	$delLog_img = "<img border=\"0\" title=\"\" src=\"".$img."icons/small/report1_(delete)_16x16.gif\" />";

?>
<div style="height:450px; width:620px; overflow:auto">
<table border="0" width="600" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" class="maintitle"><strong><?php echo $namecode?>'s </strong>Activities:<span style="float:right"><?php echo anchor($this->mod.'/empty_log/'.$uid, $delLog_img, array('title'=>'Xóa logs của thành viên này'))?></span></td>
	</tr>
	<tr align="center">
		<td class="tdrow3">Thời gian</td>
		<td class="tdrow3">Thao tác</td>
		<td class="tdrow3">Địa chỉ IP</td>
	</tr>
	<?php
if($num_rows)
{
	for($idx = 0; $idx < $num_rows; $idx++){
		$row = $db->row($idx); 
		$action = $row->action;
		$ip_address = $row->ip_address;
		$color = '#666666';
		$font = 'font-weight:normal';
		if(strpos($action, '/add') or strpos($action, '/create')) $color = '#00CC66';

		if(strpos($action, '/edit')) $color = '#FF9900';

		if(strpos($action, '/del') or strpos($action, '/dels') or strpos($action, '/delete')) $color = '#FF0000';

		if(strpos($action, '/login') or strpos($action, '/logout'))
		{
			$color = '#800080';
			$font = 'font-weight:bold';
		}

		$times = date('(H:i:s) d-m-y', $row->times);
		
		$i = (is_int($idx/2))?1:2;

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\" style=\"color:$color;$font\">$times</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" style=\"color:$color;$font\">$action</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\" style=\"color:$color;$font\">$ip_address</td>\n";
		echo "	</tr>\n";
	}
}
else
{
	echo "<tr><td colspan=\"3\" class=\"tdrow1\" align=\"center\">Chưa có dữ liệu!</td></tr>";
}
?>
</table>
</div>