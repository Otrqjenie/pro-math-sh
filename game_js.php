<?php
require_once "connect2.php";
require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");

if (!isset($_COOKIE['id']) and !isset($_COOKIE['hesh'])) {
	Header("Location: game_js_register.php");
};
if (!isset($_SESSION['id']) and !isset($_SESSION['hesh'])) {
	//print_r($_COOKIE);
	//Работаем здесь
	$m = 'SELECT * FROM user WHERE id = ?';
	$r = mysql_qw($m, $_COOKIE['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	$_SESSION['id'] = $row['id'];
    $_SESSION['hesh'] = $row['hesh'];
    $_SESSION['imya'] = $row['imya'];
    $_SESSION['familiya'] = $row['familiya'];
    $m = "UPDATE user SET activity = ".time()." WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
};
$max = 6;
// Проверка готовности к бою проверяется при каждой загрузке
if ($_REQUEST['ready'] == 1) {
	$m = 'SELECT * FROM shield WHERE id_user = ?';
	$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
	$i = 0;
	for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row ) { 
		$i++;
	};
	if ($i > 0) {
	$m = "UPDATE user_param SET readiness = 1 WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());	
	};
	

}
elseif($_REQUEST['ready'] == 0){
	$m = "UPDATE user_param SET readiness = 0 WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
};
$m = "SELECT readiness FROM user_param WHERE id = ?";
$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
$row = mysql_fetch_assoc($r);
$_SESSION['readiness'] = $row['readiness'];
// -----------------------------------------------------
	if (!isset($_SESSION['myarsenal'])) {
		$m = 'SELECT * FROM arsenal WHERE id_user = ?';
		$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		for ( $data = array(); $row = mysql_fetch_assoc($r) ; $_SESSION['myarsenal'][] = $row) { 
			# code...
		}
	};
	$m = "UPDATE user SET activity = ".time()." WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
//выход
if (isset($_REQUEST['out'])) {
	setcookie('id');
	setcookie('hesh');
	session_destroy();
	Header("Location: game_js_register.php");
};
//Проверка ответа
if (isset($_GET['otvet'])) {
	$e = $_GET['e'];
	$m = 'SELECT * FROM zadania WHERE id = ?';
	$r = mysql_qw($m, $_SESSION['id_z']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	if ($e['otvet'] == $row['otvet']) {
		$_SESSION['nazvanie'] = $row['nazvanie'];
		$m = 'SELECT * FROM arsenal WHERE id_rz = ? and id_user = ?';
		$r = mysql_qw($m, $_SESSION['id_z'], $_SESSION['id']);
		$i = 0;
		for ($data = array(); $row = mysql_fetch_assoc($r) ; $i++); 
		if ($i == 0) {
    	$m = 'INSERT INTO arsenal SET 
			id_user = ?,
			id_rz = ?,
			nazvanie = ?
		';
		mysql_qw($m, $_SESSION['id'], $_SESSION['id_z'], $_SESSION['nazvanie']) or die(mysql_error());
		};		
		
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	}
	else{
		echo "Неправильно";
	};
};
if (isset($_REQUEST['shield'])) {
	// доработать запретить добавление в бою
	$m = 'SELECT COUNT(*) FROM fight WHERE status = 2 and (id_priglos = ? or id_prigloshaemogo = ?)';
	$r = mysql_qw($m, $_SESSION['id'], $_SESSION['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	if ($row['COUNT(*)'] > 0) {
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
	  	exit();
	};	
	// ---
	$shield = $_REQUEST['shield'];
	$m = 'SELECT COUNT(*) FROM shield WHERE id_user = ? and id_zsh = ?';
	$r = mysql_qw($m, $_SESSION['id'], $shield);
	$row = mysql_fetch_assoc($r);
	// Проверка наличия данного задания
	if ($row['COUNT(*)'] > 0) {
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	};
	// Проверка колшчества заданий
	$m = 'SELECT COUNT(*) FROM shield WHERE id_user = ?';
	$r = mysql_qw($m, $_SESSION['id']);
	$row = mysql_fetch_assoc($r);
	if ($row['COUNT(*)'] >= $max) {
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
	  	exit();
	};

	$m = 'SELECT nazvanie FROM arsenal WHERE 
		id_user = ? and id_rz = ?
	';
	$r = mysql_qw($m, $_SESSION['id'], $shield) or die(mysql_error());
	$row = mysql_fetch_assoc($r) or die(mysql_error());
	$m = 'INSERT INTO shield SET 
		id_zsh = ?,
		nazvanie_zsh = ?,
		id_user = ?
	';
	mysql_qw($m, $shield, $row['nazvanie'], $_SESSION['id']) or die(mysql_error());
	
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  	exit();
}
//обработчик удаления из щита
if (isset($_REQUEST['del'])) {
	$del = $_REQUEST['del'];
	$m = 'DELETE FROM shield WHERE id_zsh = ? and id_user = ?';
	mysql_qw($m, $del, $_SESSION['id']) or die(mysql_error());
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  	exit();
}
?>

<html>
<head>
	<title>Моя страница</title>
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
		<td><a href="game_js_online.php">Игроки онлайн</a></td>
		<td><a href="game_js_invitation.php">Приглашения</a></td>
		<td><a href = "tr_js.php">Текущий бой</a></td>
		<td><a href="<?=$_SERVER['SCRIPT_NAME']?>?out">Выйти</a></td>
	</tr>
</table>
</div>
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td><?=$_SESSION['imya']?>&nbsp;<?=$_SESSION['familiya']?><a href="<?=$_SERVER['SCRIPT_NAME']?>?statist=1">(Статистика)</a></td>
	</tr>
	<tr>
		<td width = "30%" valign = "top">
			<p>Щит</p>
			<p>
				<?
					$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
					$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
					for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
					echo "<p><a href = ".$_SERVER['SCRIPT_NAME']."?shield=".$row['id_zsh']."&nazvanie_zsh=".$row['nazvanie_zsh'].">".$row['nazvanie_zsh'].
					"</a><a href = ".$_SERVER['SCRIPT_NAME']."?del=".$row['id_zsh'].">(удалить)</a></p>";	
					};
					if ($_SESSION['readiness'] == 1) {
						echo "<p><a href = ".$_SERVER['SCRIPT_NAME']."?ready=0>Не готов</a></p>";	
					}
					else{
						echo "<p><a href = ".$_SERVER['SCRIPT_NAME']."?ready=1>Готов</a></p>";
					}


					
				?>
			</p>

			<p>Арсенал</p>
			<select name = "type2">
				<option>Выберите тип задачи</option>
				<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
				<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
				<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
				<option value = "Числовые_последовательности">Числовые_последовательности</option>
				<option value = "Функции">Функции</option>
				<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
				<option value = "Геометрия">Геометрия</option>
				<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>
				
			</select>
			<div id="list2"></div>
			
		</td>
		<td width = "40%" valign = "top" >
			
			
			
			<?
			if (isset($_REQUEST['statist'])) {
				$m = 'SELECT * FROM arsenal WHERE id_user = ?';
				$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				$a = array();
				for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row ) { 
					
					if ($row['tip'] == "Числа_и_вычисления") {
						$a['Числа_и_вычисления'] = $a['Числа_и_вычисления'] +1 ;
					}
					elseif ($row['tip'] == "Алгебраические_выражения") {
						$a['Алгебраические_выражения'] = $a['Алгебраические_выражения'] + 1;
					}
					elseif ($row['tip'] == "Уравнения_и_неравенства") {
						$a['Уравнения_и_неравенства'] = $a['Уравнения_и_неравенства'] +1;
					}
					elseif ($row['tip'] == "Числовые_последовательности") {
						$a['Числовые_последовательности'] = $a['Числовые_последовательности'] +1;
					}
					elseif ($row['tip'] == "Функции") {
						$a['Функции'] = $a['Функции'] + 1;
					}
					elseif ($row['tip'] == "Координаты_на_прямой_и_плоскости") {
						$a['Координаты_на_прямой_и_плоскости'] = $a['Координаты_на_прямой_и_плоскости'] + 1;
					}
					elseif ($row['tip'] == "Геометрия") {
						$a['Геометрия'] = $a['Геометрия'] + 1;
					}
					else{
						$a['Статистика_и_теория_вероятности'] = $a['Статистика_и_теория_вероятности'] + 1;
					};
				}
				
				foreach ($a as $key => $value) {
					$str .= $key.": ".$value."</br>";
				};
				echo $str;
			}
			else{
				if (isset($_REQUEST['id_z'])) {
					
					 
					$_SESSION['id_z'] = $_GET['id_z'];
				};
				$m = 'SELECT nazvanie FROM zadania WHERE id = ?';
				$r = mysql_qw('SELECT * FROM zadania WHERE id = ?', $_SESSION['id_z']) or die(mysql_error());
				$row = mysql_fetch_assoc($r);
				
				$m1 = "<p>Задание: ".$row['nazvanie']."</p><p>".$row['soderjanie']."</p>";
				$m2 = "<form method = 'get'>
					<input type = 'text' name = 'e[otvet]'></br>
					<input type = 'submit' name = 'otvet' value='Ответить'></br>
				</form>
				";
				if (isset($row['img'])) {			
				$m3 = "<p><img src = 'imag/".$row['img']."'></p>";
				$m4 = $m1.$m3.$m2;
				echo $m4;
				}
				else {echo "Выберите задание в правой колонке.";};
				$m = "UPDATE user SET activity = ".time()." WHERE id = ?";
				mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			};
			
			
			?>
		</td>
		<td width = "30%" valign = "top">
			<label>Тип задачи:</label></br>
			<select name = "type">
				<option>Выберите тип задачи</option>
				<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
				<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
				<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
				<option value = "Числовые_последовательности">Числовые_последовательности</option>
				<option value = "Функции">Функции</option>
				<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
				<option value = "Геометрия">Геометрия</option>
				<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>
			</select>
			<div id="list"></div>
			
		</td>
	</tr>
</table>
</div>

</body>
</html>