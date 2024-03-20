<footer class="main-footer">
	<div class="container">
    <div class="footer-logo">
      <a href=""><img src="imagens/header/logo2.png"></a>
      <a href="">Rua João Lunardelli, 80 - Cidade Industrial,<br> Curitiba - PR, 81460-100</a>
      <a href=""> (41)3059-4800</a>
    </div>
    <div class="footer-acess">
      <div class="footer-column">
        <span>Menu</span>
        <a href="">Início</a>
        <a href="">Quem somos</a>
        <a href="">Contatos</a>
        <a href="">Blog</a>
        <a href="">Trabalhe conosco</a>
      </div>
      <div class="footer-column">
        <span>Categorias</span>
        <?php 
          include_once __DIR__.'/../admin/linhas_class.php';

          $linhas = buscaLinhas(array('status' => '1'));
        ?>
        <?php foreach($linhas as $key => $l): ?>
        <a href="produtos/linhas/<?= $l['urlrewrite'] ?>"><?= $l['nome'] ?></a>
        <?php endforeach; ?>
        <a href="produtos/marcas">Marcas</a>
        <a href="segmentos">Segmentos</a>
      </div>
      <div class="footer-column">
        <span>Nós Acompanhe nas redes</span>
        <a href="">Linkedin</a>
        <a href="">Instagram</a>
        <a href="">Facebook</a>
      </div>
    </div>
  </div>
  <div class="copyright">
    <span>@2023 Gamma Distribuidora. Todos os direitos reservados</span>
    <a target="_blank" href="https://agencia.red" class="img-container">
      <img src='imagens/header/red.png' alt='imagem' />
    </a>
  </div>
</footer>

<div class="flutuante d-flex">
    <a href="" target="_blank"><img src="imagens/header/zap.png" alt=""></a>
</div>

<div class="lgpd-cookies">
    <div class="lgpd-texto">
		<p>Utilizamos cookies e outras tecnologias semelhantes para melhorar a sua experiência, de acordo com a nossa Política de Privacidade e, ao continuar navegando, você concorda com estas condições.
      <strong>Para falar sobre LGPD: </strong><a href="mailto:atendimento@gammadistribuidora.com.br" class="lgpd-link">atendimento@gammadistribuidora.com.br</a>
		</p>
    </div>

    <div class="lgpd-botoes">
        <button class="lgpd-botao continuar">Continuar navegando</button>
        <button class="lgpd-botao sair">Sair</button>
    </div>
</div>