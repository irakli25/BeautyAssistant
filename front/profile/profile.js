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
            if($("#container").attr("user") == "" || $("#container").attr("user") == $("#profile_id").val())
                    $(".calculator").hide();
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
            var calc_experince           =   new multiSelect("calc_experience","experience","id","name","100%",0,getCookie("calc_experience"));
            var calc_district            =   new filter("calc_district","district","id","name","100%");

            if(!(getCookie("calc_experience") == "" || getCookie("calc_district") == "")){
               
                var calc_profiles            =   new template_filter("calc_profiles","users","id","name","100%",getCookie("calc_experience"),getCookie("calc_district"));
            
                    show_assistant();
                    $("#calc_price").html(`<span>${getCookie("calc_price")}</span><div class="lari"></div>`);
                    $("#order_button").show();
                    get_calc_price();
            }
            else{
                hide_assistant();
                $("#order_button").hide();
            }

            
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
    constructor(select_id, table,id, list, width = "300px", where = '',val = 1, arr = ''){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.where = where;
        this.get_val = val;
        this.arr = arr;
        this.profile = isNaN(Number($("#profile_id").val())) ? "" : Number($("#profile_id").val());
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
    constructor(select_id, table,id, list, width = "300px",exp,dist){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.exp = exp;
        this.dist = dist;
        
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
    constructor(select_id, table,id, list, width = "300px",val = 1, arr = ''){
        this.select_id = select_id;
        this.table_name = table;
        this.id = id;
        this.list = list;
        this.width = `width: ${width}`;
        this.get_val = val;
        this.arr = arr;
        this.profile = isNaN(Number($("#profile_id").val())) ? "" : Number($("#profile_id").val());
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
                    webalert("ცვლილება შენახულია","success");
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

$(document).on("click", "#save_finance", function(){
    var arr = new Object();
    $.each($(".f_in"),function(x,v){
        arr[$(v).attr('id')] = v.value;
    })
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"save_finance",
            arr:arr,
            id:$("#profile_id").val()
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else    
                webalert("ცვლილება შენახულია","success");
        }
    })
})



function show_assistant(){
    $("#calc_text").hide();
    $("#calc_assistant").show();
    
}
function hide_assistant(){
    $("#calc_text").show();
    $("#calc_assistant").hide();
    
}


$(document).on("change", "#calc_experience, #calc_district", function(){
    $("#calc_profiles_span").html('<select id="calc_profiles" ></select>');
    var calc_profiles            =   new template_filter("calc_profiles","users","id","name","100%",$("#calc_experience").val(),$("#calc_district").val());
    if(!($("#calc_experience").val() == 0 || $("#calc_district").val() == 0)){
        show_assistant();
        $("#order_button").show();
    }
    else{
        hide_assistant();
        $("#order_button").hide();
    }
    get_calc_price();

})

$(document).on("click","#order_button", function(){
    let district = $("#calc_district").val();

    $.ajax({
        url:"server/server.php",
        data:{
            act:"get_address",
            district:district
        },
        success:function(data){
            if(data.isaddress){
                var order_district              =   new filter("order_district","district","id","name",'300px','',0,$("#calc_district").val());
                var order_street                =   new filter("order_street","street","id","name","300px",'',0,data.street);
                $("#order_corect_address").val(data.street_name);
            }
            else{
                var order_district              =   new filter("order_district","district","id","name",'300px','',0,$("#calc_district").val());
                var order_street                =   new filter("order_street","street","id","name","300px",`district_id = ${$("#calc_district").val()}`,0);

                webalert("მითითებულ უბანზე მისამართი ვერ მოიძებნა, გთხოვთ შეიყვანოთ მისამართი !");
            }
        }
    })

   
    get_order_price();
    get_order_experience();
  $("#order_window").css("display","block");
})

$(document).on("change","#calc_profiles", function(){
    get_calc_price();
    if($(this).val() > 0){
        $("#calculate_button").show();
    }
    else{
        $("#calculate_button").hide();
    }
})

$(document).on("click","#calculate_button", function(){
    $.ajax({
        url:"server/profile/profile.php",
        data:{
            act:"get_uid",
            id:$("#calc_profiles").val()
        },
        success:function(data){
            if(data.error != "")
                webalert(data.error)
            else
                window.location = data.link;
        }
    })
})


function get_calc_price() {
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
            exp:$("#calc_experience").val(),
            profile:profile
        },
        success:function(data){
            var p = data.price;
            var price = Number(p).toFixed(2);
            $("#calc_price").html(`<span>${price}</span><div class="lari"></div>`);
            setCookie("calc_price",price);
        }
    })
}