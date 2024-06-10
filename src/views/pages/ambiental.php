<?php $render('header')?>

<div class="menu" id="menu">
    <nav class="container">
        <div class="menu-item">
            <a href="#nosso-foco">Sustentabilidade em foco</a>
        </div>
        |
        <div class="menu-item">
            <a href="#medidas">Nossas medidas</a>
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

<!-- sustentabilidade e foco -->
<section class="processos d-flex" id="nosso-foco">
    <div class="processos-container d-flex">
        <div class="processos-conteudo d-flex">
            <div class="container d-flex">
                <div class="processos-text d-flex">
                    <h3>SUSTENTABILIDADE EM FOCO</h3>
                    <p>
                        Orientar as questões socioambientais associadas aos seguimentos da <strong>Mão
                            Colorida</strong>, representa o comprometimento da empresa com o meio ambiente, buscando
                        a melhoria da qualidade de vida dos seus empregados e da comunidade em geral. Reforçando
                        assim o compromisso com o desenvolvimento sustentável do planeta.
                        <br>
                        <br>
                        A PNRS- LEI Nº 12.305 de 02 de agosto de 2010 que institui a Politica nacional de resíduos
                        sólidos e a lei que rege o setor de resíduos sólidos e define a ordem de prioridade no
                        gerenciamento da seguinte maneira:

                    </p>
                    <div class="processos-topicos d-flex">
                        <div class="topico1 d-flex">
                            <span><i class="fas fa-check laranja"></i> Não geração</span>
                            <span><i class="fas fa-check laranja"></i> Redução</span>
                            <span><i class="fas fa-check laranja"></i> Reutilização</span>
                        </div>
                        <div class="topico2 d-flex">
                            <span><i class="fas fa-check laranja"></i> Reciclagem</span>
                            <span><i class="fas fa-check laranja"></i> Tratamento </span>
                            <span><i class="fas fa-check laranja"></i> Disposiçao adequada</span>
                        </div>
                    </div>
                </div>
                <div class="processos-img d-flex">
                    <img src="<?=$base?>/assets/images/processos-img.jpg" alt="imagem">
                </div>
            </div>
        </div>
</section>



<!-- Medidas -->
<section class="medidas" id="medidas">
    <div class="container">
        <div class="medidas-titulo">
            <h2>
                <i class="fa-solid fa-earth-americas"></i>
                Medidas

            </h2>

        </div>

        <div class="box-medidas">
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/ppe.png" alt="">
                <h2>Manuseio Correto</h2>
                <p>Durante o manuseio dos resíduos o manipulador devera utilizar os seguintes equipamentos de
                    proteção individual: Luvas de PVC ou borracha e impermeável. Avental de PVC, impermeável e de
                    médio comprimento.</p>
            </div>
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/litter.png" alt="">
                <h2>Coleta Interna</h2>
                <p>Após a coleta interna, o manipulador deve lavar as mãos ainda enluvadas, retirando as luvas e
                    colocando-as em local apropriado. Em caso de ruptura das luvas, o funcionário deve descarta-las
                    imediatamente.

                </p>
            </div>
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/wash-your-hands.png" alt="">
                <h2>Equipamentos de Proteção</h2>
                <p>Os equipamentos de proteção individual dever ser desinfetados diariamente. Sempre que houver
                    contaminação com material infectado, devem ser substituídos imediatamente ou lavados.</p>
            </div>
        </div>

        <div class="box-medidas">
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/no-food.png" alt="">
                <h2>Não se Alimentar </h2>
                <p>Evitar comer ao lidar com resíduos é essencial para prevenir contaminações. Manter essa separação
                    entre atividades alimentares e o manuseio de resíduos é fundamental para proteger a saúde e
                    promover uma cultura de higiene e segurança.</p>
            </div>
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/gloves.png" alt="">
                <h2>Retirar as Luvas</h2>
                <p>É crucial que, ao exercer atividades não relacionadas aos resíduos, como ir ao sanitário, atender
                    o telefone ou beber água, o manipulador retire as luvas e lave as mãos. Esse procedimento é
                    essencial para manter a higiene e prevenir a contaminação cruzada.</p>
            </div>
            <div class="itens-medidas">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Ambiente Limpo</h2>
                <p>Manter o ambiente limpo é essencial para a saúde e o bem-estar de todos. É uma prática simples,
                    mas que faz uma grande diferença no dia a dia, proporcionando um espaço mais agradável e seguro
                    para viver e trabalhar.</p>
            </div>

            <span><i class="fa-solid fa-triangle-exclamation"></i>Em caso de acidente com resíduos: Notificar
                imediatamente o gestor, segurança e medicina do trabalho e encaminhar para o pronto atendimento se
                necessário.</span>

        </div>
    </div>
</section>

<?php $render('footer')?>