<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

echo $this->session->flashdata('message');
echo '<br clear="all" />';
?>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="7" class="maintitle">Danh sách bản tin nổi bật, tin đặc biệt</td>
	</tr>
	<tr>
		<td colspan="7" class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center">Stt</td>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Tiêu đề</td>
		<td class="tdrow3" align="center">Lượt xem</td>
		<td class="tdrow3" align="center">Ngày tạo</td>
		<td class="tdrow3" align="center">Thời gian</td>
		<td class="tdrow3" width="140" align="center">Chức năng</td>
	</tr>
<?php
if(!empty($db_special))
{
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");
	
	for($idx = 0; $idx < $total_item1; $idx++)
	{
		$row = $db_special->row($idx); 
		$id = $row->id_news;
		$id_nwc = $row->id_nwc;	
		$id_text = $row->id_text;	
		$id_cattext = $row->id_cattext;
		$title = str_replace($art , $ard, $row->news_title);
		$view_count = $row->news_viewcount;
		$create_date = date('H:i:s (d-m-Y)', $row->news_special_create_date);
		$specialtime = date('H:i:s (d-m-Y)', $row->news_specialtime);
		//
		$edit_title = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id, $title, array('title' => "Hiệu chỉnh bản tin này."));
		$view = '<a href="'.SITE.'/news/preview/'.$id_cattext.'/'.stripslashes($id_text).'" target="_blank" title="">Xem</a>';
		$edit = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id, 'Sửa', array('title' => "Hiệu chỉnh bản tin này."));
		$removed = anchor($this->mod.'/removed_special/'.$id, 'Xóa nhãn', array('title' => "Xóa nhãn đặc biệt cho bản tin này."));
		
		$i = is_int($idx/2)? 1 : 2;
		$stt = $idx+1;
		
		echo "	<tr style=\"font-weight:bold\">\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$stt</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$view_count</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$create_date</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$specialtime</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$view | $edit</td>\n";
		echo "	</tr>\n";
	}
}
?>
<?php
if(!empty($db))
{
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");

	for($idx = 0; $idx < $total_item2; $idx++)
	{
		$row = $db->row($idx); 
		$id = $row->id_news;
		$id_nwc = $row->id_nwc;	
		$id_text = $row->id_text;	
		$id_cattext = $row->id_cattext;
		$title = str_replace($art , $ard, $row->news_title);
		$view_count = $row->news_viewcount;
		$create_date = date('H:i:s (d-m-Y)', $row->news_lead_create_date);
		$specialtime = '';
		//
		$edit_title = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id, $title, array('title' => "Hiệu chỉnh bản tin này."));
		$view = '<a href="'.SITE.'/news/preview/'.$id_cattext.'/'.stripslashes($id_text).'" target="_blank" title="">Xem</a>';
		$edit = anchor($this->mod.'/edit/'.$id_nwc.'/'.$id, 'Sửa', array('title' => "Hiệu chỉnh bản tin này."));
		$removed = anchor($this->mod.'/removed_lead/'.$id, 'Xóa nhãn', array('title' => "Xóa nhãn nổi bậc cho bản tin này."));
		
		$i = is_int($idx/2)? 1 : 2;
		$stt = $idx+1;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$stt</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$edit_title</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$view_count</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$create_date</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$specialtime</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\">$view | $edit</td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>

<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tdrow3">
			Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span>
		</td>
	</tr>
</table>