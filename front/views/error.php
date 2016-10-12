<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	$site_url = site_url().'/';
	$this->load->view('all_header');
	?>
	<div id="home_left" style="min-height:500px">
	<div style="float: left; height: 35px; width: 630px; margin-bottom: 10px; border-bottom: 1px dashed rgb(204, 204, 204); color: rgb(255, 8, 0); font-size: 18px; font-weight: bold;" id="cat_tit">
	<img src="<?=$img?>stop.png" align="absmiddle"/>&nbsp; Có lỗi</div>
	<div style="font-family: tahoma; font-size: 15px; color: rgb(19, 131, 207);float:left" >&nbsp; &nbsp; <strong><?=$message;?></strong></div>
	</div>
	
	<div class="clear"></div>
	<div class="marbottom5">
		<center>
			<div id="h12" align="left" style="width:980px;height:90px">Dành cho quảng cáo h12:980x90</div>
		</center>
	</div>
<?php 
$this->load->view('all_footer');?>
