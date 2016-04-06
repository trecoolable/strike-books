$(document).ready(function() {
    
    var hid = $('#holdid').val();
     $('.addbut').click(function(e){
        $('body').append('<div class="blackout"></div>');
         $('.blackout').css({opacity:'0'});
            $('.blackout').animate({opacity:'.6'},200);
         $('body').append('<div class="interbox addinter"></div>');
         $('.interbox').html('<div class="contain">\
                <p class="intertext head interhead">Add Item</p>\
                <p class="intertext desc">Put a book out there for your campus to see.</p>\
                <input class="interput btitle" type="text" name="arse" placeholder="Title*" maxlength="60">\
                <input class="interput auth" type="text" placeholder="Author*" maxlength="32">\
                <input class="interput bisbn" type="text" placeholder="ISBN" maxlength="32">\
                <input class="interput edi" type="text" placeholder="Edition (if applicable)" maxlength="32">\
                <input class="interput course bcourse" type="text" placeholder="Course" maxlength="32">\
                <input class="interput sub bsub" type="text" placeholder="Subject (ie. Math)" maxlength="32">\
                <input class="interput tagadd" type="text" placeholder="Description (220 char)" maxlength="220">\
                <input class="interput bimg" type="text" placeholder="Image url (optional)" maxlength="100">\
<p class="signtext tiny"></p>\
                    <span class="intertext">$</span><input class="interput priceput" type="text" placeholder="Price*" maxlength="6">\
            <input type="button" class="mainbut upbut" value="Upload">\
            <div class="next add"></div>\
            </div>');
         //exit out of screen
         $('.blackout').click(function(e){
             $('.interbox').animate({top:'300', opacity:'0'},300);
            $('.blackout').animate({opacity:'0'},500);
             window.setTimeout(intermove, 700);
         });
                    
            $('.upbut').click(function(e){
                hid = $('#holdid').val();
                var title = $('.btitle').val();
                var desc = $('.tagadd').val();
                var auth = $('.auth').val();
                var bisbn = $('.bisbn').val();
                var edi = $('.edi').val();
                var bsub = $('.bsub').val();
                var bcourse = $('.bcourse').val();
                var tagadd = $('.tagadd').val();
                var bimg = $('.bimg').val();
                var price = $('.priceput').val();
                //alert(title);
                if(title!=''&&auth!=''&&price!=''){
                    //ajax to add book
                    $.ajax({
                        url: "/book/bookphp/loungehandle.php",
                        type: "post",
                        data: {badd:'add',hid:hid,btitle:title,auth:auth,bisbn:bisbn,edi:edi,bsub:bsub,bcourse:bcourse,bimg:bimg,price:price,desc:desc},
                        success: function(data){
                            if(data=='success'){
                                $('.interbox').animate({top:'300', opacity:'0'},300);
                                $('.blackout').animate({opacity:'0'},500);
                                //success, update current config
                                $.ajax({
                                    url: "/book/bookphp/loungehandle.php",
                                    type: "post",
                                    data: {fresh:'add',hid:hid},
                                    success: function(data){
                                        fresh();
                                    }
                                });
                                
                            } else {
                                 $('.tiny').text(data);
                                tinyalert();
                            }
                        }
                    });       
                } else {
                    $('.tiny').text('missing a required field');
                    tinyalert();
                } 
            });
         
         $('.interbox').css({top:'300px', opacity:'0'});
         $('.interbox').animate({top:'300px',opacity:'0'},300);
            $('.interbox').animate({top:'30px',opacity:'1'},400);
            
     });

    $('.edit').click(function(e){
        $('.credtext *').attr('contenteditable','true');
        $('.credtext *').css({background:'#E5C8F5'});
        $('.edit').addClass('save');
        $('.edit').val('Save info');
        $('.edit').removeClass('edit');
        $('.save').click(function(e){ //save to db
            $('.save').removeClass('save');
            var holdid = $('#holdid').val();
                var mail = $('.cmail').text();
                var school = $('.cschool').text();
                var major = $('.cmaj').text();
            var local = $('.clocal').text();
            var desc = $('.cdesc').text();
            var num = $('.cnum').text();
            $('.save').removeClass('edit');
            $.ajax({
                        url: "/book/bookphp/loungehandle.php",
                        type: "post",
                        data: {edit:'edit',mail:mail, school:school,major:major,local:local,desc:desc,num:num,holdid:holdid},
                        success: function(data){
                                //alert(data);
                            $('.credtext *').attr('contenteditable','false');
                            $('.credtext *').css({background:'#fff'});
                            $('.credbut').val('Saved');
                                }
                        });
        });
    });
    
    
        
    
    
    
    
    
    
    
    
    function fresh(){
        location.reload();
    }
    
    function intermove(){
        $('.blackout').remove();
             $('.interbox').remove();
    }
    
    
             
    
    
    
    
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