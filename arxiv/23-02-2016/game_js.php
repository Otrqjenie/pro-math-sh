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
	$shield = $_REQUEST['shield'];
	$m = 'SELECT COUNT(*) FROM shield WHERE id_user = ? and id_zsh = ?';
	$r = mysql_qw($m, $_SESSION['id'], $shield);
	$row = mysql_fetch_assoc($r);
	if ($row['COUNT(*)'] > 0) {
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
<div align  = "center">
<table width = "1200" border  = "1">
	<tr>
		<td>Моя страница</td>
		<td><a href="game_js_online.php">Игроки онлайн</a></td>
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
					echo "<p><a href = ".$_SERVER['SCRIPT_NAME']."?shield=".$row['id_zsh']."&nazvanie_zsh=".$row['nazvanie_zsh'].">".$row['nazvanie_zsh'].
					"</a><a href = ".$_SERVER['SCRIPT_NAME']."?del=".$row['id_zsh'].">(удалить)</a></p>";	
					};

				?>
			</p>

			<p>Арсенал</p>
			<p>
				<?
					$m = 'SELECT * FROM arsenal WHERE id_user = ? ORDER BY id_rz';
					$r = mysql_qw($m, $_SESSION['id']);
					for ($data = array(); $row = mysql_fetch_assoc($r); $data[] = $row) { 
						echo "<p><a href = ".$_SESSION['SCRIPT_NAME']."?shield=".$row['id_rz'].">".$row['nazvanie']."</a></p>";	
					};
				?>
			</p>
		</td>
		<td width = "40%" valign = "top" >
			Текст задачи</br>
			<?
			if (isset($_REQUEST['id_z'])) {
				
				 
				$_SESSION['id_z'] = $_GET['id_z'];
			};
			$m = 'SELECT nazvanie FROM zadania WHERE id = ?';
			$r = mysql_qw('SELECT * FROM zadania WHERE id = ?', $_SESSION['id_z']) or die(mysql_error());
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
			else {echo "Выберите задание в правой колонке.";};
			$m = "UPDATE user SET activity = ".time()." WHERE id = ?";
			mysql_qw($m, $_SESSION['id']) or die(mysql_error());
			?>
		</td>
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