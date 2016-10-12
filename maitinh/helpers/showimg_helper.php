<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Rocachien
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://cus.vn/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * hien thi hinh anh cac loai
 *
 *
 * @access	public
 * @param	string	the URL
 * @param	interger	chieu rong neu co
 * @param	interger	chieu cao neu co
 * @param	string	tootip neu co
 * @param	string	neu hinh la flash thi co auto play kg
 * @param	string	css neu co
 * @param	string	border cua hinh
 * @return	string	the hien hinh anh
 */
if (! function_exists('getBrowser'))
{
	function getBrowser()
	{
		return "FIREFOX";
	}
}
if (! function_exists('showIMG'))
{
	function showIMG($url,$w=90,$h=90,$alt="",$auto="", $class="", $boder=0){
		$auto=($auto)?"true":"false";
		//$auto="true";
		$img ="";
		$exists	= true;
		
		if(!file_exists($url) || empty($url))
			$exists	=  false;		
		$pos = strpos($url, 'http://');
		if($pos!==false)
		{
			$exists	= true;
			$source = $url;
		}
		else
		{
			$source = base_url().$url;
		}
		$extimg="jpg,jpe,peg,fif,png,gif,bmp";
		if($exists && stristr($extimg, substr($url,-3,3))){
			$h=empty($h) ? "" : ' height="'.$h.'"';
			$w=empty($w) ? "" : ' width="'.$w.'"';
			$img='<img src="'.$source.'" '.$w. $h .' border="'.$boder.'" alt="'.$alt.'" class="'.$class.'" />';
		}
		$extvideo="wmv,wav,mid";
		if($exists && stristr($extvideo, substr($url,-3,3))){
			$ar=getBrowser();
			if($ar=="FIREFOX"){
				$img='<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" '
				.'codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#'
				.'version=8,5,0,0" width="'.$w.'" height="'.$h.'" accesskey="a" tabindex="0" title="'
				.$alt.'" z-index="0" wmode="transparent" >'
				.'<param name="src" value="'.$source.'" />'
				.'<PARAM NAME="AutoStart" VALUE="'.$auto.'">'
				.'<embed src="'.$source.'" pluginspage="http://www.macromedia.com/shockwave/download/" '
				.'width="'.$w.'" height="'.$h.'"  AutoStart="'.$auto.'" ></embed></object>';
			}else{
				$name = basename($url);
				$img='<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 '
				.'codebase="http://download.macromedia.com/pub/shockwave/'
				.'cabs/flash/swflash.cab#version=6,0,40,0" z-index="0" wmode="transparent" '
				.'WIDTH="'.$w.'" HEIGHT="'.$h.'" id="myFlash">'
				.'<PARAM NAME=movie VALUE="'. $source.'">'
				.'<PARAM NAME=quality VALUE=high>'
				.'<PARAM NAME=bgcolor VALUE=#FFFFFF>'
				.'<PARAM NAME="AutoStart" VALUE="'.$auto.'">'
				.'<EMBED src="'. $source.'" quality=high bgcolor=#FFFFFF z-index="0" wmode="transparent" '
				.'WIDTH="'.$w.'" HEIGHT="'.$h.'" NAME="myFlash" ALIGN="" AutoStart="'.$auto.'" '
				.'TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/'
				.'go/getflashplayer"></EMBED></OBJECT>';
			}
		}
	
		if($exists && substr($url,-3,3)=="swf"){
			$img='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" '
			.'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#'
			.'version=7,0,19,0" width="'.$w.'" height="'.$h.'" accesskey="c" tabindex="0" title="'
			.$alt.'" z-index="0" wmode="transparent" >'
			.'<param name="movie" value="'.$source.'" />'
			.'<param name="quality" value="high" />'
			.'<embed src="'.$source.'" quality="high" pluginspage="http://www.macromedia.com/go/'
			.'getflashplayer" type="application/x-shockwave-flash" width="'.$w.'" height="'.$h.'" '
			.' z-index="0" wmode="transparent" ></embed></object>';
		}
	
		//file youtube movie
		$find = strpos($url, 'http://www.youtube.com');
		if($find!==false){
			/*$img='<embed src="'.base_url().'flvplayer.swf" type="application/x-shockwave-flash" flashvars="file='
			. $source.'&image=images/waitting.gif;location=flvplayer.swf&autostart='.$auto.'" '
			.'allowfullscreen="true" height="'.$h.'" width="'.$w.'" z-index="0" wmode="transparent" ></embed>';*/		
			$img='<object width="'.$w.'" height="'.$h.'" data="'.$source.'" type="application/x-shockwave-flash" class="restrain" id="yui-gen0"> <param value="'.$source.'" name="movie"> <param value="transparent" name="wmode"> </object>';	
		}
		
		if(substr($url,-3,3)=="flv"){
			$path	= ($exists)? $source: 'http://idgtech.net/';
			$img='<embed src="'.base_url().'flvplayer.swf" type="application/x-shockwave-flash" flashvars="file='
			. $path.'&image=images/waitting.gif;location=flvplayer.swf&autostart='.$auto.'" '
			.'allowfullscreen="true" height="'.$h.'" width="'.$w.'" z-index="0" wmode="transparent" ></embed>';		
			//echo "http://idgtech.net/".$url;	
		}
	
		return $img;
	}
}

// ------------------------------------------------------------------------

/**
 * hien thi hinh anh theo danh sach XML cho truoc
 *
 *
 * @access	public
 * @param	string	the URL cua file danh sach XML
 * @param	interger	chieu rong neu co
 * @param	interger	chieu cao neu co
 * @return	string	the hien hinh anh
 */
if (! function_exists('showPRO'))
{	
	function showPRO($urllist,$w=395,$h=395){

		//if(@file_exists($urllist))

		return '<embed name="flash" src="'.base_url().'imagerotator.swf" quality="high" bgcolor="#96BCE3" z-index="0" '
		.'wmode="transparent" width="'.$w.'" height="'.$h.'" type="application/x-shockwave-flash"'
		.' flashvars="&amp;file='.$urllist.'&amp;height='.$h.'&amp;width='.$w.'&amp;'
		.'transition=random" allowscriptaccess="always" allowfullscreen="true" pluginspage="'
		.'http://www.macromedia.com/shockwave/download/index.cgi?'
		.'P1_Prod_Version=ShockwaveFlash"></embed>';
	}
}
?>