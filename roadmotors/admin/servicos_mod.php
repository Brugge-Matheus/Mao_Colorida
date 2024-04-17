<?php
   // Versao do modulo: 3.00.010416

    include_once "servicos_class.php";
    include_once "includes/functions.php";

    if (!isset($_REQUEST['acao']))
    $_REQUEST['acao'] = "";

    $width = 865;
    $height = 721;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';

?>
<link rel="stylesheet" type="text/css" href="servicos_css.css" />
<script type="text/javascript" src="servicos_js.js"></script>

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


<?php if ($_REQUEST['acao'] == "formServicos") {
	if ($_REQUEST['met'] == "cadastroServicos") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servicos_script.php?opx=cadastroServicos";
		$metodo_titulo = "Cadastro Serviços";
		$idServicos = 0;

        $FontAwesome = false;

    // dados para os campos
        $servicos['idservicos'] = "";   
        $servicos['nome'] = "";
        $servicos['link'] = "";
        $servicos['resumo'] = "";
        $servicos['imagem'] = "";
        $servicos['status'] = "A";

	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servicos_script.php?opx=editServicos";
		$metodo_titulo = "Editar Serviços";
		$idServicos = (int) $_GET['idu'];
		$servicos = buscaServicos(array('idservicos' => $idServicos));

		if (count($servicos) != 1) exit;
		$servicos = $servicos[0];
	}
	?>

	<div id="titulo">
		<i class='fa fa-wrench' aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=listarServicos">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos">Cadastro</a></li>
		</ul>
	</div>

	<div id="principal">
		<form class="form" name="formServicos" id="formServicos" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome'));" enctype="multipart/form-data">

			<div id="informacaoServicos" class="content">
				<div class="content_tit">Dados Servicos:</div>

                <div class="box_ip" style="width:50%;">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="" size="30" maxlength="255" value='<?php echo $servicos['nome']; ?>' class=''/>
                </div>

                <div class="box_ip" style="width:50%;">
                    <label for="link">Link Contato</label>
                    <input type="text" name="link" id="" size="30" maxlength="255" value='<?php echo $servicos['link']; ?>' class=''/>
                </div>


                <div class="box_ip" style="width:100%;">
                    <div class="box_txt">
                        <label for="resumo">Resumo</label>
                        <textarea type="text" name="resumo"><?php echo $servicos['resumo']; ?></textarea>
                    </div>
                </div>

                <div class="box_ip">
                    <label for="status">Status</label>
                    <div class="box_sel box_txt">
                        <label for>Status</label>
                        <div class="box_sel_d">
                            <select name="status" id="status">
                                <option value="A" <?=(($servicos['status'] == 'A') ? 'SELECTED' : '')?>>Ativo</option>
                                <option value="I" <?=(($servicos['status'] == 'I') ? 'SELECTED' : '')?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CROPPER IMG -->
                <?php $caminho = 'files/servicos/'; ?>
                <div id="select-image-1" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Imagem</div>
                                <div class="box_ip imagem-atual" style="<?=empty($servicos['imagem'])?'display: none;':''?>">
                                    <a data-tipo="imagem" data-img="<?=$servicos['imagem']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($servicos['imagem'])?'images/cliente/logo.png':$caminho.$servicos['imagem']?>" class="img-servicos-form" alt=""/>
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

            <input type="hidden" id="mod" name="mod" value="<?= ($idServicos == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" name="idservicos" id="idservicos" value="<?php echo $idServicos; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
            <input type='hidden' name='imagem' id='imagem-value' value='<?=$servicos['imagem']?>'>

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


<?php if ($_REQUEST['acao'] == "listarServicos") { ?><?php
if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
	header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
<div id="titulo">
	<i class='fa fa-wrench' aria-hidden="true"></i>
	<span>Listagem de Serviços</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=servicos&acao=listarServicos">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos">Cadastro</a></li>
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
			<li class="abas_list_li action"><a href="javascript:void(0)">Serviços</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos"><img src="images/novo.png" alt="Cadastro Servicos" title="Cadastrar Servicos" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servicos&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servicos&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
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
		requestInicio = "tipoMod=servicos&p=" + preventCache + "&";
		ordem = "idservicos";
		dir = "desc";
		$(document).ready(function() {
			preTableServicos();
		});
		dataTableServicos('<?php print $buscar; ?>');
		columnServicos();
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