<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['config_file']	= "cfg/cf_homepage.php";
require_once($config['config_file']);
require_once("cfg/quangcao_mau.php");
$config['total_hot_news']	= 10;
$config['total_max_view_count_news_home']	= 10;
$config['total_max_view_count_news']	= 5;
$config['total_random_news']	= 11;
$config['total_cat_news']	= 12;
// other cat news
