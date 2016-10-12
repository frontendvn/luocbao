<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
	$url		= base_url(); 
	$img 		= $url.$this->config->item('img_dir');
	$css		= $url.$this->config->item('css_dir');
	$js 		= $url.$this->config->item('js_dir');
	
	$site_url = site_url().'/';
?>
<style>
.img_tieudiem{margin-bottom:5px; border:2px solid #fff;}
</style>
<div id="site_body" name="site_body">
	<div id="home_left">
		<div id="titt" style="width:510px;float:left;">
			<?php 

				if(is_object($db) && $db->num_rows()>0)
				{
					 $row = $db->row();
					// $news_content =  strip_tags($row->news_content, '<p><a><b><strong><img><object><embed><param><div><span><br>');
					$news_content =  $row->news_content;	
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
			<div style="float:left; height:25px; width:495px; margin-bottom:10px; border-bottom:1px dashed #CCCCCC;">
				<div id="cat_tit" style="display:inline; float:left; color:#ff0800;font-size:16px;font-weight:bold"><?=$str_name_cat;?> </div>	
				<div id="cat_date" style="float:right; margin-right:20px; color: #333333;font-size:12px;font-style:italic;display:inline"><?=$news_date;?></div>
			</div>			<div class="clear"></div>
			<div id="detail" style="width:480px; overflow:hidden;float:left; border:1px solid #d9d9d9;padding:10px; margin-bottom:10px;">
				<p style="font-family: tahoma; font-size: 20px; color:#0674b2; padding-bottom: 10px;"><?=$news_title;?></p>
				<p style="font-family: arial; font-weight: bold; font-size: 14px; margin-bottom: 10px; color:#666666">(<?= $news_author;?>) - <?=stripslashes($news_quickview);?></p>
				<?php 
					if(is_object($link_tags) && $link_tags->num_rows()>0)
					 {
					 	foreach($link_tags->result() as $row_tag)
						{
							echo '<p style="margin-bottom:5px">&bull; '.anchor('news/'.$row_tag->id_cattext.'/'.$row_tag->id_text,stripslashes($row_tag->news_title)).'</p>';
						}
					 }
				?>
				<?= $news_content;?>
				<p align="right"><a href="http://www.luocbao.com"><strong>www.luocbao.com</strong></a></p>
				<p align="right"><a href="#header" title="Về đầu trang" class="noborder"><img src="<?=$img?>up.gif" alt="Về đầu trang" /></a></p>
			</div>
			<div id="d5"  style="float:left;width:500px;height:50px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d5'));?></div>
			<div id="share" style="margin:10px; width:480px; height:30px;float:left;"> <strong style="color:#006666">Chia sẻ với bạn bè qua: </strong>
				<script type="text/javascript" language="javascript">function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
				<a href="http://www.facebook.com/share.php?u=<?=current_url();?>" onclick="return fbs_click()" target="_blank" class="noborder"><img src="<?=$img;?>facebook.gif" alt="" height="21"/></a>&nbsp; 
				<a onclick="javascript:window.open('http://twitter.com/home?status=2&amp;url='+window.location,'_blank')" class="noborder"><img src="<?=$img;?>twitter.gif" alt=""/></a>&nbsp; 
				<a onclick="javascript:window.open('http://www.google.com/bookmarks/mark?op=edit&amp;output=popup&amp;bkmk='+window.location,'_blank')" class="noborder"><img src="<?=$img;?>google.jpg" alt=""/></a>&nbsp; 
				<a onclick="javascript:window.open('http://bookmarks.yahoo.com/myresults/bookmarklet?u='+window.location,'_blank')" class="noborder"><img src="<?=$img;?>yahoo.gif" alt=""/></a>&nbsp;&nbsp;&nbsp; 
				<?php 
					//printpage
					echo anchor('printpage/'.$id_cattext.'/'.$id_text, '<img src="'.$img.'print.gif" alt="" style="border:none"/> Bản in', array('target'=>'_blank','class'=>'noborder'));
					echo '&nbsp; ';
					//sendmail
					$atts_sendmail = array(
								  'width'      => '626',
								  'height'     => '436',
								  'scrollbars' => 'yes',
								  'status'     => 'yes',
								  'resizable'  => 'yes',
								  'screenx'    => '10',
								  'screeny'    => '10'
								);
					echo anchor_popup('sendmail/'.$id_cattext.'/'.$id_text, '<img src="'.$img.'send.gif" alt="" style="border:none"/> Gởi bạn bè', $atts_sendmail);
				?>
			</div>	
			<div class="clear"></div>
			<?php
				if(is_object($show_comment) && $show_comment->num_rows()>0)
				{
					echo '<div style="width:480px;min-height:200px; border: 1px solid rgb(217, 217, 217); float:left; clear:both;overflow:auto; padding: 10px; margin-bottom: 10px;"">'; 
					echo '<strong>Ý kiến bạn đọc:</strong> <br>';
					foreach($show_comment->result() as $arw)
					{
						$fullname 	= $arw->fullname;
						$content 	= $arw->content;
						$comm_time 	= date('H:i:s A d/m/Y',$arw->comm_time);
						echo '<p><strong>'.$fullname .'</strong> - <em>('.$comm_time.')</em></p>';
						echo '<p>'.$content .'</p>';
						echo '<hr style="color:rgb(217, 217, 217)"/>';
					}
					echo '</div>';
				}
			?>
			<div id="chitchat" style="width:480px; min-height:300px;float:left; clear:both;background:url(<?=$img;?>bl_bg.gif) no-repeat;">
				
				<script type="text/javascript" language="javascript" src="http://vnexpress.net/Library/Common/vietUni.js"></script>
				<script type="text/javascript" language="javaScript">setTypingMode(1);</script>
				<div style="width:400px;float:right;height:30px; text-align:right; margin-top:12px; margin-right:10px;">
					<input type="radio" onfocus="setTypingMode(0)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="0" name="optInput">&nbsp;Tắt&nbsp;&nbsp;
					<input type="radio" checked="" onfocus="setTypingMode(1)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="1" name="optInput">&nbsp;Telex&nbsp;&nbsp;
					<input type="radio" onfocus="setTypingMode(2)" style="vertical-align: middle; margin-top: 0px;" class="SForm" value="2" name="optInput">&nbsp;VNI
				</div>
				<div class="clear"></div>
				<div style="width:470px; float:left;clear:left; margin-top:10px;">
					<div class="error"><?=$msg=empty($msg)?"":$msg;?></div>
					<form method="post" action="<?=site_url('comment')?>" name="frmComment" id="frmComment">
						<div style="width:420px;height:25px; float:right; clear:right; ">
							<div style="float:left">Tên bạn </div>
							<input type="text" style="width:300px;float:right;" name="fullname" value="<?=set_value("fullname")?>" onkeyup="initTyper(this)"  id="txtAddedBy"/>
						</div>
						<div style="width:420px;float:right;clear:right " align="center" class="error"><?=form_error('fullname'); ?></div>
						<div style="width:420px; height:25px;float:right; clear:both;">
							<div style="float:left">Email</div>
							<input type="text" style="width:300px;float:right;" name="email" value="<?=set_value("email")?>" />
						</div>
						<div style="width:420px; float:right; clear:right; " align="center" class="error"><?=form_error('email'); ?></div>
						<div style="width:420px;float:right; clear:both;">
							<div style="float:left"> Nội dung </div>
							<textarea style="float: right;width:300px; height:100px;color:#666666" name="noidung" id="txtAddedContent" cols="43" onkeyup="initTyper(this)"><?=set_value("noidung")?></textarea>
						</div>
						<div style="width:420px; float:right; clear:right; "align="center" class="error"><?=form_error('noidung'); ?></div>
						<div style="width:302px; height:25px;float:right; clear:right; padding-left:80px; margin-top:5px;">
							<input type="hidden" name="id_cattext" value="<?=$id_cattext;?>"/>
							<input type="hidden" name="id_text" value="<?=$id_text;?>"/>
							<input type="hidden" name="id_news" value="<?=$id;?>"/>
							<input type="text" style="width:50px;float:left;font-weight:bold" name="captcha"  value=""  maxlength="2" />
							<span id="captcha"><?=$captcha;?></span>&nbsp;&nbsp;<img src="<?=$img;?>swap.jpg" title="Đổi mã khác" id="swap" style="cursor:pointer; vertical-align:middle;" /> 
						</div>
						<div style="width:420px; float:right; clear:right; "align="center" class="error"><?=form_error('captcha'); ?></div>
						<div style="width:300px;float:right; clear:both; padding-left:130px;">
							<img src="<?=$img;?>warning.gif" align="absmiddle" style="cursor:help" alt="" title="Vui lòng gửi Bình luận bằng tiếng Việt có dấu, nội dung bình luận lành mạnh, nói lên quan điểm của bạn về đúng vấn đề nội dung bài viết.  Câu cú rõ ràng , ngắn gọn. Các bình luận không đáp ứng đề nghị trên sẽ không được hiển thị "/>&nbsp;
								<input id="submit_lienhe" name="btn_nhanxet" type="submit" value="Gửi bình luận" title="Gởi đi" alt="Gởi đi"/>
								&nbsp;
								<input name="reset" type="reset" title="Viết lại" value="Viết lại" alt="Viết lại"/>
							
						</div>
					</form>
					
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div id="cat_bot_list" style="width:500px;">
		<p style="font-weight:bold; color:#FF0000; margin-bottom:5px;">CÙNG CHỦ ĐỀ </p>
			<ul>
				<?php 
					$ar_tieudiem =array();
					$news_others = $this->mmod->news_others($id_text,$id_cattext);
					if(is_object($news_others) &&  $news_others->num_rows()>0)
					{
						foreach($news_others->result() as $rw){
							echo "<li>".anchor('news/'.$id_cattext.'/'.$rw->id_text,stripslashes($rw->news_title))."</li>";
						}
						
					}
				?>
			 </ul>
			
		</div>
		<div id="cat_bot_list" style="width:500px;">
		<p style="font-weight:bold; color:#FF0000; margin-bottom:5px;">TIN NÓNG </p>
			<ul>
						<?php 
							$total_hot_news = $this->config->item('total_hot_news');
							if(!empty($total_hot_news))
							{
								$n = $this->config->item('total_hot_news');
								for($i=1;$i<=$n;$i++)
								{
									$str_id_news = 'hot_news_id_'.$i;
									$str_id_cattext = 'hot_news_id_cattext_'.$i;
									$str_id_text = 'hot_news_id_text_'.$i;
									$str_news_title = 'hot_news_title_'.$i;
									$id_news = $this->config->item($str_id_news);
									if(!empty($id_news))
										echo '<li><a href="'.site_url('news/'.$this->config->item($str_id_cattext).'/'.$this->config->item($str_id_text)).'">'.stripslashes($this->config->item($str_news_title)).'</a></li>';
									else
										break;
								}
							}
						?>
				</ul>
		</div>
			 <?php }else echo '<div id="detail" style="width:480px;float:left; border:1px solid #d9d9d9;padding:10px; margin-bottom:10px;">Dữ liệu này không có.</div>';?>
	 </div>
		<div id="cat_items_right" style="width:150px;float:right;">
			<div id="docnhieu" style="background:#C1EAFF;width:140px; line-height:20px; margin-bottom:5px;padding:5px ">
				
					<p style="font-family:tahoma;font-size:14px;font-weight:bold;line-height:28px;">Tin Đọc Nhiều Nhất</p>
				<?php 
					if($rs_max_view_count_news)
					{
						foreach($rs_max_view_count_news->result() as $row)
						{
							$image = showIMG($row->news_img_thumb, 117, 79, '', '', '', 0, '');
							echo '<center><p><a href="'.site_url('news/'.$row->id_cattext.'/'.$row->id_text).'">'.$image.'</a></p></center><p><a class="bl" href="'.site_url('news/'.$row->id_cattext.'/'.$row->id_text).'">'.word_limiter(stripslashes($row->news_title), 9).'</a></p>';
						}
					}
				?>
				
			</div>
			<div id="d4"  style="float:left;width:150px;height:340px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d4'));?></div>
			<div class="marbottom5" style="float:right;border:1px solid #D5D8DE; background:#ddd; width:148px; height:705px; overflow:hidden;">
				<div style="background:#fff;margin:5px; padding:5px; line-height:18px; height:685px;overflow:hidden;">
					
						<p style="font-size:18px;" align="center">LINK HAY</p>
					<?php 
						for($i=1;$i<=5;$i++)
						{
							$useful_id = $this->config->item("useful_news_id_$i");
							if(!empty($useful_id))
							{
								echo '<center><p style="margin-bottom:5px"><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'">'.showIMG($this->config->item("useful_news_img_thumb_$i"), 117, 79).'</a></p></center>
									<p style="margin-bottom:5px"><a href="'.site_url('news/'.$this->config->item("useful_news_id_cattext_$i").'/'.$this->config->item("useful_news_id_text_$i")).'" class="bl">'.word_limiter(stripslashes($this->config->item("useful_news_title_$i")), 7).'</a></p>';
							}
						}
					?>
					
				</div>
			</div>
		</div>
	</div>
	<div id="home_right">
		<div id="d2" style="overflow:hidden;width:300px;height:190px" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d2'));?></div>
		<div id="d3" style="overflow:hidden;width:300px;height:145px" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d3'));?></div>
		<div id="block_chonloc">
			<div id="title"><a href="#">Tin Tiêu Điểm</a></div>
			<div class="clear"></div>
			<?php 
				$tieudiem4_news_id_1 = $this->config->item('tieudiem4_news_id_1');
				$tieudiem4_news_id_2 = $this->config->item('tieudiem4_news_id_2');
				if(!empty($tieudiem4_news_id_1) || !empty($tieudiem4_news_id_2)){
			?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem4_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem4_news_id_cattext_1').'/'.$this->config->item('tieudiem4_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem4_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem4_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem4_news_id_2)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem4_news_id_cattext_2').'/'.$this->config->item('tieudiem4_news_id_text_2')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem4_news_img_thumb_2'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem4_news_title_2')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }
				$tieudiem38_news_id_1 = $this->config->item('tieudiem38_news_id_1');
				$tieudiem38_news_id_2 = $this->config->item('tieudiem38_news_id_2');
				if(!empty($tieudiem38_news_id_1) || !empty($tieudiem38_news_id_2)){
			 ?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#feecec">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem38_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem38_news_id_cattext_1').'/'.$this->config->item('tieudiem38_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem38_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem38_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem38_news_id_2)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem38_news_id_cattext_2').'/'.$this->config->item('tieudiem38_news_id_text_2')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem38_news_img_thumb_2'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem38_news_title_2')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }
				$tieudiem18_news_id_1 = $this->config->item('tieudiem18_news_id_1');
				$tieudiem18_news_id_2 = $this->config->item('tieudiem18_news_id_2');
				if(!empty($tieudiem18_news_id_1) || !empty($tieudiem18_news_id_2)){
			?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem18_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem18_news_id_cattext_1').'/'.$this->config->item('tieudiem18_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem18_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem18_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						
						if(!empty($tieudiem18_news_id_2)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem18_news_id_cattext_2').'/'.$this->config->item('tieudiem18_news_id_text_2')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem18_news_img_thumb_2'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem18_news_title_2')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }
				$tieudiem24_news_id_1 = $this->config->item('tieudiem24_news_id_1');
				$tieudiem24_news_id_2 = $this->config->item('tieudiem24_news_id_2');
				if(!empty($tieudiem24_news_id_1) || !empty($tieudiem24_news_id_2)){
			?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#feecec">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						$tieudiem24_news_id_1 = $this->config->item('tieudiem24_news_id_1');
						if(!empty($tieudiem24_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem24_news_id_cattext_1').'/'.$this->config->item('tieudiem24_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem24_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem24_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						$tieudiem24_news_id_2 = $this->config->item('tieudiem24_news_id_2');
						if(!empty($tieudiem24_news_id_2)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem24_news_id_cattext_2').'/'.$this->config->item('tieudiem24_news_id_text_2')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem24_news_img_thumb_2'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem24_news_title_2')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }
				$tieudiem33_news_id_1 = $this->config->item('tieudiem33_news_id_1');
				$tieudiem10_news_id_1 = $this->config->item('tieudiem10_news_id_1');
				if(!empty($tieudiem33_news_id_1) || !empty($tieudiem10_news_id_1)){
			?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#fff">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						$tieudiem33_news_id_1 = $this->config->item('tieudiem33_news_id_1');
						if(!empty($tieudiem33_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem33_news_id_cattext_1').'/'.$this->config->item('tieudiem33_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem33_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem33_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						$tieudiem10_news_id_1 = $this->config->item('tieudiem10_news_id_1');
						if(!empty($tieudiem10_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem10_news_id_cattext_1').'/'.$this->config->item('tieudiem10_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem10_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem10_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }
				$tieudiem48_news_id_1 = $this->config->item('tieudiem48_news_id_1');
				$tieudiem34_news_id_1 = $this->config->item('tieudiem34_news_id_1');
				if(!empty($tieudiem48_news_id_1) || !empty($tieudiem34_news_id_1)){
			?>
			<div style="height:120px; width: 280px;  padding:5px; overflow:hidden; float:left; background:#feecec">
				<div style="height: 130px; width:130px;float:left; overflow:hidden">
					<?php 
						$tieudiem48_news_id_1 = $this->config->item('tieudiem48_news_id_1');
						if(!empty($tieudiem48_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem48_news_id_cattext_1').'/'.$this->config->item('tieudiem48_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem48_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem48_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
				<div style="height: 130px; width:130px; margin-left:10px;float:left; overflow:hidden">
					<?php 
						$tieudiem34_news_id_1 = $this->config->item('tieudiem34_news_id_1');
						if(!empty($tieudiem34_news_id_1)){
							$url = '<a href="'.site_url('news/'.$this->config->item('tieudiem34_news_id_cattext_1').'/'.$this->config->item('tieudiem34_news_id_text_1')).'" >';
							echo '<center><p>'.$url.showIMG($this->config->item('tieudiem34_news_img_thumb_1'), 117, 79,"","","img_tieudiem").'</a></p></center>';
							echo '<p>'.$url.word_limiter(stripslashes($this->config->item('tieudiem34_news_title_1')), 7).'</a></p>';
		
						}
					?>
				</div>
			</div>
			<?php }?>
		</div>
		<div id="d6"  style="width:300px;height:130px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d6'));?></div>
		<div id="d7"  style="width:300px;height:130px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d7'));?></div>
		<div id="d8"  style="width:300px;height:130px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d8'));?></div>
		<div id="d9"  style="width:300px;height:130px;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d9'));?></div>
	</div>
	<div class="clear"></div>
	<div id="d10"  style="width:980px;height:90px;margin:0 auto 5px auto;overflow:hidden" class="qcao marbottom5" align="center"><?=showAd($this->config->item('qc_d10'));?></div>
	</div>
</div>
<script language="javascript">
$(document).ready(function(){
		$('#swap').click(function(){
			$.get('<?=site_url('swapcaptcha/swap')?>', function(mess){
					$("#captcha").html(mess).show("fast");
			});
		});
})
</script>

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
var speed9=images9=types9=links9=0;
var speed10=images10=types10=links10=0;
var urlimg ='<?=base_url();?>';
var urllink ='<?=base_url();?>qlqc/click.php?qc=';
</script>
<script type="text/javascript" src="<?=$js;?>adlib_detail.js"></script>
<script type="text/javascript" language="javascript">
swapAd('d1');swapAd('d2');swapAd('d3');swapAd('d4');swapAd('d5');swapAd('d6');swapAd('d7');swapAd('d8');swapAd('d9');swapAd('d10');
</script>