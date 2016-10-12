<?php
	include("process.php");
	include("get_lib.php");	
	
	$get_news = new Get_lib();
	
	$offset = ($process-1)*10;
	$limit = 10;
	$is_video = $process==27? true : false; 
	
	$get_news->run($is_video, $offset, $limit);
	
	$process++;
	$process = $process>27? fmod($process, 27) : $process;
	$str = "<?php  \$process = $process;?>";
	
	$fp = fopen('process.php', 'w');
	fwrite($fp, $str);
	fclose($fp);
	mail('quocviet551@yahoo.com', 'cronjob '.date('H:i m-d-y'), 'test cronjob');
?>