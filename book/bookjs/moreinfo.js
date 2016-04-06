$(document).ready(function() {
    
    var event = 0;
     $('.nextstripe').click(function(e){
         $('.next').removeClass('.nextstripe');
         $('.next').addClass('.almostbut');
         if(event==0){
             event++;
             $('.container').animate({opacity:'1'},90);
             $('.container').animate({left:'-300px', opacity:'0'},300);
             $('.infobox').animate({top:'90px'},420);
             $('.infobox').animate({top:'50px'},500);
             $('.infobox').animate({height:'350px'},320);
             $('.infobox').animate({height:'460px'},400);
             $('.infobox').animate({width:'450px'},400);
             $('.container').animate({left:'0px',opacity:'0'},500);
             window.setTimeout(change, 500);
             $('.container').animate({opacity:'1'},200);
         }
     });
             
    
    
    
    
    var stateselect = '<select class="infoput infostate" name="state" placeholder="Select State">\
<option value="nostate">Select State</option>\
<option value="AL">Alabama</option>\
<option value="AK">Alaska</option>\
<option value="AZ">Arizona</option>\
<option value="AR">Arkansas</option>\
<option value="CA">California</option>\
<option value="CO">Colorado</option>\
<option value="CT">Connecticut</option>\
<option value="DE">Delaware</option>\
<option value="FL">Florida</option>\
<option value="GA">Georgia</option>\
<option value="HI">Hawaii</option>\
<option value="ID">Idaho</option>\
<option value="IL">Illinois</option>\
<option value="IN">Indiana</option>\
<option value="IA">Iowa</option>\
<option value="KS">Kansas</option>\
<option value="KY">Kentucky</option>\
<option value="LA">Louisiana</option>\
<option value="ME">Maine</option>\
<option value="MD">Maryland</option>\
<option value="MA">Massachusetts</option>\
<option value="MI">Michigan</option>\
<option value="MN">Minnesota</option>\
<option value="MS">Mississippi</option>\
<option value="MO">Missouri</option>\
<option value="MT">Montana</option>\
<option value="NE">Nebraska</option>\
<option value="NV">Nevada</option>\
<option value="NH">New Hampshire</option>\
<option value="NJ">New Jersey</option>\
<option value="NM">New Mexico</option>\
<option value="NY">New York</option>\
<option value="NC">North Carolina</option>\
<option value="ND">North Dakota</option>\
<option value="OH">Ohio</option>\
<option value="OK">Oklahoma</option>\
<option value="OR">Oregon</option>\
<option value="PA">Pennsylvania</option>\
<option value="RI">Rhode Island</option>\
<option value="SC">South Carolina</option>\
<option value="SD">South Dakota</option>\
<option value="TN">Tennessee</option>\
<option value="TX">Texas</option>\
<option value="UT">Utah</option>\
<option value="VT">Vermont</option>\
<option value="VA">Virginia</option>\
<option value="WA">Washington</option>\
<option value="WV">West Virginia</option>\
<option value="WI">Wisconsin</option>\
<option value="WY">Wyoming</option>\
</select>';
    
      function change(){
          $('.container').html('<p class="infotext head">Basic Info</p>\
                <p class="infotext desc">To help us find you more customers we would like to connect you to other students\
            on or near your College or University. We suggest you sell from your dorm but any location on campus is just fine.</p>\
            <input class="infoput infocoll" type="text" placeholder="College or Universiy (full name)" maxlength="32">\
            '+stateselect+'\
            <input class="infoput infolocal" type="text" placeholder="Location (preferrably your dorm room)" maxlength="32">\
            <input class="infoput infomajor" type="text" placeholder="Major (no abbreviations) *optional" maxlength="32">');
          $('.next').click(function(e){
            if(event==1){
                var coll = $('.infocoll').val();
                var hid = $('#holdid').val();
                var state = $('.infostate').val();
                var local = $('.infolocal').val();
                var major = $('.infomajor').val();
                if(coll!=''&&state!='nostate'&&local!=''){
                    $.ajax({
                        url: "/book/bookphp/signuphandle.php",
                        type: "post",
                        data: {hid:hid,coll:coll,state:state,local:local,major:major},                   
                        success: function(data){
                                        $('.tiny').text(data);
                                        tinyalert();
                                        if(data=='success'){
                                            event++;
                                            $('.container').animate({opacity:'1'},90);
                                             $('.container').animate({left:'-300px', opacity:'0'},300);
                                             $('.infobox').animate({top:'50px'},420);
                                             $('.infobox').animate({top:'90px'},500);
                                             $('.infobox').animate({height:'460px'},320);
                                             $('.infobox').animate({height:'260px'},400);
                                             $('.infobox').animate({width:'450px'},400);
                                             $('.container').animate({left:'0px',opacity:'0'},400);
                                             window.setTimeout(change2, 700);
                                             $('.container').animate({opacity:'1'},200);
                                        }
                                        
                                    }
                        });
                } else {
                    $('.tiny').text('one or more required fields are blank');
                    tinyalert();
                }
            }
          //end click event
          });
      }
    
    function change2(){
        $('.next').remove();
        $('.infobox').html('<p class="infotext head">Congratulations!</p>\
                <p class="infotext desc bg">You have just joined the forthcoming force in University textbook distribution.\
                 You\'re also part of the group of students who will actually make some smart money in college.  So pat yourself on the\
                back and make sure you tell your friends that you are now selling on Strike!</p>\
            <input class="infobut next done" type="button" value="Get me in!">');
        $('.next').click(function(e){
            if(event==2){
                $('.infobox').css({overflow:'hidden'});
                                             $('.infobox').animate({top:'90px'},220);
                                             $('.infobox').animate({top:'30px'},250);
                $('.infobox').animate({top:'30px'},100);
                $('.infobox').animate({top:'500px',opacity:'0'},400);
                                             $('.infobox').animate({height:'20px'},100);
                                             $('.container').animate({left:'0px',opacity:'0'},400);
                                             window.setTimeout(exit, 1200);
                
            }
        });
        
        function exit(){
            location.href = 'userslounge.php';
        }
        
        
        
    }
    
    
    
    
    
    
    
    function tinyalert(){
        $('.tiny').css({right:'50px', opacity:'0'});
        $('.tiny').animate({left:'50px', opacity:'1'},100);
        $('.tiny').animate({right:'20px'},60);
        $('.tiny').animate({left:'20px'},60);
        $('.tiny').animate({right:'10px'},60);
        $('.tiny').animate({left:'10px'},60);
        $('.tiny').animate({right:'5px'},60);
    }
    
    
    
    
});