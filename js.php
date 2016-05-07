<?php
require_once "connect2.php";
require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");
//Обработчик выбора заданий проверяет наличие врага
if (isset($_REQUEST['enemy_shield'])) {
				$_SESSION['enemy_shield'] = $_REQUEST['enemy_shield'];
			
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
            	$_SESSION['enemy_shield_name'] = $row['nazvanie'];
            	$_SESSION['slojnost'] = $row['slojnost'];
            	
            	$m1 = "<p>Задание: ".$row['nazvanie']."</p><p>".$row['soderjanie']."</p>";
            	$m2 = "
            	    <input type = 'text' id = 'otvet'></br>
            	    <input type = 'button' onclick = 'check()' name = 'otvet' value='Ответить'></br>
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
				$_SESSION['result'] = "<h1>Вы победили!!!</h1>";
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
		};
		// Проверка наличия текущего боя
		if (!isset($_SESSION['myarsenal'])) {
			$m = 'SELECT * FROM arsenal WHERE id_user = ?';
			$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			for ( $data = array(); $row = mysql_fetch_assoc($r) ; $_SESSION['myarsenal'][] = $row) { 
				# code...
			}
		};
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
			// $_SESSION['id_fight'] = null;
			$_SESSION['proigish'] = null;
			$_SESSION['go_fight'] = null;
			$_SESSION['slojnost'] = null;
			$_SESSION['enemy_shield_name'] = null;
		};


		// -------------------------------------------------
		// Обработка приглашений(game_js_invitation.js)
if (isset($_REQUEST['invitat'])) {
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




}
if ( isset($_REQUEST['type'])) {
	
	$m = 'SELECT * FROM zadania WHERE tip = ?';
	$tip = $_REQUEST['type'];
			$r = mysql_qw($m, $tip) or die(mysql_error());
			for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row) { 
				echo "<a href ='game_js.php?id_z=".$row['id']."'>".$row['nazvanie']."</a></br>";
			};
}
if ( isset($_REQUEST['type2'])) {
	$m = 'SELECT * FROM arsenal WHERE id_user = ?';
	$tip = $_REQUEST['type2'];
			$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row) { 
				$m2 = 'SELECT * FROM zadania WHERE tip = ? and id = ?';
				$row2 = '';
				$r2 = mysql_qw($m2, $tip, $row['id_rz']) or die(mysql_error());
				$row2 = mysql_fetch_assoc($r2);
				// print_r($row2);
				// echo $row2['nazvanie']."</br>";

				echo "<a href ='game_js.php?shield=".$row2['id']."'>".$row2['nazvanie']."</a></br>";
			};
}
//--------------------------------------------------
//Обработка tr_js.php
//Обработчик ответов
if (isset($_REQUEST['otvet'])) {
	$m = 'SELECT count FROM user_param WHERE id = ?';
	$r = mysql_qw($m,$_SESSION['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	$_SESSION['count'] = $row['count'];
// --------------------------------
// считаем щиты противника
	$r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['enemy']) or die(mysql_error());
	$row2 = mysql_fetch_assoc($r2);
	$_SESSION['quantity_enemy'] = $row2['COUNT(*)'];

$a[1] = 0;
$a[2] = 12;
$a[3] = 30;
$a[4] = 57;
$a[5] = 99;
$a[6] = 162;
$a[7] = 255;
$a[8] = 393;
$a[9] = 600;
$a[10] = 900;
$a[11] = 1260;
// --------------------------------

	$ot = $_REQUEST['otvet'];
	
	if ($_SESSION['id_fight'] == null) {
		$_SESSION['proigish'] = "Вы проиграли";
		echo "Вы проиграли";
		// Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  // 		exit();
	}
	// $e = $_GET['e'];
	$m = 'SELECT * FROM zadania WHERE id =?';
	$r = mysql_qw($m, $_SESSION['enemy_shield']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	if ($row['otvet'] == $ot) {


		mysql_qw('DELETE FROM shield WHERE id_user = ? and id_zsh = ?', $_SESSION['enemy'], $_SESSION['enemy_shield']) or die(mysql_error());


		$m = "INSERT INTO fire SET 
			id_strel = ?,
			id_jertvi = ?,
			vremya = ?,
			id_z = ?,
			rez = ?,
			ot = 0
		";
		mysql_qw($m, $_SESSION['id'], $_SESSION['enemy'], time(), $_SESSION['enemy_shield'], 1) or die(mysql_error());
		$m = 'SELECT count FROM user_param WHERE id = ?';
		$r = mysql_qw($m,$_SESSION['id']) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		$myarsenal = $_SESSION['myarsenal'];
		$i = 0;
		
			foreach ($myarsenal as $key => $value) {
				if ($value['id_rz'] == $_SESSION['enemy_shield']) {
					$i++;
				};
			};
		
		
		
		if ($i == 0) {
			// Доработать здесь
			$m = "INSERT INTO arsenal SET 
				id_user = ?, 
				id_rz =  ?,
				nazvanie = ?
			";
			mysql_qw($m, $_SESSION['id'], $_SESSION['enemy_shield'], $_SESSION['enemy_shield_name']) or die(mysql_error());
			if ($_SESSION['slojnost'] = 'Базовый') {
				$i = 3;
			}
			elseif ($_SESSION['slojnost'] = 'Повышенный') {
				$i = 15;
			}
			elseif ($_SESSION['slojnost'] ='Высокий') {
				$i = 30;
			}
			else{
				$i = 180;
			}
			$count = $row['count'] + $i;
			$m = "UPDATE user_param SET count = ? WHERE id = ?";
			mysql_qw($m, $count, $_SESSION['id']) or die(mysql_error());
			$_SESSION['count'] = $count;

		};
	$m = 'SELECT * FROM shield WHERE id_user = ?';
	$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
	$j = 0;
	// echo "Вражеский щит";
	for ( $data = array(); $row = mysql_fetch_assoc($r) ; $data[] =$row ) { 
		$j++;
		// echo "<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie_zsh'].
		// 			"</p>";	
	};

	if ($j == 0) {
		// Добавляем количество побед и поражений
		$figthts = 0; $vins = 0;
		$m = 'SELECT figthts, vins FROM user_param WHERE id = ?';
		$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		$figthts = $row['figthts'] + 1;
		$vins = $row['vins'] + 1;
		$m = 'UPDATE user_param SET figthts = ?, vins = ? WHERE id = ?';
		mysql_qw($m, $figthts, $vins, $_SESSION['id']) or die(mysql_error());
		$m = 'SELECT figthts FROM user_param WHERE id = ?';
		$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		$figthts = $row['figthts'] + 1;
		$m = 'UPDATE user_param SET figthts = ? WHERE id = ?';
		mysql_qw($m, $figthts, $_SESSION['enemy']) or die(mysql_error());
		// -----------------------------------------
		$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
		mysql_qw($m, $_SESSION['id'], $_SESSION['id_fight']) or die(mysql_error());
		$_SESSION['result'] = "Вы победили!";
		$str ="<h1>Вы победили!!!</h1>";
		// echo "<h1>Вы победили!!!</h1>";
		echo json_encode(array("str" => $str, "count" => "Опыт: ".$_SESSION['count'], "quantity_enemy" => $_SESSION['quantity_enemy']));
	}
	else {



	$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
	$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
	$str = "<p>Вражеский щит</p>";
	
	for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
		$str = $str."<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie_zsh']."</p>";	
	};
	echo json_encode(array("str" => $str, "count" => "Опыт: ".$_SESSION['count'], "quantity_enemy" => $_SESSION['quantity_enemy']));
	};
	
	}
	else {
	$m = "INSERT INTO fire SET 
		id_strel = ?,
		id_jertvi = ?,
		vremya = ?,
		id_z = ?,
		rez = ?,
		ot = 0
	";

	mysql_qw($m, $_SESSION['id'], $_SESSION['enemy'], time(), $_SESSION['enemy_shield'], 0) or die(mysql_error());
	$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
	$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
	$str = "<p>Вражеский щит</p>";
	for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
		$str =  $str."<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie_zsh']."</p>";	
	};
	echo json_encode(array("str" => $str, "count" => "Опыт: ".$_SESSION['count'], "quantity_enemy" => $_SESSION['quantity_enemy']));
};

}
// ----------------------------------------------------------------------------------
// Обработчик запросов на проверку огня противника
if (isset($_REQUEST['fire2'])) {
	// Считаем время до конца боя
	if (isset($_SESSION['id_fight'])) {
		$_SESSION['t'] = $_SESSION['time_begin'] + $_SESSION['duration']*60 - time();
		if ($_SESSION['t'] < 0) {
			// делаем записи в таблице о ничьей

			$figthts = 0; $vins = 0;
			$m = 'SELECT figthts, vins FROM user_param WHERE id = ?';
			$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			$row = mysql_fetch_assoc($r);
			$figthts = $row['figthts'] + 1;
			$vins = $row['vins'];
			$m = 'UPDATE user_param SET figthts = ?, vins = ? WHERE id = ?';
			mysql_qw($m, $figthts, $vins, $_SESSION['id']) or die(mysql_error());
			$m = 'SELECT figthts FROM user_param WHERE id = ?';
			$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
			$row = mysql_fetch_assoc($r);
			$figthts = $row['figthts'] + 1;
			$m = 'UPDATE user_param SET figthts = ? WHERE id = ?';
			mysql_qw($m, $figthts, $_SESSION['enemy']) or die(mysql_error());
			

			$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
			mysql_qw($m, -1, $_SESSION['id_fight']) or die(mysql_error());
			$_SESSION['result'] = "Вы победили!";
			$str ="<h1>Вы победили!!!</h1>";



			// ------------------------------

			$str = "Ничья";
			echo json_encode(array("str" => $str, "t" => $_SESSION['t']));
		}
		else{


	
	// ------------------------------
	// считаем свои щиты
	$r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['id']) or die(mysql_error());
	$row2 = mysql_fetch_assoc($r2);
	$_SESSION['quantity'] = $row2['COUNT(*)'];


	$m = 'SELECT * FROM fire WHERE id_jertvi = ? and ot = 0';
	// echo "string</br>";
	$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	if (isset($row['ot'])) {
		// echo "работает";
		if ($row['ot'] == 0) {
			
			$m = 'UPDATE fire SET ot = 1 WHERE id_jertvi = ?';
			mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			if ($row['rez'] == 1) {
				// Проверка опыта врага
				$m = 'SELECT count FROM user_param WHERE id = ?';
				$r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				$row = mysql_fetch_assoc($r);
				$_SESSION['enemy_count'] = $row['count'];
				// -----------------------------------------------------
				$str = '<p>Ваш щит</p>';
				$m = 'SELECT * FROM shield WHERE id_user = ?';
				$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				$j = 0;
				for ($data2 = array(); $row2 = mysql_fetch_assoc($r) ; $data2[] = $row2) { 
					$str = $str."<p>".$row2['nazvanie_zsh']."</p>";
					$j++;
				};
				if ($j == 0) {
					$str = "Вы проиграли.";
					$_SESSION['id_fight'] = null;
				};
				echo json_encode(array("rez" => 1, "str" => $str, "quantity" => $_SESSION['quantity'], "enemy_count" => $_SESSION['enemy_count'], "t" => $_SESSION['t']));
			}
			elseif ($row['rez'] == 0) {
				echo json_encode(array("rez" => 0, "quantity" => $_SESSION['quantity'], "t" => $_SESSION['t']));
			};
			

		}
	}
	else{
		echo json_encode(array("rez" => 2, "str" => '$str', "quantity" => $_SESSION['quantity'], "t" => $_SESSION['t']));
	};
	};
	};
};
// загрузка стилей в начале
if (isset($_REQUEST['begin'])) {
	$r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['id']) or die(mysql_error());
	$row2 = mysql_fetch_assoc($r2);
	$_SESSION['quantity'] = $row2['COUNT(*)'];

	$r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['enemy']) or die(mysql_error());
	$row2 = mysql_fetch_assoc($r2);
	$_SESSION['quantity_enemy'] = $row2['COUNT(*)'];
	echo json_encode(array("quantity" => $_SESSION['quantity'], "quantity_enemy" => $_SESSION['quantity_enemy']));
}
?>