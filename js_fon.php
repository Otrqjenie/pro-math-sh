<?php
define('proverka', 84);
require_once 'lib/connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
if (isset($_REQUEST['fon_js'])) {
	// Наполнение арены
	$m = "";
	$r = $db->prepare('SELECT user_param.id, user_param.nik, user_param.count, fight.duration FROM user_param, fight WHERE fight.status = ? and fight.id_priglos = user_param.id ');
	$i = 0;
	$r->bind_param('i', $i);
	$r->execute();
	$r->bind_result($id, $nik, $count, $duration);
	while ($r->fetch()) {
					
	$m = $m."<tr class = 'pr_f' onmousedown='go_f(".$id.")'>".
	"<th>".$nik."</th>
	<th>".$count."</th>
	<th>".$duration."</th>
	</tr>";			
	};
	$r -> close();
	// ---------------------
	// Наполнение приглашений
	$m2 = "";
	$i = 0;
	$nik = '';
	$r = $db-> prepare('SELECT f.id_prigloshaemogo, u.nik, u.count FROM fight f INNER JOIN user_param u 
		ON f.id_prigloshaemogo = u.id
		WHERE f.id_priglos = ? and f.id_prigloshaemogo != 0 and f.status = 2');
	$r -> bind_param('i', $_SESSION['id']);
	$r -> execute();
	$r -> bind_result($id_prigloshaemogo, $nik, $count);
	$a = array();
	while ($r -> fetch()) {
		$a[$i]['id_prigloshaemogo'] = $id_prigloshaemogo;
		$a[$i]['nik'] = $nik;
		$a[$i]['count'] = $count;
		$i++;
	};
	// $m2 = $a[0]['nik'];
	$j = 0;
	$m3 = "";
	while ($j < $i) {		
		$m3 = $m3."
		<div class = 'priglos'>
			<p class = 'zero'>".$a[$j]['nik']."<br>
			<p class = 'zero'>Опыт: ".$a[$j]['count']."</p>
			<p class = 'zero' onmousedown = prinyal(".$a[$j]['id_prigloshaemogo'].")> Принять</p>
		</div>
		";
		if ($j<2) {
			if (j==1) {
				$hr = "<hr>";
			}
			else{
				$hr = '';
			}
			$m2 = $m2."
			<div class = 'priglos'>
				".$hr."
				<p class = 'zero'>".$a[$j]['nik']."<br>
				<p class = 'zero'>Опыт: ".$a[$j]['count']."</p>
				<p class = 'zero' onmousedown = prinyal(".$a[$j]['id_prigloshaemogo'].")> Принять</p>
				
			</div>
			";
		}
		$j++;
	};
	$r -> close();
	echo json_encode(array("arena" => $m, "vrag" => $m2));
	 // $r->close();

};
if (isset($_REQUEST['prinyal'])) {
	// уязвимость, что если пока принимаешь его принял другой игрок

	$r = $db -> prepare("INSERT INTO queue (id_priglos, id_prigloshaemogo, status, customer) VALUES (?, ?, ?, ?)");
	// $i = 1;
	$st = "prinyal";
	$queue = 'arena';
	$r -> bind_param('iiss', $_SESSION['id'], $_REQUEST['prinyal'], $st, $queue);
	$r -> execute();
	$r -> close();
	// Проверка на то что ваше принятие первое
	$r = $db -> prepare("SELECT id_priglos FROM queue WHERE id_prigloshaemogo = ? and customer = 'arena' ORDER BY id");
	$r -> bind_param('i', $_REQUEST['prinyal']);
	$r -> execute();
	$r -> bind_result($id_priglos);
	$r -> fetch();
	$r -> close();
	// Так же нужна проверка не начался ли уже бой

	// $r2 = $db -> prepare("SELECT q.id_priglos, q.status, f.status FROM queue q INNER JOIN fight f ON q.id_priglos = f.id_priglos WHERE f.id_priglos = ? and f.status = 0 ORDER BY q.id");
	// доделать
	$r2 = $db -> prepare("SELECT status FROM fight WHERE id_priglos = ? and id_prigloshaemogo = 0 ORDER BY id_fight DESC");
	$r2 -> bind_param('i', $_SESSION['id']);
	$r2 -> execute();
	$r2 -> bind_result($status);
	$r2 -> fetch();
	$r2 -> close();
	echo $status;
	if (($id_priglos == $_SESSION['id']) and ($status === 0)) {	
		// Действуем мы успели
		$r = $db -> prepare("UPDATE user_param SET readiness = 1 WHERE id = ?");
		$r -> bind_param('i', $_REQUEST['prinyal']);
		$r -> execute();
		$r -> close();
		// // Превращаем бой в текущий бой и удаляем другие принятия
		$time = time();
		$r = $db -> prepare("UPDATE fight SET status =  1, time_begin = ?, id_prigloshaemogo =? WHERE id_priglos = ? and status = 0");
		$r -> bind_param('iii', $time, $_REQUEST['prinyal'], $_SESSION['id']);
		$r ->execute();
		$r -> close();
		// удаляем все принятия приглашений и все очереди
		$del1 = $db -> prepare("DELETE FROM fight WHERE id_priglos = ? and status = 2");
		$del1 -> bind_param('i', $_SESSION['id']);
		$del1 -> execute();
		$del1 -> close();
		$del2 = $db -> prepare("DELETE FROM queue WHERE (id_priglos = ? or id_prigloshaemogo = ?) and customer = 'arena'");
		$del2 -> bind_param('ii', $_SESSION['id'], $_REQUEST['prinyal']);
		$del2 -> execute();
		$del2 -> close();
	}
	else{
		// удаляем свою запись из очереди мы опоздали
		$del = $db -> prepare("DELETE FROM queue WHERE id_priglos = ?");
		$del -> bind_param('i', $_SESSION["id"]);
		$del -> execute();
		$del -> close();
	};
	

	// echo json_encode(array("t"=>2, "r"=>12));

};

?>