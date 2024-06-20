$(document).ready(function () {
    $(".estrutura-slider").slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        speed: 1000,
        autoplaySpeed: 5000,
        prevArrow: $(".prev-estrutura"),
        nextArrow: $(".next-estrutura"),
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });

    $(".clientes-slider").slick({
        infinite: true,
        autoplay: true,
        dots: false,
        arrows: true,
        prevArrow: $(".prev-cli"),
        nextArrow: $(".next-cli"),
        speed: 1000,
        focusOnSelect: true,
        autoplaySpeed: 3500,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 4,
                },
            },
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });
});
