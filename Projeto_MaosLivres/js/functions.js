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


    //Adicionar e remover produto
    const quantityInput = $('#qtd');
    const incrementButton = $('.adicionar');
    const decrementButton = $('.remover');

    incrementButton.on('click', function() {
        quantityInput.val(parseInt(quantityInput.val()) + 1);
    });

    decrementButton.on('click', function() {
        const currentValue = parseInt(quantityInput.val());
        if (currentValue > 0) {
            quantityInput.val(currentValue - 1);
        }
    });


    // Vincula um manipulador de evento de clique aos botões "Remover"
    $(".remover-produto").click(function () {
        // Encontra a div pai da qual o botão "Remover" faz parte e a remove
        $(this).closest(".carrinho-box").remove();
    });


    $(".blog-slide").click(function() {
        // Remove a classe 'ativo' de todos os elementos com a classe 'blog-slide'
        $(".blog-slide").removeClass("ativo");
        
        // Adiciona a classe 'ativo' ao elemento clicado
        $(this).addClass("ativo");
    });


    // FILTRO DE PREÇOS
    var $priceRange = $("#priceRange");
    var $minValue = $("#minValue");
    var $maxValue = $("#maxValue");

    $priceRange.ionRangeSlider({
        type: "double",
        skin: "round",
        grid: true,
        min: 0,
        max: 1000,
        from: 0, // Valor mínimo inicial
        to: 1000,   // Valor máximo inicial
        step: 1,
        prettify_enabled: true,
        prettify: function (value) {
                    return value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
                },
        to_min: 100, // Define o valor mínimo para o máximo
        from_max: 900, // Define o valor máximo para o mínimo
        onFinish: function(data) {
            // Não faz nada no evento onFinish
        }
    });
    $priceRange.on("change", function() {
        var minVal = $priceRange.data("ionRangeSlider").result.from;
        var maxVal = $priceRange.data("ionRangeSlider").result.to;
        $minValue.text(minVal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
        $maxValue.text(maxVal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
    });


    //Navegação entre INFORMAÇÕES e ARQUIVOS produto-interno
    $('.nav-infos .infoBtn').click(function() {
      // Adicione a classe navBtn à infoBtn e a classe descr-ativada à informacoes
      $('.infoBtn').addClass('navBtn');
      $('.informacoes').addClass('descr-ativada');

      // Remova a classe navBtn da arquivosBtn e a classe descr-ativada dos arquivos
      $('.arquivosBtn').removeClass('navBtn');
      $('.arquivos').removeClass('descr-ativada');
    });

    $('.nav-infos .arquivosBtn').click(function() {
      // Adicione a classe navBtn à arquivosBtn e a classe descr-ativada aos arquivos
      $('.arquivosBtn').addClass('navBtn');
      $('.arquivos').addClass('descr-ativada');

      // Remova a classe navBtn da infoBtn e a classe descr-ativada da informacoes
      $('.infoBtn').removeClass('navBtn');
      $('.informacoes').removeClass('descr-ativada');
    });


    $('.colunaBtn').on('click', function() {
      $('.coluna').addClass('coluna-open');
      $('.div-conteudo .conteudo').css('opacity', '0.5');
    });
    $('.fecharColuna').on('click', function() {
      $('.coluna').removeClass('coluna-open');
      $('.div-conteudo .conteudo').css('opacity', '1');
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

    $('.linhas-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-linhas"),
        nextArrow: $(".next-linhas"),
        slidesToShow: 3,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });

    $('.clientes-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-clientes"),
        nextArrow: $(".next-clientes"),
        slidesToShow: 6,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
          }
        },
      ]
    });

    $('.segmentos-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-segmentos"),
        nextArrow: $(".next-segmentos"),
        slidesToShow: 6,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
          }
        },
      ]
    });

    $('.lancamentos-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-lancamentos"),
        nextArrow: $(".next-lancamentos"),
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
          breakpoint: 800,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });

    $('.equipe-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-equipe"),
        nextArrow: $(".next-equipe"),
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
          breakpoint: 800,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });

    $('.timeline-slider').slick({
        infinite: false,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-timeline"),
        nextArrow: $(".next-timeline"),
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
          breakpoint: 800,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });

    $('.blog-slider').slick({
        infinite: false,
        autoplay: false,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-blog"),
        nextArrow: $(".next-blog"),
        slidesToShow: 8,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 5,
          }
        },
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 4,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
          }
        },
      ]
    });

    $('.download-slider').slick({
        infinite: false,
        autoplay: false,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-download"),
        nextArrow: $(".next-download"),
        slidesToShow: 3,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 850,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });

    $('.diferenciais-slider').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: false,
        speed: 1000,
        autoplaySpeed: 2500,
        slidesToShow: 4,
        slidesToScroll: 1,
         responsive: [
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 2,
          }
        },
      ]
    });

    $('.produto-slider').slick({
        infinite: true,
        autoplay: false,
        dots: false,
        arrows: false,
        speed: 1000,
        autoplaySpeed: 2500,
        fade: true,
        draggable: false,
        slidesToShow: 1,
        asNavFor: '.produto-dot'
    });
    $('.produto-dot').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.produto-slider',
        dots: false,
        arrows: false,
        centerMode: false,
        draggable: false,
        focusOnSelect: true
    });
});


  