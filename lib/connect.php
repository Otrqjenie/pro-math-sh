<?php 
if (!defined('proverka')) {
	die();
};
$db = new mysqli('localhost', 'ww', 'eQfL6QsZudbW6jOj', 'db');
if ($db->connect_errno) {
	die('Sorry, we having some problems.');	
};
?>