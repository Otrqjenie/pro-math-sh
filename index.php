<?php
header("Content-Type: text/html; charset=utf-8");
define("proverka", 84);
require_once "connect2.php";
require_once "lib/request.php";
if (!isset($_COOKIE['id']) and !isset($_COOKIE['hesh'])) {
	Header("Location: game_js_register.php");
};
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Математические Кораблики</title>
	<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
	<script type="text/javascript" src = "game_js.js"></script>
	<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<link rel="stylesheet" type="text/css" href="css/game_js.css">
</head>
<body>
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td><a href="index.php?site=game_js">Моя страница</a></td>
		<td><a href="index.php?site=game_js_online">Игроки онлайн</a></td>
		<td><a href="index.php?site=game_js_invitation">Приглашения</a></td>
		<td><a href = "index.php?site=tr_js">Текущий бой</a></td>
		<td><a href="<?=$_SERVER['SCRIPT_NAME']?>?out">Выйти</a></td>
	</tr>
</table>
</div>
<?
if (isset($_REQUEST['out'])) {
	setcookie('id');
	setcookie('hesh');
	session_destroy();
	Header("Location: game_js_register.php");
};
if (isset($_GET["site"])) {
	switch ($_GET["site"]) {
		case 'game_js':
			$site = $_GET["site"];
			break;
		case 'game_js_online':
			$site = $_GET["site"];
			break;
		case 'game_js_invitation':
			$site = $_GET["site"];
			break;
		case 'tr_js':
			$site = $_GET["site"];
			break;
		
		default:
			$site = "game_js";
			break;
	};
	
};
require_once  $site.'.php';
?>

</body>
</html>