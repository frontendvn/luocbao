<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
+--------------------------------*/

// template directory
$config['view_dir'] = 'video/'; // system/application/views/video/
/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 20;
$config['num_links'] = 10;

/*-------------------------------+
|  UPLOAD IMAGE                  |
+--------------------------------*/
$config['video_upload'] 		= "../uploads/video/";
$config['video_type'] 	= "flv|wmv|swf";
$config['video_size'] 	= "3072";
$config['video_name_encrypt'] = "TRUE";
/*-------------------------------+
|  config form dropdown          |
+--------------------------------*/
$show[''] = '- Chọn -';
$show['N'] = 'Ẩn';
$show['Y'] = 'Hiển thị';

$config['shown'] = $show;
// left menu
$config['menu_title'] = "Manage video";

$config['menu'] = array();
