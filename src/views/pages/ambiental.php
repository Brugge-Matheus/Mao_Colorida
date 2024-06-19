<?php $render('header')?>

<div class="menu-ambiental" id="menu-ambiental">
    <nav class="container">
        <div class="menu-ambiental-item">
            <a href="#nosso-foco">Sustentabilidade em foco</a>
        </div>

        <div class="menu-ambiental-item">
            <a href="#medidas">Nossas medidas</a>
        </div>

        <div class="menu-ambiental-item">
            <a href="#plano">Plano de gerenciamento</a>
        </div>

        <div class="menu-ambiental-item">
            <a href="#disposicao">Disposição de resíduos</a>
        </div>
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
                        A disposicao- LEI Nº 12.305 de 02 de agosto de 2010 que institui a Politica nacional de resíduos
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




<!-- Plano de gerenciamento -->
<section class="plano d-flex" id="plano">
    <div class="plano-container d-flex">
        <div class="plano-conteudo d-flex">
            <div class="container d-flex">
                <div class="plano-text d-flex">
                    <h3>PLANO DE GERENCIAMENTO DE RESÍDUOS SÓLIDOS</h3>
                    <p>
                        O Plano de Gerenciamento de Resíduos Sólidos (PGRS) é um documento técnico essencial para a
                        gestão ambiental de empresas. Ele identifica a tipologia e a quantidade de resíduos gerados,
                        comprovando a capacidade da empresa de gerir esses resíduos de maneira ambientalmente correta.
                        <br>
                        <br>
                        O PGRS orienta sobre as formas adequadas para o manejo, armazenamento, transporte, reciclagem e
                        destinação final dos resíduos, contribuindo significativamente para a redução e prevenção de
                        grandes poluições ambientais, bem como suas consequências para a saúde pública e o equilíbrio da
                        fauna e flora.
                    </p>
                    <div class="plano-topicos d-flex">
                        <div class="topico1 d-flex">
                            <h4>Identificação de Resíduos</h4>
                            <span><i class="fa-solid fa-arrow-right"></i> Tipologia e quantidade de resíduos
                                gerados.</span>
                            <!-- </div> -->
                            <!-- <br> -->
                            <!-- <div class="topico2 d-flex"> -->
                            <h4>Gestão Ambiental</h4>
                            <span><i class="fa-solid fa-arrow-right"></i> Comprova a gestão correta dos resíduos.</span>
                            <!-- <br> -->
                            <h4>Manejo e Destinação</h4>
                            <span><i class="fa-solid fa-arrow-right"></i> Manejo, armazenamento, transporte, reciclagem
                                e destinação final adequados.</span>

                            <h4>Prevenção de Poluição</h4>
                            <span><i class="fa-solid fa-arrow-right"></i> Reduz e evita poluições ambientais e suas
                                consequências.</span>

                            <h4>Legislação</h4>
                            <span><i class="fa-solid fa-arrow-right"></i> <strong>Artigo 3:</strong> Obrigações quanto
                                ao PGRS.</span>
                            <span><i class="fa-solid fa-arrow-right"></i> <strong>Artigo 25:</strong> Multa por
                                descumprimento.</span>
                            <span><i class="fa-solid fa-arrow-right"></i> <strong>Artigo 33:</strong> Requisito para
                                renovação da Licença.</span>
                        </div>
                    </div>
                </div>
                <div class="plano-img d-flex">
                    <img src="<?=$base?>/assets/images/pgrs.png" alt="imagem">
                </div>
            </div>
        </div>
</section>





<!-- disposicao -->
<section class="disposicao d-flex" id="disposicao">
    <div class="disposicao-container d-flex">
        <div class="disposicao-conteudo d-flex">
            <div class="container d-flex">
                <div class="disposicao-img d-flex">
                    <img src="<?=$base?>/assets/images/disposicao-de-residuos.jpg" alt="imagem">
                </div>
                <div class="disposicao-text d-flex">
                    <h3>DISPOSIÇÃO FINAL DOS RESÍDUOS</h3>
                    <p>
                        Atualmente, uma das principais preocupações das empresas é garantir a destinação correta dos
                        resíduos gerados em seus processos. Esta ação é fundamental para a Política Ambiental da empresa
                        e para o seu sistema de gestão ambiental.
                        <br>
                        <br>
                        A destinação adequada dos resíduos não só cumpre com as exigências legais e ambientais, mas
                        também demonstra o compromisso da empresa com a sustentabilidade.

                    </p>
                    <div class="disposicao-topicos d-flex">
                        <div class="topico1 d-flex">
                            <span><i class="fa-solid fa-star"></i> Co-processamento;</span>
                            <span><i class="fa-solid fa-star"></i> Tratabilidade</span>
                            <span><i class="fa-solid fa-star"></i> Reciclagem</span>
                        </div>
                        <div class="topico2 d-flex">
                            <span><i class="fa-solid fa-star"></i> Recuperação</span>
                            <span><i class="fa-solid fa-star"></i> Disposição </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</section>



<script src="<?=$base?>/assets/js/main.js"></script>

<?php $render('footer')?>