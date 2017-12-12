<?php
define('proverka', 84);
// require_once "connect2.php";
require_once 'lib/connect.php';
header("Content-Type: text/html; charset=utf-8");

// if (isset($_POST['tr'])) {
// 	// $g = filter_input(INPUT_POST, 'tr', FILTER_SANITIZE_STRING);
// 	$g = $_POST['tr'];
// 	$m = 'INSERT INTO tr(name) VALUES(?)';
// 	$r = $db -> prepare($m);
// 	$r -> bind_param('s', $g);
// 	$r -> execute();
// 	$r -> close();
// };
// $m = 'SELECT * FROM tr';
// $r = $db -> query($m);
// // $row = $r -> fetch_array(MYSQL_ASSOC);
// for ($a = array(); $row = $r -> fetch_array(MYSQL_ASSOC) ; $a[] = $row) { 
// 	echo $row['name'].'<br>';
// };
// echo "<pre>";
// print_r($a);
// echo "</pre>";




// function Fun($dir)
// {
// 	// $d = dir($dir);
// 	// $v = 0;
// 	// $d->handle;
// 	// $d->path;
// 	// while (false !== ($entry = $d->read())) {
// 	//    	if ($dir !== ".") {
// 	//    		$str = "hello";
// 	//    		global $str;
// 	//    		$f_name = $dir."/".$entry;
// 	//    		$v = $v + filesize($f_name);
// 	//    		// echo $f_name."-".filesize($f_name)."<br>";
// 	//    	}
// 	//    	else{
// 	//    		$f_name = $entry;
// 	//    		$v = $v + filesize($f_name);
// 	//    		// echo $f_name."-".filesize($f_name)."<br>";
// 	//    	}
// 	// };
// 	global $v;
// 	$v = filesize($dir);
// 	$v = filter_var($v, FILTER_VALIDATE_INT);
// 	return $v;
// 	// $d->close();
	
// };

// function vol()
// {
// 	$volium = 0;
// 	$a = array();
// 	// $a[] = 'arena.php';
// 	$a[] = 'css/arena.css';
// 	$a[] = 'css/game_js.css';
// 	$a[] = 'css/main.css';
// 	$a[] = 'css/tr_js.css';
// 	$a[] = 'arena.php';
// 	$a[] = 'game_js.php';
// 	$a[] = 'game_js_invitation.php';
// 	$a[] = 'game_js_load.php';
// 	$a[] = 'game_js_online.php';
// 	$a[] = 'game_js_register.php';
// 	$a[] = 'game_js_rez.php';
// 	$a[] = 'index.php';
// 	$a[] = 'js.php';
// 	$a[] = 'js_fon.php';
// 	$a[] = 'lis.php';
// 	$a[] = 'tr_js.php';
// 	$a[] = 'tr8.php';
// 	$a[] = 'lib/arena.js';
// 	$a[] = 'lib/connect.php';
// 	$a[] = 'lib/lib_js.php';
// 	$a[] = 'lib/main.js';
// 	$a[] = 'lib/mainn.js';
// 	$a[] = 'lib/tr_js.js';
// 	foreach ($a as $key => $value) {	
// 		$volium = $volium + Fun($value);
// 		echo $value."-".Fun($value)."<br>";
// 	};
// 	return $volium;
// };
// $r = vol();
// print_r($r);
// echo "<pre>";
// print_r($str);
// echo "</pre>";


// Игра

for ($i=0; $i < 10 ; $i++) { 
	print_r($i);
};






// ----------------------------------------


?>
<form action="<?=$_SERVER['SCRIPT_NAME']?>"  method = "POST">
	<input type="text" name = "tr"><br>
	<input type="submit">
</form>