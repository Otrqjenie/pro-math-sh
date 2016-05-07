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
    $m = "UPDATE user_param SET activity = ".time()." WHERE id = ?".
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
};
if (isset($_REQUEST['go'])) {
	
	$m = 'SELECT COUNT(*) FROM fight WHERE id_priglos = ? and status = 1';
	$r = mysql_qw($m, $_SESSION['id']);
	$row = mysql_fetch_assoc($r);
	if ($row['COUNT(*)'] > 0) {
		Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  		exit();
	};
	$m = "INSERT INTO fight SET 
		id_priglos = ?,
		id_prigloshaemogo = ?,
		status = ?,
		duration = ?
	";
	$id_priglos = $_SESSION['id'];
	$id_prigloshaemogo = $_SESSION['fighter'];
	// echo "id_prigloshaemogo = ".$id_prigloshaemogo;
	$status = 1;//1 приглашение, 2 бой, 3 окончен
	$duration = $_REQUEST['duration']*60;
	mysql_qw($m, $id_priglos, $id_prigloshaemogo, $status, $duration) or die(mysql_error());
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
  	exit();
}
	//Обновление активности
	$m = "UPDATE user_param SET activity = ".time()." WHERE id = ?";
	mysql_qw($m, $_SESSION['id']) or die(mysql_error());
?>
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td><a href = "game_js.php">Моя страница</a></td>
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
		<td><?=$_SESSION['imya']?>&nbsp;<?=$_SESSION['familiya']?></td>
	</tr>
	<tr>
		<td width = "30%" valign = "top">
			<p>Щит</p>
			<p>
				<?
					$m = 'SELECT * FROM shield WHERE id_user = ? ORDER BY id_zsh';
					$r = mysql_qw($m, $_SESSION['id']) or die(mysql_error());
					for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
					echo "<p><a href = ".$_SESSION['SCRIPT_NAME']."?shield=".$row['id_zsh'].">".$row['nazvanie_zsh']."</a></p>";	
					};

				?>
			</p>

			<p>Арсенал</p>
			<p>
				<?
					$m = 'SELECT * FROM arsenal WHERE id_user = ? ORDER BY id_rz';
					$r = mysql_qw($m, $_SESSION['id']);
					for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
					echo "<p><a href = ".$_SESSION['SCRIPT_NAME']."?shield=".$row['id_rz'].">".$row['nazvanie']."</p>";	
					};
				?>
			</p>
		</td>
		<td width = "40%" valign = "top" >
			<?
				if (isset($_REQUEST['fighter'])) {
					$m = 'SELECT COUNT(*) FROM user_param WHERE readiness = 1';
					$r = mysql_qw($m, $_REQUEST['fighter']) or die(mysql_error());
					$row = mysql_fetch_assoc($r);
					if ($row['COUNT(*)'] > 0) {
						$_SESSION['fighter'] = $_REQUEST['fighter'];
						$str1 = "Выберите продолжительность боя</br>";
						$str = "
							<form action = ".$_SERVER['SCRIPT_NAME'].">
								<select name = 'duration'>
									<option>10
									<option>20
									<option>30
									<option>45
									<option>120
								</select></br>
								<input type = 'submit' name = 'go'>
							</form>

						";
						echo $str1.$str;
					}
					else{
						Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
						exit();
					};

					
				}
				else {
					$t = time()-90000;
					$m = 'SELECT user.imya, user.familiya, user_param.activity, user.id FROM user, user_param WHERE user_param.activity > '.$t.' and
					 user_param.readiness = 1 and user.id = user_param.id';
					$r = mysql_qw($m) or die(mysql_error());
					for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
						$m2 = 'SELECT COUNT(*) FROM shield WHERE id_user = ?';
						$r2 = mysql_qw($m2, $row['id']) or die(mysql_error());
						$row2 = mysql_fetch_assoc($r2);
						$str1 = "Время активности &nbsp;".$row['imya']."&nbsp;".date("H:i:s", $row['activity'])." &nbsp; Щитов = ".$row2['COUNT(*)']."
						<a href = ".$_SERVER['SCRIPT_NAME']."?fighter=".$row['id'].">Вызвать на бой</a></br>";

						$str2 = "Время активности &nbsp;".$row['imya']."&nbsp;".date("H:i:s", $row['activity'])." &nbsp; Щитов = ".$row2['COUNT(*)']."</br>";
						$str = ($row['id'] == $_SESSION['id'])?($str2):($str1);
						echo $str;
					};

				};
				
			?>
		<td width = "30%" valign = "top">
			<p>Список задач</p>
			<?
			$m = 'SELECT * FROM zadania';
			$r = mysql_qw($m) or die(mysql_error());
			for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row) { 
				echo "<a href =".$_SERVER['SCRIPT_NAME']."?id_z=".$row['id'].">".$row['nazvanie']."</a></br>";
			};
			?>
		</td>
	</tr>
</table>
</div>