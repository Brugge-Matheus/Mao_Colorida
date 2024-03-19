<?php 
	 // Versao do modulo: 3.00.010416

	include_once "segmento_diferenciais_class.php";
	include_once "segmento_class.php";

	include_once "includes/functions.php";
    // $icone = buscaFW3(array('ordem' => 'nome', 'dir' => 'asc'));
	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = ""; 
     
    $width = 150;
    $height = 150;

    $width2 = 60;
    $height2 = 60;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';

    $segmentos = buscaSegmento(array('status' => '1'));
?>
<link rel="stylesheet" type="text/css" href="segmento_diferenciais_css.css" />
<script type="text/javascript" src="segmento_diferenciais_js.js"></script>

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


<?php if($_REQUEST['acao'] == "formSegmento_diferenciais"){
	if($_REQUEST['met'] == "cadastroSegmento_diferenciais"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "segmento_diferenciais_script.php?opx=cadastroSegmento_diferenciais";
		$metodo_titulo = "Cadastro de Segmento_diferenciais";
		$idSegmento_diferenciais = 0 ;
      $FontAwesome = false;

		// dados para os campos
		$segmento_diferenciais['idsegmento'] = "";
        $segmento_diferenciais['nome'] = "";
        $segmento_diferenciais['status'] = "";
		$segmento_diferenciais['icone'] = "";
        $segmento_diferenciais['icone_name'] = "";
	}

	if($_REQUEST['met'] == "editSegmento_diferenciais"){
		
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "segmento_diferenciais_script.php?opx=editSegmento_diferenciais";
		$metodo_titulo = "Editar Segmento_diferenciais";
		$idSegmento_diferenciais = (int) $_GET['idu'];
		$segmento_diferenciais = buscaSegmento_diferenciais(array('idsegmento_diferenciais'=>$idSegmento_diferenciais));

		if (count($segmento_diferenciais) != 1) exit;
		$segmento_diferenciais = $segmento_diferenciais[0];

        $StringIcone = strlen($segmento_diferenciais['icone']);
        if ($StringIcone > 3) {
            $FontAwesome = false;
            $segmento_diferenciais['icone_name'] = '';
        } else {
            $FontAwesome = true;
            $icones_Edit = buscaFW3(array('idfw' => $segmento_diferenciais['icone']));
            $icones_Edit = $icones_Edit[0];
        }
	}
?>

	<div id="titulo">
		<i class="fas fa-asterisk" aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=segmento_diferenciais&acao=formSegmento_diferenciais&met=cadastroSegmento_diferenciais">Cadastro</a></li>
		</ul>
	</div>
  
	<div id="principal">
		<form class="form" name="formSegmento_diferenciais" id="formSegmento_diferenciais" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" onsubmit="return verificarCampos(new Array('nome'));">

			<div id="informacaoSegmento_diferenciais" class="content">
				<div class="content_tit">Dados Segmento_diferenciais:</div>

                    <!-- ========== Upload Icone ========== -->
                    <div class="box_ip box_txt">
                        <ul class="tabs">
                            <li class="tab-link <?= @$FontAwesome ? 'current' : ''; ?>" data-tab="tab-1">Escolher um Ícone</li>
                            <!-- <li class="tab-link <?= !@$FontAwesome ? 'current' : ''; ?>" data-tab="tab-2">Anexar um Ícone</li> -->
                        </ul>
                        <div id="tab-1" class="tab-content <?= $FontAwesome ? 'current' : ''; ?>">
                            <span id="icone-titulo" class='labeltxt' for="pesquisar_icone">
                                <strong>Ícone</strong>
                            </span>
                            <?php if ($_GET['met'] == 'editSegmento_diferenciais') : ?>
                                <div id="mostrar_icone">
                                    <i id="current_icon" class='fas fa-<?=$segmento_diferenciais['icone_name'];?> fa-2x'></i>
                                    <input type="hidden" name="icone" value="<?= $segmento_diferenciais['icone']; ?>" id="imagem_icone">
                                    <input type="hidden" name="icone_name" value="<?= $segmento_diferenciais['icone_name']; ?>" id="icone_name">
                                </div>
                            <?php else : ?>
                                <div id="mostrar_icone">
                                    <i id="current_icon" class=''></i>
                                    <input type="hidden" name="icone" id="imagem_icone">
                                    <input type="hidden" name="icone_name" id="icone_name">
                                </div>
                            <?php endif; ?>
                            <input type="text" name="pesquisar_icone" id="pesquisar_icone" placeholder="Pesquise um icone">
                            <div id="icone_pai">
                            </div>
                            <div id="div-page-icon">
                           </div>
                        </div>
                        <!-- <div id="tab-2" class="tab-content <?= !$FontAwesome ? 'current' : ''; ?>">
                            <?php $caminho = "files/segmento_diferenciais/"; ?>
                            <div class="content_tit">Ícone</div>
                            <span class="botaoArquivo" id="inputArquivoBotao">Anexar Ícone <i class="fas fa-paperclip" aria-hidden="true"></i></span>
                            <input type="file" name="icone" id="icone_upload" class="all_imagens" data-tipo='1'><br>
                            <input type="hidden" id="imagem_value">
                            <img class="pump" src="<?= $caminho . $segmento_diferenciais['icone']; ?>" width='53' id="icone" style="display: <?= $_GET['met'] == 'editSegmento_diferenciais' ? (!empty($segmento_diferenciais['icone'] && !$FontAwesome) ? 'initial' : 'none') : 'none'; ?>"><br>
                            <p class="pre">Tamanho recomendado: <?=$width2?>x<?=$height2?>px (ou maior proporcional) - Extensão recomendada: jpg, png</p>
                            <span>O arquivo não pode ser maior que: <?=$tamanho?>
                            </span>
                            <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                        </div> -->
                    </div>
                    <script>
                        var div = document.getElementsByClassName("botaoArquivo")[0];
                        var input = document.getElementById("icone_upload");
                        var imagem_value = document.getElementById("imagem_value");

                        div.addEventListener("click", function() {
                            input.click();
                        });
                        input.addEventListener("change", function() {
                            var nome = "sem arquivos...";
                            if (input.files.length > 0) nome = input.files[0].name;
                            div.innerHTML = nome;
                            imagem_value.value = nome;
                        });
                    </script>
                    <!-- ========== Fim Upload Icone ========== -->
					<div class="box_ip">
						<label for="nome">Nome</label>
						<input type="text" name="nome" id="nome" class="" size="30" maxlength="255" value="<?php echo $segmento_diferenciais['nome']; ?>"/>
					</div>

                    <div class="box_ip">
                        <div class="box_sel box_txt">
                            <label for="idsegmento">Segmentos</label>
                            <div class="box_sel_d">
                                <select name="idsegmento" id="idsegmento">
                                    <option value="" > Selecione </option>
                                    <?php foreach ($segmentos as $k => $s) { ?>
                                        <option value="<?= $s['idsegmento'] ?>" <?= ($s['idsegmento'] == $segmento_diferenciais['idsegmento'] ? ' selected="selected" ' : ''); ?> > <?= $s['nome'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box_ip">
						<div class="box_sel box_txt">
							<label for="status">Status</label>
							<div class="box_sel_d">
								<select name="status" id="status" class=''>
											<option value="1" <?=$segmento_diferenciais['status'] == "1" ? ' selected="selected" ' : '';?>> Ativo </option>
											<option value="2" <?=$segmento_diferenciais['status'] == "2" ? ' selected="selected" ' : '';?>> Inativo </option>
									</select>
							</div>
						</div>
					</div>
			</div> 
            
			<input type="hidden" name="idsegmento_diferenciais" id="idsegmento_diferenciais" value="<?= $idSegmento_diferenciais; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type="hidden" name="imagem" value="<?php echo $segmento_diferenciais['imagem']; ?>" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
            <input type='hidden' name='aspectRatioW2' id='aspectRatioW2' value='<?=$width2?>'>
            <input type='hidden' name='aspectRatioH2' id='aspectRatioH2' value='<?=$height2?>'>
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


<?php if($_REQUEST['acao'] == "listarSegmento_diferenciais"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
 
	<div id="titulo">
		<i class="fas fa-asterisk" aria-hidden="true"></i>
		<span>Listagem de Segmento_diferenciais</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=segmento_diferenciais&acao=formSegmento_diferenciais&met=cadastroSegmento_diferenciais">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv_nome">Título</label><input type="text" name="titulo" id="adv_nome"></div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>
 
	<div id="principal" >
		<div id="abas"> 
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Segmento_diferenciais</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=segmento_diferenciais&acao=formSegmento_diferenciais&met=cadastroSegmento_diferenciais"><img src="images/novo.png" alt="Cadastro de Segmento_diferenciais" title="Cadastrar Segmento_diferenciais" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=segmento_diferenciais&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=segmento_diferenciais&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			foreach($dados as $k=>$v){
				if(!empty($v)){
					$buscar .= $k.'='.$v.'&';
				}
			}
		?>


		<script type="text/javascript">
			queryDataTable = '<?php print $buscar; ?>';
			requestInicio = "tipoMod=segmento_diferenciais&p="+preventCache+"&";
			ordem = "";
			dir = "";
			$(document).ready(function(){
				preTableSegmento_diferenciais();
			});
			dataTableSegmento_diferenciais('<?php print $buscar; ?>');
			columnSegmento_diferenciais();
		</script> 

	</div>

<?php } ?>

<div id="modal-confirmacao">
    <form class="form" method="post">
        <input type="button" value="NÃO" class="button cancel" />
        <input type="button" value="SIM" class="button confirm"/>
    </form>
</div>