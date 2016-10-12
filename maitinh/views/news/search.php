<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$url 	= base_url();
$css	= $url.$this->config->item('css_dir'); 
$js		= $url.$this->config->item('js_dir'); 
$img 	= $url.$this->config->item('img_dir'); 

echo $this->session->flashdata('message');
echo '<br clear="all" />';

echo form_open($this->mod.'/search');
$total_item = empty($total_item)?0:$total_item;
$pagi=empty($pagi)?'':'Trong '.$pagi;
$page=empty($page)?0:$page;
?>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="5" class="maintitle">Từ khóa hoặc cụm từ cần tìm  <input type="text" name="keyword" value="<?php echo $keyword;?>" /> Tìm trong chuyên mục <?php echo $the_select_box?> <input type="submit" name="btn_search" value="Tìm kiếm" /></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td colspan="5" class="maintitle">Kết quả</td>
	</tr>
	<tr>
		<td colspan="5" class="tdrow3">Hiện có <span style="font-size:13px; color:#666666;"><?=$total_item?></span> <?=$pagi?></td>
	</tr>
	<tr>
		<td class="tdrow3" width="30" align="center">Mã</td>
		<td class="tdrow3" align="center">Bản tin</td>
		<td class="tdrow3" width="120" align="center">Chức năng</td>
	</tr>
<?php
if(!empty($total_item))
{
	$ard = array("'",'"',"\n");
	$art = array("\'",'\"',"");
	for($idx = $first_item; $idx < $last_item; $idx++)
	{
		$row = $db->row($idx); 
		$id = $row->id_news;
		$id_nwc = $row->id_nwc;	
		$id_text = $row->id_text;	
		$id_cattext = $row->id_cattext;	
		$news_lead = $row->news_lead;	
		$news_useful = $row->news_useful;	
		$title = stripcslashes($row->news_title);
		$quickview = stripcslashes($row->news_quickview);
		//
		$view_title = '<a href="'.SITE.'/news/preview/'.$id_cattext.'/'.stripslashes($id_text).'" target="_blank" title="">'.$title.'</a>';
		$edit = '['.anchor($this->mod.'/edit/'.$id_nwc.'/'.$id.'/'.$page, 'Sửa', array('title' => "Hiệu chỉnh bản tin này.")).']';
		$view = '<a href="'.SITE.'/news/preview/'.$id_cattext.'/'.stripslashes($id_text).'" target="_blank" title="">Xem</a>';
		$lead = $news_lead!='1' ? '[<a style="cursor:pointer" onclick="return add_lead('.$id.')" title="">Thêm vào nổi bật</a>]' : 'Tin nổi bật';
		$useful = $news_useful!='1' ? '[<a style="cursor:pointer" onclick="return add_useful('.$id.')" title="">Thêm vào tin hay</a>]' : 'Tin hay';
		
		$i = is_int($idx/2)? 1 : 2;
		
		echo "	<tr>\n";
		echo "		<td class=\"tdrow$i\" align=\"right\">$id</td>\n";
		echo "		<td class=\"tdrow$i\">$view_title<br />$quickview [$edit] [$view]</td>\n";
		echo "		<td class=\"tdrow$i\" align=\"center\"><span id='lead$id'>$lead</span><br /><span id='useful$id'>$useful</span></td>\n";
		echo "	</tr>\n";
	}
}
?>
</table>

<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tdrow3">
			Hiện có <span style="font-size:13px; color:#666666;"><?php echo $total_item;?></span> <?php echo $pagi;?>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
var img = '<img src="<?=$img?>ajax_loading.gif" title="" />';
function add_lead(id)
{
	var url = '<?=site_url()?>';
	$('#lead'+id).html(img);
	$.get(url+'/news/add_lead/'+id, function(msg){
		$('#lead'+id).html(msg);
	});
}
function add_useful(id)
{
	var url = '<?=site_url()?>';
	$('#useful'+id).html(img);
	$.get(url+'/news/add_useful/'+id, function(msg){
		$('#useful'+id).html(msg);
	});
}
</script>