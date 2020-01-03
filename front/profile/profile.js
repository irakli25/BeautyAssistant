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
            // $( "#tabs" ).tabs({ active: 0 });
            tabs();
            let img_array;
            get_images();
            var district              =   new filter("district","district","id","name");
            var street                =   new filter("street","street","id","name","300px");
            var hear                =   new filter("hear","street","id","name");
            var skin                =   new filter("skin","street","id","name");
            var district_multi      =   new multiSelect("district_multi","district","id","name","1550px");
            var experince           =   new multiSelect("experience","experience","id","name","1550px");
            var calc_experince           =   new multiSelect("calc_experience","experience","id","name","100%",0);
            var calc_district            =   new multiSelect("calc_district","district","id","name","100%",0);
            var calc_profiles            =   new template_filter("calc_profiles","users","id","name","100%");
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


function tabs() {
    $(".tab").hide();

    $("#id1").show();
}


class filter {
    constructor(select_id, table,id, list, width = "300px", where = ''){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.where = where;
        this.send();
    }
    send(){
        $.ajax({
        url:"server/filters/filter.php",
        data:this,
        type:"GET",
        success:function(data){
            let element = $("#"+data.element_id).parent();
            element.addClass(`select_wrapper_${data.element_id}`);
            $(`.select_wrapper_${data.element_id}`).html("");
            $(`.select_wrapper_${data.element_id}`).html(data.page);
        }
    })
    }
}

class template_filter {
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
        url:"server/filters/template_filter.php",
        data:this,
        type:"GET",
        success:function(data){
            $("#"+data.element_id).parent().html(data.page);
        }
    })
    }
}


class multiSelect {
    constructor(select_id, table,id, list, width = "300px",val = 1){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.get_val = val;
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
        $(`#${id}`).not("[kendotextarea]").val('');
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


$(document).on("click",".tab-selector", function (){
    $(".tab").hide();
    var tab = $(this).attr("tab");
    $(`#${tab}`).show();
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

$(document).on("change","#experience", function (){
    var ids = $(this).val();
    update_experience(ids);


})

$(document).on("change","#district", function (){
    var ids = $(this).val();
    update_district_user(ids);
    var street                =   new filter("street","street","id","name","300px",`district_id = ${$("#district").val()}`);

})


$(document).on("change","#street", function (){
    var id = $(this).val();
    update_street(id);


})

$(document).on("click",".edit[target='birthday']", function(){
    $(".k-i-calendar").trigger("click");
})

function update_district(ids){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_district",
            ids:ids
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
}

function update_street(id){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_street",
            id:id
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
}

function update_district_user(ids){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_district_user",
            ids:ids
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
}


function update_experience(ids){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"update_experience",
            ids:ids
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
}


$(document).on("click",".change_user_pic", function(){
    $("#uploader_user_pic").trigger("click");
});

$(document).on("change","#uploader_user_pic", function(){
    var file_data = $('#uploader_user_pic').prop('files')[0];   
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
                    act:"save_user_pic",
                    id:data.id
                },
                success:function(data_inner){
                    $(".user-pic").attr("style",`background-image:url(${data.link})`);
                }
            })
        }
     });
})



$(document).on("click",".portfolio-pic", function (){
    var img = $(this).attr("style");
    $(".pic_view").attr("style",img);
    $(".pic_view").show();
})

$(document).on("click",".pic_view span", function (){

    $(".pic_view").hide();
})

function get_images(){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"get_images"
        },
        success:function(data){
            img_array = data;
            
        }
    })
}

function get_img(img){
    if(img_array[img] != undefined)
       return `background-image: url(server/uploads/${img_array[img]})`;
    return "background-image: url(media/icons/crown.png)";
}