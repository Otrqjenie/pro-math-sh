<?php
define('proverka', 84);
// require_once "connect2.php";
require_once 'lib/connect.php';
// require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");


$m = 'SELECT * FROM shield WHERE id_user = '.$_SESSION['id'];
				$r = $db -> query($m);
				// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				$j = 0;
				$row2 = $r -> fetch_array(MYSQL_ASSOC);
				// $r -> free();
				print_r($row2);
				
				$r -> close();
				// for ($data2 = array(); $row2 = fetch_array(MYSQL_ASSOC) ; $data2[] = $row2) { 
				// 	$str = $str."<p>".$row2['nazvanie_zsh']."</p>";
				// 	$j++;
				// };









?>