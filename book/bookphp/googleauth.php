<?php

class GoogleAuth{
    protected $client;
    
    public function __construct(Google_Client $googleClient = null){
        $this->client = $googleClient;
        if($this->client){
            $this->client->setClientId('1092850004110-p9tr0178793go7tmros75ohhqftr6ead.apps.googleusercontent.com');
            $this->client->setClientSecret('L5xDAIIMHR1j7T4pqsUTf8ff');
            $this->client->setRedirectUri('http://localhost/book/signup.php');
            $this->client->setScopes('email');
        }
    }
    //method to see if user is logged in
    public function isLoggedIn(){
        return isset($_SESSION['access_token']);
    }
    //gets auth url to redirect to google oauth
    public function getAuthUrl(){
        return $this->client->createAuthUrl();
    }
    //checks the code and returns information on the user
    public function checkRedirectCode(){
        if(isset($_GET['code'])){
            $this->client->authenticate($_GET['code']);
            $this->setToken($this->client->getAccessToken());
            
            $payload = $this->getPayload();
            $email = $payload['email'];
            $gid = $payload['sub'];
            //returns true if success and returns email and google id
            return array(true,$gid,$email);
        }
        return false;
    }
    //sets and returns access token for user
    public function setToken($token){
        $_SESSION['access_token'] = $token;
        $this->client->setAccessToken($token);
    }
    //unsets access token and other session variables
    public function logout(){
        unset($_SESSION['access_token']);
        unset($_SESSION['holdid']);
    }
    
    //sub is the same as id
    public function getPayload(){
        $payload = $this->client->verifyIdToken();
        return $payload;
    }
    
    //check to see if user exist from google
    public function getGoog($id,$mail,$stripeid){
        $db = new DB;
        $holdid = '';
        $ret = false;
        $sql="SELECT holdid, holdpass FROM holdertb WHERE holdmail = '".$mail."'";
        $result = $db->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with email
            $row = $result->fetch_assoc();
            $holdid = $row['holdid'];
            $holdpass = $row['holdpass'];
            if($holdpass!=''){
                $sql="UPDATE `holdertb` SET `holdgid` = '".$id."' WHERE holdmail = '".$mail."'";
                $db->query($sql); //add google id to existing user
            }
            //now redirect to users page
            $ret = false;
        } else {
            //create new user with google credentials
            $sql="INSERT INTO `holdertb` (`holdmail`,`holdgid`,`holdstripe`) VALUES ('".$mail."', '".$id."', '".$stripeid."')";
            if($db->query($sql)){
                echo 'new email added';
                $sql="SELECT holdid FROM holdertb WHERE holdmail = '".$mail."' AND holdgid = '".$id."'";
                $result = $db->query($sql);
                if ($result->num_rows != 0) {
                    //if there is a user with email
                    $row = $result->fetch_assoc();
                    $holdid = $row['holdid'];// will dictate the rest of user interactions
                    //now redirect to more info page;
                    $ret = true;
                } else {
                    echo 'error accessing user id';
                }
            } else {
                echo 'error inserting to db';
            }
        }
        return array($ret,$holdid);
    }
    
    public function setStripe($mail){
        $db = new DB;
        $sql="SELECT holdstripe FROM holdertb WHERE holdmail = '".$mail."'";
        $result = $db->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with email
            $row = $result->fetch_assoc();
            echo $row['holdstripe'];
            //return true;
        } else {
            echo 'newstripe has to be created';
            //return false;
        }
    }
        
        
}


?>