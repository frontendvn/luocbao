<?php
/***********************************************************************/
/*                                                                     */
/*   Copyright (C) 2008-2010  Ready Technology LTD.                    */
/*   Author     : rocachi - Do Van Chien - rocachien@yahoo.com.        */
/*   Powered By : Ready Technology Co.,Ltd. http://23vn.com            */
/*                                                                     */
/*   Created    : 12-11-2008 15:42:05.                                 */
/*   Modified   : 12-11-2008 15:43:22.                                 */
/*   Description: Check IAMGE CODE                 .                   */
/*                                                                     */  
/***********************************************************************/
//
//
class captcha_lib
{//	
	
	var $img_url;
	var $img_path;
	var $img_class;
	var $font_path;
	var $char_leng;
	var $img_width;
	var $img_height;
	var $expiration;
	
	//
	function  captcha_lib($config = array()) {
		//start CI + database
		$this->CI =& get_instance();
		//load database
		$this->CI->load->database();
		//load config
		$this->init($config);
	}	
	function init($config = array())
	{
		$defaults = array(
						'img_url'	 => base_url().ROOT.'captcha/',
						'img_path'	 => ROOT.'captcha/',
						'img_class'	 => "",
						'font_path'	 => ROOT.'fonts/tahoma.ttf',
						'char_leng'	 => 5,
						'img_width'	 => 100,
						'img_height' => 30,
						'expiration' => 10
					);
		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}			
			}
			else
			{
				$this->$key = $val;
			}
		}
		
	}
	//
	function set_img_url($input)
	{
		$this->img_url 		= trim($input);
	}
	function set_img_path($input)
	{
		$this->img_path 	= trim($input);
	}
	function set_img_class($input)
	{
		$this->img_class 		= trim($input);
	}
	function set_font_path($input)
	{
		$this->font_path 	= trim($input);
	}
	function set_char_leng($input)
	{
		$this->char_leng 	= intval($input);
	}
	function set_img_width($input)
	{
		$this->img_width 	= intval($input);
	}
	function set_img_height($input)
	{
		$this->img_height 	= intval($input);
	}
	function set_expiration($input)
	{
		$this->expiration 	= intval($input);
	}
	//
	function show($word='')
	{		
		// -----------------------------------
		// Remove old images	
		// -----------------------------------
				
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);
		//
		$current_dir = @opendir($this->img_path);
		//
		while (false !== ($filename = readdir($current_dir))) {
			if (strpos($filename, '.jpg',1)) {
				$name = (float)str_replace(".jpg", "", $filename);
				if (($name + $this->expiration) < $now)
				{
					@chmod($this->img_path,0777);
					@unlink($this->img_path.$filename); 
					@chmod($this->img_path,0755);
				}
			}
		}
		//
		@closedir($current_dir);
	
		// -----------------------------------
		// Do we have a "word" yet?
		// -----------------------------------
	   if (empty($word))
	   {
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
			$str = '';
			for ($i = 0; $i < $this->char_leng; $i++)
			{
				$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
			}
			
			$word = $str;
	   }
		
		// -----------------------------------
		// Determine angle and position	
		// -----------------------------------
		
		$length	= strlen($word);
		$angle	= ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
		$x_axis	= rand(6, (360/$length)-16);			
		$y_axis = ($angle >= 0 ) ? rand($this->img_height, $this->img_width) : rand(6, $this->img_height);
		
		// -----------------------------------
		// Create image
		// -----------------------------------
				
		$im = ImageCreate($this->img_width, $this->img_height);
				
		// -----------------------------------
		//  Assign colors
		// -----------------------------------
		
		$bg_color		= imagecolorallocate ($im, 255, 255, 255);
		$border_color	= imagecolorallocate ($im, 255, 255, 250);
		$text_color		= imagecolorallocate ($im, 22, 22, 200);
		$grid_color		= imagecolorallocate($im, 240, 250, 240);
		$shadow_color	= imagecolorallocate($im, 0, 0, 100);
	
		// -----------------------------------
		//  Create the rectangle
		// -----------------------------------
		
		ImageFilledRectangle($im, 0, 0, $this->img_width, $this->img_height, $bg_color);
		
		// -----------------------------------
		//  Create the spiral pattern
		// -----------------------------------
		
		$theta		= 1;
		$thetac		= 7;
		$radius		= 16;
		$circles	= 20;
		$points		= 32;
	
		for ($i = 0; $i < ($circles * $points) - 1; $i++)
		{
			$theta = $theta + $thetac;
			$rad = $radius * ($i / $points );
			$x = ($rad * cos($theta)) + $x_axis;
			$y = ($rad * sin($theta)) + $y_axis;
			$theta = $theta + $thetac;
			$rad1 = $radius * (($i + 1) / $points);
			$x1 = ($rad1 * cos($theta)) + $x_axis;
			$y1 = ($rad1 * sin($theta )) + $y_axis;
			imageline($im, $x, $y, $x1, $y1, $grid_color);
			$theta = $theta - $thetac;
		}
	
		// -----------------------------------
		//  Write the text
		// -----------------------------------
		
		$use_font = ($this->font_path != '' AND file_exists($this->font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;
			
		if ($use_font == FALSE)
		{
			$font_size = 5;
			$x = rand(0, $this->img_width/($length/3));
			$y = 0;
		}
		else
		{
			$font_size	= 12;
			$x = rand(0, $this->img_width/($length/1.5));
			$y = $font_size+2;
		}
	
		for ($i = 0; $i < strlen($word); $i++)
		{
			if ($use_font == FALSE)
			{
				$y = rand(0 , $this->img_height/2);
				imagestring($im, $font_size, $x, $y, substr($word, $i, 1), $text_color);
				$x += ($font_size*2);
			}
			else
			{		
				$y = rand($this->img_height/2, $this->img_height-3);
				imagettftext($im, $font_size, $angle, $x, $y, $text_color, $this->font_path, substr($word, $i, 1));
				$x += $font_size;
			}
		}
		
	
		// -----------------------------------
		//  Create the border
		// -----------------------------------
	
		imagerectangle($im, 0, 0, $this->img_width-1, $this->img_height-1, $border_color);		
	
		// -----------------------------------
		//  Generate the image
		// -----------------------------------
		
		$img_name = $now.'.jpg';
		//
		ImageJPEG($im, $this->img_path.$img_name);
		$iclass	= empty($this->img_class)?"":"class=\"".$this->img_class."\"";
		$img = "<img src=\"$this->img_url$img_name\" width=\"$this->img_width\" height=\"$this->img_height\" style=\"border:0;\" alt=\" \" align=\"absmiddle\" $iclass />";
		//
		ImageDestroy($im);
		//
		$data = array(
					'captcha_time'	=> intval($now),
					'ip_address'	=> $this->CI->input->ip_address(),
					'word'			=> $word
				);
		$query = $this->CI->db->insert_string('captcha', $data);
		$this->CI->db->query($query);
		//
		return $img;
	}
	function check($value)
	{
		$sql =  "SELECT word FROM captcha WHERE ip_address='".$this->CI->input->ip_address()
				."' AND word='".trim($value)."' ORDER BY captcha_time DESC LIMIT 0,1 "; 
		$res = $this->CI->db->query($sql);
		//
		$timeold = time() - $this->expiration;
		$this->CI->db->query("DELETE FROM captcha WHERE ip_address='".$this->CI->input->ip_address()
				."' OR captcha_time < ".$timeold);	
		if(is_object($res) && $res->num_rows()>0)
			 return true;
		else
			return false;
	}
};
?>