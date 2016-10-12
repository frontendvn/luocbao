<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/* Content is a full news: vnepress.net, zing.vn, bee.net.vn, bongda.com.vn */
/* not get image: tienphong.vn, vnexpress.net (làm đẹp), vnexpress.net (pháp luật ký sự), teen.tuoitre.vn (giáo dục), chuyentrang.tuoitre.vn, diaoc.tuoitre.vn, anninhthudo.vn (antg) */
class Capnhat extends Controller {
	var $mod = "capnhat";
	function Capnhat()
	{
		parent::Controller();	
		//
		$this->load->config('config_'.$this->mod);
		//
		$this->view_dir = $this->mod.'/';
		// load default page into current view page, for default action
		$this->view_page =  $this->view_dir.'index';
		// select page layout
		$this->view_container = 'adm_container';
		// init feedback for user's actions
		$this->pre_message = "";
		$this->_curl_error = "";
		$this->html = "";
		$this->get_type = $this->config->item('get_type');
		$this->image_types = $this->config->item('allowed_types');
		$this->upload_dir = $this->config->item('upload_dir');
		$this->base_url = URL;
		/*-------------------------------+
		|  CPANEL LIB                    |
		|  use for manage			     |
		+--------------------------------*/
		$this->identity = $this->session->userdata($this->config->item('identity'));
		$this->accesslvl = $this->cpanel_lib->accesslvl;
		$this->id = $this->cpanel_lib->get_userid();
		$this->profile = $this->cpanel_lib->query_main;
		// load necessary libraries
		$this->load->helper('file');
		$this->load->model($this->mod.'_model', 'mmod');
	}
	
	function index()
	{
		$this->session->set_userdata('time', 0);
				
		$data['page_title'] = 'Crawl';
		$this->view_page = $this->view_dir.'index';
		$this->load->vars($data);
		$this->load->view($this->view_container);
	}

	function _getcontent($url="", $type=1, $timeout=20)
	{
		if(empty($url)) return false;
		
		switch($type)
		{
			case 1:
				$header[] = "Accept: text/xml,application/xml,application/xhtml+xml, text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
				$header[] = "Cache-Control: max-age=0";
				$header[] = "Connection: keep-alive";
				$header[] = "Keep-Alive: 300";
				$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
				$header[] = "Accept-Language: en-us,en;q=0.5";
				$header[] = "Pragma: no-cache";
				
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
				curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
				curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
				curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
				curl_setopt($curl, CURLOPT_AUTOREFERER, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, round($timeout/2));
				curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				$this->html = curl_exec($curl);
				$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				$this->_curl_error = curl_error($curl);
				
				curl_close($curl);
				#if($httpcode<200 or $httpcode>=300) return false;
				return $httpcode;
			break;
			case 2:
				$html = '';
				$file = fopen($url,'rb');
				while (!feof($file)) {
					$html .= fread($file, 8192);
				}
				fclose($file);
			break;
			case 3:
				$html = file_get_contents($url);
			break;
			default:
				$header[] = "Accept: text/xml,application/xml,application/xhtml+xml, text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
				$header[] = "Cache-Control: max-age=0";
				$header[] = "Connection: keep-alive";
				$header[] = "Keep-Alive: 300";
				$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
				$header[] = "Accept-Language: en-us,en;q=0.5";
				$header[] = "Pragma: ";
				
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
				curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
				curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
				curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
				curl_setopt($curl, CURLOPT_AUTOREFERER, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, round($timeout/2));
				curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        
				$this->html = curl_exec($curl);
				$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				$this->_curl_error = curl_error($curl);
				
				curl_close($curl);
				#if($httpcode<200 or $httpcode>=300) return false;
				return $httpcode;
		}
		return $html;
	}
	
	function _cut_string($str, $str_start, $str_end)
	{
		if(empty($str)) return false;
		
		$find_str_start = strpos($str, $str_start);
		
		if($find_str_start===false) return false;
		
		$start = (int)$find_str_start+strlen($str_start);
		
		$end = strpos($str, $str_end, $start);

		if($end===false) return false;

		$content = substr($str, $start, $end-$start);
		
		return $content;
	}

	function _get_link($html, $str_start, $str_end)
	{
		if(empty($html)) return false;
		
		$temp1 = $this->_cut_string($html, $str_start, $str_end);
		$str_href = 'href="';
		$find_start = strpos($temp1, $str_href);
		if($find_start !== false)
		{
			
			$start = $find_start + strlen($str_href);
			$end = strpos($temp1, '"', $start);
		}
		else
		{
			$str_href = "href='";
			$find_start = strpos($temp1, $str_href);
			if($find_start !== false)
			{
				$start = $find_start + strlen($str_href);
				$end = strpos($temp1, "'", $start);
			}
			else
			{
				$str_href = 'href=';
				$find_start = strpos($temp1, $str_href);
				if($find_start !== false)
				{
					$start = $find_start + strlen($str_href);
					$end = strpos($temp1, ">", $start);
				}
			}
		}

		if($find_start === false or $end === false) return false;
		
		$link = trim(trim(trim(substr($temp1, $start, $end-$start),'"') , "'"));
		
		return $link;
	}

	function _get_title($html, $str_start, $str_end)
	{
		if(empty($html)) return false;
		
		$content = $this->_cut_string($html, $str_start, $str_end);
		
		return $content;
	}
	
	function _get_intro($html, $str_start, $str_end)
	{
		if(empty($html)) return false;

		$content = $this->_cut_string($html, $str_start, $str_end);
		
		return $content;
	}

	function _get_author($html, $str_start, $str_end)
	{
		if(empty($html)) return false;

		$content = $this->_cut_string($html, $str_start, $str_end);
		
		return $content;
	}

	function _get_content($html, $str_start, $str_end)
	{
		if(empty($html)) return false;

		$content = $this->_cut_string($html, $str_start, $str_end);
		
		return $content;
	}
	
	function _get_image($url, $path_save, $name)
	{
		if(empty($url) or !@getimagesize($url)) return false;

		$httpcode = $this->_getcontent($url, $this->get_type);
		if($httpcode<200 or $httpcode>=300) return  false;

		file_put_contents($path_save.$name, $this->html);	
		return $path_save.$name;
	}
	
	function _cut_arrayImg_string($str, $str_start, $str_end)
	{
		if(empty($str)) return false;
		
		$content = array();
		
		while(!empty($str))
		{
			$start = strpos($str, $str_start)+strlen($str_start);
			
			$end = $start>= strlen($str) ? false : strpos($str, $str_end, $start);
	
			
			if($start!==false and $end !==false)
			{
				if($start<$end)
				{
					$temp = substr($str, $start, $end-$start);
					$ar = explode('.', $temp);
					$n = sizeof($ar)-1;
					$img_type = explode('|', $this->image_types);
					if(!empty($ar[$n]) and in_array($ar[$n], $img_type))
					{
						$content[] = $temp;
					}
				}	
				$str = substr($str, $end+1);
			}
			
			if($start===false or $end===false) $str = '';
			
		}
		
		return $content;
	}

	function _cut_arrayYoutube_string($str, $str_start, $str_end)
	{
		if(empty($str)) return false;
		
		$content = array();
		
		while(!empty($str))
		{
			$start = strpos($str, $str_start)+strlen($str_start);
			
			$end = $start>= strlen($str) ? false : strpos($str, $str_end, $start);
	
			
			if($start!==false and $end !==false)
			{
				if($start<$end)
				{
					$temp = substr($str, $start, $end-$start);
					if(strpos($temp, 'youtube.com')!==false)
					{
						$content[] = $temp;
					}
				}	
				$str = substr($str, $end+1);
			}
			
			if($start===false or $end===false) $str = '';
			
		}
		
		return $content;
	}
	
	function _get_video($url, $path_save, $name)
	{
		if(empty($url)) return false;

		$httpcode = $this->_getcontent($url, $this->get_type, 55);
		if($httpcode<200 or $httpcode>=300) return  false;
		
		file_put_contents($path_save.$name, $this->html);	
		return $path_save.$name;
	}
	
	function _cut_arrayVideo_string($str, $str_start, $str_end)
	{// $str_end equal .type
		if(empty($str)) return false;
		
		$content = array();
		
		while(!empty($str))
		{
			$start = strpos($str, $str_start)+strlen($str_start);
			
			$end = $start>= strlen($str) ? false : strpos($str, $str_end, $start);
	
			
			if($start!==false and $end !==false)
			{
				if($start<$end)
				{
					$temp = substr($str, $start, $end-$start);
					$ar = explode('.', $str_end);
					$n = sizeof($ar)-1;
					$img_type = explode('|', $this->image_types);
					if(!empty($ar[$n]) and in_array($ar[$n], $img_type))
					{
						$content[] = trim($temp.$str_end);
					}
				}	
				$str = substr($str, $end+1);
			}
			
			if($start===false or $end===false) $str = '';
			
		}
		
		return $content;
	}

	function __run()
	{// read news_pattern
		$message = array();
		$rs = $this->mmod->select_all_pattern();
		if($rs)
		{
			foreach($rs->result() as $row)
			{
				$id_crawler = $row->id;
				$url2link = $row->links;//"http://www.vnexpress.net/GL/Xa-hoi/";
				$website = $row->website;//'http://www.vnexpress.net';
				$cat = $row->id_nwc;
				$cattext = $row->id_cattext;
				
				$link_start = $row->html_open;//'<div class="folder-top">';
				$link_end = $row->html_close;//'<img class="img-topsubject fl"';
				
				$content_start = $row->content_open;//'cpms_content="true">';
				$content_end = $row->content_close;//'</div>';
				
				$title_start = $row->title_open;//'<P class=Title>';
				$title_end = $row->title_close;//'</P>';
				
				$intro_start = $row->intro_open;//'<P class=Lead>';
				$intro_end = $row->intro_close;//'</P>';
				
				$author_start = $row->author_open;//'<P class=Normal align=right>';
				$author_end = $row->author_close;//'</P>';
		
				// get link
				$times = time();
				$link = $this->_get_link($url2link, $link_start, $link_end);
				if($link == 'Low')
				{
					$this->pre_message = 'Không lấy được link do site load quá chậm.';
					// write log
					$log['website'] = $url2link;
					$log['id_crawler'] = $id_crawler;
					$log['id_nwc'] = $cat;
					$log['links'] = '';
					$log['status'] = 'Low';
					$log['times'] = $times;
					$log['notes'] = $this->pre_message;
					$this->_write_log($log);
					return;
				}
				//
				while(strpos($link, ' ')!==false)
				{
					$link = str_replace(' ', '', $link);
				}
				
				$check1 = strpos($link, "'")===false? true: false;
				$check2 = strpos($link, ">")===false? true: false;
				$check3 = strpos($link, '"')===false? true: false;
				$check4 = strpos($link, ' ')===false? true: false;
				
				if($link and $link!=$website and $check1 and $check2 and $check3 and $check4)
				{// get news (html)
					$link = strpos($link, 'http://')!==false ? $link : $website.$link;
					// link active?
					$check_cat3w = strpos($url2link, 'www')===false? false : true;
					$check_3w = strpos($link, 'www')===false? false : true;
					if($check_cat3w and !$check_3w)
					{
						$link = str_replace('http://', 'http://www.', $link);
					}
					// trip label
					$find_lbl = strpos($link, '#');
					if($find_lbl!==false)
					{
						$label = substr($link, $find_lbl);
						$link = str_replace($label, '', $link);
					}
					$link = htmlspecialchars_decode($link);
					$html = $this->_getcontent($link, $this->get_type);
					if($html)
					{
						// cut title
						$title = $this->_get_title($html, $title_start, $title_end);
						
						if(!empty($title))
						{
							$title = addslashes(htmlspecialchars_decode(trim(strip_tags($title))));
							$exist = $this->mmod->check_news($link, $title);
							if(!$exist)
							{
								// cut content
								$content = $this->_get_content($html, $content_start, $content_end);
								#echo '<span>'.$content.'</span><br>';
								// cut intro
								$intro = (empty($intro_start) or empty($intro_end))? '' : $this->_get_intro($html, $intro_start, $intro_end);
								#echo $intro.'<br>';
								
								// cut author
								$author = 'Theo '.$row->name;#$this->_get_author($html, $author_start, $author_end);
								#echo $author.'<br>';
								if(!empty($content))
								{// cut bad string
									$content = str_replace('<script type="text/javascript">window.onload = function () {resizeNewsImage("news-image", 500);}</script>', '', $content);// for 24h.com.vn
									$content = str_replace('<IMG class=logo src="/common/v3/images/vietnamnet.gif" >', '', $content);// for vietnamnet.vn
									// make directory
									$upload_path = $this->upload_dir.'news/'.date('m_Y').'/';
									if(!is_dir($upload_path)) mkdir($upload_path);
									// get image
									$img_start = 'src="';
									$img_end = '"';
									$ar = $this->_cut_arrayImg_string($content, $img_start, $img_end);
									$ar_image = array();
									if(!empty($ar))
									{
										foreach($ar as $key=>$vl)
										{
											$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
											//
											if(strpos($vl, 'youtube.com')===false)
											{
												$path = @getimagesize($path) ? $path : $link.$vl;
												//
												$ar_src = explode('/', $path);
												$n = sizeof($ar_src)-1;
												$img_name = $ar_src[$n];
												$ar_img = explode('.', $img_name);
												if(is_array($ar_img))
												{
													$type = $ar_img[sizeof($ar_img)-1];
													$image = $this->_get_image($path, $upload_path, time().'_'.$id_crawler.'_'.$key.'.'.$type);
													if($image)
													{
														$image = str_replace('../', '', $image);
														$content = str_replace($vl, $this->base_url.$image, $content);
														array_push($ar_image, $image);
													}
												}
											}
										}
									}
									// get video
									$ar_video = array();
									$video_start = 'file=';
									$video_end = '.flv';
									$ar1 = $this->_cut_arrayVideo_string($content, $video_start, $video_end);
									if(!empty($ar1))
									{
										foreach($ar1 as $key=>$vl)
										{
											$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
											//
											$video = $this->_get_video(trim($path), $upload_path, time().'_'.$id_crawler.'_'.$key.'.flv');
											if($video)
											{
												$video = str_replace('../', '', $video);
												$content = str_replace($vl, $this->base_url.$video, $content);
												array_push($ar_video, $video);
											}
											/*else
											{
												$path = $link.$vl;
												$video = $this->_get_video(trim($path), $upload_path, time().'_'.$id_crawler.'_'.$key.'.flv');
												if($video)
												{
													$video = str_replace('../', '', $video);
													$content = str_replace($vl, $this->base_url.$video, $content);
													array_push($ar_video, $video);
												}
											}*/
											
										}
									}
									// get youtube
									$youtube_start = 'src="';
									$youtube_end = '"';
									$ar2 = $this->_cut_arrayYoutube_string($content, $youtube_start, $youtube_end);
									if(!empty($ar2))
									{
										foreach($ar2 as $key=>$vl)
										{
											array_push($ar_video, $vl);
										}
									}
		
									$intro = addslashes(htmlspecialchars_decode(trim(strip_tags($intro))));
									$author = addslashes(htmlspecialchars_decode(trim(strip_tags($author))));
									$this->load->helper('removed_sign');
									// insert db
									$value['id_nwc'] = $cat;
									$value['id_cattext'] = $cattext;
									$value['id_text'] = url_title(removed_sign($title));
									$value['news_title'] = $title;
									$value['news_content'] = $content;
									$value['news_quickview'] = $intro;
									$value['news_author'] = $author;
									$value['news_link'] = $link;
									$value['news_img'] = empty($ar_image[0]) ? '' : $ar_image[0];
									$value['news_meta'] = empty($ar_image) ? '' : implode('~', $ar_image);
									$value['news_video'] = empty($ar_video[0]) ? '' : $ar_video[0];
									$value['news_video_meta'] = empty($ar_video) ? '' : implode('~', $ar_video);
									$value['news_date'] = $times;
									$value['news_audit'] = 0;
									$exist = $this->mmod->check_news($link, $title);
									if(!$exist)
									{
										if($this->mmod->insert($value))
										{
											$this->pre_message = 'Thành công!';
											// write log
											$log['id_news'] = $this->db->insert_id();
											$log['id_nwc'] = $cat;
											$log['website'] = $url2link;
											$log['id_crawler'] = $id_crawler;
											$log['links'] = $link;
											$log['news_title'] = $title;
											$log['status'] = 'Success';
											$log['notes'] = $this->pre_message;
											$log['times'] = $times;
											$this->_write_log($log);
										}
										else
										{
											$this->pre_message = 'Lỗi: cập nhật dữ liệu!';
											// write log
											$log['website'] = $url2link;
											$log['id_crawler'] = $id_crawler;
											$log['id_nwc'] = $cat;
											$log['links'] = $link;
											$log['news_title'] = $title;
											$log['status'] = 'False';
											$log['times'] = $times;
											$log['notes'] = $this->pre_message;
											$this->_write_log($log);
										}
									}
									else
									{
										$message_intro = $intro===false ? 'False: Cấu trúc xem nhanh chưa khớp.' : '';
										$message_content = $content ? '' : 'False: Cấu trúc nội dung chưa khớp.';
										$this->pre_message = "Không lấy được! $message_intro $message_content";
										$status = 'False';
										// write log
										$log['website'] = $url2link;
										$log['id_crawler'] = $id_crawler;
										$log['id_nwc'] = $cat;
										$log['links'] = $link;
										$log['status'] = $status;
										$log['times'] = $times;
										$log['notes'] = $this->pre_message;
										$this->_write_log($log);
									}
								}
								else
								{
									$message_intro = $intro===false ? 'False: Cấu trúc xem nhanh chưa khớp.' : '';
									$message_content = $content ? '' : 'False: Cấu trúc nội dung chưa khớp.';
									$this->pre_message = "Không lấy được! $message_intro $message_content";
									// write log
									$log['website'] = $url2link;
									$log['id_crawler'] = $id_crawler;
									$log['id_nwc'] = $cat;
									$log['links'] = $link;
									$log['status'] = 'False';
									$log['times'] = $times;
									$log['notes'] = $this->pre_message;
									$this->_write_log($log);
								}
							}
							else
							{
								$this->pre_message = 'Không có tin mới!';
								// write log
								$log['website'] = $url2link;
								$log['id_crawler'] = $id_crawler;
								$log['id_nwc'] = $cat;
								$log['links'] = $link;
								$log['status'] = 'No_news';
								$log['times'] = $times;
								$log['notes'] = $this->pre_message;
								$this->_write_log($log);
							}
						}
						else
						{
							$message_link = $link!=$website ? '' : 'False: Cấu trúc link bản tin chưa khớp.';
							$message_title = $title ? '' : 'False: Cấu trúc tiêu đề chưa khớp.';
							$this->pre_message = "Không lấy được! $message_link $message_title";
							// write log
							$log['website'] = $url2link;
							$log['id_crawler'] = $id_crawler;
							$log['id_nwc'] = $cat;
							$log['links'] = $link;
							$log['status'] = 'False';
							$log['times'] = $times;
							$log['notes'] = $this->pre_message;
							$this->_write_log($log);
						}
					}
					else
					{
						$this->pre_message = 'Không lấy được nội dung do site load quá chậm.';
						// write log
						$log['website'] = $url2link;
						$log['id_crawler'] = $id_crawler;
						$log['id_nwc'] = $cat;
						$log['links'] = '';
						$log['status'] = 'Low';
						$log['times'] = $times;
						$log['notes'] = $this->pre_message;
						$this->_write_log($log);
						return;
					}
				}
				else
				{
					$message_link = 'False: Cấu trúc lấy link chưa khớp.';
					$this->pre_message = "Không lấy được! $message_link";
					// write log
					$log['website'] = $url2link;
					$log['id_crawler'] = $id_crawler;
					$log['id_nwc'] = $cat;
					$log['links'] = $link;
					$log['status'] = 'False';
					$log['times'] = $times;
					$log['notes'] = $this->pre_message;
					$this->_write_log($log);
				}
				array_push($message, $this->pre_message.'<hr />');
			}
		}
		$data['message'] = $message;
		$data['heading'] = 'Auto news';
		$this->view_page = $this->view_dir.'index';
		$this->load->vars($data);
		$this->load->view($this->view_page);
	}
	
	function process()
	{
		$process = $this->session->userdata('time');
		if($process<=53)
		{
			$offset = $process*5;
			$limit = 5;
			$is_video = $process==53? true : false; 
			
			$this->_run($is_video, $offset, $limit);
			$process++;
			$this->session->set_userdata('time', $process);
		}
		echo $process;
	}
		
	function _run($is_video=false, $from=0, $to=100)
	{// read news_pattern
		$status = 'Not found';
		$set_crawl_id = array();
		$rs = $this->mmod->get_crawl_id($is_video, $from, $to);
		if($rs)
		{
			foreach($rs->result() as $rw)
			{
				array_push($set_crawl_id, $rw->id);
			}
		}
		
		$result = $this->mmod->get_crawl_info($set_crawl_id);
		if($result)
		{
			foreach ($result->result() as $row)
			{
				$id_crawler = $row->id;
				$url2link = $row->links;//"http://www.vnexpress.net/GL/Xa-hoi/";
				$website = $row->website;//'http://www.vnexpress.net';
				$cat = $row->id_nwc;
				$cattext = $row->id_cattext;
				
				$link_start = $row->html_open;//'<div class="folder-top">';
				$link_end = $row->html_close;//'<img class="img-topsubject fl"';
				
				$content_start = $row->content_open;//'cpms_content="true">';
				$content_end = $row->content_close;//'</div>';
				
				$title_start = $row->title_open;//'<P class=Title>';
				$title_end = $row->title_close;//'</P>';
				
				$intro_start = $row->intro_open;//'<P class=Lead>';
				$intro_end = $row->intro_close;//'</P>';
				
				$author_start = $row->author_open;//'<P class=Normal align=right>';
				$author_end = $row->author_close;//'</P>';
		
				// get link
				$times = time();
				
				$httpcode = $this->_getcontent($url2link, $this->get_type);
				if($httpcode<200 or $httpcode>=300)	
				{
					$this->pre_message = 'Link: '.$this->_curl_error.' ('.$httpcode.')';
					// write log
					$log['website'] = $url2link;
					$log['id_crawler'] = $id_crawler;
					$log['id_nwc'] = $cat;
					$log['links'] = '';
					$log['status'] = 'Low';
					$log['times'] = $times;
					$log['notes'] = $this->pre_message;
					$this->_write_log($log);
					return;
				}
				
				$link = $this->_get_link($this->html, $link_start, $link_end);
				//
				while(strpos($link, ' ')!==false)
				{
					$link = str_replace(' ', '', $link);
				}
				
				$check1 = strpos($link, "'")===false? true: false;
				$check2 = strpos($link, ">")===false? true: false;
				$check3 = strpos($link, '"')===false? true: false;
				$check4 = strpos($link, ' ')===false? true: false;
				
				if($link and $link!=$website and $check1 and $check2 and $check3 and $check4)
				{// get news (html)
					$link = strpos($link, 'http://')!==false ? $link : $website.$link;
					// link active?
					$check_cat3w = strpos($url2link, 'www')===false? false : true;
					$check_3w = strpos($link, 'www')===false? false : true;
					if($check_cat3w and !$check_3w)
					{
						$link = str_replace('http://', 'http://www.', $link);
					}
					// trip label
					$find_lbl = strpos($link, '#');
					if($find_lbl!==false)
					{
						$label = substr($link, $find_lbl);
						$link = str_replace($label, '', $link);
					}
					$link = htmlspecialchars_decode($link);
					
					$httpcode = $this->_getcontent($link, $this->get_type);
					if($httpcode<200 or $httpcode>=300)	
					{
						$this->pre_message = 'News: '.$this->_curl_error.' ('.$httpcode.')';
						// write log
						$log['website'] = $url2link;
						$log['id_crawler'] = $id_crawler;
						$log['id_nwc'] = $cat;
						$log['links'] = $link;
						$log['status'] = 'Low';
						$log['times'] = $times;
						$log['notes'] = $this->pre_message;
						$this->_write_log($log);
						return;
					}
					// cut title
					$title = $this->_get_title($this->html, $title_start, $title_end);
					
					if(!empty($title))
					{
						$title = addslashes(htmlspecialchars_decode(trim(strip_tags($title))));
						$exist = $this->mmod->check_news($link, $title);
						if(!$exist)
						{
							$html = $this->html;
							// cut content
							$content = $this->_get_content($html, $content_start, $content_end);
							#echo '<span>'.$content.'</span><br>';
							// cut intro
							$intro = (empty($intro_start) or empty($intro_end))? '' : $this->_get_intro($html, $intro_start, $intro_end);
							#echo $intro.'<br>';
							
							// cut author
							$author = 'Theo '.$row->name;#$this->_get_author($html, $author_start, $author_end);
							#echo $author.'<br>';
							if(!empty($content))
							{// cut bad string
								$content = str_replace('<script type="text/javascript">window.onload = function () {resizeNewsImage("news-image", 500);}</script>', '', $content);// for 24h.com.vn
								$content = str_replace('<IMG class=logo src="/common/v3/images/vietnamnet.gif" >', '', $content);// for vietnamnet.vn
								// make directory
								$upload_path = $this->upload_dir.'news/'.date('m_Y').'/';
								if(!is_dir($upload_path)) mkdir($upload_path);
								// get image
								$img_start = 'src="';
								$img_end = '"';
								$ar = $this->_cut_arrayImg_string($content, $img_start, $img_end);
								$ar_image = array();
								if(!empty($ar))
								{
									foreach($ar as $key=>$vl)
									{
										$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
										//
										$path = @getimagesize($path) ? $path : $link.$vl;
										//
										$ar_src = explode('/', $path);
										$n = sizeof($ar_src)-1;
										$img_name = $ar_src[$n];
										$ar_img = explode('.', $img_name);
										if(is_array($ar_img)) $type = $ar_img[sizeof($ar_img)-1];
										$image = $this->_get_image($path, $upload_path, time().'_'.$id_crawler.'_'.$key.'.'.$type);
										if($image)
										{
											$image = str_replace('../', '', $image);
											$content = str_replace($vl, $this->base_url.$image, $content);
											array_push($ar_image, $image);
										}
									}
								}
								// get video
								$ar_video = array();
								$video_start = 'file=';
								$video_end = '.flv';
								$ar1 = $this->_cut_arrayVideo_string($content, $video_start, $video_end);
								if(!empty($ar1))
								{
									foreach($ar1 as $key=>$vl)
									{
										$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
										//
										$video = $this->_get_video(trim($path), $upload_path, time().'_'.$id_crawler.'_'.$key.'.flv');
										if($video)
										{
											$video = str_replace('../', '', $video);
											$content = str_replace($vl, $this->base_url.$video, $content);
											array_push($ar_video, $video);
										}
										/*else
										{
											$path = $link.$vl;
											$video = $this->_get_video(trim($path), $upload_path, time().'_'.$id_crawler.'_'.$key.'.flv');
											if($video)
											{
												$video = str_replace('../', '', $video);
												$content = str_replace($vl, $this->base_url.$video, $content);
												array_push($ar_video, $video);
											}
										}*/
										
									}
								}
								// get youtube
								$youtube_start = 'src="';
								$youtube_end = '"';
								$ar2 = $this->_cut_arrayYoutube_string($content, $youtube_start, $youtube_end);
								if(!empty($ar2))
								{
									foreach($ar2 as $key=>$vl)
									{
										array_push($ar_video, $vl);
									}
								}
								$intro = addslashes(htmlspecialchars_decode(trim(strip_tags($intro))));
								$author = addslashes(htmlspecialchars_decode(trim(strip_tags($author))));
								$this->load->helper('removed_sign');
								// insert db
								$value['id_nwc'] = $cat;
								$value['id_cattext'] = $cattext;
								$value['id_text'] = url_title(removed_sign($title));
								$value['news_title'] = $title;
								$value['news_content'] = $content;
								$value['news_quickview'] = $intro;
								$value['news_author'] = $author;
								$value['news_link'] = $link;
								$value['news_img'] = empty($ar_image[0]) ? '' : $ar_image[0];
								$value['news_meta'] = empty($ar_image) ? '' : implode('~', $ar_image);
								$value['news_video'] = empty($ar_video[0]) ? '' : $ar_video[0];
								$value['news_video_meta'] = empty($ar_video) ? '' : implode('~', $ar_video);
								$value['news_date'] = $times;
								$value['news_audit'] = 0;
								$exist = $this->mmod->check_news($link, $title);
								if(!$exist)
								{
									if($this->db->insert('news', $value))
									{
										$this->pre_message = 'Thành công!';
										$status = 'Success';
										// write log
										$log['id_news'] = $this->db->insert_id();
										$log['id_nwc'] = $cat;
										$log['website'] = $url2link;
										$log['id_crawler'] = $id_crawler;
										$log['links'] = $link;
										$log['news_title'] = $title;
										$log['status'] = $status;
										$log['notes'] = $this->pre_message;
										$log['times'] = $times;
										$this->_write_log($log);
									}
									else
									{
										$this->pre_message = 'Lỗi: cập nhật dữ liệu!';
										$status = 'False';
										// write log
										$log['website'] = $url2link;
										$log['id_crawler'] = $id_crawler;
										$log['id_nwc'] = $cat;
										$log['links'] = $link;
										$log['news_title'] = $title;
										$log['status'] = $status;
										$log['times'] = $times;
										$log['notes'] = $this->pre_message;
										$this->_write_log($log);
									}
								}
								else
								{
									$this->pre_message = 'Không có tin mới!';
									$status = 'No_news';
									// write log
									$log['website'] = $url2link;
									$log['id_crawler'] = $id_crawler;
									$log['id_nwc'] = $cat;
									$log['links'] = $link;
									$log['status'] = $status;
									$log['times'] = $times;
									$log['notes'] = $this->pre_message;
									$this->_write_log($log);
								}
							}
							else
							{
								$message_intro = $intro===false ? 'False: Cấu trúc xem nhanh chưa khớp.' : '';
								$message_content = $content ? '' : 'False: Cấu trúc nội dung chưa khớp.';
								$this->pre_message = "Không lấy được! $message_intro $message_content";
								$status = 'False';
								// write log
								$log['website'] = $url2link;
								$log['id_crawler'] = $id_crawler;
								$log['id_nwc'] = $cat;
								$log['links'] = $link;
								$log['status'] = $status;
								$log['times'] = $times;
								$log['notes'] = $this->pre_message;
								$this->_write_log($log);
							}
						}
						else
						{
							$this->pre_message = 'Không có tin mới!';
							$status = 'No_news';
							// write log
							$log['website'] = $url2link;
							$log['id_crawler'] = $id_crawler;
							$log['id_nwc'] = $cat;
							$log['links'] = $link;
							$log['status'] = $status;
							$log['times'] = $times;
							$log['notes'] = $this->pre_message;
							$this->_write_log($log);
						}
					}
					else
					{
						$message_link = $link!=$website ? '' : 'False: Cấu trúc link bản tin chưa khớp.';
						$message_title = $title ? '' : 'False: Cấu trúc tiêu đề chưa khớp.';
						$this->pre_message = "Không lấy được! $message_link $message_title";
						$status = 'False';
						// write log
						$log['website'] = $url2link;
						$log['id_crawler'] = $id_crawler;
						$log['id_nwc'] = $cat;
						$log['links'] = $link;
						$log['status'] = $status;
						$log['times'] = $times;
						$log['notes'] = $this->pre_message;
						$this->_write_log($log);
					}
				}
				else
				{
					$message_link = 'False: Cấu trúc lấy link chưa khớp.';
					$this->pre_message = "Không lấy được! $message_link";
					$status = 'False';
					// write log
					$log['website'] = $url2link;
					$log['id_crawler'] = $id_crawler;
					$log['id_nwc'] = $cat;
					$log['links'] = $link;
					$log['status'] = $status;
					$log['times'] = $times;
					$log['notes'] = $this->pre_message;
					$this->_write_log($log);
				}
			}
		}
		#echo $status;
	}

	function _write_log($value = array())
	{
		if(!empty($value))
		{// 
			if(!empty($value['website']))
			{
				$this->db->insert('autonews_logs', $value); 
			}
		}
	}
	
	/*function _parse_xpath($string='', $str_xpath='')
	{// 
		if(empty($string) or empty($str_xpath)) return FALSE;
		$return = array();
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = FALSE;
	
		@$doc->loadHTML($string);
		$doc->normalizeDocument();
	
		$xpath = new DOMXPath($doc);
	
		static $root = '/html/quangcao';
		static $xqueries = array(
			'type' =>	'/@type',
			'ma' =>	'/ma',
			'ten_vt' => 	'/ten_vt',
			'loai_vt' => 	'/loai_vt',
			'ten_qc' => 	'/ten_qc',
			'hinh' =>	'/hinh',
			'meta' =>	'/meta',
			'links' =>	'/links',
			'weight' =>	'/weight',
			'hethan' =>	'/hethan',
			'shown' =>	'/shown'
		);
	
		foreach ($xqueries as $key=>$xquery) {
			$$key = array();
		}
		foreach ($xqueries as $key=>$xquery) {
			$entries = $xpath->query($root . $xquery);
			$title = $$key;
			foreach ($entries as $entry) {
				$title[] = $entry->nodeValue;
			}
			$return["$key"] = $title;
		}
		return $return;
	}
	
	function __run($id_crawler)
	{// read website_pattern
		$status = 'Not found';
		$rs = $this->mmod->get_a_pattern($id_crawler);
		if($rs)
		{
			$row = $rs->row();
		
			$id_crawler = $row->id;
			$url2link = $row->links;//"http://www.vnexpress.net/GL/Xa-hoi/";
			$website = $row->website;//'http://www.vnexpress.net';
			$name = $row->name;//'Vnexpress';
			$cat = $row->id_nwc;
			$cattext = $row->id_cattext;
			
			$link_xpath = $row->link_xpath;
			$link_bad = $row->link_bad;
			$link_start = $row->link_open;//'<div class="folder-top">';
			$link_end = $row->link_close;//'<img class="img-topsubject fl"';
			
			$content_xpath = $row->content_xpath;
			$content_bad = $row->content_bad;
			$content_start = $row->content_open;//'cpms_content="true">';
			$content_end = $row->content_close;//'</div>';
			
			$title_xpath = $row->title_xpath;
			$title_bad = $row->title_bad;
			$title_start = $row->title_open;//'<P class=Title>';
			$title_end = $row->title_close;//'</P>';
			
			$intro_xpath = $row->intro_xpath;
			$intro_bad = $row->intro_bad;
			$intro_start = $row->intro_open;//'<P class=Lead>';
			$intro_end = $row->intro_close;//'</P>';
			
			$author_xpath = $row->author_xpath;
			$author_bad = $row->author_bad;
			$author_start = $row->author_open;//'<P class=Normal align=right>';
			$author_end = $row->author_close;//'</P>';
	
			// get link
			$times = time();
			$link = $this->_get_link($url2link, $link_start, $link_end);
			if($link == 'Low')
			{
				$this->pre_message = 'Không lấy được link do site load quá chậm.';
				// write log
				$log['website'] = $url2link;
				$log['id_crawler'] = $id_crawler;
				$log['id_nwc'] = $cat;
				$log['links'] = '';
				$log['status'] = 'Low';
				$log['times'] = $times;
				$log['notes'] = $this->pre_message;
				$this->_write_log($log);
				return;
			}
			//
			while(strpos($link, ' ')!==false)
			{
				$link = str_replace(' ', '', $link);
			}
			
			$check1 = strpos($link, "'")===false? true: false;
			$check2 = strpos($link, ">")===false? true: false;
			$check3 = strpos($link, '"')===false? true: false;
			$check4 = strpos($link, ' ')===false? true: false;
			
			if($link and $link!=$website and $check1 and $check2 and $check3 and $check4)
			{// get news (html)
				$link = strpos($link, 'http://')!==false ? $link : $website.$link;
				// link active?
				$check_cat3w = strpos($url2link, 'www')===false? false : true;
				$check_3w = strpos($link, 'www')===false? false : true;
				if($check_cat3w and !$check_3w)
				{
					$link = str_replace('http://', 'http://www.', $link);
				}
				// trip label
				$find_lbl = strpos($link, '#');
				if($find_lbl!==false)
				{
					$label = substr($link, $find_lbl);
					$link = str_replace($label, '', $link);
				}
				$link = htmlspecialchars_decode($link);
				$html = $this->_getcontent($link, $this->get_type);
				if($html)
				{
					// cut title
					$title = $this->_get_title($html, $title_start, $title_end);
					
					if(!empty($title))
					{
						$title = addslashes(htmlspecialchars_decode(trim(strip_tags($title))));
						$exist = $this->mmod->check_news($link, $title);
						if(!$exist)
						{
							// cut content
							$content = $this->_get_content($html, $content_start, $content_end);
							#echo '<span>'.$content.'</span><br>';
							// cut intro
							$intro = (empty($intro_start) or empty($intro_end))? '' : $this->_get_intro($html, $intro_start, $intro_end);
							#echo $intro.'<br>';
							
							// cut author
							$author = 'Theo '.$row->name;#$this->_get_author($html, $author_start, $author_end);
							#echo $author.'<br>';
							if(!empty($content))
							{// cut bad string
								$content = str_replace('<script type="text/javascript">window.onload = function () {resizeNewsImage("news-image", 500);}</script>', '', $content);// for 24h.com.vn
								$content = str_replace('<IMG class=logo src="/common/v3/images/vietnamnet.gif" >', '', $content);// for vietnamnet.vn
								// make directory
								$upload_path = $this->config->item('upload_dir').'news/'.date('m_Y').'/';
								if(!is_dir($upload_path)) mkdir($upload_path);
								// get image
								$img_start = 'src="';
								$img_end = '"';
								$ar = $this->_cut_arrayImg_string($content, $img_start, $img_end);
								$ar_image = array();
								if(!empty($ar))
								{
									foreach($ar as $key=>$vl)
									{
										$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
										//
										$path = @getimagesize($path) ? $path : $link.$vl;
										//
										$ar_src = explode('/', $path);
										$n = sizeof($ar_src)-1;
										$img_name = $ar_src[$n];
										$ar_img = explode('.', $img_name);
										if(is_array($ar_img)) $type = $ar_img[sizeof($ar_img)-1];
										$image = $this->_get_image($path, $upload_path, time().'_'.$id_crawler.'_'.$key.'.'.$type);
										if($image)
										{
											$content = str_replace($vl, base_url().$image, $content);
											array_push($ar_image, $image);
										}
									}
								}
								// get video
								$ar_video = array();
								$video_start = 'file=';
								$video_end = '.flv';
								$ar1 = $this->_cut_arrayVideo_string($content, $video_start, $video_end);
								if(!empty($ar1))
								{
									foreach($ar1 as $key=>$vl)
									{
										$path = strpos($vl, 'http://')!==false ? $vl : $website.$vl;
										//
										$video = $this->_get_video(trim($path), $upload_path, time().'_'.$id_crawler.'_'.$key.'.flv');
										if($video)
										{
											$video = str_replace('../', '', $video);
											$content = str_replace($vl, base_url().$video, $content);
											array_push($ar_video, $video);
										}
									}
								}
								// get youtube
								$youtube_start = 'src="';
								$youtube_end = '"';
								$ar2 = $this->_cut_arrayYoutube_string($content, $youtube_start, $youtube_end);
								if(!empty($ar2))
								{
									foreach($ar2 as $key=>$vl)
									{
										array_push($ar_video, $vl);
									}
								}
								
								$intro = addslashes(htmlspecialchars_decode(trim(strip_tags($intro))));
								$author = addslashes(htmlspecialchars_decode(trim(strip_tags($author))));
								$this->load->helper('removed_sign');
								// insert db
								$value['id_nwc'] = $cat;
								$value['id_cattext'] = $cattext;
								$value['id_text'] = url_title(removed_sign($title));
								$value['news_title'] = $title;
								$value['news_content'] = $content;
								$value['news_quickview'] = $intro;
								$value['news_author'] = $author;
								$value['news_link'] = $link;
								$value['news_img'] = empty($ar_image[0]) ? '' : $ar_image[0];
								$value['news_meta'] = empty($ar_image) ? '' : implode('~', $ar_image);
								$value['news_video'] = empty($ar_video[0]) ? '' : $ar_video[0];
								$value['news_video_meta'] = empty($ar_video) ? '' : implode('~', $ar_video);
								$value['news_date'] = $times;
								$value['news_audit'] = 0;
								$exist = $this->mmod->check_news($link, $title);
								if(!$exist)
								{
									if($this->mmod->insert($value))
									{
										$this->pre_message = 'Thành công!';
										$status = 'Success';
										// write log
										$log['id_news'] = $this->db->insert_id();
										$log['id_nwc'] = $cat;
										$log['website'] = $url2link;
										$log['id_crawler'] = $id_crawler;
										$log['links'] = $link;
										$log['news_title'] = $title;
										$log['status'] = $status;
										$log['notes'] = $this->pre_message;
										$log['times'] = $times;
										$this->_write_log($log);
									}
									else
									{
										$this->pre_message = 'Lỗi: cập nhật dữ liệu!';
										$status = 'False';
										// write log
										$log['website'] = $url2link;
										$log['id_crawler'] = $id_crawler;
										$log['id_nwc'] = $cat;
										$log['links'] = $link;
										$log['news_title'] = $title;
										$log['status'] = $status;
										$log['times'] = $times;
										$log['notes'] = $this->pre_message;
										$this->_write_log($log);
									}
								}
								else
								{
									$this->pre_message = 'Không có tin mới!';
									$status = 'No_news';
									// write log
									$log['website'] = $url2link;
									$log['id_crawler'] = $id_crawler;
									$log['id_nwc'] = $cat;
									$log['links'] = $link;
									$log['status'] = $status;
									$log['times'] = $times;
									$log['notes'] = $this->pre_message;
									$this->_write_log($log);
								}
							}
							else
							{
								$message_intro = $intro===false ? 'False: Cấu trúc xem nhanh chưa khớp.' : '';
								$message_content = $content ? '' : 'False: Cấu trúc nội dung chưa khớp.';
								$this->pre_message = "Không lấy được! $message_intro $message_content";
								$status = 'False';
								// write log
								$log['website'] = $url2link;
								$log['id_crawler'] = $id_crawler;
								$log['id_nwc'] = $cat;
								$log['links'] = $link;
								$log['status'] = $status;
								$log['times'] = $times;
								$log['notes'] = $this->pre_message;
								$this->_write_log($log);
							}
						}
						else
						{
							$this->pre_message = 'Không có tin mới!';
							$status = 'No_news';
							// write log
							$log['website'] = $url2link;
							$log['id_crawler'] = $id_crawler;
							$log['id_nwc'] = $cat;
							$log['links'] = $link;
							$log['status'] = $status;
							$log['times'] = $times;
							$log['notes'] = $this->pre_message;
							$this->_write_log($log);
						}
					}
					else
					{
						$message_link = $link!=$website ? '' : 'False: Cấu trúc link bản tin chưa khớp.';
						$message_title = $title ? '' : 'False: Cấu trúc tiêu đề chưa khớp.';
						$this->pre_message = "Không lấy được! $message_link $message_title";
						$status = 'False';
						// write log
						$log['website'] = $url2link;
						$log['id_crawler'] = $id_crawler;
						$log['id_nwc'] = $cat;
						$log['links'] = $link;
						$log['status'] = $status;
						$log['times'] = $times;
						$log['notes'] = $this->pre_message;
						$this->_write_log($log);
					}
				}
				else
				{
					$this->pre_message = 'Không lấy được nội dung do site load quá chậm.';
					// write log
					$log['website'] = $url2link;
					$log['id_crawler'] = $id_crawler;
					$log['id_nwc'] = $cat;
					$log['links'] = '';
					$log['status'] = 'Low';
					$log['times'] = $times;
					$log['notes'] = $this->pre_message;
					$this->_write_log($log);
					return;
				}
			}
			else
			{
				$message_link = 'False: Cấu trúc lấy link chưa khớp.';
				$this->pre_message = "Không lấy được! $message_link";
				$status = 'False';
				// write log
				$log['website'] = $url2link;
				$log['id_crawler'] = $id_crawler;
				$log['id_nwc'] = $cat;
				$log['links'] = $link;
				$log['status'] = $status;
				$log['times'] = $times;
				$log['notes'] = $this->pre_message;
				$this->_write_log($log);
			}
		}
		echo $status;
	}*/
	
	function display()
	{
		$url = 'http://datviet.com/tintuc/tin-viet-nam/index.1.html';
		$html = $this->_getcontent($url);
		echo $html = $html ? $html : 'Lỗi!';
	}
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
