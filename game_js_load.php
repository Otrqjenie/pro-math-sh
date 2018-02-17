<?php
session_start();
define('proverka', 84);
// require_once "connect2.php";
require_once "lib/request.php";
require_once 'lib/connect.php';
header("Content-Type: text/html; charset=utf-8");
session_start();


// Проверка на админа
$admin = "admin";
$r = $db -> prepare('SELECT COUNT(*) FROM user_param WHERE id = ? and resolution = ?');
$r -> bind_param('is', $_SESSION['id'], $admin);
$r -> execute();
$r -> bind_result($c_admin);
$r -> fetch();
$r -> close();
if ($c_admin == 0) {
    die("Ашыпка");
}
else{
};
if (isset($_POST['send-request'])) {
    if ($_FILES['load']['error'] == 0) {
        if ($_FILES['load']['size'] <= 1000000) {
            if ($_FILES['load']['type']) {
                $e = $_POST['e'];
                $razdel = "oge";
                switch ($e['slojnost']) {
                    case 'Базовый':
                        $slojnost = 1;
                        break;
                    case 'Повышенный':
                        $slojnost = 2;
                        break;
                    case 'Олимпиадный':
                        $slojnost = 3;
                        break;
                    
                    default:
                        $slojnost = 1;
                        break;
                };
                $r = $db -> prepare('SELECT COUNT(*) FROM zadania WHERE nazvanie = ?');
                $r -> bind_param('s', $e['nazvanie']);
                $r -> execute();
                $r -> bind_result($c_nazvanie);
                $r -> fetch();
                $r -> close();
                if ($c_nazvanie > 0) {
                    die();
                };
                $insert = $db->prepare("
                    INSERT INTO zadania (nazvanie, soderjanie, otvet, slojnost, tip, razdel, ogranichenie)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                    ");
                $insert->bind_param('ssssssi', $e['nazvanie'], $e['soderjanie'], $e['otvet'], $slojnost, $e['tip'], $razdel, $e['ogranichenie']);
                $insert->execute();
                // добавляем поле с картинкой
                if ($result = $db->query("SELECT * FROM zadania ORDER BY id DESC")) {
                    $row = $result->fetch_assoc();
                    $str = $row['id'].".gif";
                    move_uploaded_file($_FILES['load']['tmp_name'], 'imag/'.$str);
                    $m = "UPDATE zadania SET img = '".$str."' WHERE id = '".$row['id']."'";
                    $result2 = $db->query($m);
                    // $result-> bind_param('ss', $str, $row['id']);
                    // if ($result->execute()) {
                        header('Location: game_js_load.php');
                        die();
                    // }
                }


                }
            }
        }
};
?>
<form action = "<?=$_SERVER['SCRIPT_NAME']?>" method = "post" enctype = "multipart/form-data">
    Название задачи:<br>
    <input type = "text" name = "e[nazvanie]"><br>
    Текст задачи:<br>
    <textarea name = "e[soderjanie]" wrap = "virtual" cols = "40" rows = 10></textarea><br>
    Ограничение в день:<br>
    <input type = "text" name = "e[ogranichenie]" value="1-3"><br>
    Уровень сложности:<br>
    <select name = "e[slojnost]">
        <option>Базовый</option>
        <option>Повышенный</option>
        <option>Олимпиадный</option>
    </select><br>
    Тип задания:<br>
    <select name = "e[tip]">
        <option>Числа_и_вычисления</option>
        <option>Алгебраические_выражения</option>
        <option>Уравнения_и_неравенства</option>
        <option>Числовые_последовательности</option>
        <option>Функции</option>
        <option>Координаты_на_прямой_и_плоскости</option>
        <option>Геометрия</option>
        <option>Статистика_и_теория_вероятности</option>
    </select><br>
    Ответ:<br>
    <input type = "text" name = "e[otvet]"><br>
    Прикрепить изображение:<br>
    <input type = "file" name = "load"><br>
    <input type = "submit" name = "send-request">
</form>