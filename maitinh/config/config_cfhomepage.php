<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
$config['view_dir']	= "cfhomepage/";
$config['config_file']	= ROOT."cfg/cf_homepage.php";
#require_once($config['config_file']);
//
$config['menu_title'] = "Cache /";
$config['menu'] = array();
//
$config['hot_cat'] = array(2, 42, 13, 3, 4, 18, 38, 22, 30, 26);
$config['choose_cat'] = array(22, 23, 25, 39, 18, 19, 20, 21, 27, 35, 10, 46);
$config['total_hot_news'] = 10;
$config['total_lead_news'] = 10;
$config['total_cat'] = 29;
$config['all_cat_active'] = array(2, 3, 4, 10, 13, 14, 16, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49);// no zero
$config['num_cat_per_time'] = 4;
$config['cat_tieudiem'] = array(4,38,18,24,33,10,48,34);//30-7-2010
$config['soluong_tin_tieudiem'] = array(2,2,2,2,1,1,1,1);//30-7-2010
