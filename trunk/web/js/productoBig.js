$(document).ready(function() {
  $(".miniaturas img").click(function(){
    //console.log($(".imagen_grande a").attr("href"));
    //console.log($(this).attr("rel"));
    //console.log($(this).parent().attr("rel"));
    $(".imagen_grande a").attr("href", $(this).parent().attr("rel"));
    //console.log($(".imagen_grande a").attr("href"));
    $(".imagen_grande img").attr("src", $(this).attr("rel"));
    $(this).siblings("img").removeClass("current");
    $(this).addClass("current");
    $(".cloud-zoom, .cloud-zoom-gallery").CloudZoom();
  });
});
