<?php
if (!defined('proverka')) {
	die();
};

// require_once "connect2.php";
// require_once "lib/request.php";

if (!isset($_SESSION['id']) and !isset($_SESSION['hesh'])) {//Обработчик регистрации
	//print_r($_COOKIE);
	//Работаем здесь
	// доделать
	$c_id = filter_input(INPUT_COOKIE, 'id', FILTER_VALIDATE_INT);
	$m = 'SELECT * FROM user WHERE id = '.$c_id;
	$r = $db -> query($m);
	$row = $r -> fetch_assoc();
	$r -> close();
	print_r($row);
	$_SESSION['id'] = $row['id'];
    $_SESSION['hesh'] = $row['hesh'];
    $_SESSION['imya'] = filter_var($row['imya'], FILTER_SANITIZE_STRING);;
    $_SESSION['familiya'] = filter_var($row['familiya'], FILTER_SANITIZE_STRING);

    $m = "UPDATE user SET activity = ".time()." WHERE id = ?";
	$r = $db -> prepare($m);
	$r -> bind_param('i', $_SESSION['id']);
	$r -> execute();
	$r ->close();
};
//выход
if (isset($_REQUEST['out'])) {
	setcookie('id');
	setcookie('hesh');
	session_destroy();
	Header("Location: game_js_register.php");
};

// Проверка наличия текущего боя
// $m = 'SELECT * FROM fight WHERE status = 1';
// пробное
if ($r = $db -> query('SELECT * FROM fight WHERE status = 1')) {
};


$_SESSION['enemy'] = null;
$i = 0;
for ($data = array(); $row = $r -> fetch_assoc(); $data[] = $row ){
	if ($row['id_priglos'] == $_SESSION['id']) {
		$_SESSION['enemy'] = filter_var($row['id_prigloshaemogo'], FILTER_SANITIZE_STRING);
		$i++;
		$_SESSION['id_fight'] = filter_var($row['id_fight'], FILTER_SANITIZE_STRING);//Создаём id текущего боя;
		$_SESSION['time_begin'] = filter_var($row['time_begin'], FILTER_SANITIZE_STRING);
		$_SESSION['duration'] = filter_var($row['duration'], FILTER_SANITIZE_STRING);
	}
	elseif ($row['id_prigloshaemogo'] == $_SESSION['id']) {
		$_SESSION['enemy'] = filter_var($row['id_priglos'], FILTER_SANITIZE_STRING);
		$i++;
		$_SESSION['id_fight'] = $row['id_fight'];//Создаём id текущего боя
		$_SESSION['duration'] = $row['duration'];
		$_SESSION['time_begin'] = $row['time_begin'];
	};
};
	// $r -> free();
	$r -> close();
if ($i == 0) {
	$_SESSION['fighter'] = null;
	$_SESSION['enemy_shield'] = null;
	$_SESSION['id_fight'] = null;
	$_SESSION['proigish'] = null;
	$_SESSION['go_fight'] = null;
	$_SESSION['time_begin'] = null;
	$_SESSION['duration'] = null;
};

//Обработчик принятия приглашений
// if (isset($_REQUEST['go_fight']) and ($_SESSION['enemy'] == null)) {
// 	if ($_REQUEST['go_fight'] == 1) {
// 		$_SESSION['go_fight'] = 1;
// 		$_SESSION['enemy'] = filter_var($_REQUEST['go_fight_id'], FILTER_SANITIZE_STRING);
// 		$m = 'UPDATE fight SET status = ?, time_begin = ? WHERE id_prigloshaemogo = ? 
// 		and id_priglos = ? and status = 1';
// 		$t = time();
// 		$_SESSION['time_begin'] = $t;
// 		mysql_qw($m, 2, $t, $_SESSION['id'], $_SESSION['enemy']) or die(mysql_error());
// 		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
//   		exit();
// 	}
// 	else{
// 		$_SESSION['enemy'] = filter_var($_REQUEST['go_fight_id'], FILTER_SANITIZE_STRING);
// 		$m = 'DELETE FROM fight WHERE id_priglos = ? and id_prigloshaemogo = ?';
// 		mysql_qw($m, $_SESSION['enemy'], $_SESSION['id']) or die(mysql_error());
// 		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
//   		exit();
// 	};
// }
// elseif ($_REQUEST['go_fight'] ==2) {
// 	$_SESSION['enemy'] = filter_var($_REQUEST['go_fight_id'], FILTER_SANITIZE_STRING);
// 	$m = 'DELETE FROM fight WHERE id_priglos = ? and id_prigloshaemogo = ?';
// 	mysql_qw($m, $_SESSION['enemy'], $_SESSION['id']) or die(mysql_error());
// 	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
//   	exit();
// };

//Поиск приглашений
// $m = 'SELECT * FROM fight WHERE status = 1';
// $r = mysql_qw($m) or die(mysql_error());
// $priglo = array();
// $i = 0;
// for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row ){
// 	if ($row['id_prigloshaemogo'] == $_SESSION['id']) {
// 		$priglo[] = $row;
// 		$i++;
// 	}
// 	elseif ($row['id_priglos'] == $_SESSION['id']) {
// 		$priglo[] = $row;
// 		$i++;
// 	}
// };
// if ($i > 0 ) {
// 	$_SESSION['priglos'] = filter_var($priglo, FILTER_SANITIZE_STRING);
// }
// else{
// 	$_SESSION['priglos'] = null;
// };
//Обработчик ответов
if (isset($_GET['otvet'])) {
	if ($_SESSION['id_fight'] == null) {
		$_SESSION['proigish'] = "Вы проиграли";
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	}
	$e = $_GET['e'];
	$m = 'SELECT * FROM zadania WHERE id ='.$_SESSION['enemy_shield'];
	$r = $db -> query($m);
	// $r -> bind_param('i', $_SESSION['enemy_shield']);
	$row = $r -> fetch_assoc();
	$r -> close();
	// $r = mysql_qw($m, $_SESSION['enemy_shield']) or die(mysql_error());
	// $row = mysql_fetch_assoc($r);
	if ($row['otvet'] == $e['otvet']) {
		$r = $db -> prepare('DELETE FROM shield WHERE id_user = ? and id_zsh = ?');
		$r -> bind_param('ii', $_SESSION['enemy'], $_SESSION['enemy_shield']);
		$r -> execute();
		$r -> close();
		// mysql_qw('DELETE FROM shield WHERE id_user = ? and id_zsh = ?', $_SESSION['enemy'], $_SESSION['enemy_shield']) or die(mysql_error());
	};
	// else "неверно";
}

?>


<html>
<head>
<title>Бой</title>
	<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
	<script type="text/javascript" src = "lib/tr_js.js"></script>
	<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<link rel="stylesheet" type="text/css" href="css/tr_js.css">
</head>
<body>
<div align  = "center">


<div id="scene">
	<div id = "circle"></div>
	<div id = "circle2"></div>
	<div id = "gun"><img src="imag/gun2.png"  height = "100" width = "160"></div>
	<div id = "gun2"><img src="imag/gun3.png"  height = "100" width = "160"></div>
	<div id="shar"></div>
	<div id="shar2"></div>
</div>
<div id="win"></div>

<div id = "conteiner">
</div>

<?
		// вводим ограничение на раздел из боя
		$r = $db -> prepare("SELECT razdel FROM fight WHERE id_fight = ?");
		$r -> bind_param('i', $_SESSION['id_fight']);
		$r -> execute();
		$r -> bind_result($razdel);
		$r -> fetch();
		$r -> close();
		$s_id = filter_var($_SESSION[id], FILTER_VALIDATE_INT);
		$m = 'SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = '.$s_id.' and z.razdel = "'.$razdel.'" ORDER BY s.id_zsh';
		$r = $db -> query($m);
		echo "<div id = 'shield'> Ваш щит";
		for ($data = array(); $row = $r -> fetch_array(MYSQL_ASSOC); $data[] = $row) { 
			echo " <p >".$row['nazvanie']."</p> ";
		};
		echo "</div>";
		$r -> close();
		$m = "SELECT user.imya, user.familiya, user_param.count FROM user, user_param WHERE user_param.id = ".$s_id." and user.id = user_param.id";
		// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		$r = $db -> query($m);
		// $r -> execute();
		$row = $r -> fetch_array();
		$_SESSION['count'] = filter_var($row['count'], FILTER_SANITIZE_STRING);
		$row['imya'] = filter_var($row['imya'], FILTER_SANITIZE_STRING);
		$row['familiya'] = filter_var($row['familiya'], FILTER_SANITIZE_STRING);
		$row['count'] = filter_var($row['count'], FILTER_SANITIZE_STRING);
		echo "<div id='name'><p>".$row['imya']." ".$row['familiya']."</p>
			<p id = 'experience'>Опыт: ".$row['count']."</p>
		</div>";
		$r -> close();
		// $r -> prepare();
if (isset($_SESSION['enemy'])) {
			function Fun_add($value='')
			{
				# code...
			}
				$e_id = filter_var($_SESSION['enemy'], FILTER_VALIDATE_INT);
				$m = "SELECT * FROM user WHERE id = ".$e_id;
				$r = $db -> query($m);
				// $r -> bind_param('i', $_SESSION['id']);
				// $r -> execute();
				// $r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				$row = $r -> fetch_array(MYSQL_ASSOC);
				$r -> close();
				$_SESSION['enemy_cunt'] = filter_var($row['count'], FILTER_SANITIZE_STRING);
				$row['imya'] = filter_var($row['imya'], FILTER_SANITIZE_STRING);
				$row['familiya'] = filter_var($row['familiya'], FILTER_SANITIZE_STRING);
				$_SESSION['enemy_cunt'] = filter_var($_SESSION['enemy_cunt'], FILTER_SANITIZE_STRING);
				echo "<div id='name2'><p>".$row['imya']." ".$row['familiya']."</p>
					<p id = 'experience_e'>Опыт: ".$_SESSION['enemy_cunt']."</p>
				</div>";
				$i = 0;
				$e_id = filter_var($_SESSION['enemy'], FILTER_VALIDATE_INT);
				$m = 'SELECT s.id_zsh, s.id_user, z.nazvanie  FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = '.$e_id.' ORDER BY s.id_zsh';
				if($r = $db -> query($m)){
					echo "<div id = 'shield2'> <p>Вражеский щит</p> ";
					for ($data = array(); $row = $r -> fetch_array(MYSQL_ASSOC); $data[] = $row) {
						$row['id_zsh'] = filter_var($row['id_zsh'], FILTER_SANITIZE_STRING); 
						echo "<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie'].
						"</p>";	
						$i++;
					};
					echo "</div>";
				};
				$r -> close();
								
			};
?>

<div id="name2"></div>
</div>
</body>


</html>


