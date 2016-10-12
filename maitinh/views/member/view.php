<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$url 	= base_url();
	$css	= $url.$this->config->item('css_dir'); 
	$js		= $url.$this->config->item('js_dir'); 
	$img 	= $url.$this->config->item('img_dir');
	$option = $this->config->item('level');
	$view_img = "<img border=\"0\" title=\"\" src=\"".$img."icons/small/report1_16x16.gif\" />";
	if($this->id==$info['id'])
	{
		$light = false;
	}
	else
	{
		$light = true;
	}
	$activated = $info['activated']=='y'?'Đã kích hoạt':'Đã khóa';
	
	$diradmin = empty($info['teamleader'])?$info['dir_admin']:$info['teamleader'];
	$rs = $this->member_model->view_user($diradmin);
	$report_to = $rs? $rs->fullname.' ('.$rs->code.')':"No name";
	$anc_report_to = $rs? anchor('member/view/'.$diradmin, $report_to, array('title' => 'Xem thông tin')):$report_to;
	$view_log = $this->accesslvl==1?anchor($this->mod.'/view_log/'.$info['id'], $view_img, array('title' => "view logs")) : "";
?>
	<div id="flashMessage"><?php echo $message.$this->session->flashdata('message');?></div>
	<form method="post">
	<table border="0" cellpadding="0" cellspacing="0" class="tableborder" width="800">
		<tr>
			<td colspan="8" class="maintitle">Thông tin thành viên <?php echo $select_box?> <span style="float:right"><?php echo $view_log?></span></td>
		</tr>
		<tr>
			<td class="tdrow3">Họ tên</td>
			<td class="tdrow3">Loại thành viên</td>
			<td class="tdrow3">Tên đăng nhập</td>
			<td class="tdrow3">Email</td>
			<td class="tdrow3">Code</td>
			<td class="tdrow3">Thông tin thêm</td>
			<td class="tdrow3">Trạng thái tài khoản</td>
			<td class="tdrow3">Quản lý</td>
		</tr>
		<tr>
			<td class="tdrow1"><?php echo $info['fullname'];?></td>
			<td class="tdrow1"><?php echo $info['usertype'];?></td>
			<td class="tdrow1"><?php echo $info['username'];?></td>
			<td class="tdrow1"><?php echo $info['email'];?></td>
			<td class="tdrow1"><?php echo $info['code'];?></td>
			<td class="tdrow1"><?php echo $info['description'];?></td>
			<td class="tdrow1"><?php echo $activated;?></td>
			<td class="tdrow1"><?php echo $anc_report_to;?></td>
		</tr>
	</table>
	</form>