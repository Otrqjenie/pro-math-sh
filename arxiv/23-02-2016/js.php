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
				$_SESSION['result'] = "Вы проиграли!";
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
		}ж
?>