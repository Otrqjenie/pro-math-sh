<?php
require_once "connect.php";
require_once "request.php";
$t = true;
$imgDir = "img";
 session_start();
#mysql_query('DROP TABLE user');
//устанавливаем пароль, а в куках сохраняем браузер и id
if(@$_REQUEST['enter_1']){
 $enter_1 = $_REQUEST['enter_1'];
 $_SESSION['enter_u'] = $enter_1;
 ?>
  <form action="<?=$_SERVER['SCRIPT_NAME']?>" method=post enctype="multipart/form-data">
  <input type="file" name="t">
  <input type="submit" name = "doUpload" value="Закачать">
  </form>
 <?
 
}
elseif(@$_REQUEST['doUpload']){
 $data = $_FILES['t'];
 $tmp = $data['tmp_name'];
 if(@file_exists($tmp)){
  $info = @getimagesize($_FILES['t']['tmp_name']);
  if(preg_match('{image/(.*)}is', $info['mime'], $p)){
  $name = "$imgDir/".time().".".$p[1];
  move_uploaded_file($tmp, $name);
  } else{ 
    echo "Не тот формат";
  }
 } else{
   echo "Ошибка закачки: ".$data['error'];
   };
echo '<pre>Содержимое $_FILES: </br>'.print_r($_FILES, true)."</pre><hr>";
echo '<img src="Z:\tmp\phpE967.tmp" >';
}
else {
 //echo "<pre>";
  print_r($_REQUEST);
 echo "</pre>";


/*
mysql_query('CREATE TABLE IF NOT EXISTS user(
 id INT AUTO_INCREMENT PRIMARY KEY,
 pass TEXT,
 id_frend INT,
 name TEXT,
 surname TEXT,
 avatar TEXT,
 birthday INT,
 country TEXT,
 city TEXT,
 admin INT
)') or die(mysql_error());
if(@$_REQUEST['enter_u']){
 $reg_user = $_REQUEST['reg_user'];
 if($reg_user['pass1'] != $reg_user['pass2']) {$t=false;};
 $reg_user['pass1'] = md5($reg_user['pass1']);
 
 if($t){
  mysql_qw('INSERT INTO user SET name=?, surname=?, post=?, pass=?',
   $reg_user['name1'],
   $reg_user['surname'],
   $reg_user['post'],
   $reg_user['pass1']);
  
  $cook['login'] = $reg_user['post'];
  //setcookie();
 // setcookie("time", time(), time()+3600000,"","", 1);
 // setcookie("post", $reg_user['post'], time()+3600000,"","", 1);
  };
 Header("Location:{$_SERVER['SCRIPT_NAME']}?".time());
 exit();
};
*/
?>

<form action="<?=$_SERVER['SCRIPT_NAME'] ?>">
 Имя:</br>
 <input type="text", name = "reg_user[name1]"></br>
 Фамилия:</br>
 <input type="text", name = "reg_user[surname]"></br>
 Почтовый ящик:</br>
 <input type="text", name = "reg_user[post]"></br>
 Страна:</br>
 <input type="text", name = "reg_user[country]"></br>
 Город:</br>
 <input type="text", name = "reg_user[city]"></br>
 Дата рождения:</br>
 <input type="text", name = "reg_user[birthday]">Например "23\12\1988", "12-05-2001"</br>
 Пароль:</br>
 <input type="password", name = "reg_user[pass1]"></br>
 Ещё раз:</br>
 <input type="password", name = "reg_user[pass2]"></br> 
 <input type="submit", name="enter_1" value="Сохранить"></br>
</form>
<?
};
?>
