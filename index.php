<?php
define("proverka", 84);
require_once "connect2.php";
require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");
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
		<td>Моя страница</td>
		<td><a href="index.php">Игроки онлайн</a></td>
		<td><a href="index.php">Приглашения</a></td>
		<td><a href = "index.php">Текущий бой</a></td>
		<td><a href="<?=$_SERVER['SCRIPT_NAME']?>?out">Выйти</a></td>
	</tr>
</table>
</div>

</body>
</html>