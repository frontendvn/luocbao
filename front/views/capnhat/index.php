<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$heading = !empty($heading) ? $heading : 'Auto news';?></title>
</head>
<body>
<?php echo 'Logs:'.anchor($this->mod.'/run', '[Refresh]').'<br />';
foreach($message as $vl)
{
	echo '<p>'.$vl.'</p>';
}
?>
</body></html>