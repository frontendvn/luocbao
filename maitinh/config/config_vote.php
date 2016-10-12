<?php
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
+--------------------------------*/

// template directory
$config['view_dir'] = 'vote/'; // system/application/views/vote/

/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 20;
$config['num_links'] = 10;

/*-------------------------------+
|  UPLOAD IMAGE                  |
+--------------------------------*/
$config['img_upload'] 		= "../uploads/vote/";
$config['img_type'] 	= "gif|jpg|png";
$config['img_size'] 	= "300";
$config['img_width']  = "800";
$config['img_height'] = "600";
$config['img_name_encrypt'] = "TRUE";
/*-------------------------------+
|  UPLOAD IMAGE - RESIZE         |
+--------------------------------*/
$config['img_thumb_width'] = "100";
$config['img_thumb_height'] = "100";
/*-------------------------------+
|  config form dropdown          |
+--------------------------------*/
$show['0'] = 'Ẩn';
$show['1'] = 'Hiển thị';

$config['show'] = $show;
//
$type['O'] = "Chỉ chọn một";
$type['M'] = "Chọn nhiều";

$config['op_type'] = $type; 
// left menu
$config['menu_title'] = "Manage vote";

$config['menu'] = array();
