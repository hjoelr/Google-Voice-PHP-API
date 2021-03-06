<?php
include('../GoogleVoice.php');
include('LoginInfo.php');

$gv = new GoogleVoice($username, $password);

echo '<pre>';
echo 'Phone Number: ', $gv->getNumber(), "\n\n";

// call a phone from one of your forwarding phones
$gv->callNumber('9999999999', '8888888888', 'mobile');

// send an SMS to a phone number
$gv->sendSMS('9999999999', 'Sending a message!');

// fetch new voicemails
$voicemails = $gv->getNewVoicemail();

$msgIDs = array();
foreach( $voicemails as $s )
{
        preg_match('/\+1([0-9]{3})([0-9]{3})([0-9]{4})/', $s['phoneNumber'], $match);
        $phoneNumber = '(' . $match[1] . ') ' . $match[2] . '-'. $match[3];
        echo 'Message from: ' . $phoneNumber . ' on ' . $s['date'] . "\n" . $s['message'] . "\n\n";

        if( !in_array($s['msgID'], $msgIDs) )
        {
                // mark the conversation as "read" in google voice
                $gv->markSMSRead($s['msgID']);
                $msgIDs[] = $s['msgID'];
        }
}

// get all new SMSs
$sms = $gv->getNewSMS();

$msgIDs = array();
foreach( $sms as $s )
{
        preg_match('/\+1([0-9]{3})([0-9]{3})([0-9]{4})/', $s['phoneNumber'], $match);
        $phoneNumber = '(' . $match[1] . ') ' . $match[2] . '-'. $match[3];
        echo 'Message from: ' . $phoneNumber . ' on ' . $s['date'] . ': ' . $s['message'] . "\n";

        if( !in_array($s['msgID'], $msgIDs) )
        {
                // mark the conversation as "read" in google voice
                $gv->markSMSRead($s['msgID']);
                $msgIDs[] = $s['msgID'];
        }
}
echo '</pre>';

?>
