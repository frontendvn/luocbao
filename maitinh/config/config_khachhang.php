<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
+--------------------------------*/

$config['view_dir'] = 'khachhang/'; // system/application/views/khachhang/
$config['resource_dir'] = '/';
$config['uri_home'] = "";
$config['menu_title'] = "Khách hàng";
/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 20;
$config['num_links'] = 10;

/*-------------------------------+
|  Other config                  |
+--------------------------------*/
$config['menu'][] = array('name'=>'Thêm mới quảng cáo', 'link'=>'quangcao/add', 'icon'=>'');
$config['menu'][] = array('name'=>'Danh sách quảng cáo', 'link'=>'quangcao/lists', 'icon'=>'');
$config['menu'][] = array('name'=>'Cập nhật quảng cáo KH', 'link'=>'quangcao/save', 'icon'=>'');
$config['menu'][] = array('name'=>'Cập nhật QC mặc định', 'link'=>'quangcao/temp', 'icon'=>'');
$config['menu'][] = array('name'=>'Vị trí', 'link'=>'vitri', 'icon'=>'');
$config['menu'][] = array('name'=>'Khách hàng', 'link'=>'khachhang', 'icon'=>'');?>