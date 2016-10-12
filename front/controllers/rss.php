<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends Controller {
	var $mod = "rss";
	function Rss()
	{
		parent::Controller();	
		//
		$this->load->config('config_'.$this->mod);
		//
		$this->view_dir = $this->mod.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'index';
		// select page layout
		$this->view_container = 'container';
		// init feedback for user's actions
		$this->pre_message = "";
		// load necessary libraries
		$this->config_file = $this->config->item('config_file');
		$this->load->helper('file');
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function cat($id_cattext)
	{
		$rs_cat_news = $this->mmod->select_news_cat($id_cattext, 10);
		$content = '';
		$title = '';
		$webstie = site_url();
		$name_webstie = 'luocbao.com';
		$description = 'Lược báo - Chọn tin nhanh - Cập nhật sớm';
		if($rs_cat_news)
		{
			$title = $rs_cat_news->row(0)->nwc_name;
			foreach($rs_cat_news->result() as $row)
			{
				$id_cattext = $row->id_cattext;
				$id_text = $row->id_text;
				$tieude = stripslashes($row->news_title);
				$link = site_url('news/detail/'.$id_cattext.'/'.$id_text);
				$mota = stripslashes($row->news_quickview);
				$ngay = date('d-m-Y H:i', $row->news_date);
				$content .= "<item>\n
				<title>$tieude</title>\n
				<link>$link</link>\n
				<description>$mota</description>\n
				<pubDate>$ngay</pubDate>\n
				</item>\n";
			}
		}		
		$last_built = date("D, d M Y H:i:s T"); 
		$copy_year = "COPYRIGHT".date("Y"); 
		header("Content-Type: text/xml charset=UTF-8"); 
		
		echo "<?xml version=\"1.0\"?>\n\n 
		<rss version=\"2.0\">\n\n 
		  <channel>\n 
		    <title>$title - Luocbao.com</title>\n 
		    <link>$webstie</link>\n 
		    <description>$description</description>\n 
		    <copyright>$copy_year $name_webstie</copyright>\n 
		    <generator>tentrangweb</generator>\n 
		    <language>vietnamese</language>\n 
		    <lastBuildDate>$last_built</lastBuildDate>\n 
		    <managingEditor>adminmail@yourdoamain .com</managingEditor>\n 
		    <webMaster>adminmail@yourdoamain .com</webMaster>\n 
		    <ttl>60</ttl>\n\n 
		    <image>\n 
		      <title>tentrangweb</title>\n 
		      <url>/images/logo.gif</url>\n
		      <link>yourdoamain .com</link>\n 
		      <width>100</width>\n 
		      <height>48</height>\n 
		      <description>tentrangweb</description>\n 
		    </image>\n\n
			$content 
		</channel>\n\n 
		</rss>";
	}	

	function pcat($id_cattext)
	{
		$content = '';
		$title = '';
		$webstie = site_url();
		$name_webstie = 'luocbao.com';
		$description = 'Lược báo - Chọn tin nhanh - Cập nhật sớm';
		
		$cat_info = $this->mmod->get_cat_info($id_cattext);
		$title = $cat_info ? $cat_info->nwc_name: '';
		$id_nwc = $cat_info ? $cat_info->id_nwc: 0;
		$ar_id_cat = array($id_nwc);

		$sub_cat = $this->mmod->select_sub_cat($id_nwc);
		if($sub_cat)
		{
			foreach($sub_cat->result() as $row)
			{
				$id_nwc_sub = $row->id_nwc;
				if($id_nwc_sub) array_push($ar_id_cat, $id_nwc_sub);
			}
		}

		$rs_cat_news = $this->mmod->select_news_in_array_cat($ar_id_cat, 10);
		if($rs_cat_news)
		{
			foreach($rs_cat_news->result() as $row)
			{
				$id_cattext = $row->id_cattext;
				$id_text = $row->id_text;
				$tieude = stripslashes($row->news_title);
				$link = site_url('news/detail/'.$id_cattext.'/'.$id_text);
				$mota = stripslashes($row->news_quickview);
				$ngay = date('d-m-Y H:i', $row->news_date);
				$content .= "<item>\n
				<title>$tieude</title>\n
				<link>$link</link>\n
				<description>$mota</description>\n
				<pubDate>$ngay</pubDate>\n
				</item>\n";
			}
		}		
		$last_built = date("D, d M Y H:i:s T"); 
		$copy_year = "COPYRIGHT".date("Y"); 
		header("Content-Type: text/xml charset=UTF-8"); 
		
		echo "<?xml version=\"1.0\"?>\n\n 
		<rss version=\"2.0\">\n\n 
		  <channel>\n 
		    <title>$title - Luocbao.com</title>\n 
		    <link>$webstie</link>\n 
		    <description>$description</description>\n 
		    <copyright>$copy_year $name_webstie</copyright>\n 
		    <generator>tentrangweb</generator>\n 
		    <language>vietnamese</language>\n 
		    <lastBuildDate>$last_built</lastBuildDate>\n 
		    <managingEditor>adminmail@yourdoamain .com</managingEditor>\n 
		    <webMaster>adminmail@yourdoamain .com</webMaster>\n 
		    <ttl>60</ttl>\n\n 
		    <image>\n 
		      <title>tentrangweb</title>\n 
		      <url>/images/logo.gif</url>\n
		      <link>yourdoamain .com</link>\n 
		      <width>100</width>\n 
		      <height>48</height>\n 
		      <description>tentrangweb</description>\n 
		    </image>\n\n
			$content 
		</channel>\n\n 
		</rss>";
	}	
	
	function chose()
	{
		$content = '';
		$title = 'Tin chọn lọc';
		$webstie = site_url();
		$name_webstie = 'luocbao.com';
		$description = 'Lược báo - Chọn tin nhanh - Cập nhật sớm';
		
		$choose_cat = $this->config->item('choose_cat'); // is array
		$ar_choose_news = array();
		$time_chose = time()-3*86400;
		foreach($choose_cat as $acat)
		{
			$rs_choose = $this->mmod->select_news_in_choose_cat_today($time_chose, $acat, 1);
			if($rs_choose)
			{//
				foreach($rs_choose->result() as $row)
				{
					$id_cattext = $row->id_cattext;
					$id_text = $row->id_text;
					$tieude = stripslashes($row->news_title);
					$link = site_url('news/detail/'.$id_cattext.'/'.$id_text);
					$mota = stripslashes($row->news_quickview);
					$ngay = date('d-m-Y H:i', $row->news_date);
					$content .= "<item>\n
					<title>$tieude</title>\n
					<link>$link</link>\n
					<description>$mota</description>\n
					<pubDate>$ngay</pubDate>\n
					</item>\n";
				}
			}		
		}		
		$last_built = date("D, d M Y H:i:s T"); 
		$copy_year = "COPYRIGHT".date("Y"); 
		header("Content-Type: text/xml charset=UTF-8"); 
		
		echo "<?xml version=\"1.0\"?>\n\n 
		<rss version=\"2.0\">\n\n 
		  <channel>\n 
		    <title>$title - Luocbao.com</title>\n 
		    <link>$webstie</link>\n 
		    <description>$description</description>\n 
		    <copyright>$copy_year $name_webstie</copyright>\n 
		    <generator>tentrangweb</generator>\n 
		    <language>vietnamese</language>\n 
		    <lastBuildDate>$last_built</lastBuildDate>\n 
		    <managingEditor>adminmail@yourdoamain .com</managingEditor>\n 
		    <webMaster>adminmail@yourdoamain .com</webMaster>\n 
		    <ttl>60</ttl>\n\n 
		    <image>\n 
		      <title>tentrangweb</title>\n 
		      <url>/images/logo.gif</url>\n
		      <link>yourdoamain .com</link>\n 
		      <width>100</width>\n 
		      <height>48</height>\n 
		      <description>tentrangweb</description>\n 
		    </image>\n\n
			$content 
		</channel>\n\n 
		</rss>";
	}	
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */