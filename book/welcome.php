<?php
session_start();
require_once 'bookphp/conn.php';
require_once 'bookphp/signuphandle.php';
require_once 'bookphp/loungehandle.php';

$db = new DB;
$holder = new holder;
if (isset($_SESSION['holdid'])){
    $holdid = $_SESSION['holdid'];
    //echo $holdid; //redirect to userslounge
} else {
    $holdid = 'visitor';
    //echo 'no new login';
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Strike Search</title>
        <link rel="stylesheet" type="text/css" href="bookstyle/welcome.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script type="text/javascript" src="bookjs/lounge.js"></script>
        <script type="text/javascript" src="bookjs/universal.js"></script>
    </head>
    <body>
        <div class="welcomebox">
            <p class="weltext head">Strike</p>
            <form method="POST" action="mainsearch.php">
                <input class="schoolin" name="school" type="text" placeholder="Your University or College">
                <select class="statein" name="state">
                <option value="nostate">Select State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
                </select>
                <input class="inbut" type="submit" value="Check my Books!">
            </form>
        </div>
    </body>
</html>