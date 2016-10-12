<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
// Common resources location
$config['js_dir'] = ROOT.'js/';
$config['img_dir'] = ROOT.'images/';
$config['css_dir'] = ROOT.'css/';
$config['upload_dir'] = 'uploads/';
$config['img_size'] = 500;
$config['img_width'] = 1024;
$config['img_height'] = 768;
$config['allowed_types'] = 'gif|jpg|png|flv';
$config['import_size'] = 1024;

$config['item_perpage'] = 10;
$config['num_links'] = 5;
/*
 * Modify route to rewrite url
 * on/off : 1/0
*/
$config['default_param_uri'] = 1;

$config['get_type'] = 1; #Chon phuong thuc lay thong tin
/* chu thich ve $config['get_type']
 * chon 1 neu muon dung CURL
 * chon 2 neu muon dung ham fopen
 * chon 3 neu muon dung ham file_get_contents
*/

/* End of file config_site.php */
/* Location: ./system/application/config/config_site.php */