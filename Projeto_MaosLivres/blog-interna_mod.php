<main>
	<section class="banner">
        <img src="imagens/sobre/banner.png">
        <div class="banner-text">
            <span class="pagina">Blog</span>
            <span class="titulo"><?= $p['nome'] ?></span>
        </div>
    </section> 
    <section class="conteudo">
        <div class="container">
        	<div class="data">
                <?php
                    $timestamp = strtotime($p['data_hora']);
                    $dia = date("d", $timestamp);
                    $mes_por_extenso = date("F", $timestamp);
                    $mes_por_extenso = strftime("%B", $timestamp);
                    $ano = date("Y", $timestamp);
                ?>
        		<span><?php echo $dia.' de ' .$mes_por_extenso. ' de ' .$ano; ?></span>
        	</div>
            <p>
               <?= $p['descricao'] ?>
            </p>
        </div> 
    </section>
    <section class="noticias">
        <div class="container">
            <div class="noticias-titulo">
                <h2><img src="imagens/home/Frame 111.png"> Outras notícias</h2>
            </div>
            <div class="noticias-content">
                <?php foreach($posts as $key => $ps): ?>
                <div class="noticia-box">
                    <a href="blog/<?= $ps['urlrewrite'] ?>"><img src="admin/files/blog/<?= $ps['imagem'] ?>"></a>
                    <div class="noticia-text">
                        <?php
                            $timestamp = strtotime($ps['data_hora']);
                            $dia = date("d", $timestamp);
                            $mes_abreviado = date("M", $timestamp);
                            $mes_abreviado = ucfirst(strftime("%b", $timestamp));
                            $ano = date('Y', $timestamp);
                        ?>
                        <h6><?php echo $dia.' '. $mes_abreviado .' '. $ano; ?></h6>
                        <div>
                            <a><?= $ps['nome'] ?></a>
                            <img src="imagens/home/seta.png">
                        </div>
                        <p><?= $ps['resumo'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>