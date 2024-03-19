<?php
   // Versao do modulo: 3.00.010416

    include_once "tratamentos_class.php";
    include_once "includes/functions.php";

    if (!isset($_REQUEST['acao']))
   	    $_REQUEST['acao'] = "";

    $width = 300;
    $height = 600;

    $width2 = 1920;
    $height2 = 1080;

    $width3 = 96;
    $height3 = 96;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';
?>
<link rel="stylesheet" type="text/css" href="tratamentos_css.css" />
<script type="text/javascript" src="tratamentos_js.js"></script>

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


<?php if ($_REQUEST['acao'] == "formTratamentos") {
	if ($_REQUEST['met'] == "cadastroTratamentos") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "tratamentos_script.php?opx=cadastroTratamentos";
		$metodo_titulo = "Cadastro Tratamentos";
		$idTratamentos = 0;

        $FontAwesome = false;

		// dados para os campos
		$tratamentos['nome'] = "";
		$tratamentos['status'] = "";
		$tratamentos['urlrewrite'] = "";
        $tratamentos['icone_name'] = "";
        $tratamentos['icone'] = "";
        $tratamentos['imagem'] = "";
        $tratamentos['banner_topo'] = "";
        $tratamentos['resumo'] = "";
        $tratamentos['descricao'] = "";
        $tratamentos_imagens = array();
	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "tratamentos_script.php?opx=editTratamentos";
		$metodo_titulo = "Editar Tratamentos";
		$idTratamentos = (int) $_GET['idu'];
		$tratamentos = buscaTratamentos(array('idtratamentos' => $idTratamentos));

        $recursos = buscaRecursos(array('idtratamentos'=>$idTratamentos, 'ordem'=>'ordem', 'dir'=>'asc'));
        $testes = buscaTestes(array('idtratamentos'=>$idTratamentos, 'ordem'=>'ordem', 'dir'=>'asc'));

		if (count($tratamentos) != 1) exit;
		$tratamentos = $tratamentos[0];

        $tratamentos_imagens = buscaTratamentos_imagem(array("idtratamentos"=>$tratamentos['idtratamentos'],"ordem"=>'posicao_imagem',"dir"=>'ASC'));

        $StringIcone = strlen($tratamentos['icone']);
        if ($StringIcone > 3) {
            $FontAwesome = false;
            $tratamentos['icone_name'] = '';
        } else {
            $FontAwesome = true;
            // $icones_Edit = buscaFW3(array('idfw' => $tratamentos['icone']));
            // $icones_Edit = $icones_Edit[0];
        }
	}
	?>

	<div id="titulo">
		<i class='fa fa-list' aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=tratamentos&acao=listarTratamentos">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=tratamentos&acao=formTratamentos&met=cadastroTratamentos">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formTratamentos" id="formTratamentos" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome'));" enctype="multipart/form-data">

			<div id="informacaoTratamentos" class="content">
				<div class="content_tit">Dados Tratamentos:</div>

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
                            <?php if ($_GET['met'] == 'editTratamentos') : ?>
                                <div id="mostrar_icone">
                                    <i id="current_icon" class='fas fa-<?=$tratamentos['icone_name'];?> fa-2x'></i>
                                    <input type="hidden" name="icone" value="<?= $tratamentos['icone']; ?>" id="imagem_icone">
                                    <input type="hidden" name="icone_name" value="<?= $tratamentos['icone_name']; ?>" id="icone_name">
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
                            <?php $caminho = "files/tratamentos/"; ?>
                            <div class="content_tit">Ícone</div>

                            <div class="botaoArquivo" id="inputArquivoBotao">
                                <input class="btn" type="button" value="Anexar Ícone">
                                <!-- <i class="fas fa-paperclip" aria-hidden="true"></i> -->
                            </div>

                            <img class="pump" src="<?= $caminho . $tratamentos['icone']; ?>" width='<?=$width3?>' id="icone" style="display: <?= $_GET['met'] == 'editTratamentos' ? (!empty($tratamentos['icone'] && !$FontAwesome) ? 'block' : 'none') : 'none'; ?>">
                            <p class="pre">Tamanho recomendado: <?=$width3?>x<?=$height3?>px (ou maior proporcional) - Extensão recomendada: jpg, png</p>
                            <span>O arquivo não pode ser maior que: <?=$tamanho?></span>
                            <input type="file" name="icone_upload" id="icone_upload" class="all_imagens" data-tipo='1'>
                            <input type="hidden" id="imagem_value">
                            <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                        </div>
                    </div>
                <!-- ========== Fim Upload Icone ========== -->

				<div class="box_ip">
					<label for="nome">Título</label>
					<input type="text" class="" name="nome" id="nome" value="<?php echo $tratamentos['nome']; ?>" />
				</div>
				<div class="box_ip">
					<label for="urlrewrite">Url</label>
					<input type="text" name="urlrewrite" class="" id="urlrewrite" value="<?php echo $tratamentos['urlrewrite']; ?>" />
				</div>

                <div class="box_ip box_txt">
                   <label for="resumo">Resumo</label>
                   <textarea name="resumo" id="resumo" class=""><?php echo $tratamentos['resumo']; ?></textarea>
                </div>

                <div class="box_ip box_txt">
                   <label for="descricao">Descrição</label>
                   <textarea name="descricao" id="descricao" class=""><?php echo $tratamentos['descricao']; ?></textarea>
                </div>

    			<div class="box_ip">
    				<label for="status">Status</label>
    				<div class="box_sel box_txt">
    					<label for>Status</label>
    					<div class="box_sel_d">
    						<select name="status" id="status">
    							<option value="1" <?=(($tratamentos['status'] == '1') ? 'SELECTED' : '')?>>Ativo</option>
                                <option value="0" <?=(($tratamentos['status'] == '0') ? 'SELECTED' : '')?>>Inativo</option>
    						</select>
    					</div>
    				</div>
    			</div>

                <!-- CROPPER IMG -->
                <?php $caminho = 'files/tratamentos/'; ?>
                <div id="select-image-1" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Imagem</div>
                                <div class="box_ip imagem-atual" style="<?=empty($tratamentos['imagem'])?'display: none;':''?>">
                                    <a data-tipo="imagem" data-img="<?=$tratamentos['imagem']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($tratamentos['imagem'])?'images/cliente/logo.png':$caminho.$tratamentos['imagem']?>" class="img-tratamentos-form" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="box-img-crop">
                            <div class="docs-buttons">
                                <div class="btn-group box_txt">
                                    <!--input FILE -->
                                    <input id="inputImage" class="cropped-image" name="imagemCadastrar2" type="file"/>
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

                <div id="select-image-2" class="box_ip box_txt pd-left-important">
                    <div class="box_ip box_txt">
                        <div class="img_pricipal">
                            <div>
                                <div class="content_tit">Banner</div>
                                <div class="box_ip imagem-atual" style="<?=empty($tratamentos['banner_topo'])?'display: none;':''?>">
                                    <a data-tipo="banner_topo" data-img="<?=$tratamentos['banner_topo']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                    <img width="120" src="<?=empty($tratamentos['banner_topo'])?'images/cliente/logo.png':$caminho.$tratamentos['banner_topo']?>" class="img-tratamentos-form" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="box-img-crop">
                            <div class="docs-buttons">
                                <div class="btn-group box_txt">
                                    <!--input FILE -->
                                    <input id="inputImage2" class="cropped-image" name="imagemCadastrar" type="file"/>
                                    <br />
                                    <p class="pre">Tamanho recomendado: <?=$width2?>x<?=$height2?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
                                    <span>O arquivo não pode ser maior que:
                                        <?=$tamanho?>
                                    </span>
                                    <input type="hidden" name="maxFileSize" id="maxFileSize2" value="<?php echo $tamanho; ?>" />
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

            <!-- =======================Recursos========================== -->
                <div class="listaRecursos box_ip box_txt">
                    <div class="content_tit">
                        <div class="content_tit">Recursos</div>
                        <a class="btn btn-recursos"><i class="fas fa-plus"></i> Adicionar</a>
                    </div>
                    <div class="gridLista" id="gridRecursos">
                        <table class="table" id="tableRecursos">
                            <thead>
                                <tr>
                                    <th align="center">Imagem/Ícone</th>
                                    <th></th>
                                    <th></th>
                                    <th align="center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="recursos">
                                <?php if(isset($recursos) && !empty($recursos)):?>
                                    <?php foreach($recursos as $key => $rec):?>
                                        <tr class="box-recursos removeRecursos-<?=$key;?>" data-key="<?=$key?>">
                                            <td align="center" class="td-padding">

                                                <?php if(empty($rec['imagem'])):?>
                                                    <img src="https://via.placeholder.com/50?text=Upload+Foto" width="50"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php else:?>
                                                    <img src="files/recursos/<?=$rec['imagem'];?>" width="50"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php endif;?>

                                                <input type="file" name="recursos[<?=$key;?>][imagem]" class="file-upload upload-<?=$key;?>" data-key="<?=$key;?>" data-grid="recursos">
                                                <span class="fs-11">Tamanho recomendado 50x50px </span>
                                                <input type="hidden" class="nome-img-cadastrada" name="recursos[<?=$key;?>][imagem]" value="<?=$rec['imagem'];?>">

                                                <br/><span><b>OU</b></span>

                                                <div id="mostrar_icone-<?=$key;?>" class="m-15">
                                                    <i id="current-icon-recursos-<?=$key?>" data-grid="recursos" class='current-icon fas fa-<?=$rec['nome_icone'];?> fa-2x '></i>
                                                    <input type="hidden" name="recursos[<?=$key;?>][icone]" value="<?=$rec['icone'];?>" id="imagem_icone-recursos-<?=$key;?>">
                                                    <input type="hidden" name="recursos[<?=$key;?>][nome_icone]" value="<?=$rec['nome_icone'];?>" id="nome_icone-recursos-<?=$key;?>">
                                                </div>
                                                <input type="button" value="Escolher ícone" data-grid="recursos" class="btn-choose-icon btn button-escolher-icone" data-key="<?=$key;?>">

                                                <input type="hidden" name="recursos[<?=$key;?>][idrecursos]" value="<?=$rec['idrecursos'];?>">
                                                <input id='excluirRecurso-<?=$key;?>' type="hidden" name="recursos[<?=$key;?>][excluirRecurso]" value="1">
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="box_txt inputRecursos w-100" name="recursos[<?=$key;?>][nome]" value="<?=$rec['nome'];?>" placeholder="Nome">
                                                <!-- <textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="recursos[<?=$key;?>][descricao]" placeholder="Descrição"><?=$rec['descricao'];?></textarea> -->
                                            </td>
                                            <td align="center">
                                                <span class="td-flex">
                                                    <span class="subirRecursos" data-key="<?=$key;?>">
                                                        <b class="fas fa-arrow-up"></b>
                                                    </span>
                                                    <span class="descerRecursos" data-key="<?=$key;?>">
                                                        <b class="fas fa-arrow-down"></b>
                                                    </span>
                                                    <span class="excluirRecursos" data-key="<?=$key;?>">
                                                        <b class="fas fa-trash"></b>
                                                    </span>
                                                    <input type="hidden" name="recursos[<?=$key?>][ordem]" value="<?=$rec['ordem']?>">
                                                </span>
                                            </td>
                                        </tr>

                                        <tr class="removeRecursos-<?=$key;?>">
                                            <td colspan="4">
                                                <!-- <div id="escolha-icone-<?=$key;?>"><div class="box_ip div-icones" style="width: 100% !important;"></div></div> -->
                                                <div data-grid="recursos" data-key="<?=$key?>" class="div-show-icons div-mostra-icones div-icones">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- =======================Fim Recursos========================== -->

            <!-- =======================Testes========================== -->
                <div class="listaTestes box_ip box_txt">
                    <div class="content_tit">
                        <div class="content_tit">Testes</div>
                        <a class="btn btn-testes"><i class="fas fa-plus"></i> Adicionar</a>
                    </div>
                    <div class="gridLista" id="gridTestes">
                        <table class="table" id="tableTestes">
                            <thead>
                                <tr>
                                    <th align="center">Imagem/Ícone</th>
                                    <th></th>
                                    <th></th>
                                    <th align="center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="testes">
                                <?php if(isset($testes) && !empty($testes)):?>
                                    <?php foreach($testes as $key => $rec):?>
                                        <tr class="box-testes removeTestes-<?=$key;?>" data-key="<?=$key?>">
                                            <td align="center" class="td-padding">

                                                <!-- <?php if(empty($rec['imagem'])):?>
                                                    <img src="https://via.placeholder.com/50?text=Upload+Foto" width="50"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php else:?>
                                                    <img src="files/testes/<?=$rec['imagem'];?>" width="50"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php endif;?>

                                                <input type="file" name="testes[<?=$key;?>][imagem]" class="file-upload upload-<?=$key;?>" data-key="<?=$key;?>" data-grid="testes">
                                                <span class="fs-11">Tamanho recomendado 50x50px </span> -->
                                                <input type="hidden" class="nome-img-cadastrada" name="testes[<?=$key;?>][imagem]" value="<?=$rec['imagem'];?>">

                                                <!-- <br/><span><b>OU</b></span>

                                                <div id="mostrar_icone-<?=$key;?>" class="m-15">
                                                    <i id="current-icon-testes-<?=$key?>" data-grid="testes" class='current-icon fas fa-<?=$rec['nome_icone'];?> fa-2x '></i> -->
                                                    <input type="hidden" name="testes[<?=$key;?>][icone]" value="<?=$rec['icone'];?>" id="imagem_icone-testes-<?=$key;?>">
                                                    <input type="hidden" name="testes[<?=$key;?>][nome_icone]" value="<?=$rec['nome_icone'];?>" id="nome_icone-testes-<?=$key;?>">
                                                <!-- </div>
                                                <input type="button" value="Escolher ícone" data-grid="testes" class="btn-choose-icon btn button-escolher-icone" data-key="<?=$key;?>">
                                                 -->
                                                <input type="hidden" name="testes[<?=$key;?>][idtestes]" value="<?=$rec['idtestes'];?>">
                                                <input id='excluirRecurso-<?=$key;?>' type="hidden" name="testes[<?=$key;?>][excluirRecurso]" value="1">
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="box_txt inputTestes w-100" name="testes[<?=$key;?>][nome]" value="<?=$rec['nome'];?>" placeholder="Nome">
                                                <textarea rows="6" type="text" style="resize: vertical" class="box_txt inputTestes w-100" name="testes[<?=$key;?>][descricao]" placeholder="Descrição"><?=$rec['descricao'];?></textarea>
                                            </td>
                                            <td align="center">
                                                <span class="td-flex">
                                                    <span class="subirTestes" data-key="<?=$key;?>">
                                                        <b class="fas fa-arrow-up"></b>
                                                    </span>
                                                    <span class="descerTestes" data-key="<?=$key;?>">
                                                        <b class="fas fa-arrow-down"></b>
                                                    </span>
                                                    <span class="excluirTestes" data-key="<?=$key;?>">
                                                        <b class="fas fa-trash"></b>
                                                    </span>
                                                    <input type="hidden" name="testes[<?=$key?>][ordem]" value="<?=$rec['ordem']?>">
                                                </span>
                                            </td>
                                        </tr>

                                        <tr class="removeTestes-<?=$key;?>">
                                            <td colspan="4">
                                                <!-- <div id="escolha-icone-<?=$key;?>"><div class="box_ip div-icones" style="width: 100% !important;"></div></div> -->
                                                <div data-grid="testes" data-key="<?=$key?>" class="div-show-icons div-mostra-icones div-icones">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- =======================Fim Testes========================== -->

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

               <!--################################## GALERIA ##################################-->
                  <div class="box_ip box_txt" id="tratamentos_imagem">
                     <div class="content_tit">Galeria</div>
                     <!--input FILE -->
                     <input id="image" name="image"  type="file" multiple />
                     <div class='tamanhoImagem'>
                        <p class="pre">Tamanho mínimo recomendado: 294x343px (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que: <?= $tamanho ?></strong>
                           <input type="hidden" id="fileMax" value="<?= $tamanho ?>" />
                        </span>
                     </div> 

                     <!-- listagem das imagens -->
                     <div class="box_ip content-image box_txt">
                        <!-- INÍCIO DRAG N' DROP-->  
                        <div class="box_ip content-image box_txt" id="content-image" >
                           <div style="overflow:hidden"></div>
                           <ul id="sortable">  
                              <?php
                                 if(!empty($tratamentos_imagens)){
                                    //LEMBRE-SE QUE A BUSCA DA TABELA tratamentos_imagem ORDENA PELO CAMPO posicao_imagem
                                    //DESTE MODO ESSE FOREACH JÁ ALOCARÁ CADA IMAGEM EM SUA RESPECTIVA POSIÇÃO                      
                                    $posicao = 1;
                                    foreach($tratamentos_imagens as $imagem){
                                       $caminho = 'files/tratamentos/galeria/'.$imagem['nome_imagem'];
                                       echo '<li class="ui-state-default'.$posicao.' move box-img" id="'.$posicao.'" idimagem="'.$imagem['idtratamentos_imagem'].'">';
                                       echo '<img src="'.$caminho.'" id="img'.$imagem['posicao_imagem'].'" class="imagem-gallery" />';
                                       echo '<a href="#" class="editImagemDescricao" idImagem="'.$imagem['idtratamentos_imagem'].'">';
                                       echo '<button class="edit"></button>'; 
                                       echo '</a>';
                                       echo '<a href="#" class="excluirImagem" idImagemDelete="'.$imagem['idtratamentos_imagem'].'">';
                                       echo '<button class="delete"></button>';  
                                       echo '</a>'; 

                                       // echo '<a href="#" class="postImagem" idImagemPost="'.$imagem['idtratamentos_imagem'].'">';
                                       // echo '<button class="post_imagem"></button>';   
                                       // echo '</a>'; 

                                       echo '<input type="hidden" name="idtratamentos_imagem[]" value="'.$imagem['idtratamentos_imagem'].'">';
                                       echo '<input type="hidden" name="descricao_imagem[]" value="'.$imagem['descricao_imagem'].'">';
                                       echo '<input type="hidden" name="imagem_tratamentos[]" value="'.$imagem['nome_imagem'].'">';
                                       echo '<input type="hidden" name="posicao_imagem[]" value="'.$imagem['posicao_imagem'].'">';
                                       echo '</li>'; 
                                       $posicao++;  
                                    }                       
                                 } 
                              ?> 
                           </ul>
                        </div> 
                     </div>  
                  </div>  
               <!--################################## FIM GALERIA ##################################-->

			</div>

            <input type="hidden" id="mod" name="mod" value="<?= ($idTratamentos == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" name="idtratamentos" id="idtratamentos" value="<?php echo $idTratamentos; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
            <input type='hidden' name='aspectRatioW2' id='aspectRatioW2' value='<?=$width2?>'>
            <input type='hidden' name='aspectRatioH2' id='aspectRatioH2' value='<?=$height2?>'>
            <input type='hidden' name='imagem' id='imagem-value' value='<?=$tratamentos['imagem']?>'>
            <input type='hidden' name='banner_topo' id='imagem_2-value' value='<?=$tratamentos['banner_topo']?>'>
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


<?php if ($_REQUEST['acao'] == "listarTratamentos") { ?><?php
if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
	header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
<div id="titulo">
	<i class='fa fa-list' aria-hidden="true"></i>
	<span>Listagem de Tratamentos</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=tratamentos&acao=listarTratamentos">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=tratamentos&acao=formTratamentos&met=cadastroTratamentos">Cadastro</a></li>
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
			<li class="abas_list_li action"><a href="javascript:void(0)">Tratamentos</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=tratamentos&acao=formTratamentos&met=cadastroTratamentos"><img src="images/novo.png" alt="Cadastro Tratamentos" title="Cadastrar Tratamentos" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=tratamentos&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=tratamentos&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
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
		requestInicio = "tipoMod=tratamentos&p=" + preventCache + "&";
		ordem = "idtratamentos";
		dir = "desc";
		$(document).ready(function() {
			preTableTratamentos();
		});
		dataTableTratamentos('<?php print $buscar; ?>');
		columnTratamentos();
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