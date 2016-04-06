<?php
require_once 'conn.php';


class holder{
    public function __construct(){
        $this->mysqli = new mysqli('localhost', 'root', '', 'bookdb');
    }
    
    public function query($sql){
        return $this->mysqli->query($sql);
    }
    
    public function getCred($holdid){
        $sql="SELECT * FROM holdertb WHERE holdid = '".$holdid."'";
        $result = $this->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with matching email
            $row = $result->fetch_assoc();
            $mail = $row['holdmail'];
            $stripe = $row['holdstripe'];
            $state = $row['holdstate'];
            $school = $row['holdschool'];
            $local = $row['holdlocal'];
            $major = $row['holdmajor'];
            $status = $row['holdstatus'];
            $num = $row['holdnum'];
            $desc = $row['holddesc'];
            return array($mail,$stripe,$state,$school,$local,$major,$status,$num,$desc);
        } else {
            return 'email does not exist or is OAuth';
        } 
    }
    
    public function getMy($holdid){
        $sql="SELECT * FROM booktb WHERE bholdid = '".$holdid."' ORDER BY bookid DESC";
        $result = $this->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with books
            //$book = array();
            $book = 0;
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
                $bact = $row['bactive'];
                $book++;
                if($bact!=0){
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
                } else { //inactive paid for
                    echo '<div class="recbox bookbox paid">
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
        } else {
            echo 'You currently have no books available.';
        } 
        //return $book;
    }
    
        public function getMyCount($holdid){
        $sql="SELECT * FROM booktb WHERE bholdid = '".$holdid."' AND bactive = '1' ORDER BY bookid DESC";
        $result = $this->query($sql);
        if ($result->num_rows != 0) {
            //if there is a user with books
            //$book = array();
            $book = 0;
            while($row = $result->fetch_assoc()){
                $book++;
            }
        } else {
            $book = 0;
        } 
        return $book;
    }
    
    
    public function updateHold($holdid,$mail,$school,$maj,$local,$desc,$num){
        $sql = "UPDATE `holdertb` SET `holdmail` = '".$mail."', `holdschool` = '".$school."', `holdlocal` = '".$local."', `holddesc` = '".$desc."', `holdnum` = '".$num."', `holdmajor` = '".$maj."' WHERE `holdertb`.`holdid` = ".$holdid."";
        if($this->query($sql)){
            return true;
        } else {
            return false;
        }
    }
}

$holder = new holder;
if(isset($_POST['badd'])&&$_POST['badd']=='add'&&isset($_POST['hid'])&&isset($_POST['btitle'])){
    $hold = $_POST['hid'];
    $cred = $holder->getCred($_POST['hid']);
    $school = $cred[3];
    $state = $cred[2];
    $local = $cred[4];
    $maj = $cred[5];
    
    $title = mysqli_real_escape_string($conn,$_POST['btitle']);
    $auth = mysqli_real_escape_string($conn,$_POST['auth']);
    $isbn = mysqli_real_escape_string($conn,$_POST['bisbn']);
    $sub = mysqli_real_escape_string($conn,$_POST['bsub']);
    $edi = mysqli_real_escape_string($conn,$_POST['edi']);
    $bcourse = mysqli_real_escape_string($conn,$_POST['bcourse']);
    $bimg = mysqli_real_escape_string($conn,$_POST['bimg']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $desc = mysqli_real_escape_string($conn,$_POST['desc']);
    
    $sql="INSERT INTO `booktb` (`bholdid`, `btitle`, `bisbn`, `bauth`, `bcourse`, `bsubject`, `bschool`, `bstate`, `bimg`, `bprice`, `bstock`, `bactive`, `bedition`, `bviews`, `bmajor`, `blocal`,`bdesc`) VALUES ('".$hold."', '".$title."', '".$isbn."', '".$auth."', '".$bcourse."', '".$sub."', '".$school."', '".$state."', '".$bimg."', '".$price."', '1', '1', '".$edi."', '2', '".$maj."', '".$local."', '".$desc."')";
    if ($holder->query($sql)){
        echo 'success';
    } else {
        echo 'error inserting to db';
    }
}

if(isset($_POST['fresh'])){
    $hold = $_POST['hid'];
    $holder->getMy($hold);
}

if(isset($_POST['edit'])&&$_POST['edit']=='edit'){
    $holdid = mysqli_real_escape_string($conn,$_POST['holdid']);
    $mail = mysqli_real_escape_string($conn,$_POST['mail']);
    $school = mysqli_real_escape_string($conn,$_POST['school']);
    $maj = mysqli_real_escape_string($conn,$_POST['major']);
    $desc = mysqli_real_escape_string($conn,$_POST['desc']);
    $local = mysqli_real_escape_string($conn,$_POST['local']);
    $num = mysqli_real_escape_string($conn,$_POST['num']);
    if($holder->updateHold($holdid,$mail,$school,$maj,$local,$desc,$num)){
        echo 'updated';
        
    } else {
        echo 'error updating';
    }
}












?>