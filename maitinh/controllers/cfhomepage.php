<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class cfhomepage extends Controller {
	var $mod = "cfhomepage";
	function cfhomepage()
	{		
		parent::Controller();
		$this->config->load('config_'.$this->mod);		
		// directory of the view, just to reduce number of typed text
		$this->view_dir = $this->config->item('view_dir');
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'add';
		// select page layout
		$this->view_container = 'adm_container';
		// init feedback for user's actions
		$this->pre_message = "";
		$this->config_file = $this->config->item('config_file');
		$this->all_cat_active = $this->config->item('all_cat_active');
		/*-------------------------------+
		|  CPANEL LIB                    |
		|  use for manage			     |
		+--------------------------------*/
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// load necessary libraries
		$this->load->model($this->mod.'_model', 'mmod');
	}
	// default page
	function index()
	{
		$this->session->set_userdata('temp', $this->all_cat_active);
		$this->session->set_userdata('time', 0);
				
		$data['page_title'] = 'Cache';
		$this->view_page = $this->view_dir.'index';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}
	
	function process()
	{
		$session_temp = $this->session->userdata('temp');
		$session_time = $this->session->userdata('time');

		if(is_array($session_temp) and !empty($session_temp))
		{
			$num_cat_per_time = $this->config->item('num_cat_per_time');
			for($i=1;$i<=$num_cat_per_time;$i++)
			{
				$cat_curent = array_shift($session_temp); 
				if(!empty($cat_curent))
				{
					$rs_cat = $this->mmod->select_news_cat($cat_curent, 4);
					// read $rs_cat and save in db
					if($rs_cat)
					{
						foreach ($rs_cat->result_array() as $vl)
						{ 
							$this->db->insert('homepage_cache', $vl);
						}
					}
				}
				else
				{//$cat_curent is null
					break;
				}
			}
			
			$session_time = $session_time+1;
			$this->session->set_userdata('temp', $session_temp);
			$this->session->set_userdata('time', $session_time);
		}
		if(!empty($session_time) and $session_time==10)// update session
		{
			$this->session->unset_userdata('temp');
			$this->session->unset_userdata('time');
			// filter data for homepage
			// some code here
			/*$ar_cat_hot = $this->config->item('hot_cat');
			$ar_cat_old = array();
			$ar_news_hot = array();
			$total_hot_news = $this->config->item('total_hot_news');*/
			
			$rs_homepage = $this->mmod->select_news_for_homepage($this->all_cat_active);
			if($rs_homepage)
			{// hot_news
				// per cat
				foreach($this->all_cat_active as $val)
				{
					$array = 'array'.$val;
					$$array = array();
				}
				// list news latest in per cat
				foreach ($rs_homepage->result_array() as $array_item)
				{
					$array_cat = 'array'.$array_item['id_nwc'];
					array_push($$array_cat, $array_item);
					
					/*if(in_array($array_item['id_nwc'], $ar_cat_hot) and !in_array($array_item['id_nwc'], $ar_cat_old))
					{// get news hot
						array_push($ar_news_hot, $array_item);
						array_push($ar_cat_old, $array_item['id_nwc']);
					}*/
				}
			}
			// auto hot news in cats 
			// some code here
			$string_hot_news_in_cat = '';
			foreach($this->all_cat_active as $val)
			{
				$array = 'array'.$val;
				$string_hot_news_in_cat .= $this->_convert_array_to_string_hot_news_in_cat($$array);
			}
			$rs_video = $this->mmod->select_news_video_cat(15, 4);
			if($rs_video)
			{
				$string_hot_news_in_cat .= $this->_convert_array_to_string_hot_news_in_cat($rs_video->result_array());
			}
			// auto choose news in cats 
			// some code here
			$choose_cat = $this->config->item('choose_cat'); // is array
			$ar_choose_news = array();
			$time_chose = time()-7*86400;
			foreach($choose_cat as $acat)
			{
				$rs_choose = $this->mmod->select_news_in_choose_cat_today($time_chose, $acat, 1);
				if($rs_choose)
				{//
					$a_choose_news = $rs_choose->first_row('array');
					array_push($ar_choose_news, $a_choose_news);
				}
			}		
			$string_choose_news = $this->_convert_array_to_string_choose_news($ar_choose_news);
			// auto lead news (hot)
			// some code here
			/*$string_hot_news = $this->_convert_array_to_string_hot_news($ar_news_hot);*/
			$rs_lead = $this->mmod->select_news_lead();
			$ar_lead_news = array();
			if($rs_lead)
			{//
				foreach($rs_lead->result_array() as $row)
				{
					array_push($ar_lead_news, $row);
				}
			}
			$string_lead_news = $this->_convert_array_to_string_hot_news($ar_lead_news);
			// auto useful news
			// some code here
			$rs_useful = $this->mmod->select_news_useful();
			$ar_useful_news = array();
			if($rs_useful)
			{//
				foreach($rs_useful->result_array() as $row)
				{
					array_push($ar_useful_news, $row);
				}
			}
			$string_useful_news = $this->_convert_array_to_string_news_useful($ar_useful_news);
			// auto special news
			// some code here
			$rs_special = $this->mmod->select_news_special(1);
			$ar_special_news = array();
			if($rs_useful)
			{//
				foreach($rs_special->result_array() as $row)
				{
					array_push($ar_special_news, $row);
				}
			}
			$string_special_news = $this->_convert_array_to_string_news_special($ar_special_news);
			
			/******************2-8-2010tin tieu diem*************/
			$cat_tieudiem 			= $this->config->item('cat_tieudiem');
			$soluong_tin_tieudiem 	= $this->config->item('soluong_tin_tieudiem');
			$ar_tieudiem = array();
			$i=0;
			$string_tieudiem ='';
			foreach($cat_tieudiem as $acat)
			{
				$rs_choose = $this->mmod->select_news_in_choose_cat($acat, $soluong_tin_tieudiem[$i]);
				if(is_object($rs_choose) && $rs_choose->num_rows()>0) 
				{//
					$string_tieudiem .= $this->_convert_array_to_string_tieudiem($rs_choose);
				}
				$i++;
			}	
			/*****************tin tieu diem*************/
			// write cf_homepage file
			$this->_write_config(array($string_special_news, $string_lead_news, $string_hot_news_in_cat, $string_choose_news, $string_tieudiem, $string_useful_news));
			// empty table homepare_news in db
			// some code here
			$this->db->truncate('homepage_cache');
			// write xml list video
			// some code here
			#$rs_video = $this->mmod->select_list_video(3);
			#$this->_write_xml($rs_video);
		}
		echo $session_time;
	}
	
	function _convert_array_to_string_hot_news($array)
	{//
		$str = '';
		if(!empty($array) and is_array($array))
		{
			$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
			$art = array("\'",'\"',"",'','\"',"\'");
			$arz = array('','','','','','');
			$n = sizeof($array);
			for($i=0;$i<$n;$i++)
			{
				$id_news = $array[$i]['id_news'];
				$id_text = $array[$i]['id_text'];
				$id_cattext = $array[$i]['id_cattext'];
				$id_nwc = $array[$i]['id_nwc'];
				$news_title = $array[$i]['news_title'];
				$news_intro = $array[$i]['news_quickview'];
				$news_date = $array[$i]['news_date'];
				$random_img = $this->_random_image();
				$news_img = empty($array[$i]['news_img']) ? $random_img : $array[$i]['news_img'];
				$news_img_thumb = empty($array[$i]['news_img_thumb']) ? $random_img : $array[$i]['news_img_thumb'];
				
				$id_text = str_replace($ard, $arz, $id_text);
				$id_cattext = str_replace($ard, $arz, $id_cattext);
				#$news_title = str_replace($ard, $art, $news_title);
				#$news_intro = str_replace($ard, $art, $news_intro);
				$j = $i+1;
				
				$str .= "\n";
				$str .= "\n\$config['hot_news_id_".$j."'] = $id_news;";
				$str .= "\n\$config['hot_news_id_text_".$j."'] = '$id_text';";
				$str .= "\n\$config['hot_news_id_cattext_".$j."'] = '$id_cattext';";
				$str .= "\n\$config['hot_news_id_nwc_".$j."'] = '$id_nwc';";
				$str .= "\n\$config['hot_news_title_".$j."'] = '$news_title';";
				$str .= "\n\$config['hot_news_intro_".$j."'] = '$news_intro';";
				$str .= "\n\$config['hot_news_date_".$j."'] = $news_date;";
				$str .= "\n\$config['hot_news_img_".$j."'] = '$news_img';";
				$str .= "\n\$config['hot_news_img_thumb_".$j."'] = '$news_img_thumb';";
			}
		}
		return $str;
	}

	function _convert_array_to_string_choose_news($array)
	{//
		$str = '';
		if(!empty($array) and is_array($array))
		{
			$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
			$art = array("\'",'\"',"",'','\"',"\'");
			$arz = array('','','','','','');
			$n = sizeof($array);
			for($i=0;$i<$n;$i++)
			{
				$id_news = $array[$i]['id_news'];
				$id_text = $array[$i]['id_text'];
				$id_cattext = $array[$i]['id_cattext'];
				$id_nwc = $array[$i]['id_nwc'];
				$news_title = $array[$i]['news_title'];
				$news_intro = $array[$i]['news_quickview'];
				$news_date = $array[$i]['news_date'];
				$random_img = $this->_random_image();
				$news_img = empty($array[$i]['news_img']) ? $random_img : $array[$i]['news_img'];
				$news_img_thumb = empty($array[$i]['news_img_thumb']) ? $random_img : $array[$i]['news_img_thumb'];
				
				$id_text = str_replace($ard, $arz, $id_text);
				$id_cattext = str_replace($ard, $arz, $id_cattext);
				#$news_title = str_replace($ard, $art, $news_title);
				#$news_intro = str_replace($ard, $art, $news_intro);
				$j = $i+1;
				
				$str .= "\n";
				$str .= "\n\$config['choose_news_id_".$j."'] = $id_news;";
				$str .= "\n\$config['choose_news_id_text_".$j."'] = '$id_text';";
				$str .= "\n\$config['choose_news_id_cattext_".$j."'] = '$id_cattext';";
				$str .= "\n\$config['choose_news_id_nwc_".$j."'] = '$id_nwc';";
				$str .= "\n\$config['choose_news_title_".$j."'] = '$news_title';";
				$str .= "\n\$config['choose_news_intro_".$j."'] = '$news_intro';";
				$str .= "\n\$config['choose_news_date_".$j."'] = $news_date;";
				$str .= "\n\$config['choose_news_img_".$j."'] = '$news_img';";
				$str .= "\n\$config['choose_news_img_thumb_".$j."'] = '$news_img_thumb';";
			}
		}
		return $str;
	}
	
	function _convert_array_to_string_hot_news_in_cat($array)
	{//
		$str = '';
		if(!empty($array) and is_array($array))
		{
			$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
			$art = array("\'",'\"',"",'','\"',"\'");
			$arz = array('','','','','','');
			$n = sizeof($array);
			for($i=0;$i<$n;$i++)
			{
				$id_news = $array[$i]['id_news'];
				$id_text = $array[$i]['id_text'];
				$id_cattext = $array[$i]['id_cattext'];
				$id_nwc = $array[$i]['id_nwc'];
				$news_title = $array[$i]['news_title'];
				$news_intro = $array[$i]['news_quickview'];
				$news_date = $array[$i]['news_date'];
				$random_img = $this->_random_image();
				$news_img = empty($array[$i]['news_img']) ? $random_img : $array[$i]['news_img'];
				$news_img_thumb = empty($array[$i]['news_img_thumb']) ? $random_img : $array[$i]['news_img_thumb'];
				$news_meta = $array[$i]['news_meta'];
				$news_video = empty($array[$i]['news_video']) ? $news_img : $array[$i]['news_video'];
				
				$id_text = str_replace($ard, $arz, $id_text);
				$id_cattext = str_replace($ard, $arz, $id_cattext);
				#$news_title = str_replace($ard, $art, $news_title);
				#$news_intro = str_replace($ard, $art, $news_intro);
				$j = $i+1;
				
				$str .= "\n";
				$str .= "\n\$config['cat".$id_nwc."_news_id_".$j."'] = $id_news;";
				$str .= "\n\$config['cat".$id_nwc."_news_id_text_".$j."'] = '$id_text';";
				$str .= "\n\$config['cat".$id_nwc."_news_id_cattext_".$j."'] = '$id_cattext';";
				$str .= "\n\$config['cat".$id_nwc."_news_id_nwc_".$j."'] = '$id_nwc';";
				$str .= "\n\$config['cat".$id_nwc."_news_title_".$j."'] = '$news_title';";
				$str .= "\n\$config['cat".$id_nwc."_news_intro_".$j."'] = '$news_intro';";
				$str .= "\n\$config['cat".$id_nwc."_news_date_".$j."'] = $news_date;";
				$str .= "\n\$config['cat".$id_nwc."_news_img_".$j."'] = '$news_img';";
				$str .= "\n\$config['cat".$id_nwc."_news_img_thumb_".$j."'] = '$news_img_thumb';";
				if($id_nwc==19 and $i==0)
					$str .= "\n\$config['cat".$id_nwc."_news_meta_".$j."'] = '$news_meta';";
				if($id_nwc==15)
					$str .= "\n\$config['cat".$id_nwc."_news_video_".$j."'] = '$news_video';";
			}
		}
		return $str;
	}
	
	function _convert_array_to_string_news_useful($array)
	{//
		$str = '';
		if(!empty($array) and is_array($array))
		{
			$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
			$art = array("\'",'\"',"",'','\"',"\'");
			$arz = array('','','','','','');
			$n = sizeof($array);
			for($i=0;$i<$n;$i++)
			{
				$id_news = $array[$i]['id_news'];
				$id_text = $array[$i]['id_text'];
				$id_cattext = $array[$i]['id_cattext'];
				$id_nwc = $array[$i]['id_nwc'];
				$news_title = $array[$i]['news_title'];
				$news_intro = $array[$i]['news_quickview'];
				$news_date = $array[$i]['news_date'];
				$random_img = $this->_random_image();
				$news_img = empty($array[$i]['news_img']) ? $random_img : $array[$i]['news_img'];
				$news_img_thumb = empty($array[$i]['news_img_thumb']) ? $random_img : $array[$i]['news_img_thumb'];
				
				$id_text = str_replace($ard, $arz, $id_text);
				$id_cattext = str_replace($ard, $arz, $id_cattext);
				#$news_title = str_replace($ard, $art, $news_title);
				#$news_intro = str_replace($ard, $art, $news_intro);
				$j = $i+1;
				
				$str .= "\n";
				$str .= "\n\$config['useful_news_id_".$j."'] = $id_news;";
				$str .= "\n\$config['useful_news_id_text_".$j."'] = '$id_text';";
				$str .= "\n\$config['useful_news_id_cattext_".$j."'] = '$id_cattext';";
				$str .= "\n\$config['useful_news_id_nwc_".$j."'] = '$id_nwc';";
				$str .= "\n\$config['useful_news_title_".$j."'] = '$news_title';";
				$str .= "\n\$config['useful_news_intro_".$j."'] = '$news_intro';";
				$str .= "\n\$config['useful_news_date_".$j."'] = $news_date;";
				$str .= "\n\$config['useful_news_img_".$j."'] = '$news_img';";
				$str .= "\n\$config['useful_news_img_thumb_".$j."'] = '$news_img_thumb';";
			}
		}
		return $str;
	}
	
	function _convert_array_to_string_news_special($array)
	{//
		$str = '';
		if(!empty($array) and is_array($array))
		{
			$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
			$art = array("\'",'\"',"",'','\"',"\'");
			$arz = array('','','','','','');
			$n = sizeof($array);
			for($i=0;$i<$n;$i++)
			{
				$id_news = $array[$i]['id_news'];
				$id_text = $array[$i]['id_text'];
				$id_cattext = $array[$i]['id_cattext'];
				$id_nwc = $array[$i]['id_nwc'];
				$news_title = $array[$i]['news_title'];
				$news_intro = $array[$i]['news_quickview'];
				$news_date = $array[$i]['news_date'];
				$news_date = $array[$i]['news_date'];
				$news_special_create_date = $array[$i]['news_special_create_date'];
				$news_specialtime = $array[$i]['news_specialtime'];
				$random_img = $this->_random_image();
				$news_img = empty($array[$i]['news_img']) ? $random_img : $array[$i]['news_img'];
				$news_img_thumb = empty($array[$i]['news_img_thumb']) ? $random_img : $array[$i]['news_img_thumb'];
				
				$id_text = str_replace($ard, $arz, $id_text);
				$id_cattext = str_replace($ard, $arz, $id_cattext);
				#$news_title = str_replace($ard, $art, $news_title);
				#$news_intro = str_replace($ard, $art, $news_intro);
				$j = $i+1;
				
				$str .= "\n";
				$str .= "\n\$config['special_news_id_".$j."'] = $id_news;";
				$str .= "\n\$config['special_news_id_text_".$j."'] = '$id_text';";
				$str .= "\n\$config['special_news_id_cattext_".$j."'] = '$id_cattext';";
				$str .= "\n\$config['special_news_id_nwc_".$j."'] = '$id_nwc';";
				$str .= "\n\$config['special_news_title_".$j."'] = '$news_title';";
				$str .= "\n\$config['special_news_intro_".$j."'] = '$news_intro';";
				$str .= "\n\$config['special_news_date_".$j."'] = $news_date;";
				$str .= "\n\$config['special_news_create_date_".$j."'] = $news_special_create_date;";
				$str .= "\n\$config['special_news_specialtime_".$j."'] = $news_specialtime;";
				$str .= "\n\$config['special_news_img_".$j."'] = '$news_img';";
				$str .= "\n\$config['special_news_img_thumb_".$j."'] = '$news_img_thumb';";
			}
		}
		return $str;
	}
	
	function _convert_array_to_string_tieudiem($array)//2-8-2010
	{
		$str = '';
		$ard = array("'",'"',"\n",'\\','&quot;','&#039;');
		$art = array("\'",'\"',"",'','\"',"\'");
		$arz = array('','','','','','');
		$j=0;
		foreach($array->result_array() as $row){
			$id_news = $row['id_news'];
			$id_text = $row['id_text'];
			$id_cattext = $row['id_cattext'];
			$id_nwc = $row['id_nwc'];
			$news_title = $row['news_title'];
			$random_img = $this->_random_image();
			$news_img_thumb = empty($row['news_img_thumb']) ? $random_img : $row['news_img_thumb'];
			
			$id_text = str_replace($ard, $arz, $id_text);
			$id_cattext = str_replace($ard, $arz, $id_cattext);
			#$news_title = str_replace($ard, $art, $news_title);
			
			$j++;
			$str .= "\n";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_id_".$j."'] = $id_news;";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_id_text_".$j."'] = '$id_text';";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_id_cattext_".$j."'] = '$id_cattext';";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_id_nwc_".$j."'] = '$id_nwc';";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_title_".$j."'] = '$news_title';";
			$str .= "\n\$config['tieudiem".$id_nwc."_news_img_thumb_".$j."'] = '$news_img_thumb';";
		}
		
		return $str;
	}
	
	function _write_config($array)
	{//  
		$strConfig = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
/**
* Cache file for home page.
* Date: ".date('d/m/y H:i:s').".
**/";
		if(is_array($array))
		{
			foreach($array as $vl)
			{
				$strConfig .= "$vl";
			}
		}
		
		$strConfig .= "\n\n/* End of file cf_homepage.php */
/* Location: ./cfg/cf_homepage.php */";

		$this->load->helper('file');
		if (write_file($this->config_file, $strConfig))
		{
			 $this->pre_message .=  "Write data success!";
		}
		else
		{
			 $this->pre_message .=  "Error: cant not write file!";
		}
	}
	
	function _random_image($path = 'images/', $max=4)
	{
		$range = range(1,$max);
		shuffle($range);//random vi tri
		return $path.'temp'.$range[0].'.jpg';
	}
}