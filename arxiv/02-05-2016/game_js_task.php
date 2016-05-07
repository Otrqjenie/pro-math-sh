<?php
require_once "connect2.php";
require_once "lib/request.php";
?>
<form action = <?=$_SERVER['SCRIPT_NAME']?> >
	Номер: <input type = "text" name = "number"></br>
	<input type = "text" name = "nazv_kart"></br> 
	<input type = "text" name = "type_z"></br>

</form>