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
<meta name="robots" content="INDEX,FOLLOW" />
<meta name="generator" content="Ready Technologies CMS" />
<meta name="keywords" content="<?=$meta_keyword=empty($meta_keyword)?"":$meta_keyword;?>"/>
<meta name="description" content="<?=$description=empty($description)?"":$description;?>" />
<title><?=$heading=empty($heading)?"":$heading;?></title>
<link rel="shortcut icon" href="<?=$img;?>favicon.gif" type="image/x-icon" />
<link rel='index' title='Lược báo' href='<?=base_url();?>' />
<link rel="canonical" href="<?=base_url();?>" />
<link rel="stylesheet" href="<?=$css?>site.css" type="text/css" media="screen" title="default" />
<script type="text/javascript" src="<?=$js?>submenu/mouseovertabs.js"></script>
<script type="text/javascript" src="<?=$js?>jquery-1.3.2.js"></script>
<script src="<?=$js;?>ui.core.js"></script>
<script type="text/javascript" src="<?=$js?>ui.tabs.js"></script>
</head>
<body>
<script type="text/javascript" src="<?=base_url();?>cfg/quangcao.js"></script>

<div id="header" name="header">
	<div id="golo"><a href="<?=site_url()?>" title="Trang nhất" class="noborder"><img src="<?=$img?>logo.gif" alt="Trang nhất" /></a></div>
	<div id="bonan">
		<?php $segment_1 = $this->uri->segment(1);
		$segment_2 = $this->uri->segment(2-$this->default_param_uri);
		if($segment_1=='' || $segment_1=='news') $id_banner = 'h1';
		elseif ($segment_1=='news' && $segment_2=='cat') $id_banner = 'c1';
		elseif ($segment_1=='news' && $segment_2=='search') $id_banner = 'c1';
		elseif ($segment_1=='news' && $segment_2=='detail') $id_banner = 'd1';
		else $id_banner = 'c1';
		 ?>
		<div id="<?=$id_banner;?>" style="height:80px;width:730px;overflow:hidden" align="center" class="qcao">
		<?php if($id_banner=='c1'){ 
				echo showAd($this->config->item('qc_c1'));
			}
			if($id_banner=='d1'){
				echo showAd($this->config->item('qc_d1'));
			}
		?>
		</div>
	</div>
</div>

<?php 
	$segment_3 = $this->uri->segment(3-$this->default_param_uri); 
	$tin12h = array('Tin12h','tin12h');
	$thegioi = array('The-gioi');
	$vanhoa = array('Van-hoa');
	$phapluat = array('Phap-luat','Trat-tu-xa-hoi','Ho-so-trinh-sat','Nuoc-mat-toa-an','An-ninh-the-gioi');
	$kinhte = array('Kinh-te','Thi-truong-tiep-thi','Nhip-cau-dau-tu','Bat-dong-san','Thanh-dat');
	$thethao = array('The-thao');
	$showbiz = array('Show-biz','The-gioi-sao','Goc-anh-dep','Chuyen-hau-truong','Doi-thoai');
	$nhipsong = array('Nhip-song-tre','Tinh-yeu-gioi-tinh','Chuyen-tham-kinh','Hon-nhan-gia-dinh','Chuyen-cong-so');
	$phongcach = array('Phong-cach-song','Lam-dep','Thoi-trang-shopping','Song-khoe','Dan-ong');
	$congnghe = array('Sanh-cong-nghe','Vi-tinh','Dien-thoai','Hi-tech','Xe-hoi-xe-may');
	$gocsong = array('Goc-song-kien-truc');
	$teen = array('4-teen','Giao-duc-khuyen-hoc','Phong-cach-teen','Tuoi-moi-lon','Chuyen-chung-minh');
	$tamsu = array('Tam-su');
	$giaitri = array('Giai-tri','Nhung-dieu-ky-thu','Du-lich-kham-pha','Am-thuc','Cuoi-hip-mat');
	
	$url_cat = '';
	if(in_array($segment_3,$tin12h)){
		$selected_tin12h ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $tin12h[0];
	}else{
		$selected_tin12h ='rel="gotsubmenu"';
	}
	
	if(in_array($segment_3,$thegioi)){
		$selected_thegioi ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $thegioi[0];
	}else{
		$selected_thegioi ='rel="gotsubmenu"';
	} 
	
	if(in_array($segment_3,$vanhoa)){
		$selected_vanhoa ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $vanhoa[0];
	}else $selected_vanhoa ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$phapluat)){
		$selected_phapluat ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $phapluat[0];
	}else $selected_phapluat ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$kinhte)){
		$selected_kinhte ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $kinhte[0];
	}else $selected_kinhte ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$thethao)){
		$selected_thethao ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $thethao[0];
	}else $selected_thethao ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$showbiz)){
		$selected_showbiz ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $showbiz[0];
	}else $selected_showbiz ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$nhipsong)){
		$selected_nhipsong ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $nhipsong[0];
	}else $selected_nhipsong ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$phongcach)){
		$selected_phongcach ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $phongcach[0];
	}else $selected_phongcach ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$congnghe)){
		$selected_congnghe ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $congnghe[0];
	}else $selected_congnghe ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$gocsong)){
		$selected_gocsong ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $gocsong[0];
	}else $selected_gocsong ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$teen)){
		$selected_4teen ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $teen[0];
	}else $selected_4teen ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$tamsu)){
		$selected_tamsu ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $tamsu[0];
	}else $selected_tamsu ='rel="gotsubmenu"';
	
	if(in_array($segment_3,$giaitri)){
		$selected_giaitri ='class="active"  rel="gotsubmenu[selected]"';
		$url_cat = $giaitri[0];
	} else $selected_giaitri ='rel="gotsubmenu"';
	

	?>

<input type="hidden" value="<?=$url_cat;?>" id="url_cat"/>

<div id="throat">
	<div id="hor_menu">
		<div id="mytabsmenu" class="tabsmenuclass">
			<ul>
				<li id="trangchu" ><a href="<?=site_url()?>" rel="gotsubmenu">Trang chủ</a></li>
				<li id="tin12h" ><a <?=$selected_tin12h;?> href="<?=site_url('news/Tin12h')?>">Tin 12h</a></li>
				<li id="thegioi"><a <?=$selected_thegioi;?> href="<?=site_url('news/The-gioi')?>" >Thế giới</a></li>
				<li id="vanhoa"><a <?=$selected_vanhoa;?> href="<?=site_url('news/Van-hoa')?>" >Văn hóa</a></li>
				<li id="phapluat"><a <?=$selected_phapluat;?> href="<?=site_url('news/Phap-luat')?>" >Pháp luật</a></li>
				<li id="kinhte"><a <?=$selected_kinhte;?> href="<?=site_url('news/Kinh-te')?>" >Kinh tế</a></li>
				<li id="thethao"><a <?=$selected_thethao;?> href="<?=site_url('news/The-thao')?>" >Thể thao</a></li>
				<li id="showbiz"><a <?=$selected_showbiz;?> href="<?=site_url('news/Show-biz')?>" >Show biz</a></li>
				<li id="nhipsong"><a <?=$selected_nhipsong;?> href="<?=site_url('news/Nhip-song-tre')?>" >Nhịp sống trẻ</a></li>
				<li id="phongcach"><a <?=$selected_phongcach;?> href="<?=site_url('news/Phong-cach-song')?>" >Phong Cách</a></li>
				<li id="congnghe"><a <?=$selected_congnghe;?> href="<?=site_url('news/Sanh-cong-nghe')?>" >Sành Công Nghệ</a></li>
				<li id="mgocsong"><a <?=$selected_gocsong;?> href="<?=site_url('news/Goc-song-kien-truc')?>" >Góc sống</a></li>
				<li id="4teen"><a <?=$selected_4teen;?> href="<?=site_url('news/4-teen')?>" >4teen</a></li>
				<li id="tamsu"><a <?=$selected_tamsu;?> href="<?=site_url('news/Tam-su')?>" >Tâm Sự</a></li>
				<li id="giaitri"><a <?=$selected_giaitri;?> href="<?=site_url('news/Giai-tri')?>" >Giải trí</a></li>
			</ul>
		</div>
		<div id="mysubmenuarea" class="tabsmenucontentclass" style="float:left"><a href="<?=$js?>submenu/submenucontents.php" style="visibility:hidden">Menu</a></div>
		<div style="float:right; display:inline; margin-right:10px">
			<form method="post" id="searchform" action="<?=site_url('search/');?>" style="display:inline; margin:0px;">
				<input type="text" style="display:inline;padding-top:-2px;width:212px; height:22px; font-size:12px;color: #666666; text-align:center" value="" name="keywords" />
				<input type="submit" title="Tìm kiếm" name="btn_search" value="&nbsp;" style="margin-top:2px; display:inline; padding-left:5px; border:0; width: 65px; height:20px; background:url(<?=$img?>search.gif) no-repeat;"/>
			</form>
		</div>
		<script type="text/javascript">mouseovertabsmenu.init("mytabsmenu", "mysubmenuarea", true)</script>
	</div>
</div>
<div id="site_body">
