<?php 
	 // Versao do modulo: 3.00.010416

	include_once "categoria_class.php";
	include_once "linhas_class.php";

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";

	$categorias = buscaCategoria(array("tipocategoria"=>1));

	$linhas = buscaLinhas(array('status'=>'A', "ordem" => "nome", "dir" => "asc"));

	$width = 1920;
	$height = 280;

	$tamanho = explode('M', ini_get('upload_max_filesize'));
	$tamanho = $tamanho[0].'MB';
?>
<link rel="stylesheet" type="text/css" href="categoria_css.css" />
<script type="text/javascript" src="categoria_js.js"></script>

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


<?php if($_REQUEST['acao'] == "formCategoria"){
	if($_REQUEST['met'] == "cadastroCategoria"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "categoria_script.php?opx=cadastroCategoria";
		$metodo_titulo = "Cadastro de Categoria";
		$idCategoria = 0 ;

		// dados para os campos
		$categoria['nome'] = "";
		$categoria['urlrewrite'] = "";
		$categoria['seotitle'] = "";
		$categoria['seodescription'] = "";
		$categoria['seokeywords'] = "";
		$categoria['idcategoria_pai'] = "";
		$categoria['imagem'] = "";
		$categoria['status'] = "A";
		$categoria['idcategoria'] = "";
		$categoria['tipocategoria'] = 0;
		$categoria['cor'] = "";
		$categoria['destaque'] = "";
		$categoria['idlinhas'] = "";

	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "categoria_script.php?opx=editCategoria";
		$metodo_titulo = "Editar Categoria";
		$idCategoria = (int) $_GET['idu'];
		$categoria = buscaCategoria(array('idcategoria'=>$idCategoria));
		if (count($categoria) != 1) exit;
		$categoria = $categoria[0];
	}
?>

	<div id="titulo">
		<img src="images/modulos/categoria_preto.png" height="24" width="24" alt="ico" />
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=categoria&acao=listarCategoria">Listagem</a></li>			
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formCategoria" id="formCategoria" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome', 'urlrewrite', 'tipocategoria', 'idcategoria_pai', 'status')); " >

			<div id="informacaoCategoria" class="content">
				<div class="content_tit">Dados Categoria de loja:</div>
					<div class="box_ip" style="width:100%;">
						<label  for="nome">Nome</label>
						<input type="text" name="nome" id="nome" size="30" maxlength="255" value="<?php echo $categoria['nome']; ?>" class="required"/>
					</div>

					<div class="box_ip" style="width:100%;">
						<label for="nome">Urlrewrite (exemplo-de-url-rewrite)</label>
						<input type="text" name="urlrewrite" id="urlrewrite" size="30" maxlength="255" value="<?= $categoria['urlrewrite']; ?>" class="required"/>
						<input type="hidden" name="urlrewriteantigo" id="urlrewriteantigo" value="<?= $categoria['urlrewrite']; ?>" />
					</div> 
					<div class="box_ip" style="width:100%;">
						<label  for="seotitle">Title</label>
						<input type="text" name="seotitle" id="seotitle" size="30" maxlength="255" value="<?php echo $categoria['seotitle']; ?>" />
					</div>
					<div class="box_ip" style="width:100%;">
						<label  for="resumo">Resumo da categoria</label>
						<textarea type="text" name="resumo" id="resumo" size="30" maxlength="255" value="<?php echo $categoria['resumo']; ?>" ><?php echo $categoria['resumo']; ?></textarea>
					</div>

					<div class="box_ip">
							<div class="box_sel box_txt">
									<label for="idlinhas">Linhas</label>
									<div class="box_sel_d">
											<select name="idlinhas" id="idlinhas">
													<option value="" > Selecione </option>
													<?php foreach ($linhas as $k => $l) { ?>
															<option value="<?= $l['idlinhas'] ?>" <?= ($l['idlinhas'] == $categoria['idlinhas'] ? ' selected="selected" ' : ''); ?> > <?= $l['nome'] ?> </option>
													<?php } ?>
											</select>
									</div>
							</div>
					</div>

					<!-- <div class="box_ip"> 
							<div class="box_sel">
								<label for="">Tipo</label>
								<div class="box_sel_d">
										<select name="tipocategoria" id="tipocategoria" class='required'>
												<option></option>
													<option value="1" <?php print ($categoria['tipocategoria'] == 1 ? ' selected="selected" ' : ''); ?> > Categoria </option>
													<option value="2" <?php print ($categoria['tipocategoria'] == 2 ? ' selected="selected" ' : ''); ?> > Subcategoria </option>
											</select>
								</div>
							</div>
					</div>  -->

					<!-- <div class="box_ip subcategoria" <?= ($categoria['tipocategoria'] != "2")? "style='display:none;'":"" ?>> 
							<div class="box_sel">
								<label for="">Categoria</label>
								<div class="box_sel_d">
										<select name="idcategoria_pai" id="idcategoria_pai" class="required">
												<option value='0'></option> 
												<?php foreach($categorias as $k => $v){ ?> 
														<option value='<?= $v['idcategoria'] ?>' <?= (($v['idcategoria'] == $categoria['idcategoria_pai'])? "SELECTED":""); ?> ><?= $v['nome'] ?></option> 
												<?php }; ?>
											</select>
								</div>
							</div>
					</div>  -->

					<div class="box_ip">
							<label  for="status">Status</label> 
							<div class="box_sel">
								<label for="">Status</label>
								<div class="box_sel_d">
										<select name="status" id="status" class='required'>
												<option value=""></option>
												<option value="A" <?= ($categoria['status'] == "A" ? ' selected="selected" ' : ''); ?> > Ativo </option>
													<option value="I" <?= ($categoria['status'] == "I" ? ' selected="selected" ' : ''); ?> > Inativo </option>
										</select>
								</div>
							</div>
					</div>

					<!-- CROPPER IMG -->
					<?php $caminho = 'files/categoria/'; ?>
					<div id="select-image-1" class="box_ip box_txt pd-left-important">
						<div class="box_ip box_txt">
								<div class="img_pricipal">
										<div>
												<div class="content_tit">Imagem</div>
												<div class="box_ip imagem-atual" style="<?=empty($categoria['imagem'])?'display: none;':''?>">
														<a data-tipo="imagem" data-img="<?=$categoria['imagem']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
														<img width="300" src="<?=empty($categoria['imagem'])?'images/cliente/logo.png':$caminho.$categoria['imagem']?>" class="img-categoria-form" alt=""/>
												</div>
										</div>
								</div>
								<div class="box-img-crop">
										<div class="docs-buttons">
												<div class="btn-group box_txt">
														<!--input FILE -->
														<input id="inputImage" class="cropped-image" name="imagemCadastrar" type="file"/>
														<br />
														<p class="pre">Tamanho recomendado: <?=$width?>x<?=$height?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
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
 
			</div>
			<input type="hidden" name="imagem" value="<?php echo $categoria['imagem']; ?>" />
			<input type="hidden" name="idcategoria" value="<?php echo $idCategoria; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
			<input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
			<input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
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


<?php if($_REQUEST['acao'] == "listarCategoria"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<img src="images/modulos/categoria_preto.png" height="22" width="24" alt="ico" />
		<span>Listagem de Categorias</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=categoria&acao=formCategoria&met=cadastroCategoria">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv_nome">Nome</label><input type="text"  name="nome" id="adv_nome"></div>
			<div class="box_ip"><label for="adv_urlrewrite">Urlrewrite</label><input type="text"  name="urlrewrite" id="adv_urlrewrite"></div>
			<div class="box_ip"><label for="adv_seotitle">Title</label><input type="text"  name="seotitle" id="adv_seotitle"></div>
			<div class="box_ip"><label for="adv_seodescription">Description</label><input type="text"  name="seodescription" id="adv_seodescription"></div>
			<div class="box_ip"><label for="adv_seokeywords">Keywords</label><input type="text"  name="seokeywords" id="adv_seokeywords"></div>
		 	<div class="box_ip">
                <label  for="status">Status</label> 
                <div class="box_sel">
                  <label for="">Status</label>
                  <div class="box_sel_d">
                        <select name="status" id="status" class='required'>
                      		<option></option>
                         	<option value="A"> Ativo </option>
                            <option value="I"> Inativo </option>
                        </select>
                  </div>
               </div>
            </div>

            <div class="box_ip"> 
                <div class="box_sel">
                  <label for="">Tipo</label>
                  <div class="box_sel_d">
                     	<select name="tipocategoria" id="tipocategoria" class='required'>
                      		<option></option>
                          	<option value="1"> Categoria </option>
                            <option value="2"> SubCategoria </option>
                      	</select>
                  </div>
               </div>
            </div> 

            <div class="box_ip categoria"> 
                <div class="box_sel">
                  <label for="">Categoria</label>
                  <div class="box_sel_d">
                     	<select name="idcategoria_pai" id="idcategoria_pai">
                      		<option value=''></option> 
                      		<? foreach($categorias as $k => $v){ ?> 
                      				<option value='<?= $v['idcategoria'] ?>'><?= $v['nome'] ?></option> 
                      		<? } ?>
                      	</select>
                  </div>
               </div>
            </div>  
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>




	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Categorias</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=categoria&acao=formCategoria&met=cadastroCategoria"><img src="images/novo.png" alt="Cadastro Categoria" title="Cadastrar Categoria" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=categoria&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=categoria&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=categoria&p="+preventCache+"&";
			ordem = "idcategoria";
			dir = "desc";
			$(document).ready(function(){
				preTableCategoria();
			});
			dataTableCategoria('<?php print $buscar; ?>');
			columnCategoria();
		</script>




	</div>

<?php } ?>

