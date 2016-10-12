<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir'); 
?>
<link type="text/css" href="<?=$js?>themes/base/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="<?=$js?>ui.datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#date").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy"
	});
})
</script>
<form method="post" action="<?=site_url($this->mod.'/edit/'.$id);?>" enctype="multipart/form-data">
<div class="postbox close">
	<div class="inside">
		<table class="tableborder"  cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class="maintitle"><strong>Hiệu chỉnh quảng cáo  </strong></td>
			<td align="right" class="maintitle"><?=anchor($this->mod.'/add','Thêm mới')?></td>
		</tr>
		<tr>
			<td colspan="2" class="tdrow2"><strong>Lưu ý: Nếu là quảng cáo mặc định các mục chủ đề, ngày hết hạn, khách hàng, số giây hiển thị có thể bỏ qua<br />
			Quảng cáo mẫu chỉ dành cho các vị trí thuộc chủ đề và trang xem chi tiết
			</strong></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên quảng cáo <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="ten" value="<?=$ten?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Loại <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=form_dropdown('types', $this->config->item('type'), $types)?></td>
		</tr>
		<tr>
			<td class="tdrow1">Link website <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="link" value="<?=$link?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Vị trí <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=$vitri?></td>
		</tr>
		<tr>
			<td class="tdrow1">Chủ đề </td>
			<td class="tdrow1"><?=$chude;?></td>
		</tr>
		<tr>
			<td class="tdrow1">Upload hình </td>
			<td class="tdrow1">
			<input type="file" name="userfile" value="" size="40" />&nbsp;chỉ hỗ trợ <?=str_replace('|', ', ',$this->config->item('img_type'))?>.
			<br />hoặc link&nbsp;
			<?php $pos = strpos($image, 'http://');
						echo $link_img = $pos===false?'<input type="text" size="42" name="link_img" value="" />':'<input type="text" size="42" name="link_img" value="'.$image.'" />';
						$path = $pos===false?'../'.$image:$image;
						echo '<br />'.showIMG($path,150);?></td>
		</tr>
		<tr>
			<td class="tdrow1">Ngày hết hạn</td>
			<td class="tdrow1"><input type="text" name="ngay_hethan" value="<?=empty($ngay_hethan)?'':date('d/m/Y', $ngay_hethan)?>" size="10" id="date" />&nbsp;(dd/mm/yyyy) Nếu là vô thời hạn thì để trống.</td>
		</tr>
		<tr>
			<td class="tdrow1">Khách hàng <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=$select_kh?></td>
		</tr>
		<tr>
			<td class="tdrow1">Trạng thái <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=form_dropdown('shown', $this->config->item('shown'), $shown)?></td>
		</tr>
		<tr>
			<td class="tdrow1">Số giây hiển thị </td>
			<td class="tdrow1"><input type="text" name="tg_hienthi" value="<?=$tg_hienthi?>" size="10" /> (millisec)</td>
		</tr>
		<tr>
		   <td class="tdrow1">QC mặc định</td>
		   <td class="tdrow1"><?php $temp = ($temp==1)?'checked="checked"':"";?>
			<label><input type="checkbox" name="temp" value="1" <?=$temp;?> />  </label>
		  </tr>
		<tr class="tdrow1">
			<td align="right">&nbsp;</td>
			<td align="left"><input type="hidden" name="id" value="<?=$id?>"/><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

