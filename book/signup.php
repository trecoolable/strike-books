<?php
session_start();
require_once 'bookphp/conn.php';
require_once '../googleapi/vendor/autoload.php';
//require_once '../stripephp/init.php';
require_once 'bookphp/googleauth.php';
require_once 'bookphp/signuphandle.php';
require_once 'bookphp/googleauth.php';

$db = new DB;
$googleClient = new Google_Client;
$auth = new GoogleAuth($googleClient);
//check superglobals to see if google has redirected back
$redcred = $auth->checkRedirectCode();
if($redcred[0]){
    $stripeid = $db->getStripe($redcred[2]);
    //$auth->getGoog($auth->checkRedirectCode()[1],$auth->checkRedirectCode()[2], $stripeid);
    $green = $auth->getGoog($redcred[1],$redcred[2], $stripeid)[0];
    $holdid = $auth->getGoog($redcred[1],$redcred[2], $stripeid)[1];
    if ($green){
        $_SESSION['holdid'] = $holdid;
        header('Location: moreinfo.php');
    } else {
        $_SESSION['holdid'] = $holdid;
        header('Location: userslounge.php');
    }
}

if(isset($_GET['newid'])){
    $_SESSION['holdid'] = $_GET['newid'];
    header('Location: moreinfo.php');
}

if(isset($_SESSION['holdid'])){
    //header('Location: userslounge.php');
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>SignUp</title>
        <link rel="stylesheet" type="text/css" href="bookstyle/signup.css">
        <link rel="stylesheet" type="text/javascript" href="bookjs/signup.js">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="bookjs/signup.js"></script>
    </head>
    <body>
        <div class="mainbox">
            <p class="signtext head">Sign In</p>
            <form>
            <input class="signput signmail" type="email" placeholder="Email" maxlength="32">
            <input class="signput signpass" type="password" placeholder="Password" maxlength="32">
            <div class="ext"></div>
            <input class="subbut login" type="button" value="Sign In">
            <p class="signtext tiny"></p>
            <a class="signup">or Sign Up with Strike!</a>
            </form>
            <?php if(isset($_GET['type'])){
                    echo '<a class="googbut" href="'.$auth->getAuthUrl().'">Sign Up With Google</a>';
                } else{
                    if(!$auth->isLoggedIn()){ //check to see if user is signed in
                        echo '<a class="googbut" href="'.$auth->getAuthUrl().'">Sign In With Google</a>';
                    } else{
                        echo '<a class="googbut" href="logout.php">Sign Out</a>';
                    }
                }
            ?>
        </div>
        
        
        
        
        
        
    </body>
</html>