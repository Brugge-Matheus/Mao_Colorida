<main>
    <section class="botoes" id="botoes">
        <div class="container">
            <img src="imagens/icone.png">
            <a class="ativo carrinho-btn">Meu orçamento</a>
            <a class="desativo carrinho-btn"><i class="fas fa-chevron-right"></i>Cadastro</a>
            <a class="desativo carrinho-btn"><i class="fas fa-chevron-right"></i>Finalizado</a>
        </div>
    </section>

    <section class="orcamento" id="orcamento">
        <div class="container">
            <?php if(!empty($_SESSION['orcamento'])){ ?>
            <div class="carrinho">
                <?php foreach($_SESSION['orcamento'] as $key => $item): ?>
                <div class="carrinho-box">
                    <div class="box-img">
                        <img src="admin/files/produto/<?= $item['idproduto'] ?>/<?= $item['imagem'] ?>">
                    </div>
                    <div class="box-nome">
                        <h4><?= $item['nome'] ?></h4>
                        <p><?= $item['codigo'] ?></p>
                    </div>
                    <div class="box-input">
                        <p>qtd.</p>
                        <div class="input">
                            <a class="remover">-</a>
                            <input type="number" name="" id="qtd" value="<?= $item['qtde']?>">
                            <a class="adicionar">+</a>
                        </div>
                        <a onclick="remove(<?php echo $item['idproduto']; ?>)" class="remover-produto">Remover</a>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="continuar">
                    <a href="produtos" class="produtosBtn2">Ver mais produtos</a>
                    <a href="cadastro" class="continuarBtn">Continuar</a>
                </div>
            </div>
            <?php } else{ ?>
            <div class="carrinho-vazio">
                <h2>Você não possui produtos no seu carrinho!</h2>
                <a href="produtos" class="produtoBtn">Veja nossos produtos</a>
            </div>
            <?php } ?>
        </div>
    </section>
</main>