<?php
// Возможно удалить(удалить в конце недели если не нашлось применения)
// Найти ошибку
// Можно улучшить
// Доделать
// Доработать
// работаю
// уязвимость
header("Content-Type: text/html; charset=utf-8");
// error_reporting(0);
define('proverka', 84);
require_once "lib/ips_ids.php"; // проверка соответствия ip в сессии и на деле
// require_once "connect2.php";
require_once 'lib/connect.php';
require_once "lib/request.php";
if (!isset($_COOKIE['id']) and !isset($_COOKIE['hesh'])) {
	Header("Location: game_js_register.php");
};
session_start();

if (!isset($_SESSION['id']) and !isset($_SESSION['hesh'])) {
	$hesh = $db->
prepare("SELECT id, hesh, imya, familiya FROM user WHERE id = ?");
	$hesh->bind_param('i', $_COOKIE['id']);
	$hesh->execute();
	$hesh->bind_result($id, $hesh, $imya, $familiya);
	if ($hesh->fetch()) {
		$_SESSION['id'] = $id;
		$_SESSION['hesh'] = $hesh;
		$_SESSION['imya'] = $imya;
		$_SESSION['familiya'] = $familiya;
	};
};
if (!isset($_SESSION['razdel'])) {
		$r = $db->prepare("SELECT razdel FROM user_param WHERE id = ?");
		$r-> bind_param('i', $_SESSION['id']);
		$r->execute();
		$r->bind_result($razdel);
		$r->fetch();
		$_SESSION['razdel'] = $razdel;
		$r->close();
		if ($razdel === null) {
			$_SESSION['razdel'] = 'oge';
		};
	};

if ($_REQUEST['site'] == 'out') {
	setcookie('id');
	setcookie('hesh');
	session_destroy();
	Header("Location: game_js_register.php");
};
if (isset($_GET["site"])) {
	switch ($_GET["site"]) {
		case 'game_js':
			$site = $_GET["site"];
			$head = '
<title>Моя страница</title>
<script type="text/javascript" src = "lib/jquery-3.2.1.js"></script>
<script type="text/javascript" src = "game_js.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<link rel="stylesheet" type="text/css" href="css/game_js.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link href="js/jquery-ui.css" rel="stylesheet">
';
			break;

		case 'arena':
			$site = $_GET['site'];
			$head = '
<title>Арена</title>
<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
<script type="text/javascript" src = "lib/arena.js"></script>
<script type="text/javascript" src = "game_js.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<link rel="stylesheet" type="text/css" href="css/arena.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
';
			break;
		case 'tr_js':
			$site = $_GET["site"];
			$head = '
<title>Бой</title>
<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
<script type="text/javascript" src = "lib/tr_js.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<link rel="stylesheet" type="text/css" href="css/tr_js.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
';
			break;
		
		default:
			$site = "game_js";
			$head = '
<title>Моя страница</title>
<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
<script type="text/javascript" src = "game_js.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<link rel="stylesheet" type="text/css" href="css/game_js.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
';
			break;
	};
	
};
?>
<!DOCTYPE html>
<html>
<head>
	<?=$head?>
	<script type="text/javascript" src="lib/main.js"></script>		
</head>
<body>
	<div id="container">
		
	<div id="header2">
		<div id="game_js" class="main_menu" align="center">
			<p><b>Моя страница</b></p>
		</div>
		<div id="arena" class="main_menu" align="center">
			<p><b>Арена</b></p>
		</div>
		<div id="tr_js" class="main_menu" align="center">
			<p><b>Бой</b></p>
		</div>
		<div id="out" class="main_menu" align="center">
			<p><b>Выход</b></p>
		</div>
	</div>
	<div id="content">
		<?
if (!isset($site)) {
	$site = 'game_js';
};
require_once  $site.'.php';
?></div>
</div>
</body>
</html>