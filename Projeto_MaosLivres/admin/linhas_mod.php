<?php
   // Versao do modulo: 3.00.010416

    include_once "linhas_class.php";
    include_once "includes/functions.php";

    if (!isset($_REQUEST['acao']))
    $_REQUEST['acao'] = "";

    $width = 350;
    $height = 420;

    $width2 = 1920;
    $height2 = 280;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';

?>
<link rel="stylesheet" type="text/css" href="linhas_css.css" />
<script type="text/javascript" src="linhas_js.js"></script>

<!-- CROPPER-->
<link href="css/cropper-padrao.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">

<script src="js/bootstrap.min.js"></script>
<script src="js/cropper.js"></script>
<script src="js/main.js"></script>
<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if ($_REQUEST['acao'] == "formLinhas") {
	if ($_REQUEST['met'] == "cadastroLinhas") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "linhas_script.php?opx=cadastroLinhas";
		$metodo_titulo = "Cadastro Soluções";
		$idLinhas = 0;

        $FontAwesome = false;

    // dados para os campos
        $linhas['idlinhas'] = "";   
        $linhas['nome'] = "";
        $linhas['resumo'] = "";
        $linhas['urlrewrite'] = "";
        $linhas['imagem'] = "";
        $linhas['imagem2'] = "";
        $linhas['status'] = "A";

        $linhas_imagens = array();
        $linhas_faq = array();

	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "linhas_script.php?opx=editLinhas";
		$metodo_titulo = "Editar Linhas";
		$idLinhas = (int) $_GET['idu'];
		$linhas = buscaLinhas(array('idlinhas' => $idLinhas));

		if (count($linhas) != 1) exit;
		$linhas = $linhas[0];
        //$StringIcone = strlen($linhas['icone']);
        // if ($StringIcone > 3) {
        //     $FontAwesome = false;
        //     $linhas['icone_name'] = '';
        // } else {
        //     $FontAwesome = true;
        // }
	}
	?>

	<div id="titulo">
		<i class='fa fa-briefcase' aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=linhas&acao=listarLinhas">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=linhas&acao=formLinhas&met=cadastroLinhas">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formLinhas" id="formLinhas" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome'));" enctype="multipart/form-data">

			<div id="informacaoLinhas" class="content">
				<div class="content_tit">Dados Linhas:</div>

                <div class="box_ip" style="width:50%;">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" size="30" maxlength="255" value='<?php echo $linhas['nome']; ?>' class=''/>
                </div>

                
                <div class="box_ip" style="width:50%;">
                    <label for="urlrewrite">Urlrewrite</label>
                    <input type="text" name="urlrewrite" id="urlrewrite" size="30" maxlength="255" value="<?php echo $linhas['urlrewrite']; ?>" class=''/>
                    <input type="hidden" name="urlrewriteantigo" id="urlrewriteantigo" value="<?= $linhas['urlrewrite']; ?>"/>
                </div>

                <!-- <div class="box_ip" style="width:100%;">
                    <div class="box_txt">
                        <label for="resumo">Resumo</label>
                        <br/><br/>
                        <textarea type="text" name="resumo" id="resumo" size="30" rows="10"
                                  cols='100'><?php echo $linhas['resumo']; ?></textarea>
                    </div>
                </div> -->

                <div class="box_ip">
                    <label for="status">Status</label>
                    <div class="box_sel box_txt">
                        <label for>Status</label>
                        <div class="box_sel_d">
                            <select name="status" id="status">
                                <option value="A" <?=(($linhas['status'] == 'A') ? 'SELECTED' : '')?>>Ativo</option>
                                <option value="I" <?=(($linhas['status'] == 'I') ? 'SELECTED' : '')?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CROPPER IMG -->
                <?php $caminho = 'files/linhas/'; ?>
                <div id="select-image-1" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Imagem</div>
                                <div class="box_ip imagem-atual" style="<?=empty($linhas['imagem'])?'display: none;':''?>">
                                    <a data-tipo="imagem" data-img="<?=$linhas['imagem']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($linhas['imagem'])?'images/cliente/logo.png':$caminho.$linhas['imagem']?>" class="img-linhas-form" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="box-img-crop">
                            <div class="docs-buttons">
                                <div class="btn-group box_txt">
                                    <!--input FILE -->
                                    <input id="inputImage" class="cropped-image" name="imagemCadastrar2" type="file"/>
                                    <br />
                                    <p class="pre">Tamanho recomendado: <?= $width ?>x<?php echo $height ?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
                                    <span>O arquivo não pode ser maior que:
                                        <?=$tamanho?>
                                    </span>
                                    <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="select-image-2" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Imagem 2</div>
                                <div class="box_ip imagem-atual" style="<?=empty($linhas['imagem2'])?'display: none;':''?>">
                                    <a data-tipo="imagem" data-img="<?=$linhas['imagem2']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($linhas['imagem2'])?'images/cliente/logo.png':$caminho.$linhas['imagem2']?>" class="img-linhas-form" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="box-img-crop">
                            <div class="docs-buttons">
                                <div class="btn-group box_txt">
                                    <!--input FILE -->
                                    <input id="inputImage2" class="cropped-image" name="imagemCadastrar2" type="file"/>
                                    <br />
                                    <p class="pre">Tamanho recomendado: <?=$width2?>x<?=$height2?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
                                    <span>O arquivo não pode ser maior que:
                                        <?=$tamanho?>
                                    </span>
                                    <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="select-image-3" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Imagem 3</div>
                                <div class="box_ip imagem-atual" style="<?=empty($linhas['imagem3'])?'display: none;':''?>">
                                    <a data-tipo="imagem" data-img="<?=$linhas['imagem3']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($linhas['imagem3'])?'images/cliente/logo.png':$caminho.$linhas['imagem3']?>" class="img-linhas-form" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="box-img-crop">
                            <div class="docs-buttons">
                                <div class="btn-group box_txt">
                                    <input id="inputImage3" class="cropped-image" name="imagemCadastrar3" type="file"/>
                                    <br />
                                    <p class="pre">Tamanho recomendado: <?=$width6?>x<?=$height6?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
                                    <span>O arquivo não pode ser maior que:
                                        <?=$tamanho?>
                                    </span>
                                    <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div id="cropper-modal">
                    <!-- /.docs-buttons -->
                    <div class="img-container" id="img-container">
                        <img alt="">
                    </div>
                    <!-- Show the cropped image in modal -->
                    <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                                </div>
                                <div class="modal-body"></div>
                            </div>
                        </div>
                    </div><!-- /.modal -->
                    <div class="div-save-cropped-image">
                        <input data-image-type='' type="button" value="Salvar" class="save-cropped-image">
                    </div>
                </div>
            <div class="div-aux" hidden></div>
			</div>

            <input type="hidden" id="mod" name="mod" value="<?= ($idLinhas == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" name="idlinhas" id="idlinhas" value="<?php echo $idLinhas; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
            <input type='hidden' name='aspectRatioW2' id='aspectRatioW2' value='<?=$width2?>'>
            <input type='hidden' name='aspectRatioH2' id='aspectRatioH2' value='<?=$height2?>'>
            <!-- <input type='hidden' name='aspectRatioW3' id='aspectRatioW3' value='<?=$width6?>'>
            <input type='hidden' name='aspectRatioH3' id='aspectRatioH3' value='<?=$height6?>'> -->
            <input type='hidden' name='imagem' id='imagem-value' value='<?=$linhas['imagem']?>'>
            <input type='hidden' name='imagem2' id='imagem_2-value' value='<?=$linhas['imagem2']?>'>
            <!-- <input type='hidden' name='imagem3' id='imagem_3-value' value='<?=$linhas['imagem3']?>'> -->

		</form>
	</div>

<?php } ?>



<!--************************************
     _       _        _        _     _
    | |     | |      | |      | |   | |
  __| | __ _| |_ __ _| |_ __ _| |__ | | ___
 / _` |/ _` | __/ _` | __/ _` | '_ \| |/ _ \
| (_| | (_| | || (_| | || (_| | |_) | |  __/
 \__,_|\__,_|\__\__,_|\__\__,_|_.__/|_|\___|
					*******************************-->


<?php if ($_REQUEST['acao'] == "listarLinhas") { ?><?php
if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
	header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
<div id="titulo">
	<i class='fa fa-briefcase' aria-hidden="true"></i>
	<span>Listagem de Soluções</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=linhas&acao=listarLinhas">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=linhas&acao=formLinhas&met=cadastroLinhas">Cadastro</a></li>
	</ul>
</div>
<div class="search">
	<form name="formbusca" method="post" action="#" onsubmit="return false">
		<input type="text" name="buscarapida" value="Buscar" onblur="campoBuscaEscreve(this);" onfocus="campoBuscaLimpa(this);" id="buscarapida" />
	</form>
	<a href="" class="search_bt">Busca Avançada</a>
</div>
<div class="advanced">
	<form name="formAvancado" id="formAvancado" method="post" action="#" onsubmit="return false">
		<p class="advanced_tit">Busca Avançada</p>
		<img class="advanced_close" src="images/ico_close.png" height="10" width="11" alt="ico" />
		<div class="box_ip"><label for="adv_nome">Nome</label><input type="text" name="nome" id="adv_nome"></div>
		<div class="box_ip"><label for="adv_status">Status</label><input type="text" name="status" id="adv_status"></div>
		<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
	</form>
</div>

<div id="principal">
	<div id="abas">
		<ul class="abas_list">
			<li class="abas_list_li action"><a href="javascript:void(0)">Soluções</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=linhas&acao=formLinhas&met=cadastroLinhas"><img src="images/novo.png" alt="Cadastro Linhas" title="Cadastrar Linhas" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=linhas&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=linhas&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
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
		requestInicio = "tipoMod=linhas&p=" + preventCache + "&";
		ordem = "idlinhas";
		dir = "desc";
		$(document).ready(function() {
			preTableLinhas();
		});
		dataTableLinhas('<?php print $buscar; ?>');
		columnLinhas();
	</script>
</div>

<?php } ?>


<!--/////////////////////////////////////////////////////////-->
<!--////////////// FORMULARIOS PARA A GALERIA ////////////////-->
<!--////////////////////////////////////////////////////////-->

<!--data dialog descrição-->
<div id="boxDescricao" style="display:none;">                                                   
    <div id="principal">
        <form class="form" name="formDescricaoImagem" id="formDescricaoImagem" method="post" action="">
            <div id="informacaoGaleria" class="content">                                
                <div class="content_tit"></div>     
                <div class="box_ip" >
                    <label  for="descricao_imagem">Descrição</label>
                    <input type="text" name="descricao_imagem" id="descricao_imagem"   />
                    <input type="hidden" id="idImagem" value="" /> 
                    <input type="hidden" id="posImagem" value="" />
                </div>
                <input type="submit" value="Salvar" class="btSaveDescricao button" />
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
                <input type="hidden" id="idPosicao" value="" />  
                <input type="button" value="NÃO" id="cancelar" class="btCancelarExclusao button cancel" />                              
                <input type="submit" value="SIM" class="btExcluirImagem button"/>
            </div>
        </form>
    </div>
</div>  
<input type="hidden" value="<?=ENDERECO?>" name="_endereco" id="_endereco" />
<!--Fim dialog exclusão de imagem-->

<div id="modal-confirmacao">
    <form class="form" method="post">
        <input type="button" value="NÃO" class="button cancel" />
        <input type="button" value="SIM" class="button confirm"/>
    </form>
</div>