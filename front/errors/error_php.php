<html>
<head>
<title>404 Page Not Found</title>
<meta http-equiv="refresh" content="70; url=http://luocbao.com/index.php/common_error/ephp" />
<style type="text/css">
body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
		<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>PHP error!</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

	</div>
</body>
</html>