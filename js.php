<?php
// Возможно удалить(удалить в конце недели если не нашлось применения)
// Найти ошибку
// Можно усовершенствовать
// Доделать
// работаю
// разобраться
define('proverka', 84);
// require_once "connect2.php";
require_once 'lib/connect.php';
// require_once "lib/request.php";
session_start();
header("Content-Type: text/html; charset=utf-8");
function ses_del()
{
	$_SESSION['fighter'] = null;
	$_SESSION['enemy_shield'] = null;
	$_SESSION['id_fight'] = null;
	$_SESSION['proigish'] = null;
	$_SESSION['go_fight'] = null;
	$_SESSION['slojnost'] = null;
	$_SESSION['enemy_shield_name'] = null;
};
//Обработчик выбора заданий проверяет наличие врага привет
if (isset($_REQUEST['enemy_shield'])) {
	// Можно усовершенствовать
	// сделать проверку не пуст ли enemy_shield
				$_SESSION['enemy_shield'] = filter_var($_REQUEST['enemy_shield'], FILTER_VALIDATE_INT);
			
if (isset($_SESSION['enemy'])) {
				$i = 0;
				$e_id = filter_var($_SESSION['enemy'], FILTER_VALIDATE_INT);
				$m = 'SELECT * FROM shield WHERE id_user = '.$e_id.' ORDER BY id_zsh';
				$r = $db -> query($m);
				// $r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				for ($data = array(); $row = $r -> fetch_array(MYSQL_ASSOC); $data[] = $row) { 
					$i++;
				};
				if ($i > 0) {
				$m = 'SELECT * FROM zadania WHERE id = '.$_SESSION['enemy_shield'];
				$r = $db -> query($m);
				// $r = mysql_qw('SELECT * FROM zadania WHERE id = ?', $_SESSION['enemy_shield']) or die(mysql_error());
            	$row = $r -> fetch_array(MYSQL_ASSOC);
            	$r -> close();
            	$_SESSION['enemy_shield_name'] = $row['nazvanie'];
            	$_SESSION['slojnost'] = $row['slojnost'];
            	
            	$m1 = "<p>Задание: ".$row['nazvanie']."</p><p>".$row['soderjanie']."</p>";
            	$m2 = "
            	    <input type = 'text' id = 'otvet'></br>
            	    <input type = 'button' onclick = 'check()' name = 'otvet' value='Ответить'></br>
            	";
            	if (isset($row['img'])) {           
            	$m3 = "<p><img src = 'imag/".$row['img']."'></p>";
            	$m4 = $m1.$m3.$m2."<p>номер=".$_SESSION['enemy_shield']."</p>";
            	echo $m4;
            	}
				else {echo "Выберите задание выше.";};

				};
			if ($i == 0) {
				// Разобраться
				$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
				$r = $db -> prepare($m);
				$r -> bind_param('ii', $_SESSION['id'], $_SESSION['id_fight']);
				$r -> execute();
				$r -> close();
				// mysql_qw($m, $_SESSION['id'], $_SESSION['id_fight']) or die(mysql_error());
				$_SESSION['result'] = "<h1>Вы победили!!!</h1>";
				echo "<h1>Вы победили!!!</h1>";
			};
			$i = 0;
				$s_id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
				$m = 'SELECT * FROM shield WHERE id_user = '.$s_id.' ORDER BY id_zsh';
				// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				$r = $db -> query($m);
				for ($data = array(); $row = $r -> fetch_array(MYSQL_ASSOC); $data[] = $row) { 
						
					$i++;
				};
				$r -> close();
			if ($i == 0) {
				echo "<h1>Вы проиграли</h1>";
			}

			if ($i == 0) {

				ses_del();
			};

			
			}
			else {
				echo $_SESSION['result'];
				$_SESSION['result'] = null;
			};
		};
		// Проверка наличия текущего боя 
		if (!isset($_SESSION['myarsenal'])) {
			// $m = 'SELECT * FROM arsenal WHERE id_user = ?';
			if ($r = $db->prepare('SELECT * FROM arsenal WHERE id_user = ?')) {
				// Найти ошибку
				if ($result->num_rows) {
					$r->bind_param('i', $_SESSION['id']);
					$r->execute();	
					$rows = $r->fetch_assoc();
					print_r($rows);				
				}
			}

			

		};



		// -------------------------------------------------


if (isset($_REQUEST['type'])) {
	$_SESSION['stranica'] = 1;
	$tip = filter_var($_REQUEST['type'], FILTER_SANITIZE_SPECIAL_CHARS);
	switch ($tip) {
		case 'accordeon1':
			$tip = 'Числа_и_вычисления';
			break;
		case 'accordeon2':
			$tip = 'Алгебраические_выражения';
			break;
		case 'accordeon3':
			$tip = 'Уравнения_и_неравенства';
			break;
		case 'accordeon4':
			$tip = 'Числовые_последовательности';
			break;
		case 'accordeon5':
			$tip = 'Функции';
			break;
		case 'accordeon6':
			$tip = 'Координаты_на_прямой_и_плоскости';
			break;
		case 'accordeon7':
			$tip = 'Геометрия';
			break;
		case 'accordeon8':
			$tip = 'Статистика_и_теория_вероятности';
			break;		
		default:
			die();
			break;
	};
	$_SESSION['tip_nz'] = $tip;
	// Выборка всех заданий, что есть у игрока в арсенале
	$a = array();
	$r = $db -> prepare('SELECT id_rz FROM arsenal WHERE id_user = ?');
	$r -> bind_param('i', $_SESSION['id']);
	$r -> execute();
	$r -> bind_result($id_rz);
	while ($r -> fetch()) {
		$a[] = $id_rz;
	};
	$r -> close();
	// Считаем сколько страниц
	// $r = $


	$zadania = $db->prepare('SELECT id, nazvanie FROM zadania WHERE tip = ? and razdel = ?');
	
	$zadania->bind_param('ss', $tip, $_SESSION['razdel']);
	$zadania->execute();
	$zadania->bind_result($id, $nazvanie);
	$m = '';
	$i = 0;
	while (($zadania->fetch()) and ($i < 12)) {
		// Помарка найти как складываются строки
		$datchik = array_search($id, $a);
		if($datchik === false){
			$m = $m."<p class = my_sh onmousedown = show_nz(".$id.")>".$nazvanie."</p>";
			$i++;
		};
		

		
	};
	$m = "<div id = 'pole_zadanii_cont'>".$m."</div><div class = 'listanie' id = 'left_list'></div><div id = 'stranica'><p id = 'str'>1</p></div><div class = 'listanie' id = 'rightwards_list'></div>";
	$zadania -> close();
	echo $m;
	// echo json_encode(array());
	// echo $tip;

};
if ( isset($_REQUEST['type2'])) {
	$tip = trim($_REQUEST['type2']);
			// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
	$tip = filter_var($_REQUEST['type2'], FILTER_SANITIZE_SPECIAL_CHARS);
	switch ($tip) {
		case 'accordeon1':
			$tip = 'Числа_и_вычисления';
			break;
		case 'accordeon2':
			$tip = 'Алгебраические_выражения';
			break;
		case 'accordeon3':
			$tip = 'Уравнения_и_неравенства';
			break;
		case 'accordeon4':
			$tip = 'Числовые_последовательности';
			break;
		case 'accordeon5':
			$tip = 'Функции';
			break;
		case 'accordeon6':
			$tip = 'Координаты_на_прямой_и_плоскости';
			break;
		case 'accordeon7':
			$tip = 'Геометрия';
			break;
		case 'accordeon8':
			$tip = 'Статистика_и_теория_вероятности';
			break;		
		default:
			die();
			break;
	}
	$_SESSION['tip_rz'] = $tip;
			$r = $db->prepare("SELECT a.id_rz, z.nazvanie FROM arsenal a INNER JOIN zadania z ON a.id_rz = z.id WHERE a.id_user = ? and z.tip = ? ORDER BY id_rz");
			$r->bind_param('is', $_SESSION['id'], $tip);
			$r->execute();
			$r->bind_result($id_rz, $nazvanie);
			echo "<div>";
			$m1 = "";
			$i = 0;
			$a = array();
			while ($r->fetch()) {
				// $m = $m."<p class = 'my_sh' ><span onmousedown = show_z(".$id_rz.")>
				// ".$nazvanie."</span><span onmousedown = add(".$id_rz.")> +</span></p>";
				$a[$i]['id_rz'] = $id_rz;
				$a[$i]['nazvanie'] = $nazvanie;
				$a[$i]['metka'] = 0;
				$i++;
			};
			$r->close();
			// print_r($a);
			$r2 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z on s.id_zsh = z.id WHERE id_user = ?");
			$r2-> bind_param("i", $_SESSION['id']);
			$r2->execute();
			$r2->bind_result($id_zsh, $nazvanie_zsh);
			while ($r2->fetch()) {
				foreach ($a as $key => $value) {
					// echo "<pre>";
					// print_r($value);
					// echo "</pre>";
					if ($value['id_rz'] == $id_zsh) {
						$a[$key]['metka'] = 1;
					}
				}
			};
			$m = '';
			foreach ($a as $key => $value) {
				// echo "<pre>";
				// print_r($value);
				// echo "</pre>";
				if (!$value['metka']) {
					$m = $m."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
					".$value['nazvanie']."</span><span onmousedown = add(".$value['id_rz'].")> +</span></p>";
				}
				else{
					$m = $m."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
				".$value['nazvanie']."</span></p>";
				}
			};
			$r2->close();

			echo $m;
			
			echo "</div>";
}
//--------------------------------------------------
//Обработка tr_js.php
//Обработчик ответов
//  можно усовершенствовать собрав несколько запросов в один
if (isset($_REQUEST['otvet'])) {
	// Надо поставить ограничение на количество проверок ответов в минуту их должно быть не более 3-х
	$t = time()-60;
	$m = "SELECT COUNT(*) FROM fire WHERE id_strel = ? and vremya > ?";
	$r = $db -> prepare($m);
	$r -> bind_param('ii', $_SESSION['id'], $t);
	$r -> execute();
	$r -> bind_result($c_fire);
	$r -> fetch();
	$r -> close();
	if ($c_fire > 3) {
		$message = "Много ответов";
		echo json_encode(array("message" => $message));

	}
	else{	

		
		
		$s_id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
		$otvet = filter_var($_REQUEST['otvet'], FILTER_SANITIZE_SPECIAL_CHARS);

		// Проверяем ответ
		$m = 'SELECT COUNT(*), slojnost FROM zadania WHERE id = ? and otvet = ?';
		$r = $db -> prepare($m);
		$c_otvetov = 12;
		$r -> bind_param('is', $_SESSION['enemy_shield'], $otvet);
		$r -> execute();
		$r -> bind_result($c_otvetov, $slojnost);
		$r -> fetch();
		$r -> close();
		// ------------------------------------------------------
		// Добавляем в fire огонь
		$m = "INSERT INTO fire SET 
			id_strel = ?,
			id_jertvi = ?,
			vremya = ?,
			id_z = ?,
			rez = ?,
			ot = 0
		";
		$r = $db -> prepare($m);
		$r -> bind_param('iiiii', $_SESSION['id'], $_SESSION['enemy'], time(), $_SESSION['enemy_shield'], $c_otvetov);
		$r -> execute();
		$r -> close();
		// -----------------------------------------------
		if ($c_otvetov == 1) {
			// Считаем свои щиты
			$m = 'SELECT COUNT(*) FROM shield WHERE id_user = '.$_SESSION['id'];
			$r = $db -> query($m);
			$row2 = $r -> fetch_array(MYSQL_ASSOC);
			$c_sh = $row2['COUNT(*)'];
			$r -> close();
				$message	= "Верно";
			if ($c_sh > 0) {
				// Удаляем из щита решённое
				$m = "DELETE FROM shield WHERE id_user = ? and id_zsh = ?";
				$r = $db -> prepare($m);
				$r -> bind_param('ii', $_SESSION['enemy'], $_SESSION['enemy_shield']);
				$r -> execute();
				$r -> close();
				// Если у нас такой задачи в арсенале не было добавляем
				$count = 1;
				$m = 'SELECT COUNT(*) FROM arsenal WHERE id_user = ? and id_rz = ?';
				$r = $db -> prepare($m);
				$r -> bind_param('ii', $_SESSION['id'], $_SESSION['enemy_shield']);
				$r -> execute();
				$r -> bind_result($count);
				$r -> fetch();
				$r -> close();
				if ($count == 0) {
					// Добавляем опыта себе
					$m = "SELECT experience FROM user_param WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('i', $_SESSION['id']);
					$r -> execute();
					$r -> bind_result($experience);
					$r -> fetch();
					$r -> close();

					$experience = $experience + $slojnost;
					$m = "UPDATE user_param SET experience = ? WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('ii', $experience, $_SESSION['id']);
					$r -> execute();
					$r -> close();

					// добавляем в арсенал
					$m = 'INSERT INTO arsenal (id_user, id_rz) VALUES(?, ?)';
					$r = $db -> prepare($m);
					$r -> bind_param('ii', $_SESSION['id'], $_SESSION['enemy_shield']);
					$r -> execute();
					$r -> close();
				};
				// считаем щиты противника
				$m = "SELECT COUNT(*) FROM shield WHERE id_user = ".$_SESSION['enemy'];
				$r = $db -> query($m);
				$row = $r -> fetch_array(MYSQL_ASSOC);
				$c_sh = $row['COUNT(*)'];
				if ($c_sh > 0) {
					// Усовершенствовать
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
					$str = "<div id='name2'><p>".$row['imya']." ".$row['familiya']."</p>
						<p id = 'experience_e'>Опыт: ".$_SESSION['enemy_cunt']."</p>
					</div>";
					$i = 0;
					$e_id = filter_var($_SESSION['enemy'], FILTER_VALIDATE_INT);
					$m = 'SELECT s.id_zsh, s.id_user, z.nazvanie  FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = '.$e_id.' ORDER BY s.id_zsh';
					if($r = $db -> query($m)){
						$str .= " <p>Вражеский щит</p> ";
						for ($data = array(); $row = $r -> fetch_array(MYSQL_ASSOC); $data[] = $row) {
							$row['id_zsh'] = filter_var($row['id_zsh'], FILTER_SANITIZE_STRING); 
							$str .= "<p onmousedown = 'load1(".$row['id_zsh'].")'>".$row['nazvanie'].
							"</p>";	
							$i++;
						};
						// $str .= "</div>";
					};
					$r -> close();
					
				}
				else{
					// работаю
				$m = "INSERT INTO queue_vin SET
					id_fight = ?,
					id_vinner =?
				";
				$r = $db -> prepare($m);
				$r -> bind_param('ii', $_SESSION['id_fight'], $_SESSION['id']);
				$r -> execute();
				$r -> close();
				// определяем кто первый добил
				$id_vinner = 0;
				$m = "SELECT id_vinner FROM queue_vin WHERE id_fight = ? ORDER BY id";
				$r = $db -> prepare($m);
				$r -> bind_param('i', $_SESSION['id_fight']);
				$r -> execute();
				$r -> bind_result($id_vinner);
				$r -> fetch();
				$r -> close();
				// print_r($id_vinner);
					// echo "work - ".$_SESSION['id_fight']."id_vinner-".$id_vinner;
				if ($id_vinner == $_SESSION['id']) {
					// С победным ударом должны происх все драмматические изменения
					// считаем бои победителя и побеждённого
					// Можно усовершенствовать использовав функции
					$m = "SELECT vins, figthts FROM user_param WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('i', $_SESSION['id']);
					$r -> execute();
					$r -> bind_result($vins, $figthts);
					$r -> fetch();
					$r -> close();
					$vins++;
					$figthts++;

					$m = "UPDATE user_param SET 
					readiness = 0,
					figthts = ?,
					vins = ?
					WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('iii', $figthts, $vins, $_SESSION['id']);
					$r -> execute();
					$r -> close();

					// для врага
					$m = "SELECT figthts FROM user_param WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('i', $_SESSION['enemy']);
					$r -> execute();
					$r -> bind_result($figthts);
					$r -> fetch();
					$r -> close();
					$figthts++;

					$m = "UPDATE user_param SET 
					readiness = 0,
					figthts = ?
					WHERE id = ?";
					$r = $db -> prepare($m);
					$r -> bind_param('ii', $figthts, $_SESSION['enemy']);
					$r -> execute();
					$r -> close();
					// Завершение боя

					$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
					$r = $db -> prepare($m);
					$r -> bind_param('ii', $_SESSION['id'], $_SESSION['id_fight']);
					$r -> execute();
					$r -> close();
					ses_del();
					$message = "Вы победили!";

				}
				elseif ($id_vinner == -1) {
					die();
				};
				};

				
				// если удар победный делаем запись в очередь на победу и присваиваем победу сильнейшему
			};

		}
		else
		{
			$message = "Неверно";
		}

		// -------------

		$m = 'SELECT count FROM user_param WHERE id = '.$s_id;
		$r = $db -> query($m);

		$row = $r -> fetch_array(MYSQL_ASSOC);
		$_SESSION['count'] = $row['count'];
		$r -> close();
	// --------------------------------
	// считаем щиты противника

		$m = 'SELECT COUNT(*) FROM shield WHERE id_user = ?';
		$r2 = $db -> prepare($m);
		$r2 -> bind_param('i', $_SESSION['enemy']);
		$r2 -> execute();
		$r2 -> bind_result($c);
		$r2 -> fetch();
		$r2 -> close();
		$_SESSION['quantity_enemy'] = $c;


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
	// $str = "доделать";
	$quantity_enemy = 1;
	// $message = 0;
	echo json_encode(array("str" => $str, "quantity_enemy" => $quantity_enemy, "count" => $c_sh, "message" => $message ));
}
};
// ------------------------------------------------------------------
// Обработчик запросов на проверку огня противника
if (isset($_REQUEST['fire2'])) {
	if (isset($_SESSION['id_fight'])) {
		$_SESSION['t'] = $_SESSION['time_begin'] + $_SESSION['duration']*60 - time();
		// echo "work";
		if ($_SESSION['t'] < 0) {
			


			

			$m = "INSERT INTO queue_vin SET id_fight = ?, id_vinner = ?";
			$r = $db -> prepare($m);
			$vinner = -1;
			$r -> bind_param('ii', $_SESSION['id_fight'], $vinner);
			$r -> execute();
			$r -> close();
			$m = "SELECT id_vinner FROM queue_vin WHERE id_fight = ?";
			$r = $db -> prepare($m);
			$r -> bind_param('i', $_SESSION['id_fight']);
			$r -> execute();
			$r -> bind_result($id_vinner);
			$r -> fetch();
			$r -> close();
			

			if ($id_vinner !== -1) {
				
				
			
			$figthts = 0; $vins = 0;
			$s_id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
			$e_id = filter_var($_SESSION['enemy'], FILTER_VALIDATE_INT);
			$m = 'SELECT figthts, vins FROM user_param WHERE id = '.$s_id;

			$r = $db -> query($m);
			// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			$row = $r -> fetch_array(MYSQL_ASSOC);
			$r -> close();
			$figthts = $row['figthts'] + 1;
			$vins = $row['vins'];
			$m = 'UPDATE user_param SET figthts = '.$figthts.', vins = '.$vins.', readiness = 0 WHERE id = '.$s_id.' or id = '.$e_id;
			// echo $m;
			if($r = $db -> query($m)){
				// $r -> close();
			}
			else{
				die($db -> error());
			};
			// $r -> close();
			// mysql_qw($m, $figthts, $vins, $_SESSION['id']) or die(mysql_error());
			$m = 'SELECT figthts FROM user_param WHERE id = '.$e_id;
			$r = $db -> query($m);
			// $r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
			$row = $r -> fetch_array(MYSQL_ASSOC);
			$figthts = $row['figthts'] + 1;
			$m = 'UPDATE user_param SET figthts = ? WHERE id = ?';
			$r = $db -> prepare($m);
			$r -> bind_param('ii', $figthts, $_SESSION['enemy']);
			// mysql_qw($m, $figthts, $_SESSION['enemy']) or die(mysql_error());
			$r -> execute();
			$r -> close();

			$m = 'UPDATE fight SET status = 3, id_vin = ? WHERE id_fight = ?';
			$r = $db -> prepare($m);
			$t = -1;
			$r -> bind_param('ii', $t, $_SESSION['id_fight']);
			$r -> execute();
			$r -> close();
			// mysql_qw($m, -1, $_SESSION['id_fight']) or die(mysql_error());
			$_SESSION['result'] = "Ничья!";
			// $str ="<h1>Вы победили!!!</h1>";
			$_SESSION['id_fight'] = null;



			// ------------------------------

			$str = "Ничья";
			echo json_encode(array("str" => $str, "t" => $_SESSION['t']));
			};
		}
		else{


	
	// ------------------------------
	// считаем свои щиты
	$m = 'SELECT COUNT(*) FROM shield WHERE id_user = '.$_SESSION['id'];
	$r = $db -> query($m);
	// $r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['id']) or die(mysql_error());
	$row2 = $r -> fetch_array(MYSQL_ASSOC);
	$_SESSION['quantity'] = $row2['COUNT(*)'];
	$r -> close();


	$m = 'SELECT * FROM fire WHERE id_jertvi = '.$_SESSION['id'].' and ot = 0';
	$r = $db -> query($m);
	// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
	$row = $r -> fetch_array(MYSQL_ASSOC);
	$r -> close();
	if (isset($row['ot'])) {
		if ($row['ot'] == 0) {
			
			$m = 'UPDATE fire SET ot = 1 WHERE id_jertvi = ?';
			$r = $db -> prepare($m);
			$r -> bind_param('i', $_SESSION['id']);
			$r -> execute();
			// $row = $r -> fetch_array(MYSQL_ASSOC);
			$r -> close();
			// mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			if ($row['rez'] == 1) {
				// Проверка опыта врага
				$m = 'SELECT count FROM user_param WHERE id = '.$_SESSION['enemy'];
				$r = $db -> query($m);
				$row = $r -> fetch_array(MYSQL_ASSOC);
				$r -> close();
				// $r = mysql_qw($m, $_SESSION['enemy']) or die(mysql_error());
				// $row = mysql_fetch_assoc($r);
				$_SESSION['enemy_count'] = $row['count'];
				// -----------------------------------------------------
				$str = 'Ваш щит';
				// $m = 'SELECT * FROM shield WHERE id_user = '.$_SESSION['id'];
				$m = 'SELECT z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = '.$_SESSION['id'];
				$r = $db -> query($m);
				// $r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
				$j = 0;
				for ($data2 = array(); $row2 = $r -> fetch_array(MYSQL_ASSOC) ; $data2[] = $row2) { 
					$str = $str."<p>".$row2['nazvanie']."</p>";
					$j++;
				};
				$r -> close();
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
	// $r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['id']) or die(mysql_error());
	$s_id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
	$m = 'SELECT COUNT(*) FROM shield WHERE id_user = '.$s_id;
	$r = $db -> query($m);
	$row2 = $r -> fetch_array(MYSQL_ASSOC);
	$_SESSION['quantity'] = $row2['COUNT(*)'];


	// $r2 = mysql_qw('SELECT COUNT(*) FROM shield WHERE id_user = ?', $_SESSION['enemy']) or die(mysql_error());
	// $r2 = $db -> prepare('SELECT COUNT(*) FROM shield WHERE id_user = ?');
	// $r2 -> bind_param('i', $_SESSION['enemy']);
	// $r2 -> execute();
	// $r2 -> bind_result($count);
	// $row2 = mysql_fetch_assoc($r2);
	$m =
	$_SESSION['quantity_enemy'] = $row2['COUNT(*)'];
	echo json_encode(array("quantity" => $_SESSION['quantity'], "quantity_enemy" => $_SESSION['quantity_enemy']));
}
// Обработчики для game_js.js
if (isset($_REQUEST['show_z'])) {
	$show_z = $db->prepare("SELECT nazvanie, soderjanie, otvet, img FROM zadania WHERE id = ?");
	$show_z->bind_param('i', $_REQUEST['show_z']);
	$show_z->execute();
	$show_z->bind_result($nazvanie, $soderjanie, $otvet, $img);
	$show_z->fetch();
	// echo $nazvanie."<br>".$soderjanie;
	$m1 = "<p>Задание: ".$nazvanie."</p><p>".$soderjanie."</p>";
	$m3 = "<p><img src = 'imag/".$img."'></p><p>Ответ: ".$otvet."</p>";
	$m = $m1.$m3;
	echo $m;





	$show_z->close();

	// $m = 'SELECT soderjanie FROM zadania WHERE id = ?';
	// $r = mysql_qw($m, $_REQUEST['show_z']) or die(mysql_errno());
	// $row = mysql_fetch_assoc($r);
	// echo $row['soderjanie'];
};
if (isset($_REQUEST['del_z'])) {
	$readiness = 0;
	// Удаляем задания из щита
	$proverka2 = $db->prepare('SELECT readiness FROM user_param WHERE id = ?');
	$proverka2->bind_param('i', $_SESSION['id']);
	$proverka2->execute();
	$proverka2->bind_result($readiness);
	$proverka2->fetch();
			
	if ($readiness === 0) {
		$proverka2->close();
		$del = $db->prepare("DELETE FROM shield WHERE id_user = ? and id_zsh = ?");
		$del->bind_param('ii', $_SESSION['id'], $_REQUEST['del_z']);
		$del->execute();
		$del->close();
	}else{
		$proverka2->close();
	};
 
	$del2 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ?");
	$del2->bind_param('is', $_SESSION['id'], $_SESSION['razdel']);
	$del2->execute();
	$del2->bind_result($id_zsh, $nazvanie_zsh);
	$m = '';
	$i = 1;
	while ($del2->fetch()) {
		$m = $m."<div id = 'sh_p".$i."'><span class = 'my_sh' onclick = show_z(".$id_zsh.")>".$nazvanie_zsh." </span><span class = 'my_sh' onclick = del_z(".$id_zsh.")>-</span></div>";
		$i++;
	};
	$del2->close();

// додедать
	$tip = filter_var($_REQUEST['del_z2'], FILTER_SANITIZE_SPECIAL_CHARS);
	switch ($tip) {
		case 'accordeon1':
			$tip = 'Числа_и_вычисления';
			break;
		case 'accordeon2':
			$tip = 'Алгебраические_выражения';
			break;
		case 'accordeon3':
			$tip = 'Уравнения_и_неравенства';
			break;
		case 'accordeon4':
			$tip = 'Числовые_последовательности';
			break;
		case 'accordeon5':
			$tip = 'Функции';
			break;
		case 'accordeon6':
			$tip = 'Координаты_на_прямой_и_плоскости';
			break;
		case 'accordeon7':
			$tip = 'Геометрия';
			break;
		case 'accordeon8':
			$tip = 'Статистика_и_теория_вероятности';
			break;		
		default:
			die();
			break;
	};
	// Обновление списка list2
	// исправлять
	$r = $db->prepare('SELECT a.id_rz, z.nazvanie FROM arsenal a INNER JOIN zadania z ON a.id_rz = z.id WHERE a.id_user = ? and z.tip = ?');
	// типы в разных разделах не должны совпадать
	$r->bind_param('is', $_SESSION['id'], $tip);
	$r->execute();
	$r->bind_result($id_rz, $nazvanie);
	$i = 0;
	$a = array();
	while ($r->fetch()) {

		$a[$i]['id_rz'] = $id_rz;
		$a[$i]['nazvanie'] = $nazvanie;
		$a[$i]['metka'] = 0;
		$i++;
	};
	$r->close();
	$r2 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ?");
	$r2-> bind_param("i", $_SESSION['id']);
	$r2->execute();
	$r2->bind_result($id_zsh, $nazvanie_zsh);
	while ($r2->fetch()) {
		foreach ($a as $key => $value) {
			if ($value['id_rz'] == $id_zsh) {
				$a[$key]['metka'] = 1;
			}
		}
	};
	$m2 = '';
	foreach ($a as $key => $value) {
		if (!$value['metka']) {
			$m2 = $m2."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
			".$value['nazvanie']."</span><span onmousedown = add(".$value['id_rz'].")> +</span></p>";
		}
		else{
			$m2 = $m2."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
		".$value['nazvanie']."</span></p>";
		}
	};
	$r2->close();

	// 
	echo json_encode(array("shield"=>$m, "arsenal"=>$m2, "razdel"=>$_SESSION["razdel"]));


};

// Добавление задач в щит
if (isset($_REQUEST['add'])) {
	$count = 0; 
	$proverka = $db->prepare("SELECT readiness FROM user_param  WHERE id = ?");
	$proverka->bind_param('i', $_SESSION['id']);
	$proverka->execute();
	$proverka->bind_result($readiness);
	$proverka->fetch();
	if ($readiness === 0) {
		$proverka->close();
	

		$shield1 = $db->prepare("SELECT COUNT(*) FROM shield WHERE id_user = ? and id_zsh = ?");
		$shield1->bind_param('ii', $_SESSION['id'], $_REQUEST['add']);
		$shield1->execute();
		$shield1->bind_result($count);
		$shield1->fetch();
		$shield1->close();
	};
	if ($count == 0) {// Проверяем есть ли в списке щита задача
		// переделать в сложный запрос к бд
		$shield2 = $db->prepare("SELECT a.id_user, a.id_rz, z.nazvanie, z.razdel  FROM arsenal a INNER JOIN zadania z ON a.id_rz = z.id WHERE (a.id_user = ? and a.id_rz = ?) and z.razdel = ?");
		$shield2->bind_param('iii', $_SESSION['id'], $_REQUEST['add'], $_SESSION['razdel']);
		$shield2->execute();
		$shield2->bind_result($id_user,  $id_rz, $nazvanie, $razdel);
		$count = 0;
		while ($shield2->fetch()) {
			$count++;
			// echo "<p>".$nazvanie."</p>";
		};
		if ($count) {
			$shield2->close();
			$shield3 = $db->prepare("INSERT INTO shield (id_zsh, id_user)
				VALUES(?, ?)
				");
			$shield3->bind_param('ii', $id_rz, $id_user);
			$shield3->execute();
			$shield3->close();
			$shield4 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ? ORDER BY s.id_zsh");
			$shield4->bind_param('is', $_SESSION['id'], $_SESSION['razdel']);
			$shield4->execute();
			$shield4->bind_result($id_rz, $nazvanie);
			$m = "";
			$i = 1;
			while ($shield4->fetch()) {
				$m = $m."<div id = 'sh_p".$i."'><span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie." </span><span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span></div>";
				$i++;
			};
			// echo $m;
			$shield4->close();

		}
		else{
			$shield4 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ? ORDER BY s.id_zsh");
			$shield4->bind_param('ii', $_SESSION['id'], $_SESSION['razdel']);
			$shield4->execute();
			$shield4->bind_result($id_rz, $nazvanie);
			$m = "";
			$i = 1;
			while ($shield4->fetch()) {
				$m = $m."<div id = 'sh_p".$i."'><span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie." </span><span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span></div>";
				$i++;
			};
			$shield4->close();
		}
		
	}
	else{
		$shield1->close();
		$shield4 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ? ORDER BY s.id_zsh");
		$shield4->bind_param('ii', $_SESSION['id'], $_SESSION['razdel']);
		$shield4->execute();
		$shield4->bind_result($id_rz, $nazvanie);
		$m = "";
		$i = 1;
		while ($shield4->fetch()) {
			$m = $m."<div id = 'sh_p".$i."'><span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie." </span><span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span></div>";
			$i++;
		};
		$shield4->close();
	};
	// переделать в сложный запрос к бд
	$tip = filter_var($_REQUEST['add2'], FILTER_SANITIZE_SPECIAL_CHARS);
	switch ($tip) {
		case 'accordeon1':
			$tip = 'Числа_и_вычисления';
			break;
		case 'accordeon2':
			$tip = 'Алгебраические_выражения';
			break;
		case 'accordeon3':
			$tip = 'Уравнения_и_неравенства';
			break;
		case 'accordeon4':
			$tip = 'Числовые_последовательности';
			break;
		case 'accordeon5':
			$tip = 'Функции';
			break;
		case 'accordeon6':
			$tip = 'Координаты_на_прямой_и_плоскости';
			break;
		case 'accordeon7':
			$tip = 'Геометрия';
			break;
		case 'accordeon8':
			$tip = 'Статистика_и_теория_вероятности';
			break;		
		default:
			die();
			break;
	};

	$r = $db->prepare("SELECT a.id_rz, z.nazvanie FROM arsenal a INNER JOIN zadania z ON a.id_rz = z.id WHERE a.id_user = ? and z.tip = ? ORDER BY a.id_rz");
	$r->bind_param('is', $_SESSION['id'], $tip);
	$r->execute();
	$r->bind_result($id_rz, $nazvanie);
	$i = 0;
	$a = array();
	while ($r->fetch()) {

		$a[$i]['id_rz'] = $id_rz;
		$a[$i]['nazvanie'] = $nazvanie;
		$a[$i]['metka'] = 0;
		$i++;
	};
	$r->close();
	$r2 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ?");
	$r2-> bind_param("is", $_SESSION['id'], $_SESSION['razdel']);
	$r2->execute();
	$r2->bind_result($id_zsh, $nazvanie_zsh);
	while ($r2->fetch()) {
		foreach ($a as $key => $value) {
			if ($value['id_rz'] == $id_zsh) {
				$a[$key]['metka'] = 1;
			}
		}
	};
	$m2 = '';
	foreach ($a as $key => $value) {
		if (!$value['metka']) {
			$m2 = $m2."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
			".$value['nazvanie']."</span><span onmousedown = add(".$value['id_rz'].")> +</span></p>";
		}
		else{
			$m2 = $m2."<p class = 'my_sh' ><span onmousedown = show_z(".$value['id_rz'].")>
		".$value['nazvanie']."</span></p>";
		}
	};
	$r2->close();
	echo json_encode(array("shield"=>$m, "arsenal"=>$m2, "razdel"=>$_SESSION['razdel']));

};

// исправляем отсюа
if (isset($_REQUEST['ready_f'])) {
	

if ($_REQUEST['ready_f'] == 1) {
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
	echo "
				
			<span class = 'my_sh' onmousedown = ready_f(0)> Не готов</span>
		
		";	
		// print_r($_REQUEST['ready_f']);
	$m = "SELECT readiness FROM user_param WHERE id = ?";
	$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
	$row = mysql_fetch_assoc($r);
	$_SESSION['readiness'] = $row['readiness'];

}
elseif($_REQUEST['ready_f'] == 0){
	$m = "UPDATE user_param SET readiness = 0 WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		echo "
		
			
			<span class = 'my_sh' onmousedown = ready_f(1)> Готов</span>
		
		";
		// print_r($_REQUEST['ready_f']);
		$m = "SELECT readiness FROM user_param WHERE id = ?";
		$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
		$row = mysql_fetch_assoc($r);
		$_SESSION['readiness'] = $row['readiness'];
};
};



if (isset($_REQUEST['show_nz'])) {
	// Считаем число попыток решить данную задачу данным пользователем
	$vremya = time() - 82800;
	$r = $db -> prepare('SELECT COUNT(*) FROM attempt_baza WHERE 
		(id_user = ? and id_zadachi = ?) and vremya > ?
		');
	$r -> bind_param('iii', $_SESSION['id'], $_REQUEST['show_nz'], $vremya);
	$r -> execute();
	$r -> bind_result($c_attempt);
	$r -> fetch();
	$r -> close();	
	// --------------------------------
	$zadania = $db->prepare("SELECT id, nazvanie, soderjanie, img, ogranichenie FROM zadania WHERE id = ?");
	$zadania->bind_param('i', $_REQUEST['show_nz']);
	$zadania->execute();
	$zadania->bind_result($id, $nazvanie, $soderjanie, $img, $ogranichenie);
	$zadania->fetch();
	$ostatok = $ogranichenie - $c_attempt;
	if ($ostatok > 0) {
		$ostatok_str = ' (Осталось '.$ostatok.' попыток)';
	}
	else{
		// $t = getdate($ostatok);
		$ostatok_str = ' (Временно недоступно)';
	};
	$show_nz = filter_var($_REQUEST['show_nz'], FILTER_VALIDATE_INT);
	$mist = "<ins class = 'mist' id = '".$show_nz."'>Сообщить об ошибке</ins>";
	$m1 = "<p>Задание: ".$nazvanie.$ostatok_str.$mist."</p><p>".$soderjanie."</p>";
	$m2 = "
		<input type = 'text' id = 'check_nr'><br>
		<input type = 'hidden' id = 'nomer_z' value = '".$id."'>
		
		<input type = 'button' onclick = check_nr() value='Ответить'><br>
	";
	$m3 = "<p><img src = 'imag/".$img."'></p>";
	$m = $m1.$m2.$m3;
	// echo $m;
	echo json_encode(array("m"=> $m));
}

// -----------------------------------
// обработка ответа к задаче из базы

if (isset($_REQUEST['nomer_z']) and isset($_REQUEST['check_nr'])) {
	// Ограничить id доступных заданий

 	// Считаем количество попыток решить данную задачу 
		$nomer_z = filter_var($_REQUEST['nomer_z'], FILTER_VALIDATE_INT);
		
	 	$vremya = time() - 82800;
	 	$r = $db -> prepare('SELECT COUNT(*) FROM attempt_baza WHERE 
			(id_user = ? and id_zadachi = ?) and vremya > ?
			');
	 	$r -> bind_param('iii', $_SESSION['id'], $nomer_z, $vremya);
	 	$r -> execute();
	 	$r -> bind_result($c_attempt);
	 	$r -> fetch();
	 	$r -> close();	
	 	
 	$check_nr = trim($_REQUEST['check_nr']);
 	// $nomer_z = trim($_REQUEST['nomer_z']);
 	$vremya = time();
 	$r = $db -> prepare('INSERT INTO attempt_baza SET
			id_user = ?, id_zadachi = ?, vremya = ?
 		');
 	
 	$r -> bind_param('iii', $_SESSION['id'], $nomer_z, $vremya);
 	$r -> execute();
 	$r -> close();
 	// считаем сколько свежих попыток
 	$r = $db -> prepare('SELECT ogranichenie FROM zadania WHERE id = ?');
 	$r -> bind_param('i', $nomer_z);
 	$r -> execute();
 	$r -> bind_result($ogranichenie);
 	$r -> fetch();
 	$r -> close();

 	$ostatok = $ogranichenie - $c_attempt;
 	$message2 = $ostatok;
 	if ($ostatok < 1) {
 		$message = "Доступные попытки завершились ожидайте их восстановления.".$ogranichenie."-".$c_attempt;
 		die(json_encode(array("message" => $message, "message2" => $message2)));

 	};
 	// --------------------------------------

 	$proverka = $db->prepare("SELECT id_rz FROM arsenal WHERE id_rz = ? and id_user = ?");
 	$proverka->bind_param('ii', $nomer_z, $_SESSION['id']);
 	$proverka->execute();
 	$i = 0;
 	while ($proverka->fetch()) {
 		$i++;
 	};
 	$proverka->close();

// echo $check_nr." ".$nomer_z;
 	if ($i == 0) {
 		// echo "string2";
 		$otvet = $db->prepare("SELECT id, nazvanie FROM zadania WHERE id = ? and otvet = ?");
 		$otvet->bind_param('is', $nomer_z, $check_nr);
 		$otvet->execute();
 		$otvet->bind_result($id_rz, $nazvanie);
 		
 		$i = 0;
 		while ($otvet->fetch()) {
 			$i++;
 		};
 		$id_rz = trim($id_rz);
 		
 		if ($i == 1) {
 			

 			$id = $_SESSION['id'];
 			
 			
 			$insert_o = $db->prepare("INSERT INTO arsenal (id_user, id_rz)
 				VALUES (?, ?)
 				");
 			$insert_o->bind_param('ii', $id, $id_rz);
 			$insert_o-> execute();
 			$message = "<p>Поздравляем!!!</p><p>Задание ".$nazvanie." решено верно и добавлено в арсенал!</p>";
 			echo json_encode(array("message" => $message));
 		}
 		else{
 			$message = "<p>Неверно</p>";
 			echo json_encode(array("message" => $message, "message2" => $message2));
 			
 		}
 	}
	
	
	// echo "<pre>";
	// // print_r($otvet);
	// echo $id_rz." ".$nazvanie." ".$tip;
	
	// echo "</pre>";
	


 };
// ---------------------------------
 //Обработчики для arena.php
 if (isset($_REQUEST['razdel'])) {
 	if ($_REQUEST['razdel'] == "oge") {
 		$_SESSION['razdel'] = $_REQUEST['razdel'];	
 	}
 	elseif ($_REQUEST['razdel'] == "ege") {
 		$_SESSION['razdel'] = $_REQUEST['razdel'];
 	}
 	elseif ($_REQUEST['razdel'] == "sh_f") {
 		$_SESSION['razdel'] = $_REQUEST['razdel'];
 	}
 	elseif ($_REQUEST['razdel'] == "U_f") {
 		$_SESSION['razdel'] = $_REQUEST['razdel'];
 	}
 	else{
 		die();
 	};
 	$r = $db->prepare("UPDATE user_param SET razdel = ? WHERE id = ?");
 	$r->bind_param('si', $_SESSION['razdel'], $_SESSION['id']);
 	$r->execute();
 	$r->close();
 	$color = "#FA8072";
 	echo json_encode(array("color" => $color, "razdel" => $_SESSION['razdel']));
 };
 if (isset($_REQUEST['new_f'])) {
 	// Ограничиваем количество приглашений
 	$m = "SELECT COUNT(*) FROM fight WHERE id_priglos = ? and status = 0";
 	$r = $db -> prepare($m);
 	$r -> bind_param('i', $_SESSION['id']);
 	$r -> execute();
 	$r -> bind_result($count);
 	$r -> fetch();
 	$r -> close();
 	if ($count > 0) {
 		die();
 	};

 	// -------------------------------------
 	$r = $db->prepare("SELECT readiness, nik FROM user_param WHERE id = ?");
 	$r->bind_param('i', $_SESSION['id']);
 	$r->execute();
 	$r->bind_result($readiness, $nik);
 	$r->fetch();
 	$r->close();
 	// echo $id;
 	$r4 = $db->prepare("SELECT s.id_user FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ?");
 	$r4->bind_param('is',$_SESSION['id'], $_SESSION['razdel']);
 	$r4->execute();
 	$r4->bind_result($id2);
 	$r4->fetch();
 	$r4->close();
 	echo " ".$id2;
 	// echo "string";
 	if (($readiness === 0) and ($id2 !== null)) {

 			$r2 = $db->prepare("UPDATE user_param SET readiness = 1 WHERE id = ?");
 			$r2->bind_param('i', $_SESSION['id']);
 			$r2->execute();
 			$r2->close();// Можно улучшить присылая отчёт об успешном создании игры чтоб на время ваша созданная игра подсвечивалась на фоне других
 			$r3 = $db->prepare("INSERT INTO fight (nik, id_priglos, duration, razdel) VALUES(?, ?, ?, ?)");
 			$r3->bind_param('siis', $nik, $_SESSION['id'], $_REQUEST['new_f'], $_SESSION['razdel']);
 			$r3->execute();
 			$r3->close();


 	}
 	elseif(($id2 !== null) and ($readiness == 1)){

 		echo "В бою!";
 	}
 	else{
 		echo "Щит пуст!";
 	}



 	

 };
 // Принятие боя не автор

 if (isset($_REQUEST['go_f'])) {
 	if ($_REQUEST['go_f'] == $_SESSION['id']) {
 	echo "hi";
 		$del = $db->prepare("DELETE FROM fight WHERE id_priglos = ? and (status <> 1 and status <> 3)");
 		$del -> bind_param('i', $_SESSION['id']);
 		$del -> execute();
 		$del -> close();
 		$s = $db->prepare("UPDATE user_param SET readiness = 0 WHERE id = ?");
 		$s -> bind_param('i', $_SESSION['id']);
 		$s -> execute();
 		$s -> close();
 		die();
 	};
 	$s = $db->prepare("SELECT readiness, razdel FROM user_param WHERE id = ?");
 	$s->bind_param('i', $_REQUEST['go_f']);
 	$s->execute();
 	$s->bind_result($readiness_v, $razdel_v);
 	$s->fetch();
 	$s->close();

 	$r = $db->prepare("SELECT readiness, nik FROM user_param WHERE id = ?");
 	$r->bind_param('i', $_SESSION['id']);
 	$r->execute();
 	$r->bind_result($readiness, $nik);
 	$r->fetch();
 	$r->close();

 	$r4 = $db->prepare("SELECT s.id_user FROM shield s INNER JOIN zadania z ON s.id_zsh = z.id WHERE s.id_user = ? and z.razdel = ?");
 	$r4->bind_param('is',$_SESSION['id'], $razdel_v); //проверка  на наличие в щите задач нужного типа
 	$r4->execute();
 	$r4->bind_result($id2);
 	$r4->fetch();
 	$r4->close();
 	if ((($readiness === 0) and ($id2 !== null)) and ($readiness_v ===1)) {
 			// $r2 = $db->prepare("UPDATE user_param SET readiness = 1 WHERE id = ?");
 			// $r2->bind_param('i', $_SESSION['id']);
 			// $r2->execute();
 			// $r2->close();
 			// Можно улучшить присылая отчёт об успешном создании игры чтоб на время ваша созданная игра подсвечивалась на фоне других
 			$r3 = $db->prepare("INSERT INTO fight (nik, id_priglos, id_prigloshaemogo, razdel, status) VALUES(?, ?, ?, ?, ?)");
 			$status = 2;
 			$r3->bind_param('siisi', $nik, $_REQUEST['go_f'], $_SESSION['id'], $razdel_v, $status);



 			// $r3 = $db->prepare("INSERT INTO fight (nik, id_priglos, duration, razdel) VALUES(?, ?, ?, ?)");
 			// $r3->bind_param('siis', $nik, $_SESSION['id'], $_REQUEST['new_f'], $_SESSION['razdel']);
 			$r3->execute();
 			$r3->close();
 			echo " ".$nik." ".$_SESSION['id']." ".$_REQUEST['go_f']." ".$_SESSION['razdel'];

 	}
 }
 // ---------------------

 //---------------------------------
 // Фоновая функция для проверки ситуации в игре
 if (isset($_REQUEST['fon_js'])) {
 	$i = 12;
 	echo json_encode(array("i" => $i));
 };
 // -------------------------------
 // функция для переключения страниц
 if (isset($_REQUEST['listanie'])) {
 	// print_r($_SESSION['tip_nz']);
 	$multipl = 12;
 	
 	// Считаем сколько страниц
 	$r = $db -> prepare('SELECT COUNT(*) FROM zadania WHERE tip = ?');
 	$r -> bind_param('s', $_SESSION['tip_nz']);
 	$r -> execute();
 	$r -> bind_result($c_tip);
 	$r -> fetch();
 	$r -> close();
 	$mod = $c_tip % 12;
 	$div = floor($c_tip/$multipl);
 	if ($mod>0) {
 		$div++;
 	};



 	// ----------------------
 	$l = filter_var($_REQUEST['listanie'], FILTER_SANITIZE_SPECIAL_CHARS);
 	if (($l === 'left_list') and ($_SESSION['stranica'] == 1)) {
 		$_SESSION['stranica'] = 1;
 	}
 	elseif (($l === 'left_list') and ($_SESSION['stranica'] > 1)) {
 		$_SESSION['stranica']--;
 	}
 	elseif (($l == 'rightwards_list') and ($div == $_SESSION['stranica'])) {
 	}
 	elseif (($l == 'rightwards_list') and ($div > $_SESSION['stranica'])) {
 		$_SESSION['stranica']++;
 	};
 	$sup = $multipl*$_SESSION['stranica'];
 	$inf = $sup - $multipl;
 	$sup--;
 	// echo "inf=".$inf." sup=".$sup;
 	// помещаем все задания в массив
 	$a = array();
 	$r = $db -> prepare('SELECT id_rz FROM arsenal WHERE id_user = ?');
 	$r -> bind_param('i', $_SESSION['id']);
 	$r -> execute();
 	$r -> bind_result($id_rz);
 	while ($r -> fetch()) {
 		$a[] = $id_rz;
 	};
 	$r -> close();

 	$r = $db -> prepare('SELECT id, nazvanie FROM zadania WHERE tip = ? and razdel = ? ORDER BY id');
 	$r -> bind_param('ss', $_SESSION['tip_nz'], $_SESSION['razdel']);
 	$r -> execute();
 	$r -> bind_result($id, $nazvanie);
 	$m = '';
 	$i = 0;
 	while ($r -> fetch()) {
 		$datchik = array_search($id, $a);
 		if ($datchik === false) {
 			if (($i >= $inf) and ($i<=$sup)) {
 				$m = $m."<p class = my_sh onmousedown = show_nz(".$id.")>".$nazvanie."</p>";
 			};
 			$i++;
 		}
 	};
 	$m = "<div id = 'pole_zadanii_cont'>".$m."</div><div class = 'listanie' id = 'left_list'></div><div id = 'stranica'><p id = 'str'>".$_SESSION['stranica']."</p></div><div class = 'listanie' id = 'rightwards_list'></div>";
 	echo json_encode(array("m" => $m, "str" => $_SESSION['stranica']));
 	// echo $m;
 	// -------------------------------
 };
 // --------------------------
 
?>