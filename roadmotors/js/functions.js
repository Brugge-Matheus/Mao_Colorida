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

      // Função para definir a altura dos slides
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

      // Função para chamar setSlideHeight quando o slider é inicializado
      function initializeSlider(sliderClass) {
          $(sliderClass).on('init', function(event, slick) {
              setSlideHeight(sliderClass);
          });
      }

      // Chamar a função para cada slider que deseja inicializar
      initializeSlider('.depoimentos-slider');
      initializeSlider('.diferenciais-nav');

      // Chamar setSlideHeight quando a janela for redimensionada
      $(window).on('resize', function() {
          setSlideHeight('.depoimentos-slider');
          setSlideHeight('.diferenciais-nav');
      });


      $(".scroll-to").click(function(event) {
        event.preventDefault(); // Evita o comportamento padrão do link
        
        // Verifica se o .header-mobile tem a classe .opened e a remove, se necessário
        if ($('.header-mobile').hasClass('opened')) {
            $('.header-mobile').removeClass('opened');
        }

        var targetID = $(this).data('target');
        var targetOffset = $("#" + targetID).offset().top - 50; // Subtrai 100 pixels
        $('html, body').animate({ scrollTop: targetOffset }, 300);
    });


   //Abrir menu mobile
   $('.open-mobile').on('click', function() {
    $('.header-mobile').addClass('opened');
    });

    $('.close-mobile').on('click', function() {
        $('.header-mobile').removeClass('opened');
    });


    $('.banner-slider').slick({
        infinite: true,
        autoplay: false,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 3000,
        prevArrow: $(".prev-bn"),
        nextArrow: $(".next-bn"),
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    $('.servicos-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 3000,
        prevArrow: $(".prev-serv"),
        nextArrow: $(".next-serv"),
        slidesToShow: 1,
        slidesToScroll: 1,
    });

     $('.diferenciais-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: false,
      fade: true,
      asNavFor: '.diferenciais-nav'
    });
    $('.diferenciais-nav').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '.diferenciais-for',
      dots: false,
      arrows: false,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1300,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 900,
          settings: {
            slidesToShow: 2,
          }
        }
      ]
    });

    $('.equipe-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 3000,
        prevArrow: $(".prev-equip"),
        nextArrow: $(".next-equip"),
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 900,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
          }
        }
      ]
    });

    $('.depoimentos-slider').slick({
      infinite: true,
      autoplay: false,
      dots: false,
      arrows: true,
      centerMode: true,
      centerPadding: '20%',
      autoplaySpeed: 3000,
      prevArrow: $(".prev-depo"),
      nextArrow: $(".next-depo"),
      slidesToShow: 1,
      responsive: [
        {
          breakpoint: 1100,
          settings: {
            centerMode: false,
            centerPadding: '0',
          }
        }
      ]
    });



});


  