<?php
require_once "connect2.php";
require_once "lib/request.php";
header("Content-Type: text/html; charset=utf-8");
session_start();
$t = 'shield';
if(isset($_REQUEST['go'])){
	$m = "CREATE TABLE IF NOT EXISTS ".$t." (
		id_zsh INT,
		nazvanie_zsh TEXT,
		id_user INT,
		id_fight INT
		)";
	//mysql_qw($m);

	mysql_qw($m) or die(mysql_error());

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
		echo "<p>".$m."</p>";
		//mysql_qw($m) or die(mysql_error());
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
	//$m = 'DROP TABLE '.$t;
	//mysql_qw($m);
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