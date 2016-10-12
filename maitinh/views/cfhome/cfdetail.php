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
 <div style="border:dashed thin;height:60px;width:700px" id="d_1" class="column"> banner
   <?php if(is_object($d_1) && $d_1->num_rows()>0){
						foreach($d_1->result() as $row){
							$d_1_nid = $row->id;
							$d_1_blocks_id = $row->blocks_id;
							$d_1_title = $row->title;
							$d_1_mota = $row->mota;
							echo '<div class="portlet"  id="'.$d_1_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$d_1_title.'</div>';
							echo '		<div class="portlet-content">'.$d_1_mota.'</div>';
							echo '	</div>';
						}
					}?>
 </div>

 <div id="main">
  <!--main-->
  <!--left-->
  <div style="width:540px;float:left;" >
   <!--quang cao-->
   <div class="column" style="margin-top:15px;width:520px;border:dashed thin;height:50px;padding:5px" id="d_2" >quảng cáo 
   <?php if(is_object($d_2) && $d_2->num_rows()>0){
						foreach($d_2->result() as $row){
							$d_2_nid = $row->id;
							$d_2_blocks_id = $row->blocks_id;
							$d_2_title = $row->title;
							$d_2_mota = $row->mota;
							echo '<div class="portlet"  id="'.$d_2_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$d_2_title.'</div>';
							echo '		<div class="portlet-content">'.$d_2_mota.'</div>';
							echo '	</div>';
						}
					}?>
    </div>
   <div style="clear:both;border:solid thin;margin-top:100px;min-height:100px;width:530px">  nội dung  </div>
  </div>
  <!--right-->
  <div style="border:dashed thin;margin-left:0px;width:150px;float:left;margin-top:10px;min-height:300px;" id="d_3" class="column">
   <?php if(is_object($d_3) && $d_3->num_rows()>0){
						foreach($d_3->result() as $row){
							$d_3_nid = $row->id;
							$d_3_blocks_id = $row->blocks_id;
							$d_3_title = $row->title;
							$d_3_mota = $row->mota;
							echo '<div class="portlet"  id="'.$d_3_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$d_3_title.'</div>';
							echo '		<div class="portlet-content">'.$d_3_mota.'</div>';
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
		
	$("#d_1").sortable({ 
		connectWith: ['#d_1']
	});
	$("#d_2").sortable({ 
		connectWith: ['#d_2'] 
	});
	$("#d_3").sortable({ 
		connectWith:['#d_3']
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
		d1 = $('#d_1').sortable('toArray');
		d2 = $('#d_2').sortable('toArray');
		d3 = $('#d_3').sortable('toArray');
		
		$.ajax({
			url: '<?=site_url()?>' + '/cfhome/save_cfdetail',
			type: 'POST',
			data: 'd1='+d1 + '&' +'d2='+d2 + '&' +'d3='+d3,
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
