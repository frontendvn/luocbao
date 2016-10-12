<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//

$config['view_dir'] = 'comment/';
$config['menu'][] = array('name'=>'Nhận xét chưa xem', 'link'=>'comment/new_comment', 'icon'=>'set.gif');
$config['menu'][] = array('name'=>'Nhận xét đã xem', 'link'=>'comment/lists', 'icon'=>'set.gif');

?>