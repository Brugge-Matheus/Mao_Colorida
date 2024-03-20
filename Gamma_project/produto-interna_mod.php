<main>
    <section class="produto">
        <div class="container">
            <div class="produto-slicks">
                <div class="produto-slider">
                    <?php foreach($produto_imagens as $key => $pi): ?>
                    <div>
                        <div class="produto-slide" data-fancybox="galeria" href="admin/files/produto/<?= $pi['idproduto'] ?>/galeria/<?= $pi['nome_imagem'] ?>">
                            <a><img src="admin/files/produto/<?= $pi['idproduto'] ?>/galeria/<?= $pi['nome_imagem'] ?>"></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="produto-dot">
                    <?php foreach($produto_imagens as $key => $pi): ?>
                    <div>
                        <div class="dot-slide">
                            <img src="admin/files/produto/<?= $pi['idproduto'] ?>/galeria/<?= $pi['nome_imagem'] ?>">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="produto-texto">
                <h2><?= $produto['nome'] ?></h2>
                <span>(Cod.&nbsp;<p><?= $produto['codigo'] ?></p>)</span>
                <p>
                    <?= $produto['resumo'] ?>
                </p>
                <input type="hidden"  id="idproduto" value="<?php echo  $produto['idproduto'] ?>">
                <input type="hidden" id="produto_qtd" value="1">
                <a href="orcamento" type="button" onclick="adicionarOrcamento()" class="adicionarBtn">Adicionar ao orçamento</a>
                <a href="revendedor" class="revendedorBtn">Seja um revendedor</a>
                <?php $numero_apenas = preg_replace('/[^0-9]/', '', $produto['numero_whatsapp']); ?>
                <a href="https://wa.me/55<?php echo $numero_apenas;?>?text=Fale+agora+com+um+consultor" class="zapBtn" target="_blank"><i class="fab fa-whatsapp"></i> Fale agora com um consultor</a>
            </div>
            <div class="produto-descricao">
                <div class="nav-infos">
                    <button class="infoBtn navBtn"><span></span> Informações do produto</button>
                    <?php if(!empty($produto['arquivo'])){ ?>
                    <button class="arquivosBtn"><span></span> Arquivos</button>
                    <?php }?>
                </div>
                <div class="produto-divs">
                    <div class="informacoes descr-ativada">
                        <p>
                            <?= $produto['informacoes'] ?>
                        </p>
                    </div>
                    <?php if(!empty($produto['arquivo'])){ ?>
                        <div class="arquivos">
                            <div class="download-slide">
                                <div class="ds-img">
                                    <a href="admin/files/produto/<?= $produto['arquivo'] ?>" download target="_blank"><img src="imagens/revenda/doc.png"></a>
                                </div>
                                <div class="ds-text">
                                    <h4><?= $produto['nome_arquivo'] ?></h4>
                                    <p>
                                        <?= $produto['resumo_arquivo'] ?>
                                    </p>
                                </div>
                                <div class="ds-link">
                                    <a href="admin/files/catalogos/<?= $produto['arquivo'] ?>" download target="_blank"><img src="imagens/revenda/download.png"></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                    <?php foreach($produtos_relacionados as $key => $pdr): ?>
                    <div>
                        <div class="lancamento-slide">
                            <a><img src="admin/files/produto/<?= $pdr['idproduto'] ?>/<?= $pdr['imagem'] ?>"></a>
                            <div class="lancamento-text">
                                <h6><?= $pdr['nome'] ?></h6>
                                <p><?= $pdr['resumo'] ?></p>
                                <input type="hidden"  id="idproduto" value="<?php echo  $pdr['idproduto'] ?>">
                                <input type="hidden" id="produto_qtd" value="1">
                                <a class="orcamento-btn2" type="button" href="produtos/<?= $pdr['urlrewrite'] ?>">Ver Produto</a>
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
</main>