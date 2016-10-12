<?php
class Get_lib{
	function __construct()
	{
		// init feedback for user's actions
		$this->pre_message = "";
		$this->_curl_error = "";
		$this->html = "";
		$this->get_type = 1;
		$this->image_types = 'gif|jpg|png|flv';
		$this->upload_dir = '../uploads/';
		$this->base_url = $_SERVER['HTTP_HOST']=='localhost' ? 'http://luocbao.com/' : 'http://luocbao.com';
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

	function run($is_video=false, $from=0, $to=100)
	{// read news_pattern
		$status = 'Not found';
		if($_SERVER['HTTP_HOST']=='localhost')
			$this->connect_db('localhost', 'root', '', 'autonews');
		else
			$this->connect_db('localhost', 'root', '123456', 'luocbao_autonews');
			
		$result = $this->get_crawl_info($is_video, $from, $to);
		if(! $result) die('not found');
		while ($row = mysql_fetch_object($result))
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
					$exist = $this->check_news($link, $title);
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
							// insert db
							$value['id_nwc'] = $cat;
							$value['id_cattext'] = $cattext;
							$value['id_text'] = $this->url_title($this->removed_sign($title));
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
							$exist = FALSE;//$this->check_news($link, $title);
							if(!$exist)
							{
								if($this->_insert('news', $value))
								{
									$this->pre_message = 'Thành công!';
									$status = 'Success';
									// write log
									$log['id_news'] = $this->insert_id();
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
		echo $status.$this->pre_message;
	}
	
	function _write_log($value = array())
	{
		if(!empty($value))
		{// 
			if(!empty($value['website']))
			{
				$this->_insert('autonews_logs', $value);
			}
		}
	}
	
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					  );

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		
		return trim(stripslashes($str));
	}
	
	function removed_sign($str)
	{
		if(empty($str)) return $str;
		$char_unicode = array(  
					'ạ','á','à','ả','ã','Ạ','Á','À','Ả','Ã',  
					'â','ậ','ấ','ầ','ẩ','ẫ','Â','Ậ','Ấ','Ầ','Ẩ','Ẫ',  
					'ă','ặ','ắ','ằ','ẳ','ẫ','Ă','Ắ','Ằ','Ẳ','Ẵ','Ặ',  
					'ê','ẹ','é','è','ẻ','ẽ','Ê','Ẹ','É','È','Ẻ','Ẽ',  
					'ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ',  
					'ọ','ộ','ổ','ỗ','ố','ồ','Ọ','Ộ','Ổ','Ỗ','Ố','Ồ','Ô','ô',  
					'ó','ò','ỏ','õ','Ó','Ò','Ỏ','Õ',  
					'ơ','ợ','ớ','ờ','ở','ỡ',  
					'Ơ','Ợ','Ớ','Ờ','Ở','Ỡ',  
					'ụ','ư','ứ','ừ','ử','ữ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','ự','Ự',  
					'ú','ù','ủ','ũ','Ú','Ù','Ủ','Ũ',  
					'ị','í','ì','ỉ','ĩ','Ị','Í','Ì','Ỉ','Ĩ',  
					'ỵ','ý','ỳ','ỷ','ỹ','Ỵ','Ý','Ỳ','Ỷ','Ỹ',  
					'đ','Đ' 
		);  

		$char_EN = array(  
					'a','a','a','a','a','A','A','A','A','A',  
					'a','a','a','a','a','a','A','A','A','A','A','A',  
					'a','a','a','a','a','a','A','A','A','A','A','A',  
					'e','e','e','e','e','e','E','E','E','E','E','E',  
					'e','e','e','e','e','E','E','E','E','E',  
					'o','o','o','o','o','o','O','O','O','O','O','O','O','o',  
					'o','o','o','o','O','O','O','O',  
					'o','o','o','o','o','o',  
					'O','O','O','O','O','O',  
					'u','u','u','u','u','u','U','U','U','U','U','U','u','U',  
					'u','u','u','u','U','U','U','U',  
					'i','i','i','i','i','I','I','I','I','I',  
					'y','y','y','y','y','Y','Y','Y','Y','Y',  
					'd','D'  
		); 
			 
		$char_unknow = array(  
					'ạ','&aacute;','&agrave;','ả','&atilde;','Ạ','&Aacute;','&Agrave;','Ả','&Atilde;',  
					'&acirc;','ậ','ấ','ầ','ẩ','ẫ','&Acirc;','Ậ','Ấ','Ầ','Ẩ','Ẫ',  
					'ă','ặ','ắ','ằ','ẳ','ẫ','Ă','Ắ','Ằ','Ẳ','Ẵ','Ặ',  
					'&ecirc;','ẹ','&eacute;','&egrave;','ẻ','ẽ','&Ecirc;','Ẹ','&Eacute;','&Egrave;','Ẻ','Ẽ',  
					'ế','ề','ể','ễ','&#7879;','Ế','Ề','Ể','Ễ','Ệ',  
					'ọ','ộ','ổ','ỗ','ố','ồ','Ọ','Ộ','Ổ','Ỗ','Ố','Ồ','&Ocirc;','&ocirc;',  
					'&oacute;','&ograve;','ỏ','&otilde;','&Oacute;','&Ograve;','Ỏ','&Otilde;',  
					'ơ','ợ','ớ','&#7901;','ở','ỡ',  
					'Ơ','Ợ','Ớ','Ờ','Ở','Ỡ',  
					'ụ','ư','ứ','ừ','ử','ữ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','ự','Ự',  
					'&uacute;','&ugrave;','ủ','ũ','&Uacute;','&Ugrave;','Ủ','Ũ',  
					'ị','&iacute;','&igrave;','ỉ','ĩ','Ị','&Iacute;','&Igrave;','Ỉ','Ĩ',  
					'ỵ','&yacute;','ỳ','ỷ','ỹ','Ỵ','&Yacute;','Ỳ','Ỷ','Ỹ',  
					'đ','Đ'  
		); 

		$char_html = array(  
					'&#7841;','á','à','&#7843;','ã','Ạ','Á','À','Ả','Ã',  
					'â','ậ','ấ','&#7847;','&#7849;','ẫ','Â','Ậ','Ấ','Ầ','Ẩ','Ẫ',  
					'ă','ặ','&#7855;','ằ','ẳ','ẫ','Ă','Ắ','Ằ','Ẳ','Ẵ','Ặ',  
					'ê','&#7865;','é','è','ẻ','ẽ','Ê','Ẹ','É','È','Ẻ','Ẽ',  
					'&#7871;','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ',  
					'ọ','&#7897;','ổ','ỗ','&#7889;','&#7891;','Ọ','Ộ','Ổ','Ỗ','Ố','Ồ','Ô','ô',  
					'ó','ò','ỏ','õ','Ó','Ò','Ỏ','Õ',  
					'&#417;','ợ','&#7899;','&#7901;','&#7903;','ỡ',  
					'Ơ','Ợ','Ớ','Ờ','Ở','Ỡ',  
					'&#7909;','&#432;','ứ','ừ','ử','&#7919;','Ụ','Ư','Ứ','Ừ','Ử','Ữ','ự','Ự',  
					'ú','ù','ủ','ũ','Ú','Ù','Ủ','Ũ',  
					'ị','í','ì','ỉ','ĩ','Ị','Í','Ì','Ỉ','Ĩ',  
					'ỵ','ý','ỳ','ỷ','ỹ','Ỵ','Ý','Ỳ','Ỷ','Ỹ',  
					'&#273;','&#272;'  
		); 
		 
		$char_viqr = array(  
			'a.',"a'",'a`','a?','a~','A.',"A'",'A`','A?','A~',  
			'a^','a^.',"a^'",'a^`','a^?','a^~','A^','A^.',"A^'",'A^`','A^?','A^~',  
			'a(','a(.',"a('",'a(`','a(?','a^~','A(',"A('",'A(`','A(?','A(~','A(.',  
			'e^','e.',"e'",'e`','e?','e~','E^','E.',"E'",'E`','E?','E~',  
			"e^'",'e^`','e^?','e^~','e^.',"E^'",'E^`','E^?','E^~','E^.',  
			'o.','o^.','o^?','o^~',"o^'",'o^`','O.','O^.','O^?','O^~',"O^'",'O^`','O^','o^',  
			"o'",'o`','o?','o~',"O'",'O`','O?','O~',  
			'o+','o+.',"o+'",'o+`','o+?','o+~',  
			'O+','O+.',"O+'",'O+`','O+?','O+~',  
			'u.','u+',"u+'",'u+`','u+?','u+~','U.','U+',"U+'",'U+`','U+?','U+~','u+.','U+.',  
			"u'",'u`','u?','u~',"U'",'U`','U?','U~',  
			'i.',"i'",'i`','i?','i~','I.',"I'",'I`','I?','I~',  
			'y.',"y'",'y`','y?','y~','Y.',"Y'",'Y`','Y?','Y~',  
			'dd','DD'  
		);  

		$char_iso = array(  
			'ạ','á','à','&#7843;','ã','Ạ','Á','À','Ả','Ã',  
			'â','ậ','ấ','ầ','ẩ','ẫ','Â','Ậ','Ấ','Ầ','Ẩ','Ẫ',  
			'ă','ặ','ắ','ằ','ẳ','ẫ','Ă','Ắ','Ằ','Ẳ','Ẵ','Ặ',  
			'ê','ẹ','é','è','ẻ','ẽ','Ê','Ẹ','É','È','Ẻ','Ẽ',  
			'ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ',  
			'ọ','ộ','ổ','ỗ','ố','ồ','Ọ','Ộ','Ổ','Ỗ','Ố','Ồ','Ô','ô',  
			'ó','ò','ỏ','õ','Ố','Ô','Ỏ','Õ',  
			'ơ','ợ','ớ','ờ','ở','ỡ',  
			'Ơ','Ợ','Ớ','Ờ','Ở','Ỡ',  
			'ụ','ư','ứ','ừ','ử','ữ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','ự','Ự',  
			'ú','ù','ủ','ũ','Ú','Ù','Ủ','Ũ',  
			'ị','í','ì','ỉ','ĩ','Ị','Í','Ì','Ỉ','Ĩ',  
			'ỵ','ý','ỳ','ỷ','ỹ','Ỵ','Ý','Ỳ','Ỷ','Ỹ',  
			'đ','Đ'  
		);  
		
		$str = htmlspecialchars_decode($str);
		$str = str_replace($char_unicode,$char_EN,$str);
		$str = str_replace($char_viqr,$char_EN,$str);
		$str = str_replace($char_iso,$char_EN,$str);
		$str = str_replace($char_unknow,$char_EN,$str);
		$str = str_replace($char_html,$char_EN,$str);
		return $str;
	}

	function get_crawl_info($is_video, $offset=0, $limit=100)
	{//	
		$set_crawl_id = $this->get_crawl_id($is_video, $offset, $limit);
		if(empty($set_crawl_id)) return FALSE;
		
		$sql = "SELECT 
					a.id, a.id_pattern, a.id_nwc, a.id_cattext, a.links, a.available, b.name, b.html_open, b.html_close, 
					b.website, b.title_open, b.title_close, b.intro_open, b.intro_close, b.content_open, b.content_close, 
					b.author_open, b.author_close, b.times, b.time_update 
				FROM 
					crawler a, news_pattern b
				WHERE a.id_pattern=b.id_pattern AND a.available!='0' AND a.id IN $set_crawl_id";
				
		$result = $this->_query($sql);
		if (!$result) {
			echo 'Invalid query: ' . mysql_error();
			return FALSE;
		}
		return $result;
	}

	function get_crawl_id($is_video, $offset=0, $limit=100)
	{//	
		$ar_crawl_id = array();
		if($is_video)
		{
			$sql = "SELECT 
						id 
					FROM 
						crawler
					WHERE available!='0' AND is_video='1'
					LIMIT 5";
		}
		else
		{
			$sql = "SELECT 
						id 
					FROM 
						crawler
					WHERE available!='0' AND is_video!='1'
					LIMIT $offset, $limit";
		}		
		$result = $this->_query($sql);
		if (!$result) {
			return FALSE;
		}
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
			array_push($ar_crawl_id, $row['id']);
		}
		mysql_free_result($result);
		if(empty($ar_crawl_id))
		{
			return FALSE;
		}
		$set_crawl_id = '('.implode(',', $ar_crawl_id).')';
		return $set_crawl_id;
	}

	function check_news($link, $title)
	{//	
		$sql = "SELECT 
					id_news
				FROM 
					news
				WHERE news_link='$link' OR news_title='$title'";			
		$query = $this->_query($sql);
		$num_rows = @mysql_num_rows($query);

		if ((int)$num_rows > 0)
		{
			return true;
		}
		return false;
	}

	function _query($sql)
	{
		$result = mysql_query($sql);
		if (!$result) {
			echo 'Invalid query: ' . mysql_error();
		}
		return $result;
	}
	
	function str_insert($table, $keys, $values)
	{	
		return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).")";
	}
	
	function _insert($table, $values)
	{
		foreach($values as $key=>$val)
		{
			$values[$key] = $this->escape($val);
		}
		$sql = $this->str_insert($table, array_keys($values), array_values($values));
		return $this->_query($sql);
	}
	
	function insert_id()
	{
		return mysql_insert_id($this->conn);
	}
	
	function connect_db($host, $user, $pass, $database, $char_set='utf8', $dbcollat='utf8_general_ci')
	{
		$this->conn = mysql_connect($host, $user, $pass) or die('Error connecting to mysql'); 
		mysql_select_db($database, $this->conn);
		$this->db_set_charset($char_set, $dbcollat);
		return $this->conn;
	}
	
	function close_db($conn)
	{
		mysql_close($conn);
	}
	/**
	 * "Smart" Escape String
	 *
	 * Escapes data based on type
	 * Sets boolean and null types
	 *
	 * @access	public
	 * @param	string
	 * @return	mixed		
	 */	
	function escape($str)
	{
		if (is_string($str))
		{
			$str = "'".$this->escape_str($str)."'";
		}
		elseif (is_bool($str))
		{
			$str = ($str === FALSE) ? 0 : 1;
		}
		elseif (is_null($str))
		{
			$str = 'NULL';
		}

		return $str;
	}

	/**
	 * Escape String
	 *
	 * @access	public
	 * @param	string
	 * @param	bool	whether or not the string will be used in a LIKE condition
	 * @return	string
	 */
	function escape_str($str, $like = FALSE)	
	{	
		if (is_array($str))
		{
			foreach($str as $key => $val)
	   		{
				$str[$key] = $this->escape_str($val, $like);
	   		}
   		
	   		return $str;
	   	}

		if (function_exists('mysql_real_escape_string') AND is_resource($this->conn))
		{
			$str = mysql_real_escape_string($str, $this->conn);
		}
		elseif (function_exists('mysql_escape_string'))
		{
			$str = mysql_escape_string($str);
		}
		else
		{
			$str = addslashes($str);
		}
		
		// escape LIKE condition wildcards
		if ($like === TRUE)
		{
			$str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
		}
		
		return $str;
	}
	/**
	 * Set client character set
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	resource
	 */
	function db_set_charset($charset, $collation)
	{
		return @mysql_query("SET NAMES '".$this->escape_str($charset)."' COLLATE '".$this->escape_str($collation)."'", $this->conn);
	}
		
}
?>