<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-------------------------------+
|  MAIN CONFIGURATION            |
| important notice:              |
+--------------------------------*/

// template directory
$config['view_dir'] = 'vote_content/'; // system/application/views/vote_content/
/*-------------------------------+
|  PAGINATION                    |
+--------------------------------*/
$config['item_perpage'] = 10;
$config['num_links'] = 10;

/*-------------------------------+
|  UPLOAD IMAGE                  |
+--------------------------------*/
$config['img_upload'] 		= "../uploads/vote_content/";
$config['img_type'] 	= "gif|jpg|png";
$config['img_size'] 	= "300";
$config['img_width']  = "800";
$config['img_height'] = "600";
$config['img_name_encrypt'] = "TRUE";
/*-------------------------------+
|  UPLOAD IMAGE - RESIZE         |
+--------------------------------*/
$config['img_thumb_width'] = "100";
$config['img_thumb_height'] = "100";

$type['O'] = "Chỉ chọn một";
$type['M'] = "Chọn nhiều";

$config['op_type'] = $type; 

$vote_content['N'] = "Không";
$vote_content['Y'] = "Có";

$config['op_vote_content'] = $vote_content; 
// left menu
$config['menu_title'] = "Manage question catelogy";

$config['menu'] = array();
