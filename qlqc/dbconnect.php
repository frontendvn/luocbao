<?php
$database="luocbao_autonews";
$user="root";
$pass="root";
$hostname="localhost";
$conn = mysql_connect("$hostname", "$user","$pass");
mysql_select_db("$database",$conn);
mysql_query("set names utf8",$conn);
?>