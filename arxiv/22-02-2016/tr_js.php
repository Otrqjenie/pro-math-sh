<?php
require_once "connect2.php";
require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");

if (!isset($_COOKIE['id']) and !isset($_COOKIE['hesh'])) {
	Header("Location: game_js_register.php");
};
if (!isset($_SESSION['id']) and !isset($_SESSION['hesh'])) {//Обработчик регистрации
	//print_r($_COOKIE);
	//Работаем здесь
	$m = 'SELECT * FROM user WHERE id = ?';
	$r = mysql_qw($m, $_COOKIE['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	$_SESSION['id'] = $row['id'];
    $_SESSION['hesh'] = $row['hesh'];
    $_SESSION['imya'] = $row['imya'];
    $_SESSION['familiya'] = $row['familiya'];
    $m = "UPDATE user SET activity = ".time()." WHERE id = ?".
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
};
// Проверка наличия текущего боя
$m = 'SELECT * FROM fight WHERE status = 2';
$r = mysql_qw($m);
$_SESSION['enemy'] = null;
$i = 0;
for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row ){
	if ($row['id_priglos'] == $_SESSION['id']) {
		$_SESSION['enemy'] = $row['id_prigloshaemogo'];
		$i++;
		$_SESSION['id_fight'] = $row['id_fight'];//Создаём id текущего боя
	}
	elseif ($row['id_prigloshaemogo'] == $_SESSION['id']) {
		$_SESSION['enemy'] = $row['id_priglos'];
		$i++;
		$_SESSION['id_fight'] = $row['id_fight'];//Создаём id текущего боя
	};
	
};
if ($i == 0) {
	$_SESSION['fighter'] = null;
	$_SESSION['enemy_shield'] = null;
	$_SESSION['id_fight'] = null;
	$_SESSION['proigish'] = null;
	$_SESSION['go_fight'] = null;
};

//Обработчик принятия приглашений
if (isset($_REQUEST['go_fight']) and ($_SESSION['enemy'] == null)) {
	if ($_REQUEST['go_fight'] == 1) {
		$_SESSION['go_fight'] = 1;
		$_SESSION['enemy'] = $_REQUEST['go_fight_id'];
		$m = 'UPDATE fight SET status = ?, time_begin = ? WHERE id_prigloshaemogo = ? 
		and id_priglos = ? and status = 1';
		mysql_qw($m, 2, time(), $_SESSION['id'], $_SESSION['enemy']) or die(mysql_error());
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	}
	else{
		$_SESSION['enemy'] = $_REQUEST['go_fight_id'];
		$m = 'DELETE FROM fight WHERE id_priglos = ? and id_prigloshaemogo = ?';
		mysql_qw($m, $_SESSION['enemy'], $_SESSION['id']) or die(mysql_error());
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	};
}
elseif ($_REQUEST['go_fight'] ==2) {
	$_SESSION['enemy'] = $_REQUEST['go_fight_id'];
	$m = 'DELETE FROM fight WHERE id_priglos = ? and id_prigloshaemogo = ?';
	mysql_qw($m, $_SESSION['enemy'], $_SESSION['id']) or die(mysql_error());
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  	exit();
};

//Поиск приглашений
$m = 'SELECT * FROM fight WHERE status = 1';
$r = mysql_qw($m) or die(mysql_error());
$priglo = array();
$i = 0;
for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row ){
	if ($row['id_prigloshaemogo'] == $_SESSION['id']) {
		$priglo[] = $row;
		$i++;
	}
	elseif ($row['id_priglos'] == $_SESSION['id']) {
		$priglo[] = $row;
		$i++;
	}
};
if ($i > 0 ) {
	$_SESSION['priglos'] = $priglo;
}
else{
	$_SESSION['priglos'] = null;
};
//Обработчик ответов
if (isset($_GET['otvet'])) {
	if ($_SESSION['id_fight'] == null) {
		$_SESSION['proigish'] = "Вы проиграли";
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	}
	$e = $_GET['e'];
	$m = 'SELECT * FROM zadania WHERE id =?';
	$r = mysql_qw($m, $_SESSION['enemy_shield']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	if ($row[otvet] == $e['otvet']) {
		mysql_qw('DELETE FROM shield WHERE id_user = ? and id_zsh = ?', $_SESSION['enemy'], $_SESSION['enemy_shield']) or die(mysql_error());
	}
	else "неверно";
}

?>


<html>
<head>
<title>Бой</title>
	<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
	<script type="text/javascript" src = "lib/tr_js.js"></script>
	<link rel="stylesheet" type="text/css" href="css/tr_js.css">
</head>
<body>
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td><a href = "game_js.php">Моя страница</a></td>
		<td><a href="game_js_online.php">Игроки онлайн</a></td>
		<td>Текущий бой</td>
		<td><a href="<?=$_SERVER['SCRIPT_NAME']?>?out">Выйти</a></td>
	</tr>
</table>
</div>

<div id = "conteiner">
<?
			if (isset($_REQUEST['enemy_shield'])) {
				$_SESSION['enemy_shield'] = $_REQUEST['enemy_shield'];
			}
			
			// Провеяем принятость приглашений
			if (isset($_SESSION['enemy'])) {
				$i = 0;
				$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
				$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
						
					$i++;
				};
				if ($i > 0) {
					
				
				$r = mysql_qw('SELECT * FROM zadania WHERE id = ?', $_SESSION['enemy_shield']) or die(mysql_error());
            	$row = mysql_fetch_assoc($r);
            	
            	$m1 = "<p>".$row['nazvanie']."Название</p><p>".$row['soderjanie']."</p>";
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
				else {echo "Выберите задание выше.";};

				};
			if ($i == 0) {
				$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
				mysql_qw($m, $_SESSION['id'], $_SESSION['id_fight']) or die(mysql_error());
				$_SESSION['result'] = "Вы победили!";
				echo "<h1>Вы победили!!!</h1>";
			};
			$i = 0;
				$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
				$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
						
					$i++;
				};
			if ($i == 0) {
				echo "<h1>Вы проиграли</h1>";
			}
			}
			else {
				echo $_SESSION['result'];
				$_SESSION['result'] = null;
			};
			
			?>
</div>

<?
		$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
		$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		echo "<div id = 'shield'>";
		for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
			echo " <p >".$row['nazvanie_zsh']."</p> ";
		};
		echo "</div>";


if (isset($_SESSION['enemy'])) {
				$i = 0;
				$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
				$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				echo "<div id = 'shield2'>";
				for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
					echo "<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie_zsh'].
					"</p>";	
					$i++;
				};
				echo "</div>";
			};
?>



</body>

</html>


