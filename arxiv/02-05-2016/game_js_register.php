<?php
require_once "connect2.php";
require_once "lib/request.php";
require_once "lib/lib_js.php";
header("Content-Type: text/html; charset=utf-8");
session_start();
// require_once "captcha.php";
if (isset($_REQUEST['reg'])) {
    $args = array(
            'login' => FILTER_SANITIZE_STRING,
            'parol' => FILTER_SANITIZE_STRING,
            'imya' => FILTER_SANITIZE_STRING,
            'familiya' => FILTER_SANITIZE_STRING
        );
$e = filter_var_array($_REQUEST['e'], $args) ;

$m = 'SELECT * FROM user WHERE login = ?';
$r = mysql_qw($m, $e['login'])or die(mysql_error());
$i = 0;

for ($data = array(); $row = mysql_fetch_assoc($r) ; $i++); 
if (isset($_REQUEST['captcha'])) {
    $captcha = filter_var($_REQUEST['captcha'], FILTER_SANITIZE_STRING);
    $s_captcha = filter_var($_SESSION['captcha'], FILTER_SANITIZE_STRING);

if($captcha == $s_captcha){
    if ($i !== 0) {
        echo "Извините, этот логин занят!";
    }
    else{
        $e['parol'] = md5(md5($e['parol']));
        $hesh = rand_string();
        mysql_qw('INSERT INTO user SET 
            login = ?,
            password = ?,
            imya = ?,
            familiya = ?,
            hesh = ?
            ', 
            $e['login'], $e['parol'], $e['imya'], $e['familiya'], $hesh) or die(mysql_error());
        $m = 'SELECT * FROM user WHERE login = ?';
        $r = mysql_qw($m, $e['login']);
        $row = mysql_fetch_assoc($r) or die(mysql_error());
        mysql_qw('INSERT INTO user_param SET
            id =?,
            figthts = 0,
            vins = 0,
            count = 0,
            activity = ?,
            readiness = 0

            ', $row['id'], time()
            ) or die(mysql_error());

        setcookie('id', $row['id'], time() +   12960000);
        setcookie('hesh', $hesh, time() + 12960000);
        $_SESSION['id'] = $row['id'];
        $_SESSION['hesh'] = $hesh;
        $_SESSION['imya'] = $row['imya'];
        $_SESSION['familiya'] = $row['familiya'];
        Header("Location: game_js.php");

    };

}
else{
    
};
};





require_once "captcha.php";
?>
<html>
<head>
    <title></title>
    <script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#captcha .img").click(function() {
                $(this).prev().prop('checked', true);
            })
        })
    </script>
</head>
<body>
<a href="<?=$_SERVER['SCRIPT_NAME']?>">Войти</a>
<form action = "<?=$_SERVER['SCRIPT_NAME']?>">
            логин:</br>
            <input type = "text" name = "e[login]"></br>
            пароль:</br>
            <input type = "password" name = "e[parol]"></br>
            имя:</br>
            <input type = "text" name = "e[imya]"></br>
            фамилия:</br>
            <input type = "text" name = "e[familiya]"></br>
            <?=$captcha?>
            <input type = "submit" name = "reg">
            
</form>
</body>
</html>

<?
}
else{
    //Здесь будет код для входа!
    if (isset($_REQUEST['in'])) {
        
        $e = $_REQUEST['e'];
        $e['parol'] = md5(md5($e['parol']));
        $m = 'SELECT * FROM user WHERE login = ? and password = ?';
        $r = mysql_qw($m, $e['login'], $e['parol'])or die(mysql_error());
        $i = 0;
        for ($data = array(); $row = mysql_fetch_assoc($r) ;$i++); 
        if($_REQUEST['captcha'] == $_SESSION['captcha']){
            if ($i !== 0) {
                //echo "string";
                $m = 'SELECT * FROM user WHERE login = ?';
                $r = mysql_qw($m, $e['login']);
                $row = mysql_fetch_assoc($r) or die(mysql_error());
                setcookie('id', $row['id'], time() +   12960000);
                setcookie('hesh', $row['hesh'], time() + 12960000);
                $_SESSION['id'] = $row['id'];
                $_SESSION['hesh'] = $row['hesh'];
                $_SESSION['imya'] = $row['imya'];
                $_SESSION['familiya'] = $row['familiya'];
                Header("Location: game_js.php");
            }
            else {
                echo "Неправильно указан логин или пароль";
            };
        }
        else{
            
        };
        
        
    }
 require_once "captcha.php";   
?>
<html>
<head>
    <title></title>
    <script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#captcha .img").click(function() {
                $(this).prev().prop('checked', true);
            })
        })
    </script>
</head>
<body>
<a href="<?=$_SERVER['SCRIPT_NAME']?>?reg">Зарегистрироваться</a>
<form action = "<?=$_SERVER['SCRIPT_NAME']?>">
    логин:</br>
    <input type = "text" name = "e[login]"></br>
     пароль:</br>
    <input type = "password" name = "e[parol]"></br>
    <?=$captcha?>
    <input type = "submit" name = "in">
</form>
</body>
</html>

<?
// print_r($_COOKIE);
};

?>