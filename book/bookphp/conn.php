<?php
//connection variables  mysqli//
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dberror1 = "Was not able to connect to database.";
$dberror2 = "Could not find specified table.";  
$dbsel = "bookdb";

//Connect to database//
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ($dberror1);

//Select table within db//
$select_db = mysqli_select_db($conn, $dbsel) or die ($dberror2);
?>