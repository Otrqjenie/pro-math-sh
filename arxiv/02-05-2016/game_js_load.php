<?php
require_once "connect2.php";
require_once "lib/request.php";
header("Content-Type: text/html; charset=utf-8");
//session_start();
if (isset($_POST['send-request'])) {
    if ($_FILES['load']['error'] == 0) {
        if ($_FILES['load']['size'] <= 1000000) {
            if ($_FILES['load']['type'] == "image/gif") {
                //print_r($_FILES['load']);
                $e = $_REQUEST['e'];
                //Проверка на повтор
                mysql_qw('INSERT INTO zadania SET
                    nazvanie = ?,
                    soderjanie = ?,
                    otvet = ?,
                    slojnost = ?,
                    tip = ?
                    ', $e['nazvanie'], $e['soderjanie'], $e['otvet'], $e['slojnost'], $e['tip']
                    ) or die(mysql_error());
                $r = mysql_qw('SELECT * FROM zadania ORDER BY id DESC') or die(mysql_error());
                $row = mysql_fetch_assoc($r);
                //print_r($e);
                $str = $row['id'].".gif";
                move_uploaded_file($_FILES['load']['tmp_name'], 'imag/'.$str);
                $m = 'UPDATE zadania SET img = ? WHERE id = ?';
                mysql_qw($m, $str, $row['id']) or die(mysql_error());
                Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
                exit();

            }
        }
    }
    
};
?>
<form action = "<?=$_SERVER['SCRIPT_NAME']?>" method = "post" enctype = "multipart/form-data">
    Название задачи:</br>
    <input type = "text" name = "e[nazvanie]"></br>
    Текст задачи:</br>
    <textarea name = "e[soderjanie]" wrap = "virtual" cols = "40" rows = 10></textarea></br>
    Уровень сложности:</br>
    <select name = "e[slojnost]">
        <option>Базовый</option>
        <option>Повышенный</option>
        <option>Высокий</option>
        <option>Олимпиадный</option>
    </select></br>
    Тип задания:</br>
    <select name = "e[tip]">
        <option>Числа_и_вычисления</option>
        <option>Алгебраические_выражения</option>
        <option>Уравнения_и_неравенства</option>
        <option>Числовые_последовательности</option>
        <option>Функции</option>
        <option>Координаты_на_прямой_и_плоскости</option>
        <option>Геометрия</option>
        <option>Статистика_и_теория_вероятности</option>
    </select></br>
    Ответ:</br>
    <input type = "text" name = "e[otvet]"></br>
    Прикрепить изображение:</br>
    <input type = "file" name = "load"></br>
    <input type = "submit" name = "send-request">
</form>