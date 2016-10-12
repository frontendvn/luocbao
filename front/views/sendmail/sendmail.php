<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lược báo: gửi nội dung bài viết qua email</title>
<?php
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
?>
<link rel="stylesheet" href="<?=$css;?>site.css" type="text/css" media="screen" title="default" />
</head>
<body style="background:#fff;">
<div id="chitchat" style="width:480px; min-height:300px;float:left; clear:both;"> 
	<center>
	<img src="<?=$img;?>logo.png"/>
	<p style="font-size:18px; font-weight:bold; color:#009999">Gửi nội dung bài viết cho bạn bè</p>
	</center>
	<script type="text/javascript" language="javascript" src="http://vnexpress.net/Library/Common/vietUni.js"></script>
	<script type="text/javascript" language="javaScript">setTypingMode(1);</script>
	<div style="width:400px;float:right;height:30px; text-align:right; margin-top:12px; margin-right:10px;">
		<input type="radio" onfocus="setTypingMode(0)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="0" name="optInput">
		&nbsp;Tắt&nbsp;&nbsp;
		<input type="radio" checked="" onfocus="setTypingMode(1)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="1" name="optInput">
		&nbsp;Telex&nbsp;&nbsp;
		<input type="radio" onfocus="setTypingMode(2)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="2" name="optInput">
		&nbsp;VNI </div>
	<div class="clear"></div>
	<div style="width:470px; float:left;clear:left; margin-top:10px;">
		<div class="error">
			<?=$msg=empty($msg)?"":$msg;?>
		</div>
		<form method="post" name="frmComment" id="frmComment">
			<div style="width:420px; height:25px;float:right; clear:right; overflow:hidden; display:block">
				<div style="float:left">Tên người gửi </div>
				<input type="text" style="width:300px;float:right;" name="nguoigui" value="" onkeyup="initTyper(this)"  />
			</div>
			<div style="width:420px; height:25px;float:right; clear:both;">
				<div style="float:left">Email gửi</div>
				<input type="text" style="width:300px;float:right;" name="email_gui" value="" />
			</div>
			<div style="width:420px; height:25px;float:right; clear:right; overflow:hidden; display:block">
				<div style="float:left">Tên người nhận </div>
				<input type="text" style="width:300px;float:right;" name="nguoinhan" value="" onkeyup="initTyper(this)"  />
			</div>
			<div style="width:420px; height:25px;float:right; clear:both;">
				<div style="float:left">Email nhận</div>
				<input type="text" style="width:300px;float:right;" name="email_nhan" value=""  />
			</div>
			<div style="width:420px;float:right; clear:both;">
				<div style="float:left"> Nội dung </div>
				<textarea style="float: right;width:300px; height:100px;color:#666666" name="noidung" cols="43" onkeyup="initTyper(this)"></textarea>
			</div>
			<div style="width:300px;float:right; clear:both; padding-left:130px; margin-top:20px;"> &nbsp;
				<input id="submit_lienhe" name="btn_nhanxet" type="submit" value="Gửi bài" title="Gởi đi" alt="Gởi đi"/>
			</div>
		</form>
		<script type="text/javascript">
	var bshow = false;
	function submitForm(theform){
		document.frmComment.txtAddedBy.value = Trim(document.frmComment.txtAddedBy.value);
		if (document.frmComment.txtAddedBy.value == '' || document.frmComment.txtAddedBy.value == 'Họ tên')
		{
			alert('Xin hay nhap Ho ten!');
			document.frmComment.txtAddedBy.focus();
			return;
		}

		if ((SEmail = CheckEmailAddress(document.frmComment.txtAddedByEmail.value))=='')
		{
			alert('Dia chi Email khong hop le!');
			document.frmComment.txtAddedByEmail.focus();
			return;
		}

		document.frmComment.txtAddedByEmail.value = SEmail;

		document.frmComment.txtAddedTitle.value = Trim(document.frmComment.txtAddedTitle.value);
		if (document.frmComment.txtAddedTitle.value == '' || document.frmComment.txtAddedTitle.value == 'Tiêu đề')
		{
			alert('Xin hay nhap Tieu de!');
			document.frmComment.txtAddedTitle.focus();
			return;
		}
		

		document.frmComment.txtAddedContent.value = Trim(document.frmComment.txtAddedContent.value);
		if (document.frmComment.txtAddedContent.value == '')
		{
			alert('Xin hay nhap Noi dung!');
			document.frmComment.txtAddedContent.focus();
			return;
		}

		if (!confirm('Gui yeu cau?'))
			return;
			
		var status = AjaxRequest.submit(
			theform
			,{
				'onSuccess':function(req){
					if(req.responseText=='ValidCode'){
						alert('Ma xac nhan khong dung!');
					}
					else{
						alert(req.responseText);
						ResetDefault();
					}
				}
				,'onError':function(req){
					alert(req.responseText);
				}
			}
		);
		return status;
	}
	
	function ChangeImage() {			
		var ranNum = Math.floor(Math.random() * 5);

		AjaxRequest.get(
		  {
			'onSuccess':function(req){
				gmobj('imgValidCode').src = "/Service/Vote/securelog/image.asp?Code=" + ranNum;						
			}
			,'onError':function(req){					
			}
		  }

		)
    }
	
	function InputDefault() {
		document.frmComment.txtAddedBy.value = 'Họ tên';
		document.frmComment.txtAddedBy.className = 'adword-textbox';
		document.frmComment.txtAddedByEmail.value = 'Email';
		document.frmComment.txtAddedByEmail.className = 'adword-textbox';		
		document.frmComment.txtAddedTitle.value = 'Tiêu đề';
		document.frmComment.txtAddedTitle.className = 'adword-textbox';
		document.frmComment.txtValidCode.value = 'Mã xác nhận';		
		document.frmComment.txtValidCode.className = 'adword-textbox';
		document.frmComment.txtAddedContent.value = '';
		document.frmComment.txtAddedContent.focus();
	}
	
	function ResetDefault() {
		InputDefault();
		ChangeImage();
		
		ShowFormComment();
				
	}
</script>
		<div class="clear"></div>
	</div>
</div>
</body>
</html>