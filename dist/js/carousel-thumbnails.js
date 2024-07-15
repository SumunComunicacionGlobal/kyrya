/*
jQuery(document).ready(function($) {

    $(".carrusel-post").carousel('cycle');
    $(".carrusel-post").on("slide.bs.carousel", function (e) {
        var slideFromId = $(this).find(".active").index();
        var slideToId = $(e.relatedTarget).index();
        // console.log(slideFromId+' => '+slideToId);

        $( ".carousel-indicators li.active" ).removeClass("active");
        $( ".carousel-indicators li").eq(slideToId).addClass("active");

    });
});
*/