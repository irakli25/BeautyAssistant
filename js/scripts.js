$.ajaxSetup({
    dataType:"json",
    type:'POST'
  });

$(document).on("click",".closebtn",function (){
    $(this).parent().css("display","none");
})

$(document).on("click","#id01", function (e){
    if (e.target !== this)
        return;
    $(this).css("display","none");
})

$(document).on("click","#login", function (){
    $("#id01").css("display","block");
})

$(document).on("click", "#need-job", function () {
    window.location="?pg=2";
})

$(document).on("click", "#need-assistant", function () {
    window.location="?pg=3";
})

class person {
        
    constructor(type){
        this.name = $("#name").val();
        this.email = $("#email").val();
        this.pass = $("#pass").val();
        this.conpass = $("#conpass").val();
        this.action = type;
    }
}

$(document).on("click","#register_client", function(){
    var client = new person('11');
    $.ajax({
        url:"server/register.php",
        data:client,
        success:function(data){
            if(data.Error !=''){
                webalert(data.Error,"alert");
            }
        }

    })
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

   
}