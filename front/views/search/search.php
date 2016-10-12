<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
	$total_item = empty($total_item)?"":$total_item;
$pagi=empty($pagi)?"":$pagi;
$page=empty($page)?"0":$page;
?>

	<div id="home_left">
		<div id="cat_tit" style="float:left;height:25px; width:630px; margin-bottom:10px; border-bottom:1px dashed #CCCCCC; color:#ff0800;font-size:14px;">Từ khoá tìm kiếm: <?=$key=empty($key_word)?"":$key_word;?> <?=$message=empty($message)?"":$message;?></div>
		<div id="cat_items_left" style="width:500px;float:left">
		<input type="hidden" name="page" value="<?php echo $page;?>" />
		<div id="paging" style="padding-bottom:25px">
		<?php if(!empty($total_item)){?>
			<div id="paging_info" style="float:left">Kết quả tìm kiếm: <strong><?php echo $total_item;?></strong> </div>
			<div id="paging_page" style="float:right"><?php echo $pagi; ?></div>
			
		<?php }?>	
		</div>
		<?php 
			if($total_item)
			{
				$j=0;
				for($i=$first_item;$i<$last_item;$i++)
				{
					$first_news = $db->row($j);
					$image = showIMG($first_news->news_img_thumb, 144, 97, '', '', '', 0, 'style="margin-right:10px; border:1px solid #F2F2F2"');
					echo '<div id="cat_item_left">
							<div style="float:left;width:150px"><a href="'.site_url('news/'.$first_news->id_cattext.'/'.$first_news->id_text).'" title="">'.$image.'</a></div>
							<div style="float:right;width:310px">
								<p><a href="'.site_url('news/'.$first_news->id_cattext.'/'.$first_news->id_text).'" style="font-size:14px;font-weight: bold;">'.word_limiter(stripslashes($first_news->news_title), 14).'</a></p>
								<h6>'.date('d/m/Y', $first_news->news_date).'</h6>
								<p>'.word_limiter(stripslashes($first_news->news_quickview), 30).'</p>
							</div>
						</div>';
					$j++;
				}
			}
		?>
		<div id="paging">
		<?php if(!empty($total_item)){?>
			<div id="paging_page" style="float:right"><?php echo $pagi; ?></div>
		<?php }?>
		</div>
		</div>
		
		<div id="cat_items_right" style="width:155px;float:right">
			<div id="docnhieu" style="background:#C1EAFF;width:140px; line-height:20px; margin-bottom:10px;padding:5px">
				
					<p style="font-family:tahoma;font-size:14px;font-weight:bold;line-height:22px; text-align:center;">Tin Đọc Nhiều Nhất</p>
				<?php 
					if($rs_max_view_count_news)
					{
						foreach($rs_max_view_count_news->result() as $row)
						{
							$news_img = empty($row->news_img_thumb)?_random_image():$row->news_img_thumb;
							$image = showIMG($news_img, 117, 79, '', '', '', 0, 'style="margin-bottom:4px"');
							echo '<p><center><a href="'.site_url('news/'.$row->id_cattext.'/'.$row->id_text).'">'.$image.'</a></center></p><p><a class="bl" href="'.site_url('news/'.$row->id_cattext.'/'.$row->id_text).'">'.word_limiter(stripslashes($row->news_title), 7).'</a></p>';
						}
					}
				?>
				
			</div>
			<div id="c5"  style="float:left;width:150px;height:340px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c5'));?></div>
			<div class="clear"></div>
			<div id="list_tieudiem">
				<center>
					<p style="font-family:tahoma;font-size:14px;font-weight:bold;line-height:18px;">Tin Tiêu Điểm</p>
				</center>
				<ul>
		<?php 
			if($num_random_news)
			{
				for($i=0;$i<$total_random_news;$i++)
				{
					$j = $range[$i];
					$first_news = $rs_random_news_other_cat->row($j);
					echo '<li><a href="'.site_url('news/'.$first_news->id_cattext.'/'.$first_news->id_text).'">'.word_limiter(stripslashes($first_news->news_title), 14).'</a></li>';
				}
			}
		?>
				</ul>
			</div>
			
		</div>
		<div class="clear"></div>
		<div id="cat_bot_list" style="width:500px">
			<p style="font-weight:bold; color:#FF0000">PHẢI ĐỌC</p>
			<ul>
		<?php 
			$total_hot_news = $this->config->item('total_hot_news');
			if(!empty($total_hot_news))
			{
				$n = $this->config->item('total_hot_news');
				for($i=1;$i<=$n;$i++)
				{
					$str_id_news = 'hot_news_id_'.$i;
					$str_id_nwc = 'hot_news_id_cattext_'.$i;
					$str_id_text = 'hot_news_id_text_'.$i;
					$str_news_title = 'hot_news_title_'.$i;
					$id_news = $this->config->item($str_id_news);
					if(!empty($id_news))
						echo '<li><a href="'.site_url('news/'.$this->config->item($str_id_nwc).'/'.$this->config->item($str_id_text)).'">'.stripslashes($this->config->item($str_news_title)).'</a></li>';
					else
						break;
				}
			}
		?>
			</ul>
		</div>
		
	</div>
	<div id="home_right">
		<div id="c2"  style="width:300px;height:190px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c2'));?></div>
		<div id="c3"  style="width:300px;height:145px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c3'));?></div>
		<div id="block_chonloc">
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat2_news_id_cattext_1'))?>">Tin 12h</a></p>
					<?php 
						$cat2_news_id_1 = $this->config->item('cat2_news_id_1');
						if(!empty($cat2_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat2_news_id_cattext_1').'/'.$this->config->item('cat2_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat2_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat2_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat3_news_id_cattext_1'))?>">Thế Giới</a></p>
					<?php 
						$cat3_news_id_1 = $this->config->item('cat3_news_id_1');
						if(!empty($cat3_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat3_news_id_cattext_1').'/'.$this->config->item('cat3_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat3_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat3_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat4_news_id_cattext_1'))?>">Văn Hóa</a></p>
					<?php 
						$cat4_news_id_1 = $this->config->item('cat4_news_id_1');
						if(!empty($cat4_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat4_news_id_cattext_1').'/'.$this->config->item('cat4_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat4_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat4_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat38_news_id_cattext_1'))?>">Pháp Luật</a></p>
					<?php 
						$cat38_news_id_1 = $this->config->item('cat38_news_id_1');
						if(!empty($cat38_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat38_news_id_cattext_1').'/'.$this->config->item('cat38_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat38_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat38_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat42_news_id_cattext_1'))?>">Kinh Tế</a></p>
					<?php 
						$cat42_news_id_1 = $this->config->item('cat42_news_id_1');
						if(!empty($cat42_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat42_news_id_cattext_1').'/'.$this->config->item('cat42_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat42_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat42_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat13_news_id_cattext_1'))?>">Thể Thao</a></p>
					<?php 
						$cat13_news_id_1 = $this->config->item('cat13_news_id_1');
						if(!empty($cat13_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat13_news_id_cattext_1').'/'.$this->config->item('cat13_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat13_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat13_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
		</div>
		<div id="block_chonloc">
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat18_news_id_cattext_1'))?>">Showbiz</a></p>
					<?php 
						$cat18_news_id_1 = $this->config->item('cat18_news_id_1');
						if(!empty($cat18_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat18_news_id_cattext_1').'/'.$this->config->item('cat18_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat18_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat18_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat22_news_id_cattext_1'))?>">Nhịp Sống Trẻ</a></p>
					<?php 
						$cat22_news_id_1 = $this->config->item('cat22_news_id_1');
						if(!empty($cat22_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat22_news_id_cattext_1').'/'.$this->config->item('cat22_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat22_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat22_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat26_news_id_cattext_1'))?>">Phong Cách</a></p>
					<?php 
						$cat26_news_id_1 = $this->config->item('cat26_news_id_1');
						if(!empty($cat26_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat26_news_id_cattext_1').'/'.$this->config->item('cat26_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat26_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat26_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat30_news_id_cattext_1'))?>">Công Nghệ</a></p>
					<?php 
						$cat30_news_id_1 = $this->config->item('cat30_news_id_1');
						if(!empty($cat30_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat30_news_id_cattext_1').'/'.$this->config->item('cat30_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat30_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat30_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat35_news_id_cattext_1'))?>">4 Teen</a></p>
					<?php 
						$cat35_news_id_1 = $this->config->item('cat35_news_id_1');
						if(!empty($cat35_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat35_news_id_cattext_1').'/'.$this->config->item('cat35_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat35_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat35_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat10_news_id_cattext_1'))?>">Tâm Sự</a></p>
					<?php 
						$cat10_news_id_1 = $this->config->item('cat10_news_id_1');
						if(!empty($cat10_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat10_news_id_cattext_1').'/'.$this->config->item('cat10_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat10_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat10_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
		</div>
		<div id="block_chonloc">
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat46_news_id_cattext_1'))?>">Giải trí </a></p>
					<?php 
						$cat46_news_id_1 = $this->config->item('cat46_news_id_1');
						if(!empty($cat46_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat46_news_id_cattext_1').'/'.$this->config->item('cat46_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat46_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat46_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat16_news_id_cattext_1'))?>">Góc sống - KT hiện đại</a></p>
					<?php 
						$cat16_news_id_1 = $this->config->item('cat16_news_id_1');
						if(!empty($cat16_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat16_news_id_cattext_1').'/'.$this->config->item('cat16_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat16_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat16_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
			<div style="height:140px; width: 280px;  padding:5px; overflow:hidden; float:left; ">
				<div id="chuyenmuc">
					<p><a href="<?=site_url('new/'.$this->config->item('cat15_news_id_cattext_1'))?>">Video Clips</a></p>
					<?php 
						$cat15_news_id_1 = $this->config->item('cat15_news_id_1');
						if(!empty($cat15_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat15_news_id_cattext_1').'/'.$this->config->item('cat15_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat15_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat15_news_title_1')), 7).'</p>';
						}
					?>
				</div>
				<div id="chuyenmuc" style="margin-left:15px">
					<p><a href="<?=site_url('new/'.$this->config->item('cat14_news_id_cattext_1'))?>">Cuộc sống quanh ta</a></p>
					<?php 
						$cat14_news_id_1 = $this->config->item('cat14_news_id_1');
						if(!empty($cat14_news_id_1)){
							echo '<p><a href="'.site_url('news/'.$this->config->item('cat14_news_id_cattext_1').'/'.$this->config->item('cat14_news_id_text_1')).'" title="">'.showIMG($this->config->item('cat14_news_img_thumb_1'), 117, 79, '', '', '', 0, 'style="margin-bottom:5px; border:2px solid #fff"').'</a></p>
						<p>'.word_limiter(stripslashes($this->config->item('cat14_news_title_1')), 7).'</p>';
						}
					?>
				</div>
			</div>
		</div>
		<div id="c6"  style="width:300px;height:260px;float:left;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c6'));?></div>
		<div id="c7"  style="width:138px;height:476px;float:left;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c7'));?></div>
		<div class="marbottom5" style="float:right;border:1px solid #D5D8DE; background:#ddd; width:147px; height:470px; overflow:hidden;">
			<div style="background:#fff;margin:5px; padding:5px; line-height:20px; height:450px;">
				
					<p style="font-size:18px;"><center>LINK HAY</center></p>
				<?php 
					for($i=1;$i<=3;$i++) //10
					{
						$useful_id = $this->config->item("useful_news_id_$i");
						if(!empty($useful_id))
						{
							echo '<p style="margin-bottom:10px"><center><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'">'.showIMG($this->config->item("useful_news_img_thumb_$i"), 117, 79).'</a></center></p>
								<p style="margin-bottom:10px;margin-top:5px;"><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'" class="bl">'.word_limiter(stripslashes($this->config->item("useful_news_title_$i")), 7).'</a></p>';
						}
					}
				?>
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
		<div id="c8"  style="width:980px;height:90px;margin:0 auto 5px auto;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_c8'));?></div>
	</div>
	<script type="text/javascript" language="javascript">
 var url_cat = document.getElementById('url_cat').value;
var speed1=images1=types1=links1=0;
var speed2=images2=types2=links2=0;
var speed3=images3=types3=links3=0;
var speed4=images4=types4=links4=0;
var speed5=images5=types5=links5=0;
var speed6=images6=types6=links6=0;
var speed7=images7=types7=links7=0;
var speed8=images8=types8=links8=0;
var urlimg ='<?=base_url();?>';
var urllink ='<?=base_url();?>qlqc/click.php?qc=';
</script>
<script type="text/javascript" src="<?=$js;?>adlib_cat.js"></script>
<script type="text/javascript" language="javascript">
swapAd('c1');swapAd('c2');swapAd('c3');swapAd('c5');swapAd('c6');swapAd('c7');swapAd('c8');
</script>