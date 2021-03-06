<html>
<head>
<title>Test Send SMS</title>

<script type="text/javascript">

function updateCharCount()
{
	var messageLength = document.getElementById("message").value.length;

	var messageCount = Math.floor(messageLength / 160);

	var charCount = 160 - (messageLength % 160);

	document.getElementById("charCount").innerHTML = (messageCount > 0) ? (messageCount+1).toString() + '.' + charCount.toString() : charCount.toString();
}

</script>

</head>
<body onload="updateCharCount();">
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
$message = $_POST['message'];

if (!empty($submitted) && $submitted == 'submitted'
	&& !empty($username) && !empty($password) && !empty($numbersRaw)
	&& !empty($message)) {
	
	$numbers = explode(',', $numbersRaw);
	
	array_walk($numbers, 'trim_value');
	
	$gv = new GoogleVoice($username, $password);
	
	$errorMsg = '';
	
	echo 'Sending Messages...<br/><br/>';
	try {
		$numbers = $gv->sendSMS($numbers, $message);
	} catch (Exception $e)
	{
		$errorMsg = $e->getMessage();
	}
	
	if ($errorMsg != '')
	{
		echo "Unable to send messages for the following reason:<br/>";
		echo '<ul><li>', htmlentities($errorMsg), '</li></ul>';
	} else {
		echo "Message sent to the following: <br/>";
		
		echo '<ul>';
		foreach ($numbers as $number)
		{
			echo '<li>', $number, '</li>';
		}
		echo '</ul>';
	}
	
	
}
?>

<h1>Test Send SMS</h1>
<div>Enter the following information to test this function:</div>
<form method="post" action="TestSendSMS.php">
<label for="username">GV Username:</label>
<input type="text" name="username" value="<?php echo htmlentities($username); ?>" /><br />
<label for="password">GV Password:</label>
<input type="password" name="password" value="<?php echo htmlentities($password); ?>" /><br />
<label for="numbersRaw">Numbers (separated by comma):</label>
<input type="text" name="numbersRaw" value="<?php echo htmlentities($numbersRaw); ?>" /><br />
<label for="message">Message:</label><br />
<textarea name="message" id="message" cols="20" rows="7" onkeydown="updateCharCount();" onkeyup="updateCharCount();"><?php echo htmlentities(empty($message) ? 'Test MSG to group.' : $message); ?></textarea><br />
<div id="charCount">160</div><br />
<input type="submit" value="Send Message" />
<input type="hidden" name="submitted" value="submitted" />
</form>
</body>
</html>
