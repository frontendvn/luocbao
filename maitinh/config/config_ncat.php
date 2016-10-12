<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
|  important notice:             |
+--------------------------------*/

// ncat template directory
$config['view_dir'] = 'ncat/'; // system/application/views/ncat/
// left menu
$mod = 'ncat';
$config['menu_title'] = "Chủ đề /";

$config['menu'][] = array('name'=>'Danh sách', 'link'=>$mod.'/lists', 'icon'=>'list.gif');
$config['menu'][] = array('name'=>'Thêm mới', 'link'=>$mod.'/add', 'icon'=>'customer_add.gif');