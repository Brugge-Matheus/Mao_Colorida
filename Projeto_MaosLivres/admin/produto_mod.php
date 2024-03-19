<?php
// Versao do modulo: 3.00.010416

include_once "produto_class.php";
include_once "categoria_class.php";
include_once "linhas_class.php";
include_once "segmento_class.php";
include_once "marcas_class.php";

if (!isset($_REQUEST['acao']))
    $_REQUEST['acao'] = "";

$categorias = buscaCategoria(array("tipocategoria" => 1, "subcategorias" => false, "ordem" => "nome", "dir" => "asc"));
$marcas = buscaMarcas(array('status'=>'A'));
$linhas = buscaLinhas(array('status'=>'A', "ordem" => "nome", "dir" => "asc"));
$segmento = buscaSegmento(array('status'=>'1'));


?>
<link rel="stylesheet" type="text/css" href="produto_css.css"/>
<script type="text/javascript" src="produto_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if ($_REQUEST['acao'] == "formProduto") {
    if ($_REQUEST['met'] == "cadastroProduto") {
        if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
            header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
            exit;
        }
        $action = "produto_script.php?opx=cadastroProduto";
        $metodo_titulo = "Cadastro Produto";
        $idProduto = 0;

        // dados para os campos
        $produto['nome'] = "";
        $produto['codigo'] = "";
        $produto['urlrewrite'] = "";
        $produto['resumo'] = "";
        $produto['imagem'] = "";
        $produto['informacoes'] = "";
        $produto['arquivo'] = "";
        $produto['numero_whatsapp'] = "";
        $produto['status'] = "A";
        $produto['idmarcas'] = "";
        $produto['nome_arquivo'] = "";
        $produto['resumo_arquivo'] = "";
        $produto['idlinhas'] = "";
        $produto['idsegmento'] = "";


        $subs = array();
        $subs['idproduto_categoria'] = 0;
        $modelos = array();
        $produto_categorias = array();
        $produto_quemvoce = array();
        $produto_faq = array();
        $produto_info = array();
    } else {
        if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
            header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
            exit;
        }
        $action = "produto_script.php?opx=editProduto";
        $metodo_titulo = "Editar Produto";
        $idProduto = (int)$_GET['idu'];
        $produto = buscaProduto(array('idproduto' => $idProduto));
        if (count($produto) != 1) exit;
        $produto = $produto[0];
        $subs = buscaProduto(array("teste" => true, 'idproduto' => $idProduto, "inner_categoria" => true, "ordem" => "PC.idproduto_categoria asc"));
        $produto_imagens = buscaProduto_imagem(array("idproduto" => $produto['idproduto'], "ordem" => 'posicao_imagem', "dir" => 'ASC'));
        
        $produto_categorias = buscaProduto_categoria(array('idproduto' => $idProduto));
    }

    $subAtivas = array();
    ?>

    <div id="titulo">
        <img src="images/modulos/produto_preto.png" height="24" width="24" alt="ico"/>
        <span><?php print $metodo_titulo; ?></span>
        <ul class="other_abs">
            <li class="other_abs_li"><a href="index.php?mod=produto&acao=listarProduto">Listagem</a></li>
        </ul>
    </div>

    <div id="principal">
        <form class="form" name="formProduto" id="formProduto" method="post" action="<?php echo $action; ?>"
              onsubmit="return verificarCampos(new Array('nome', 'codigo', 'urlrewrite', 'imagem', 'informacoes')); ">

            <div id="informacaoProduto" class="content">
                <div class="content_tit">Dados Produto:</div>

                <div class="box_ip" style="width:100%;">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" size="30" maxlength="255"
                           value='<?php echo $produto['nome']; ?>' class='required'/>
                </div>

                <div class="box_ip" style="width:100%;">
                    <label for="urlrewrite">Urlrewrite</label>
                    <input type="text" name="urlrewrite" id="urlrewrite" size="30" maxlength="255"
                           value="<?php echo $produto['urlrewrite']; ?>" class='required'/>
                    <input type="hidden" name="urlrewriteantigo" id="urlrewriteantigo"
                           value="<?= $produto['urlrewrite']; ?>"/>
                </div>

                <div class="box_ip" style="width:50%;">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" id="codigo" size="30" maxlength="20"
                           value="<?php echo $produto['codigo']; ?>" class='required'/>
                </div>

                <div class="box_ip" style="width:50%;">
                    <label for="numero_whatsapp">Whatsapp</label>
                    <input type="text" class="phone_br" name="numero_whatsapp" id="numero_whatsapp" size="30" maxlength="255"
                           value='<?php echo $produto['numero_whatsapp']; ?>' class='required'/>
                </div>

                <div class="box_ip">
                    <div class="box_sel box_txt">
                        <label for="idmarcas">Marca</label>
                        <div class="box_sel_d">
                            <select name="idmarcas" id="idmarcas">
                                <option value="" > Selecione </option>
                                <?php foreach ($marcas as $k => $m) { ?>
                                    <option value="<?= $m['idmarcas'] ?>" <?= ($m['idmarcas'] == $produto['idmarcas'] ? ' selected="selected" ' : ''); ?> > <?= $m['nome'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box_ip" style="width:50%;">
                    <label for="status">Status</label>
                    <div class="box_sel">
                        <label for="">Status</label>
                        <div class="box_sel_d">
                            <select name="status" id="status" class='required'>
                                <option value=""></option>
                                <option value="A" <?= ($produto['status'] == "A" ? ' selected="selected" ' : ''); ?> >
                                    Ativo
                                </option>
                                <option value="I" <?= ($produto['status'] == "I" ? ' selected="selected" ' : ''); ?> >
                                    Inativo
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="box_ip" style="width:100%;">
                    <div class="box_txt">
                        <label for="resumo">Resumo</label>
                        <br/><br/>
                        <textarea type="text" name="resumo" id="resumo" size="30" rows="10"
                                  cols='100'><?php echo $produto['resumo']; ?></textarea>
                    </div>
                </div>

                <div class="box_ip" style="width:100%;">
                    <div class="box_txt">
                        <label for="informacoes">Informações</label>
                        <br/><br/>
                        <textarea type="text" name="informacoes" id="informacoes" size="30" rows="10"
                                  cols='100'><?php echo $produto['informacoes']; ?></textarea>
                    </div>
                </div>

                    <?php //foreach ($subs as $i => $j) { ?>
                        <!-- <div class='categorias'>
                            <div class="box_ip">
                                <label for="idcategoria">Categoria</label>
                                <div class="box_sel">
                                    <label for="">Categoria</label>
                                    <div class="box_sel_d">
                                        <select name="idcategoria[]" class='required'>
                                            <option value=""></option>
                                            <?php foreach ($categorias as $k => $v) {
                                                $add = false;
                                                $subcategorias = $v['subcategorias'];
                                                if (!empty($subcategorias)) {
                                                    foreach ($subcategorias as $l => $s) {
                                                        if (!in_array($s['idcategoria'], $subAtivas)) {
                                                            $add = true;
                                                            break;
                                                        }
                                                    }
                                                } else if (!in_array($v['idcategoria'], $subAtivas)) {
                                                    $add = true;
                                                    if ($v['idcategoria'] == $j['idcategoria']) {
                                                        $subAtivas[] = $v['idcategoria'];
                                                    }
                                                }

                                                if ($add) { ?>
                                                    <option value='<?= $v['idcategoria'] ?>' <?= (($v['idcategoria'] == $j['idcategoria_pai'] || $v['idcategoria'] == $j['idcategoria']) ? "SELECTED" : "") ?>><?= $v['nome'] ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box_ip" <?= ((empty($j['idcategoria_pai'])) ? "style='display:none;'" : "") ?> >
                                <label for="idsubcategoria">SubCategoria</label>
                                <div class="box_sel">
                                    <label for="">SubCategoria</label>
                                    <div class="box_sel_d">
                                        <?php
                                        $subCategorias = array();
                                        if (isset($j['idcategoria_pai']) && !empty($j['idcategoria_pai'])) {
                                            $subCategorias = buscaCategoria(array("idcategoria_pai" => $j['idcategoria_pai'], "ordem" => "nome asc"));
                                        }
                                        ?>
                                        <select name="idsubcategoria[]"
                                                id='<?= $i . rand(); ?>' <?= ((!empty($j['idcategoria_pai'])) ? "class='required'" : "") ?>>
                                            <option value=""></option>
                                            <?php foreach ($subCategorias as $k => $v) {
                                                if (!in_array($v['idcategoria'], $subAtivas)) { ?>
                                                    <option value='<?= $v['idcategoria'] ?>' <?= (($v['idcategoria'] == $j['idcategoria']) ? "SELECTED" : "") ?>><?= $v['nome'] ?></option>
                                                <?php }
                                                if (!in_array($v['idcategoria'], $subAtivas) && $v['idcategoria'] == $j['idcategoria']) {
                                                    $subAtivas[] = $v['idcategoria'];
                                                } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if ($i > 0) { ?>
                                <div class='divDelete'>
                                    <a href='#' class='removerLinha'><img src='images/delete.png' alt='Remover' title='Remover'></a>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="idproduto_categoria[]" value="<?= $j['idproduto_categoria'] ?>"/>
                            <input type="hidden" name="remover[]" value="0"/>
                        </div> -->
                    <?php //} ?>
                </div>

                <div class="box_cr ">
                    <p>Categorias</p>
                    <?php
                        // $arrTags = explode(',', $blog_post['tags']);
                        // $arrTags = empty($arrTags)?array():$arrTags;
                        $produto_categorias = array_column($produto_categorias, 'idcategoria');
                    ?>

                    <?php foreach($categorias as $key => $l):?>
                        <label>
                            <!-- <input name="linhas[]" value="<?=$l['idcategoria']?>" type="checkbox" <?=in_array($l['idcategoria'], $produto_categorias)?'checked':''?>> -->
                            <input name="categorias[<?=$l['idcategoria']?>][checked]" value="<?=$l['idcategoria']?>" type="checkbox" <?=in_array($l['idcategoria'], $produto_categorias)?'checked':''?>>
                            <input type="hidden" name="categorias[<?=$l["idcategoria"]?>][idcategoria]" value="<?=$l["idcategoria"]?>"/>
                            <span><?=$l['nome']?></span>
                        </label>
                    <?php endforeach;?>
                </div>
                <div class="box_ip">
                    <div class="box_sel box_txt">
                        <label for="idlinhas">Linhas</label>
                        <div class="box_sel_d">
                            <select name="idlinhas" id="idlinhas">
                                <option value="" > Selecione </option>
                                <?php foreach ($linhas as $k => $l) { ?>
                                    <option value="<?= $l['idlinhas'] ?>" <?= ($l['idlinhas'] == $produto['idlinhas'] ? ' selected="selected" ' : ''); ?> > <?= $l['nome'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box_ip">
                    <div class="box_sel box_txt">
                        <label for="idsegmento">Segmento</label>
                        <div class="box_sel_d">
                            <select name="idsegmento" id="idsegmento">
                                <option value="" > Selecione </option>
                                <?php foreach ($segmento as $k => $s) { ?>
                                    <option value="<?= $s['idsegmento'] ?>" <?= ($s['idsegmento'] == $produto['idsegmento'] ? ' selected="selected" ' : ''); ?> > <?= $s['nome'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!--################################## IMAGEM GRANDE #################################################
           ###############################################################################################-->
            <div class="box_ip imagem produto" style="width:100%">
                <div class="content_tit" style="margin-left:0px;">Imagem</div>
                <input type="file" id="full" class="foto <?= ((empty($produto['imagem'])) ? "required" : "") ?>"
                       name="full" tipo="imagem" value="<?= $produto['imagem'] ?>"/>
                <div id="progress" class="progress" style="display:none;">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <br/>
                <p class="pre">Tamanho mínimo recomendado: 800x600px (ou maior proporcional) - Extensão recomendada:
                    jpg, png</p>
                <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                            $tamanho = explode('M', ini_get('upload_max_filesize'));
                            $tamanho = $tamanho[0];
                            echo $tamanho . 'MB';
                            ?>	
	                   </span>
                <?php
                $caminho = '';
                if ($produto['imagem'] != '') {
                    $caminho = 'files/produto/' . $produto['idproduto'] . '/thumb' . $produto['imagem'];
                }
                ?><br/>
                <img src="<?php echo $caminho; ?>" class="imagem_grande"
                     width="150" <?php echo ($_REQUEST['met'] == 'cadastroProduto') ? 'style="display:none;"' : ''; ?> />
            </div>
            <!--################################## FIM IMAGEM GRANDE #################################################
            ###############################################################################################-->


            <!--################################## GALERIA #################################################
            ###############################################################################################-->


            <div class="box_ip" style="width:100%;" id="produto_imagem">
                <div class="content_tit" style="margin-left:0; padding-left:5px;">Fotos Galeria</div>
                <!--input FILE -->
                <input style="width:50%; margin-left:5px;" id="image" name="image" type="file" multiple/>
                <div class='tamanhoImagem'>
                    <p class="pre">Tamanho mínimo recomendado: 800x800px (ou maior proporcional) - Extensão recomendada:
                        jpg, png</p>
                    <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                                <?php
                                $tamanho = explode('M', ini_get('upload_max_filesize'));
                                $tamanho = $tamanho[0];
                                echo $tamanho . 'MB';
                                ?>	
                                <input type="hidden" id="fileMax" value="<?= $tamanho ?>"/>
	                       </span>
                </div>

                <div class="box_ip content-image" id="content-image" style="width:100%; margin-left:5px;">
                    <div class="box_ip content-image" id="content-image">
                        <div style="overflow:hidden"></div>
                        <ul id="sortable">
                            <?php
                            if (!empty($produto_imagens)) {
                                $posicao = 1;
                                foreach ($produto_imagens as $imagem) {
                                    $caminho = 'files/produto/' . $imagem['idproduto'] . '/galeria/thumb' . $imagem['nome_imagem'];
                                    echo '<li class="ui-state-default' . $posicao . ' move box-img" id="' . $posicao . '" idimagem="' . $imagem['idproduto_imagem'] . '">';
                                    echo '<img src="' . $caminho . '" id="img' . $imagem['posicao_imagem'] . '" class="imagem-gallery" style="opacity:1;" />';
                                    echo '<a href="#" class="editImagemDescricao" idImagem="' . $imagem['idproduto_imagem'] . '">';
                                    echo '<button class="edit"></button>';
                                    echo '</a>';
                                    echo '<a href="#" class="excluirImagem" idImagemDelete="' . $imagem['idproduto_imagem'] . '">';
                                    echo '<button class="delete"></button>';
                                    echo '</a>';
                                    echo '<input type="hidden" name="idproduto_imagem[]" value="' . $imagem['idproduto_imagem'] . '">';
                                    echo '<input type="hidden" name="descricao_imagem[]" value="' . $imagem['descricao_imagem'] . '">';
                                    echo '<input type="hidden" name="imagem_produto[]" value="' . $imagem['nome_imagem'] . '">';
                                    echo '<input type="hidden" name="posicao_imagem[]" value="' . $imagem['posicao_imagem'] . '">';
                                    echo '</li>';
                                    $posicao++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="content_tit">Arquivo</div>

				<div class="box_ip">
					<label for="nome_arquivo">Nome Arquivo</label>
					<input type="text" name="nome_arquivo" id="nome_arquivo" size="30" maxlength="255" value="<?php echo $produto['nome_arquivo']; ?>" />
				</div>

				<div class="box_ip" style="width: 100%;">
					<label for="resumo_arquivo">Resumo Arquivo</label>
					<textarea type="text" name="resumo_arquivo" id="resumo_arquivo" size="30" maxlength="255" value="<?php echo $produto['resumo_arquivo']; ?>"><?php echo $produto['resumo_arquivo']; ?></textarea>
				</div>

                <div class='box_ip' style='width:100%;'>
                    <label for="arquivo"><b>Arquivo</b></label><br />
                </div>

                <div class="box_ip">
                    <input type="file" name="arquivo" id="arquivo" value="<?php echo $produto['arquivo']; ?>" />
                </div>

                <?php 
                    if (!empty($produto['arquivo']))
                        print "<a href='files/produto/" . $produto['arquivo'] . "' target='_blank' style='float:left;width:100%;margin-left:20px;color:#000;font-weight:bold;'>Ver Arquivo</a>";
                ?>

            </div>
            <!--################################## FIM GALERIA #################################################
            ###############################################################################################-->


            <input type="hidden" id="imagem" name="imagem" value="<?= $produto['imagem'] ?>"/>
            <input type="hidden" id="mod" name="mod"
                   value="<?= ($produto['idproduto'] == 0) ? "cadastro" : "editar"; ?>"/>
            <input type="hidden" name="idproduto" id="idproduto" value="<?= $idProduto; ?>"/>
            <input type="submit" value="Salvar" class="bt_save salvar"/>
            <input type="button" value="Cancelar" onclick="history.go(-1);" class="bt_cancel cancelar"/>
        </form>
    </div>

    <style>
        .box_cr label span {
            word-wrap: break-word;
            text-align: left;
            display: contents;
        }

        .box_cr label {
            float: left;
            line-height: 20px;
            margin: 0 5px;
            width: 45%;
            /* word-wrap: break-word; */
        }
    </style>

<?php } ?>


<!--************************************
     _       _        _        _     _
    | |     | |      | |      | |   | |
  __| | __ _| |_ __ _| |_ __ _| |__ | | ___
 / _` |/ _` | __/ _` | __/ _` | '_ \| |/ _ \
| (_| | (_| | || (_| | || (_| | |_) | |  __/
 \__,_|\__,_|\__\__,_|\__\__,_|_.__/|_|\___|
					*******************************-->


<?php if ($_REQUEST['acao'] == "listarProduto") { ?><?php
    if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
        header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
    ?>
    <div id="titulo">
        <img src="images/modulos/produto_preto.png" height="22" width="24" alt="ico"/>
        <span>Listagem de Produto</span>
        <ul class="other_abs">
            <li class="other_abs_li"><a href="index.php?mod=produto&acao=formProduto&met=cadastroProduto">Cadastro</a>
            </li>
        </ul>
    </div>
    <div class="search">
        <form name="formbusca" method="post" action="#" onsubmit="return false">
            <input type="text" name="buscarapida" value="Buscar" onblur="campoBuscaEscreve(this);"
                   onfocus="campoBuscaLimpa(this);" id="buscarapida"/>
        </form>
        <a href="" class="search_bt">Busca Avançada</a>
    </div>
    <div class="advanced">
        <form name="formAvancado" id="formAvancado" method="post" action="#" onsubmit="return false">
            <p class="advanced_tit">Busca Avançada</p>
            <img class="advanced_close" src="images/ico_close.png" height="10" width="11" alt="ico"/>
            <div class="box_ip"><label for="adv_nome">Nome</label><input type="text" name="nome" id="adv_nome"></div>
            <!-- <div class="box_ip"><label for="adv_codigo">Codigo</label><input type="text" name="codigo" id="adv_codigo"> </div>-->
            <!-- <div class="box_ip"><label for="adv_urlrewrite">Urlrewrite</label><input type="text" name="urlrewrite"  id="adv_urlrewrite"></div> -->
            <!-- <div class="box_ip"><label for="adv_destaque">Destaque</label><input type="text" name="destaque" id="adv_destaque"></div> -->
            <!-- <div class="box_ip"><label for="adv_informacoes">Informacoes</label><input type="text" name="informacoes" id="adv_informacoes"></div> -->
            <!-- <div class="box_ip"><label for="adv_resumo_tecnico">Resumo Tecnico</label><input type="text" name="resumo_tecnico" id="adv_resumo_tecnico"> </div> -->
            <div class="box_ip"><label for="adv_descricao">Descrição</label><input type="text" name="descricao" id="adv_descricao"></div>
            <!-- <div class="box_ip"><label for="adv_title">Title</label><input type="text" name="title" id="adv_title"> </div> -->
            <!-- <div class="box_ip"><label for="adv_description">Description</label><input type="text" name="description" id="adv_description"></div> -->
            <!-- <div class="box_ip"><label for="adv_keywords">Keywords</label><input type="text" name="keywords" id="adv_keywords"></div> -->

            <div class="box_ip">
                <div class="box_sel">
                    <label for="">Categoria</label>
                    <div class="box_sel_d">
                        <select name="idcategoria_pai" id="idcategoria_pai">
                            <option value='0'></option>
                            <?php foreach ($categorias as $k => $v) { ?>
                                <option value='<?= $v['idcategoria'] ?>'><?= $v['nome'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- <div class="box_ip subcategoria">
                <div class="box_sel">
                    <label for="">Sub-Categoria</label>
                    <div class="box_sel_d">
                        <select name="idcategoria" id="idcategoria">
                            <option value='0'></option>
                        </select>
                    </div>
                </div>
            </div> -->

            <!-- <div class="box_ip">
                <div class="box_sel">
                    <label for="">Marcas</label>
                    <div class="box_sel_d">
                        <select name="idmarcas" id="idmarcas">
                            <option value='0'></option>
                            <?php foreach ($marcas as $k => $v) { ?>
                                <option value='<?= $v['idmarcas'] ?>'><?= $v['nome'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div> -->

            <a href="" class="advanced_bt" id="filtrar">Filtrar</a>
        </form>
    </div>


    <div id="principal">
        <div id="abas">
            <ul class="abas_list">
                <li class="abas_list_li action"><a href="javascript:void(0)">Produto</a></li>
            </ul>
            <ul class="abas_bts">
                <li class="abas_bts_li"><a href="index.php?mod=produto&acao=formProduto&met=cadastroProduto"><img
                                src="images/novo.png" alt="Cadastro Produto" title="Cadastrar Produto"/></a></li>
                <li class="abas_bts_li"><a href="javascript:void(0)"
                                           onclick="popUp('relatorio_class.php?modulo=produto&output=print&'+queryDataTable);"><img
                                src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
                <li class="abas_bts_li"><a href="javascript:void(0)"
                                           onclick="popUp('relatorio_class.php?modulo=produto&output=xls&'+queryDataTable);"><img
                                src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a>
                </li>
            </ul>
        </div>
        <table class="table" cellspacing="0" cellpadding="0" id="listagem">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
        <?php include_once("paginacao/paginacao.php"); ?>




        <?php
        $dados = isset($_POST) ? $_POST : array();
        $buscar = '';
        foreach ($dados as $k => $v) {
            if (!empty($v))
                $buscar .= $k . '=' . $v . '&';
        }
        ?>


        <script type="text/javascript">
            queryDataTable = '<?php print $buscar; ?>';
            requestInicio = "tipoMod=produto&p=" + preventCache + "&";
            ordem = "idproduto";
            dir = "desc";
            $(document).ready(function () {
                preTableProduto();
            });
            dataTableProduto('<?php print $buscar; ?>');
            columnProduto();
        </script>


    </div>

<?php } ?>


<div style='display:none' id="one">
    <div class='categorias'>
        <div class="box_ip">
            <label for="idcategoria">Categoria</label>
            <div class="box_sel">
                <label for="">Categoria</label>
                <div class="box_sel_d">
                    <select name="idcategoria[]" class='required'>
                        <option value=""></option>
                        <?php foreach ($categorias as $k => $v) { ?>
                            <option value='<?= $v['idcategoria'] ?>'><?= $v['nome'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="box_ip">
            <label for="idsubcategoria">SubCategoria</label>
            <div class="box_sel">
                <label for="">SubCategoria</label>
                <div class="box_sel_d">
                    <select name="idsubcategoria[]" class='required'>
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </div>
        <div class='divDelete'>
            <a href='#' class='removerLinha'><img src='images/delete.png' alt='Remover' title='Remover'></a>
        </div>
        <input type="hidden" name="idproduto_categoria[]" value="0"/>
        <input type="hidden" name="remover[]" value="0"/>
    </div>
</div>


<!--/////////////////////////////////////////////////////////-->
<!--////////////// FORMULARIOS PARA A GALERIA ////////////////-->
<!--////////////////////////////////////////////////////////-->

<!--data dialog descrição-->
<div id="boxDescricao" style="display:none;">
    <div id="principal">
        <form class="form" name="formDescricaoImagem" id="formDescricaoImagem" method="post" action="">
            <div id="informacaoGaleria" class="content">
                <div class="content_tit"></div>
                <div class="box_ip">
                    <label for="descricao_imagem">Descrição</label>
                    <input type="text" name="descricao_imagem" id="descricao_imagem"/>
                    <input type="hidden" id="idImagem" value=""/>
                    <input type="hidden" id="posImagem" value=""/>
                </div>
                <input type="submit" value="Salvar" class="btSaveDescricao button"/>
            </div>
        </form>
    </div>
</div>
<!--Fim dialog descrição-->

<!--data dialog exclusão de imagem-->
<div id="excluirImagem" style="display:none;">
    <div id="principal">
        <form class="form" name="formDeleteImagem" id="formDeleteImagem" method="post" action="">
            <div id="informacaoGaleria" class="content">
                <div class="content_tit"></div>
                <input type="hidden" id="idPosicao" value=""/>
                <input type="button" value="NÃO" id="cancelar" class="btCancelarExclusao button cancel"/>
                <input type="submit" value="SIM" class="btExcluirImagem button"/>
            </div>
        </form>
    </div>
</div>
<input type="hidden" value="<?= ENDERECO ?>admin/" name="_endereco" id="_endereco"/>
<!--Fim dialog exclusão de imagem-->



