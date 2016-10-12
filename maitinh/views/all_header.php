<?php
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
	// set page's variables
	//$page_title = empty($this->menu_title)?"":$this->menu_title;
	if(!isset($controller_title)) $controller_title = "";
	if(!isset($function_title)) $function_title = " ";
	$fullname = $this->profile? $this->profile->fullname: "";
	$seg1 = $this->uri->segment(1);
	$clss1='';$clss2='';$clss3='';$clss4='';$clss5='';$clss6='';$clss7='';$clss8='';$clss9='';$clss10='';$clss11='';$clss12='';
	$class_current = 'menu_current'; 
	switch($seg1)
	{
		case 'welcome': $clss1=$class_current; break;
		case 'ncat': $clss2=$class_current; break;
		case 'news': $clss3=$class_current; break;
		case 'member': $clss4=$class_current; break;
		case 'cfsite': $clss4=$class_current; break;
		case 'usertype': $clss4=$class_current; break;
		case 'class_permit': $clss4=$class_current; break;
		case 'func_permit': $clss4=$class_current; break;
		case 'cfhomepage': $clss5=$class_current; break;
		case ($seg1=='vote' or $seg1=='vote_content'): $clss6=$class_current; break;
		case 'capnhat': $clss7=$class_current; break;
		case 'pattern': $clss8=$class_current; break;
		case 'crawler': $clss9=$class_current; break;
		case 'comment': $clss10=$class_current; break;
		case 'quangcao': $clss11=$class_current; break;
		case 'del_db': $clss12=$class_current; break;
		default: $clss1=$class_current;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lược báo - Quản trị -
<?php if(isset($page_title)) echo $page_title;?>
</title>
<link href="<?php echo $css?>tooltip.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$js?>jquery-1.3.2.js"></script>
<script type="text/javascript" src="<?php echo $js?>ui.core.js"></script>

<style type="text/css">
@charset "utf-8";
*{margin:0;padding:0} 
	body {
		background:transparent url(<?=$img;?>bg.gif);
		color: #161616;
		font-family:tahoma;
		font-size:12px;
		line-height:18px;
		margin:5px 0;
	}
	#body_top {
		width:1000px;
		margin:0 auto;
		height:10px;
		background:url(<?=$img;?>spritead.png) 0 0;
		}
	#body_content{
		background-color:#FFFFFF;
		padding:10px;
		width:980px;
		margin:0 auto;
		min-height:600px;
		display:block;
	}
	#body_bottom {
		width:1000px;
		margin:0 auto;
		height:10px;
		background:url(<?=$img;?>spritead.png) 0 -10px;
		clear:both;
	}
	a{ 
		color: #A07205;
		text-decoration: none;
	}
	a:hover{
		color:#FF3300
	}
	.underline {
		text-decoration: underline;
		color:#FF0000;
	}
	h1{font:20px; color: #FF3300}
	h2{font:18px; color: #FF6600}
	h3{font:16px; color: #FF9900}
	.clearfix {
		display:block;
	}
	
	#logo{
		float:left;
		text-align:left;
	}
	#nav{
		width:630px;
		height:90px;
		float:right;
	}
	#main_nav{
		width:780px;
		overflow:hidden;
		float:left;
		color:#999999;
		line-height:25px;
	}
	#main_nav a{
		font-size:13px;
		font-weight:bold;
		color:#006dd2;
		text-decoration:none;
	}
	#main_nav a:hover{
		color: #00CC33;
	}
	#sub_nav{
		font-family:tahoma;
		color:#999999;
	}
	#sub_nav a{
		font-size:11px;
		font-weight:bold;
		color: #006666;
		text-decoration:none;
	}
	#sub_nav a:hover{
		color: #FF3300;
	}

	.rtest{ border: 1px solid red; }
	a img {
		border:0 none;
	}
	div.buttons a img {
		display:inline;
		float:left;
		margin-right:10px;
	}
	div.buttons a img {
		display:inline;
		float:left;
		margin-right:10px;
	}
	div.buttons img {
		cursor:pointer;
	}
	.btn_them{background-image:url(<?=$img?>btn_them.gif);width:57px;height:26px;border:0;cursor:pointer}
.btn_xoa{background-image:url(<?=$img?>btn_xoa.gif);width:57px;height:26px;border:0;cursor:pointer}
.btn_sua{background-image:url(<?=$img?>btn_sua.gif);width:57px;height:26px;border:0;cursor:pointer}
/*wordpress liked ui */
.error, #error, .message, #message {
	display:block;
	width:auto;
	min-height:30px;
	font-family:Arial;
	font-size: 13px;
	color: #990000;
	float:left;
	margin:10px;
	padding:10px;
	border:1px solid #68abdd;
	background:#FFFFEC;
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

.button-secondary{
	border-color: #bbb;
	color: #464646;
}

.button-secondary:hover, input[type=button]:hover,input[type=submit]:hover{
	color: #000;
	border-color: #666;
}

.button-secondary, input[type=button],input[type=submit] {
	background: #f2f2f2 url(<?=$img?>white-grad.png) repeat-x scroll left top;
}


.button-secondary:active {
	background: #eee url(<?=$img?>white-grad-active.png) repeat-x scroll left top;
}
.button-secondary, input[type=button],input[type=submit] {
	vertical-align:middle;
	font-family: Arial;
	text-decoration: none;
	font-size: 12px !important;
	padding: 2px 8px;
	cursor: pointer;
	border-width: 1px;
	border-style: solid;
	-moz-border-radius: 11px;
	-khtml-border-radius: 11px;
	-webkit-border-radius: 11px;
	border-radius: 11px;
	-moz-box-sizing: content-box;
	-webkit-box-sizing: content-box;
	-khtml-box-sizing: content-box;
	box-sizing: content-box;
}
.button-secondary[disabled],
.button-secondary:disabled{
	color: #ccc !important;
	border-color: #ccc;
}

.button-secondary, input[type=button],input[type=submit]{
	text-shadow: rgba(255,255,255,1) 0 1px 0;
}
input[type=text], input[type=password], input[type=file], input[type=checkbox], input[type=radio], textarea, select, fieldset, upload {
	border:1px solid #999999;
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	margin: 2px;
}
select{margin-top:2px;height:22px;vertical-align:middle;}
input[type=text], input[type=password], input[type=file]{
	height:20px;
	vertical-align:middle;
}
fieldset{
	background:url(<?=$img?>kidbg.png) repeat-x;
	padding:10px;
}

legend {
	font-weight:bold;
	padding:0px 5px;
}
fieldset textarea{
	width:300px;
	height:50px;
	padding: 5px;
}
/* menu current*/
.menu_current { padding:2px;border:dotted 1px #0099CC; background-color:#CCFFFA; color:#663399}
.highlight {  padding:2px;border:dotted 1px #0099CC; background-color: #E9E9E9; color:#663399}
</style>
<?php
$this->load->view("css/css_table_row.php"); // '.anchor('pattern', 'Mẫu website', array('class'=>$clss8)).' - 
?>
</head>
<body>
<img id="dhtmlpointer" src="<?php echo $img;?>tooltiparrow.gif" alt="" />
<script src="<?php echo $js?>tooltip.js" type="text/javascript"></script>
<div id="body_top" ></div>
<div id="body_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px;">
	<tr>
		<td rowspan="3"><a href="<?php echo site_url('welcome')?>"><img src="<?=$img;?>brand.gif" border="0" /></a></td>
		<td align="right">Chào <?php echo $fullname;?> | <a href="<?=site_url('member/profile')?>"><strong>Tài khoản</strong></a> | <a href="<?php echo SITE?>" target="_blank">Website(Front)</a> | <a href="<?=site_url('home/logout')?>"><strong>Thoát</strong></a></td>
	</tr>
	<tr>
		<td id="main_nav">
		<?php echo anchor('welcome', 'Trang chủ', array('class'=>$clss1)).' - '.anchor('ncat', 'Chủ đề', array('class'=>$clss2)).' - '.anchor('news', 'Bản tin', array('class'=>$clss3)).' - '.anchor('news/list_audit', 'Duyệt tin', array('class'=>$clss3)).' - '.anchor('member', 'Quản trị', array('class'=>$clss4)).' - '.anchor('cfhomepage', 'Cache', array('class'=>$clss5)).' - '.anchor('vote', 'Thăm dò', array('class'=>$clss6)).' - '.anchor('comment', 'Nhận xét', array('class'=>$clss10)).' - '.anchor('quangcao', 'Quảng cáo', array('class'=>$clss11)).' - '.anchor('capnhat', 'Lấy tin', array('class'=>$clss7)).' - '.anchor('del_db', 'Xóa dữ liệu', array('class'=>$clss12));?></td>
	</tr>
	<tr>
		<td valign="top" id="sub_nav"><?php 
				echo "<span><strong>$controller_title </strong></span>";
				//echo "<span id=\"function_title\">$function_title</span>&nbsp;&nbsp;";
				if(isset($this->menu)) { // write controller's menus
					for($idx = 0; $idx < count($this->menu); $idx++){
						if(!strstr($this->uri->uri_string(), $this->menu[$idx]['link'])) $highlight = "";
						else $highlight = "class = 'highlight'";
						$link = $this->menu[$idx]['link'] =='#'?'#':site_url($this->menu[$idx]['link']);
						if(!empty($this->menu[$idx]['icon']) and file_exists("../images/icons/small/".$this->menu[$idx]['icon']))
							$icon_img = "<img src='".$img."icons/small/".$this->menu[$idx]['icon']."' align='absmiddle' />&nbsp;";
						else 
							$icon_img = "";
						echo $icon_img."<a href='".$link."' $highlight>".$this->menu[$idx]['name']." </a> &nbsp; &nbsp;";
					}
				}
			?></td>
	</tr>
</table>

<?php if(!empty($message)) echo "<div style='border:1px solid #fdb735; background-color: #e9ffef; padding:10px'>".$message."</div>";?>
