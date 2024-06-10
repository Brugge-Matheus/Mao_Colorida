<?=$render('header')?>

<div class="menu" id="menu">
    <nav class="container">
        <div class="menu-item">
            <a href="#segurança-do-trabalho">Segurança do trabalho</a>
        </div>
        |
        <div class="menu-item">
            <a href="#seguranca-patrimonial">Segurança Patrimonial</a>
        </div>
        <!-- <div class="menu-item">
            <a href="#nosso-foco">Nossos esforços</a>
        </div>
        <div class="menu-item">
            <a href="#objetivos">Missão e valores</a>
        </div>
        <div class="menu-item">
            <a href="#medidas">Medidas</a>
        </div> -->
    </nav>
</div>

<!-- Segurança Do Trabalho -->
<section class="processos d-flex" id="segurança-do-trabalho">
    <div class="titulo-processos d-flex">
        <span class="span-titulo">Trabalho Seguro</span>
        <h2>Segurança do Trabalho</h2>
    </div>
    <div class="processos-container d-flex">
        <div class="processos-conteudo d-flex">
            <div class="container d-flex">
                <div class="processos-text d-flex">
                    <span class="span-titulo">Compromisso</span>
                    <h3>PRIORIZANDO A SEGURANÇA</h3>
                    <p>
                        A Segurança do Trabalho consiste em medidas preventivas para evitar acidentes e proteger a
                        saúde dos colaboradores. Os acidentes no trabalho têm causas como stress, fadiga, falta de
                        atenção e negligência.
                        <br>
                        <br>
                        Em caso de acidente ou incidente, é importante procurar imediatamente o técnico de segurança do
                        trabalho. Se não estiver disponível, o gestor deve encaminhar o colaborador para atendimento
                        médico e relatar o ocorrido ao RH e aos responsáveis. A Comunicação de Acidente de Trabalho
                        (CAT) deve ser aberta dentro de 24 horas.

                    </p>
                </div>
                <div class="processos-img d-flex">
                    <img src="<?=$base?>/assets/images/img-seguranca-do-trabalho.jpg" alt="imagem">
                </div>
            </div>
        </div>
</section>

<!-- Segurança Patrimonial -->
<div class="titulo-segurança-pat d-flex" id="seguranca-patrimonial">
    <span class="span-titulo">Responsabilidade</span>
    <h2>Segurança Patrimonial</h2>
</div>
<section class="seg-pat d-flex">
    <div class="container d-flex">
        <div class="texto1 d-flex">
            <span class="span-titulo-seg-pat">Alerta de Responsabilidade</span>
            <h2>Cuidados com Pertences na Mão Colorida</h2>
            <p class="cor-2">
                A Mão Colorida não assume qualquer responsabilidade por objetos de valor deixados nos armários. É
                importante ressaltar que a guarda e segurança desses pertences são inteiramente de responsabilidade
                do próprio colaborador</p>
            <img src="<?=$base?>/assets/images/imagem-seg-pat.jpg" alt="imagem">
        </div>
        <div class="texto2 d-flex">
            <div class="titulo d-flex ">
                <h3>Procedimentos internos</h3>
            </div>
            <div class="topicos d-flex">
                <div class="box">
                    <div class="d-flex">
                        <img src="<?=$base?>/assets/icons/seta.png" alt="" class="icon-seta">
                    </div>
                    <div class="box-texto d-flex">
                        <h4>Proibido fotografar</h4>
                        <p class="cor-2">
                            Proibido fotografar ou filmar as dependências da empresa
                            (exceções serão tratadas com o gerente do setor e
                            conhecimento da diretoria).</p>
                    </div>
                </div>
                <div class="box">
                    <div class="box-icon d-flex">
                        <img src="<?=$base?>/assets/icons/seta.png" alt="" class="icon-seta">
                    </div>
                    <div class="box-texto d-flex">
                        <h4>Uso de objetos</h4>
                        <p class="cor-2">
                            Probido o uso de qualquer objeto que não seja para o
                            desempenho do serviço.</p>
                    </div>
                </div>
                <div class="box">
                    <div class="box-icon d-flex">
                        <img src="<?=$base?>/assets/icons/seta.png" alt="" class="icon-seta">
                    </div>
                    <div class="box-texto d-flex">
                        <h4>Portar bolsas</h4>
                        <p class="cor-2">
                            Proibido permanecer ou andar dentro da fabrica portanto bolsas,
                            sacolas etc.</p>
                    </div>
                </div>
                <div class="box">
                    <div class="box-icon d-flex">
                        <img src="<?=$base?>/assets/icons/seta.png" alt="" class="icon-seta">
                    </div>
                    <div class="box-texto d-flex">
                        <h4>Uso de celulares</h4>
                        <p class="cor-2">
                            Probido o uso de celulares, rádios, aparelhos sonoros, fones de ouvidos
                            ou qualquer objeto que não seja para o desempenho do
                            serviço. *Exceto funcionários liberados pela gerência.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?= $render('footer')?>
