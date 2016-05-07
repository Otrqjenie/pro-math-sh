<?php
require_once "connect2.php";
require_once "lib/request.php";
header("Content-Type: text/html; charset=utf-8");
session_start();
$t = 'arsenal';

// $m = 'SELECT * FROM zadania';
// $r = mysql_qw($m) or die(mysql_error());
// for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row) { 
// 	// echo $row['tip']."</br>";
// 	$m2 = 'UPDATE arsenal SET tip = ? WHERE id_rz = ?';
// 	mysql_qw($m2, $row['tip'], $row['id']) or die(mysql_error());
// }

if(isset($_REQUEST['go'])){// id INT AUTO_INCREMENT PRIMARY KEY,
	$m = "CREATE TABLE IF NOT EXISTS ".$t." (
		id_user INT,
		id_rz INT,
		nazvanie TEXT,
		tip TEXT
		)";
	//mysql_qw($m);

	mysql_qw($m) or die(mysql_error());
	if (isset($_SESSION['buffer'])) {
	$in = $_SESSION['buffer'];
	foreach ($in as $key => $value) {
		
		$m = 'INSERT INTO '.$t.' SET';
		$i = 0;
		foreach($value as $k =>$v){
			if (!isset($v)) {
				$v = 0;
			}
			if ($i == 0) {
				$m = $m." ".$k." = '".$v."' ";
			}
			else {
				$m = $m.", ".$k." = '".$v."' ";
			};
			$i++;
		};
		// echo "<p>".$m."</p>";
		mysql_qw($m) or die(mysql_error());
	}
	}
	
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
	exit();
}
elseif (isset($_REQUEST['go2'])) {
	if (isset($_REQUEST['save'])) {
		
		$m = 'SELECT * FROM '.$t;
		$r = mysql_qw($m) or die(mysql_error());
		for ($data = array(); $row = mysql_fetch_assoc($r) ; $data[] = $row);
		$_SESSION['buffer'] = $data;
	};
	$m = 'DROP TABLE '.$t;
	mysql_qw($m);
	Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
	exit();
}
else{
	//Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
	//exit();
};
//print_r($_SESSION['buffer']);
?>
<form action = "<?=$_SERVER['SCRIPT_NAME']?>">
	<input type = "submit" name = "go"></br>
	<input type = "checkbox" name = "save">
	<input type = "submit" name = "go2" value = "Удалить">
</form>