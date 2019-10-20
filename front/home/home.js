
$(document).ready(function (){

  animate ();
 
})


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
