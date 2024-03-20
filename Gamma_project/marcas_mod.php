<main>
    <?php if($_SESSION[''] == 'categoria'){ ?>
    <section class="banner">
        <img src="imagens/sobre/banner.png">
        <div class="banner-text">
            <span class="pagina">Linha leve</span>
            <span class="titulo">Aditivos</span>
        </div>
    </section>
    <?php } ?>

    <section class="produtos">
        <div class="container">
            <?php if($_SESSION[''] == 'categoria'){?>
            <div class="produtos-titulo">
                <h4>Aditivos</h4>
                <p>
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
                </p>
            </div>
            <?php } ?>
            <div class="div-conteudo">
                <div class="colunaBtn"><button><i class="fas fa-bars"></i></button></div>
                <div class="coluna">
                    <button class="fecharColuna">x</button>
                    <div class="busca-categoria">
                        <div class="pesquisa">
                            <input type="" name="" placeholder="Pesquise aqui...">
                            <button class="buscaBtn"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="categorias">
                            <div class="titulo">
                                <h4>Categorias Relacionadas</h4>
                            </div>
                            <?php foreach($categorias as $key => $c): ?>
                            <a href="produtos/categoria/<?= $c['urlrewrite'] ?>"><?= $c['nome'] ?></a>
                            <?php endforeach; ?>
                            <a class="categoriaBtn">Ver mais</a>
                        </div>
                    </div>
                    <div class="filtros">
                        <div class="titulo">
                            <h4>Filtros</h4>
                        </div>
                        <div class="preco">
                            <span class="preco-titulo">Preço</span>
                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" id="input_value_filter_min" class="range-min" min="0" max="3000" value="<?php echo empty($_SESSION['filtros']['values']) ? 0 : $_SESSION['filtros']['values'][0]; ?>" step="1" onmouseup="filter_values()">
                                <input type="range" id="input_value_filter_max" class="range-max" min="0" max="3000" value="<?php echo empty($_SESSION['filtros']['values']) ? 3000 : $_SESSION['filtros']['values'][1]; ?>" step="1" onmouseup="filter_values()">
                            </div>
                            <div class="price-input">
                                <div class="field">
                                    <span>R$</span>
                                    <input type="number" class="input-min" value="<?php echo empty($_SESSION['filtros']['values']) ? 0 : $_SESSION['filtros']['values'][0]; ?>">
                                </div>
                                <div class="separator">-</div>
                                <div class="field">
                                    <span>R$</span>
                                    <input type="number" class="input-max" value="<?php echo empty($_SESSION['filtros']['values']) ? 3000 : $_SESSION['filtros']['values'][1]; ?>">
                                </div>
                            </div>
                        </div>
                        <form class="marcas">
                            <span>Marcas</span>
                            <div class="check">
                                <?php foreach($marcas as $key => $m): ?>
                                <a href="produtos/marcas/<?= $m['urlrewrite'] ?>"><label class="check-text"><?= $m['nome'] ?>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label></a>
                                <?php endforeach; ?>
                            </div>
                        </form>
                    </div>
                    <div class="filtrar">
                        <button class="filtrarBtn">Limpar filtros</button>
                    </div>
                </div>
                <div class="coluna-bg"></div>
                <div class="conteudo">
                        <?php if(empty($produtos)) { ?>
                        <?php } else { ?>
                        <div class="conteudo-topo">
                            <div class="texto1">
                                <h4><span><?php echo $totais['totalRecords']; ?></span> produtos encontrados</h4>
                            </div>
                            <div class="texto2">
                                <h4>Ordenar por:</h4>
                                <select onchange="filter_order(this)" >
                                    <option value="">Mais vendidos</option>
                                    <option value="">Opção 1</option>
                                    <option value="">Opção 2</option>
                                    <option value="">Opção 3</option>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="conteudo-produtos">
                        <?php if(empty($produtos)) { ?>
                            <h2 class="vazio">Não há produtos cadastrados.</h2>
                        <?php } else { ?>
                            <?php foreach($produtos as $key => $prd): ?>
                                <div class="box-produto">
                                    <div class="box-img">
                                        <a href="produtos/<?= $prd['urlrewrite'] ?>"><img src="admin/files/produto/<?= $prd['idproduto']?>/<?= $prd['imagem']?>"></a>
                                    </div>
                                    <div class="box-text">
                                        <a href="produtos/<?= $prd['urlrewrite'] ?>"><h4><?= $prd['nome'] ?></h4></a>
                                        <p>
                                            <?= $prd['resumo'] ?>
                                        </p>
                                        <a href="produto-interna" class="adicionarBtn">Adicionar ao orçamento</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php } ?>
                    </div>
                    <?php if(empty($produtos)) { ?>
                    <?php } else { ?>
                        <?php include 'includes/paginacao.php';?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php include 'includes/footer-content.php';?>
    </section> 
</main>
<script type="text/javascript">
    function filter_order(el){ 
        $( '#input_filtros_ordem' ).val( $(el).val() );
        $( '#input_filtros_ordem' ).parent()[0].submit();
    }
</script>