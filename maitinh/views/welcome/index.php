<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$url		= base_url(); 
$img 		= $url.$this->config->item('img_dir');
$css		= $url.$this->config->item('css_dir');
$js 		= $url.$this->config->item('js_dir');
?>
<style>
#welcome_container{
	margin:10px;
	margin-left:30px;
	display:block;
	font-weight:bold;
	font-family:arial, tahoma;
	font-size:13px;
	font-weight:bold;
	color:#333333
}
#welcome_container a {
	
	color:#007ef3;
}
#welcome_container a:hover {
	color: #33CC33;
}
#welcome_container ul li{
	margin-left:50px;
	line-height:25px;
	width:250px;
}
#welcome_container ul li:hover{
	background-color:#FCFFC6;
}
#left_welcome{
	float:left;
	width:430px;
	margin-left:50px;
}
#right_welcome{
	float:left;
	width:400px;
}
.atest{background-color:#CCCCCC}
.btest{border:1px dashed #666}
.blocktit {
	-moz-box-shadow:-2px 2px 2px #C8C8C8;
	background:none repeat scroll 0 0 #DEF0FD;
	clear:both;
	color:#3E3E3E;
	font-size:15px;
	margin-bottom:5px;
	padding:5px 10px;
	text-align:left;
	width:300px;
}
</style>
<div id="welcome_container">
	<div id="left_welcome"><div class="blocktit">Nội dung</div>
		<ul>
			<li><a href="<?=site_url('ncat');?>">Chủ đề</a></li>
			<li><a href="<?=site_url('news');?>">Tin đã duyệt</a></li>
			<li><a href="<?=site_url('news/list_audit');?>">Tin chưa duyệt</a>
			<?php $audit = $this->db->query(" SELECT count(id_news) AS count_news FROM news WHERE news_audit!='1' AND news_delete!='1'");
			if(is_object($audit) && $audit->num_rows()>0)
			 	echo '( '.$audit->row()->count_news.' )';
			 else echo '';
			?>
			</li>
			<li><a href="<?=site_url('news/list_lead');?>">Tin nổi bật</a></li>
			<li><a href="<?=site_url('news/list_useful');?>">Tin hay</a></li>
			<li><a href="<?=site_url('news/add');?>">Thêm tin mới</a></li>
		</ul>
		<div class="clear"> </div>
		<div class="blocktit">Quản trị</div>
		<ul>
			<li><a href="<?=site_url('member/lists');?>">Danh sách thành viên</a></li>
			<li><a href="<?=site_url('member/create');?>">Thêm mới thành viên</a></li>
			<li><a href="<?=site_url('usertype');?>">Loại thành viên</a></li>
			<li><a href="<?=site_url('class_permit');?>">Quản lý module</a></li>
			<li><a href="<?=site_url('member/change_password');?>">Đổi mật khẩu</a></li>
		</ul>
		<div class="clear"> </div>
		
	</div>
	<div id="right_welcome" >
		<div class="blocktit">Tiện ích</div>
		<ul>
			<li><a href="<?=site_url('vote');?>">Thăm dò</a></li>
		</ul>
		<div class="clear"> </div>
		<div class="blocktit">Nhận xét</div>
			<ul>
				<li><a href="<?=site_url('comment/new_comment');?>">Nhận xét chưa xem</a>
				<?php $comment = $this->db->query(" SELECT count(id) AS count_comment FROM comment WHERE shown=0 ");
			if(is_object($comment) && $comment->num_rows()>0)
			 	echo '( '.$comment->row()->count_comment.' )';
			 else echo '';
			?>
				</li>
				<li><a href="<?=site_url('comment/lists');?>">Nhận xét đã xem</a></li>
			</ul>
		<div class="clear"> </div>
		<div class="blocktit">Quảng cáo</div>
		<ul>
			<li><a href="<?=site_url('quangcao/add');?>">Thêm mới quảng cáo</a></li>
			<li><a href="<?=site_url('quangcao/lists');?>">Danh sách quảng cáo</a></li>
			<li><a href="<?=site_url('quangcao/save');?>">Cập nhật quảng cáo</a></li>
			<li><a href="<?=site_url('khachhang');?>">Khách hàng</a></li>
			<li><a href="<?=site_url('vitri');?>">Vị trí</a></li>
		</ul>
		<div class="clear"> </div>
		<div class="blocktit">Thống kê truy cập</div>
		<?php 
			$total_users_online = $this->online_users->total_users_online(); 
			$total_visited_today = $this->online_users->total_visited_today(); 
			$total_visited = $this->online_users->total_visited_allday()+$total_visited_today;
		?>
		<ul>
			<li><?='<strong>Trực tuyến</strong>: '.$total_users_online;?></li>
			<li><?='<strong>Hôm nay</strong>: '.$total_visited_today;?></li>
			<li><?='<strong>Tổng truy cập</strong>: '.$total_visited;?></li>
		</ul>
		<div class="clear"> </div>
	</div>
</div>
