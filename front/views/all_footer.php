<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'news/';
?>
</div>
<div class="clear"></div>
<input type="hidden" value="<?=base_url();?>" id="id_homepage"/>

<script type="text/javascript" language="javascript">
function setHomePage() {
    if (document.all) {
        var homepage = document.getElementById("id_homepage");
        if (!homepage) {
            return;
        }
        var ishp = false;
		if (homepage.isHomePage('<?=base_url();?>')) {
			ishp = true;
		}
    
        if (!ishp) {
            homepage.style.behavior = "url(#default#homepage)";
            homepage.setHomePage(url);
        }
    } else {
        alert("Ch\u1ECDn Tools > Option > Main > Use Current Page (Alt+C) \u0111\u1EC3 \u0111\u1EB7t trang ch\u1EE7!");
    }
}
function addFavorite() {
    var title = "Lược báo - Chọn tin nhanh - Cập nhật sớm ";
    if (document.all) {
        window.external.AddFavorite('<?=base_url();?>', title);
    } else if (window.sidebar) {
        window.sidebar.addPanel(title, '<?=base_url();?>', "");
    }
}
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18463991-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div id="footer">
	<div id="bottom_menu">
	<center>
		<div id="div" class="bottomlinks">
			<ul>
				<li class="trangchu"><a href="javascript:setHomePage()">Đặt làm trang chủ</a></li>
				<li class="quangcaobt"><a href="#">Liên hệ quảng cáo</a></li>
				<li class="goibai"><a href="#">Phản ánh - gởi bài</a></li>
				<li class="toasoan"><a href="#">Liên hệ tòa soạn</a></li>
				<li class="ghinho"><a href="javascript:addFavorite();">Ghi nhớ trang này</a></li>
			</ul>
		</div>
		<div class="clear"></div>
		<h5><a href="<?=base_url();?>">Trang chủ</a> | <a href="<?=$site_url?>tin24h">Tin 24h</a> | <a href="<?=$site_url?>The-gioi">Thế giới</a> | <a href="<?=$site_url?>Van-hoa">Văn hóa</a> | <a href="<?=$site_url?>Phap-luat">Pháp luật</a> | <a href="<?=$site_url?>Kinh-te">Kinh tế</a> | <a href="<?=$site_url?>The-thao">Thể thao</a> | <a href="<?=$site_url?>Show-biz">Show biz</a> | <a href="<?=$site_url?>Nhip-song-tre">Nhịp sống trẻ</a> | <a href="<?=$site_url?>Phong-cach-song">Phong Cách Sống</a> | <a href="<?=$site_url?>Sanh-cong-nghe">Công Nghệ</a> | <a href="<?=$site_url?>4-teen">4teen</a> | <a href="<?=$site_url?>Goc-song-kien-truc">Góc Sống</a> | <a href="<?=$site_url?>Video-clip">Video Clips</a> | <a href="<?=$site_url?>Cuoc-song-quanh-ta">Cuộc sống quanh ta</a> | <a href="<?=$site_url?>Tam-su">Tâm Sự</a> | <a href="<?=$site_url?>Giai-tri">Giải trí</a></h5>
	</center>
	</div>
	<center ><p style="color:#666666;font-size:12px;margin-top:10px"><?php include 'cfg/cf_power_site.php';echo $footer = empty($config['footer'])?'':$config['footer'];?></p></center>
</div>

</body>
</html>