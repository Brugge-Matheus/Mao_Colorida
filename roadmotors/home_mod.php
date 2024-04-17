<main>
    <section class="banner">
        <span class="prev-bn arrow"><i class="fas fa-chevron-left"></i></span>
        <div class="banner-slider">
            <?php foreach($banners as $key => $b): ?>
            <div>
                <div class="banner-slide">
                    <picture>
                        <source media='(max-width:768px)' srcset='admin/files/banner/<?= $b['banner_mobile'] ?>'>
                        <img src='admin/files/banner/<?= $b['banner_full'] ?>' alt='imagem' />
                    </picture>
                    <!-- <div class="absolute-container">
                        <div class="container">
                            <div class="texto d-flex">
                                <h2>
                                    A SUA OFICINA PREMIUM LAND ROVER
                                </h2>
                                <p class="cor-1">
                                    Profissionalismo e cuidado com todos os modelos Land Rover
                                </p>
                                <div class="d-flex">
                                    <h3>RANGE ROVER</h3>
                                    <span>|</span>
                                    <h3>DEFENDER</h3>
                                    <span>|</span>
                                    <h3>DISCOVERY</h3>
                                </div>
                                <a class="scale1 scroll-to" data-target="contato"><?= $b['titulo_botao'] ?><i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div> -->
                    <a class="scale1 scroll-to" data-target="contato"><?= $b['titulo_botao'] ?><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <span class="next-bn arrow"><i class="fas fa-chevron-right"></i></span>
    </section>

    <section class="contato-1 d-flex">
        <div class="container d-flex">
            <span class="barra"></span>
            <div class="texto d-flex column">
                <div class="titulo">
                    <h2>ASSISTÊNCIA<br>ESPECIALIZADA</h2>
                </div>
                <div class="conteudo d-flex">
                    <img class="bg" src="imagens/home/barra.png" alt="">
                    <div class="boxs-div d-flex column">
                        <div class="box">
                            <div class="icon d-flex">
                                <img src="imagens/home/icon1.png" alt="">
                            </div>
                            <div class="box-texto d-flex column">
                                <span class="cor-2">PASSO 01</span>
                                <h4 class="primaria">PREENCHA O FORMULÁRIO</h4>
                                <p class="cor-1">
                                    Envie suas informações de contato e a placa do seu carro.
                                </p>
                            </div>
                        </div>
                        <div class="div d-flex"></div>
                        <div class="box">
                            <div class="icon d-flex">
                                <img src="imagens/home/icon2.png" alt="">
                            </div>
                            <div class="box-texto d-flex column">
                                <span class="cor-2">PASSO 02</span>
                                <h4 class="primaria">RECEBA UMA LIGAÇÃO</h4>
                                <p class="cor-1">
                                    Após preencher o formulário ao lado você receberá uma ligação em até 12 horas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" id="form-contato2" class="d-flex column">
                <p class="cor-1">Preencha as informações abaixo que entraremos em contato com você.</p>
                <input type="text" name="nome" placeholder="Seu nome">
                <input type="text" name="email" placeholder="Email">
                <input type="text" class="phone_with_ddd" name="telefone" placeholder="(DDD) | Telefone">
                <input type="text" name="placa" maxlength=7 placeholder="Placa do veículo">
                <button class="scale1" id="enviar-contato2">ENVIAR <i class="fas fa-chevron-right"></i></button>
                <span class="cor-1"><img src="imagens/home/safe.png" alt=""> Seus dados estão seguros!</span>
            </form>
        </div>
    </section>

    <section class="servicos" id="servicos">
        <div class="container d-flex">
            <span class="barra"></span>
            <div class="titulo d-flex">
                <h2 class="branco">CONHEÇA NOSSOS SERVIÇOS</h2>
                <div class="arrow desktop">
                    <span class="prev-serv"><i class="fas fa-chevron-left"></i></span>
                    <span class="next-serv"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>
            <div class="servicos-slider">
                <?php foreach($servicos as $key => $s): ?>
                <div class="">
                    <div class="box d-flex">
                        <div class="texto d-flex column">
                            <h2 class="branco"><?= $s['nome'] ?></h2>
                            <p class="cor-1">
                               <?= $s['resumo'] ?>
                            </p>
                            <a href="<?= $s['link'] ?>" class="scale1 scroll-to" data-target="contato">ENTRAR EM CONTATO <i class="fas fa-chevron-right"></i></a>
                        </div>
                        <img src="admin/files/servicos/<?= $s['imagem'] ?>" alt="">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="arrow mobile">
                <span class="prev-serv"><i class="fas fa-chevron-left"></i></span>
                <span class="next-serv"><i class="fas fa-chevron-right"></i></span>
            </div>
        </div>
    </section>

    <section class="diferenciais d-flex" id="diferenciais">
        <div class="container d-flex">
            <div class="titulo d-flex column">
                <span class="barra"></span>
                <h2>NOSSOS DIFERENCIAIS</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <div class="diferenciais-div d-flex">
                <div class="diferenciais-nav">
                    <?php foreach($diferenciais as $key => $diftopo): ?>
                    <div>
                        <a class="box">
                            <?= $diftopo['nome'] ?>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="diferenciais-for">
                    <?php foreach($diferenciais as $key => $dif): ?>
                    <div>  
                        <div class="box d-flex">
                            <div class="texto d-flex column">
                                <h3><?= $dif['titulo'] ?></h3>
                                <p>
                                    <?= $dif['resumo'] ?>
                                </p>
                                <a class="scroll-to" data-target="contato">ENTRAR EM CONTATO <i class="fas fa-chevron-right"></i></a>
                            </div>
                            <div class="img d-flex">
                                <img src="admin/files/diferenciais/<?= $dif['imagem'] ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="objetivos d-flex" id="sobre">
        <div class="texto column d-flex">
            <span class="barra"></span>
            <h3 class="branco"><?= $v['titulo'] ?></h3>
            <p>
                <?= $v['resumo'] ?>
            </p>
            <div class="box-div d-flex column">
                <?php foreach($valores as $key => $vs): ?>
                <div class="box">
                    <div class="icon d-flex">
                        <i class="fas fa-<?= $vs['icone_name'] ?>"></i>
                    </div>
                    <div class="b-texto d-flex column">
                        <h3><?= $vs['nome'] ?></h3>
                        <p>
                            <?= $vs['texto'] ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="img d-flex">
            <img src="imagens/home/img3.png" alt="">
        </div>
    </section>

    <section class="equipe d-flex" id="equipe">
        <div class="container column d-flex">
            <div class="titulo d-flex column">
                <span class="barra"></span>
                <h2>VOCÊ MERECE UM PROFISSIONAL EM QUEM POSSA CONFIAR</h2>
                <p class="cor-1">
                    Conte com uma equipe de especialistas comprometidos em proporcionar a você o melhor atendimento, 100% personalizado, que atenda às suas necessidades e as particularidades do seu veículos.
                </p>
            </div>
            <div class="equipe-slider">
                <?php foreach($equipe as $key => $e): ?>
                <div class="">
                    <div class="box d-flex">
                        <img src="admin/files/equipe/<?= $e['imagem'] ?>" alt="">
                        <div class="texto d-flex column">
                            <h4 class="branco"><?= $e['nome'] ?></h4>
                            <span class="barra"></span>
                            <p><?= $e['descricao'] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="arrow">
                <span class="prev-equip"><i class="fas fa-chevron-left"></i></span>
                <span class="next-equip"><i class="fas fa-chevron-right"></i></span>
            </div>
        </div>   
    </section>

    <section class="depoimentos column d-flex">
            <div class="titulo column d-flex">
                <span class="barra"></span>
                <h2 class="branco">O QUE NOSSOS CLIENTES DIZEM</h2>
                <div class="arrow desktop">
                    <span class="prev-depo"><i class="fas fa-chevron-left"></i></span>
                    <span class="next-depo"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>
            <div class="depoimentos-slider">
                <?php foreach($depoimento as $key => $d): ?>
                <div>
                    <div class="box d-flex">
                        <p class="cor-1">
                           <?= $d['depoimento'] ?>
                        </p>
                        <div class="infos d-flex">
                            <div class="user d-flex">
                                <div class="img d-flex">
                                    <img src="admin/files/depoimento/<?= $d['imagem'] ?>" alt="">
                                </div>
                                <div class="texto d-flex column">
                                    <h4><?= $d['nome'] ?></h4>
                                    <span class="cor-1"><?= $d['subtitulo'] ?></span>
                                </div>
                            </div>
                            <span class="barra"></span>
                            <div class="veiculo d-flex column">
                                <span class="cor-1">Veículo</span>
                                <h4><?= $d['veiculo'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="arrow mobile">
                <span class="prev-depo"><i class="fas fa-chevron-left"></i></span>
                <span class="next-depo"><i class="fas fa-chevron-right"></i></span>
            </div>
    </section>

    <section class="numeros d-flex">
        <div class="texto column d-flex">
            <span class="barra"></span>
            <h3 class="primaria">NÚMEROS<br>IMPULSIONAM</h3>
            <div class="box-div d-flex column" id="counter">
                <?php foreach($features as $key => $f): ?>
                <div class="box d-flex column">
                    <h3><span><?= $f['prefixo'] ?></span> <span class="count"><?= $f['numero'] ?></span> <?= $f['sufixo'] ?></h3>
                    <p>
                        <?= $f['titulo'] ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="img d-flex">
            <img src="imagens/home/img4.png" alt="">
        </div>
    </section>

    <section class="contato-1 d-flex" id="contato">
        <div class="container d-flex">
            <span class="barra"></span>
            <div class="texto d-flex column">
                <div class="titulo">
                    <h2 class="branco">ENTRE EM CONTATO<br>CONOSCO</h2>
                </div>
                <div class="conteudo d-flex">
                    <img class="bg" src="imagens/home/barra.png" alt="">
                    <div class="boxs-div d-flex column">
                        <div class="box">
                            <div class="icon d-flex">
                                <img src="imagens/home/icon1.png" alt="">
                            </div>
                            <div class="box-texto d-flex column">
                                <span class="cor-2">PASSO 01</span>
                                <h4 class="branco">PREENCHA O FORMULÁRIO</h4>
                                <p class="cor-1">
                                    Envie suas informações de contato e a placa do seu carro.
                                </p>
                            </div>
                        </div>
                        <div class="div d-flex"></div>
                        <div class="box">
                            <div class="icon d-flex">
                                <img src="imagens/home/icon2.png" alt="">
                            </div>
                            <div class="box-texto d-flex column">
                                <span class="cor-2">PASSO 02</span>
                                <h4 class="branco">RECEBA UMA LIGAÇÃO</h4>
                                <p class="cor-1">
                                    Em até 12 horas, um dos nossos especialistas fará uma ligação para entender como podemos te ajudar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" class="d-flex column">
                <p class="cor-1">Preencha as informações abaixo que entraremos em conato com você.</p>
                <input type="text" placeholder="Seu nome">
                <input type="text" placeholder="Email">
                <input type="text" placeholder="(DDD) | Telefone">
                <input type="text" placeholder="Placa do veículo">
                <button class="scale1">ENVIAR <i class="fas fa-chevron-right"></i></button>
                <span class="cor-1"><img src="imagens/home/safe.png" alt=""> Seus dados estão seguros!</span>
            </form>
        </div>
    </section>
</main>