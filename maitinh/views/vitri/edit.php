<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
?>
<form method="post" action="<?=site_url($this->mod.'/edit/'.$id);?>">
<div class="postbox close">
	<div class="inside">
		<table class="tableborder"  cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class="maintitle" colspan="2"><strong>Hiệu chỉnh vị trí</strong></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên vị trí <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="ten_vt" value="<?=$ten_vt?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1" ><span style="color:#FF0000">*</span>Kích thước</td>
			<td class="tdrow1">
				<input type="text" name="ngang" value="<?=$ngang?>" size="4" /> x 
				<input type="text" name="doc" value="<?=$doc?>" size="4" />
			</td>
		</tr>
		<tr class="tdrow1">
			<td align="right">&nbsp;</td>
			<td align="left"><input type="hidden" name="id" value="<?=$id?>"/><input type="submit" name="save" value="Lưu lại" id="button" /></td>
		</tr>
	</table>
	</div>
</div>
</form>


<table>
	<tr>
		<td><?php $this->load->view($this->view_dir.'list');?></td>
		<td style="padding-left:10px;padding-top:20px" valign="top">
		<div id="loading" style="border: 1px solid rgb(253, 183, 53); padding: 10px; background-color: rgb(233, 255, 239);display:none; margin-top:10px">Lưu cấu hình thành  công</div>
		<div style="width:150px;margin-left:0px">
 <div id="main">
  <!--right-->
  <div style="border:dashed thin;width:150px;min-height:170px;" id="list1" class="column">
   <?php if($list){
			foreach($list->result() as $row){
				$id = $row->id;
				$weight = $row->weight;
				$title = $row->ten;
				$anchor_edit = anchor('quangcao/edit/'.$id, '[hiệu chỉnh]', array('title' => 'Hiệu chỉnh'));
				echo '<div class="portlet" id="'.$id.'">';
				echo '	<div class="portlet-header">'.$title.'</div>';
				echo '	<div class="portlet-content">'.$anchor_edit.'</div>';
				echo '</div>';
			}
		}?>
  </div>
 </div>
 <div style="float:left;clear:both; margin-top:10px;">
  <input name="submit" id="submit" type="submit" class="button-secondary" value="Lưu thay đổi" />
 </div>
</div></td>
	</tr>
</table>


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
	$("#list1").sortable({ 
		connectWith: ['#list1'] 
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
		list1 = $('#list1').sortable('toArray');
		$.ajax({
			url: '<?=site_url()?>' + '/vitri/sorts',
			type: 'POST',
			data: 'list1='+list1,
			success: function(msg){
			$('#loading').show("fast");
			
			}
		});
	});	
	$(".column").disableSelection();
	
});
</script>
<link type="text/css" href="<?=$js?>themes/base/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="<?=$js?>jquery-1.3.2.js"></script>
<script type="text/javascript" src="<?=$js?>ui.core.js"></script>
<script type="text/javascript" src="<?=$js?>ui.sortable.js"></script>
<script type="text/javascript" src="<?=$js?>ui.selectable.js"></script>