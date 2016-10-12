<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Rocachien
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://greenit.vn/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 *
 * @access	public
 * @param	string	the URL
 * @param	interger	time to reload
 * @return	string
 */
if (! function_exists('reload'))
{
	function reload($uri = '', $time = 0, $exit = false)
	{
		$uri	= (substr($uri, 0, 4) == "http")?$uri:site_url($uri);
		if (!headers_sent())
			//header('Location: '.$uri);
			header("Refresh: $time; url=$uri");
		else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$uri.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="'.$time.';url='.$uri.'" />';
			echo '</noscript>';
		}
		if($exit)
				exit;
	}
}	
if (! function_exists('alert'))
{
	function alert($msg, $title="Thông Báo")
	{//
		echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><title>"
			.$title."</title><script>alert(\"".$msg."\");</script></head><body></body></html>";
	}
}
?>