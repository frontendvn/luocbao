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
 <div style="border:dashed thin;height:60px;width:700px" id="c_1" class="column"> banner
   <?php if(is_object($c_1) && $c_1->num_rows()>0){
						foreach($c_1->result() as $row){
							$c_1_nid = $row->id;
							$c_1_blocks_id = $row->blocks_id;
							$c_1_title = $row->title;
							$c_1_mota = $row->mota;
							echo '<div class="portlet"  id="'.$c_1_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$c_1_title.'</div>';
							echo '		<div class="portlet-content">'.$c_1_mota.'</div>';
							echo '	</div>';
						}
					}?>
 </div>

 <div id="main">
  <!--main-->
  <!--left-->
  <div style="width:540px;float:left;" >
   <!--quang cao-->
   <div class="column" style="margin-top:15px;width:520px;border:dashed thin;height:50px;padding:5px" id="c_2" >quảng cáo 
   <?php if(is_object($c_2) && $c_2->num_rows()>0){
						foreach($c_2->result() as $row){
							$c_2_nid = $row->id;
							$c_2_blocks_id = $row->blocks_id;
							$c_2_title = $row->title;
							$c_2_mota = $row->mota;
							echo '<div class="portlet"  id="'.$c_2_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$c_2_title.'</div>';
							echo '		<div class="portlet-content">'.$c_2_mota.'</div>';
							echo '	</div>';
						}
					}?>
    </div>
   <div style="clear:both;border:solid thin;margin-top:100px;min-height:100px;width:530px">  nội dung  </div>
  </div>
  <!--right-->
  <div style="border:dashed thin;margin-left:0px;width:150px;float:left;margin-top:10px;min-height:300px;" id="c_3" class="column">
   <?php if(is_object($c_3) && $c_3->num_rows()>0){
						foreach($c_3->result() as $row){
							$c_3_nid = $row->id;
							$c_3_blocks_id = $row->blocks_id;
							$c_3_title = $row->title;
							$c_3_mota = $row->mota;
							echo '<div class="portlet"  id="'.$c_3_blocks_id.'">';
							echo '		<div class="portlet-header" >'.$c_3_title.'</div>';
							echo '		<div class="portlet-content">'.$c_3_mota.'</div>';
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
		
	$("#c_1").sortable({ 
		connectWith: ['#c_1']
	});
	$("#c_2").sortable({ 
		connectWith: ['#c_2'] 
	});
	$("#c_3").sortable({ 
		connectWith:['#c_3']
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
		c1 = $('#c_1').sortable('toArray');
		c2 = $('#c_2').sortable('toArray');
		c3 = $('#c_3').sortable('toArray');
		
		$.ajax({
			url: '<?=site_url()?>' + '/cfhome/save_cfcat',
			type: 'POST',
			data: 'c1='+c1 + '&' +'c2='+c2 + '&' +'c3='+c3,
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
