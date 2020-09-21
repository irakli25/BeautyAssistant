$(document).ready(function (){
    control_buttons();
})

function control_buttons() {

    var url_string = window.location.href;
    var url = new URL(url_string);
    var uid = url.searchParams.get("uid");
    var order_id = url.searchParams.get("order_id");

    $.ajax({
        url:"server/call_control/call_control.php",
        data:{
            act:"get_buttons",
            uid:uid,
            order_id:order_id 
        },
        success:function(data){
            if(data.error !=""){
                webalert(data.error);
            }
            else {
                $(".control_buttons").html(data.html);
                if( $(".control_buttons").html()==''){
                    control_buttons();
                }
            }
            
        }
    })
}


