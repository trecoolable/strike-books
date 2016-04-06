<?php
session_start();
require_once 'bookphp/conn.php';
require_once 'bookphp/signuphandle.php';
require_once 'bookphp/loungehandle.php';
require_once 'bookphp/searchhandle.php';

$db = new DB;
$holder = new holder;
$searchEx = new searchEx;
if (isset($_SESSION['holdid'])){
    $holdid = $_SESSION['holdid'];
    //echo $holdid;
} else {
    $holdid = 'visitor';
    //echo 'no new login';
}

$holdarray = $holder->getCred($holdid);

$school = '';
if(isset($_POST['school'])){
    $_SESSION['school'] = $_POST['school'];
    $school = $_POST['school'];
} else if(isset($_SESSION['school'])){
   $school = $_SESSION['school'];
}
$state = '';
if(isset($_POST['state'])){
    $_SESSION['state'] = $_POST['state'];
    $state = $_POST['state'];
} else if(isset($_SESSION['state'])){
   $state = $_SESSION['state'];
}
if($holdid!='visitor'){
    $school = $holdarray['3'];
    $state = $holdarray['2'];
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Strike Search</title>
        <link rel="stylesheet" type="text/css" href="bookstyle/mainsearch.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script type="text/javascript" src="bookjs/lounge.js"></script>
        <script type="text/javascript" src="bookjs/universal.js"></script>
    </head>
    <body>
        <div class="base"></div>
        <div class="topperup">
            <div class="topperbox" onclick="window.location.href='mainsearch.php'">
                <p class="toppercv">Strike</p>
                <p class="topper">Strike</p>
                <p class="toppercv topperside">Books!</p>
            </div>
            
        
        </div> 
        <div class="mainbar">
            <div class="barcn">
                <?php if($holdid!='visitor'){
                    echo '<p class="bartext unitext">'.$holdarray['3'].'</p>';
                } else {
                    echo '<p class="bartext unitext">'.$school.'</p>';
                }
                ?>
                <input class="barput bookput mayput" type="text" placeholder="Search for books here" maxlength="120">
                <?php if($holdid!='visitor'){
                    echo '<p class="bartext logintext" onclick="window.location.href=\'userslounge.php\'">Logged in as: '.$holdarray['0'].'</p>';
                } else {
                    echo '<p class="bartext logintext" onclick="window.location.href=\'signup.php\'">Sign up with Strike!</p>';
                }
                ?>
            </div>
            
        </div>
        
        <div class="mainbox">
            <input type="hidden" id="holdid" value="<?php echo $holdid; ?>" />
            <p class="maintext head">Books near you</p>
            <p class="maintext label filterlb">Filter by:</p>
            <select class="mainput filtersel" name="filter">
                <option value="nostate">Date submitted</option>
                <option value="nostate">School</option>
                <option value="nostate">Price Low-High</option>
                <option value="nostate">Views</option>
            </select>
            <div class="maincontain">
                <?php $searchEx->getSchool($state,$school) ?>
            </div>
        </div>
        <div class="statein" val="<?php echo $state ?>"></div>
        <div class="schoolin" val="<?php echo $school ?>"></div>
        
        
        
        
    </body>
</html>