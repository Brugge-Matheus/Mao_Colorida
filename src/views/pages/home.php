<?php $render('header'); ?>


<div class="menu-home" id="menu-home">
    <nav class="container">
        <div class="menu-home-item">
            <a href="#nossa-historia">Quem somos</a>
        </div>

        <div class="menu-home-item">
            <a href="#nossa-estrutura">Nossa estrutura</a>
        </div>

        <div class="menu-home-item">
            <a href="#objetivos">Missão e valores</a>
        </div>

        <div class="menu-home-item">
            <a href="#parceiros">Parceiros</a>
        </div>
    </nav>
</div>


<!-- Nossa história -->
<section class="nossa-historia" id="nossa-historia">
    <div class="container-historia container">
        <div class="hist-img">
            <img src="./assets/images/sobre-img.jpg" alt="sobre_nos_image">
        </div>
        <div class="hist-text">
            <h2>Nossa história</h2>
            <p>
                Fundada em 1997 em Curitiba por Marcos Vargas, após retornar da Espanha, onde adquiriu experiência
                em comunicação visual e sinalização. A empresa Mão Colorida tem como objetivo de trabalho projetar
                Ponto de Vendas (PDV) para as empresas conforme a necessidade, integrando criação, engenharia,
                produção, atendimento comercial e pós venda.
                <br>
                <br>
                Alguns dos projetos arquitetados foram para as empresas O Boticário, Adidas, Cacau Show, Samsung,
                etc. De maneira completamente sustentável a empresa desenvolve designs tecnológicos, modernos e
                inovadores.
                Um desses projetos foi para a marca Quem Disse Berenice? O qual apresenta muita cor e modernidade
                que definem perfeitamente a personalidade da marca. Além disso todos os revestimentos da loja foram
                confeccionados com plástico reciclado, desde a fachada ate os móveis.
            </p>
        </div>
    </div>
</section>


<!-- Conheça nossa estrutura -->
<div class="titulo-segurança-pat d-flex" id="nossa-estrutura">
    <span class="span-titulo">Estrutura</span>
    <h2>Conheça nossa estrutura</h2>
</div>
<section class="estrutura">
    <div class="container">
        <div class="estrutura-content">
            <div class="estrutura-slider">
                <?php for($i = 0; $i < $numItensEstrutura; $i++): ?>
                <div>
                    <div class="estrutura-slide">
                        <!-- Ajuste o caminho da imagem de acordo com o nome do arquivo -->
                        <img src="./assets/images/estrutura/<?=$itensEstrutura[$i]?>">
                        <h3><?=$estruturas[$i]?></h3>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <span class="prev-estrutura"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="next-estrutura"><i class="fa-solid fa-chevron-right"></i></span>
        </div>
    </div>
</section>


<!-- nossos objetivos -->
<section class="objetivos" id="objetivos">
    <div class="container">
        <div class="objetivos-titulo">
            <h2>
                <i class="fa-solid fa-bullseye"></i>
                Pilares Fundamentais
            </h2>

        </div>

        <div class="box-objetivos">
            <div class="itens-objetivos box1">
                <img src="./assets/images/icone-missão.png" alt="">
                <h2>Missão</h2>
                <p>Utilizar nossa criatividade e as melhores tecnologias do mercado para tornar realidade os sonhos
                    e objetivos dos clientes</p>
            </div>
            <div class="itens-objetivos box2">
                <img src="./assets/images/icone-visao.png" alt="">
                <h2>Visão</h2>
                <p>Ser uma empresa de vanguarda atendendo os clientes mais exigentes do mercado com uma equipe
                    motivada por resultados</p>
            </div>
            <div class="itens-objetivos box3">
                <img src="./assets/images/icone-coracao.png" alt="">
                <h2>Valores</h2>
                <p>A qualidade superior que entregamos ao nossos clientes junto com a busca da rentabilidade e do
                    crescimento do nosso negocio</p>
            </div>
        </div>
    </div>
</section>


<!-- Clientes atendindos -->
<section class="clientes d-flex" id="parceiros">
    <div class="container d-flex">

        <div class="titulo-segurança-pat d-flex" id="seguranca-patrimonial">
            <span class="span-titulo">Parceiros</span>
            <h2>Quem confia na Mão Colorida?</h2>
        </div>

        <div class="clientes-div d-flex">
            <span class="prev-cli"><i class="fas fa-chevron-left"></i></span>
            <div class="clientes-slider">
                <?php for($i = 0; $i < $numItensMarcas; $i++): ?>
                <div>
                    <div class="box">
                        <img src="./assets/images/marcas/<?=$itensMarcas[$i]?>" alt="imagem">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <span class="next-cli"><i class="fas fa-chevron-right"></i></span>
        </div>
    </div>
</section>

<?=$render('footer')?>