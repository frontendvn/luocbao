<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="SSB - vote result">
<title>SSB - Ket qua Bieu quyet</title>
</head>
<body topmargin="2" leftmargin="5" marginheight="5" marginwidth="5" style="background-color:#0C186D">
	<div>
				<?php 
if($db)
{				
	echo '<form method="post" name="vote" target="vote">';
	
	$ard=array("'",'"',"\n");
	$art=array("\'",'\"',"");
	//
	$row = $db->row(0);
	$id = $row->id_vo;		
	$title = str_replace($ard, $art, $row->title_vo);
	$types = $row->types_vo;
	$comment = $row->comment_vo;
	$image = $row->image_vo;
	$show_vo = $row->show_vo;
	$images = ($image && file_exists("../".$image))?'<img src="'.base_url()."../".$image.'" width=100 />':'';
	//
	echo "<div class=\"block_title\">$title</div>";
	echo $images.$comment;
	//
	foreach($db->result() as $rw)
	{
		$aid = $rw->id_vc;
		$qid = $rw->id_vo;
		$position = $rw->position_vc;
		$content = $rw->content_vc;
		$image_ans = $rw->image_vc;
		$str_img = (!empty($image_ans) && file_exists('../'.$image_ans))?'<img src="'.base_url().'../'.$image_ans.'" width="100" style="padding-left:10px; vertical-align:text-top;" /><br />':'';	
##		echo form_hidden('check',$position);
		switch($types){
			case 'O': 
				$data = array(
											'name'        => 'check',
											'id'          => 'check'.$qid.'_'.$position,
											'value'       => $position,
											'style'       => 'margin:10px',
											);
				echo '<p><label>'.form_radio($data).$str_img.$content.'</label></p>';
			break;
			case 'M': 
				$data = array(
											'name'        => 'check[]',
											'id'          => 'check'.$qid.'_'.$position,
											'value'       => $position,
											'style'       => 'margin:10px',
											);
				echo '<p><label>'.form_checkbox($data).$str_img.$content.'</label></p>';
			break;
			default: 
				$data = array(
											'name'        => 'check',
											'id'          => 'check'.$qid.'_'.$position,
											'value'       => $position,
											'style'       => 'margin:10px',
											);
				echo '<p><label>'.form_radio($data).$str_img.$content.'</label></p>';
		}
		
	}
	echo '<input type="hidden" name="voteid" value="'.$id.'" /><input type="hidden" name="view" value="0" /><input type="submit" name="btnsubmit" value="Biểu quyết" onclick="return SubmitVote(this.form,0)" /> <input type="submit" name="btnview" value="Xem kết quả" onclick="return SubmitVote(this.form,1)" />';
		
	echo form_close();
}
?>
	</div>
	<table width="100%" cellspacing=0 cellpadding=0 border=0 id="AdImg" style="background-color:#f4f5f6">
		<form name="frmImgCode" id="frmImgCode" method="post" onSubmit="return doSubmit();">
			<input type=hidden name=hidAction id=hidAction value="">
			<input type=hidden name=fsubjectid id=fsubjectid value="1">

			<input type=hidden name=fpageid id=fpageid value="1">
			<input type=hidden name=fvoteid id=fvoteid value="322066248">
			<input type=hidden name=fvotetitle id=fvotetitle value="Từng chứng kiến học sinh xô xát, bạn hành động như thế nào?">
			<input type=hidden name=fvotefor id=fvotefor value="1">
			<input type=hidden name=faction id=faction value="0">
			<input type=hidden name=fDescription id=fDescription value="">
			<input type=hidden name=fnumitem id=fnumitem value="5">
			
			<input type=hidden name=fT_0 id=fT_0 value="Can ngăn">
			<input type=hidden name=fI_0 id=fI_0 value="0">

			<input type=hidden name=fN_0 id=fN_0 value="0">
			<input type=hidden name=fC_0 id=fC_0 value="">
			
			<input type=hidden name=fT_1 id=fT_1 value="Báo cho người có trách nhiệm">
			<input type=hidden name=fI_1 id=fI_1 value="0">
			<input type=hidden name=fN_1 id=fN_1 value="1">
			<input type=hidden name=fC_1 id=fC_1 value="1">
			
			<input type=hidden name=fT_2 id=fT_2 value="Quan sát">
			<input type=hidden name=fI_2 id=fI_2 value="0">
			<input type=hidden name=fN_2 id=fN_2 value="2">

			<input type=hidden name=fC_2 id=fC_2 value="">
			
			<input type=hidden name=fT_3 id=fT_3 value="Bỏ đi, coi như không biết">
			<input type=hidden name=fI_3 id=fI_3 value="0">
			<input type=hidden name=fN_3 id=fN_3 value="3">
			<input type=hidden name=fC_3 id=fC_3 value="">
			
			<input type=hidden name=fT_4 id=fT_4 value="Ý kiến khác">
			<input type=hidden name=fI_4 id=fI_4 value="0">
			<input type=hidden name=fN_4 id=fN_4 value="4">
			<input type=hidden name=fC_4 id=fC_4 value="">

			
			<input type=hidden name=fReferer id=fReferer value="http://vnexpress.net/GL/Home/">
			<tr>
				<td colspan="3" height="43px" valign=top style="background-color:#f4f5f6;padding-left:5px;"><img src="/Images/logo.gif" border="0"></td>
			</tr>
			<tr><td colspan="3" height="6px" valign=top align="center" style="background:url(/Service/Vote/securelog/line.gif)"></td></tr>
			<tr><td colspan="3" height="7px" valign=top></td></tr>
			<tr>
				<td width="18px" height="181px"></td>
				<td width="446px" height="181px" valign=top align="center">

					<table width="446px" height="100%" cellspacing=0 cellpadding=0 border=0>
						<tr><td colspan="3" height="2px" valign=top style="background:url(/Service/Vote/securelog/top.gif)"></td></tr>
						<tr height="175px">
							<td width="1px" valign=top style="background:url(/Service/Vote/securelog/cols.gif)"></td>
							<td width="444px" valign=top style="background-color:#ffffff;" align="center">
								<table cellspacing=0 cellpadding=0 border=0>
									<tr>
										<td colspan="3" height="48px" align=center><img src="/Service/Vote/securelog/title.gif" border="0"></td>
									</tr>

									<tr>
										<td colspan="3" height="10px"></td>
									</tr>
									<tr>
										<td height="35px" style="font-family:Tahoma;font-size:12px;padding-right:21px">Nh&#7853;p m&#227; x&#225;c nh&#7853;n (h&#236;nh)</td>

										<td height="35px" valign=middle align="center" style="padding-right:24px"><input type="text" name="txtValidCode" id="txtValidCode" maxlength="3" style="width:70px;height:35px;font-family:Tahoma;font-size:23px;text-align:center;"></td>
										<td height="35px" valign=middle><img src="/Service/Vote/securelog/image.asp"></td>
									</tr>
									<tr>
										<td colspan="3" height="28px"></td>
									</tr>
									<tr>
										<td colspan="3" align="center"><img src="/Service/Vote/securelog/submit.gif" border="0" style="cursor:pointer" name="btnRegis" id="btnRegis" onClick="doSubmit();"></td>
									</tr>

								</table>
							</td>
							<td width="1px" valign=top style="background:url(/Service/Vote/securelog/cols.gif)"></td>
						</tr>
						<tr><td colspan="3" height="4px" valign=top style="background:url(/Service/Vote/securelog/bottom.gif)"></td></tr>
					</table>
				</td>
				<td width="18px" height="181px"></td>
			</tr>

			<tr><td colspan="3" height="7px" valign=top></td></tr>
		</form>	
	</table>
	<script language="javascript">
		document.frmImgCode.txtValidCode.select();
		document.frmImgCode.txtValidCode.focus();
		function doSubmit(){
			if (frmImgCode.txtValidCode.value=='' || frmImgCode.txtValidCode.value.length !=3){
				alert('Ban phai nhap ma xac nhan du 3 ky tu!');
				return false;
			}
			document.frmImgCode.hidAction.value='1';
			document.getElementById('frmImgCode').submit();
		}
	</script>
<table width="100%" cellspacing=0 cellpadding=0 border=0 id="AdVote" style="display:none;background-color:#0C186D;"><tr><td>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td align=right class=VoteRemark>Th&#7913; ba, 16/3/2010, 14:52 GMT+7</td></tr>
<tr><td class=Title><font color="#ffffff">Từng chứng kiến học sinh xô xát, bạn hành động như thế nào?</font></td></tr>

</table>
<table border=0 cellspacing=1 cellpadding=3 width="100%">
<tr height=22>
<td  bgcolor="#ffffff" class=VoteShow>Can ngăn</td>
<td  bgcolor="#ffffff" class=VoteShow><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width=38 bgcolor="#FF3300">&nbsp;</td><td class=VoteShow>&nbsp;25.1%</td></tr></table></td>
<td  bgcolor="#ffffff" class=VoteShow align=right>3,998&nbsp;phi&#7871;u</td>
</tr>
<tr height=22>
<td  bgcolor="#ffffff" class=VoteShow>Báo cho người có trách nhiệm</td>
<td  bgcolor="#ffffff" class=VoteShow><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width=49 bgcolor="#004000">&nbsp;</td><td class=VoteShow>&nbsp;32.8%</td></tr></table></td>

<td  bgcolor="#ffffff" class=VoteShow align=right>5,226&nbsp;phi&#7871;u</td>
</tr>
<tr height=22>
<td  bgcolor="#ffffff" class=VoteShow>Quan sát</td>
<td  bgcolor="#ffffff" class=VoteShow><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width=23 bgcolor="#004080">&nbsp;</td><td class=VoteShow>&nbsp;15.2%</td></tr></table></td>
<td  bgcolor="#ffffff" class=VoteShow align=right>2,428&nbsp;phi&#7871;u</td>
</tr>
<tr height=22>
<td  bgcolor="#ffffff" class=VoteShow>Bỏ đi, coi như không biết</td>

<td  bgcolor="#ffffff" class=VoteShow><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width=34 bgcolor="#FF0080">&nbsp;</td><td class=VoteShow>&nbsp;22.9%</td></tr></table></td>
<td  bgcolor="#ffffff" class=VoteShow align=right>3,656&nbsp;phi&#7871;u</td>
</tr>
<tr height=22>
<td  bgcolor="#ffffff" class=VoteShow>Ý kiến khác</td>
<td  bgcolor="#ffffff" class=VoteShow><table cellspacing=0 cellpadding=0 border=0 align=left height=20><tr><td width=6 bgcolor="#008080">&nbsp;</td><td class=VoteShow>&nbsp;4.0%</td></tr></table></td>
<td  bgcolor="#ffffff" class=VoteShow align=right>636&nbsp;phi&#7871;u</td>
</tr>

<tr height=25><td bgcolor="#ffffff" colspan=3 align=right class=VoteShow>T&#7893;ng c&#7897;ng: 15,944&nbsp;phi&#7871;u</td></tr>
</table>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr>
<td height=20 valign=bottom class=VoteRemark></td>
<td height=20 valign=bottom align=right><a href="JavaScript:window.close()" class=Time><font color="#ffffff">[Tr&#7903; v&#7873;]</font></a></td>
</tr>
</table>

</td></tr></table>


</body>
</html>