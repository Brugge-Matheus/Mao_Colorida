<?=$render('header')?>
<main>
    <section class="sac">
        <div class="container">
            <div class="sac-titulo">
                <img src="./assets/icons/sac.jpg">
                <div class="text">
                    <h4>Fale conosco</h4>
                    <span>Sac</span>
                </div>
            </div>
            <span class="sac-div"></span>
            <div class="sac-infos">
                <h3>Mão Colorida Ltda.</h3>
                <a href="tel:+31227550"><i class="fa-solid fa-phone"></i>+55 (41) 3122-7550</a>
                <a href="mailto:maocolorida@maocolorida.com.br?subject=Dúvida&body=Olá, gostaria de tirar uma dúvida"><i
                        class="fa-solid fa-envelope"></i>
                    maocolorida@maocolorida.com.br</a>
                <a href="https://maps.app.goo.gl/vN8udS6GHy7YLrgD8" target="_blank"><i
                        class="fa-solid fa-location-dot"></i>
                    R. Augusto Dias Paredes,68 Boqueirão, Curitiba/PR, Brasil</a>
            </div>
        </div>
    </section>

    <section class="contato" id="sac-contato">
        <div class="container">
            <div class="contato-info">
                <h2>Fale conosco</h2>
                <a href="" target="_blank"><i class="fa-solid fa-phone"></i> +55 (41) 3122-7550</a>
                <a href="" target="_blank"><i class="fa-solid fa-envelope"></i> maocolorida@maocolorida.com.br</a>
                <a href="https://www.instagram.com/maocoloridacv/?hl=pt#" target="_blank"><i
                        class="fa-brands fa-instagram"></i> @maocolorida</a>
                <a href="http://linkedin.com.br/company/m%C3%A3o-colorida" target="_blank"><i
                        class="fa-brands fa-linkedin"></i> Mão Colorida</a>
            </div>
            <div class="form-div d-flex column">
                <?php if (!empty($flash)): ?>
                <div class="flash"><?= htmlspecialchars($flash) ?></div>
                <?php elseif (!empty($correct)): ?>
                <div class="correct"><?= htmlspecialchars($correct) ?></div>
                <?php endif; ?>
                <div class="botoes-form">
                    <button class="sac-b ativo" id="btn-contato" data-target="sac-f">Contato</button>
                    <button class="financeiro-b" id="btn-trabalhe" data-target="financeiro-f">Indicações</button>
                </div>
                <form id="form-sac" class="contato-form sac-f ativado" action="./contato" method="POST">
                    <div class="form">
                        <input type="text" name="nome" placeholder="Nome completo">
                        <input type="text" class="phone_br" name="telefone" placeholder="Telefone">
                        <input type="text" name="email" placeholder="E-mail">
                        <textarea name="body" placeholder="Digite seu texto..." rows="7" cols="50"></textarea>
                        <input type="submit" value="Enviar" id="enviar-financeiro">
                    </div>
                </form>
                <form id="form-financeiro" class="contato-form financeiro-f" action="./trabalhe" method="POST">
                    <div class="form">
                        <input type="text" name="nome" placeholder="Nome completo">
                        <input type="text" class="phone_br" name="telefone" placeholder="Telefone">
                        <input type="text" name="email" placeholder="E-mail">
                        <label for="file-upload" class="custom-file-upload">
                            Anexar currículo <i class="fa-solid fa-paperclip"></i>
                        </label>
                        <input id="file-upload" type="file" name="curriculo" style="display: none;">
                        <input type="submit" value="Enviar" id="enviar-financeiro">
                    </div>
                </form>
            </div>
        </div>
    </section>



    <section class="endereco">
        <div class="container">
            <div class="endereco-titulo">
                <h2><i class="fa-solid fa-earth-americas"></i> Nosso endereço</h2>
                <div class="botoes-mapas">
                    <a class="end-1 ativo" data-target="mapa-1" target="_blank">R. Augusto Dias Paredes, 68 Boqueirão,
                        Curitiba/PR, Brasil</a>
                </div>
            </div>
            <div class="endereco-mapa">
                <iframe class="mapa mapa-1 ativado"
                    src=https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7202.371915956757!2d-49.224693!3d-25.498844!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dcfaec978ab67b%3A0x5ad9a27e725fb733!2sR.%20Augusto%20Dias%20Paredes%2C%2068%20-%20Boqueir%C3%A3o%2C%20Curitiba%20-%20PR%2C%2081730-100%2C%20Brasil!5e0!3m2!1spt-BR!2sus!4v1716507872442!5m2!1spt-BR!2sus"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</main>
<?=$render('footer')?>

<script src="./assets/js/functions.js"></script>