<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	$site_url = site_url().'/';
	$base = base_url();
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AUTO NEWS</title>
<script src="<?php echo $js?>jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#swap').click(function(){
		$.get('<?=site_url($this->mod.'/swapcaptcha')?>', function(mess){
				$("#captcha").html(mess).show("fast");
		});
	});
})
</script>
<style type="text/css">
body{
	margin:0px;
	padding:0px;
	/*background-color:#333333;
	background: url(<?=$img;?>bg.gif);*/
	font-family: arial;
	font-size:12px;
	height:100%;
}
a {color:#fff}
.container {
	margin: 0 auto;
	margin-top:150px;
	text-align:center;
/*	background:url(<?=$img;?>login_bg.gif);
*/	height:322px;
}
.frame{	
	margin: 0 auto;
	width: 598px;
	height:322px;
	background:url(<?=$img;?>login.gif);
	background-repeat:no-repeat;
}

.message {
	margin: 0 auto;
	width: 300px;
	min-height:100px;
	display:block;
	color:#FF0000;
}
.floatl{
	float:left;
}
.floatr{
	float:right;
}

.clear{
	clear:both;
}
.rtest{
	border: 1px solid red;
}
.gtest{
	border: 1px solid green;
}
.btest{
	border: 1px solid blue;
}
input[type="text"] {
	border: 0;
	background-color:transparent;
	width:170px;
	height:20px;
}
input[type="password"] {
	border: 0;
	border-color: #003399;
	background-color:transparent;
	width:170px;
	height:20px;
}
#row_1{
	float:left;
	margin-top:136px;
	padding-left:230px;
}
#row_2{
	float:left;
	clear:left;
	margin-top:5px;
	padding-left:225px;
}
#row_3{
	float:left;
	clear:left;
	margin-top:10px;
	padding-left:230px;
}
</style>
</head>
<body>
<div class="container">
	<div class="frame">
		<form action="<?=site_url($this->mod.'/login')?>" method="post" style="margin:0;padding:0">
			<div id="row_1">
				<input type="text" name="email" />
			</div>
			<div id="row_2">
				<input type="password" name="password" />
			</div>
			<div id="row_2">
				<input name="captcha" value="" maxlength="5" type="text" size="1" style="height:20px; width:50px;font-size:14px;font-weight:bold; border:solid 1px; background:#fff" /> <span id="captcha"><?=$captcha?></span><img src="<?=$img?>/icons/small/swap.jpg" title="Đổi mã khác" id="swap" style="cursor:pointer; vertical-align:middle;" />
			</div>
			<div id="row_3">
				<input type="image" title="Sign In" name="login" src="<?=$img;?>signin.png" style="vertical-align:middle" />&nbsp;<? /*=anchor('home/forgotten_password', 'Quên mật khẩu?')*/?>
			</div>
		</form>
	</div>
	<div class="message"><?php echo $this->session->flashdata('message')?></div>
	<div style="clear:both">Contact admin: rotttten at yahoo dot com 
	</div>
	
	
</div>
</body>
</html>