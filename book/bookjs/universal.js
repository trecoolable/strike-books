$(document).ready(function() {
    
    var event = 0;
    var ikey = 'btitle';
    var input;
    var state = $('.statein').attr("val");
    var school = $('.schoolin').attr("val");
     $('.bookput').click(function(e){
         
         if(event==0){
             event++;
             //$('.topper').addClass('topsearch');
         $('.mainbar').animate({height:'97px'},400);
         $('.bookput').animate({top:'7px',height:'40px'},300);
         $('.bookput').addClass('bg');
             $('.unitext').addClass('md');
         $('.barcn').append('<div class="barcn bottomcn">\
                <p class="inop s1">Search by: </p>\
            <p class="barop optin" val="btitle">Title</p>\
            <p class="barop" val="bauth">Author</p>\
            <p class="barop" val="bisbn">ISBN</p>\
            <p class="barop" val="btag">Keyword</p>\
            <p class="barop" val="bsubject">Subject</p>\
            <p class="barop" val="bcourse">Course</p>\
            <p class="barop" val="bmajor">Major</p>\
            </div>');
         
         
             $('.barop').click(function(e){
                $('.optin').removeClass('optin'); 
                $(this).addClass('optin');
                 key = $('.optin').attr("val");
                input = $('.bookput').val();
                getSearch(input,key,state,school);
            });
             closeBar();
         }
     });     
    
    $('.bookput').keyup(function(e){
        key = $('.optin').attr("val");
        input = $('.bookput').val();
        $('.head').text('Search: '+input);
        getSearch(input,key,state,school);
    });
    getRec();
    
    
    
    
    function getRec(){
        $('.recbox').click(function(e){
            var bookid = $(this).closest(".recbox").find(".bookid").val();
            var hid = $('#holdid').val();
            if(typeof bookid!=='undefined'){
                $.ajax({
                            url: "/book/bookphp/searchhandle.php",
                            type: "post",
                            data: {search:'look',look:'look',bookid:bookid,holdid:hid},          
                            success: function(data){
                                //$('.maincontain').html(data);
                                $('body').append('<div class="blackout"></div>');
                                 $('.blackout').css({opacity:'0'});
                                    $('.blackout').animate({opacity:'.6'},300);
                                 $('body').append('<div class="interbox bookinter"></div>');
                                 $('.interbox').html(data);
                                
                                $('.delbut').click(function(e){
                                            $.ajax({
                                    url: "/book/bookphp/searchhandle.php",
                                    type: "post",
                                    data: {del:'del',bookid:bookid},          
                                    success: function(data){
                                            if(data === 'deleted'){
                                                location.reload();
                                            }
                                        }
                                    });
                                });
                                
                                 //exit out of screen
                                 $('.blackout').click(function(e){
                                     $('.interbox').animate({top:'300', opacity:'0'},300);
                                    $('.blackout').animate({opacity:'0'},500);
                                     window.setTimeout(intermove, 700);
                                 });
                                $('.interbox').css({top:'-300px', opacity:'0'});
                                 $('.interbox').animate({top:'-300px',opacity:'0'},300);
                                    $('.interbox').animate({top:'30px',opacity:'1'},400);
                                //alert(data);
                                stripeHandle();
                                
                                
                                
                                
                                
                                
                                
                                
                            }
                        });
            }
        });
    }
    
    function stripeHandle(){
        //alert(price);
        var title;
        var price;
        var holder;
        var bookid
        var handler = StripeCheckout.configure({
        key: 'pk_test_k0UFG0kwuLVVYpNd31bHTA6k',
        locale: 'auto',
        token: function(token) {
          // Use the token to create the charge with a server-side script.
          // You can access the token ID with `token.id`
            //go to ajax with token id
            var booktoken = token.id;
            //alert(booktoken+holder);
            $.ajax({
                url: "/book/bookphp/searchhandle.php",
                type: "post",
                data: {pay:'pay',booktoken:booktoken,price:price,holder:holder,bookid:bookid},          
                success: function(data){
                    alert(data);
                    alert(booktoken+holder);
                }
            });
            alert(booktoken+holder);
            
        }
      });

      $('.getbut').click(function(e) {
        // Open Checkout with further options
           title = $(this).closest(".contain").find(".bititle").text();
           price = ($(this).closest(".contain").find(".bipricein").val())*100;
           holder = ($(this).closest(".contain").find(".biholdin").val());
          bookid = ($(this).closest(".contain").find(".bibookin").val());
        handler.open({
          name: title,
          description: 'from Strike Books',
          amount: price
        });
        e.preventDefault();
      });

      // Close Checkout on page navigation
      $(window).on('popstate', function() {
        handler.close();
      });
    }
    
    
    
    
    function intermove(){
        $('.blackout').remove();
             $('.interbox').remove();
    }
    
    function getSearch(input,ikey,state,school){
        if(input!=''){
                $.ajax({
                    url: "/book/bookphp/searchhandle.php",
                    type: "post",
                    data: {search:'search',input:input,ikey:ikey,state:state,school:school},          
                    success: function(data){
                        $('.maincontain').html(data);
                        getRec();
                    }
                });
        }
    }
 
    function closeBar(){
        $(document).click(function(e) {
                if ($(e.target).is('.mainbar, .mainbar *')&&event==1) {
                    
                }
                else {
                    $('.mainbar').animate({height:'37px'},300);
                     $('.bookput').animate({top:'0px',height:'27px'},300);
                     $('.bookput').removeClass('bg');
                         $('.unitext').removeClass('md');
                     $('.bottomcn').remove();
                    event = 0;
                    event.stopPropagation();
                }
            });
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