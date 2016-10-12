<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lược báo: in bài viết</title>
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
<div style="width:800px; padding:0; margin:0; margin:0 auto;"> <img src="<?=$img;?>logo.png" style="float:left"/> <a href="" onclick="window.print()" class="print-title" style="display:block; margin-top:20px; float:right"><img alt="" src="<?=$img;?>print.gif" align="absmiddle"/>&nbsp;<strong>In trang</strong> </a>
	<div id="detail" style="width:780px; clear:both;float:left; border:1px solid #d9d9d9;padding:10px; margin-bottom:10px;">
	 <?php 

				if(is_object($db) && $db->num_rows()>0)
				{
					 $row = $db->row();
					 $news_content = $row->news_content;	
					 $id 		= $row->id_news;	
					 $id_nwc 	= $row->id_nwc;	
					 $news_date = date('d/m/Y',$row->news_date);	
					 $news_author 	= $row->news_author;	
					 $news_title 	= stripslashes($row->news_title);
					 $news_quickview 	= $row->news_quickview;	
					 $news_img 	= $row->news_img;	
					 $id_text 	= $row->id_text;
					 $id_cattext = $row->id_cattext;	
				?>
				
			<div id="cat_date" style="float:right;height:25px; width:50px; margin-bottom:10px; margin-right:20px; border-bottom:1px dashed #CCCCCC; color: #333333;font-size:12px;font-style:italic;"><?=$news_date;?></div>
			<div class="clear"></div>
				<p style="font-family: tahoma; font-size: 20px; color: rgb(19, 131, 207); padding-bottom: 10px;"><?=$news_title;?></p>
				<p style="font-family: arial; font-weight: bold; font-size: 14px; margin-bottom: 10px;">(<?= $news_author;?>) - <?=$news_quickview;?></p>
				
				<?= $news_content;?>
			<?php }?>
	 </div>
	<div style="width:780;height:50px; border-top:solid 1px #ccc; clear:both;">
		<div style="float:left; width:600px;">
			<p style="padding:20px 5px 0px 5px; margin:0; font-family:Arial; font-size:12px; color:#666;"> Bản quyền &copy; 2010 - 2020 Lược Báo </p>
		</div>
		<div style="float:left; padding:2px 0px 0px 0px; width:200px; text-align:right;"> <a href="" onclick="window.print()" class="print-title" style="display:block; margin-top:20px; float:right"><img alt="" src="<?=$img;?>print.gif" align="absmiddle"/>&nbsp;<strong>In trang</strong> </a> </div>
	</div>
</div>
</body>
</html>