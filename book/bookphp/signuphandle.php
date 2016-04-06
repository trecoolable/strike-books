<?php
require_once 'conn.php';
require_once __DIR__.'/../../stripephp/init.php';

class DB{
    protected $mysqli;
    
    public function __construct(){
        $this->mysqli = new mysqli('localhost', 'root', '', 'bookdb');
    }
    
    public function query($sql){
        return $this->mysqli->query($sql);
    }
    
    public function getStripe($mail){
        $stripeId = null;
        \Stripe\Stripe::setApiKey("sk_test_ogYq2jDuLA5nnMP4wytUzZBn");
        try {
        $arse = \Stripe\Account::create(array(
          "country" => "US",
          "managed" => false,
          "email" => $mail
        ));
            //echo "<br>".$arse->id; test id for stripe
            $stripeId = $arse->id; //hold on to stripe id
            //echo 'stripe created';
            $_SESSION['stripeconn'] = 'auto';
        } catch (\Stripe\Error\InvalidRequest $e) {
            //echo 'stripe already exists';
            $stripeId = 'needconnect';//error in creating or already exists
            $_SESSION['stripeconn'] = 'pend'; //sets session to show that user needs to connect
        }
        return $stripeId;
    }
    
    
    public function putStripe($stripeid,$holdid){
        $sql="UPDATE holdertb SET holdstripe ='".$stripeid."' WHERE holdid = '".$holdid."'";
        $update = $this->query($sql);
    }
    
    //see if user is actually new
    public function getGreen($id){
        $ret = false;
        $stripe = false;
        $id = mysqli_real_escape_string($this->mysqli,$id);
         $sql="SELECT holdstatus, holdstripe FROM holdertb WHERE holdid = '".$id."'";
            $result = $this->query($sql);
            if ($result->num_rows != 0) {
                //if there is a user with matching email
                $row = $result->fetch_assoc();
                if($row['holdstatus']=='0'){
                    $ret= true;
                    if($row['holdstripe']=='needconnect'){
                        $stripe = true;
                    }
                } else {
                    if($row['holdstatus']=='1'){
                        $ret= false;
                    } else {
                        $ret= false;
                    } 
                }
            }
        return array($ret,$stripe);
    }

    
    
    
    //end class
}


class StripeEnd{
    
    
    public function connectStripe($holdid){
        $db = new DB;
        $return = '';
          define('CLIENT_ID', 'ca_85jXrtzj53u540I81QYE8YSor3lgj6M0'); //ac_862G4Fkh1tYf78fodO2gRqufRS4pUmtX
          define('API_KEY', 'sk_test_ogYq2jDuLA5nnMP4wytUzZBn');
          define('TOKEN_URI', 'https://connect.stripe.com/oauth/token');
          define('AUTHORIZE_URI', 'https://connect.stripe.com/oauth/authorize');
          if (isset($_GET['code'])) { // Redirect w/ code
            $code = $_GET['code'];
            $token_request_body = array(
              'client_secret' => API_KEY,
              'grant_type' => 'authorization_code',
              'client_id' => CLIENT_ID,
              'code' => $code,
            );
            $req = curl_init(TOKEN_URI);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true );
            curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
            // TODO: Additional error handling
            //var_export($token_request_body);
            $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            //$resp = json_decode(curl_exec($req), true);
            $stripeid = (json_decode(curl_exec($req), true)['stripe_user_id']);
            curl_close($req);
              //echo '<br><br>'.$stripeid;
            //deal with putting stripe in
              $db->putStripe($stripeid,$holdid);
          } else if (isset($_GET['error'])) { // Error
            echo $_GET['error_description'];
          } else { // Show OAuth link
            $authorize_request_body = array(
              'response_type' => 'code',
              'scope' => 'read_write',
              'client_id' => CLIENT_ID
            );
            $url = AUTHORIZE_URI . '?' . http_build_query($authorize_request_body);
              $return = $url;
          }  
        return $return;
    }
 
    
}




$db = new DB;

//
if(isset($_POST['sub'])&&isset($_POST['mail'])&&isset($_POST['pass'])){
    $mail = mysqli_real_escape_string($conn,$_POST['mail']);
    $pass = mysqli_real_escape_string($conn,$_POST['pass']);
    $crypass = md5($pass);
     $sql="SELECT holdid, holdpass, holdgid FROM holdertb WHERE holdmail = '".$mail."'";
        $result = $db->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with matching email
            $row = $result->fetch_assoc();
            if($row['holdgid']!=''){
                echo 'user is using google sign in';
            } else {
                if($crypass == $row['holdpass']){
                //set session holdid and redirect to users page
                $_SESSION['holdid'] = $row['holdid'];
                //header('Location: userslounge.php');
                $_POST['logged'] = 'wookie';
                echo 'signed in';
                } else {
                    echo 'password is incorect';
                } 
            }
        } else {
            echo 'email does not exist or is OAuth';
        }
}

if(isset($_POST['nsub'])&&isset($_POST['mail'])&&isset($_POST['pass'])&&isset($_POST['repass'])){
    $mail = mysqli_real_escape_string($conn,$_POST['mail']);
    $pass = mysqli_real_escape_string($conn,$_POST['pass']);
    $crypass = md5($pass);
    $sql="SELECT holdid FROM holdertb WHERE holdmail = '".$mail."'";
        $result = $db->query($sql);
        if ($result->num_rows != 0) {
            echo 'email address is already in use';
        } else {
            //create stripe account link
            $newStripe = $db->getStripe($mail);
            //if($newStripe =='needconnect')
            //create new user
            $sql="INSERT INTO `holdertb` (`holdmail`,`holdpass`, `holdstripe`) VALUES ('".$mail."', '".$crypass."','".$newStripe."')";
            if($db->query($sql)){
                //echo 'new email added';
                $sql="SELECT holdid FROM holdertb WHERE holdmail = '".$mail."' AND holdpass = '".$crypass."'";
                $result = $db->query($sql);
                if ($result->num_rows != 0) {
                    //if there is a user with email
                    $row = $result->fetch_assoc();
                    echo $row['holdid']; 
                    //now redirect to more info page;
                    $_SESSION['newb']='newb';
                    //echo 'signed in new';
                } else {
                    //echo 'error accessing user id';
                    echo 'error';
                }
            } else {
                echo 'error inserting to db';
                echo 'error';
            }
        }
}

if(isset($_POST['hid'])&&isset($_POST['coll'])&&isset($_POST['state'])&&isset($_POST['local'])){
    $holdid = $_POST['hid'];
    $coll = mysqli_real_escape_string($conn,$_POST['coll']);
    $state = mysqli_real_escape_string($conn,$_POST['state']);
    $local = mysqli_real_escape_string($conn,$_POST['local']);
    $major = mysqli_real_escape_string($conn,$_POST['major']);
    
    $sql="UPDATE `holdertb` SET `holdstatus` = '0', `holdschool` = '".$coll."', `holdstate` = '".$state."', `holdlocal` = '".$local."', `holdmajor` = '".$major."' WHERE `holdid` = ".$holdid."";
    if($db->query($sql)){
        echo 'success';
    } else {
        echo 'error inserting to db';
    }
    
    
    
}


    
    
    
    
    
    
    

?>