<?php
session_start();
require_once '../googleapi/vendor/autoload.php';
require_once 'bookphp/googleauth.php';
$auth = new GoogleAuth();
$auth->logout();
unset($_SESSION['holdid']);
header('Location: signup.php');


?>