<?php
// Versao do modulo: 3.00.010416
 
include_once "documentos_class.php";


if (!isset($_REQUEST['acao'])) 
	$_REQUEST['acao'] = "";

?>
<link rel="stylesheet" type="text/css" href="documentos_css.css" />
<script type="text/javascript" src="documentos_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if ($_REQUEST['acao'] == "formDocumentos") {
	if ($_REQUEST['met'] == "cadastroDocumentos") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "documentos_script.php?opx=cadastroDocumentos";
		$metodo_titulo = "Cadastro Documento";
		$idDocumentos = 0;
		$cadastro = TRUE;

		// dados para os campos
		$documentos['nome'] = "";
		$documentos['resumo'] = "";
		$documentos['arquivo'] = "";
		$documentos['status'] = "";
		$documentos['capa'] = "";
		$documentos['tipo'] = "";
		$documentos['marcas'] = "";

	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$cadastro = FALSE;
		$action = "documentos_script.php?opx=editDocumentos";
		$metodo_titulo = "Editar Documento";
		$idDocumentos = (int) $_GET['idu'];
		$documentos = buscaDocumentos(array('iddocumentos' => $idDocumentos));
		if (count($documentos) != 1) exit;
		$documentos = $documentos[0];
	}
	?>

	<div id="titulo">
	<i class="fas fa-book-open"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=documentos&acao=listarDocumentos">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=documentos&acao=formDocumentos&met=cadastroDocumentos">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formDocumentos" id="formDocumentos" enctype="multipart/form-data" method="post" action="<?php echo $action; ?>">

			<div id="informacaoDocumentos" class="content">
				<div class="content_tit">Dados Documento:</div>

				<div class="box_ip">
					<label for="nome">Nome</label>
					<input type="text" name="nome" id="nome" size="30" maxlength="255" value="<?php echo $documentos['nome']; ?>" />
				</div>
				
				<div class="box_sel" style="width:48.6%;">
					<label for="">Status</label>
					<div class="box_sel_d">
						<select name="status" id="status" class='required'>
							<option disabled>Selecione:</option>
							<option value="A" <?= (($documentos['status'] == 'A') ? 'selected="selected"' : ''); ?>> Ativo </option>
							<option value="I" <?= (($documentos['status'] == 'I') ? 'selected="selected"' : ''); ?>> Inativo </option>
						</select>
					</div>
				</div>

				<div class="box_ip">
					<label for="resumo">Resumo</label>
					<textarea type="text" name="resumo" id="resumo" size="30" maxlength="255" value="<?php echo $documentos['resumo']; ?>"><?php echo $documentos['resumo']; ?></textarea>
				</div>

				
				<?php //$caminho = "files/documentos/"; ?>
            <!-- <div class="box_ip imagem" style="width: 100%;padding-top:15px">
									<label for="capa" style="top:-5px">Capa: </label>
                    <input type="file" name="capa" id="icons_capa" class="all_imagens" data-tipo='1'>
                    <img src="<?= $caminho . $documentos['capa']; ?>" height='87' id="capa" style="margin-top: 10px;display: <?= $_GET['met'] == 'editDocumentos' ? (!empty($documentos['capa']) ? 'initial' : 'none') : 'none'; ?>">
                    <span>O arquivo não pode ser maior que:
                        <?php
                            $tamanho = explode('M', ini_get('upload_max_filesize'));
                            $tamanho = $tamanho[0];
                            echo $tamanho . 'MB';
                            ?>
                    </span>
                    <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                </div> -->
								
						<div class='box_ip' style='width:100%;'>
              <label for="arquivo"><b>Arquivo</b></label><br />
            </div>

            <div class="box_ip">
                <input type="file" name="arquivo" id="arquivo" value="<?php echo $documentos['arquivo']; ?>" />
            </div>

            <?php 
							if (!empty($documentos['arquivo']))
								print "<a href='files/documentos/" . $documentos['arquivo'] . "' target='_blank' style='float:left;width:100%;margin-left:20px;color:#000;font-weight:bold;'>Ver Arquivo</a>";
            ?>
			</div>


			<input type="hidden" name="iddocumentos" value="<?php echo $idDocumentos; ?>" />
			<input type="hidden" name="arquivo" id="arquivo" value="<?php echo $documentos['arquivo']; ?>" />
			<input type="hidden" name="capa" id="capa" value="<?php echo $documentos['capa']; ?>" />
			<input type="hidden" name="docs_uteis" value="1" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" onclick="history.go(-1);" class="bt_cancel cancelar" />
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


<?php if ($_REQUEST['acao'] == "listarDocumentos") { ?><?php
	if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
<div id="titulo">
<i class="fas fa-book-open"></i>
	<span>Listagem de Documentos</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=documentos&acao=listarDocumentos">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=documentos&acao=formDocumentos&met=cadastroDocumentos">Cadastro</a></li>
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
		<div class="box_ip"><label for="adv_categoria">Categoria</label><input type="text" name="categoria" id="adv_categoria"></div>
		<div class="box_sel" style="width:48.6%;">
			<label for="adv_status">Status</label>
			<div class="box_sel_d">
				<select name="status" id="adv_status" class='required'>
					<option></option>
					<option value="A"> Ativo </option>
					<option value="I"> Inativo </option>
				</select>
			</div>
		</div>
		<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
	</form>
</div>




<div id="principal">
	<div id="abas">
		<ul class="abas_list">
			<li class="abas_list_li action"><a href="javascript:void(0)">Documentos</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=documentos&acao=formDocumentos&met=cadastroDocumentos"><img src="images/novo.png" alt="Cadastro Documento" title="Cadastrar Documentos" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=documentos&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=documentos&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
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
		requestInicio = "tipoMod=documentos&p=" + preventCache + "&";
		ordem = "iddocumentos";
		dir = "desc";
		$(document).ready(function() {
			preTableDocumentos();
		});
		dataTableDocumentos('<?php print $buscar; ?>');
		columnDocumentos();
	</script>




</div>

<?php } ?>