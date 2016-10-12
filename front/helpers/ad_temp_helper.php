<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('showAd'))
{
	function showAd($vt_qc){
		if(is_array($vt_qc) && !empty($vt_qc))
		{
			$url = base_url();
			$qc_click = $url.'qlqc/click.php?qc='.$vt_qc[2];
			$image = $vt_qc[0];
			if($vt_qc[1]=='I'){
				if(substr($image,0,7)=="uploads")
					$show ='<a href="'.$qc_click.'"><img src="'.$url.$image.'" border=0 ></a>';
				else $show ='<a href="'.$qc_click.'"><img src="'.$image.'" border=0 ></a>';
			}
			if($vt_qc[1]=='F'){
				if(substr($image,0,7)=="uploads")
					$show ='<a href="'.$qc_click.'" target="_blank"><embed src="'.$url.$image.'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent"></embed></a>';
				else $show ='<a href="'.$qc_click.'" target="_blank"><embed src="'.$image.'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" align="left"  z-index="0" wmode="transparent"></embed></a>';
			}
		}
		return $show;
	}
}


?>