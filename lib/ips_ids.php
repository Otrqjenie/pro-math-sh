<?php
// Проверка не сменился ли ip при неизменной сессии
if (!defined('proverka')) {
	die();
};
if (!isset($_SESSION['u_ip']) && !isset($_SESSION['u_id'])) {
	$_SESSION['u_ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['u_id'] = session_id();
}
elseif (isset($_SESSION['u_ip']) && isset($_SESSION['u_id'])) {
	if ($_SESSION['u_id'] == session_id()) {
		if ($_SESSION['u_ip'] != $_SERVER['REMOTE_ADDR']) {
			setcookie('id');
			setcookie('hesh');
			session_destroy();
			Header("Location: game_js_register.php");
		}
	}
};
//-------------------------------------------------------
// Функция экранирования спецсимволов
function escape($string)
{
	return htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
};
?>