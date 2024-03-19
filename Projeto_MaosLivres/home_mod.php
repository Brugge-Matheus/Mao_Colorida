<main>
    <section class="banner">
        <div class="banner-responsive banner-slider">
            <?php foreach($banner as $key => $b): ?>
            <div>
                <div class="banner-slide">
                    <picture>
                        <source media='(max-width:768px)' srcset='admin/files/banner/<?= $b['banner_mobile'] ?>'>
                        <img src='admin/files/banner/<?= $b['banner_full']?>' alt='imagem' />
                    </picture>
                    <?php //if($b['dinamico'] == 1): ?>
                    <!-- <div class="absolute-container">
                        <div class="container">
                            <h1>
                                A cada dia nossa força se renova
                            </h1>
                        </div>
                    </div> -->
                    <?php //endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <i class="fas fa-chevron-left prev-banner"></i>
        <i class="fas fa-chevron-right next-banner"></i>
    </section>

    <section class="linhas">
        <div class="container">
            <div class="linhas-titulo">
                <h2><img src="imagens/home/Frame 11111.png"> O que você procura?</h2>
                <span>Filtre pelas categorias que deseja, e encontre o produto ideal para você</span>
            </div>
            <div class="linhas-content">
                <div class="linhas-slider">
                    <?php foreach($linhas as $key => $l): ?>
                    <div>
                        <div class="linha-slide">
                            <img src="admin/files/linhas/<?= $l['imagem'] ?>">
                            <div class="linha-text">
                                <h2><?= $l['nome'] ?></h2>
                                <a href="produtos/linhas/<?= $l['urlrewrite'] ?>">Ver produtos</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-linhas"></i>
                <i class="fas fa-chevron-right next-linhas"></i>
            </div>
        </div>
    </section>

    <section class="clientes">
        <div class="container">
            <div class="clientes-titulo">
                <h2><img src="imagens/home/Frame 1111.png"> Principais marcas</h2>
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
    </section>

    <section class="segmentos">
        <div class="container">
            <div class="segmentos-titulo">
                <h2><img src="imagens/home/Frame 11111.png"> Quem é você?</h2>
                <span>O que você procura? Clique e confira os produtos do seu segmento</span>
            </div>
            <div class="segmentos-content">
                <div class="segmentos-slider">
                    <?php foreach($segmentos as $key => $s): ?>
                    <div>
                        <div class="segmento-slide">
                            <a href="segmento/<?= $s['urlrewrite'] ?>"><img src="admin/files/segmento/<?= $s['imagem'] ?>"></a>
                            <h4><?= $s['nome'] ?></h4>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-segmentos"></i>
                <i class="fas fa-chevron-right next-segmentos"></i>
            </div>
        </div>
    </section>

    <section class="lancamentos">
        <div class="container">
            <div class="lancamentos-titulo">
                <h2><img src="imagens/home/Frame 11.png"> Lançamentos</h2>
                <span>Novidades e lançamentos da Gamma</span>
            </div>
            <div class="lancamentos-content">
                <div class="lancamentos-slider">
                    <?php foreach($lancamentos as $key => $l): ?>
                    <div>
                        <div class="lancamento-slide">
                            <a><img src="admin/files/produto/<?= $l['idproduto'] ?>/<?= $l['imagem'] ?>"></a>
                            <div class="lancamento-text">
                                <h6><?= $l['nome'] ?></h6>
                                <p><?= $l['resumo'] ?></p>
                                <input type="hidden"  id="idproduto" value="<?php echo  $l['idproduto'] ?>">
                                <input type="hidden" id="produto_qtd" value="1">
                                <a class="orcamento-btn2" href="orcamento" type="button" onclick="adicionarOrcamento()">Adicionar ao orçamento</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-lancamentos"></i>
                <i class="fas fa-chevron-right next-lancamentos"></i>
            </div>
            <a href="produtos" class="red-btn">Ver todos os produtos</a>
        </div>
    </section>

   <section class="noticias">
        <div class="container">
            <div class="noticias-titulo">
                <h2><img src="imagens/home/Frame 111.png"> Últimas notícias</h2>
                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
            </div>
            <div class="noticias-content">
                <?php foreach($blog as $key => $bg): ?>
                <div class="noticia-box">
                    <a href="blog/<?= $bg['urlrewrite'] ?>"><img src="admin/files/blog/<?= $bg['imagem'] ?>"></a>
                    <div class="noticia-text">
                        <?php
                            $timestamp = strtotime($bg['data_hora']);
                            $dia = date("d", $timestamp);
                            $mes_abreviado = date("M", $timestamp);
                            $mes_abreviado = ucfirst(strftime("%b", $timestamp));
                            $ano = date('Y', $timestamp);
                        ?>
                        <h6><?php echo $dia.' '. $mes_abreviado .' '. $ano; ?></h6>
                        <div>
                            <a><?= $bg['nome'] ?></a>
                            <img src="imagens/home/seta.png">
                        </div>
                        <p><?= $bg['resumo'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <a href="noticias" class="red-btn">Ver todas as notícias</a>
        </div>
        <?php include 'includes/footer-content.php';?>
    </section>
</main>