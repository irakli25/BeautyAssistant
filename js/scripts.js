$.ajaxSetup({
    dataType:"json",
    type:'POST'
  });

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

$(document).on("click","#login", function (){
    $(".container-hamburger").trigger("click");
    $("#id01").css("display","block");
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
        if(this.name != ""){
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
                            var  mail = new Mail(data.email,"Email authentication",html(data.email,data.name));
                            mail.send();
                            webalert(`${data.name} თქვენ წარმატებით გაიარეთ რეგისტრაცია`,"success");
                            location.href = "https://beautyassistant.herokuapp.com";
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
        case 'error' : color = "#f44336"; break;
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

function html(email,name){
    return `
    <p>გამარჯობა ${name},</p>
    <p>რეგისტრაციის დასასრულებლად დააჭირე ღილაკს</p>
    <a href='https://beautyassistant.herokuapp.com/server/authentication.php?email=${email}'>
    <button
    style="border-radius: 5px;
    background-color: #d015ed;
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
                    location.reload(true);
                }
            }
        }

    })
})


class Mail {
    constructor(mail,subject,html){
        this.mail = mail;
        this.subject = subject;
        this.html = html;
    }
    send(){
        $.ajax({
            url:"server/mailsender.php",
            data:this

        })
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


  $(document).on("click","#order_button", function(){
    //   get_order_price();
    //   get_order_experience();
    $("#order_window").css("display","block");
  })

