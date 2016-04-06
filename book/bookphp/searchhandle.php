<?php
require_once 'conn.php';
require_once __DIR__.'/../../stripephp/init.php';


class searchEx{
    public function __construct(){
        $this->mysqli = new mysqli('localhost', 'root', '', 'bookdb');
    }
    
    public function query($sql){
        return $this->mysqli->query($sql);
    }
    
    public function getSearch($input,$key,$state,$school){
        $sql="SELECT * FROM booktb WHERE ".$key." LIKE '%".$input."%' AND bactive = '1' AND bstate = '".$state."' AND bschool = '".$school."' ORDER BY bookid DESC";
        if($this->getResult($sql)<1){
            echo '<div class="recbox noresbox">
                    <p class="norestext">No Results near '.$school.'</p>
                </div>';
            $sql="SELECT * FROM booktb WHERE ".$key." LIKE '%".$input."%' AND bactive = '1' AND bstate = '".$state."' ORDER BY bookid DESC";
            if($this->getResult($sql)<1){
                echo '<div class="recbox noresbox">
                    <p class="norestext">No Results in '.$state.'</p>
                </div>';
                $sql="SELECT * FROM booktb WHERE ".$key." LIKE '%".$input."%' AND bactive = '1' ORDER BY bookid DESC";
                if($this->getResult($sql)<1){
                    echo '<div class="recbox noresbox">
                    <p class="norestext">No Results for "'.$input.'"</p>
                </div>';
                
                }
            }
            
        }
        //move to a greater scope 
    }
    
//make a query and display books
public function getResult($sql){
    $more = 0;
    if(!$result = $this->query($sql)){
            //echo 'No results for criteria';
        } else {
        if($result->num_rows == 0){
            
        } else {
            $more++;
                while($row = $result->fetch_assoc()){
                    $bookid = $row['bookid'];
                    $btitle = $row['btitle'];
                    $bauth = $row['bauth'];
                    $bisbn = $row['bisbn'];
                    $bcourse = $row['bcourse'];
                    $bsub = $row['bsubject'];
                    $bstate = $row['bstate'];
                    $bschool = $row['bschool'];
                    $bimg = $row['bimg'];
                    $bprice = $row['bprice'];
                    $bedit = $row['bedition'];
                    $bviews = $row['bviews'];
                    $blocal = $row['blocal'];
                    $bmaj = $row['bmajor'];
                    echo '<div class="recbox bookbox">
                            <div class="imgbox" style="background-image:url('.$bimg.')"></div>
                            <div class="infobox">
                                <p class="infotext title">'.$btitle.'</p>
                                <p class="infotext isbn">ISBN: '.$bisbn.'</p>
                                <p class="infotext author">'.$bauth.'</p>
                                <p class="infotext edition">Edition: '.$bedit.'</p>
                                <p class="infotext sm course">'.$bcourse.'</p>
                                <p class="infotext sm school">'.$bschool.'</p>
                                <p class="infotext sm major">'.$bmaj.' @ '.$blocal.'</p>
                                <input type="hidden" class="bookid" value="'.$bookid.'">
                            </div>
                            <div class="pricebox"><p class="infotext price">$'.$bprice.'</p></div>
                        </div>';
                }
        }  
    }
       return $more; 
}
    
    public function getSchool($state,$school){
        $sql="SELECT * FROM booktb WHERE bactive = '1' AND bstate = '".$state."' AND bschool = '".$school."' ORDER BY bookid DESC LIMIT 30";
        $res = $this->getResult($sql);
        if($res<1){
            echo '<div class="recbox noresbox">
                    <p class="norestext">No Results near '.$school.'</p>
                </div>';
            $sql="SELECT * FROM booktb WHERE bactive = '1' AND bstate = '".$state."' ORDER BY bookid DESC LIMIT 30";
            $res = $this->getResult($sql);
            if($res<1){
                echo '<div class="recbox noresbox">
                    <p class="norestext">No Results in '.$state.'</p>
                </div>';
                $sql="SELECT * FROM booktb WHERE bactive = '1' ORDER BY bookid DESC LIMIT 30";
                $res = $this->getResult($sql);
                if($res<1){
                    echo '<div class="recbox noresbox">
                    <p class="norestext">No Results for "'.$input.'"</p>
                </div>';
                
                }
            }
            
        }
        //move to a greater scope 
    }
    
    public function getBook($bookid){
        $hid = '';
        if(isset($_POST['holdid'])&&$_POST['holdid']!=''){
            $hid = $_POST['holdid'];
        }
        $sql="SELECT * FROM booktb WHERE `bookid` = '".$bookid."' LIMIT 1";
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        $bookid = $row['bookid'];
        $holdid = $row['bholdid'];
        $btitle = $row['btitle'];
        $bauth = $row['bauth'];
        $bisbn = $row['bisbn'];
        $bcourse = $row['bcourse'];
        $bdesc = $row['bdesc'];
        $bsub = $row['bsubject'];
        $bstate = $row['bstate'];
        $bschool = $row['bschool'];
        $bimg = $row['bimg'];
        $bprice = $row['bprice'];
        $bedit = $row['bedition'];
        $bviews = $row['bviews'];
        $blocal = $row['blocal'];
        $bmaj = $row['bmajor'];
        $sql="SELECT * FROM holdertb WHERE `holdid` = '".$holdid."' LIMIT 1";
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        $holdid = $row['holdid'];
        $holdmail = $row['holdmail'];
        $num = $row['holdnum'];
        $holdmail = $row['holdmail'];
        $desc = $row['holddesc'];
        
        echo '<div class="contain">
        <p class="intertext head interhead">Book Viewer</p>
            <p class="intertext desc">We hope you found the right one!</p>
                <div class="imgbox biimg" style="background-image:url('.$bimg.')"></div>
                <p class="bitext bititle">'.$btitle.'</p>
                <p class="bitext biauth">Author: '.$bauth.'</p>
                <p class="bitext biisbn">ISBN: '.$bisbn.'</p>
                <p class="bitext bidesc">Description: '.$bdesc.' '.$bcourse.'</p>
                <p class="bitext selltext biinfo">Seller info:</p>
                <p class="bitext selltext bimail">Email: '.$holdmail.'</p>
                <p class="bitext selltext binum">Phone: '.$num.'</p>
                <p class="bitext selltext bimajor">Major: '.$bmaj.'</p>
                <p class="bitext selltext bilocal">Pickup at: '.$blocal.'</p>
                <p class="bitext selltext bibio">Bio: '.$desc.'</p>
                <p class="bitext biprice" value="30">$'.$bprice.'</p>';
                if($hid == $holdid){
                    echo '<input type="button" class="mainbut delbut" value="Delete Record">';
                } else {
                    echo '<input type="button" class="mainbut getbut" value="Get this book">
                <p class="bitext stripetext">Checkout with <span>Stripe</span></p>';
                }
        echo '<input type="hidden" class="bipricein" value="'.$bprice.'">
        <input type="hidden" class="biholdin" value="'.$holdid.'">
        <input type="hidden" class="bibookin" value="'.$bookid.'">
                </div>';
    }
    
    
    function setPaid($bookid,$holder){
         $sql="UPDATE `booktb` SET `bactive` = '0' WHERE `bookid` = ".$bookid."";
            $this->query($sql);
        
    }
    
    
    function stripePay($token,$amount,$client_id,$bookid,$holder){
        $response = 'error handling card';
        if($token!=''){
            //echo $_POST['stripeToken'];
            //echo $_POST['amount'];
            //$token = $_POST['stripeToken'];
            //$amount = $_POST['amount'];
            //$client_id = "acct_17qnvpCRFoOFhe7G";  //newly created users through sign up don't need to connect stripe account
            \Stripe\Stripe::setApiKey("sk_test_ogYq2jDuLA5nnMP4wytUzZBn");
            try {
              $charge = \Stripe\Charge::create(array(
                "amount" => $amount, // amount in cents, again
                "currency" => "usd",
                "source" => $token,
                "description" => "Strike Charge",
                "application_fee" => 400,
                "destination" => $client_id
                ));
                $this->setPaid($bookid,$holder);
                 $response = 'card charged';
            } catch(\Stripe\Error\Card $e) {
              // The card has been declined
                $response = 'card declined';
            } catch(\Stripe\Error\InvalidRequest $e) {
              // The card has been declined
                $response = 'not charged';
            } 
        }
        return $response;
    }
    
    
    
}

$searchEx = new searchEx;

if(isset($_POST['search'])&&$_POST['search']=='search'&&isset($_POST['input'])){
    $input = mysqli_real_escape_string($conn,$_POST['input']);
    $key = mysqli_real_escape_string($conn,$_POST['ikey']);
    $state = mysqli_real_escape_string($conn,$_POST['state']);
    $school = mysqli_real_escape_string($conn,$_POST['school']);
    $searchEx->getSearch($input,$key,$state,$school);
}

if(isset($_POST['look'])&&$_POST['look']=='look'&&isset($_POST['bookid'])){
    $bookid = mysqli_real_escape_string($conn,$_POST['bookid']);
    $searchEx->getBook($bookid);
    
}


if(isset($_POST['pay'])&&$_POST['pay']=='pay'&&isset($_POST['booktoken'])){
    
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $holder = mysqli_real_escape_string($conn,$_POST['holder']);
    $token = mysqli_real_escape_string($conn,$_POST['booktoken']);
    $bookid = mysqli_real_escape_string($conn,$_POST['bookid']);
    $sql="SELECT holdstripe FROM holdertb WHERE `holdid` = '".$holder."' LIMIT 1";
    $result = $searchEx->query($sql);
    $row = $result->fetch_assoc();
    $holdstripe = $row['holdstripe'];
    $res = $searchEx->stripePay($token,$price,$holdstripe,$bookid,$holder);
    
    echo $res;
}

if(isset($_POST['del'])&&$_POST['del']=='del'&&isset($_POST['bookid'])){
    $bookid = mysqli_real_escape_string($conn,$_POST['bookid']);
    $sql = 'DELETE FROM booktb WHERE bookid = '.$bookid.'';
    $del = $searchEx->query($sql);
    if (!$del){
        echo 'error deleting';
    } else {
        echo 'deleted';
    }
}









?>