$(document).ready(function ()

{

    var url_string = window.location.href;
    var url = new URL(url_string);
    var uid = url.searchParams.get("uid");
    $.ajax({
        dataType:"html",
        url:`server/profile/processing.php?uid=${uid}`,
        success:function(data){
            $("#profile_wrapper").html(data);
        }
    })
})