<?php
require_once "connect2.php";
require_once "lib/request.php";
header("Content-Type: text/html; charset=utf-8 without BOM");
if(isset($_REQUEST['go'])){
	$e = $_REQUEST['e'];
	$r = mysql_qw('INSERT INTO book SET name = ?, writ = ?', $e['name'], $e['text'] ) or die(mysql_error());
Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
exit();
}
else{

$r= mysql_qw('SELECT * FROM book');
for($data=array(); $row = mysql_fetch_assoc($r); $data[] = $row)
echo "<pre>";
print_r($data);
echo "</pre>";

//$r= mysql_qw('DELETE FROM book') or die(mysql_error());
};
?>
<form action="<?=$_SERVER['SCRIPT_NAME']?>" >
	<input type = "text" name = "e[name]"></br>
	<input type = "text" name = "e[text]"></br>
	<input type = "submit" name = "go"></br>
</form>
