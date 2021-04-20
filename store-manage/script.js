var alertDelay = 4000; 

setTimeout(function(){ 
  $("#StoreAlert").slideUp(500);
}, alertDelay);



$(document).on('click','#SideNavCollapse',function(){

$("#sidebar").toggleClass("sidebarActive")

})


$(".collapse").on("show.bs.collapse",function(){

    $(".collapse.in").each(function(){
      $(this).collapse("hide");
    })
})
