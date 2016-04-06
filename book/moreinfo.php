<?php
session_start();
require_once 'bookphp/conn.php';
require_once 'bookphp/signuphandle.php';

$db = new DB;
$stripeConn = new stripeEnd;
$stripeUrl;
if (isset($_SESSION['holdid'])){
    $holdid = $_SESSION['holdid'];
    //echo $holdid;
    if($db->getGreen($holdid)[0]){
        //echo 'yes';
        if($db->getGreen($holdid)[1]){
            //deal with stripe connect
            $stripeUrl = $stripeConn->connectStripe($holdid);
        }
    } else {
        //echo 'no';
        header('Location: https://www.google.com/');
    }
} else {
    echo 'no new login';
}
?>



<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>SignUp</title>
        <link rel="stylesheet" type="text/css" href="bookstyle/moreinfo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="bookjs/moreinfo.js"></script>
    </head>
    <body>
        <div class="infobox">
            <div class="container">
                <p class="infotext stripe">Stripe</p>
                <div class="cn 1">
                <p class="infotext stripem">We have taken the initiative to make your user experience
                more peaceful and streamlined. That is why we have integrated Stripe Payments directly into
                our website. <br>Upon signing up, we have created a Stripe account on your behalf. You
                ready to recieve payments immediately!</p>
                </div>
                <div class="cn 2">
                <p class="infotext stripem">Be sure to check your email to confirm your new stripe account.<br><br>
                -Strike Team</p>
                </div>
            </div>
            <?php if(!isset($stripeUrl)){
                echo '<input class="infobut next nextstripe" type="button" value="next">';
            } else {
                echo '<input class="infobut next nextstripe" onclick="window.location.href=\''.$stripeUrl.'\'" type="button" value="Connect">';
            } ?>
            
            <input type="hidden" id="holdid" value="<?php echo $holdid; ?>" />
            <p class="infotext tiny"></p>
        </div>
    </body>
</html>