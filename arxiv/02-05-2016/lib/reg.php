<?php
require_once "connect.php";
require_once "request.php";
if(@$REQUEST['del']){echo "da";};

if(@$_REQUEST['enter']){
$reg=$_REQUEST['reg'];

mysql_query('
 CREATE TABLE IF NOT EXISTS producer(
  id INT AUTO_INCREMENT PRIMARY KEY,
  denominations TEXT,
  inn INT,
  pass TEXT,
  post TEXT,
  id_admin INT,
  type TEXT  
  )
 ') or die( mysql_error());
mysql_qw('INSERT INTO producer SET  denominations=?, inn=?, pass=?,
 post=?, id_admin=?, type=?',
 $reg['denominations'], $reg['inn'], $reg['password'],
 $reg['post'], $reg['adm'], $reg['type_org']) or die(mysql_error());
Header("Location:{$_SERVER['SCRIPT_NAME']}?photo=1?".time());
exit();
};

?>
<body marginheight=0 topmargin=0 bgcolor="silver">

 <table align=center border="1" cellpadding="0" cellspacing="0">

  <tr>
   <th>
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <form action="<?=$_SERVER['SCRIPT_NAME']?>">
       Код:</br>
       <input type=text name = "reg[kod]"> </br>
       Наименование:</br>
       <input type=text name = "reg[denominations]"> </br>
       Пароль:</br>
       <input type=password name = "reg[password]"></br>
       ИНН:</br>
       <input type=text name = "reg[inn]"> </br>
       Почта:</br>
       <input type=text name = "reg[post]"> </br>
       ID администратора:</br>
       <input type=text name = "reg[adm]"> </br>
       <input type=radio name = "reg[type_org]" value = "prod" checked> Производитель</br>
       <input type=radio name = "reg[type_org]" value = "seller">Продавец</br>

       <input type="submit" name="enter" value="Проверить">


    </form>
    </th>
    <th>
     <a href="<?=$_SERVER['SCRIPT_NAME']?>", name = "del"">Delet</a>
    </th>
  </tr>
 </table>

</body>