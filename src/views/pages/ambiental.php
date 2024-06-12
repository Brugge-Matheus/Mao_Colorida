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
            <div class="itens-medidas"
                data-text="Durante o manuseio dos resíduos, o manipulador deve usar luvas e avental impermeáveis de PVC.">
                <img src="<?=$base?>/assets/icons/ppe.png" alt="">
                <h2>Manuseio Correto</h2>
                <button class="ver-medida">Ver medida</button>
            </div>
            <div class="itens-medidas"
                data-text="Após a coleta interna, o manipulador deve lavar as mãos ainda enluvadas, retirar as luvas e colocá-las em local apropriado. Se as luvas romperem, devem ser descartadas imediatamente.">
                <img src="<?=$base?>/assets/icons/litter.png" alt="">
                <h2>Coleta Interna</h2>
                <button class="ver-medida">Ver medida</button>
            </div>
            <div class="itens-medidas"
                data-text="Os equipamentos de proteção individual devem ser desinfetados diariamente. Se contaminados, devem ser substituídos ou lavados.">
                <img src="<?=$base?>/assets/icons/wash-your-hands.png" alt="">
                <h2>Equipamentos de Proteção</h2>
                <button class="ver-medida">Ver medida</button>
            </div>
        </div>

        <div class="box-medidas">
            <div class="itens-medidas"
                data-text="Evitar comer ao lidar com resíduos é essencial para prevenir contaminações e promover higiene e segurança.">
                <img src="<?=$base?>/assets/icons/no-food.png" alt="">
                <h2>Não se Alimentar</h2>
                <button class="ver-medida">Ver medida</button>
            </div>
            <div class="itens-medidas"
                data-text="Ao realizar atividades não relacionadas aos resíduos, como ir ao sanitário, o manipulador deve retirar as luvas e lavar as mãos.">
                <img src="<?=$base?>/assets/icons/gloves.png" alt="">
                <h2>Retirar as Luvas</h2>
                <button class="ver-medida">Ver medida</button>
            </div>
            <div class="itens-medidas"
                data-text="Manter o ambiente limpo é essencial para a saúde e o bem-estar, proporcionando um espaço mais agradável e seguro.">
                <img src="<?=$base?>/assets/icons/household.png" alt="">
                <h2>Ambiente Limpo</h2>
                <button class="ver-medida">Ver medida</button>
            </div>

            <span><i class="fa-solid fa-triangle-exclamation"></i>Em caso de acidente com resíduos: Notificar
                imediatamente o gestor, segurança e medicina do trabalho e encaminhar para o pronto atendimento se
                necessário.</span>
        </div>
    </div>
</section>

<!-- Modal medidas -->
<div id="medidaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modal-text"></p>
    </div>
</div>



<script src="<?=$base?>/assets/js/main.js"></script>

<?php $render('footer')?>