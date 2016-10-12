<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MEKONG EMERALD</title>
<link type="text/css" href="../../../crm/views/member/css/rounded_box.css" rel="Stylesheet" />
<style type="text/css">
body{
	margin:0px;
	padding:0px;
	/*background: #223039 url(<?=$img?>bg.gif);*/
	font-family: arial;
	font-size:12px;
	height:100%;
}
.container {
	margin: 0 auto;
	width: 300px;
	min-height:200px;
	display:block;
	margin-top:150px;
	/*background:url(<?=$img?>mekong_login.png);*/
}
.message {
	margin: 0 auto;
	width: 300px;
	min-height:200px;
	display:block;
	color:#FF0000;
}

a {
	cursor: pointer;
	text-decoration:none;
	color:#326696;
	}
a:hover{
	color:#FF0000;
}

a img {
	border: 0;
}
.swap_img_link a:hover{
	background-position: top right;

}
/* GENERAL STYLES */

h1 {
	font-size: 16px;
	margin: 5px 0;
	color: rgb(140,138,132);
	}

h2 {
	font-size: 14px;
	margin: 0px 0 15px 0;
	color: rgb(80,79,77);
	}

hr {
	border: 0;
	border-top: 1px dashed #666666;
	}
.segment{
	width:850px;
	float:left;
	overflow:hidden;
	margin-top:10px;
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
	border:none;
	border-color:#FFFFFF;
	width:150px;
	height:18px;
}
input[type="password"] {
	border:none;
	border-color:#FFFFFF;
	width:150px;
	height:18px;
}
#row_1{
	float:left;
	margin-top:100px;
	padding-left:115px;
}
#row_2{
	float:left;
	clear:left;
	margin-top:8px;
	padding-left:115px;
}
#row_3{
	float:left;
	clear:left;
	margin-top:10px;
	padding-left:115px;
}
</style>
</head>

<body>
<div class="container">
<?php
echo form_open($this->mod.'/login'); ?>
	<div id="row_1">
		<input type="text" name="email" />
	</div>
	<div id="row_2">
		<input type="password" name="password" />
	</div>
	<div id="row_3">
		<input type="image" src="<?=$img?>login_button.png" />
	</div>
<?php echo form_close(''); ?>
</div>
<div class="message"><?php echo $this->session->flashdata('message')?></div>
</body>
</html>