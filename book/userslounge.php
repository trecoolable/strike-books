<?php
session_start();
require_once 'bookphp/conn.php';
require_once 'bookphp/signuphandle.php';
require_once 'bookphp/loungehandle.php';

$db = new DB;
$holder = new holder;
if (isset($_SESSION['holdid'])){
    $holdid = $_SESSION['holdid'];
    //echo $holdid;
    if($db->getGreen($holdid)){ //check if user has authenticated
        //echo 'yes';
    } else {
        //echo 'no';
       // header('Location: https://www.google.com/');
    }
} else {
    echo 'no new login';
}

$holdarray = $holder->getCred($holdid);

?>



<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Users Lounge</title>
        <link rel="stylesheet" type="text/css" href="bookstyle/lounge.css">
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
                <p class="bartext unitext"><?php echo $holdarray['3']; ?></p>
                <input class="barput bookput mayput" type="text" placeholder="Search for books here" maxlength="120">
                <p class="bartext logintext" onclick="window.location.href='logout.php'">Log out: <?php echo $holdarray['0']; ?></p>
            </div>
            
        </div>
        
        <div class="mainbox">
            <input type="hidden" id="holdid" value="<?php echo $holdid; ?>" />
            <p class="maintext head">My Dashboard</p>
            
            <div class="credbox">
                <p class="credtext credmail">Email: <span class="cmail"><?php echo $holdarray['0']; ?></span></p>
                <p class="credtext credschool">School: <span class="cschool"><?php echo $holdarray['3']; ?></span></p>
                <p class="credtext credmaj">Major: <span class="cmaj"><?php echo $holdarray['5']; ?></span></p>
                <p class="credtext credlocal">Meet Place: <span class="clocal"><?php echo $holdarray['4']; ?></span></p>
                <p class="credtext crednum">Phone: <span class="cnum"><?php echo $holdarray['7']; ?></span></p>
                <p class="credtext credbio">Bio: <span class="cdesc"><?php echo $holdarray['8']; ?></span></p>
                <input type="button" class="credbut edit" value="Edit info">
            </div>
            
            
            
            <p class="maintext restext"><?php echo $holder->getMyCount($holdid) ?> Books</p>
 
            <div class="maincontain">
                <div class="recbox addbox">
                    <input type="button" class="mainbut addbut" value="Add an Item">
                </div>
                <?php $holder->getMy($holdid) ?>
            </div>
        </div>
        <div class="statein" val="<?php echo $holdarray['2']; ?>"></div>
        <div class="schoolin" val="<?php echo $holdarray['3']; ?>"></div>
        
        
        
        
    </body>
</html>