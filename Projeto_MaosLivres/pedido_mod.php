<main>
    <section class="botoes" id="botoes">
        <div class="container
        ">
            <img src="imagens/icone.png">
            <a class="ativo carrinho-btn">Meu orçamento</a>
            <a class="ativo carrinho-btn"><i class="fas fa-chevron-right"></i>Cadastro</a>
            <a class="ativo carrinho-btn"><i class="fas fa-chevron-right"></i>Finalizado</a>
        </div>
    </section>

    <section class="pedido" id="pedido">
        <div class="container">
            <div class="pedido-content">
                <div class="pedido-numero">
                    <h3>Nº Orçamento</h3>
                    <?php
                        session_start(); // Inicia a sessão (deve ser a primeira instrução em arquivos PHP que usam sessões)

                        // Se o número do orçamento estiver definido na sessão, exibe-o
                        if(isset($_SESSION['dados']['numero_orcamento'])) {
                            echo "<h2>Nº " . $_SESSION['dados']['numero_orcamento'] . "</h2>";
                        } else {
                            echo "<h2>Nº de Orçamento não disponível</h2>";
                        }
                    ?>
                </div>
                <div class="pedido-text">
                    <h2>Verifique seu e-mail, o orçamento já foi enviado!</h2>
                </div>
            </div>
        </div>
    </section>
</main>