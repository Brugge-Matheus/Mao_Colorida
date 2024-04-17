<?php 
	 // Versao do modulo: 3.00.010416

	include_once "valor_class.php";
	
	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="valor_css.css" />
<script type="text/javascript" src="valor_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formValor"){
	if($_REQUEST['met'] == "cadastroValor"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Você não tem privilégios para acessar este modulo!'));
			exit;
		}
		$action = "valor_script.php?opx=cadastroValor";
		$metodo_titulo = "Cadastro Valor";
		$idValor = 0 ;

		// dados para os campos
		$valor['title'] = "";
		$valor['description'] = "";
        $valor['keywords'] = "";
        $valor['urlrewrite'] = "";

	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Você não tem privilégios para acessar este modulo!'));
			exit;
		}
		$action = "valor_script.php?opx=editValor";
		$metodo_titulo = "Editar Valor";
		$idValor = (int) $_GET['idu'];
		$valor = buscaValor(array('idvalor'=>$idValor));
		if (count($valor) != 1) exit;
		$valor = $valor[0];	
	}
?>

	<div id="titulo">
		<i class="fas fa-question-circle" aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=valor&acao=listarValor">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=valor&acao=formValor&met=cadastroValor">Cadastro</a></li>
		</ul>
	</div>
	<div id="principal">
		<form class="form" name="formValor" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('title'));">
			<div id="informacaoValor" class="content">
				<div class="content_tit">Dados Valor:</div>
					<div class="box_ip separar" style='width:100%'>
							<label for="titulo">Titulo</label>
							<input name="titulo" id="title" class='required' value="<?php echo $valor['titulo']; ?>">
					</div>
					<div class="box_ip separar" style='width:100%'>
							<label for="resumo">Resumo</label>
							<textarea name="resumo" id="resumo" class=''><?php echo $valor['resumo']; ?></textarea>
					</div>
					<div class="box_ip">
						<div class="box_sel box_txt">
							<label for="status">Status</label>
								<div class="box_sel_d">
									<select name="status" id="status" class=''>
										<option value="1" <?php print($valor['status'] == "A" ? ' selected="selected" ' : ''); ?>> Ativo </option>
										<option value="0" <?php print($valor['status'] == "I" ? ' selected="selected" ' : ''); ?>> Inativo </option>
									</select>
								</div>
						</div>
					</div>
			</div>
			<input type="hidden" name="idvalor" value="<?php echo $idValor; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
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


<?php if($_REQUEST['acao'] == "listarValor"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Você não tem privilégios para acessar este modulo!'));
?>
	<div id="titulo">
	<i class="fas fa-question-circle" aria-hidden="true"></i>
		<span>Listagem de Valor</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=valor&acao=listarValor">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=valor&acao=formValor&met=cadastroValor">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv_title">Title</label><input type="text" name="title" id="adv_title"></div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>




	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Valor</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=valor&acao=formValor&met=cadastroValor"><img src="images/novo.png" alt="Cadastro Valor" title="Cadastrar Valor" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=valor&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=valor&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
				if(!empty($v))
					$buscar .= $k.'='.$v.'&';
			}
		?>


		<script type="text/javascript">
			queryDataTable = '<?php print $buscar; ?>';
			requestInicio = "tipoMod=valor&p="+preventCache+"&";
			ordem = "idvalor";
			dir = "asc";
			$(document).ready(function(){
				preTableValor();
			});
			dataTableValor('<?php print $buscar; ?>');
			columnValor();
		</script>




	</div>

<?php } ?>