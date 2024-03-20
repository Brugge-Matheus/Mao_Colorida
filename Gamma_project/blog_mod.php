<main>
    <section class="banner">
        <img src="imagens/sobre/banner.png">
        <div class="banner-text">
            <span class="pagina">Blog</span>
            <span class="titulo">Fique por<br> dentro</span>
        </div>
    </section> 
 
    <section class="blog-destaque">
        <div class="container">
            <div class="blog-titulo">
                <h3>Destaque</h3>
            </div>
            <?php $firstIteration = true; ?>
            <?php foreach($postsdestaque as $key => $p): ?>
            <div class="destaque1">
                <div class="blog-box post-destaque">
                    <div class="blog-img">
                        <a href="blog/<?= $p['urlrewrite'] ?>"><img src="admin/files/blog/<?= $p['imagem'] ?>"></a>
                    </div>
                    <div class="blog-text">
                        <?php
                            $timestamp = strtotime($p['data_hora']);
                            $dia = date("d", $timestamp);
                            $mes_abreviado = date("M", $timestamp);
                            $mes_abreviado = ucfirst(strftime("%b", $timestamp));
                            $ano = date('Y', $timestamp);
                        ?>
                        <span><?php echo $dia.' '. $mes_abreviado .' '. $ano; ?></span>
                        <a href="blog/<?= $p['urlrewrite'] ?>"><?= $p['nome'] ?></a>
                        <p>
                            <?= $p['resumo'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php $firstIteration = false; ?>
                <?php if ($firstIteration === false) break; ?>
            <?php endforeach; ?>
            <div class="destaque2">
                <?php 
                    $iteration = 0;
                    foreach($postsdestaque as $key => $p): 
                        if ($iteration == 0) {
                            $iteration++;
                            continue;
                        }
                        if ($iteration > 2) {
                            break;
                        }
                ?>
                <div class="blog-box post-destaque">
                    <div class="blog-img ">
                        <a href="blog/<?= $p['urlrewrite'] ?>"><img src="admin/files/blog/<?= $p['imagem'] ?>"></a>
                    </div>
                    <div class="blog-text">
                        <?php
                            $timestamp = strtotime($p['data_hora']);
                            $dia = date("d", $timestamp);
                            $mes_abreviado = date("M", $timestamp);
                            $mes_abreviado = ucfirst(strftime("%b", $timestamp));
                            $ano = date('Y', $timestamp);
                        ?>
                        <span><?php echo $dia.' '. $mes_abreviado .' '. $ano; ?></span>
                        <a href="blog/<?= $p['urlrewrite'] ?>"><?= $p['nome'] ?></a>
                        <p>
                            <?= $p['resumo'] ?>
                        </p>
                    </div>
                </div>
                <?php 
                    $iteration++;
                    endforeach; 
                ?>
            </div>
        </div>
    </section>

    <section class="blog-conteudo">
        <div class="container">
            <div class="blog-filtro">
                <div class="blog-slider">
                    <div>
                        <div class="blog-slide <?php if(empty($_SESSION['extra'])){ echo 'ativo'; } ?>">
                            <a href="blog" class="btn-categoria">Todas</a>
                        </div>
                    </div>
                    <?php foreach($categorias as $key => $c): ?>
                        <div>
                            <div class="blog-slide <?php echo ($c['urlrewrite'] == $_SESSION['extra']) ? 'ativo' : ''; ?>">
                                <a href="blog/categoria/<?= $c['urlrewrite']?>" class="btn-categoria"><?= $c['nome'] ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <i class="fas fa-chevron-left prev-blog"></i>
                <i class="fas fa-chevron-right next-blog"></i>
            </div>
            <div class="posts">
                <?php foreach ($posts as $key => $bp): ?>
                <div class="blog-box post-normal">
                    <div class="blog-img">
                        <a href="blog/<?= $bp['urlrewrite'] ?>"><img src="admin/files/blog/<?= $bp['imagem'] ?>"></a>
                    </div>
                    <div class="blog-text">
                        <?php
                            $timestamp = strtotime($bp['data_hora']);
                            $dia = date("d", $timestamp);
                            $mes_abreviado = date("M", $timestamp);
                            $mes_abreviado = ucfirst(strftime("%b", $timestamp));
                            $ano = date('Y', $timestamp);
                        ?>
                        <span><?php echo $dia.' '. $mes_abreviado .' '. $ano; ?></span>
                        <a href="blog/<?= $bp['urlrewrite'] ?>"><?= $bp['nome'] ?></a>
                        <p>
                            <?= $bp['resumo'] ?>
                        </p>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>
            </div>
            <?php include 'includes/paginacao.php';?>
        </div>
    </section>
</main>