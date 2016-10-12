<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
// Common resources location

$config['js_dir'] = ROOT.'js/';
$config['img_dir'] = ROOT.'images/';
$config['css_dir'] = ROOT.'css/';
$config['upload_dir'] = ROOT.'uploads/';
$config['img_size'] = 500;
$config['img_width'] = 1024;
$config['img_height'] = 768;
$config['allowed_types'] = 'gif|jpg|png|flv';
$config['import_size'] = 1024;

$config['item_perpage'] = 10;
$config['num_links'] = 5;
// Thoi gian 24h
$hours[0] = '--';
$hours[1] = 1;
$hours[2] = 2;
$hours[3] = 3;
$hours[4] = 4;
$hours[5] = 5;
$hours[6] = 6;
$hours[7] = 7;
$hours[8] = 8;
$hours[9] = 9;
$hours[10] = 10;
$hours[11] = 11;
$hours[12] = 12;
$hours[13] = 13;
$hours[14] = 14;
$hours[15] = 15;
$hours[16] = 16;
$hours[17] = 17;
$hours[18] = 18;
$hours[19] = 19;
$hours[20] = 20;
$hours[21] = 21;
$hours[22] = 22;
$hours[23] = 23;
$hours[24] = 24;
$config['hours']  = $hours;

$config['get_type'] = 1; #Chon phuong thuc lay thong tin
/* chu thich ve $config['get_type']
 * chon 1 neu muon dung CURL
 * chon 2 neu muon dung ham fopen
 * chon 3 neu muon dung ham file_get_contents
 * tuy vao host cua ban ho tro ham nao ma chon ham do
*/

/* End of file config_site.php */
/* Location: ./system/application/config/config_site.php */