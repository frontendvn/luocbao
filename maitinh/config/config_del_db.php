<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
| ci folder : system/application |
+--------------------------------*/

// template directory
$config['view_dir'] = 'del_db/'; // system/application/views/auto_log/
//
$config['menu_title'] = "Xóa dữ liệu /";
$config['menu'] = array();
//
$config['years'] = 2010;
//
$months[1] = '1';
$months[2] = '2';
$months[3] = '3';
$months[4] = '4';
$months[5] = '5';
$months[6] = '6';
$months[7] = '7';
$months[8] = '8';
$months[9] = '9';
$months[10] = '10';
$months[11] = '11';
$months[12] = '12';
$config['months'] = $months;