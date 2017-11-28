<?php
if (!defined('proverka')) {
	die();
};
$user="ww";
$pass="eQfL6QsZudbW6jOj";
$db="db";
mysql_connect("localhost", $user, $pass)
 or die("Error".misql_error());
@mysql_query("CREATE DATABASE $db");
mysql_select_db($db)
 or die("coold not select db".mysql_error());
mysql_query("SET NAMES utf8") or die(mysql_error());
?>