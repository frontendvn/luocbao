<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
?>
<script src="<?=$js;?>ui.dialog.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		$("#ui-tabs").tabs({	event: 'mouseover'});
		//$("#tabs-1").tabs({event: 'mouseover'}).tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
		$("#gallery").tabs({event: 'mouseover'}).tabs({fx:{opacity: "toggle"}}).tabs("rotate", 4000, true);
});

$(function() {
	$("#idsoxokt").dialog({
		bgiframe: true,
		autoOpen: false,
		height: 500,
		width: 500,
		modal: true
	});
	$('#idxoso').click(function() {
		$('#idsoxokt').dialog('open');
	})
	$("#truyenhinh_dialog").dialog({
		bgiframe: true,
		autoOpen: false,
		height: 445,
		width: 772,
		modal: true
	});
	$('#truyenhinh').click(function() {
		$('#truyenhinh_dialog').dialog('open');
	})
	
});
	</script>

	<div id="home_left">
		<div id="headline">
			<div id="hl_left">
			<?php 
				
				$total_hot_news = $this->config->item('total_hot_news');
				$special_news_id_1 = $this->config->item('special_news_id_1');
				$specialtime_1 = $this->config->item('special_news_specialtime_1');
				$time = time();
				$j = 1;
				$var_total_hot_news = (!empty($special_news_id_1) and (int)$specialtime_1 >= $time)?10:9;
				$dump_html = "";
				if(!empty($special_news_id_1) and (int)$specialtime_1 >= $time)
				{
					$img_src = '<img src="'.$url.$this->config->item('special_news_img_1').'" width="356" />';
					$anchor_img = anchor('news/'.$this->config->item('special_news_id_cattext_1').'/'.$this->config->item('special_news_id_text_1'),$img_src);
					$title = stripslashes($this->config->item('special_news_title_1'));
					$anchor_title = anchor('news/'.$this->config->item('special_news_id_cattext_1').'/'.$this->config->item('special_news_id_text_1'),$title);
					$brief = word_limiter(stripslashes($this->config->item('special_news_intro_1')),38);
					$dump_html .= '
						<div id="itm0" style="width:362px;height:360px;overflow:hidden;" ><div style="width:362px;height:224px;overflow:hidden;">'.$anchor_img.'</div>
						<div id="hlinetit" style="margin:10px 0;clear:left;float:left;">'.$anchor_title.'</div>
						<p  style="clear:both">'.$brief.'</p></div>';
					//$total_hot_news = $total_hot_news + 1;
					
				}
				
				$k = (!empty($special_news_id_1) and (int)$specialtime_1 >= $time)?1:0;
				
				while($j<=$total_hot_news) :
					$img_src = '<img src="'.$url.$this->config->item('hot_news_img_'.$j).'" width="356" />';
					$anchor_img = anchor('news/'.$this->config->item('hot_news_id_cattext_'.$j).'/'.$this->config->item('hot_news_id_text_'.$j),$img_src);
					$title = stripslashes($this->config->item('hot_news_title_'.$j));
					$anchor_title = anchor('news/'.$this->config->item('hot_news_id_cattext_'.$j).'/'.$this->config->item('hot_news_id_text_'.$j),$title);
					$brief = word_limiter(stripslashes($this->config->item('hot_news_intro_'.$j)),38);
					//$m = $j+$k;
					$dump_html .= '
						<div id="itm'.$k.'" style="width:362px;height:360px;overflow:hidden;" ><div style="width:362px;height:224px;overflow:hidden;">'.$anchor_img.'</div>
						<div id="hlinetit" style="margin:10px 0;clear:left;float:left;">'.$anchor_title.'</div>
						<p  style="clear:both">'.$brief.'</p></div>';
					
					$j++; $k++;
				endwhile; 
				echo $dump_html;
			?>
			</div>
			<div id="hl_right">
				<div id="ui-tabs">
					<ul>
						<li><center><a href="#tabs-1" style="display:block; width:128px; ">TIN NÓNG</a></center></li>
						<li><center><a href="#tabs-2" style="display:block; width:128px; ">ĐỌC NHIỀU NHẤT</a></center></li>
					</ul>
					<div class="clear"></div>
					<div id="tabs-1" style="width:300px;over-flow:hidden;">
						<ul>
						<?php 
							$m=1;
							if(!empty($special_news_id_1) and (int)$specialtime_1 >= $time)
							{
								$str_id_news 					= 'special_news_id_1';
								$str_news_title 				= stripslashes($this->config->item('special_news_title_1'));
								$special_news_id_cattext_1 		= $this->config->item('special_news_id_cattext_1');
								$special_news_id_text_1 		= $this->config->item('special_news_id_text_1');
								$id_news = $this->config->item($str_id_news);
								//$total_hot_news = $total_hot_news + 1;
								echo '<li  onmouseover="Slide(0)" style="clear:left"><a style="padding:0px;" href="'.site_url('news/'.$special_news_id_cattext_1.'/'.$special_news_id_text_1).'">'.$str_news_title.'</a></li>';
							}
							$i = (!empty($special_news_id_1) and (int)$specialtime_1 >= $time)?1:0;
							while($m<=$total_hot_news) :
								$str_id_news 			= 'hot_news_id_'.$m;
								$str_news_title 		= stripslashes($this->config->item('hot_news_title_'.$m));
								$hot_news_id_text 		= $this->config->item('hot_news_id_text_'.$m);
								$hot_news_id_cattext 	= $this->config->item('hot_news_id_cattext_'.$m);
								$id_news = $this->config->item($str_id_news);
								//$m = $i+$k;
								if(!empty($id_news))
									echo '<li  onmouseover="Slide('.$i.')" style="width:270px;overflow:hidden"><a style="padding:0px;" href="'.site_url('news/'.$hot_news_id_cattext.'/'.$hot_news_id_text).'">'.$str_news_title.'</a></li>';
								 $m++;$i++;
							endwhile;
						?>
						</ul>
					</div>
					<div id="tabs-2">
						<ul>
						<?php 
							if($rs_max_view_count_news)
							{
								foreach($rs_max_view_count_news->result() as $row)
								{
									echo '<li><a href="'.site_url('news/'.$row->id_cattext.'/'.$row->id_text).'">'.stripslashes($row->news_title).'</a></li>';
								}
							}
						?>
						</ul>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="h4" align="center" style="width:670px;height:90px;overflow:hidden" class="qcao marbottom5 martop5">h4:670x90</div>
		<div id="block1_cover" class="marbottom5">
			<div id="block1_left">
				<div id="block1">
					<div id="title"><a href="<?=site_url('news/'.$this->config->item('cat2_news_id_cattext_1'))?>">Tin 12h</a></div>
					<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat2_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
					<div id="news">
					<?php 
						$cat2_news_id_1 = $this->config->item('cat2_news_id_1');
						if(!empty($cat2_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat2_news_id_cattext_1').'/'.$this->config->item('cat2_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat2_news_img_thumb_1'), 144,97).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat2_news_id_cattext_1').'/'.$this->config->item('cat2_news_id_text_1')).'">'.stripslashes($this->config->item('cat2_news_title_1')).'</a></h3>
						<p>'.word_limiter(stripslashes($this->config->item('cat2_news_intro_1')), 15).'</p>';
						}
					?>
					</div>
					<div class="clear"></div>
					<ul>
					<?php 
						$cat2_news_id_2 = $this->config->item('cat2_news_id_2');
						if(!empty($cat2_news_id_2)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat2_news_id_cattext_2').'/'.$this->config->item('cat2_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat2_news_title_2')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat2_news_date_2')).'</span></li>';
						}
						$cat2_news_id_3 = $this->config->item('cat2_news_id_3');
						if(!empty($cat2_news_id_3)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat2_news_id_cattext_3').'/'.$this->config->item('cat2_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat2_news_title_3')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat2_news_date_3')).'</span></li>';
						}
					?>
					</ul>
				</div>
			</div>
			<div id="block1_right">
				<div id="block1">
					<div id="title"><a href="<?=site_url('news/'.$this->config->item('cat3_news_id_cattext_1'))?>">Thế giới</a></div>
					<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat3_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
					<div id="news">
					<?php 
						$cat3_news_id_1 = $this->config->item('cat3_news_id_1');
						if(!empty($cat3_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat3_news_id_cattext_1').'/'.$this->config->item('cat3_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat3_news_img_thumb_1'), 144,97).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat3_news_id_cattext_1').'/'.$this->config->item('cat3_news_id_text_1')).'">'.stripslashes($this->config->item('cat3_news_title_1')).'</a></h3>
						<p>'.word_limiter(stripslashes($this->config->item('cat3_news_intro_1')), 15).'</p>';
						}
					?>
					</div>
					<div class="clear"></div>
					<ul>
					<?php 
						$cat3_news_id_2 = $this->config->item('cat3_news_id_2');
						if(!empty($cat3_news_id_2)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat3_news_id_cattext_2').'/'.$this->config->item('cat3_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat3_news_title_2')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat3_news_date_2')).'</span></li>';
						}
						$cat3_news_id_3 = $this->config->item('cat3_news_id_3');
						if(!empty($cat3_news_id_3)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat3_news_id_cattext_3').'/'.$this->config->item('cat3_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat3_news_title_3')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat3_news_date_3')).'</span></li>';
						}
					?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="block1_cover" class="marbottom5">
			<div id="block1_left">
				<div id="block1">
					<div id="title"><a href="<?=site_url('news/'.$this->config->item('cat4_news_id_cattext_1'))?>">Văn hóa</a></div>
					<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat4_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
					<div id="news">
					<?php 
						$cat4_news_id_1 = $this->config->item('cat4_news_id_1');
						if(!empty($cat4_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat4_news_id_cattext_1').'/'.$this->config->item('cat4_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat4_news_img_thumb_1'), 144,97).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat4_news_id_cattext_1').'/'.$this->config->item('cat4_news_id_text_1')).'">'.stripslashes($this->config->item('cat4_news_title_1')).'</a></h3>
						<p>'.word_limiter(stripslashes($this->config->item('cat4_news_intro_1')), 15).'</p>';
						}
					?>
					</div>
					<div class="clear"></div>
					<ul>
					<?php 
						$cat4_news_id_2 = $this->config->item('cat4_news_id_2');
						if(!empty($cat4_news_id_2)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat4_news_id_cattext_2').'/'.$this->config->item('cat4_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat4_news_title_2')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat4_news_date_2')).'</span></li>';
						}
						$cat4_news_id_3 = $this->config->item('cat4_news_id_3');
						if(!empty($cat4_news_id_3)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat4_news_id_cattext_3').'/'.$this->config->item('cat4_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat4_news_title_3')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat4_news_date_3')).'</span></li>';
						}
					?>
					</ul>
				</div>
			</div>
			<div id="block1_right">
				<div id="block1">
					<div id="title"><a href="<?=site_url('news/'.$this->config->item('cat13_news_id_cattext_1'))?>">Thể thao</a></div>
					<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat13_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
					<div id="news">
					<?php 
						$cat13_news_id_1 = $this->config->item('cat13_news_id_1');
						if(!empty($cat13_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat13_news_id_cattext_1').'/'.$this->config->item('cat13_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat13_news_img_thumb_1'), 144,97).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat13_news_id_cattext_1').'/'.$this->config->item('cat13_news_id_text_1')).'">'.stripslashes($this->config->item('cat13_news_title_1')).'</a></h3>
						<p>'.word_limiter(stripslashes($this->config->item('cat13_news_intro_1')), 15).'</p>';
						}
					?>
					</div>
					<div class="clear"></div>
					<ul>
					<?php 
						$cat13_news_id_2 = $this->config->item('cat13_news_id_2');
						if(!empty($cat13_news_id_2)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat13_news_id_cattext_2').'/'.$this->config->item('cat13_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat13_news_title_2')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat13_news_date_2')).'</span></li>';
						}
						$cat13_news_id_3 = $this->config->item('cat13_news_id_3');
						if(!empty($cat13_news_id_3)){
							echo '<li><a href="'.site_url('news/'.$this->config->item('cat13_news_id_cattext_3').'/'.$this->config->item('cat13_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat13_news_title_3')), 7).'</a> <span class="date">'.date('(d/m/y)', $this->config->item('cat13_news_date_3')).'</span></li>';
						}
					?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="h5" align="center" style="width:670px;height:65px;overflow:hidden" class="qcao marbottom5">h5:670x65</div>
		<div id="block2" class="marbottom5" style="height:370px">
			<div style="float:left;width:310px;">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1195px no-repeat; "></div>
				<div style="height:22px; width:265px; padding-top:3px; float:left;background:#7f7f7f"> <a href="<?=site_url('news/Phap-luat');?>" style="font-size:18px; color:#fff;">Pháp Luật</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#7f7f7f"><a  class="rss" href="<?=site_url('rss/cat/'.$this->config->item('cat38_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1195px no-repeat; "></div>
			<div class="clear" style="margin-bottom:10px"></div>
				<div id="news">
					<?php 
						$cat38_news_id_1 = $this->config->item('cat38_news_id_1');
						if(!empty($cat38_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat38_news_id_cattext_1').'/'.$this->config->item('cat38_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat38_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat38_news_id_cattext_1')).'" title="">Trật tự xã hội</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat38_news_id_cattext_1').'/'.$this->config->item('cat38_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat38_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat38_news_id_cattext_1')).'" title="">Trật tự xã hội</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat39_news_id_1 = $this->config->item('cat39_news_id_1');
						if(!empty($cat39_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat39_news_id_cattext_1').'/'.$this->config->item('cat39_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat39_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat39_news_id_cattext_1')).'" title="">Hồ sơ trinh sát</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat39_news_id_cattext_1').'/'.$this->config->item('cat39_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat39_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat39_news_id_cattext_1')).'" title="">Hồ sơ trinh sát</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat40_news_id_1 = $this->config->item('cat40_news_id_1');
						if(!empty($cat40_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat40_news_id_cattext_1').'/'.$this->config->item('cat40_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat40_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat40_news_id_cattext_1')).'" title="">Nước mắt tòa án</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat40_news_id_cattext_1').'/'.$this->config->item('cat40_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat40_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat40_news_id_cattext_1')).'" title="">Nước mắt tòa án</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat41_news_id_1 = $this->config->item('cat41_news_id_1');
						if(!empty($cat41_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat41_news_id_cattext_1').'/'.$this->config->item('cat41_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat41_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat41_news_id_cattext_1')).'" title="">An ninh thế giới</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat41_news_id_cattext_1').'/'.$this->config->item('cat41_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat41_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat41_news_id_cattext_1')).'" title="">An ninh thế giới</a></h3>';
					?>
				</div>
			</div>
			<div style="float:right;width:310px; border-left:1px solid #E5E5E5; padding-left:10px;">
				<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1195px no-repeat; "></div>
			<div style="height:22px; width:265px; padding-top:3px; float:left;background:#7f7f7f"> <a href="<?=site_url('news/Kinh-te');?>" style="font-size:18px; color:#fff;">Kinh Tế</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#7f7f7f"><a class="rss" href="<?=site_url('rss/cat/'.$this->config->item('cat42_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1195px no-repeat; "></div>
				<div class="clear" style="margin-bottom:10px"></div>
				<div id="news">
					<?php 
						$cat42_news_id_1 = $this->config->item('cat42_news_id_1');
						if(!empty($cat42_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat42_news_id_cattext_1').'/'.$this->config->item('cat42_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat42_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat42_news_id_cattext_1')).'" title="">Thị trường tiếp thị</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat42_news_id_cattext_1').'/'.$this->config->item('cat42_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat42_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat42_news_id_cattext_1')).'" title="">Thị trường tiếp thị</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat43_news_id_1 = $this->config->item('cat43_news_id_1');
						if(!empty($cat43_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat43_news_id_cattext_1').'/'.$this->config->item('cat43_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat43_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat43_news_id_cattext_1')).'" title="">Nhịp cầu đầu tư</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat43_news_id_cattext_1').'/'.$this->config->item('cat43_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat43_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat43_news_id_cattext_1')).'" title="">Nhịp cầu đầu tư</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat44_news_id_1 = $this->config->item('cat44_news_id_1');
						if(!empty($cat44_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat44_news_id_cattext_1').'/'.$this->config->item('cat44_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat44_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat44_news_id_cattext_1')).'" title="">Bất động sản</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat44_news_id_cattext_1').'/'.$this->config->item('cat44_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat44_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat44_news_id_cattext_1')).'" title="">Bất động sản</a></h3>';
					?>
				</div>
				<div id="news">
					<?php 
						$cat45_news_id_1 = $this->config->item('cat45_news_id_1');
						if(!empty($cat45_news_id_1)){
							echo '<a href="'.site_url('news/'.$this->config->item('cat45_news_id_cattext_1').'/'.$this->config->item('cat45_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat45_news_img_thumb_1'), 117, 79).'</a>
							<h3><a href="'.site_url('news/'.$this->config->item('cat45_news_id_cattext_1')).'" title="">Thành đạt</a></h3>
							<p><a href="'.site_url('news/'.$this->config->item('cat45_news_id_cattext_1').'/'.$this->config->item('cat45_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat45_news_title_1')), 12).'</a></p>';
						}
						else
							echo '<h3><a href="'.site_url('news/'.$this->config->item('cat45_news_id_cattext_1')).'" title="">Thành đạt</a></h3>';
					?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:162px; height:312px; border:1px solid #d5d8de; background:url(<?=$img?>block_bg.gif) repeat-x;">
			<p><a href="<?=site_url('news/'.$this->config->item('cat16_news_id_cattext_1'))?>" style="display:block; margin:5px 10px;font-size:14px; font-weight:bold;">Góc sống</a></p>
			<div id="gocsong">
			<?php 
				$cat16_news_id_1 = $this->config->item('cat16_news_id_1');
				if(!empty($cat16_news_id_1)){
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat16_news_id_cattext_1').'/'.$this->config->item('cat16_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat16_news_img_thumb_1'), 144,97,'','','border:2px solid #fff').'</a></p>
					<p id="goc1"><a href="'.site_url('news/'.$this->config->item('cat16_news_id_cattext_1').'/'.$this->config->item('cat16_news_id_text_1')).'" style="color:#fff">'.word_limiter(stripslashes($this->config->item('cat16_news_title_1')), 10).'</a></p>';
				}

				$cat16_news_id_2 = $this->config->item('cat16_news_id_2');
				if(!empty($cat16_news_id_2)){
					echo '<p id="goc2"><a href="'.site_url('news/'.$this->config->item('cat16_news_id_cattext_2').'/'.$this->config->item('cat16_news_id_text_2')).'" style="color:#fff">'.word_limiter(stripslashes($this->config->item('cat16_news_title_2')), 10).'</a></p>';
				}
				$cat16_news_id_3 = $this->config->item('cat16_news_id_3');
				if(!empty($cat16_news_id_3)){
					echo '<p id="goc3"><a href="'.site_url('news/'.$this->config->item('cat16_news_id_cattext_3').'/'.$this->config->item('cat16_news_id_text_3')).'" style="color:#fff">'.word_limiter(stripslashes($this->config->item('cat16_news_title_3')), 10).'</a></p>';
				}
			?>				
			</div>
			<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat16_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:162px; height:312px; border:1px solid #d5d8de;background:url(<?=$img?>block_bg.gif) repeat-x;">
			<p><a href="<?=site_url('news/'.$this->config->item('cat14_news_id_cattext_1'))?>" style="display:block; margin:5px 10px;font-size:14px; font-weight:bold;">Cuộc sống quanh ta</a></p>
			<div id="gocsong" style="background-color: #b5e51d">
			<?php 
				$cat14_news_id_1 = $this->config->item('cat14_news_id_1');
				if(!empty($cat14_news_id_1)){
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat14_news_id_cattext_1').'/'.$this->config->item('cat14_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat14_news_img_thumb_1'), 144,97,'','','border:2px solid #fff').'</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat14_news_id_cattext_1').'/'.$this->config->item('cat14_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat14_news_title_1')), 10).'</a></p>';
				}

				$cat14_news_id_2 = $this->config->item('cat14_news_id_2');
				if(!empty($cat14_news_id_2)){
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat14_news_id_cattext_2').'/'.$this->config->item('cat14_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat14_news_title_2')), 10).'</a></p>';
				}
				$cat14_news_id_3 = $this->config->item('cat14_news_id_3');
				if(!empty($cat14_news_id_3)){
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat14_news_id_cattext_3').'/'.$this->config->item('cat14_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat14_news_title_3')), 10).'</a></p>';
				}
			?>				
			</div>
			<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat14_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
		</div>
		<div class="marbottom5" style="float:left; margin-left:3px; width:330px; height:312px; overflow:hidden"> 
			<?php 
				$cat15_news_id_1 = $this->config->item('cat15_news_id_1');
				if(!empty($cat15_news_id_1)){
					echo showIMG($this->config->item('cat15_news_video_1'), 328, 232).'
					<p align="center"><a href="'.site_url('news/'.$this->config->item('cat15_news_id_cattext_1').'/'.$this->config->item('cat15_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat15_news_title_1')), 8).'</a></p>
					<p style="font-size:14px; font-weight:bold;">Video clips</p>';
				}
				else
					echo '<p style="font-size:14px; font-weight:bold;">Video clips</p>';
					
				$cat15_news_id_2 = $this->config->item('cat15_news_id_2');
				if(!empty($cat15_news_id_2)){
					echo '<p><img src="'.$img.'video.gif" />  <a href="'.site_url('news/'.$this->config->item('cat15_news_id_cattext_2').'/'.$this->config->item('cat15_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat15_news_title_2')), 8).'</a></p>';
				}
				
				$cat15_news_id_3 = $this->config->item('cat15_news_id_3');
				if(!empty($cat15_news_id_3)){
					echo '<p><img src="'.$img.'video.gif" />  <a href="'.site_url('news/'.$this->config->item('cat15_news_id_cattext_3').'/'.$this->config->item('cat15_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat15_news_title_3')), 8).'</a></p>';
				}
			?>				
		</div>
		<div id="h8" style="width:670px;height:65px;overflow:hidden" class="qcao marbottom5" align="center">h8:670x65</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:664px; padding:2px; height:210px; border:1px solid #d5d8de;overflow:hidden">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1039px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#0f87ff"> <a href="<?=site_url('news/Nhip-song-tre');?>" style="font-size:18px; color:#fff;">Nhịp Sống Trẻ</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#0f87ff"><a class="rss" href="<?=site_url('rss/pcat/Nhip-song-tre')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1039px no-repeat; "></div>
			<div style="width:140px; height:170px; margin:10px; margin-bottom:5px; float:left;display:inline; line-height:22px;overflow:hidden">
				<center><p><a href="<?=site_url('news/'.$this->config->item('cat22_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2">TÌNH YÊU GIỚI TÍNH</a></p></center>
				<?php 
					$cat22_news_id_1 = $this->config->item('cat22_news_id_1');
					if(!empty($cat22_news_id_1)){
						echo '<p><a href="'.site_url('news/'.$this->config->item('cat22_news_id_cattext_1').'/'.$this->config->item('cat22_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat22_news_img_thumb_1'), 144,97).'</a></p>
						<p style="color:#5d5d5d"><a href="'.site_url('news/'.$this->config->item('cat22_news_id_cattext_1').'/'.$this->config->item('cat22_news_id_text_1')).'">'.stripslashes($this->config->item('cat22_news_title_1')).'</a></p>';
					}
				?>
			</div>
			<div style="width:140px; height:170px; margin:10px; margin-bottom:5px; float:left;display:inline; line-height:22px;overflow:hidden">
				<center><p><a href="<?=site_url('news/'.$this->config->item('cat23_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2">CHUYỆN THẦM KÍN</a></p></center>
				<?php 
					$cat23_news_id_1 = $this->config->item('cat23_news_id_1');
					if(!empty($cat23_news_id_1)){
						echo '<p><a href="'.site_url('news/'.$this->config->item('cat23_news_id_cattext_1').'/'.$this->config->item('cat23_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat23_news_img_thumb_1'), 144,97).'</a></p>
						<p style="color:#5d5d5d"><a href="'.site_url('news/'.$this->config->item('cat23_news_id_cattext_1').'/'.$this->config->item('cat23_news_id_text_1')).'">'.stripslashes($this->config->item('cat23_news_title_1')).'</a></p>';
					}
				?>
			</div>
			<div style="width:140px; height:170px; margin:10px; margin-bottom:5px; float:left;display:inline; line-height:22px;overflow:hidden">
				<center><p><a href="<?=site_url('news/'.$this->config->item('cat24_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2">HÔN NHÂN - GIA ĐÌNH</a></p></center>
				<?php 
					$cat24_news_id_1 = $this->config->item('cat24_news_id_1');
					if(!empty($cat24_news_id_1)){
						echo '<p><a href="'.site_url('news/'.$this->config->item('cat24_news_id_cattext_1').'/'.$this->config->item('cat24_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat24_news_img_thumb_1'), 144,97).'</a></p>
						<p style="color:#5d5d5d"><a href="'.site_url('news/'.$this->config->item('cat24_news_id_cattext_1').'/'.$this->config->item('cat24_news_id_text_1')).'">'.stripslashes($this->config->item('cat24_news_title_1')).'</a></p>';
					}
				?>
			</div>
			<div style="width:140px; height:170px; margin:10px; margin-right:0; margin-bottom:5px; float:left;display:inline; line-height:22px;overflow:hidden">
				<center><p><a href="<?=site_url('news/'.$this->config->item('cat25_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2">CHUYỆN CÔNG SỞ</a></p></center>
				<?php 
					$cat25_news_id_1 = $this->config->item('cat25_news_id_1');
					if(!empty($cat25_news_id_1)){
						echo '<p><a href="'.site_url('news/'.$this->config->item('cat25_news_id_cattext_1').'/'.$this->config->item('cat25_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat25_news_img_thumb_1'), 144,97).'</a></p>
						<p style="color:#5d5d5d"><a href="'.site_url('news/'.$this->config->item('cat25_news_id_cattext_1').'/'.$this->config->item('cat25_news_id_text_1')).'">'.stripslashes($this->config->item('cat25_news_title_1')).'</a></p>';
					}
				?>
			</div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:664px; padding:2px; height:350px; overflow:hidden; border:1px solid #d5d8de">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1065px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#f9824a"> <a href="<?=site_url('news/Show-biz');?>" style="font-size:18px; color:#fff;">Showbiz</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#f9824a"><a class="rss" href="<?=site_url('rss/pcat/Show-biz')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1065px no-repeat; "></div>
			<div style="width:300px; height:300px; margin:10px; margin-bottom:5px; float:left; display:inline; line-height:30px;">
				<p><a href="<?=site_url('news/'.$this->config->item('cat19_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2;font-size:16px">Camera Cận Cảnh</a></p>
				<div style="background:url(<?=$img?>album.gif) no-repeat;width:282px;height:42px; padding-left:18px; padding-top:1px;" id="gallery">
				<ul>
			<?php 
				$cat19_news_id_1 = $this->config->item('cat19_news_id_1');
				$cat19_news_meta_1 = $this->config->item('cat19_news_meta_1');
				$ar_img = empty($cat19_news_meta_1) ? array() : explode('~', $cat19_news_meta_1);
				$count = sizeof($ar_img);
				$n = $count>6 ? 6 : $count;
				if(!empty($cat19_news_id_1)){
					
					for($index=0; $index<$n; $index++)
					{
						$aimg = $ar_img[$index];
						//$index = $i+1;
						echo '<li style="width:40px; height:40px;overflow:hidden;float:left; margin-right:4px; background:none;" id="nav-showbiz-'.$index.'"><a style="padding:0px;" href="#showbiz-'.$index.'">
						<image src="'.base_url().$aimg.'"  width="37" border="0" style="min-height:37px"/></a></li>';
					}
				}
				?>
				</ul>
				</div>
				<div id="gallery_showbiz" style="clear:both;float:left;width:300px;height:220px;overflow:hidden;">
			<?php 
				if(!empty($cat19_news_id_1)){
					$showbiz_id_text = $this->config->item('cat19_news_id_text_1');
					$showbiz_title 	= word_limiter(stripslashes($this->config->item('cat19_news_title_1')),10);
					$id_cat_showbiz = $this->config->item('cat19_news_id_cattext_1');
					$anchor_showbiz_title = '<a href="'.site_url('news/'.$id_cat_showbiz.'/'.$showbiz_id_text).'" >'.$showbiz_title.'</a>';
					$slide_html ='<p style="color:#5d5d5d;clear:both">'.$anchor_showbiz_title.'</p>';
					for($index=0; $index<$n; $index++)
					{
						$aimg = $ar_img[$index];
						$showbiz_img 	= '<image src="'.base_url().$aimg.'"  width="296" />';
						$anchor_showbiz_img = '<a href="'.site_url('news/'.$id_cat_showbiz.'/'.$showbiz_id_text).'" >'.$showbiz_img.'</a>';

						$slide_html .= '<div id="showbiz-'.$index.'" class="ui-tabs-panel ui-tabs-hide">';
						$slide_html .= '<center>'.$anchor_showbiz_img.'</center></div>';
					}
					echo $slide_html;
				}
			?>
			</div>
			</div>
			<div style="width:310px; height:290px; margin:10px; margin-bottom:5px; float:left; display:inline; line-height:22px;">
				<div id="rnhipsong">
				<?php 
					$cat18_news_id_1 = $this->config->item('cat18_news_id_1');
					if(!empty($cat18_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat18_news_id_cattext_1').'/'.$this->config->item('cat18_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat18_news_img_thumb_1'), 144,'').'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat18_news_id_cattext_1')).'" title="">Thế giới sao</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat18_news_id_cattext_1').'/'.$this->config->item('cat18_news_id_text_1')).'">'.stripslashes($this->config->item('cat18_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat18_news_id_cattext_1')).'" title="">Thế giới sao</a></h3>';
				?>
				</div>
				<div id="rnhipsong">
				<?php 
					$cat20_news_id_1 = $this->config->item('cat20_news_id_1');
					if(!empty($cat20_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat20_news_id_cattext_1').'/'.$this->config->item('cat20_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat20_news_img_thumb_1'), 144,'').'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat20_news_id_cattext_1')).'" title="">Chuyện hậu trường</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat20_news_id_cattext_1').'/'.$this->config->item('cat20_news_id_text_1')).'">'.stripslashes($this->config->item('cat20_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat20_news_id_cattext_1')).'" title="">Chuyện hậu trường</a></h3>';
				?>
				</div>
				<div id="rnhipsong">
				<?php 
					$cat21_news_id_1 = $this->config->item('cat21_news_id_1');
					if(!empty($cat21_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat21_news_id_cattext_1').'/'.$this->config->item('cat21_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat21_news_img_thumb_1'), 144,'').'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat21_news_id_cattext_1')).'" title="">Đối thoại</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat21_news_id_cattext_1').'/'.$this->config->item('cat21_news_id_text_1')).'">'.stripslashes($this->config->item('cat21_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat21_news_id_cattext_1')).'" title="">Đối thoại</a></h3>';
				?>
				</div>
			</div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:664px; padding:2px; height:335px; border:1px solid #d5d8de">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1091px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#f119c6"> <a href="<?=site_url('news/Phong-cach-song');?>" style="font-size:18px; color:#fff;">Phong Cách Sống</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#f119c6"><a class="rss" href="<?=site_url('rss/pcat/Phong-cach-song')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1091px no-repeat; "></div>
			<div style="float:left; display:inline;width:310px; margin:5px; margin-top:30px">
				<div id="news">
				<?php 
					$cat26_news_id_1 = $this->config->item('cat26_news_id_1');
					if(!empty($cat26_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat26_news_id_cattext_1').'/'.$this->config->item('cat26_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat26_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat26_news_id_cattext_1')).'" title="">Làm đẹp</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat26_news_id_cattext_1').'/'.$this->config->item('cat26_news_id_text_1')).'">'.stripslashes($this->config->item('cat26_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat26_news_id_cattext_1')).'" title="">Làm đẹp</a></h3>';
				?>
				</div>
				<div id="news">
				<?php 
					$cat28_news_id_1 = $this->config->item('cat28_news_id_1');
					if(!empty($cat28_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat28_news_id_cattext_1').'/'.$this->config->item('cat28_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat28_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat28_news_id_cattext_1')).'" title="">Sống khỏe</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat28_news_id_cattext_1').'/'.$this->config->item('cat28_news_id_text_1')).'">'.stripslashes($this->config->item('cat28_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat28_news_id_cattext_1')).'" title="">Sống khỏe</a></h3>';
				?>
				</div>
				<div id="news">
				<?php 
					$cat27_news_id_1 = $this->config->item('cat27_news_id_1');
					if(!empty($cat27_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat27_news_id_cattext_1').'/'.$this->config->item('cat27_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat27_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat27_news_id_cattext_1')).'" title="">Thời trang - Shopping</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat27_news_id_cattext_1').'/'.$this->config->item('cat27_news_id_text_1')).'">'.stripslashes($this->config->item('cat27_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat27_news_id_cattext_1')).'" title="">Thời trang - Shopping</a></h3>';
				?>
				</div>
			</div>
			<div style="float:right; display:inline;width:310px; margin-right:10px; margin-top:10px; border:1px solid #999999; padding:7px;">
				<h3><a href="<?=site_url('news/'.$this->config->item('cat29_news_id_cattext_1'))?>">Đàn ông</a></h3>
				<div class="clear"></div>
				<div id="news">
				<?php 
					$cat29_news_id_1 = $this->config->item('cat29_news_id_1');
					if(!empty($cat29_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_1').'/'.$this->config->item('cat29_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat29_news_img_thumb_1'), 117, 79).'</a>
						<h4><a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_1').'/'.$this->config->item('cat29_news_id_text_1')).'" title="">'.word_limiter(stripslashes($this->config->item('cat29_news_title_1')), 11).'</a></h4>
						<p>'.word_limiter(stripslashes($this->config->item('cat29_news_intro_1')), 12).'</p>';
					}
				?>
				</div>
				<div id="news">
				<?php 
					$cat29_news_id_2 = $this->config->item('cat29_news_id_2');
					if(!empty($cat29_news_id_2)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_2').'/'.$this->config->item('cat29_news_id_text_2')).'" title="">'.showIMG($this->config->item('cat29_news_img_thumb_2'), 117, 79).'</a>
						<h4><a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_2').'/'.$this->config->item('cat29_news_id_text_2')).'" title="">'.word_limiter(stripslashes($this->config->item('cat29_news_title_2')), 11).'</a></h4>
						<p>'.word_limiter(stripslashes($this->config->item('cat29_news_intro_2')), 12).'</p>';
					}
				?>
				</div>
				<div id="news">
				<?php 
					$cat29_news_id_3 = $this->config->item('cat29_news_id_3');
					if(!empty($cat29_news_id_3)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_3').'/'.$this->config->item('cat29_news_id_text_3')).'" title="">'.showIMG($this->config->item('cat29_news_img_thumb_3'), 117, 79).'</a>
						<h4><a href="'.site_url('news/'.$this->config->item('cat29_news_id_cattext_3').'/'.$this->config->item('cat29_news_id_text_3')).'" title="">'.word_limiter(stripslashes($this->config->item('cat29_news_title_3')), 11).'</a></h4>
						<p>'.word_limiter(stripslashes($this->config->item('cat29_news_intro_3')), 12).'</p>';
					}
				?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="h10" align="center" style="width:670px;height:65px;overflow:hidden" class="qcao marbottom5">h10:670x65</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:664px; padding:2px; height:210px; border:1px solid #d5d8de">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1117px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#981d98"> <a href="<?=site_url('news/4-teen');?>" style="font-size:18px; color:#fff;">4 Teen</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#981d98"><a class="rss" href="<?=site_url('rss/pcat/4-teen')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1117px no-repeat; "></div>
			<div style="float:left;width:310px; margin:5px; margin-top:10px;">
				<div id="news">
				<?php 
					$cat34_news_id_1 = $this->config->item('cat34_news_id_1');
					if(!empty($cat34_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat34_news_id_cattext_1').'/'.$this->config->item('cat34_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat34_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat34_news_id_cattext_1')).'" title="">Giáo dục khuyến học</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat34_news_id_cattext_1').'/'.$this->config->item('cat34_news_id_text_1')).'">'.stripslashes($this->config->item('cat34_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat34_news_id_cattext_1')).'" title="">Giáo dục khuyến học</a></h3>';
				?>
				</div>
				<div id="news">
				<?php 
					$cat35_news_id_1 = $this->config->item('cat35_news_id_1');
					if(!empty($cat35_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat35_news_id_cattext_1').'/'.$this->config->item('cat35_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat35_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat35_news_id_cattext_1')).'" title="">Phong cách teen</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat35_news_id_cattext_1').'/'.$this->config->item('cat35_news_id_text_1')).'">'.stripslashes($this->config->item('cat35_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat35_news_id_cattext_1')).'" title="">Phong cách teen</a></h3>';
				?>
				</div>
			</div>
			<div style="float:right;width:310px; margin:5px;margin-top:10px; border-left:1px solid #E5E5E5; padding-left:10px;">
				<div id="news">
				<?php 
					$cat36_news_id_1 = $this->config->item('cat36_news_id_1');
					if(!empty($cat36_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat36_news_id_cattext_1').'/'.$this->config->item('cat36_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat36_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat36_news_id_cattext_1')).'" title="">Tuổi mới lớn</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat36_news_id_cattext_1').'/'.$this->config->item('cat36_news_id_text_1')).'">'.stripslashes($this->config->item('cat36_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat36_news_id_cattext_1')).'" title="">Tuổi mới lớn</a></h3>';
				?>
				</div>
				<div id="news">
				<?php 
					$cat37_news_id_1 = $this->config->item('cat37_news_id_1');
					if(!empty($cat37_news_id_1)){
						echo '<a href="'.site_url('news/'.$this->config->item('cat37_news_id_cattext_1').'/'.$this->config->item('cat37_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat37_news_img_thumb_1'), 117, 79).'</a>
						<h3><a href="'.site_url('news/'.$this->config->item('cat37_news_id_cattext_1')).'" title="">Chuyện chúng mình</a></h3>
						<p><a href="'.site_url('news/'.$this->config->item('cat37_news_id_cattext_1').'/'.$this->config->item('cat37_news_id_text_1')).'">'.stripslashes($this->config->item('cat37_news_title_1')).'</a></p>';
					}
					else
						echo '<h3><a href="'.site_url('news/'.$this->config->item('cat37_news_id_cattext_1')).'" title="">Chuyện chúng mình</a></h3>';
				?>
				</div>
			</div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; line-height:20px; width:664px; padding:2px; height:237px; overflow:hidden; border:1px solid #d5d8de">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1143px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#676767"> <a href="<?=site_url('news/Sanh-cong-nghe');?>" style="font-size:18px; color:#fff;">Sành Công Nghệ</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#676767"><a class="rss" href="<?=site_url('rss/pcat/Sanh-cong-nghe')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1143px no-repeat; "></div>
			<div style="width:155px; height:170px; margin:10px 0 5px 10px; float:left;display:inline;">
			<?php 
				$cat30_news_id_1 = $this->config->item('cat30_news_id_1');
				if(!empty($cat30_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_1').'/'.$this->config->item('cat30_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat30_news_img_thumb_1'), 144,'').'</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Vi tính</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_1').'/'.$this->config->item('cat30_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat30_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Vi tính</a></p>';
				
				$cat30_news_id_2 = $this->config->item('cat30_news_id_2');
				if(!empty($cat30_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_2').'/'.$this->config->item('cat30_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat30_news_title_2')), 8).'</a></p>';
				}
			?>
			</div>
			<div style="width:155px; height:170px;  margin:10px 0 5px 10px; float:left;display:inline;">
			<?php 
				$cat31_news_id_1 = $this->config->item('cat31_news_id_1');
				if(!empty($cat31_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat31_news_id_cattext_1').'/'.$this->config->item('cat31_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat31_news_img_thumb_1'), 144,'').'</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat31_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Điện thoại</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat31_news_id_cattext_1').'/'.$this->config->item('cat31_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat31_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat31_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Điện thoại</a></p>';
				
				$cat31_news_id_2 = $this->config->item('cat31_news_id_2');
				if(!empty($cat31_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat31_news_id_cattext_2').'/'.$this->config->item('cat31_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat31_news_title_2')), 8).'</a></p>';
				}
			?>
			</div>
			<div style="width:155px; height:170px; margin:10px 0 5px 10px; float:left;display:inline;">
			<?php 
				$cat32_news_id_1 = $this->config->item('cat32_news_id_1');
				if(!empty($cat32_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1').'/'.$this->config->item('cat32_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat32_news_img_thumb_1'), 144,'').'</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Hi - Tech</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1').'/'.$this->config->item('cat32_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat32_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Hi - Tech</a></p>';
				
				$cat32_news_id_2 = $this->config->item('cat32_news_id_2');
				if(!empty($cat32_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_2').'/'.$this->config->item('cat32_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat32_news_title_2')), 8).'</a></p>';
				}
			?>
			</div>
			<div style="width:155px; height:170px;  margin:10px 0 5px 10px; float:left;display:inline;">
			<?php 
				$cat33_news_id_1 = $this->config->item('cat33_news_id_1');
				if(!empty($cat33_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat33_news_id_cattext_1').'/'.$this->config->item('cat33_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat33_news_img_thumb_1'), 144,'').'</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Xe hơi - Xe máy</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat33_news_id_cattext_1').'/'.$this->config->item('cat33_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat33_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat32_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Xe hơi - Xe máy</a></p>';
				
				$cat33_news_id_2 = $this->config->item('cat33_news_id_2');
				if(!empty($cat33_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat33_news_id_cattext_2').'/'.$this->config->item('cat33_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat33_news_title_2')), 8).'</a></p>';
				}
			?>
			</div>
		</div>
		<div class="marbottom5" style="float:left; margin-right:4px; width:664px; padding:2px; height:300px; border:1px solid #d5d8de">
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) 0px -1169px no-repeat; "></div>
			<div style="height:22px; width:616px; padding-top:3px; float:left;background:#6acb44"> <a href="<?=site_url('news/Giai-tri');?>" style="font-size:18px; color:#fff;">Giải Trí</a> </div>
			<div style="height:23px; padding-top:2px; float:left;background:#6acb44"><a class="rss" href="<?=site_url('rss/pcat/Giai-tri')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div style="height:25px; width:8px; float:left;background:url(<?=$img?>sprite.gif) -10px -1169px no-repeat; "></div>
			<div style="width:240px; height:260px; background-color:#dfeced; margin:10px; margin-right:5px; float:left;display:inline; line-height:18px;">
				<center>
					<p><a href="<?=site_url('news/'.$this->config->item('cat46_news_id_cattext_1'))?>" style="font-weight:bold;color:#0674b2;font-size:16px;line-height:25px;">Những điều kỳ thú </a></p>
				</center>
				
				<div style="float:left;width:110px;margin-right:10px;">
				
				<?php
				$cat46_news_id_1 = $this->config->item('cat46_news_id_1');
				if(!empty($cat46_news_id_1)){
					echo '<p><center><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_1').'/'.$this->config->item('cat46_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat46_news_img_thumb_1'), 85, 65).'</a></center></p>
					<p style="color:#5d5d5d; margin-top:5px;"><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_1').'/'.$this->config->item('cat46_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat46_news_title_1')), 6).'</a></p>';
				}
				
				$cat46_news_id_2 = $this->config->item('cat46_news_id_2');
				if(!empty($cat46_news_id_2)){
					echo '<p style="margin-top:10px"><center><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_2').'/'.$this->config->item('cat46_news_id_text_2')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat46_news_img_thumb_2'), 85, 65).'</a></center></p>
					<p style="color:#5d5d5d; margin-top:5px;"><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_2').'/'.$this->config->item('cat46_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat46_news_title_2')), 6).'</a></p>';
				}
				?>
				
				</div>
				<div style="float:left;width:110px;">
				<?php
				$cat46_news_id_3 = $this->config->item('cat46_news_id_3');
				if(!empty($cat46_news_id_3)){
					echo '<p><center><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_3').'/'.$this->config->item('cat46_news_id_text_3')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat46_news_img_thumb_3'), 85, 65).'</a></center></p>
					<p style="color:#5d5d5d; margin-top:5px;"><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_3').'/'.$this->config->item('cat46_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat46_news_title_3')), 6).'</a></p>';
				}
				
				$cat46_news_id_4 = $this->config->item('cat46_news_id_4');
				if(!empty($cat46_news_id_4)){
					echo '<p style="margin-top:10px"><center><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_4').'/'.$this->config->item('cat46_news_id_text_4')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat46_news_img_thumb_4'), 85, 65).'</a></center></p>
					<p style="color:#5d5d5d; margin-top:5px;"><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_4').'/'.$this->config->item('cat46_news_id_text_4')).'">'.word_limiter(stripslashes($this->config->item('cat46_news_title_4')), 6).'</a></p>';
				}
				?>
				</div>
			</div>
			<div style="width:125px; height:280px; margin:10px; margin-right:0; float:left;display:inline; line-height:20px;">
			<?php 
				$cat47_news_id_1 = $this->config->item('cat47_news_id_1');
				if(!empty($cat47_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;line-height:25px;">DL - Khám phá</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_1').'/'.$this->config->item('cat47_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat47_news_img_thumb_1'), 117, 79).'</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_1').'/'.$this->config->item('cat47_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat47_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">DL - Khám phá</a></p>';
				
				$cat47_news_id_2 = $this->config->item('cat47_news_id_2');
				if(!empty($cat47_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_2').'/'.$this->config->item('cat47_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat47_news_title_2')), 8).'</a></p>';
				}
				$cat47_news_id_3 = $this->config->item('cat47_news_id_3');
				if(!empty($cat47_news_id_3)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat47_news_id_cattext_3').'/'.$this->config->item('cat47_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat47_news_title_3')), 8).'</a></p>';
				}
			?>
			</div>
			<div style="width:125px; height:280px; margin:10px; margin-right:0; float:left;display:inline; line-height:20px;">
			<?php 
				$cat48_news_id_1 = $this->config->item('cat48_news_id_1');
				if(!empty($cat48_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;line-height:25px;">Ẩm thực</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_1').'/'.$this->config->item('cat48_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat48_news_img_thumb_1'), 117, 79).'</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_1').'/'.$this->config->item('cat48_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat48_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Ẩm thực</a></p>';
				
				$cat48_news_id_2 = $this->config->item('cat48_news_id_2');
				if(!empty($cat48_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_2').'/'.$this->config->item('cat48_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat48_news_title_2')), 8).'</a></p>';
				}
				$cat48_news_id_3 = $this->config->item('cat48_news_id_3');
				if(!empty($cat48_news_id_3)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat48_news_id_cattext_3').'/'.$this->config->item('cat48_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat48_news_title_3')), 8).'</a></p>';
				}
			?>
			</div>
			<div style="width:125px; height:280px; margin:10px; margin-right:0; float:left;display:inline; line-height:20px;">
			<?php 
				$cat49_news_id_1 = $this->config->item('cat49_news_id_1');
				if(!empty($cat49_news_id_1)){
					echo '<center>
					<p><a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;line-height:25px;">Cười híp mắt</a></p>
					<p><a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_1').'/'.$this->config->item('cat49_news_id_text_1')).'" title="" style="font-weight:12px;color:#0674b2">'.showIMG($this->config->item('cat49_news_img_thumb_1'), 117, 79).'</a></p>
					</center>
					<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_1').'/'.$this->config->item('cat49_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat49_news_title_1')), 8).'</a></p>';
				}
				else
					echo '<p><a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_1')).'" title="" style="font-weight:bold;color:#0674b2;font-size:16px;">Cười híp mắt</a></p>';
				
				$cat49_news_id_2 = $this->config->item('cat49_news_id_2');
				if(!empty($cat49_news_id_2)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_2').'/'.$this->config->item('cat49_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat49_news_title_2')), 8).'</a></p>';
				}
				$cat49_news_id_3 = $this->config->item('cat49_news_id_3');
				if(!empty($cat49_news_id_3)){
					echo '<p style="color:#5d5d5d">&bull; <a href="'.site_url('news/'.$this->config->item('cat49_news_id_cattext_3').'/'.$this->config->item('cat49_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat49_news_title_3')), 8).'</a></p>';
				}
			?>
			</div>
			
		</div>
	</div>
	<div id="home_right">
		<div id="h2" align="center" style="width:300px;height:190px;overflow:hidden" class="qcao marbottom5">h2:300x190</div>
		<div id="h3" align="center" style="width:300px;height:90px;overflow:hidden" class="qcao marbottom5">h3:300x90</div>
		<div class="marbottom5" style="border:1px solid #d5d8de; width:288px; padding:5px;">
			<div class="util01">
				<p class="utiltitle"><img height="18" width="17" alt="" src="http://zing.vn/news/images/icon_weather.gif"/> Thời tiết</p>
				<div id="cboWeather">
					
				</div>
				<div id="zfWeContent"> </div>
				<script src="http://zing.vn/util/weather.js" type="text/javascript"></script>
				<script type="text/javascript">
				  var initWeatherValue='t-p-ho-chi-minh';
				  function zfWeContent(idx){
						 var strCont='<p class="degree">'+weather[idx][2]+'</p>';
						 strCont+='<div class="cont09im"><img src="http://zing.vn/news/images/weather/'+weather[idx][3]+'" alt="" /></div>';
						 strCont+='<div class="cont09txt">'+weather[idx][4]+'<br />Độ ẩm: '+weather[idx][5]+'<br />'+weather[idx][6]+'</div>';
						 document.getElementById('zfWeContent').innerHTML=strCont;
					 };
					function zfChange(this_){
						zfWeContent(this_.selectedIndex);
					};
					function zfShowWeather(){
						var strcboWeather='<select onchange="zfChange(this);">';
						var itemindex=0;for(var i=0;i<weather.length;i++){
						var id=weather[i][0];
						if(initWeatherValue==id) itemindex=i;
						var name=weather[i][1];
						strcboWeather+='<option value="'+id+'"'+(initWeatherValue==id?' selected ':'')+'>'+name+'</option>';
					}
					document.getElementById('cboWeather').innerHTML=strcboWeather+'</select>';
					zfWeContent(itemindex);
				};
					
				zfShowWeather();
				</script>
				<div class="clear" style="margin-bottom:10px"></div>
				<p >&bull;&nbsp;<a id="idxoso" style="cursor:pointer">Kết quả xổ số</a></p>
				<p >&bull;&nbsp;<a id="truyenhinh" style="cursor:pointer">Truyền hình</a></p>
			</div>
			<div class="util02">
				<script type="text/javascript" language="javascript" src="http://vnexpress.net/Service/Gold_Content.js"></script>
				<script src="http://vnexpress.net/Service/Forex_Content.js" language="javascript" type="text/javascript"></script>
				<script type="text/javascript" language="javascript">
					function gmobj(o){
					 if(document.getElementById){ m=document.getElementById(o); }
					 else if(document.all){ m=document.all[o]; }
					 else if(document.layers){ m=document[o]; }
					 return m;
					} 
					function ShowGoldPrice(){
						var sHTML = '';
						sHTML = sHTML.concat('<div style="text-align:right;color:#8A0000;font:bold 10px arial;">ĐVT: tr.&#273;/l&#432;&#7907;ng</div>');
						if(vGoldSbjBuy=='{0}' || vGoldSbjSell=='{1}' || vGoldSjcBuy =='{2}' || vGoldSjcSell=='{3}'){
							sHTML = sHTML.concat('<table border="1" bordercolor="#ccc" style="border-collapse:collapse" cellpadding="3" cellspacing="1" class="tbl-goldprice">');
							sHTML = sHTML.concat('	<tr>');	
							sHTML = sHTML.concat('		<td class="td-weather-title" style="text-align:center;font-size:10px;width:35%;font-weight:bold">D&#7919; li&#7879;u &#273;ang &#273;&#432;&#7907;c c&#7853;p nh&#7853;t</td>');	
							sHTML = sHTML.concat('	</tr>');
							sHTML = sHTML.concat('</table>');
						}
						else{	
							sHTML = sHTML.concat('<table border="1" bordercolor="#ccc" style="border-collapse:collapse" cellpadding="3" cellspacing="1" class="tbl-goldprice">');
							sHTML = sHTML.concat('	<tr>');
							sHTML = sHTML.concat('		<td class="td-weather-title" style="font-size:10px;width:30%;">Lo&#7841;i</td>');
							sHTML = sHTML.concat('		<td class="td-weather-title" style="text-align:center;font-size:10px;width:35%;">Mua</td>');
							sHTML = sHTML.concat('		<td class="td-weather-title" style="text-align:center;font-size:10px;width:35%;">B&#225;n</td>');
							sHTML = sHTML.concat('	</tr>');
							sHTML = sHTML.concat('	<tr>');
							sHTML = sHTML.concat('		<td class="td-weather-title">SBJ</td>');
							sHTML = sHTML.concat('		<td class="td-weather-data txtr">').concat(vGoldSbjBuy).concat('</td>');
							sHTML = sHTML.concat('		<td class="td-weather-data txtr">').concat(vGoldSbjSell).concat('</td>');
							sHTML = sHTML.concat('	</tr>');
							sHTML = sHTML.concat('	<tr>');
							sHTML = sHTML.concat('		<td class="td-weather-title">SJC</td>');
							sHTML = sHTML.concat('		<td class="td-weather-data txtr">').concat(vGoldSjcBuy).concat('</td>');
							sHTML = sHTML.concat('		<td class="td-weather-data txtr">').concat(vGoldSjcSell).concat('</td>');
							sHTML = sHTML.concat('	</tr>');
							sHTML = sHTML.concat('</table>');	
						}
						gmobj('eGold').innerHTML = sHTML;
					}
					
					function ShowForexRate(){
						var sHTML = '';
						sHTML = sHTML.concat('<table border="1" bordercolor="#ccc" style="border-collapse:collapse" cellpadding="3" cellspacing="1" class="tbl-weather">');
						for(var i=0;i<vForexs.length;i++){
							sHTML = sHTML.concat('	<tr>');
							sHTML = sHTML.concat('		<td class="td-weather-title">').concat(vForexs[i]).concat('</td>');
							sHTML = sHTML.concat('		<td class="td-weather-data txtr">').concat(vCosts[i]).concat('</td>');
							sHTML = sHTML.concat('	</tr>');
						}
						sHTML = sHTML.concat('</table>');
						gmobj('eForex').innerHTML = sHTML;
					}	
					
				</script>
				<div class="goldprice fl">
					<div class="fl"><img class="img-icon" src="http://vnexpress.net/Images/money.gif" alt=""/>&nbsp;&nbsp;
						<label class="link-folder">Giá vàng 9999</label>
					</div>
					<div class="fl">
						<div id="eGold" class="gold-price fl"> </div>
						<div class="fl" style="width: 127px;">
							<label style="font: italic 10px arial; color: rgb(145, 144, 144);"> (Nguồn: <a href="http://www.sacombank-sbj.com/" target="_blank"> <img style="border: 0px none; vertical-align: middle; width: 80px; height: 9px;" src="http://vnexpress.net/Images/logoSb.gif" alt="Sacombank"/> </a>)</label>
						</div>
						<div class="fl"><img class="img-icon" src="http://vnexpress.net/Images/circle-chart.gif" alt=""/>&nbsp;&nbsp;
							<label class="link-folder">Tỷ giá</label>
						</div>
						<div id="eForex" class="forex-rate fl"> </div>
						<div class="fl">
							<label style="font: italic 10px arial; color: rgb(5, 50, 79);">(Nguồn: <a href="http://www.eximbank.com.vn/" target="_blank"> <img style="border: 0px none; vertical-align: middle;" src="http://vnexpress.net/Images/logo-EXIM.gif" alt=""/></a>)</label>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript" language="javascript">ShowGoldPrice();ShowForexRate();</script>
			<div class="clear"></div>
		</div>
		<div id="block_chonloc">
			<div id="title"><a href="#">Tin chọn lọc</a></div>
			<div id="rss"><a class="rss" href="<?=site_url('rss/chose/')?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div class="clear"></div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#e4f4fd">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_1 = $this->config->item('choose_news_id_1');
					if(!empty($choose_news_id_1)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_1').'/'.$this->config->item('choose_news_id_text_1')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_1'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_1').'/'.$this->config->item('choose_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_1')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122x; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_2 = $this->config->item('choose_news_id_2');
					if(!empty($choose_news_id_2)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_2').'/'.$this->config->item('choose_news_id_text_2')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_2'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_2').'/'.$this->config->item('choose_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_2')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_3 = $this->config->item('choose_news_id_3');
					if(!empty($choose_news_id_3)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_3').'/'.$this->config->item('choose_news_id_text_3')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_3'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_3').'/'.$this->config->item('choose_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_3')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122px; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_4 = $this->config->item('choose_news_id_4');
					if(!empty($choose_news_id_4)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_4').'/'.$this->config->item('choose_news_id_text_4')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_4'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_4').'/'.$this->config->item('choose_news_id_text_4')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_4')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#e4f4fd">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_5 = $this->config->item('choose_news_id_5');
					if(!empty($choose_news_id_5)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_5').'/'.$this->config->item('choose_news_id_text_5')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_5'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_5').'/'.$this->config->item('choose_news_id_text_5')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_5')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122px; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_6 = $this->config->item('choose_news_id_6');
					if(!empty($choose_news_id_6)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_6').'/'.$this->config->item('choose_news_id_text_6')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_6'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_6').'/'.$this->config->item('choose_news_id_text_6')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_6')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_7 = $this->config->item('choose_news_id_7');
					if(!empty($choose_news_id_7)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_7').'/'.$this->config->item('choose_news_id_text_7')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_7'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_7').'/'.$this->config->item('choose_news_id_text_7')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_7')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122px; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_8 = $this->config->item('choose_news_id_8');
					if(!empty($choose_news_id_8)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_8').'/'.$this->config->item('choose_news_id_text_8')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_8'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_8').'/'.$this->config->item('choose_news_id_text_8')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_8')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#e4f4fd">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_9 = $this->config->item('choose_news_id_9');
					if(!empty($choose_news_id_9)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_9').'/'.$this->config->item('choose_news_id_text_9')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_9'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_9').'/'.$this->config->item('choose_news_id_text_9')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_9')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122px; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_10 = $this->config->item('choose_news_id_10');
					if(!empty($choose_news_id_10)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_10').'/'.$this->config->item('choose_news_id_text_10')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_10'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_10').'/'.$this->config->item('choose_news_id_text_10')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_10')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
			<div style="height:122px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 122px; width:130px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_11 = $this->config->item('choose_news_id_11');
					if(!empty($choose_news_id_11)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_11').'/'.$this->config->item('choose_news_id_text_11')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_11'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_11').'/'.$this->config->item('choose_news_id_text_11')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_11')), 8).'</a></p>';
					}
				?>					
				</div>
				<div style="height: 122px; width:130px; margin-left:10px;float:left; overflow:hidden">
				<?php 
					$choose_news_id_12 = $this->config->item('choose_news_id_12');
					if(!empty($choose_news_id_12)){
						echo '<p><center><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_12').'/'.$this->config->item('choose_news_id_text_12')).'" title="">'.showIMG($this->config->item('choose_news_img_thumb_12'), 117, 79).'</a></center></p>
						<p style="margin-top:5px"><a href="'.site_url('news/'.$this->config->item('choose_news_id_cattext_12').'/'.$this->config->item('choose_news_id_text_12')).'">'.word_limiter(stripslashes($this->config->item('choose_news_title_12')), 8).'</a></p>';
					}
				?>					
				</div>
			</div>
		</div>
		
		<div id="h6" align="center" style="width:300px;height:200px;overflow:hidden" class="qcao marbottom5">h6:300x200</div>
		<div id="h7" align="center" style="width:300px;height:200px;overflow:hidden" class="qcao marbottom5">h7:300x200</div>
		<div id="block_chonloc">
			<?=show_vote();?>
		</div>
		<div id="block_chonloc">
			<div id="title"><a href="<?=site_url('news/'.$this->config->item('cat10_news_id_cattext_1'))?>">Tâm sự</a></div>
			<div id="rss"><a href="<?=site_url('rss/cat/'.$this->config->item('cat10_news_id_cattext_1'))?>"><img src="<?=$img?>rss.gif" /></a></div>
			<div class="clear"></div>
			<div id="rtamsu">
			<?php 
				$cat10_news_id_1 = $this->config->item('cat10_news_id_1');
				if(!empty($cat10_news_id_1)){
					echo '<a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_1').'/'.$this->config->item('cat10_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat10_news_img_thumb_1'), 117, 79).'</a>
				<h4><a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_1').'/'.$this->config->item('cat10_news_id_text_1')).'">'.word_limiter(stripslashes($this->config->item('cat10_news_title_1')), 10).'</a></h4>
				<p>'.word_limiter(stripslashes($this->config->item('cat10_news_intro_1')), 28).'</p>';
				}
			?>
			</div>
			<div id="rtamsu">
			<?php 
				$cat10_news_id_2 = $this->config->item('cat10_news_id_2');
				if(!empty($cat10_news_id_2)){
					echo '<a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_2').'/'.$this->config->item('cat10_news_id_text_2')).'" title="">'.showIMG($this->config->item('cat10_news_img_thumb_2'), 117, 79).'</a>
				<h4><a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_2').'/'.$this->config->item('cat10_news_id_text_2')).'">'.word_limiter(stripslashes($this->config->item('cat10_news_title_2')), 10).'</a></h4>
				<p>'.word_limiter(stripslashes($this->config->item('cat10_news_intro_2')), 28).'</p>';
				}
			?>
			</div>
			<div id="rtamsu">
			<?php 
				$cat10_news_id_3 = $this->config->item('cat10_news_id_3');
				if(!empty($cat10_news_id_3)){
					echo '<a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_3').'/'.$this->config->item('cat10_news_id_text_3')).'" title="">'.showIMG($this->config->item('cat10_news_img_thumb_3'), 117, 79).'</a>
				<h4><a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_3').'/'.$this->config->item('cat10_news_id_text_3')).'">'.word_limiter(stripslashes($this->config->item('cat10_news_title_3')), 10).'</a></h4>
				<p>'.word_limiter(stripslashes($this->config->item('cat10_news_intro_3')), 28).'</p>';
				}
			?>
			</div>
			<div class="clear"></div>
		</div>
		<div id="h9" align="center" style="width:300px;height:260px;overflow:hidden" class="qcao marbottom5">h9:300x260</div>
		<div id="h11" align="center" style="float:left;width:138px;height:476px;overflow:hidden" class="qcao marbottom5">h11:138x476</div>
		<div class="marbottom5" style="float:right;border:1px solid #D5D8DE; background:#ddd; width:147px; height:472px; overflow:hidden;">
			<div style="background:#fff;margin:5px; padding:5px; line-height:20px;">
				<center><p style="font-size:18px;">LINK HAY</p></center>
				<?php 
					for($i=1;$i<=3;$i++)
					{
						$useful_id = $this->config->item("useful_news_id_$i");
						if(!empty($useful_id))
						{
							echo '<p style="margin-bottom:10px"><center><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'">'.showIMG($this->config->item("useful_news_img_thumb_$i"), 117, 79).'</a></center></p>
								<p style="margin-bottom:10px; margin-top:5px"><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'" class="bl">'.word_limiter(stripslashes($this->config->item("useful_news_title_$i")), 7).'</a></p>';
						}
					}
				?>
			</div>
		</div>
		<div id="h13" align="center" style="width:300px;height:160px;overflow:hidden" class="qcao marbottom5"><img src="<?=$img;?>x1.jpg" /></div>
		<div class="clear"></div>
		<div id="h14" align="center" style="width:300px;height:160px;overflow:hidden" class="qcao marbottom5"><img src="<?=$img;?>x2.jpg" /></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="h12" align="center" style="width:980px;height:90px;margin:0 auto 5px auto;overflow:hidden;" class="qcao marbottom5"> h12:980x90</div>
	 <div  id="idsoxokt" style="width:500px;height:500px;background:#FFFFFF;border:5px solid #EFEFEF;padding:5px;display:none;" title="Kết quả xổ số"> 
  <iframe src="http://phienbancu.tuoitre.vn/tianyon/transweb/xoso.htm" style="margin-top: -50px;" width="100%" frameborder="0" height="550px" scrolling="no">
  </iframe>
 </div>
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
var speed13=images13=types13=links13=0;
var speed14=images14=types14=links14=0;
var urlimg ='<?=base_url();?>';
var urllink ='<?=base_url();?>qlqc/click.php?qc=';
</script>
<script type="text/javascript" src="<?=$js;?>adlib.js"></script>
 <script type="text/javascript" language="javascript">
	var curPos=0;
	var timer = setTimeout("Slide(1)",5000);
	var total_hot_news = <?=$var_total_hot_news;?>;
	function Slide(index)
	{
		clearTimeout(timer);
		var table = document.getElementById("TopNews");
		
		document.getElementById("itm" + curPos).style.display = "none";
		document.getElementById("itm" + index).style.display = "";
		
		curPos = index;
		index = (index == total_hot_news)?0:(index + 1);
		timer = setTimeout("Slide(" + index + ")", 5000);
	}
		swapAd('h1');swapAd('h2');swapAd('h3');swapAd('h4');swapAd('h5');swapAd('h6');swapAd('h7');swapAd('h8');swapAd('h9');swapAd('h10');swapAd('h11');swapAd('h12');swapAd('h13');swapAd('h14');

</script>
<div style="width:772px;height:440px;background:#FFFFFF;border:5px solid #EFEFEF;padding:5px;display:none;overflow:auto" id="truyenhinh_dialog" title="Lịch phát sóng truyền hình">&nbsp;&nbsp;&nbsp;
   <select name="truyenhinh_id" id="truyenhinh_id" onchange="truyenhinh_select()">
    <option selected="selected" value="VTV1">VTV1</option>
    <option value="VTV2">VTV2</option>
    <option value="VTV3">VTV3</option>
    <option value="VTV4">VTV4</option>
    <option value="VTV6">VTV6</option>
    <option value="VTV9">VTV9</option>
    <option value="VCTV1">VCTV1</option>
    <option value="VCTV2">VCTV2</option>
    <option value="VCTV3">VCTV3</option>
    <option value="VCTV6">VCTV6</option>
    <option value="VCTV7">VCTV7</option>
    <option value="VCTV8">VCTV8</option>
    <option value="VTC1">VTC1</option>
    <option value="VTC2">VTC2</option>
    <option value="VTC8">VTC8</option>
    <option value="VTC9">VTC9</option>
    <option value="HTV1">HTV1</option>
    <option value="HTV2">HTV2</option>
    <option value="HTV3">HTV3</option>
    <option value="HTV7">HTV7</option>
    <option value="HTV9">HTV9</option>
    <option value="Thuần Việt">Thuần Việt</option>
    <option value="HTVC-MOVIE">HTVC-MOVIE</option>
    <option value="TVB8">TVB8</option>
    <option value="Disney">Disney</option>
    <option value="Bloomberg">Bloomberg</option>
    <option value="Star Movies">Star Movies</option>
    <option value="NHK World">NHK World</option>
    <option value="Arirang">Arirang</option>
    <option value="News Asia">News Asia</option>
    <option value="Fashion TV">Fashion TV</option>
    <option value="TV5MONDE">TV5MONDE</option>
    <option value="Star World">Star World</option>
    <option value="Star Sport">Star Sport</option>
    <option value="ESPN">ESPN</option>
    <option value="Animax">Animax</option>
    <option value="Channel [V]">Channel [V]</option>
    <option value="Vĩnh Long">Vĩnh Long</option>
    <option value="HTVC-Phụ Nữ">HTVC-Phụ Nữ</option>
    <option value="HTVC-Gia Đình">HTVC-Gia Đình</option>
    <option value="Đồng Nai 1">Đồng Nai 1</option>
    <option value="Đồng Nai 2">Đồng Nai 2</option>
    <option value="Playhouse Disney">Playhouse Disney</option>
    <option value="O2TV">O2TV</option>
    <option value="BTV9">BTV9</option>
    <option value="Australia NWK">Australia NWK</option>
    <option value="HBO">HBO</option>
    <option value="Boomerang">Boomerang</option>
    <option value="DW-TV Asia+">DW-TV Asia+</option>
    <option value="Cartoon Network">Cartoon Network</option>
    <option value="VTC3">VTC3</option>
    <option value="Astro Cảm xúc">Astro Cảm xúc</option>
    <option value="Super Sport 1">Super Sport 1</option>
    <option value="Super Sport 2">Super Sport 2</option>
    <option value="Super Sport 3">Super Sport 3</option>
    <option value="VBC">VBC</option>
   </select>
   <center style="padding-top: 20px;">
    <div id="truyenhinh_result"></div>
   </center> 
   </div>
	<script type="text/javascript" language="javascript">
	$("#truyenhinh_result").html('<iframe src="http://tintucso.net/ajax/truyenhinh/VTV1"  width="730px" frameborder="0" height="440px" ></iframe>');
	function truyenhinh_select()
	{
		$("#truyenhinh_result").html('<iframe src="http://tintucso.net/ajax/truyenhinh/'+encodeURIComponent($('#truyenhinh_id').val())+'"  width="730px" frameborder="0" height="440px" ></iframe>');
	}
	</script>