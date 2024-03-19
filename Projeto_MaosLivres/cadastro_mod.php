<main>
    <section class="botoes" id="botoes">
        <div class="container
        ">
            <img src="imagens/icone.png">
            <a class="ativo carrinho-btn">Meu orçamento</a>
            <a class="ativo carrinho-btn"><i class="fas fa-chevron-right"></i>Cadastro</a>
            <a class="desativo carrinho-btn"><i class="fas fa-chevron-right"></i>Finalizado</a>
        </div>
    </section>

    <section class="cadastro" id="cadastro">
        <div class="container">
            <form id="form-cadastro-orcamento" class="form-cadastro-orcamento">
                <div class="form-topo">
                    <h3>Insira seus dados</h3>
                    <span>Faça seu login</span>
                </div>
                <?php 
                    $idProduto = $_SESSION['orcamento'][1]['idproduto'];
                    $nomeProduto = $_SESSION['orcamento'][1]['nome'];
                    $qtde = $_SESSION['orcamento'][1]['qtde'];
                 ?>
                <div class="form-inputs">
                    <input type="hidden" name="idproduto" value="<?php echo $idProduto; ?>">
                    <input type="hidden" name="nomeproduto" value="<?php echo $nomeProduto; ?>">
                    <input type="hidden" name="qtde" value="<?php echo $qtde; ?>">
                    <input type="text" name="nome" placeholder="Nome">
                    <input type="text" name="email" placeholder="E-mail">
                    <input type="text" name="telefone" class="phone_br" placeholder="Telefone">
                    <input type="text" name="cpf" class="cpf" placeholder="CPF">
                </div>
                <div class="form-botoes">
                    <button id="enviar-cadastro-orcamento" class="pedidoBtn">Finalizar orçamento</button>
                    <a href="orcamento" class="voltarBtn">Voltar</a>
                </div>
            </form>
        </div>
    </section>
</main>