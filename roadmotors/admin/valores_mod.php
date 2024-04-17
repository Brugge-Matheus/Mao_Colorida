<?php
   // Versao do modulo: 3.00.010416

    include_once "valores_class.php";
    include_once "valor_class.php";
    include_once "includes/functions.php";

    if (!isset($_REQUEST['acao']))
   	    $_REQUEST['acao'] = "";

    $width = 625;
    $height = 535;

    $width2 = 1860;
    $height2 = 380;

    $width3 = 96;
    $height3 = 96;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';

    $valor = buscaValor(array('status' => '1'));
?>
<link rel="stylesheet" type="text/css" href="valores_css.css" />
<script type="text/javascript" src="valores_js.js"></script>

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


<?php if ($_REQUEST['acao'] == "formValores") {
	if ($_REQUEST['met'] == "cadastroValores") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "valores_script.php?opx=cadastroValores";
		$metodo_titulo = "Cadastro Valores";
		$idValores = 0;

        $FontAwesome = false;

        // dados para os campos
        $valores['idvalor'] = "";
        $valores['nome'] = "";
        $valores['texto'] = "";
        $valores['icone'] = "";
        $valores['icone_name'] = "";
        $valores['status'] = "";	

	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "valores_script.php?opx=editValores";
		$metodo_titulo = "Editar Valores";
		$idValores = (int) $_GET['idu'];
		$valores = buscaValores(array('idvalores' => $idValores));

		if (count($valores) != 1) exit;
		$valores = $valores[0];

        $StringIcone = strlen($valores['icone']);
        if ($StringIcone > 3) {
            $FontAwesome = false;
            $valores['icone_name'] = '';
        } else {
            $FontAwesome = true;
            // $icones_Edit = buscaFW3(array('idfw' => $valores['icone']));
            // $icones_Edit = $icones_Edit[0];
        }
	}
	?>

	<div id="titulo">
		<i class='fa fa-comments' aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=valores&acao=listarValores">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=valores&acao=formValores&met=cadastroValores">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formValores" id="formValores" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome'));" enctype="multipart/form-data">

			<div id="informacaoValores" class="content">
				<div class="content_tit">Dados Valores:</div>

                <!-- ========== Upload Icone ========== -->
                    <div class="box_ip box_txt">
                        <ul class="tabs">
                            <li class="tab-link <?= @$FontAwesome ? 'current' : ''; ?> btn-choose-icon" data-tab="tab-1-not-grid">Escolher um Ícone</li>
                            <li class="tab-link <?= !@$FontAwesome ? 'current' : ''; ?>" data-tab="tab-2">Anexar um Ícone</li>
                        </ul>
                        <div id="tab-1-not-grid" class="box_ip box_txt tab-content <?= $FontAwesome ? 'current' : ''; ?>">
                            <span id="icone-titulo" class='labeltxt' for="pesquisar_icone">
                                <strong>Ícone</strong>
                            </span>
                            <?php if ($_GET['met'] == 'editValores') : ?>
                                <div id="mostrar_icone">
                                    <i id="current_icon" class='fas fa-<?=$valores['icone_name'];?> fa-2x'></i>
                                    <input type="hidden" name="icone" value="<?= $valores['icone']; ?>" id="imagem_icone">
                                    <input type="hidden" name="icone_name" value="<?= $valores['icone_name']; ?>" id="icone_name">
                                </div>
                            <?php else : ?>
                                <div id="mostrar_icone">
                                    <i id="current_icon" class=''></i>
                                    <input type="hidden" name="icone" id="imagem_icone">
                                    <input type="hidden" name="icone_name" id="icone_name">
                                </div>
                            <?php endif; ?>

                        </div>
                        <div id="tab-2" class="tab-content <?= !$FontAwesome ? 'current' : ''; ?>">
                            <?php $caminho = "files/valores/"; ?>
                            <div class="content_tit">Ícone</div>

                            <div class="botaoArquivo" id="inputArquivoBotao">
                                <input class="btn" type="button" value="Anexar Ícone">
                                <!-- <i class="fas fa-paperclip" aria-hidden="true"></i> -->
                            </div>

                            <img class="pump" src="<?= $caminho . $valores['icone']; ?>" width='<?=$width3?>' id="icone" style="display: <?= $_GET['met'] == 'editValores' ? (!empty($valores['icone'] && !$FontAwesome) ? 'block' : 'none') : 'none'; ?>">
                            <p class="pre">Tamanho recomendado: <?=$width3?>x<?=$height3?>px (ou maior proporcional) - Extensão recomendada: jpg, png</p>
                            <span>O arquivo não pode ser maior que: <?=$tamanho?></span>
                            <input type="file" name="icone_upload" id="icone_upload" class="all_imagens" data-tipo='1'>
                            <input type="hidden" id="imagem_value">
                            <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                        </div>
                    </div>
                <!-- ========== Fim Upload Icone ========== -->

				<div class="box_ip">
					<label for="nome">Nome</label>
					<input type="text" class="" name="nome" id="nome" value="<?php echo $valores['nome']; ?>" />
				</div>

                <div class="box_ip box_txt">
                   <label for="texto">Texto</label>
                   <textarea name="texto" id="texto" class=""><?php echo $valores['texto']; ?></textarea>
                </div>

                <div class="box_ip">
                    <div class="box_sel box_txt">
                        <label for="valor">Valor</label>
                        <div class="box_sel_d">

                            <select name="idvalor" id="idvalor" class=''>
                                    <option value="">Selecione</option>
                                    <?php foreach($valor as $key=>$v): ?>
                                        <option value="<?= $v['idvalor'] ?>" <?php print ($v['idvalor'] == $valores['idvalor'] ? ' selected="selected" ' : ''); ?> > <?= $v['titulo'] ?> </option>
                                    <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box_ip">
                    <label for="status">Status</label>
                    <div class="box_sel box_txt">
                        <label for>Status</label>
                        <div class="box_sel_d">
                            <select name="status" id="status">
                                <option value="A" <?=(($valores['status'] == 'A') ? 'SELECTED' : '')?>>Ativo</option>
                                <option value="I" <?=(($valores['status'] == 'I') ? 'SELECTED' : '')?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>


            <div class="div-aux" hidden></div>

            <!-- ====== Ícones ===== -->
                <div id="box_icons" class="box_ip box_txt">
                   <div id="tab-1" class="tab-content-grid current">
                      <input type="text" name="pesquisar_icone" id="pesquisar_icone" placeholder="Pesquise um icone">
                      <div id="icone_pai">
                      </div>
                      <div id="div-page-icon">
                      </div>
                   </div>
                </div>

                <div id="box_icons-not-grid" class="box_ip box_txt">
                    <input type="text" name="pesquisar_icone" id="pesquisar_icone-not-grid" placeholder="Pesquise um icone">
                    <div id="icone_pai-not-grid"></div>
                    <div id="div-page-icon-not-grid"></div>
                </div>
            <!-- ===== Fim ícones ===== -->

			</div>

            <input type="hidden" id="mod" name="mod" value="<?= ($idValores == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" name="idvalores" id="idvalores" value="<?php echo $idValores; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
            <input type='hidden' name='aspectRatioW2' id='aspectRatioW2' value='<?=$width2?>'>
            <input type='hidden' name='aspectRatioH2' id='aspectRatioH2' value='<?=$height2?>'>
            <input type='hidden' name='imagem' id='imagem-value' value='<?=$valores['imagem']?>'>
            <input type='hidden' name='banner_topo' id='imagem_2-value' value='<?=$valores['banner_topo']?>'>
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


<?php if ($_REQUEST['acao'] == "listarValores") { ?><?php
if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
	header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
<div id="titulo">
	<i class='fa fa-comments' aria-hidden="true"></i>
	<span>Listagem de Valores</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=valores&acao=listarValores">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=valores&acao=formValores&met=cadastroValores">Cadastro</a></li>
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
			<li class="abas_list_li action"><a href="javascript:void(0)">Valores</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=valores&acao=formValores&met=cadastroValores"><img src="images/novo.png" alt="Cadastro Valores" title="Cadastrar Valores" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=valores&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=valores&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
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
		requestInicio = "tipoMod=valores&p=" + preventCache + "&";
		ordem = "idvalores";
		dir = "desc";
		$(document).ready(function() {
			preTableValores();
		});
		dataTableValores('<?php print $buscar; ?>');
		columnValores();
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