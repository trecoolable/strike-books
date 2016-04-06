$(document).ready(function() {
    
    var newer = false;
    $('.login').click(function(e){
        var mail = $('.signmail').val();
        var pass = $('.signpass').val();
        if(!newer&&mail!=''&&pass!=''){
            $.ajax({
                url: "/book/bookphp/signuphandle.php",
                type: "post",
                data: {sub:'sub',mail:mail, pass:pass},                   
                success: function(data){
                                if(data=='signed in'&&newer!=true){
                                    location.href = 'userslounge.php';
                                } else {
                                    $('.tiny').text(data);
                                    tinyalert();
                                }
                            }
                });
        } else {
            $('.tiny').text('email or password is blank');
            tinyalert();
        }
    //end of submit event
    });
    
    $('.signup').click(function(e){
        newer = true;
        $('.ext').html('<input class="signput signrepass" type="password" placeholder="Confirm Password" maxlength="32">');
        $('.signup').animate({left:'300' , opacity:'0'}, 250);
        $(".subbut").val('Sign Up');
        $('.subbut').animate({bottom:'10'}, 300);
        $('.signrepass').css({left:'400px', opacity:'0'});
        $('.signrepass').animate({left:'4%' , opacity:'1'},300);
        $('.signrepass').animate({left:'7.2%' , opacity:'1'},100);
        $('.signrepass').animate({left:'4.5%' , opacity:'1'},90);;
        $('.signrepass').animate({left:'6.8%' , opacity:'1'},80);
        $('.signrepass').animate({left:'5%' , opacity:'1'},70);
        $('.signrepass').animate({left:'6.6%' , opacity:'1'},60);
        $('.signrepass').animate({left:'6.4%' , opacity:'1'},50);
        $('.subbut').addClass('newer');
        $('.subbut').removeClass('login');
        //submit new data
        $('.newer').click(function(e){
            var mail = $('.signmail').val();
            var pass = $('.signpass').val();
            var repass = $('.signrepass').val();
            if(repass!==pass&&mail!=''&&pass!=''){
                $('.tiny').text('passwords do not match');
                tinyalert();
            } else {
                $.ajax({
                    url: "/book/bookphp/signuphandle.php",
                    type: "post",
                    data: {nsub:'nsub',mail:mail, pass:pass, repass:repass},                   
                    success: function(data){
                                    if(data!='error'&&newer==true){
                                        location.href = 'signup.php?newid='+data;
                                        //alert(data);
                                    } else {
                                        $('.tiny').text(data);
                                       tinyalert(); 
                                    }
                                }
                    });
            }
        //end of submit event
        });  
    });
    
    
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