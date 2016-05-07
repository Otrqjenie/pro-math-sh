<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
 ?>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 <? if (isset($_POST['captcha']) && $_POST['captcha'] != ''){
if($_POST['captcha'] == $_SESSION['captcha']){
	echo "Верно";
}
else{
	
};
 };
  
 
 

?>
 </body>
 </html>