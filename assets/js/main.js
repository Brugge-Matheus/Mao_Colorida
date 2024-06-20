// Menu Mobile
$(document).ready(function () {
    $("#header-toggle").click(function () {
        $("#header-menu").toggleClass("show");
    });

    $("#header-close").click(function () {
        $("#header-menu").removeClass("show");
    });

    // Hover medidas
    $(".ver-medida").click(function () {
        var text = $(this).parent().attr("data-text");
        $("#modal-text").text(text);
        $("#medidaModal").fadeIn();
    });

    $(".close").click(function () {
        $("#medidaModal").fadeOut();
    });

    $(window).click(function (event) {
        if ($(event.target).is("#medidaModal")) {
            $("#medidaModal").fadeOut();
        }
    });
});
