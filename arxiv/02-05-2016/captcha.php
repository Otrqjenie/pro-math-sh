<?php 
function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
$elements = array(
	'chrome.png' => 'Google Chrome',
	'firefox.png' => 'Firefox',
	'ie.png' => 'Internet Explorer',
	'opera.png' => 'Opera',
	'safari.png' => 'Safari'
);
$rand = array_rand($elements, 1);
shuffle_assoc($elements);
// var_dump($elements);
$base = rand();
$captcha = 'Выберите браузер:<strong>'.$elements[$rand].'</strong>';
$captcha .= '<div id = "captcha">';
foreach ($elements as $key => $value) {
    $captcha .= '<input type = "radio" name = "captcha" value = "'.md5($value . $base).'" style = "display:none">';
    $captcha .= "<div  class = \"img\" style = \"background: url('imag/{$key}') bottom left no-repeat; width: 180px; height: 180px; float: left; cursor: pointer;\"></div>";
}
$captcha .= '<div style = "clear: both"></div>';
$captcha .= '</div>';
$_SESSION['captcha'] = md5($elements[$rand] . $base);
 ?>