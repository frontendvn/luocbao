<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*-------------------------------+
|  MAIN CONFIGURATION            |
|  important notice:             |
+--------------------------------*/

// template directory
$config['view_dir'] = 'crawler/'; // system/application/views/crawler/

/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 300;
$config['num_links'] = 10;

// left menu
$mod = 'crawler';
$config['menu_title'] = "Crawler /";

$config['menu'][] = array('name'=>'Danh sách theo chủ đề', 'link'=>$mod.'/lists', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Thêm mới', 'link'=>$mod.'/add', 'icon'=>'customer_add.gif');