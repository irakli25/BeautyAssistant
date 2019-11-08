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
            $( "#tabs" ).tabs();
            $( "#tabs" ).tabs({ active: 0 });
            var district              =   new filter("district","district","id","name");
            var street                =   new filter("street","street","id","name");
            var hear                =   new filter("hear","street","id","name");
            var skin                =   new filter("skin","street","id","name");
            var district_multi      =   new multiSelect("district_multi","street","id","name","1550px");
        
        }
    })
})





class filter {
    constructor(select_id, table,id, list, width = "300px"){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.send();
    }
    send(){
        $.ajax({
        url:"server/filters/filter.php",
        data:this,
        type:"GET",
        success:function(data){
            $("#"+data.element_id).parent().html(data.page);
        }
    })
    }
}


class multiSelect {
    constructor(select_id, table,id, list, width = "300px"){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.send();
    }
    send(){
        $.ajax({
        url:"server/filters/multiple.php",
        data:this,
        type:"GET",
        success:function(data){
            $("#"+data.element_id).parent().html(data.page);
        }
    })
    }
}

$(document).on("click","li[role='tab']",function(){
    $(this).children('a').click();
})
