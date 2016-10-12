<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class swapcaptcha extends Controller {
	var $mod = "captcha";
	function swapcaptcha()
	{
		parent::Controller();	
		// load necessary libraries
		$this->load->library(array('captcha_lib'));
	}
	
	function swap()//30-7-2010
	{
		echo $this->captcha_lib->show();
	}
}

?>