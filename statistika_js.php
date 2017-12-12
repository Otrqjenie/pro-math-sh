<?php
// require_once "lib/connect.php";
define('proverka', 84);
require_once "connect2.php";
require_once "st_lib/request.php";
define('proverka', 84);
session_start();
header("Content-Type: text/html; charset=utf-8");
// функция для суммирования объёма
function Fun($dir)
{
	global $v;
	$v = filesize($dir);
	$v = filter_var($v, FILTER_VALIDATE_INT);
	return $v;
	
};

function vol()
{
	$volium = 0;
	$a = array();
	$a[] = 'css/arena.css';
	$a[] = 'css/game_js.css';
	$a[] = 'css/main.css';
	$a[] = 'css/tr_js.css';
	$a[] = 'arena.php';
	$a[] = 'game_js.php';
	$a[] = 'game_js_invitation.php';
	$a[] = 'game_js_load.php';
	$a[] = 'game_js_online.php';
	$a[] = 'game_js_register.php';
	$a[] = 'game_js_rez.php';
	$a[] = 'index.php';
	$a[] = 'js.php';
	$a[] = 'js_fon.php';
	$a[] = 'lis.php';
	$a[] = 'tr_js.php';
	$a[] = 'tr8.php';
	$a[] = 'lib/arena.js';
	$a[] = 'lib/connect.php';
	$a[] = 'lib/lib_js.php';
	$a[] = 'lib/main.js';
	$a[] = 'lib/mainn.js';
	$a[] = 'lib/tr_js.js';
	foreach ($a as $key => $value) {	
		$volium = $volium + Fun($value);
	};
	return $volium;
};
// -----------------------------
// Создание новой сессии либо пауза
if (isset($_GET['start'])) {
	if ($_SESSION['time'] == 1) {// если стоит на паузе
		$_SESSION['time'] = time();

	}
	elseif($_SESSION['time'] > 1){// если паузу нажали;
		$m = 'SELECT * FROM statistika WHERE konec = 0';
		$r = mysql_qw($m) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		// $volium = time() - $_SESSION['time'] + $row['volium'];
		// Собираем объёмы всех файлов
		$volium = vol();
		$progress = $volium - $row['volium'];
		if ($progress < 0) {
			$progress = 0;
		};
		$general_volium = $row['general_volium'] + $progress;
		// Работаю
		$_SESSION['time'] = 1;
		$m = 'UPDATE statistika SET volium = ?, general_volium = ? WHERE konec = 0';
		mysql_qw($m, $volium, $general_volium) or die(mysql_error());
		$_SESSION['rez'] = date("H:i:s", $volium - 10800);
	}
	else{//если запустили сессию
		$m = 'SELECT * FROM statistika WHERE konec = 0';
		$r = mysql_qw($m) or die(mysql_error());
		$i = 0;
		for ($data = array(); $row = mysql_fetch_assoc($r)  ; $data[] = $row ) { 
			$i++;
		};
		if ($i == 0) {
			$nach_vol = vol();
			$m = "INSERT INTO statistika SET 
			nach = ?,
			volium = ?,
			nach_vol = ?,
			general_volium = ?,
			konec = ?,
			z1 = ?,
			z2 = ?,
			v = ?,
			i = ?";
			mysql_qw($m, time(), $nach_vol, $nach_vol, 0, 0, 0, 0, 0, 0) or die(mysql_error());
			$_SESSION['time'] = time();
		}
		else{
			$_SESSION['time'] = time();
		};
		
	}
	
// Таймер сверху
};
if (isset($_GET['time'])) {
	$t = time() - $_SESSION['time'] - 10800;
	// $t1 = date("H:i:s", -3600);
	$t = date("H:i:s", $t);
	if ($_SESSION['time'] != 1) {
		echo $t."</br>". $_SESSION['rez']."</br>";
		$m = 'SELECT * FROM statistika WHERE konec = 0';
		$r = mysql_qw($m) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		// $volium = time() - $_SESSION['time'] + $row['volium'];
		// Собираем объёмы всех файлов
		$volium = vol();
		$progress = $volium - $row['volium'];
		if ($progress < 0) {
			$progress = 0;
		};
		$general_volium = $row['general_volium'] + $progress;
		// Работаю
		// $_SESSION['time'] = 1;
		$m = 'UPDATE statistika SET volium = ?, general_volium = ? WHERE konec = 0';
		mysql_qw($m, $volium, $general_volium) or die(mysql_error());
	}
	else{
		echo "&nbsp;</br>". $_SESSION['rez']."</br>";
	}
	
}


// Работа с графиком
if (isset($_GET['gr'])) {
	$m = 'SELECT * FROM statistika WHERE id > 204 ORDER BY id';
	$r = mysql_qw($m) or die(mysql_error());
	$left = 50;
	$i = 0;
	for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row ) { 
		$top = 420;
		$z1 = $row['z1']*20;
		$z2 = $row['z2'];
		$v = $row['v']*5;
		$i = $row['i']*10;
		// echo $z1."</br>".$z2."</br>".$v."</br>".$i;
		$h = floor($row['general_volium']/60) + $z1 + $z2 + $v + $i;
		$h2 = floor($row['general_volium']/6);
		$str = "";
		if ($h2<=60) {
			$str = "Бомж";
		}
		elseif (($h2>60) and ($h2<120)) {
			$str = "Бич";
		}
		elseif (($h2>120) and ($h2<240)) {
			$str = "Лох";
		}
		elseif (($h2>240) and ($h2<360)) {
			$str = "Холоп";
		}
		elseif (($h2>360) and ($h2<480)) {
			$str = "Профи";
		}
		elseif (($h2>480) and ($h2<600)) {
			$str = "Дуров";
		}
		elseif (($h2>240) and ($h2<360)) {
			$str = "Илон";
		}
		else
			{};
		
		$top = $top - $h;
		$height = $h."px";

		echo "<div class = 'fild4' 	style ='top: ".$top."px; left: ".$left."px; height: ".$height.";'
		'>".$h."<br>".$str."<br>".floor($row['general_volium']/60)."</div>";
		$left = $left +55;
		$i++;

	};
};
// Остановка сессии
if (isset($_GET['stop'])) {
	$m = 'UPDATE statistika SET konec = ? WHERE konec = 0';
	mysql_qw($m, 1);
	$_SESSION['time'] = 0;
	$_SESSION['rez'] = 0;
};
// Задачи уровня I
if ((isset($_GET['x']) and (isset($_GET['y'])))) {
	// echo $_GET['x']."=".$_GET['y'];
	$x = $_GET['x'];
	$y = $_GET['y'];
	$m = 'SELECT '.$x.' FROM statistika WHERE konec = 0';
	$r = mysql_qw($m) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	$row[$x] = $row[$x] + $y;
	echo $row[$x];
	// print_r($row);

	$m = 'UPDATE statistika SET '.$x.' = ? WHERE konec = 0';
	mysql_qw($m, $row[$x]) or die(mysql_error());
}
?>