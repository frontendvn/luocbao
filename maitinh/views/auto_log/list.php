<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
	$delLog_img = "<img style=\"vertical-align:middle\" border=\"0\" title=\"\" src=\"".$img."icons/small/report1_(delete)_16x16.gif\" />";

?>
<table border="0" width="980" cellpadding="0" cellspacing="0" align="center" style="max-width:980px">
	<tr class="maintitle">
		<td colspan="5" style="padding-left:5px"><span style="float:left">Kết quả lấy tin</span> <span style="float:left"><?=form_open($this->mod.'/lists').form_dropdown('status', $this->config->item('status'), $this->input->post('status'), 'onchange="this.form.submit()"').' Thời điểm '.form_dropdown('time_ago', $this->config->item('time_ago'), $time_ago, 'onchange="this.form.submit()"').form_close();?></span> <?php echo anchor($this->mod.'/empty_log/'.$this->input->post('status').'/'.$from.'/'.$to, $delLog_img, array('title'=>'Xóa auto log.', 'onclick' =>'return verify_del()'))." Tổng cộng $num_rows records."?> </td>
	</tr>
	<tr align="center">
		<td class="tdrow3">Id</td>
		<td class="tdrow3">Thời gian</td>
		<td class="tdrow3">Website lấy</td>
		<td class="tdrow3">Tin tìm thấy</td>
		<td class="tdrow3">Kết quả</td>
	</tr>
	<tbody style="height:510px;overflow:auto">
	<?php
if($num_rows)
{
	for($idx = 0; $idx < $num_rows; $idx++)
	{
		$row = $db->row($idx); 
		$times = $row->times;
		$website = $row->website;
		$links = $row->links;
		$status = $row->status;
		$notes = $row->notes;
		$news_title = stripslashes($row->news_title);
		$id_news = $row->id_news;
		$id_nwc = $row->id_nwc;
		$id_crawler = $row->id_crawler;
		$id = $row->id;
		
		$str_website = '<a href="'.$website.'" target="_blank">'.$website.'</a>';
		$str_times = date('(H:i:s) d-m-y', $times);
		
		$font = 'font-weight:normal';
		switch($status)
		{
			case 'Success':
				$str_title = anchor('news/edit/'.$id_nwc.'/'.$id_news, $news_title, array('title'=>'Xem tin này.', 'target'=>'_blank'));
				$color = '#00CC66';
			break;
			case 'False':
				$str_title = '<span title="'.$links.'">'.$status.'</span> ['.anchor('crawler/edit/'.$id_nwc.'/'.$id_crawler, 'Crawler', array('title'=>'Xem lại crawler này.', 'target'=>'_blank')).']';
				$color = '#FF0000';
			break;
			case 'No_news':
				$str_title = $status;
				$color = '#800080';
			break;
			case 'Low':
				$str_title = '<span title="'.$links.'">'.$status.'</span> ['.anchor('crawler/edit/'.$id_nwc.'/'.$id_crawler, 'Crawler', array('title'=>'Xem lại crawler này.', 'target'=>'_blank')).']';
				$color = '#FF9900';
			break;
			default:
				$str_title = anchor('news/edit/'.$id_nwc.'/'.$id_news, $news_title, array('title'=>'Xem tin này.', 'target'=>'_blank'));
				$color = '#666666';
		}
		
		$i = (is_int($idx/2))?1:2;

		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\" style=\"color:$color;$font\">$id</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\" style=\"color:$color;$font\">$str_times</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" style=\"color:$color;$font\">$str_website</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" style=\"color:$color;$font\">$str_title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"left\" style=\"color:$color;$font\">$notes</td>\n";
		echo "	</tr>\n";
	}
}
else
{
	echo "<tr><td colspan=\"5\" class=\"tdrow1\" align=\"center\">Chưa có dữ liệu!</td></tr>";
}
?>
	</tbody>
</table>
<script type="text/javascript">
function verify_del()
{
	return window.confirm("Bạn có muốn xóa không?\nVui lòng xác nhận.");
}
</script>