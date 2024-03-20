<main>
    <section class="banner">
        <img src="admin/files/segmento/original_<?= $s1['banner'] ?>">
        <div class="banner-text">
            <span class="pagina">Segmentos</span>
            <span class="titulo"><?= $s1['nome'] ?></span>
        </div>
    </section>

    <section class="segmento">
        <div class="container">
            <div class="segmento-titulo">
                <h2>Como agregamos valor</h2>
                <p>
                    <?= $s1['valor'] ?>
                </p>
            </div>
            <div class="diferencial">
                <div class="diferencial-titulo">
                    <h2>Diferenciais</h2>
                </div>
                <div class="diferenciais-slider">
                    <?php foreach($diferenciais as $key => $d): ?>
                    <div>
                        <div class="diferenciais-slide">
                            <div class="diferenciais-img">
                                <i class="fas fa-<?= $d['icone_name'] ?>"></i>
                            </div>
                            <h4><?= $d['nome'] ?></h4>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="lancamentos">
        <div class="container">
            <div class="lancamentos-titulo">
                <h2><img src="imagens/home/Frame 11.png"> Produtos para você</h2>
            </div>
            <div class="lancamentos-content">
                <div class="lancamentos-slider">
                    <?php foreach($produtos as $key => $p): ?>
                    <div>
                        <div class="lancamento-slide">
                            <a><img src="admin/files/produto/<?= $p['idproduto'] ?>/<?= $p['imagem'] ?>"></a>
                            <div class="lancamento-text">
                                <h6><?= $p['nome'] ?></h6>
                                <p><?= $p['resumo'] ?></p>
                                <a href="produtos/<?= $p['urlrewrite'] ?>" class="adicionarBtn" type="button">Ver Produto</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-lancamentos"></i>
                <i class="fas fa-chevron-right next-lancamentos"></i>
            </div>
        </div>
    </section>

    <section class="clientes">
        <div class="container">
            <div class="clientes-titulo">
                <h2><img src="imagens/segmentos/Frame 12.png"> Principais marcas</h2>
                <span>Encontre o que você precisa, as melhores marcas do mercado</span>
            </div>
            <div class="clientes-content">
                <div class="clientes-slider">
                    <?php foreach($marcas as $key => $m): ?>
                    <div>
                        <div class="cliente-slide">
                            <img src="admin/files/marcas/<?= $m['imagem']?>">
                            
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-clientes"></i>
                <i class="fas fa-chevron-right next-clientes"></i>
            </div>
        </div>
        <?php include 'includes/footer-content.php';?>
    </section>

    
</main>