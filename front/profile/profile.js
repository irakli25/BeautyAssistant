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
            var district_multi      =   new multiSelect("district_multi","district","id","name","1550px");
            var experince           =   new multiSelect("experience","experience","id","name","1550px");
            var val = "";
            $(".datepicker").kendoDatePicker({
                culture: "ka-GE",
                format: "yyyy-MM-dd",
                value: $("#hidden_birth").val(),
                animation: {
                 close: {
                   effects: "fadeOut zoom:out",
                   duration: 300
                 },
                 open: {
                   effects: "fadeIn zoom:in",
                   duration: 300
                 }
                }
              });
              
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


$(document).on("click", ".edit", function(){
    
    var id = $(this).attr("target");
    val = $(`#${id}`).val();

    if (id == "birthday"){
        var datepicker = $(`#${id}`).data("kendoDatePicker");
        datepicker.readonly(false);
        $(`#${id}`).val('');
        $(`#${id}`).focus();
    }
    else {
        $(`#${id}`).prop("readonly",false);
        $(`#${id}`).val('');
        $(`#${id}`).focus();
    }

        $(`.edit[target="${id}"]`).hide();
        $(`.done[target="${id}"]`).show();
    
    
    
})




$(document).on("click", ".done", function(){
    
    var id = $(this).attr("target");


    

    if (id == "birthday"){
        var datepicker = $(`#${id}`).data("kendoDatePicker");
        datepicker.readonly(true);

    }
    else {
        $(`#${id}`).prop("readonly",true);

    }

        if($(`#${id}`).val().replace(/\s/g, '') != ''){

            $.ajax({
                url:"server/profile/profile.php",
                data:{
                    act:"update_user",
                    id:id,
                    value:$(`#${id}`).val()
                },
                success:function(data){
                    $(`.done[target="${id}"]`).hide();
                    $(`.edit[target="${id}"]`).show();
                }
            })
        }
        else{
            $(`#${id}`).val(val);
            $(`.done[target="${id}"]`).hide();
            $(`.edit[target="${id}"]`).show();
        }
    
    
    
    
})

$(document).on("click",".add", function(){
    var number = $(this).parent().children('input').val();
    if(number.length == 9){
        $.ajax({
            url:"server/profile/profile.php",
            data:{
                act:"add_phone",
                number:number
            },
            success:function(){
                update_phones ();
            }
        })
    }
    else{
        webalert("არასწორი ფორმატი !");
    }
    
})

$(document).on("click",".delete", function(){
    var id = $(this).attr('row_id');
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"delete_phone",
            id:id
        },
        success:function(){
            update_phones ();
        }
    })
    
})


function update_phones () {
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_phones"
        },
        success:function(data){
            $(".phone-grid").html(data.result);
        }
    })
}



$(document).on("click","#up_pic_port", function(){
    $("#uploader").trigger("click");
})


$(document).on('change', "#uploader", function() {
    var file_data = $('#uploader').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
                                
    $.ajax({
        url: 'server/upload.php',   
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,                         
        success: function(data){
            $.ajax({
                url:"server/profile/profile.php",
                data:{
                    act:"save_portfolio",
                    id:data.id
                },
                success:function(data){
                    $(".portfolio_wrap").html(data.html);
                }
            })
        }
     });
});



$(document).on("change","#district_multi", function (){
    var ids = $(this).val();
    update_district(ids);


})


function update_district(ids){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_district",
            ids:ids
        },
        success:function(data){
            if(data.error = "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
}




