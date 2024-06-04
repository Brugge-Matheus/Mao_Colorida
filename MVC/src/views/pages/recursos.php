<?php $render('header')?>

<!-- Menu -->
<div class="menu">
    <nav class="container">
        <!-- <div class="menu-drop">
            <i class="fa-solid fa-bars"></i>
            <a href="#">Exemplo</a>
            <i class="fa-solid fa-chevron-down"></i>
        </div> -->
        <div class="menu-item">
            <a href="#nossa-historia">Quem somos</a>
        </div>
        |
        <div class="menu-item">
            <a href="#seguranca-patrimonial">Seguranças</a>
        </div>
        |
        <div class="menu-item">
            <a href="#nosso-foco">Nossos esforços</a>
        </div>
        |
        <div class="menu-item">
            <a href="#objetivos">Missão e valores</a>
        </div>
        |
        <div class="menu-item">
            <a href="#medidas">Medidas</a>
        </div>
        <!-- |
        <div class="menu-item">
            <a href="#">Exemplo</a>
        </div> -->
</div>
</nav>

<!-- Pagamentos -->
<section class="pagamentos" id="pagamentos">
    <div class="container">
        <div class="pagamentos-titulo">
            <h2>
                <i class="fa-solid fa-sack-dollar"></i>
                Pagamentos
            </h2>

        </div>

        <div class="box-pagamentos">
            <div class="itens-pagamentos box1-pagamentos">
                <img src="<?=$base?>/assets/icons/pagar.png" alt="">
                <h2>Adiantamento</h2>
                <p>Adiantamento salarial de 40% no dia 15 do mês. Saldo de salário creditado no ultimo dia de cada mês.
                </p>
            </div>
            <div class="itens-pagamentos box2-pagamentos">
                <img src="<?=$base?>/assets/icons/nota-de-dolar.png" alt="">
                <h2>Faltas</h2>
                <p>No caso de faltas injustificadas, o funcionário terá descontado o dia de trabalho, o descanso semanal
                    remunerado e feriado na semana, se houver.
                </p>
            </div>
            <div class="itens-pagamentos box3-pagamentos">
                <img src="<?=$base?>/assets/icons/mala-de-viagem.png" alt="">
                <h2>Inicialização</h2>
                <p>No 1º mês de trabalho, o funcionário não receberá nenhum adiantamento salarial, devendo aguardar até
                    o final do mês para receber.</p>
            </div>
        </div>
    </div>
</section>


<!-- Benefícios -->
<section class="beneficios" id="beneficios">
    <div class="container">
        <div class="beneficios-titulo">
            <h2>
                <i class="fa-solid fa-user-plus"></i>
                Benefícios

            </h2>

        </div>

        <div class="box-beneficios">
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/ppe.png" alt="">
                <h2>VR Pae</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/litter.png" alt="">
                <h2>VR Nutrição</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/wash-your-hands.png" alt="">
                <h2>VR Seguro alimentação</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>

            </div>
        </div>
        <div class="box-beneficios">
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/no-food.png" alt="">
                <h2>TotalPass </h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/gloves.png" alt="">
                <h2>Ginástica Laboral</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Férias</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Estacionamento</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Farmácia</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Vale Transporte</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>

            <span><i class="fa-solid fa-triangle-exclamation"></i>Todos os funcionários são avaliados no prazo de 90
                dias pelo gestor da área. Após a experiência, o funcionário adquire os benefícios ofertados.</span>

        </div>
    </div>
</section>

<?php $render('footer')?>