
$(document).ready(function (){

  animate ();
  get_staff();

 
 
})

function hamburger(x) {
  var width = $(".navigation_ul").css("width");
  access = $(".container-hamburger").css("display") == "none" ? false : true;
  if(access){
    if(width == "9px"){
      $(".navigation_ul").css("display","flex");
      $(".navigation_ul").css("width","50%");
    }
    else {
      $(".navigation_ul").css("width","0");
      $(".navigation_ul").toggle();
    }
    x.classList.toggle("change");
}
}

function animate(n=0){
  var services = $(".services div");

  if(n != 0){
    $(services[n-1]).removeClass(`service_${n}_colored`);
    $(services[n-1]).addClass(`service_${n}`);
  }
  else{
    $(services[5]).removeClass(`service_6_colored`);
    $(services[5]).addClass(`service_6`);
  }

  $(services[n]).removeClass(`service_${n+1}`);
  $(services[n]).addClass(`service_${n+1}_colored`);

  setTimeout(function () {
      n++;
      if(n==6)n=0;
        animate(n);
  }, 1000);
  
}

function get_staff(){
    $.ajax({
      url:"server/server.php",
      data:{
        act:'get_list_staff'
      },
      success:function(data){
        $(".profile_wrapper").html(data.html);
        $(".profile_wrapper").css("height","70vh");
      }
    })
}


$(document).on("click", ".profile", function(){
  window.location = $(this).attr("link");
})

