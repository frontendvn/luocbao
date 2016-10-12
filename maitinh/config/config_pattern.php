<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*-------------------------------+
|  MAIN CONFIGURATION            |
|  important notice:             |
+--------------------------------*/

// template directory
$config['view_dir'] = 'pattern/'; // system/application/views/pattern/

/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 300;
$config['num_links'] = 10;

// left menu
$mod = 'pattern';
$config['menu_title'] = "Mẫu /";

$config['menu'][] = array('name'=>'Danh sách', 'link'=>$mod.'/lists', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Thêm mới', 'link'=>$mod.'/add', 'icon'=>'customer_add.gif');