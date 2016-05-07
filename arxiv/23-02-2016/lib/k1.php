<?php
header("Content-Type: text/html; charset=utf-8 without BOM");
session_start();
$pice = 220;
if(isset($_REQUEST['go1'])){
	$a = htmlspecialchars($_REQUEST['a']);
	$a;
	?>	
	<form action = <?=$_SERVER['SCRIPT_NAME']?>>
	Высота потолка: &nbsp;&nbsp;&nbsp;&nbsp; <input type = "text" name = h></br>
		<?
			for($i = 0; $i < $a; $i++){
				$b = $i +1;
				echo "Ширина ".$b."-й стены: <input type = 'text' name = n[".$i."]></br>";
			};
		?></br>
		<input type = "submit" name = "gob1" value = "<<Назад"><input type = "submit" name = "go2" value = "Далее>>">
	</form>
	<?

}
elseif(isset($_REQUEST['go2'])){
	$h = $_REQUEST['h'];
	$a = $_REQUEST['n'];
	$p = 0;
	foreach($a as $k=>$v){
		$p = $p + $v;
	};
	$s = $p*$h;
	$pr = $s*$pice;
	echo "Площадь = ".$s."</br>Стоимость = ".$pr."руб";
}
elseif(isset($_REQUEST['gob1'])){
	?>
	<form action = <?=$_SERVER['SCRIPT_NAME']?>>
	Колличество стен:	<select name = a>
						<option>1
						<option>2
						<option>3
						<option>4
						<option>5
						<option>6
						<option>7
						<option>8
						<option>9
						<option>10
						</br><input type = "submit" name = "go1" value = "Далее>>">
	</form>
	<?
}
else{
	?>
	<form action = <?=$_SERVER['SCRIPT_NAME']?>>
	Колличество стен:	<select name = a>
						<option>1
						<option>2
						<option>3
						<option>4
						<option>5
						<option>6
						<option>7
						<option>8
						<option>9
						<option>10
		</br><input type = "submit" name = "go1" value = "Далее>>">
	</form>
	<?
};
?>
