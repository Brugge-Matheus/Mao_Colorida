<main>
    <section class="banner">
        <img src="imagens/sobre/banner.png">
        <div class="banner-text">
            <span class="pagina">Sobre</span>
            <span class="titulo">Nossa História</span>
        </div>
    </section>

    <section class="historia">
        <div class="container">
            <div class="hist-img">
                <img src="imagens/sobre/img1.png">
            </div>
            <div class="hist-text">
                <h2>Nossa história</h2>
                <p>
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. 
                    <br><br>
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. 
                </p>
            </div>
        </div>
    </section>

    <section class="equipe">
        <div class="container">
            <div class="equipe-titulo">
                <h2><img src="imagens/sobre/heads.png"> Heads e executivos</h2>
            </div>
            <div class="equipe-content">
                <div class="equipe-slider">
                    <?php foreach($equipe as $key => $e): ?>
                    <div>
                        <div class="equipe-slide">
                            <img src="admin/files/equipe/<?= $e['imagem']; ?>">
                            <h3><?= $e['nome']; ?></h3>
                            <span><?= $e['especialidade']; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-equipe"></i>
                <i class="fas fa-chevron-right next-equipe"></i>
            </div>
        </div>
    </section>

    <section class="timeline">
        <div class="container">
            <div class="timeline-titulo">
                <h2><img src="imagens/sobre/trajetoria.png"> Nossa trajetória</h2>
            </div>
            <div class="timeline-content">
                <div class="timeline-slider">
                    <?php foreach($timeline as $key => $t): ?>
                    <div>
                        <div class="timeline-slide">
                            <h3><?= $t['ano'] ?></h3>
                            <img src="admin/files/timeline/<?= $t['imagem'] ?>">
                            <p>
                                <?= $t['descricao'] ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-timeline"></i>
                <i class="fas fa-chevron-right next-timeline"></i>
            </div>
        </div>
    </section>

    <section class="numeros">
        <div class="container">
            <div class="numeros-titulo">
                <h2><img src="imagens/sobre/numeros.png"> Nossos números</h2>
            </div>
            <div class="numeros-box" id="counter">
                <?php foreach($features as $key => $f): ?>
                <div class="num-box">
                    <h2 class="count"><?= $f['numero']; ?></h2>
                    <p>
                        <?= $f['prefixo']; ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="estrutura">
        <div class="container">
            <div class="estru-text">
                <h2>Estrutura</h2>
                <p>
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. 
                    <br><br>
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. 
                </p>
            </div>
            <div class="estru-img">
                <img src="imagens/sobre/img1.png">
            </div>
        </div>
    </section>
</main>