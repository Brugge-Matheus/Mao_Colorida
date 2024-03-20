<main>
    <section class="sac">
    	<div class="container">
    		<div class="sac-titulo">
    			<img src="imagens/contato/sac.png">
    			<div class="text">
    				<h4>Fale conosco</h4>
    				<span>Sac</span>
    			</div>
    		</div>
    		<span class="sac-div"></span>
    		<div class="sac-infos">
    			<h3>Gamma Distribuidora de Lubrificantes Ltda.</h3>
    			<a href="" target="_blank"><img src="imagens/contato/call.png"> (41)3059-4800</a>
    			<a href="" target="_blank"><img src="imagens/contato/mail.png"> atendimento@gammadistribuidora.com.br</a>
    			<a href="https://maps.app.goo.gl/vN8udS6GHy7YLrgD8" target="_blank"><img src="imagens/contato/map.png"> Rua Jão Lunardelli, 80 - Cidade Industrial, Curitiba - PR, 81460-100</a>
    		</div>
    	</div>
    </section>

    <section class="trabalhe">
    	<div class="container">
    		<div class="trabalhe-img">
    			<img src="imagens/contato/img.png">
    		</div>
    		<div class="trabalhe-text">
    			<h2>Trabalhe conosco</h2>
    			<p>
    				It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
    			</p>
    			<a class="curriculoBtn">Enviar curriculo <img src="imagens/contato/upload.png"></a>
    			<a href="" class="vagasBtn" target="_blank">Ver vagas <img src="imagens/contato/seta.png"></a>
    		</div>
    	</div>
    </section>

    <section class="endereco">
    	<div class="container">
    		<div class="endereco-titulo">
    			<h2><img src="imagens/contato/Frame 1.png"> Nosso endereço</h2>
                <a href="https://maps.app.goo.gl/vN8udS6GHy7YLrgD8" target="_blank">Rua João Lunardelli, 80 - Cidade Industrial, Curitiba - PR, 81460-100</a>
    		</div>
    		<div class="endereco-mapa">
    			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3599.8773937240844!2d-49.313815123702064!3d-25.542460637352658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dcef64573de11b%3A0x2ece18dc7ee18c74!2sGamma%20Distribuidora%20de%20Lubrificantes!5e0!3m2!1spt-BR!2sbr!4v1698416836864!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    		</div>
    	</div>
    </section>

    <section class="contato">
    	<div class="container">
    		<div class="contato-info">
    			<h2>Fale conosco</h2>
                <a href="" target="_blank"><img src="imagens/contato/call.png"> (41)3059-4800</a>
                <a href="" target="_blank"><img src="imagens/contato/mail.png"> atendimento@gammadistribuidora.com.br</a>
                <a href="" target="_blank"><img src="imagens/contato/insta-pin.png"> @gammadistribuidora</a>
                <a href="" target="_blank"><img src="imagens/contato/face-pin.png"> Gamma Distribuidora</a>
    		</div>
    		<form id="form-contato" class="contato-form">
								<div class="contato-opcoes" name="assunto">
									<label class="ratio">
										<input type="radio" value="sac" checked="checked" name="opcao_contato">
										<a class="btnRatio">SAC</a> 
									</label>
									<label class="ratio">
										<input type="radio" value="financeiro" name="opcao_contato">
										<a class="btnRatio">Financeiro</a>    
									</label>
									<label class="ratio">
											<input type="radio" value="comercial" name="opcao_contato">
										<a class="btnRatio">Comercial</a>
									</label>
									<label class="ratio">
											<input type="radio" value="rh" name="opcao_contato">
										<a class="btnRatio">RH</a>
									</label>     
								</div>
                <div class="form">
                    <input type="text" name="nome" placeholder="Nome completo">
                    <input type="text" class="phone_br" name="telefone" placeholder="Telefone">
                    <input type="text" name="email" placeholder="E-mail">
                    <textarea placeholder="Digite seu texto..." rows="7" cols="50"></textarea>
                    <button id="enviar-contato">Enviar</button>
                </div>
    		</form>
    	</div>
    </section>

    <div class="modal-trabalhe">
        <div class="modal-bg"></div>
        <form id="form-trabalhe-conosco" class="form">
            <span class="fechar-trabalhe">x</span>
            <input type="text" name="nome" id="trabalhe-nome" placeholder="Nome completo">
            <input type="text" class="phone_br" id="trabalhe-telefone" name="telefone" placeholder="Telefone">
            <input type="text" name="email" id="trabalhe-email" placeholder="E-mail">
            <input type="text" name="mensagem" id="trabalhe-mensagem" placeholder="Assunto">
            <div>
                <label for="trabalhe-curriculo">Anexar curriculo <img src="imagens/contato/paperclip.png"></label>
                <input type="file" name="arquivo" id="trabalhe-curriculo" placeholder="Anexo">
            </div>
            <button id="enviar-trabalhe-conosco">Enviar</button>
        </form>
    </div>
</main>