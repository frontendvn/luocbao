<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
+--------------------------------*/

$config['view_dir'] = 'quangcao/'; // system/application/views/ncat/
$config['resource_dir'] = '/';
$config['uri_home'] = "";
$config['menu_title'] = "Quảng cáo";
/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 80;
$config['num_links'] = 10;

/*-------------------------------+
|  UPLOAD IMAGE                  |
+--------------------------------*/
$config['img_upload'] 		= "../uploads/quangcao/";
$config['img_type'] 	= "gif|jpg|png|swf";
$config['img_size'] 	= "2048";
$config['img_width']  = "800";
$config['img_height'] = "600";
//$config['img_name_encrypt'] = "TRUE";

/*-------------------------------+
|  Other config                  |
+--------------------------------*/
$config['menu'][] = array('name'=>'Thêm mới quảng cáo', 'link'=>'quangcao/add', 'icon'=>'');
$config['menu'][] = array('name'=>'Danh sách quảng cáo', 'link'=>'quangcao/lists', 'icon'=>'');
$config['menu'][] = array('name'=>'Cập nhật quảng cáo KH', 'link'=>'quangcao/save', 'icon'=>'');
$config['menu'][] = array('name'=>'Cập nhật QC mặc định', 'link'=>'quangcao/temp', 'icon'=>'');
$config['menu'][] = array('name'=>'Vị trí', 'link'=>'vitri', 'icon'=>'');
$config['menu'][] = array('name'=>'Khách hàng', 'link'=>'khachhang', 'icon'=>'');

$type[''] ="- Chọn -";
$type['I'] ="Hình";
$type['F'] ="Flash";
$config['type'] = $type;

$shown['Y'] ="Hiển thị";
$shown['N'] ="Tạm ngưng";
$config['shown'] = $shown;
?>