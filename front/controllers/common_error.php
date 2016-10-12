<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class common_error extends Controller {
var $mod = 'common_error';
	function common_error()
	{
		parent::Controller();	
		//
		$this->view_dir = '/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'';
		// select page layout
		$this->view_container = 'container';
		$this->session->set_userdata('previous_url', $this->uri->uri_string());
		$this->funtion_title = 'Có lỗi';
		
	}
	
	function index()
	{
		$data['title'] = "Có lỗi, chưa xác định nguyên nhân.";
		$data['message'] = "Có lỗi! Nội dung bạn muốn xem không thể kết xuất được, vui lòng báo lại với BQT để khắc phục. Chân thành cám ơn.";
		$this->load->vars($data);
		$this->load->view($this->view_dir.'error');
	}
	function e404()
	{
		$data['title'] = "Có lỗi hoặc nội dung bạn đang tìm kiếm không tồn tại.";
		$data['message'] = "Xin lỗi, nội dung bạn truy vấn không có trên website này.";
		$this->load->vars($data);
		$this->load->view($this->view_dir.'error');
	}
	function edb()
	{
		$data['title'] = "Có vấn đề với cơ sở dữ liệu.";
		$data['message'] = "Truy vấn cơ sở dữ liệu gặp trục trặc, xin thông báo lỗi cho quản trị viên. Xin cám ơn";
		$this->load->vars($data);
		$this->load->view($this->view_dir.'error');
	}
	function egeneral()
	{
		$data['title'] = "Có lỗi, chưa xác định nguyên nhân.";
		$data['message'] = "Xin báo lại với quản trị viên đường dẫn gây lỗi. Chân thành cảm ơn";
		$this->load->vars($data);
		$this->load->view($this->view_dir.'error');
	}
	function ephp()
	{
		$data['title'] = "Có lỗi code.";
		$data['message'] = "Hệ thống gặp phải lỗi code hoặc trục trặc từ phía server. Xin thông báo với quản trị viên qua phần liên hệ";
		$this->load->vars($data);
		$this->load->view($this->view_dir.'error');
	}
}

?>