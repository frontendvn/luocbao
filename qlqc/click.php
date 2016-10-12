<?php
require'dbconnect.php';
if ($_GET['qc']!="")
{
    $vitri=$_GET['qc'];
    $sql="SELECT * FROM quangcao WHERE id=$vitri";
    $rs=mysql_query($sql,$conn);
    $r=mysql_fetch_assoc($rs);
        $Link=$r['links'];
        mysql_query("UPDATE quangcao SET clicks=clicks +1 WHERE id='$vitri'",$conn);
        header ("Location: $Link");
}
require'dbclose.php';
?>
