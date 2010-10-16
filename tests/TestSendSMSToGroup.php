<?php
include_once('../GoogleVoice.php');
include_once('LoginInfo.php');

//include_once('../firephp/FirePHP.class.php');
//
//$firephp = FirePHP::getInstance(true);
// 
//$firephp->log($username, 'username');
//$firephp->log($password, 'password');

$gv = new GoogleVoice($username, $password);

echo 'Sending Messages...<br/><br/>';

$numbers = array('8285536915', '8285530205', '8285536915');

$gv->sendSMSToGroup($numbers, 'Test MSG to a group.');

echo "Message sent to the following: <br/>";

echo '<ul>';
foreach ($numbers as $number)
{
	echo '<li>', $number, '</li>';
}
echo '</ul>';