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

?>
<html>
<head>
	<title>Приглашения</title>
	<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
	<script type="text/javascript" src = "lib/game_js_invitation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/game_js_invitation.css">
</head>
<body>
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td><a href = "game_js.php">Моя страница</a></td>
		<td><a href="game_js_online.php">Игроки онлайн</a></td>
		<td><a href="game_js_invitation.php">Приглашения</a></td>
		<td><a href="tr_js.php">Текущий бой</a></td>
		<td><a href="<?=$_SERVER['SCRIPT_NAME']?>?out">Выйти</a></td>
	</tr>
</table>
</div>
<div id = "conteiner" align = "center">
<?


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
// ----
	if ($_SESSION['priglos'] != null) {
		foreach ($_SESSION['priglos'] as $key => $value) {					
			echo "</br>";
			if (($value['id_priglos'] == $_SESSION['id']) and ($value['status'] == 1)) {
				$m = 'SELECT * FROM user WHERE id = ?';
				$r = mysql_qw($m, $value['id_prigloshaemogo']) or die(mysql_error());
				$row = mysql_fetch_assoc($r);
				echo "Вы пригласили игрока: ".$row['imya']." ".$row['familiya']."</br>" ;
			}
			elseif (($value['id_prigloshaemogo'] == $_SESSION['id']) and ($value['status'] == 1)) {
				$m = 'SELECT * FROM user WHERE id = ?';
				$r = mysql_qw($m, $value['id_priglos']) or die(mysql_error());
				$row = mysql_fetch_assoc($r);
				echo "Вас пригласил игрок : ".$row['imya']." ".$row['familiya']."<a href = tr_js.php?go_fight=1&go_fight_id=".$row['id']."> Принять</a>
				<a href = tr_js.php?go_fight=2&go_fight_id=".$row['id']."> Отклонить</a></br>" ;
			};
		};
	};






?>

</div>
</body>
</html>



