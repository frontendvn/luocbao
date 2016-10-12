<?php

$config['menu'][] = array('name'=>'Blocks', 'link'=>'blocks', 'icon'=>'bullet.gif');
$config['menu'][] = array('name'=>'Skin', 'link'=>'skin', 'icon'=>'bullet.gif');
$config['menu'][] = array('name'=>'Layout home', 'link'=>'cfhome/index', 'icon'=>'bullet.png');
$config['menu'][] = array('name'=>'Layout category', 'link'=>'cfhome/cfcat', 'icon'=>'bullet.png');
$config['menu'][] = array('name'=>'Layout detail', 'link'=>'cfhome/cfdetail', 'icon'=>'bullet.png');

$type[''] ="Chọn loại";
$type['nhomtin'] ="Nhóm tin";
$type['bantin'] ="Bản tin";
$type['html'] ="Html";
$type['survey'] ="Thăm dò";
$config['type'] = $type;
?>