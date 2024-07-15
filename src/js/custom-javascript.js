(function ($) {
  jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
    var fieldId = jQuery(this).attr('id');
    // var defaultCountry = jQuery(this).attr('country-code');
    var defaultCountry = jQuery('#top-bar .wpml-ls-item-active').text();
    console.log(defaultCountry);

    if ( defaultCountry == 'en' ) {
      defaultCountry = 'gb';
    }

    // alert(defaultCountry);
    
    $("#"+fieldId).countrySelect({
      defaultCountry: defaultCountry,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      responsiveDropdown: true,
      preferredCountries: ['es', 'gb', 'fr', 'it', 'de', 'pt', 'us']
    });
  });
})(jQuery);


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



// function miniaturas_carrusel(slideToId) {
//     var current = jQuery( ".carousel-thumbnails .carousel-indicators li.active" ).index();
//     var total = jQuery( ".carousel-thumbnails .carousel-indicators li").length - 1;
//     if ( slideToId = 'next') {
//       slideToId = current + 1;
//       if (slideToId > total) {
//         slideToId = 0;
//       }
//     } else if('prev') {
//       slideToId = current - 1;
//       if (slideToId < 0) {
//         slideToId = total;
//       }
//     }
//     jQuery( ".carousel-thumbnails .carousel-indicators li.active" ).removeClass("active");
//     jQuery( ".carousel-thumbnails .carousel-indicators li").eq(slideToId).addClass("active");
// }

jQuery(document).ready(function($) {

  // var textoSinFlecha = $('body').html().replace(/➜/g, '<i class="fa fa-chevron-right mx-1"></i>')
  // $('body').html(textoSinFlecha);

  $('.wpcf7-list-item-label, label').each(function(index) {
    var text = $(this).text().trim();
    if ( text.indexOf('/*') >= 0 ) {
      var textArray = text.split('/*');
      var newTextHtml = '';

      $.each(textArray, function(indexTextArray,value) {
        if ( 'undefined' != value ) {
          var langElement = value.split('*/');
          newTextHtml += '<span class="show-lang-' + langElement[0] + '">' + langElement[1] + '</span>';
        }
      });

      var oldHtml = $(this).html().trim();

      // alert(text);
      // alert(newTextHtml);
      // alert(oldHtml);
      // alert(text.length);
      newTextHtml += oldHtml.substring(text.length);
      // alert(oldHtml.replace(text, newTextHtml));
      // $(this).html(oldHtml.replace(text, newTextHtml));
      $(this).html(newTextHtml);

    }
  });

  $('.wp-block-button__link').addClass('btn btn-primary').removeClass('wp-block-button__link');

  $('.aparecer').each(function(index) {
    var i = index + 1;
    var delay = 0.04;
    $(this).css('animation-delay', delay * i + 's');
  });

  $('.aparecer').addClass("hidden").viewportChecker({
      classToAdd: 'visible animated fadeInUp',
      offset: 100,

      // callbackFunction: function(elem) {
      //         // var elements = elem.find('div'),
      //             // i = 0;
      //         interval = setInterval(function(){
      //             elem.addClass('visible animated fadeInUp');
      //             // if(i==elements.length) {
      //             //     clearInterval(interval);
      //             // }
      //         },250);
      //     }

   });

  var campoTipo = $('input[name="kt"]');
  var campoProducto = $('input[name="kn"]');
  if (campoProducto.length) {
    if (campoProducto.val().length > 0) {
      $('#consulta-sobre').html( '+ info: ' + campoTipo.val() + ' ' + campoProducto.val());
      $('#consulta-sobre').show();
    } else {
      $('#consulta-sobre').hide();
    }
  }

    $(document).click(function (event) {
        var clickover = $(event.target);
        var _expanded = $("#navbar-toggler").attr("aria-expanded");
        // alert(_closed);
        if (_expanded === 'true' && !clickover.hasClass("navbar-toggler") && !clickover.hasClass("nav-link")  && !clickover.hasClass("form-control") ) {
            $("#navbar-toggler").click();
        }
    });

  // Close modal 
  $('.close-modal').click(function() {
    $('.modal').toggleClass('show');
  });

  // Detect windows width function
  var $window = $(window);

  function checkWidth() {
    var windowsize = $window.width();
    if (windowsize > 767) {
      // alert(windowsize);
      // if the window is greater than 767px wide then do below. we don't want the modal to show on mobile devices and instead the link will be followed.

      $(".modal-link").click(function(e) {

        $("#modal-ajax-post").modal("show");
        var modalContent = $("#modal-ajax-post .modal-body");
        // var modalContent = $("#modal-body");


        // var post_link = $('.show-in-modal').html(); // get content to show in modal
        var post_link = $(this).attr("href"); // this can be used in WordPress and it will pull the content of the page in the href
        
        e.preventDefault(); // prevent link from being followed
        
        $('.modal').addClass('show', 1000, "easeOutSine"); // show class to display the previously hidden modal
        modalContent.html("loading..."); // display loading animation or in this case static content
        // modalContent.html(post_link); // for dynamic content, change this to use the load() function instead of html() -- like this: modalContent.load(post_link + ' #modal-ready')
        modalContent.load(post_link + ' #modal-ready', function() {
        // modalContent.load(post_link, function() {

          var base_url = window.location.origin;
          if ( base_url.includes("localhost") || base_url.includes("viral.sumun.net")) {
            base_url += "/kyrya";
          }
          $.getScript( base_url + "/wp-content/themes/kyrya/js/carousel-thumbnails.js");
        });





        // $("html, body").animate({ // if you're below the fold this will animate and scroll to the modal
        //   scrollTop: 0
        // }, "slow");
        // return false;
      });
    }
  };

  checkWidth(); // excute function to check width on load
  $(window).resize(checkWidth); // execute function to check width on resize
});
