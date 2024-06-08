<?php $render('header')?>

<!-- Menu -->
<div class="menu" id="menu">
    <nav class="container">
        <!-- <div class="menu-drop">
            <i class="fa-solid fa-bars"></i>
            <a href="#">Exemplo</a>
            <i class="fa-solid fa-chevron-down"></i>
        </div> -->
        <div class="menu-item">
            <a href="#pagamentos">Pagamentos</a>
        </div>
        |
        <div class="menu-item">
            <a href="#beneficios">Benefícios</a>
        </div>
        |
        <div class="menu-item">
            <a href="#ponto">Ponto eletrônico</a>
        </div>
        |
        <div class="menu-item">
            <a href="#canais">Canais de denúncia</a>
        </div>
</div>
</nav>

<!-- Pagamentos -->
<section class="pagamentos" id="pagamentos">
    <div class="container">
        <div class="pagamentos-titulo">
            <h2>
                <i class="fa-solid fa-sack-dollar"></i>
                Pagamentos
            </h2>

        </div>

        <div class="box-pagamentos">
            <div class="itens-pagamentos box1-pagamentos">
                <img src="<?=$base?>/assets/icons/pagar.png" alt="">
                <h2>Adiantamento</h2>
                <p>Adiantamento salarial de 40% no dia 15 do mês. Saldo de salário creditado no ultimo dia de cada mês.
                </p>
            </div>
            <div class="itens-pagamentos box2-pagamentos">
                <img src="<?=$base?>/assets/icons/nota-de-dolar.png" alt="">
                <h2>Faltas</h2>
                <p>No caso de faltas injustificadas, o funcionário terá descontado o dia de trabalho, o descanso semanal
                    remunerado e feriado na semana, se houver.
                </p>
            </div>
            <div class="itens-pagamentos box3-pagamentos">
                <img src="<?=$base?>/assets/icons/mala-de-viagem.png" alt="">
                <h2>Inicialização</h2>
                <p>No 1º mês de trabalho, o funcionário não receberá nenhum adiantamento salarial, devendo aguardar até
                    o final do mês para receber.</p>
            </div>
        </div>
    </div>
</section>


<!-- Benefícios -->
<section class="beneficios" id="beneficios">
    <div class="container">
        <div class="beneficios-titulo">
            <h2>
                <i class="fa-solid fa-user-plus"></i>
                Benefícios

            </h2>

        </div>

        <div class="box-beneficios">
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-vr.png" alt="">
                <h2>VR Pae</h2>
                <p>Vale-Refeição do Programa de Alimentação do Trabalhador.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-vr.png" alt="">
                <h2>VR Nutrição</h2>
                <p>Vale-Refeição para alimentação saudável e balanceada.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-vr.png" alt="">
                <h2>VR Seguro</h2>
                <p> Vale-Refeição para garantir a segurança alimentar dos trabalhadores..</p>

            </div>
        </div>
        <div class="box-beneficios">
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-totalpass.png" alt="">
                <h2>TotalPass </h2>
                <p>Programa de acesso a academias e atividades físicas.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/icone-ginastica.png" alt="">
                <h2>Ginástica Laboral</h2>
                <p>Exercícios físicos realizados no ambiente de trabalho.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-ferias.png" alt="">
                <h2>Férias</h2>
                <p>Período de descanso remunerado para os trabalhadores.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-estacionamento.png" alt="">
                <h2>Estacionamento</h2>
                <p>Vaga para estacionamento de veículos dos colaboradores.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-farmacia.png" alt="">
                <h2>Farmácia</h2>
                <p>Benefício de desconto em medicamentos e produtos farmacêuticos.</p>
            </div>
            <div class="itens-beneficios">
                <img src="<?=$base?>/assets/images/logo-vale-transporte.png" alt="">
                <h2>Vale Transporte</h2>
                <p>Auxílio para cobrir despesas de transporte público dos trabalhadores.</p>
            </div>

            <span><i class="fa-solid fa-triangle-exclamation"></i>Todos os funcionários são avaliados no prazo de 90
                dias pelo gestor da área. Após a experiência, o funcionário adquire os benefícios ofertados.</span>

        </div>
    </div>
</section>

<!-- Ponto eletrônico -->
<section class="ponto d-flex" id="ponto">
    <div class="ponto-container d-flex">
        <div class="ponto-conteudo d-flex">
            <div class="container d-flex">
                <div class="ponto-text d-flex">
                    <h3>PONTO ELETRÔNICO</h3>
                    <p>
                        De acordo com a Portaria <strong>Nº 1.510</strong>, todos os colaboradores devem registrar o
                        ponto eletrônico em momentos específicos: na entrada do trabalho, na saída para o almoço, no
                        retorno do almoço e na saída do trabalho. A tolerância para o registro do ponto é de 10 minutos.
                        <br>
                        <br>
                        É importante observar que as horas extras só poderão ser realizadas mediante solicitação e
                        aprovação do gestor da área. Além disso, caso haja a utilização do aplicativo de registro de
                        ponto (Tangerino), é necessário que seja feito apenas nos setores de trabalho designados,
                        evitando seu uso fora desses locais.
                    </p>
                    <div class="ponto-topicos d-flex">
                        <div class="topico1 d-flex">
                            <h4>Horas extras</h4>
                            <span><i class="fas fa-check laranja"></i> Solicitação e aprovação necessárias.</span>
                            <span><i class="fas fa-check laranja"></i> Pagamento varia: 50%, 60%. </span>
                            <span><i class="fas fa-check laranja"></i> 100% (finais de semana/feriados).</span>
                            <!-- </div> -->
                            <!-- <br> -->
                            <!-- <div class="topico2 d-flex"> -->
                            <h4>Registro de ponto</h4>
                            <span><i class="fas fa-check laranja"></i> Pontualidade obrigatória, com margem de 10
                                minutos.</span>
                            <span><i class="fas fa-check laranja"></i> Restrito aos setores de trabalho.</span>

                            <!-- <br> -->

                            <h4>Banco de horas</h4>
                            <span><i class="fas fa-check laranja"></i> Acúmulo de horas extras.</span>
                            <span><i class="fas fa-check laranja"></i> Compensação ou pagamento após 4 meses.</span>
                        </div>
                    </div>
                </div>
                <div class="ponto-img d-flex">
                    <img src="<?=$base?>/assets/images/imagem-ponto3.png" alt="imagem">
                </div>
            </div>
        </div>
</section>


<!-- Canais de denuncia -->
<section class="canais d-flex" id="canais">
    <div class="canais-container d-flex">
        <div class="canais-conteudo d-flex">
            <div class="container d-flex">
                <div class="canais-text d-flex">
                    <h3>CANAIS DE DENÚNCIA</h3>
                    <div class="canais-topicos d-flex">
                        <div class="topico1 d-flex">
                            <span><i class="fas fa-check laranja"></i> Perseguição ou submissão da vítima a pequenos
                                ataques repetidos.</span>
                            <span><i class="fas fa-check laranja"></i> Se expressa por diversas atitudes do assediador,
                                não necessariamente ilícitas, concretizadas de várias maneiras (gestos, palavras,
                                atitudes, omissões). </span>
                            <span><i class="fas fa-check laranja"></i> Prática repetida, sistemática.</span>
                            <!-- </div> -->
                            <!-- <br> -->
                            <!-- <div class="topico2 d-flex"> -->
                            <span><i class="fas fa-check laranja"></i> Criação de uma relação assimétrica de dominante e
                                dominado psicologicamente.</span>
                            <span><i class="fas fa-check laranja"></i> Utilização de recurso e meios insidiosos, sutis,
                                que visam diminuir a capacidade de defesa do assediado.</span>
                            <!-- <br> -->
                            <span><i class="fas fa-check laranja"></i> Pode ter motivações variadas por parte do
                                assediador.</span>
                            <span><i class="fas fa-check laranja"></i> Destruição da identidade da vítima, violação da
                                dignidade pessoal, profissional e, sobretudo, da integridade psicofísica do
                                assediado.</span>
                            <span><i class="fas fa-check laranja"></i> Danos à saúde mental do assediado.</span>
                            <span><i class="fas fa-check laranja"></i> Coloca em risco a manutenção do emprego da
                                vítima.</span>
                            <span><i class="fas fa-check laranja"></i> Degrada seu ambiente de trabalho.</span>
                        </div>
                    </div>
                    <p>
                        Está passando por uma situação descrita acima?
                        <br>
                        <br>
                        Acesso o formulário via QRCODE e preencha o formulário para que possamos auxiliar no combate a
                        situações como essas!​
                    </p>
                </div>

                <div class="canais-img d-flex">
                    <img src="<?=$base?>/assets/images/qr-code.png" alt="imagem">
                </div>

            </div>
        </div>
</section>

<?php $render('footer')?>