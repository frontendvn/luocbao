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
<title>Giá Xây dựng - Control panel</title>
<link rel="stylesheet" type="text/css" href="<?=$css?>site.css" />
<style type="text/css">
body{
	margin:0px;
	padding:0px;
	background:#FFFFFF;
	font-family: arial;
	font-size:12px;
	height:100%;
}
.container {
	margin: 0 auto;
	margin-top:150px;
	text-align:center;
	height:322px;
}

.message {
	margin: 0 auto;
	width: 300px;
	min-height:200px;
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
input[type="text"] {
	background-color:transparent;
	width:170px;
	height:20px;
}
input[type="password"] {
	border-color: #003399;
	background-color:transparent;
	width:170px;
	height:20px;
}
#center_part{
	display:block;
	margin: 0px auto;
	width:550px;
	min-height:350px;
	overflow:hidden;
	line-height:20px;
}
</style>
</head>
<body>
<div class="container">
<div id="center_part">
	<div class="boxbotron">
		<div class="boxbotron_inner clearfix">
			<div class="boxbotron_head_left">Phục hồi mật khẩu</div>
			<div class="boxbotron_head_right"> </div>
			<div class="boxbotron_corner boxbotron_bl"> </div>
			<div class="boxbotron_corner boxbotron_br"> </div>
			<div class="boxbotron_border clearfix">
				<div class="boxbotron_content clearfix">
					<?php
echo $message;
echo $this->session->flashdata('message');
echo form_open($this->mod.'/forgotten_password'); ?>
					<div class="clear"></div>
					<div style="margin-top:10px; margin-left:50px;">
						<label for="login">Email của bạn &nbsp;
						<input name="email" id="login" size="40" tabindex="1" type="text" />
						</label>
						<input value="Tiến hành" name="submitAuth" tabindex="3" type="submit" />
					</div>
					<?php echo form_close(''); ?>
					<div class="sepdiv"></div>
					(!) Trong vài phút tới, hệ thống sẽ gởi một email đến địa chỉ email của bạn.<br />
					Bạn cần đăng nhập vào hộp thư và làm các bước theo hướng dẫn để được cấp mật khẩu mới.</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>