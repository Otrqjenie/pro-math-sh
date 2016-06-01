<?php
require_once "connect.php";
require_once "request.php";
//mysql_query("DROP TABLE count");
mysql_query("CREATE TABLE IF NOT EXISTS count (
  count FLOAT
  )
") or die("Ошибочка ".mysql_error());
$r=mysql_query("SELECT * FROM count") or die(mysql_error());
$row=mysql_fetch_assoc($r);
$r=$row['count']+0.5;
//echo $row['count'];
mysql_query("UPDATE count SET count=".$r." WHERE count=".$row['count']."") or die("Ещё одна ".mysql_error());
?>