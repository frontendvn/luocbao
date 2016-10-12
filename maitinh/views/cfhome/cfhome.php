<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');

?>
<script type="text/javascript"  src="<?=$js;?>jquery.js"></script>

<div id="loading" style="border: 1px solid rgb(253, 183, 53); padding: 10px; background-color: rgb(233, 255, 239);display:none"> Lưu cấu hình thành  công</div>
<!--default blocks-->
<div class="column" id="default" style="float:left;border:dashed thin;min-height:50px">
 <label><strong>Block có sẵn</strong></label>
 <?php if(is_object($blocks_default) && $blocks_default->num_rows()>0){
			foreach($blocks_default->result() as $row){
				$nid = $row->id;
				$title = $row->title;
				$mota = $row->mota;
				echo '<div class="portlet"  id="'.$nid.'">';
				echo '		<div class="portlet-header" >'.$title.'</div>';
				echo '		<div class="portlet-content">'.$mota.'</div>';
				echo '	</div>';
			}
		}?>
	
</div>
<!--config home-->
<div style="width:700px;float:left;margin-left:7px">
 <div style="border:dashed thin;height:60px;width:700px" id="h_1" class="column"> banner
   <?php if(is_object($h_1) && $h_1->num_rows()>0){
						foreach($h_1->result() as $row){
							$h_1_nid = $row->id;
							$h_1_blocks_id = $row->blocks_id;
							$h_1_title = $row->title;
							$h_1_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_1_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_1_title.'</div>';
							echo '		<div class="portlet-content">'.$h_1_mota.'</div>';
							echo '	</div>';
						}
					}?>
 </div>

 <div id="main">
  <!--main-->
  <!--left-->
  <div style="width:540px;float:left;" id="left">
   <div  style="clear:both;margin-top:15px;width:520px;border:solid thin;height:50px;padding:5px" >Bản tin
   <form method="post"><?php $string =read_file('../cfg/hotnews.php');?>
   		Nhập id_news <input type="text" name="hotnews" value="<?php echo load_db_config('hotnews');?>" size="20"/>  <em>(phân biệt bằng dấu ","  vd: 2,3,4)</em>
		<input type="submit" name="btn" value="luu"/></form>
   </div>
   <!--quang cao-->
   <div class="column" style="clear:both;margin-top:15px;width:520px;border:dashed thin;height:50px;padding:5px" id="h_2" > quảng cáo
  	<?php if(is_object($h_2) && $h_2->num_rows()>0){
						foreach($h_2->result() as $row){
							$h_2_nid = $row->id;
							$h_2_blocks_id = $row->blocks_id;
							$h_2_title = $row->title;
							$h_2_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_2_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_2_title.'</div>';
							echo '		<div class="portlet-content">'.$h_2_mota.'</div>';
							echo '	</div>';
						}
					}?>
   </div>
   <div style="clear:both" id="left">
    <div class="column" id="h_3" style="border:dashed thin;margin-top:7px;min-height:50px;width:260px" >
     <?php if(is_object($h_3) && $h_3->num_rows()>0){
						foreach($h_3->result() as $row){
							$h_3_nid = $row->id;
							$h_3_blocks_id = $row->blocks_id;
							$h_3_title = $row->title;
							$h_3_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_3_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_3_title.'</div>';
							echo '		<div class="portlet-content">'.$h_3_mota.'</div>';
							echo '	</div>';
						}
					}?>
    </div>
    <div class="column" id="h_4"  style="border:dashed thin;margin:7px;min-height:50px;width:260px" >
    <?php if(is_object($h_4) && $h_4->num_rows()>0){
						foreach($h_4->result() as $row){
							$h_4_nid = $row->id;
							$h_4_blocks_id = $row->blocks_id;
							$h_4_title = $row->title;
							$h_4_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_4_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_4_title.'</div>';
							echo '		<div class="portlet-content">'.$h_4_mota.'</div>';
							echo '	</div>';
						}
					}?>
    </div>
   </div>
   
   <div class="column" id="h_5"  style="clear:both;border:dashed thin;margin-top:7px;min-height:50px;width:530px">
    <?php if(is_object($h_5) && $h_5->num_rows()>0){
						foreach($h_5->result() as $row){
							$h_5_nid = $row->id;
							$h_5_blocks_id = $row->blocks_id;
							$h_5_title = $row->title;
							$h_5_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_5_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_5_title.'</div>';
							echo '		<div class="portlet-content">'.$h_5_mota.'</div>';
							echo '	</div>';
						}
					}?>
    </div>
  </div>
  <!--right-->
  <div style="border:dashed thin;margin-left:0px;width:150px;float:left;margin-top:10px;min-height:300px;" id="h_6" class="column">
   <?php if(is_object($h_6) && $h_6->num_rows()>0){
						foreach($h_6->result() as $row){
							$h_6_nid = $row->id;
							$h_6_blocks_id = $row->blocks_id;
							$h_6_title = $row->title;
							$h_6_mota = $row->mota;
							echo '<div class="portlet"  id="'.$h_6_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$h_6_title.'</div>';
							echo '		<div class="portlet-content">'.$h_6_mota.'</div>';
							echo '	</div>';
						}
					}?>
  </div>
 </div>
 <div style="float:left;clear:both">
  <input name="submit" id="submit" type="submit" class="button-secondary" value="Lưu thay đổi" />
 </div>
</div>
<style type="text/css">
	.column { width: 170px; float: left; background:#F4F4F4}
	
	.portlet { margin:2px; margin-top:0}
	.portlet-header { margin: 0; padding: 5x; font-size:12px; }
	.portlet-header .ui-icon { float: right; }
	.portlet-content { padding: 5px; font-size:10px; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
	</style>
<script type="text/javascript">
	$(function() {
		$(".column").sortable({
			connectWith: '.column'
		});
		
	$("#h_1").sortable({ 
		connectWith: ['#h_1']
	});
	$("#h_2").sortable({ 
		connectWith: ['#h_2'] 
	});
	$("#h_3").sortable({ 
		connectWith:['#h_3']
	});
	$("#h_4").sortable({ 
		connectWith: ['#h_4'] 
	});
	$("#h_5").sortable({ 
		connectWith:['#h_5']
	});
	$("#h_6").sortable({ 
		connectWith:['#h_6']
	});
		$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
			.find(".portlet-header")
				.addClass("ui-widget-header ui-corner-all")
				.prepend('<span class="ui-icon ui-icon-plusthick"></span>')
				.end()
			.find(".portlet-content");

		$(".portlet-header .ui-icon").click(function() {
			$(this).toggleClass("ui-icon-minusthick");
			$(this).parents(".portlet:first").find(".portlet-content").toggle();
		});

	
		$('#submit').click(function() {
		h1 = $('#h_1').sortable('toArray');
		h2 = $('#h_2').sortable('toArray');
		h3 = $('#h_3').sortable('toArray');
		h4= $('#h_4').sortable('toArray');
		h5 = $('#h_5').sortable('toArray');
		h6 = $('#h_6').sortable('toArray');
		$.ajax({
			url: '<?=site_url()?>' + '/cfhome/save_cfhome',
			type: 'POST',
			data: 'h1='+h1 + '&' +'h2='+h2 + '&' +'h3='+h3+ '&' +'h4='+h4 + '&' +'h5='+h5 + '&' +'h6='+h6,
			 success: function(msg){
			$('#loading').show("fast");
			}
		});
		});	$(".column").disableSelection();
		
	});
	
	</script>
<link type="text/css" href="<?=$js?>themes/base/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="<?=$js?>jquery-1.3.2.js"></script>
<script type="text/javascript" src="<?=$js?>ui.core.js"></script>
<script type="text/javascript" src="<?=$js?>ui.sortable.js"></script>
