  $(document).ready(function() {

    $('.accordion').click(function(){
        var $details = $(this).parent();
        // Fecha todos os detalhes exceto o atualmente clicado
        $('details').not($details).removeAttr('open');
    });

    $('.colunaBtn').on('click', function() {
      $('.coluna').addClass('coluna-open');
    });
    $(document).click(function(event) {
      if (!$(event.target).closest(".colunaBtn").length) {
        $("body").find(".coluna").css('display', 'none');
      }
    });

    function setSlideHeight(sliderClass) {
        var maxHeight = 0;
        $(sliderClass + ' .slick-slide').each(function(){
          var slideHeight = $(this).height();
          maxHeight = Math.max(maxHeight, slideHeight);
        });

        $(sliderClass + ' .slick-slide').css('height', maxHeight + 'px');
        }

    // Atualizar a altura dos slides quando o carrossel for redefinido para o primeiro slider
    $('.-slider').on('afterChange', function(event, slick, currentSlide){
    setSlideHeight('.-slider');
    });

      // Configurar a altura inicial dos slides para o primeiro slider
    setSlideHeight('.-slider');

    // Pega a altura da maior box
    var maxHeight = 0;
    $(".box-text").each(function() {
      var height = $(this).height();
      if (height > maxHeight) {
        maxHeight = height;
      }
    });

      // Coloca a altura da maior box para as outros
      $(".funcionalidades-slider .box-text").height(maxHeight);
});

