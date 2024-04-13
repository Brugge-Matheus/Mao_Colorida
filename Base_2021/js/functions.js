$(document).ready(function(){
    //Contadores dinâmicos
      $(window).scroll(function(){
        if($('.count').length > 0){
          if(checkVisible(document.getElementById('counter'))){
              $('.count:not(.started)').each(function () {
                  $(this).addClass('started');
                  $(this).prop('Counter',0).animate({
                      Counter: $(this).text()
                  }, {
                      duration: 4000,
                      easing: 'swing',
                      step: function (now) {
                          $(this).text(Math.ceil(this.Counter).toLocaleString());
                      }
                  });
              });
            }
          }
      });

      function setSlideHeight(sliderClass) {
      var maxHeight = 0;
      
      // Resetar a altura dos slides
      $(sliderClass + ' .slick-slide').css('height', 'auto');
      
      // Iterar sobre os slides para encontrar a maior altura
      $(sliderClass + ' .slick-slide').each(function(){
          var slideHeight = $(this).outerHeight(true);
          maxHeight = Math.max(maxHeight, slideHeight);
      });

      // Definir a altura de todos os slides com a altura máxima encontrada
      $(sliderClass + ' .slick-slide').css('height', maxHeight + 'px');
      }

      // Chamar a função quando o slider é inicializado
      $('.depoimentos-slider').on('init', function(event, slick){
          setSlideHeight('.depoimentos-slider');
      });

    


   //Abrir menu mobile
   $('.open-mobile').on('click', function() {
    $('.header-mobile').addClass('opened');
    });

    $('.close-mobile').on('click', function() {
        $('.header-mobile').removeClass('opened');
    });

    $('.menu-dropdown').click(function(){
        $('.drop-menu').css('display' , 'flex');
        $(this).toggleClass('open');
        $(".drawer").toggleClass("open");
        $('.header-mobile').css('display' , 'none');
    })
    $(document).click(function(event) {
      if (!$(event.target).closest(".menu-dropdown").length) {
        $("body").find(".drop-menu").css('display', 'none');
      }
    });


    //modal trabalhe
    $('.curriculoBtn').on('click', function() {
        $('.modal-trabalhe').addClass('opened');
        $("body").css("overflow", "hidden")
        });

        $('.fechar-trabalhe').on('click', function() {
            $('.modal-trabalhe').removeClass('opened');
            $("body").css("overflow", "unset")
        });

        $('.modal-bg').on('click', function() {
            $('.modal-trabalhe').removeClass('opened');
            $("body").css("overflow", "unset")
        });


    $('.banner-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-banner"),
        nextArrow: $(".next-banner"),
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    $(window).on("load", function() {
      // Get the height of the tallest box
      var maxHeight = 0;
      $(".-slider .box-text").each(function() {
          var height = $(this).outerHeight(true);
          if (height > maxHeight) {
              maxHeight = height;
          }
      });

      // Set the height of all boxes to the maxHeight
      $(".-slider .box-text").height(maxHeight);

      $(".-slider .box-text").each(function() {
          var height = $(this).outerHeight(true);
          if (height > maxHeight) {
              maxHeight = height;
          }
      });

      // Set the height of all boxes to the maxHeight
      $(".-slider .box-text").height(maxHeight);
  });

});


  