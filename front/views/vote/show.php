<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="SSB - vote result">
<title>SSB - Ket qua Bieu quyet</title>
</head>
<body topmargin="2" leftmargin="5" marginheight="5" marginwidth="5" style="background-color:#0C186D">
<?php if($db){?>
<table width="100%" cellspacing=0 cellpadding=0 border=0 id="AdVote" style="display:none;background-color:#0C186D;"><tr><td>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td class=Title><font color="#ffffff"><?=$db->row(0)->title_vo?></font></td></tr>

</table>
<table border=0 cellspacing=1 cellpadding=3 width="100%">
<?php
	$total = 0;$stt = 0;
	foreach($db->result() as $row)
		$total = $total+$row->result_vc;
	foreach($db->result() as $row)
	{
		$stt++;
		$content_vc = $row->content_vc;
		$result_vc = $row->result_vc;
		$str_re = $total?round(($result_vc/$total)*100,2):0;
		$image = $row->image_vc;
		$images = ($image && file_exists("../".$image))?'<img src="'.base_url()."../".$image.'" width=100 /><br />':'';
		switch($stt)
		{
			case 1: $color = "#FF3300";break;
			case 2: $color = "#004000";break;
			case 3: $color = "#004080";break;
			case 4: $color = "#FF0080";break;
			case 5: $color = "#008080";break;
			default: $color = "#993366";
		}
		$width = round($str_re);
		
?>
<tr height=22>
<td  bgcolor="#ffffff"><?=$images.$content_vc?></td>
<td  bgcolor="#ffffff"><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width="<?=$width?>" bgcolor="<?=$color?>">&nbsp;</td><td>&nbsp;<?=$str_re?>%</td></tr></table></td>
<td  bgcolor="#ffffff" align=right><?=$result_vc?>&nbsp;phiếu</td>
</tr>
<?php }?>
<tr height=25><td bgcolor="#ffffff" colspan=3 align=right>Tổng cộng: <?=$total?> phiếu</td></tr>
</table>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr>
<td height=20 valign=bottom></td>
<td height=20 valign=bottom align=right><a href="JavaScript:window.close()" class=Time><font color="#ffffff">[Đóng lại]</font></a></td>
</tr>
</table>

</td></tr></table>

	<script language="javascript">
		document.getElementById('AdVote').style.display = "";
	</script>
<?php }else echo 'Dữ liệu chưa đúng';?>

</body>
</html>