<main>
    <?php if($_SESSION['idu'] == 'linhas'):?>
        <section class="banner">
            <img src="admin/files/linhas/<?= $li['banner'] ?>">
            <div class="banner-text">
                <!-- <span class="pagina">Linha leve</span> -->
                <span class="titulo"><?= $li['nome'] ?></span>
            </div>
        </section>
    <?php elseif($_SESSION['idu'] == 'categoria'): ?>
        <section class="banner">
            <img src="admin/files/categoria/<?= $catb['imagem'] ?>">
            <div class="banner-text">
                <span class="pagina"><?= $li1['nome'] ?></span>
                <span class="titulo"><?= $catb['nome'] ?></span>
            </div>
        </section>
    <?php endif; ?> 
    <section class="produtos">
        <div class="container">
            <?php if(!empty($catb)): ?>
            <div class="produtos-titulo">
                <h4><?= $catb['seotitle']; ?></h4>
                <p>
                    <?= $catb['seodescription']; ?>
                </p>
            </div>
            <?php endif; ?>
            <div class="div-conteudo">
                <div class="colunaBtn"><button><i class="fas fa-bars"></i></button></div>
                <div class="coluna">
                    <button class="fecharColuna">x</button>
                    <div class="busca-categoria">
                        <form class="pesquisa" method="POST" action="<?php echo ENDERECO.'produtos'; ?>">
                                <input type="text" name="search" placeholder="Pesquise aqui..." value="<?php echo $search;?>">
                                <button class="buscaBtn" onclick="$(this).parent().submit();" ><i class="fas fa-search"></i></button>
                        </form>
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
                        <!-- <div class="preco">
                            <span class="preco-titulo">Preço</span>
                            <div class="slider">
                                <div class="progress"></div>
                            </div> -->
                            <!-- <div class="range-input">
                                <input type="range" id="input_value_filter_min" class="range-min" min="0" max="3000" value="<?php //echo empty($_SESSION['filtros']['values']) ? 0 : $_SESSION['filtros']['values'][0]; ?>" step="1" onmouseup="filter_values()">
                                <input type="range" id="input_value_filter_max" class="range-max" min="0" max="3000" value="<?php //echo empty($_SESSION['filtros']['values']) ? 3000 : $_SESSION['filtros']['values'][1]; ?>" step="1" onmouseup="filter_values()">
                            </div> -->
                            <!-- <div class="price-input">
                                <div class="field">
                                    <span>R$</span>
                                    <input type="number" class="input-min" value="<?php //echo empty($_SESSION['filtros']['values']) ? 0 : $_SESSION['filtros']['values'][0]; ?>">
                                </div>
                                <div class="separator">-</div>
                                <div class="field">
                                    <span>R$</span>
                                    <input type="number" class="input-max" value="<?php //echo empty($_SESSION['filtros']['values']) ? 3000 : $_SESSION['filtros']['values'][1]; ?>">
                                </div>
                            </div> -->
                        <!-- </div> -->
                        <form class="marcas">
                            <span>Marcas</span>
                            <div class="check">
                                <?php foreach($marcas as $key => $m): ?>
                                <?php $isChecked = ($_SESSION['extra'] == $m['urlrewrite']) ? 'checked' : ''; ?>
                                <label class="check-text"><?= $m['nome'] ?>
                                    <input type="checkbox" class="marca-checkbox" data-url="<?= $m['urlrewrite'] ?>" <?= $isChecked ?>>
                                    <span class="checkmark"></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </form>
                        </div>
                        <div class="filtrar">
                            <button class="filtrarBtn">Filtrar</button>
                        </div>

                        <div class="filtrar">
                            <a href="produtos" class="filtrarBtn">Limpar filtros</a>
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
                                    <option value="">Mais Recentes</option>
                                    <option value="">Ordem Alfabética</option>
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
                                        <input type="hidden"  id="idproduto" value="<?php echo  $prd['idproduto'] ?>">
                                        <input type="hidden" id="produto_qtd" value="1">
                                        <a href="orcamento" class="adicionarBtn" type="button" onclick="adicionarOrcamento()">Adicionar ao orçamento</a>
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
<!-- <script type="text/javascript">
    function filter_order(el){ 
        $( '#input_filtros_ordem' ).val( $(el).val() );
        $( '#input_filtros_ordem' ).parent()[0].submit();
    }
</script> -->