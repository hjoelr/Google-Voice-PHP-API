<html>
<head>
<title>Test Send SMS To Group</title>
</head>
<body>
<?php

function trim_value(&$value) 
{ 
    $value = trim($value); 
}

		
include_once('../GoogleVoice.php');

//include_once('../firephp/FirePHP.class.php');
//
//$firephp = FirePHP::getInstance(true);
// 
//$firephp->log($username, 'username');
//$firephp->log($password, 'password');

$submitted = $_POST['submitted'];
$username = $_POST['username'];
$password = $_POST['password'];
$numbersRaw = $_POST['numbersRaw'];

if (!empty($submitted) && $submitted == 'submitted'
	&& !empty($username) && !empty($password) && !empty($numbersRaw)) {
	
	$numbers = explode(',', $numbersRaw);
	
	array_walk($numbers, 'trim_value');
	
	$gv = new GoogleVoice($username, $password);
	
	echo 'Sending Messages...<br/><br/>';
	
	$gv->sendSMSToGroup($numbers, 'Test MSG to a group.');
	
	echo "Message sent to the following: <br/>";
	
	echo '<ul>';
	foreach ($numbers as $number)
	{
		echo '<li>', $number, '</li>';
	}
	echo '</ul>';
}
?>

<h1>Test Send SMS To Group</h1>
<div>Enter the following information to test this function:</div>
<form method="post" action="TestSendSMSToGroup.php">
<label for="username">GV Username:</label>
<input type="text" name="username" value="<?php echo $username; ?>" /><br />
<label for="password">GV Password:</label>
<input type="password" name="password" value="<?php echo $password; ?>" /><br />
<label for="numbersRaw">Numbers (separated by comma):</label>
<input type="text" name="numbersRaw" value="<?php echo $numbersRaw; ?>" /><br />
<input type="submit" value="Test Values" />
<input type="hidden" name="submitted" value="submitted" />
</form>
</body>
</html>
