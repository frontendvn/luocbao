<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lược Báo</title>
<link rel="stylesheet" href="<?=$css?>site.css" type="text/css" media="screen" title="default" />
<script type="text/javascript" src="<?=$js?>submenu/mouseovertabs.js"></script>
<script type="text/javascript" src="<?=$js?>jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=$js?>jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#tabs").tabs({
		event: 'mouseover'
	});
	var page = '<?=$this->uri->segment(1)?>';
	if(page=='home' || page =='') $.get('<?=$site_url?>capnhat');
});
</script>
</head>
<body>
<script type="text/javascript" src="<?=base_url();?>cfg/quangcao.js"></script>
<script type="text/javascript" language="javascript">
var speed1=images1=types1=links1=0;
var speed2=images2=types2=links2=0;
var speed3=images3=types3=links3=0;
var speed4=images4=types4=links4=0;
var speed5=images5=types5=links5=0;
var speed6=images6=types6=links6=0;
var speed7=images7=types7=links7=0;
var speed8=images8=types8=links8=0;
var speed9=images9=types9=links9=0;
var speed10=images10=types10=links10=0;
var speed11=images11=types11=links11=0;
var speed12=images12=types12=links12=0;
var urlimg ='<?=base_url();?>';
var urllink ='<?=base_url();?>qlqc/click.php?qc=';
</script>
<script type="text/javascript" src="<?=$js;?>adlib.js"></script>
<div id="header">
	<div id="golo"><img src="<?=$img?>logo.png" /> </div>
	<div id="bonan" style="height:80px;width:735px"><div id="h1" align="left" >Dành cho quảng cáo h1:730x80</div> </div>
</div>
<div id="throat">
	<div id="hor_menu">
		<div id="mytabsmenu" class="tabsmenuclass">
			<ul>
				<li id="trangchu" class="active"><a href="<?=site_url()?>" rel="gotsubmenu[selected]">Trang chủ</a></li>
				<li id="tin12h"><a href="<?=site_url('news/cat/Tin12h')?>" rel="gotsubmenu">Tin 12h</a></li>
				<li id="thegioi"><a href="<?=site_url('news/cat/The-gioi')?>" rel="gotsubmenu">Thế giới</a></li>
				<li id="vanhoa"><a href="<?=site_url('news/cat/Van-hoa')?>" rel="gotsubmenu">Văn hóa</a></li>
				<li id="phapluat"><a href="<?=site_url('news/cat/Phap-luat')?>" rel="gotsubmenu">Pháp luật</a></li>
				<li id="kinhte"><a href="<?=site_url('news/cat/Kinh-te')?>" rel="gotsubmenu">Kinh tế</a></li>
				<li id="kinhte"><a href="<?=site_url('news/cat/The-thao')?>" rel="gotsubmenu">Thể thao</a></li>
				<li id="showbiz"><a href="<?=site_url('news/cat/Show-biz')?>" rel="gotsubmenu">Show biz</a></li>
				<li id="nhipsong"><a href="<?=site_url('news/cat/Nhip-song-tre')?>" rel="gotsubmenu">Nhịp sống trẻ</a></li>
				<li id="phongcach"><a href="<?=site_url('news/cat/Phong-cach-song')?>" rel="gotsubmenu">Phong Cách</a></li>
				<li id="congnghe"><a href="<?=site_url('news/cat/Sanh-cong-nghe')?>" rel="gotsubmenu">Sành Công Nghệ</a></li>
				<li id="mgocsong"><a href="<?=site_url('news/cat/Goc-song-kien-truc')?>" rel="gotsubmenu">Góc sống</a></li>
				<li id="4teen"><a href="<?=site_url('news/cat/4-teen')?>" rel="gotsubmenu">4teen</a></li>
				<li id="tamsu"><a href="<?=site_url('news/cat/Tam-su')?>" rel="gotsubmenu">Tâm Sự</a></li>
				<li id="showbiz"><a href="<?=site_url('news/cat/Giai-tri')?>" rel="gotsubmenu">Giải trí</a></li>
			</ul>
		</div>
		<div id="mysubmenuarea" class="tabsmenucontentclass" style="float:left"><a href="<?=$js?>submenu/submenucontents.php" style="visibility:hidden">Menu</a></div>
		<div style="float:right; margin-right:10px">
			<form method="get" id="searchform" action="" style="display:inline; margin:0px;">
				<input type="text" style="padding-top:-2px;width:212px; height:22px; font-size:12px;color: #666666; text-align:center" value="" name="s" id="s"/>
				<input type="submit" title="Tìm kiếm" value="" style="margin-top:2px; padding-left:5px; border:0; width: 65px; height:20px; background:url(<?=$img?>search.gif) no-repeat;"/>
			</form>
		</div>
		<script type="text/javascript">mouseovertabsmenu.init("mytabsmenu", "mysubmenuarea", false)</script>
	</div>
</div>
<div id="site_body">