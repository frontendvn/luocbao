<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
| ci folder : system/application |
+--------------------------------*/

// template directory
$config['view_dir'] = 'auto_log/'; // system/application/views/auto_log/
//
$config['menu_title'] = "Auto logs /";
$config['menu'] = array();
//
$status[''] = '- All -';
$status['Success'] = 'Success';
$status['False'] = 'False';
$status['No_news'] = 'No_news';
$status['Low'] = 'Low';
$config['status'] = $status;
//
$time_ago['1'] = 'Last Hour';
$time_ago['2'] = 'Last Two Hours';
$time_ago['4'] = 'Last Four Hours';
$time_ago['T'] = 'Today';
$time_ago['Y'] = 'Yesterday';
$time_ago['48'] = 'Last Two Days';
$time_ago['W'] = 'Last Week';
$time_ago['A'] = 'Everything';
$config['time_ago'] = $time_ago;