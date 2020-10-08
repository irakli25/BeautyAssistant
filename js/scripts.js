$.ajaxSetup({
    dataType:"json",
    type:'POST'
  });
  var url_string = window.location.href;
  var DIR = url_string.slice(0,url_string.indexOf('?'));
// scroll
  $(document).ready(function() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var route = url.searchParams.get("route");

    getLocation();

    $(`a[href='?route=${route}']`).parent().addClass("active_menu");


    var lastScrollTop = 0;
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st > lastScrollTop){
            $(".header1").addClass("up");
            $(".dropdown-content").hide();
        } else {
            $(".header1").removeClass("up");
            $(".dropdown-content").show();
        }
        lastScrollTop = st;
    });
    $('select').selectric();
    

setTimeout(() => {
    GetDate("birthday");
    GetDateTimes("order_time");
}, 1000);
  });
// scroll
$(document).on("click",".closebtn",function (){
    $(this).parent().css("display","none");
})

$(document).on("click","#close_order_window",function (){
    $("#order_window").css("display","none");
})

$(document).on("click","#id01", function (e){
    if (e.target !== this)
        return;
    $(this).css("display","none");
})

$(document).on("click","#order_window", function (e){
    if (e.target !== this)
        return;
    $(this).css("display","none");
})

$(document).on("click","#login, #login_mobile", function (){
    $(".container-hamburger").trigger("click");
    $("#id01").css("display","block");
})

$(document).on("click", ".beauty_logo", function () {
    window.location="?route=1";
})

$(document).on("click", "#need-job", function () {
    window.location="?route=2";
})

$(document).on("click", "#need-assistant", function () {
    window.location="?route=3";
})
class userlogin {
    constructor(){
        this.email = $("#login_email").val();
        this.pass  = $("#login_pass").val();
        this.sendAjax();
    }

    sendAjax(){
        $.ajax({
            url:"server/login.php",
            data:this,
            success:function(data){
                if(data.Error != ""){
                    webalert(data.Error,"alert");
                }
                else{
                    if(data.result){
                        window.location="?route=1";
                    }
                    else{
                        webalert(data.result,"alert");
                    }
            }
            }
        })
    }
}
class person {
        
    constructor(type){
        this.name = $("#name").val();
        this.surname = $("#surname").val();
        this.email = $("#email").val();
        this.pass = $("#pass").val();
        this.conpass = $("#conpass").val();
        this.type = type;
    }

    confirm () {
        if  (this.conpass == this.pass) {
            return true;
        }
        else{
            webalert("პაროლები ერთმანეთს არ დაემთხვა !", "alert");
        }
    }

    check_name(){
        if(this.name != ""){
            $("#name").css("border-color","#ccc");
            return true;
        }
        else {
            $("#name").css("border-color","red");
            webalert("შეავსეთ ყველა ველი !");
            return false;
        }
    }

    check_surname(){
        if(this.surname != ""){
            $("#surname").css("border-color","#ccc");
            return true;
        }
        else {
            $("#surname").css("border-color","red");
            webalert("შეავსეთ ყველა ველი !");
            return false;
        }
    }

    check_email(){
        if(this.email != ""){
            $("#email").css("border-color","#ccc");
            return true;
        }
        else {
            $("#email").css("border-color","red");
            webalert("შეავსეთ ყველა ველი !");
            return false;
        }
    }

    check_pass(){
        if(this.pass != ""){
            $("#pass").css("border-color","#ccc");
            return true;
        }
        else {
            $("#pass").css("border-color","red");
            webalert("შეავსეთ ყველა ველი !");
            return false;
        }
    }

    check_conpass(){
        if(this.conpass != ""){
            $("#conpass").css("border-color","#ccc");
            return true;
        }
        else {
            $("#conpass").css("border-color","red");
            webalert("შეავსეთ ყველა ველი !");
            return false;
        }
    }



    sendAjax () {
        if(this.check_name() && this.check_surname() && this.check_email()  && this.check_pass() && this.check_conpass() && this.confirm()){
            $.ajax({
                url:"server/register.php",
                data:this,
                success:function(data){
                    if(data.Error !=''){
                        webalert(data.Error,"alert");
                    }
                    else {
                        if(data.result){
                            var  mail = new Mail(data.email,"ელფოსტის დადასტურება",mailhtml(data.email,data.name));
                            mail.send();
                            webalert(`${data.name} თქვენ წარმატებით გაიარეთ რეგისტრაცია`,"success");
                            setTimeout(() => {
                                window.location = "?route=1";
                            }, 1000);
                       
                        }
                    }
                }
        
            })
        }

    }

}

$(document).on("click","#register_client", function(){
    var client = new person('2');
    client.sendAjax();

})


$(document).on("click","#register_staff", function(){
    var client = new person('1');
    client.sendAjax();

})



function webalert(content, type){
    color = '';
    switch (type){
        case 'success' : color = "#008000"; break;
        case 'alert' : color = "#FF8800"; break;
        case 'error' : color = "#fa4033"; break;
        default : color = "#FF8800"; 
    }

    var i = Math.random().toFixed(3) * 1000;
  

    $(".alert_wrapper").append(`<div class="alert error_${i}"><span>${content}</span><span class="closebtn" >&times;</span></div>`);
        $(".error_"+i).css("background",color);
        $(".error_"+i).css("display","block");
        setTimeout(() => {
            $(".error_"+i).css("display","none");
        }, 5000);

   
}

function mailhtml(email,name){
    return `
    <p>გამარჯობა ${name},</p>
    <p>რეგისტრაციის დასრულების შემდეგ გადახვალთ პროფილის გვერდზე, იმისთვის რომ ისარგებლოთ პლათფორმით უნდა შეავსოთ ინფორმაცია თქვენს შესახებ </p>
    <p>რეგისტრაციის დასასრულებლად დააჭირე ღილაკს</p>
    <a href='${DIR}server/authentication.php?email=${email}'>
    <button
    style="border-radius: 5px;
    background-color: #f5577b;
    border: 1px solid transparent;
    padding: 7px;
    color: #FFF;
    margin-left: 5%;
    cursor: pointer;"
    >რეგისტრაციის დასრულება</button></a>
    
    
    `;
}



$(document).on("click","#login_button", function(){
    var login = new userlogin();
})

$(document).on("click","#logout", function(){
    $.ajax({
        url:"server/logout.php",
        success:function(data){
            if(data.Error !=''){
                webalert(data.Error,"alert");
            }
            else {
                if(data.result == "logout"){
                    window.location="?route=1";
                }
            }
        }

    })
})


class Mail {
    constructor(mail,subject,html){
        this.mail = mail;
        this.subject = subject;
        this.html = html + this.signature();
    }
    send(){
        $.ajax({
            url:"server/mailsender.php",
            data:this,
            success:function(data){
              
            }

        })
    }
     signature(){

        return `<br><br><hr> <table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr><td style="vertical-align: middle;"><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr><td><h3 color="#000000" class="sc-fBuWsC eeihxG" style="margin: 0px; font-size: 18px; color: rgb(0, 0, 0);"><span>BeautyAssistant</span><span>&nbsp;</span><span></span></h3><p color="#000000" font-size="medium" class="sc-fMiknA bxZCMx" style="margin: 0px; color: rgb(0, 0, 0); font-size: 14px; line-height: 22px;"><span>Your beauty assistant</span></p></td><td width="15"><div></div></td><td color="#F2547D" direction="vertical" width="1" class="sc-jhAzac hmXDXQ" style="width: 1px; border-bottom: none; border-left: 1px solid rgb(242, 84, 125);"></td><td width="15"><div></div></td><td><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr height="25" style="vertical-align: middle;"><td width="30" style="vertical-align: middle;"><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr><td style="vertical-align: bottom;"><span color="#F2547D" width="11" class="sc-jlyJG bbyJzT" style="display: block; background-color: rgb(242, 84, 125);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/phone-icon-2x.png" color="#F2547D" width="13" class="sc-iRbamj blSEcj" style="display: block; background-color: rgb(242, 84, 125);"></span></td></tr></tbody></table></td><td style="padding: 0px; color: rgb(0, 0, 0);"><a href="tel:557 12 34 56" color="#000000" class="sc-gipzik iyhjGb" style="text-decoration: none; color: rgb(0, 0, 0); font-size: 12px;"><span>557 12 34 56</span></a> | <a href="tel:577 78 45 12" color="#000000" class="sc-gipzik iyhjGb" style="text-decoration: none; color: rgb(0, 0, 0); font-size: 12px;"><span>577 78 45 12</span></a></td></tr><tr height="25" style="vertical-align: middle;"><td width="30" style="vertical-align: middle;"><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr><td style="vertical-align: bottom;"><span color="#F2547D" width="11" class="sc-jlyJG bbyJzT" style="display: block; background-color: rgb(242, 84, 125);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/email-icon-2x.png" color="#F2547D" width="13" class="sc-iRbamj blSEcj" style="display: block; background-color: rgb(242, 84, 125);"></span></td></tr></tbody></table></td><td style="padding: 0px;"><a href="mailto:beautyassistantgeorgia@gmail.com" color="#000000" class="sc-gipzik iyhjGb" style="text-decoration: none; color: rgb(0, 0, 0); font-size: 12px;"><span>beautyassistantgeorgia@gmail.com</span></a></td></tr><tr height="25" style="vertical-align: middle;"><td width="30" style="vertical-align: middle;"><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;"><tbody><tr><td style="vertical-align: bottom;"><span color="#F2547D" width="11" class="sc-jlyJG bbyJzT" style="display: block; background-color: rgb(242, 84, 125);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/link-icon-2x.png" color="#F2547D" width="13" class="sc-iRbamj blSEcj" style="display: block; background-color: rgb(242, 84, 125);"></span></td></tr></tbody></table></td><td style="padding: 0px;"><a href="//www.beautyassistant.ge" color="#000000" class="sc-gipzik iyhjGb" style="text-decoration: none; color: rgb(0, 0, 0); font-size: 12px;"><span>www.beautyassistant.ge</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td height="30"></td></tr><tr><td color="#F2547D" direction="horizontal" height="1" class="sc-jhAzac hmXDXQ" style="width: 100%; border-bottom: 1px solid rgb(242, 84, 125); border-left: none; display: block;"></td></tr><tr><td height="30"></td></tr><tr><td><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial; width: 100%;"><tbody><tr><td style="text-align: right; vertical-align: top;"><table cellpadding="0" cellspacing="0" class="sc-gPEVay eQYmiW" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial; display: inline-block;"><tbody><tr style="text-align: right;"><td><a href="//vdfvdv" color="var(--main-color)" class="sc-hzDkRC kpsoyz" style="display: inline-block; padding: 0px; background-color: rgb(106, 120, 209);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/facebook-icon-2x.png" alt="facebook" color="var(--main-color)" height="24" class="sc-bRBYWo ccSRck" style="background-color: rgb(106, 120, 209); max-width: 135px; display: block;"></a></td><td width="5"><div></div></td><td><a href="//vdfv" color="var(--main-color)" class="sc-hzDkRC kpsoyz" style="display: inline-block; padding: 0px; background-color: rgb(106, 120, 209);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/twitter-icon-2x.png" alt="twitter" color="var(--main-color)" height="24" class="sc-bRBYWo ccSRck" style="background-color: rgb(106, 120, 209); max-width: 135px; display: block;"></a></td><td width="5"><div></div></td><td><a href="//vfdvdfv" color="var(--main-color)" class="sc-hzDkRC kpsoyz" style="display: inline-block; padding: 0px; background-color: rgb(106, 120, 209);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/linkedin-icon-2x.png" alt="linkedin" color="var(--main-color)" height="24" class="sc-bRBYWo ccSRck" style="background-color: rgb(106, 120, 209); max-width: 135px; display: block;"></a></td><td width="5"><div></div></td><td><a href="//vfdvdv" color="var(--main-color)" class="sc-hzDkRC kpsoyz" style="display: inline-block; padding: 0px; background-color: rgb(106, 120, 209);"><img src="https://cdn2.hubspot.net/hubfs/53/tools/email-signature-generator/icons/instagram-icon-2x.png" alt="instagram" color="var(--main-color)" height="24" class="sc-bRBYWo ccSRck" style="background-color: rgb(106, 120, 209); max-width: 135px; display: block;"></a></td><td width="5"><div></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td height="30"></td></tr><tr><td style="text-align: center;"></td></tr></tbody></table>`
                ;
      }
}



function setCookie(cname, cvalue, exdays = 1) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }





  function get_order_price(){
    var profile = "";
    if(isNaN(Number($("#profile_id").val()))){
        profile = $("#calc_profiles").val();
    }
    else{
        profile = Number($("#profile_id").val());
    }
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"get_price",
            exp:($("#calc_experience").val() == '' ? getCookie("calc_price") : $("#calc_experience").val()),
            profile:profile
        },
        success:function(data){
            var p = data.price;
            var price = Number(p).toFixed(2);
            $("#get_price").html(`<span>${price}</span><div class="lari"></div>`);
            setCookie("calc_price",price);
        }
    })
  }


  function get_order_experience(){
      $.ajax({
          url:"server/server.php",
          data:{
              exps:getCookie("calc_experience"),
              act:"get_products"
          },
          success:function(data){
              $("#get_service").html(data.products);
          }
      })
  }



  $(document).on("click","#order_done_button",function(){
      var obj = new Object();
      obj.act = "save_order";
      obj.assistant = $("#get_assistant").attr("user_id");
      obj.products = $("#calc_experience").val();
      obj.district = $("#order_district").val();
      obj.street = $("#order_street").val();
      obj.address = $("#order_corect_address").val();
      obj.order_time = $("#order_time").val(),
      $.ajax({
          url:"server/server.php",
          data:obj,
          success:function(data){
            if(data.error != "")
                webalert(data.error);
            else {
                $("#order_window").css("display","none");
                var  mail = new Mail(data.user_email,`New Order - ${data.id}`,data.user_email_text);
                mail.send();
                var  mail = new Mail(data.assistant_email,`New Order - ${data.id}`,`${data.assistan_email_text} ${data.link}`);
                mail.send();
            }
          }
          
      })
  })



$(document).on("click", ".control_buttons button", function(){
    var url_string = window.location.href;
    var url = new URL(url_string);
    var uid = url.searchParams.get("uid");
    var order_id = url.searchParams.get("order_id");
    var status = $(this).attr("status");
    $.ajax({
        url:"server/call_control/call_control.php",
        data:{
            act:"control_buttons",
            uid:uid,
            order_id:order_id,
            status:status 
        },
        success:function(data){
            control_buttons();
            var  mail = new Mail(data.user_email,`Order - ${data.id}`,data.text);
            mail.send();
        }
    })
})


$(document).on("click", "#close_menu", function(){
    $(".header2").removeClass("open_menu");
})

$(document).on("click", "#menu", function(){
    $(".header2").addClass("open_menu");
})


$(document).on("keyup", ".loginContainer .register_in", function(e){
    if(e.keyCode == 13){
        $("#login_button").click();
    }
})

$(document).on("keyup", ".client_form .register_in", function(e){
    if(e.keyCode == 13){
        $("#register_client").click();
    }
})

$(document).on("keyup", ".staff_form .register_in", function(e){
    if(e.keyCode == 13){
        $("#register_staff").click();
    }
})



function GetDate(name) {
    $("#" + name).datepicker({
    	changeMonth: true,
        changeYear: true,
        yearRange: "-70:-0"
    });

    var date = $("#" + name).val();

    $("#" + name).datepicker("option", $.datepicker.regional["ka"]);
    $("#" + name).datepicker("option", "dateFormat", "yy-mm-dd");
    $("#" + name).datepicker( "setDate", date );

}


function GetDateTimes(name) {
    $("#" + name).datetimepicker({
    	dateFormat: "yy-mm-dd"

    });
    $("#" + name).datepicker("option", $.datepicker.regional["ka"]);
    $("#" + name).datepicker("option", "dateFormat", "yy-mm-dd");

}




  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
      webalert("Geolocation is not supported by this browser", "error");
    }
  }




function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        webalert("User denied the request for Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        webalert("Location information is unavailable.");
        break;
      case error.TIMEOUT:
        webalert("The request to get user location timed out.");
        break;
      case error.UNKNOWN_ERROR:
        webalert("An unknown error occurred.");
        break;
    }
  }


function showPosition(position) {
  
  $("#map").html(`<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?width=100%&amp;height=300&amp;hl=ka&amp;mrt=loc&amp;q=${position.coords.latitude},${position.coords.longitude}&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>`);
}
