<?php 
	 // Versao do modulo: 3.00.010416

	include_once "orcamento_class.php";
	include_once "produto_class.php";

 
	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = ""; 
	 
?>
<link rel="stylesheet" type="text/css" href="orcamento_css.css" />
<script type="text/javascript" src="orcamento_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formOrcamento"){
	if($_REQUEST['met'] == "cadastroOrcamento"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "orcamento_script.php?opx=cadastroOrcamento";
		$metodo_titulo = "Cadastro Orçamentos";
		$idOrcamento = 0 ;

		// dados para os campos
		$orcamento['idproduto'] = "";
		$orcamento['nome'] = "";
		$orcamento['nomeproduto'] = "";
		$orcamento['numero_orcamento'] = "";
		$orcamento['telefone'] = "";
		$orcamento['email'] = "";
		$orcamento['cpf'] = "";
		$orcamento['status_orcamento'] = "";
		$orcamento['qtde'] = "";
		$orcamento['assunto'] = "";

	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "orcamento_script.php?opx=editOrcamento";
		$metodo_titulo = "Editar Orçamentos";
		$idOrcamento = (int) $_GET['idu'];
		$orcamento = buscaOrcamento(array('idorcamento'=>$idOrcamento));
		if (count($orcamento) != 1) exit;
		$orcamento = $orcamento[0];
	}

?>

	<div id="titulo">
		<i class="fas fa-user"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=orcamento&acao=listarOrcamento">Listagem</a></li>
 		</ul>
	</div>  

	<div id="principal">
		<form class="form" name="formOrcamento" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome')); " >

			<div id="informacaoOrcamento" class="content">
				<div class="content_tit">Dados Orçamento: </div>
				<div class='emails_contato'>
					<div class="box_ip">
						<label for="nome">Nome Cliente</label>
						<input type="text" name="nome" id="nome" size="30" value="<?php echo $orcamento['nome']; ?>"/>
					</div>
					
					<div class="box_ip">
						<label for="telefone">Telefone</label>
						<input type="text" name="telefone" id="telefone" class="phone_br" value="<?php echo $orcamento['telefone']; ?>"/>
					</div> 
					
					<div class="box_ip">
						<label for="email">E-mail</label>
						<input type="text" name="email" id="email" size="30" value="<?php echo $orcamento['email']; ?>" />
					</div>  
					 
					<div class="box_ip">
						<label for="cpf">CPF</label>
						<input type="text" name="cpf" id="cpf" value="<?php echo $orcamento['cpf']; ?>"/>
					</div> 

					<div class="box_ip" style="width: 100%;">
						<label for="assunto">Assunto</label>
						<input type="text" name="assunto" id="assunto" size="30" value="<?php echo $orcamento['assunto']; ?>"/>
					</div>

					<div class="box_ip" style="width:35%;">
							<label for="numero_orcamento">Nº Orçamento</label>
							<input type="text" class="" name="numero_orcamento" id="numero_orcamento" size="30" maxlength="255"
											value='<?php echo $orcamento['numero_orcamento']; ?>' class='required'/>
					</div>

					<div class="box_ip" style="width:15%;">
						<label for="qtde">Quantidade</label>
						<input type="text" name="qtde" id="qtde" size="30" value="<?php echo $orcamento['qtde']; ?>"/>
					</div>

					<div class="box_ip">
						<label for="nomeproduto">Nome Produto</label>
						<input type="text" name="nomeproduto" id="nomeproduto" size="30" value="<?php echo $orcamento['nomeproduto']; ?>"/>
					</div>

					<div class="box_ip">
							<label for="status_orcamento">Status</label>
							<div class="box_sel">
									<label for="">Status</label>
									<div class="box_sel_d" style="width: 150%;">
											<select name="status_orcamento" id="status_orcamento" class='required'>
													<option value="Orçamento Recebido" <?= ($orcamento['status_orcamento'] == "Orçamento Recebido" ? ' selected="selected" ' : ''); ?> >
														Orçamento Recebido
													</option>
													<option value="Orçamento Enviado" <?= ($orcamento['status_orcamento'] == "Orçamento Enviado" ? ' selected="selected" ' : ''); ?> >
														Orçamento Enviado
													</option>
											</select>
									</div>
							</div>
					</div>

			<input type="hidden" name="idorcamento" id="idorcamento" value="<?php echo $idOrcamento; ?>" />
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


<?php if($_REQUEST['acao'] == "listarOrcamento"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
 
?>
	<div id="titulo">
		<i class="fas fa-user"></i>
		<span>Listagem de Orçamento</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=orcamento&acao=listarOrcamento">Listagem</a></li>
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
			<div class="box_ip"><label for="adv_email">E-mail</label><input type="text" name="email" id="adv_email"></div>
			<div class="box_ip"><label for="adv_telefone">Telefone</label><input type="text" name="telefone" id="adv_telefone" class="tel"></div>
			<div class="box_ip"><label for="adv_assunto">Assunto</label><input type="text" name="assunto" id="adv_assunto"></div>
			<!-- <div class="box_ip"><label for="adv_mensagem">Mensagem</label><input type="text" name="mensagem" id="adv_mensagem"></div> -->
			
			<!-- <div class="box_ip sel">
				<label for="idioma">Idioma</label> 
				<div class="box_sel" style='width:98%;margin:0;'>
					<label for="">Idioma</label>
					<div class="box_sel_d">
						<select name="ididiomas" id="ididiomas" class=''>
							<option></option> -->
							<?/* foreach($idiomas as $k => $v){ ?>
									<option value='<?= $v['ididiomas'] ?>'><?= $v['idioma'] ?></option>	
							<? } */?>
						<!-- </select>
					</div>
				</div>
			</div> -->
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>
	

	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Orcamento</a></li>
			</ul>
			<ul class="abas_bts">
				 <li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=orcamento&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=orcamento&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=orcamento&p="+preventCache+"&";
			ordem = "C.idorcamento";
			dir = "desc";
			$(document).ready(function(){
				preTableOrcamento();
			});
			dataTableOrcamento('<?php print $buscar; ?>');
			columnOrcamento();
		</script>
	</div>

<?php } ?>

