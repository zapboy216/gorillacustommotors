<?php

error_reporting(E_ALL ^ E_NOTICE);



$my_email = "gorillamotors@netzero.com";



$from_email = "";

/*

Optional.  Enter the continue link to offer the user after the form is sent.  If you do not change this, your visitor will be given a continue link to your homepage.

If you do change it, remove the "/" symbol below and replace with the name of the page to link to, eg: "mypage.htm" or "http://www.elsewhere.com/page.htm"

*/

$continue = "/";

/*



Save this file (FormToEmail.php) and upload it together with your webpage containing the form to your webspace.  IMPORTANT - The file name is case sensitive!  You must save it exactly as it is named above!



You do not need to make any changes below this line.

*/

$errors = array();

// Remove $_COOKIE elements from $_REQUEST.

if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}

// Validate email field.

if(isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{

$_REQUEST['email'] = trim($_REQUEST['email']);

if(substr_count($_REQUEST['email'],"@") != 1 || stristr($_REQUEST['email']," ") || stristr($_REQUEST['email'],"\\") || stristr($_REQUEST['email'],":")){$errors[] = "Email address is invalid";}else{$exploded_email = explode("@",$_REQUEST['email']);if(empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1])){$errors[] = "Email address is invalid";}else{if(substr_count($exploded_email[1],".") == 0){$errors[] = "Email address is invalid";}else{$exploded_domain = explode(".",$exploded_email[1]);if(in_array("",$exploded_domain)){$errors[] = "Email address is invalid";}else{foreach($exploded_domain as $value){if(strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value)){$errors[] = "Email address is invalid"; break;}}}}}}

}

// Check referrer is from same site.

if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}

// Check for a blank form.

function recursive_array_check_blank($element_value)
{

global $set;

if(!is_array($element_value)){if(!empty($element_value)){$set = 1;}}
else
{

foreach($element_value as $value){if($set){break;} recursive_array_check_blank($value);}

}

}

recursive_array_check_blank($_REQUEST);

if(!$set){$errors[] = "You cannot send a blank form";}

unset($set);

// Display any errors and exit if errors exist.

if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}

if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}

// Build message.

function build_message($request_input){if(!isset($message_output)){$message_output ="";}if(!is_array($request_input)){$message_output = $request_input;}else{foreach($request_input as $key => $value){if(!empty($value)){if(!is_numeric($key)){$message_output .= str_replace("_"," ",ucfirst($key)).": ".build_message($value).PHP_EOL.PHP_EOL;}else{$message_output .= build_message($value).", ";}}}}return rtrim($message_output,", ");}

$message = build_message($_REQUEST);

$message = $message . PHP_EOL.PHP_EOL."-- ".PHP_EOL."newsletter subscriber for gorilla custom motors";

$message = stripslashes($message);

$subject = "FormToEmail Comments";

$subject = stripslashes($subject);

if($from_email)
{

$headers = "From: " . $from_email;
$headers .= PHP_EOL;
$headers .= "Reply-To: " . $_REQUEST['email'];

}
else
{

$from_name = "";

if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])){$from_name = stripslashes($_REQUEST['name']);}

$headers = "From: {$from_name} <{$_REQUEST['email']}>";

}

mail($my_email,$subject,$message,$headers);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<title>Form To</title>
<!-- CSS -->
<link rel="stylesheet" media="screen, print" href="stylesheets/basic.css">

<!--[if gte IE 7]><!-->
<link rel="stylesheet" media="screen" href="stylesheets/screen.css">
<!--<![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#ffffff" text="#000000">

<div>



<header role="masthead">
  
<h1 id="branding"><a href="index.html">Gorilla Custom Motors</a></h1>
	
    
</header>

<div id="content" class="page">


<div id="wrap">

<section id="main">

 
<h3>Thank you <?php if(isset($_REQUEST['name'])){print stripslashes($_REQUEST['name']);} ?></h3>
<h3>we will respond as quickly as possible</h3>
<img src="img/ads/adone2.jpg"  alt=""/>
<p><a href="<?php print $continue; ?>">Click here to continue</a></p>
	












</section>
<!-- /#main -->


<aside role="sub">



	

	




</aside>

</div><!-- /#content -->

<!-- /aside -->

<footer id="siteinfo">
	<p><a href="legalterms.html">Privacy Policy</a> | <a href="legalterms.html">Terms of Use</a> | <a href="contact.html">Contact</a><br>© 2014 gorilla custom motors, all rights reserved.</p>
	
</footer>

</div><!-- /#wrap -->
</center>
</div>

</body>
</html>