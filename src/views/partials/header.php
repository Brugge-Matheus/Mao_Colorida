<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mão Colorida</title>

    <!-- Css -->
    <link rel="stylesheet" href="<?=$base?>/assets/css/home.css">
    <!-- <link rel="stylesheet" href="<?=$base?>/assets/css/sustentabilidade.css"> -->
    <link rel="stylesheet" href="<?=$base?>/assets/css/contato.css">
    <link rel="stylesheet" href="<?=$base?>/assets/css/recursos.css">
    <link rel="stylesheet" href="<?=$base?>/assets/css/segurancas.css">
    <link rel="stylesheet" href="<?=$base?>/assets/css/ambiental.css">
    <link rel="stylesheet" href="<?=$base?>/assets/css/partials.css">
    <link rel="stylesheet" href="<?=$base?>/assets/css/qualidade.css">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=$base?>/assets/images/mao_colorida_favicon.jpeg" type="image/x-icon">


    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
</head>

<header class="header" id="header">
    <div class="header-container container">
        <a href="<?=$base?>" class="header-logo">
            <img src="<?=$base?>/assets/images/logo-new.png" alt="logo-header">
        </a>
        <button class="header-toggle" id="header-toggle">&#9776;</button>
        <nav class="header-menu" id="header-menu">
            <a href="<?=$base?>/" class="header-link">Sobre</a>
            <a href="<?=$base?>/recursos" class="header-link">Recursos Humanos</a>
            <a href="<?=$base?>/ambiental" class="header-link">Ambiental </a>
            <a href="<?=$base?>/qualidade" class="header-link">Qualidade</a>
            <a href="<?=$base?>/segurancas" class="header-link">Seguranças</a>
            <a href="<?=$base?>/contato" class="fale-conosco-btn">
                <i class="fa-solid fa-paper-plane"></i>
                Contato
            </a>
            <button class="header-close" id="header-close">&times;</button>
        </nav>
    </div>
</header>

<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="<?=$base?>/assets/js/main.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>