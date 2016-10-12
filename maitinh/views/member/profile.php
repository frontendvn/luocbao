<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
?>
<script type="text/javascript" src="<?=$js?>member/check_profileform.js"></script>
	<div id="flashMessage"><?php 	echo $message.$this->session->flashdata('message');?></div>
<?php
	$vl_fullname = $load['fullname'];
	$vl_description = $load['description'];
	$vl_name = $load['name'];
	$vl_email = $load['email'];
	$vl_code = $load['code'];
	
	$ar_content = explode('~', $load['content']);
	
	$vl_menu = $ar_content[0];
	$vl_color = $ar_content[1];
	
	switch($vl_menu)
	{
		case 1: $menu_ck1 = TRUE; $menu_ck2 = FALSE; $menu_ck3 = FALSE;
			break;
		case 2: $menu_ck1 = FALSE; $menu_ck2 = TRUE; $menu_ck3 = FALSE;
			break;
		case 3: $menu_ck1 = FALSE; $menu_ck2 = FALSE; $menu_ck3 = TRUE;
			break;
		default: $menu_ck1 = TRUE; $menu_ck2 = FALSE; $menu_ck3 = FALSE;
	}
	
	switch($vl_color)
	{
		case 1: $color_ck1 = TRUE; $color_ck2 = FALSE; $color_ck3 = FALSE;
			break;
		case 2: $color_ck1 = FALSE; $color_ck2 = TRUE; $color_ck3 = FALSE;
			break;
		case 3: $color_ck1 = FALSE; $color_ck2 = FALSE; $color_ck3 = TRUE;
			break;
		default: $color_ck1 = TRUE; $color_ck2 = FALSE; $color_ck3 = FALSE;
	}

	$attributes = array('onsubmit' => 'return checkProfileForm(this);');
	echo form_open($this->mod.'/profile', $attributes);
?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr>
			<td colspan="2" class="maintitle">Hiệu chỉnh thông tin tài khoản</td>
		</tr>
		<tr>
			<td class="tdrow1">Họ tên *</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'fullname','size'=>'40','id'=>'fullname','maxlength'=>'40'), set_value('fullname', $vl_fullname)).form_error('fullname'); ?></td>
		</tr>
		<tr>
			<td class="tdrow1">Thông tin khác</td>
			<td class="tdrow1"><?php echo form_textarea(array('name'=>'description','cols'=>'40','id'=>'description','rows'=>'5'), set_value('description', $vl_description)).form_error('description');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Email</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'email','size'=>'40','id'=>'email'), set_value('email', $vl_email)).form_error('email');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Code</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'code','size'=>'40','id'=>'code','readonly'=>'readonly'), set_value('code', $vl_code)).form_error('code');?></td>
		</tr>
		<tr>
			<td class="tdrow1">Loại thành viên</td>
			<td class="tdrow1"><?php echo form_input(array('name'=>'name','size'=>'40','id'=>'name','readonly'=>'readonly'), set_value('name', $vl_name)).form_error('name');?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
	<!--<br />
	<form method="post" action="<?php echo site_url($this->mod.'/option')?>">
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder">
		<tr>
			<td colspan="2" class="maintitle">Tùy chỉnh</td>
		</tr>
		<tr>
			<td class="tdrow1">Kiểu menu</td>
			<td class="tdrow1"><?php echo '<label>Ngang '.form_radio(array('name'=>'menu','id'=>'menu1','value'=>'1','checked'=>$menu_ck1)).'</label> <label>Dọc '.form_radio(array('name'=>'menu','id'=>'menu2','value'=>'2','checked'=>$menu_ck2)).'</label> <label>Cả hai '.form_radio(array('name'=>'menu','id'=>'menu3','value'=>'3','checked'=>$menu_ck3)).'</label>'.form_error('menu')?></td>
		</tr>
		<tr>
			<td class="tdrow1">Màu nền</td>
			<td class="tdrow1"><?php echo '<label>Trắng '.form_radio(array('name'=>'color','id'=>'color1','value'=>'1','checked'=>$color_ck1)).'</label> <label>Xanh '.form_radio(array('name'=>'color','id'=>'color2','value'=>'2','checked'=>$color_ck2)).'</label> <label>Vàng '.form_radio(array('name'=>'color','id'=>'color3','value'=>'3','checked'=>$color_ck3)).'</label>'.form_error('color')?></td>
		</tr>
		<tr>
			<td class="tdrow1" colspan="2"><?php echo form_submit('btnsubmit', 'Lưu lại');?></td>
		</tr>
	</table>
	</form>-->