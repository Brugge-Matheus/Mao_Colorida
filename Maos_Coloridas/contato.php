<?php
include 'includes\head.php';
include 'includes\header.php';
?>

<main>
    <section class="sac">
        <div class="container">
            <div class="sac-titulo">
                <img src="icons/sac.png">
                <div class="text">
                    <h4>Fale conosco</h4>
                    <span>Sac</span>
                </div>
            </div>
            <span class="sac-div"></span>
            <div class="sac-infos">
                <h3>Gamma Distribuidora de Lubrificantes Ltda.</h3>
                <a href="" target="_blank"><img src="imagens/contato/call.png"> (41)3059-4800</a>
                <a href="" target="_blank"><img src="imagens/contato/mail.png">
                    atendimento@gammadistribuidora.com.br</a>
                <a href="https://maps.app.goo.gl/vN8udS6GHy7YLrgD8" target="_blank"><img src="imagens/contato/map.png">
                    Rua Jão Lunardelli, 80 - Cidade Industrial, Curitiba - PR, 81460-100</a>
            </div>
        </div>
    </section>

    <section class="contato">
        <div class="container">
            <div class="contato-info">
                <h2>Fale conosco</h2>
                <a href="" target="_blank"><img src="imagens/contato/call.png"> (41)3059-4800</a>
                <a href="" target="_blank"><img src="imagens/contato/mail.png">
                    atendimento@gammadistribuidora.com.br</a>
                <a href="" target="_blank"><img src="imagens/contato/insta-pin.png"> @gammadistribuidora</a>
                <a href="" target="_blank"><img src="imagens/contato/face-pin.png"> Gamma Distribuidora</a>
            </div>
            <div class="form-div d-flex column">
                <div class="botoes-form">
                    <button class="sac-b ativo" data-target="sac-f ">SAC</button>
                    <button class="financeiro-b" data-target="financeiro-f">Financeiro</button>
                </div>
                <form id="form-sac" class="contato-form sac-f ativado">
                    <div class="form">
                        <input type="text" name="nome" placeholder="Nome completo">
                        <input type="text" class="phone_br" name="telefone" placeholder="Telefone">
                        <input type="text" name="email" placeholder="E-mail">
                        <textarea placeholder="Digite seu texto..." rows="7" cols="50"></textarea>
                        <button id="enviar-sac">Enviar</button>
                    </div>
                </form>
                <form id="form-financeiro" class="contato-form financeiro-f">
                    <div class="form">
                        <input type="text" name="nome" placeholder="Nome completo">
                        <input type="text" class="phone_br" name="telefone" placeholder="Telefone">
                        <input type="text" name="email" placeholder="E-mail">
                        <textarea placeholder="Digite seu texto..." rows="7" cols="50"></textarea>
                        <button id="enviar-financeiro">Enviar</button>
                    </div>
                </form>

                </form>
            </div>

        </div>
    </section>

    <section class="endereco">
        <div class="container">
            <div class="endereco-titulo">
                <h2><img src="imagens/contato/Frame 1.png"> Nosso endereço</h2>
                <div class="botoes-mapas">
                    <a class="end-1 ativo" data-target="mapa-1" target="_blank">Jardim Alvorada, Maringá - PR</a>
                    <a class="end-2" data-target="mapa-2" target="_blank">Cidade Industrial, Curitiba - PR</a>
                    <a class="end-3" data-target="mapa-3" target="_blank">Cidade Industrial, Curitiba</a>
                </div>
            </div>
            <div class="endereco-mapa">
                <iframe class="mapa mapa-1 ativado"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3599.868729466371!2d-49.3115719!3d-25.542749199999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dcfc588fbdc9bb%3A0xeeeb81ac7e67ef1a!2sRua%20Jo%C3%A3o%20Lunardelli%2C%2080%20-%20Cidade%20Industrial%2C%20Curitiba%20-%20PR%2C%2081460-100!5e0!3m2!1spt-BR!2sbr!4v1715285737481!5m2!1spt-BR!2sbr"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <iframe class="mapa mapa-2"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3661.891955639386!2d-51.9086851!3d-23.392125599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ecd113d0a8e8d3%3A0x86780efb5a02c130!2sAv.%20Franklin%20Delano%20Roosevelt%2C%201145%20-%20Jardim%20Alvorada%2C%20Maring%C3%A1%20-%20PR%2C%2087035-090!5e0!3m2!1spt-BR!2sbr!4v1715285766800!5m2!1spt-BR!2sbr"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <iframe class="mapa mapa-3"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3661.891955639386!2d-51.9086851!3d-23.392125599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ecd113d0a8e8d3%3A0x86780efb5a02c130!2sAv.%20Franklin%20Delano%20Roosevelt%2C%201145%20-%20Jardim%20Alvorada%2C%20Maring%C3%A1%20-%20PR%2C%2087035-090!5e0!3m2!1spt-BR!2sbr!4v1715285766800!5m2!1spt-BR!2sbr"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
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

<?php include 'includes\footer.php'?>