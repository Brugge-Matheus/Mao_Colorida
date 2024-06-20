<?php $render('header')?>

<div class="menu-qualidade" id="menu-qualidade">
    <nav class="container">
        <div class="menu-qualidade-item">
            <a href="#melhoria">Cartão de melhoria</a>
        </div>

        <div class="menu-qualidade-item">
            <a href="#tratativas">Tratativas</a>
        </div>

        <div class="menu-qualidade-item">
            <a href="#metodologia">Metodologia</a>
        </div>

        <div class="menu-qualidade-item">
            <a href="#bn-contato">Instruções</a>
        </div>
    </nav>
</div>

<!-- Melhorias -->
<section class="melhoria" id="melhoria">
    <div class="container">
        <div class="melhoria-img">
            <img src="./assets/images/cartao_de_melhoria.jpg">
        </div>
        <div class="melhoria-text">
            <h2>Cartões de melhoria</h2>
            <p>
                Na Mão Colorida, a melhoria contínua é incentivada por meio de um sistema de cartões de
                melhoria, com urnas e QR codes espalhados pela fábrica para facilitar a coleta de sugestões dos
                colaboradores. Bimestralmente, a empresa realiza uma premiação para reconhecer os destaques nesse
                processo.
                <br><br>
                São concedidos prêmios de R$200,00 para quem abre a maior quantidade de cartões, R$300,00 para
                quem implementa mais sugestões e R$300,00 para a melhor ideia implementada. Esse sistema motiva a
                participação ativa dos funcionários e promove um ambiente de trabalho mais colaborativo e inovador.
            </p>
            <a href="//drive.google.com/file/d/1pQc7HF5slhqlCLOxq9WMLlXrGL65BcUt/view?usp=drive_link"
                class="curriculoBtn" target="_blank">Como preencher? <i class="fa-solid fa-pen"></i></a>
            <a href="//app.smartsheet.com/b/form/0478814e620a4e1eb2fbff2ad4275e31" target="_blank"
                class="vagasBtn" target="_blank">Preencher cartão <i class="fa-solid fa-clipboard"></i></a>
        </div>
    </div>
</section>


<!-- Tratativas -->
<section class="tratativas" id="tratativas">
    <div class="container">

        <div class="trat-text">
            <h2>Tratativas de não conformidade</h2>
            <p>
                A gestão de não conformidades segue o processo estabelecido no Procedimento MC0003. Este documento está
                disponível para consulta na fábrica, especificamente na área de quarentena, e também pode ser acessado
                na pasta "QUALIDADE" da rede virtual da Mão Colorida (público-qualidade procedimentos).
                <br><br>
                É essencial que todas as não conformidades sejam comunicadas ao encarregado do setor envolvido,
                garantindo que o problema seja tratado de forma adequada e conforme os padrões de qualidade
                estabelecidos pela empresa. Dessa maneira, asseguramos a manutenção da excelência em nossos metodologia
                e
                produtos, além de facilitar a identificação e correção de possíveis falhas.
            </p>
        </div>
        <div class="trat-img">
            <img src="./assets/images/tratativa-nao-conforme.jpg">
        </div>
    </div>
</section>




<!-- metodologia -->
<section class="metodologia d-flex" id="metodologia">
    <div class="metodologia-container d-flex">
        <div class="metodologia-conteudo d-flex">
            <div class="container d-flex">
                <div class="metodologia-img d-flex">
                    <img src="./assets/images/metodologia.jpg" alt="imagem">
                </div>
                <div class="metodologia-text d-flex">
                    <h3>METODOLOGIA 5S</h3>
                    <p>
                        Estamos promovendo uma gincana para implementar a metodologia 5S em toda a empresa, com foco em
                        limpeza e organização. A gincana é composta por cinco fases:
                        <br>
                        <br>
                        Em cada fase, os setores que obtiverem a maior pontuação serão premiados. Esta iniciativa visa
                        melhorar o ambiente de trabalho, promovendo eficiência e bem-estar para todos.

                    </p>
                    <div class="metodologia-topicos d-flex">
                        <div class="topico1 d-flex">
                            <span><i class="fa-solid fa-caret-right"></i> Utilização</span>
                            <span><i class="fa-solid fa-caret-right"></i> Organização</span>
                            <span><i class="fa-solid fa-caret-right"></i> Limpeza</span>
                        </div>
                        <div class="topico2 d-flex">
                            <span><i class="fa-solid fa-caret-right"></i> Padronização</span>
                            <span><i class="fa-solid fa-caret-right"></i> Disciplina </span>
                            <span><i class="fa-solid fa-caret-right"></i> Sustentabilidade</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</section>


<!-- Procedimentos e instruções de trabalho -->
<section class="bn-contato d-flex" id="bn-contato">
    <div class="texto d-flex column">
        <span class="barra"></span>
        <h5>Integração</h5>
        <span class="barra"></span>
        <h2 class="branco">Procedimentos e instruções de trabalho</h2>
        <p>
            Os procedimentos e instruções de trabalho são documentos essenciais para assegurar a qualidade, consistência
            e eficiência nas operações de uma empresa. Eles detalham as etapas a serem seguidas para a execução correta
            de tarefas específicas, proporcionando orientação clara aos colaboradores.
        </p>
        <a href="https://drive.google.com/file/d/1vSA0kfaKpi30qFHrt7wlV9kdCiutmEVn/view?usp=sharing" target="_blank"
            class="btn-contato scale1">Ver procedimentos <i class="fa-solid fa-download"></i></a>
    </div>
</section>


<?php $render('footer')?>