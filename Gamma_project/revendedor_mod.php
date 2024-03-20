<main>
    <section class="banner">
        <img src="imagens/revenda/banner.png">
        <div class="banner-text">
            <span class="pagina">Segmento</span>
            <span class="titulo">Seja um<br> Revendedor</span>
        </div>
    </section>
    
    <section class="revendedor">
        <div class="container">
            <div class="atuacao">
                <div class="atuacao-text">
                    <h2>Formatos de atuação</h2>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                </div>
                <div class="atuacao-img">
                    <img src="imagens/revenda/img.png">
                </div>
            </div>
            <img src="imagens/revenda/bg.png" class="bg">
            <div class="vantagens">
                <div class="vantagens-img">
                    <img src="imagens/revenda/img.png">
                </div>
                <div class="vantagens-text">
                    <h2>Vantagens da Gamma</h2>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                    <span><img src="imagens/revenda/seta.png"> Lorem ipsum dolor sit amet</span>
                </div>
            </div>
        </div>
    </section>
    
    <section class="download">
        <div class="container">
            <div class="download-titulo">
                <h2><img src="imagens/sobre/numeros.png"> Materiais para download</h2>
            </div>
            <div class="download-content">
                <div class="download-slider">
                    <?php foreach($documentos as $key => $c): ?>
                    <div>
                        <div class="download-slide">
                            <div class="ds-img">
                                <a href="admin/files/documentos/<?= $c['arquivo'] ?>" download target="_blank"><img src="imagens/revenda/doc.png"></a>
                            </div>
                            <div class="ds-text">
                                <h4><?= $c['nome'] ?></h4>
                                <p>
                                    <?= $c['resumo'] ?>
                                </p>
                            </div>
                            <div class="ds-link">
                                <a href="admin/files/documentos/<?= $c['arquivo'] ?>" download target="_blank"><img src="imagens/revenda/download.png"></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <i class="fas fa-chevron-left prev-download"></i>
                <i class="fas fa-chevron-right next-download"></i>
            </div>
        </div>
    </section>
    
    <section class="numeros">
        <div class="container">
            <div class="numeros-titulo">
                <h2><img src="imagens/sobre/numeros.png"> Números da Marca</h2>
            </div>
            <div class="numeros-box" id="counter">
                <?php foreach($features as $key => $f): ?>
                <div class="num-box">
                    <h2 class="count started"><?= $f['numero'] ?></h2>
                    <p>
                        <?= $f['prefixo'] ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="formulario">
        <div class="container">
            <div class="formulario-titulo">
                <h2><img src="imagens/revenda/Frame 1.png"> Formulário de Cadastro</h2>
            </div>
            <form id="form-revendedor" class="form">
                <input type="" id="nome" name="nome" placeholder="Nome completo">
                <input type="" class="phone_br" id="telefone" name="telefone" placeholder="Telefone">
                <input type="" id="email" name="email" placeholder="E-mail">
                <select name="interesse" class="">
                    <option>Título de interesse</option>
                    <option>Assunto 1</option>
                    <option>Assunto 2</option>
                    <option>Assunto 3</option>
                    <option>Assunto 4</option>
                </select>
                <div>
                    <label for="arquivo"><img src="imagens/revenda/input.png"> Anexo</label>
                    <input type="file" name="arquivo" id="arquivo" placeholder="Anexo">
                </div>
                <textarea id="mensagem" name="mensagem" placeholder="Digite seu texto..." rows="7" cols="50"></textarea>
                <button id="enviar-revendedor" class="enviar">Enviar</button>
            </form>
        </div>
    </section>
</main>