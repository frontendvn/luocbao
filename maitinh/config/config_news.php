<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*-------------------------------+
|  MAIN CONFIGURATION            |
|  important notice:             |
+--------------------------------*/

// template directory
$config['view_dir'] = 'news/'; // system/application/views/news/

/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 30;
$config['num_links'] = 10;

/*-------------------------------+
|  UPLOAD IMAGE                  |
+--------------------------------*/
$config['file_dir'] = "news/";
$config['img_name_encrypt'] = "TRUE";
/*-------------------------------+
|  UPLOAD IMAGE - RESIZE         |
+--------------------------------*/
$config['img_thumb_width'] = "144";
$config['img_thumb_height'] = "97";

// left menu
$mod = 'news';
$config['menu_title'] = "Bản tin /";

$config['menu'][] = array('name'=>'Tin đã duyệt', 'link'=>$mod.'/lists', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Tin chưa duyệt', 'link'=>$mod.'/list_audit', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Tin nổi bật', 'link'=>$mod.'/list_lead', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Tin hay', 'link'=>$mod.'/list_useful', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Thêm tin mới', 'link'=>$mod.'/add', 'icon'=>'add.gif');