<?php

// error_reporting(0);
define('proverka', 84);
require_once "connect2.php";
require_once "st_lib/request.php";
// require_once "lib/connect.php";
session_start();
header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
<title>Статистика!</title>
<script type="text/javascript" src = "lib/jquery-2.2.0.js"></script>
<script type="text/javascript" src = "statistika_js.js"></script>
<link rel="stylesheet" type="text/css" href="st_css/statistika.css">
</head>
<body>
<div class  = "fild" id = "timer"></div>
<div class  = "fild" id = "z1">Задачи I-ур</div>
<div class  = "fild" id = "but1"><button onclick = "but1('z1', 1)">+</button></br><button onclick = "but1('z1', -1)">-</button></div>
<div class  = "fild" id = "z2">Задачи II-ур</div>
<div class  = "fild" id = "but2"><button onclick = "but1('z2', 1)">+</button></br><button onclick = "but1('z2', -1)">-</button></div>
<div class  = "fild" id = "video">Ролики</div>
<div class  = "fild" id = "videobut"><button onclick = "but1('v', 1)">+</button></br><button onclick = "but1('v', -1)">-</button></div>
<div class  = "fild" id = "idei">Идеи</div>
<div class  = "fild" id = "ideibut"><button onclick = "but1('i', 1)">+</button></br><button onclick = "but1('i', -1)">-</button></div>
<div class  = "fild" id = "sess"><button onclick = "start()">Старт</button></br><button onclick = "stoP()">Стоп</button></div>
<div id = "conteiner"></div>
<div class  = "fild3" id = "graph"></div>
<div class  = "fild" id = "load"><button onclick ="lo()">График</button></div>
</body>
</html>