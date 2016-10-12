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
<form method="post" action="<?=site_url($this->mod.'/add');?>" enctype="multipart/form-data">
<div class="postbox close">
	<div class="inside">
		<table class="tableborder"  cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" class="maintitle"><strong>Tạo Quảng Cáo Mới </strong></td>
		</tr>
		<tr>
			<td colspan="2" class="tdrow2"><strong>Lưu ý: Nếu là quảng cáo mặc định các mục chủ đề, ngày hết hạn, khách hàng, số giây hiển thị có thể bỏ qua<br />
			Quảng cáo mẫu chỉ dành cho các vị trí thuộc chủ đề và trang xem chi tiết
			</strong></td>
		</tr>
		<tr>
			<td class="tdrow1">Tên quảng cáo <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="ten" value="<?=$this->input->post('ten')?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Loại <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=form_dropdown('types', $this->config->item('type'), $this->input->post('types'))?></td>
		</tr>
		<tr>
			<td class="tdrow1">Link website <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><input type="text" name="link" value="<?=$this->input->post('link')?>" size="50" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Vị trí <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=$vitri?></td>
		</tr>
		<tr>
			<td class="tdrow1">Chủ đề </td>
			<td class="tdrow1"><div style="overflow:auto;float:left;width:500px;">
			<?php 
				$show_chude = $this->pmod->show_chude();
				if(is_object($show_chude) && $show_chude->num_rows()>0){
				$nums = $show_chude->num_rows();
				$i=0;
				foreach($show_chude->result_array() as $row)
				{
					$id_cattext 	= $row['id_cattext'];
					$nwc_name 		= $row['nwc_name'];
					$data = array(
												'name'        => 'id_cattext[]',
												'value'       => $id_cattext
												);
					$i++;
					$br = ($i%2==0)?'style="float:left;width:200px;"':' style="float:right;width:200px;"';
					echo "<div $br>".form_checkbox($data)."&nbsp;".$nwc_name."</div>";
				}
			}
			  ?>
  			</div></td>
		</tr>
		<tr>
			<td class="tdrow1">Upload hình </td>
			<td class="tdrow1"><input type="file" name="userfile" value="" size="40" />&nbsp;chỉ hỗ trợ <?=str_replace('|', ', ',$this->config->item('img_type'))?>.<br />hoặc link&nbsp;<input type="text" size="42" name="link_img" id="link_img" value="<?=$this->input->post('link_img')?>" /></td>
		</tr>
		<tr>
			<td class="tdrow1">Ngày hết hạn</td>
			<td class="tdrow1"><input type="text" name="ngay_hethan" value="<?=$this->input->post('ngay_hethan')?>" size="10" id="date" />&nbsp;(dd/mm/yyyy). Nếu là vô thời hạn thì để trống.</td>
		</tr>
		<tr>
			<td class="tdrow1">Khách hàng <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=$select_kh?></td>
		</tr>
		<tr>
			<td class="tdrow1">Trạng thái <span style="color:#FF0000">*</span></td>
			<td class="tdrow1"><?=form_dropdown('shown', $this->config->item('shown'), $this->input->post('shown'))?></td>
		</tr>
		<tr>
			<td class="tdrow1">Số giây hiển thị </td>
			<td class="tdrow1"><input type="text" name="tg_hienthi" value="12000" size="10" /> (millisec)</td>
		</tr>
		<tr>
		   <td class="tdrow1">QC mặc định</td>
		   <td class="tdrow1">
			<label><input type="checkbox" name="temp" value="1" />  </label>
		</tr>
		<tr class="tdrow1">
			<td align="right">&nbsp;</td>
			<td ><input type="submit" name="save" value="Lưu lại" id="button"  /></td>
		</tr>
	</table>
	</div>
</div>
</form>

