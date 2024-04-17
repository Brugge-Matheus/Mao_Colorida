<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["ajax"]) || empty($_REQUEST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_VALORES") || define("CADASTRO_VALORES","cadastroValores");
defined("EDIT_VALORES") || define("EDIT_VALORES","editValores");
defined("DELETA_VALORES") || define("DELETA_VALORES","deletaValores");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("LISTA_VALORES") || define("LISTA_VALORES", "listaValores");
defined("LISTA_SUBCATEGORIAS") || define("LISTA_SUBCATEGORIAS", "listaSubcategorias");
defined("CANCELAR_IMAGEM") || define("CANCELAR_IMAGEM","cancelarImagem");
defined("EXCLUIR_IMAGEM") || define("EXCLUIR_IMAGEM","excluirImagem");
//GALERIA
   defined("SALVA_GALERIA") || define("SALVA_GALERIA","salvarGaleria");
   defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
   defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
   defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
   defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");

// URLREWRITE
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE", "verificarUrlRewrite");

defined("EXCLUIR_ARQUIVO") || define("EXCLUIR_ARQUIVO","excluirArquivo");   

switch ($opx) {
	case CADASTRO_VALORES:
		include_once 'valores_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

	    $dados = $_REQUEST;
        $imagens = $_FILES;

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("valores", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            $dados['icone'] = $nomeicone;
        }

        $caminhopasta = "files/imagem";

        if(!file_exists($caminhopasta)){
            mkdir($caminhopasta, 0777);
        }

        //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['caracteristicas'])){
            foreach($imagens['caracteristicas'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg as $img){
                $nomeimagem[] = fileImage("caracteristicas", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['caracteristicas'] as $keys => $imagem){
                foreach($nomeimagem as $key => $names){
                    $dados['caracteristicas'][$key]['imagem'] = $names;
                }
            }
        }

        $arrayImg2 = array();
        if(!empty($imagens['utilizadores'])){
            foreach($imagens['utilizadores'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg2[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg2 as $img){
                $nomeimagem2[] = fileImage("utilizadores", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['utilizadores'] as $keys => $imagem){
                foreach($nomeimagem2 as $key => $names){
                    $dados['utilizadores'][$key]['imagem'] = $names;
                }
            }
        }

        $idValores = cadastroValores($dados);

		if (is_int($idValores)) {

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'valores';
			$log['descricao'] = 'Cadastrou valores ID('.$idValores.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=valores&acao=listarValores&mensagemalerta='.urlencode('Valores criado com sucesso!'));
		} else {
			header('Location: index.php?mod=valores&acao=listarValores&mensagemerro='.urlencode('ERRO ao criar novo Valores!'));
		}

	break;

	case EDIT_VALORES:
		include_once 'valores_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';
      
		$dados = $_REQUEST;
        $imagens = $_FILES;

		$antigo = buscaValores(array('idvalores'=>$dados['idvalores']));
		$antigo = $antigo[0];

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("valores", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            apagarImagemValores($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

        $idValores = editValores($dados);

		if ($idValores != FALSE) {

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'valores';
			$log['descricao'] = 'Editou valores ID('.$idValores.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$antigo['status'].') PARA nome ('.$dados['nome'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=valores&acao=listarValores&mensagemalerta='.urlencode('Valores salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=valores&acao=listarValores&mensagemerro='.urlencode('ERRO ao salvar Valores!'));
		}

	break;

	case DELETA_VALORES:
		include_once 'valores_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('valores_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=valores&acao=listarValores&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaValores(array('idvalores'=>$dados['idu']));

            $duvidas = buscaValores_faq(array('idvalores'=>$dados['idu']));

            deletaValores_faq($duvida['idvalores']);

            apagarImagemValores($antigo[0]['thumbs']);
            apagarImagemValores($antigo[0]['banner_topo']);

            foreach ($antigoCaracteristicas as $key => $oldRec) {
            }
            

			if (deletaValores($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'valores';
				$log['descricao'] = 'Deletou valores ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=valores&acao=listarValores&mensagemalerta='.urlencode('Valores deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=valores&acao=listarValores&mensagemerro='.urlencode('ERRO ao deletar Valores!'));
			}
		}

	break;

    case SALVA_IMAGEM:
        include_once('valores_class.php');
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

        $dados = $_POST;
        $imagem = $_FILES;

        if(!empty($dados['idvalores'])){
            $valoresOld = buscaValores(array('idvalores'=>$dados['idvalores']));
            $valoresOld = $valoresOld[0];
        }

        if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("valores", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
            // fileImage("valores", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/valores/'.$nomeimagem;
            compressImage($caminho);

            if(!empty($dados['idvalores'])){
                if(!empty($valoresOld[$dados['tipo']])){
                    $apgImage = deleteFiles('files/valores/', $valoresOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                    $valoresOld[$dados['tipo']] = $nomeimagem;
                    $edit = editValores($valoresOld);
                }else{
                    $valoresOld[$dados['tipo']] = $nomeimagem;
                    $edit = editValores($valoresOld);
                }
            }

            echo json_encode(array('status'=>true, 'imagem'=>$nomeimagem));
        }else{
            echo json_encode(array('status'=>false, 'msg'=>'Erro ao salvar imagem. Tente novamente'));
        }
    break;

    case CANCELAR_IMAGEM:
        $dados = $_REQUEST;

        if(file_exists('files/'.$dados['pasta'].'/'.$dados['imagem'])){
            unlink('files/'.$dados['pasta'].'/'.$dados['imagem']);
        }

        echo json_encode(array('status'=>true));

    break;

    case EXCLUIR_IMAGEM:
        include_once 'valores_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $valores = buscaValores(array('valores'=>$id));
        $valores = $valores[0];

        $imgAntigo = $valores[$tipo];
        deleteFiles('files/valores/', $imgAntigo, array('','thumb_','original_'));
        $valores[$tipo] = '';
        editValores($valores);

        echo json_encode(array('status'=>true));

    break;

   case LISTA_VALORES:
      include_once 'valores_class.php';

      $dados = $_REQUEST;
      $listavalores = buscaValores($dados);

      echo json_encode($listavalores);

   break;

   case LISTA_SUBCATEGORIAS:
      include_once 'valores_class.php';
      include_once 'subcategoria_valores_class.php';

      $dados = $_REQUEST;

      echo json_encode($listasubcategoria_valores);

   break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
      include_once ('valores_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $idvalores = $dados['idvalores'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/valores/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("valores/galeria", "", "", $imagem['imagem'], 294, 343, 'resize');
      // $thumb = fileImage("valores/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop');
      // fileImage("valores/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;

      compressImage($caminho);

      //vai cadastrar se já tiver o id do valores, senao so fica na pasta.
      $idvalores_imagem = $nomeimagem; 

      if(is_numeric($idvalores)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idvalores'] = $idvalores;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idvalores_imagem = salvaImagemValores($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "idvalores":"'.$idvalores.'", "idvalores_imagem":"'.$idvalores_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('valores_class.php');
      $dados = $_POST;

      $imagem = buscaValores_imagem(array("idvalores_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editValores_imagem($imagem)){
            print '{"status":true}';
         }else{
            print '{"status":false}';
         }
      }else{
         print '{"status":false}';
      }
   break;

   //EXCLUI A IMAGEM DA GALERIA SELECIONADA
   case EXCLUIR_IMAGEM_GALERIA:

      include_once('valores_class.php');

      $dados = $_POST;  
      $idvalores = $dados['idvalores'];
      $idvalores_imagem = $dados['idvalores_imagem'];
      $imagem = $dados['imagem']; 

      if(is_numeric($idvalores) && $idvalores > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemBlogGaleriaValores($idvalores_imagem, $idvalores);
         $retorno['status'] = apagarImagemBlogValores($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemBlogValores($imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('valores_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemValores($dados);
      print '{"status":true}';

   break; 


   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('valores_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_valores'])){
         $imgs = $dados['imagem_valores'];
         foreach ($imgs as $key => $value) { 
            apagarImagemBlogValores($value);
         }
      } 
      print '{"status":true}'; 
   break; 

   case EXCLUIR_ARQUIVO: 
        include_once('valores_class.php');
        $dados = $_POST;

        // print_r($dados);die;
        $return = excluirArquivoValores($dados);

        if($return == true){
           echo json_encode(array('status'=>true));
        }else{
           echo json_encode(array('status'=>false));
        }
    break; 

    case VERIFICAR_URLREWRITE:

        include_once('valores_class.php');
        include_once('includes/functions.php');

        $dados = $_POST;

        $urlrewrite = converteUrl(utf8_encode(str_replace(" - ", " ", $dados['urlrewrite'])));
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $urlrewrite)));
        // echo $urlrewrite;
        // exit;
        $url = buscaValores(array("urlrewrite" => $urlrewrite, "not_idvalores" => $dados['idvalores']));

        if (empty($url)) {
            print '{"status":true,"url":"' . $urlrewrite . '"}';
        } else {
            print '{"status":false,"msg":"Url já cadastrada para outro tratamento"}';
        }

    break;


    case INVERTE_STATUS:
        include_once("valores_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';
        include_once("includes/functions.php");
        $tabela = 'valores';
        $id = 'idvalores';

        try {
            $valores = buscaValores(array('idvalores' => $dados['idvalores']));
            $valores = $valores[0];

            // print_r($valores);
            if($valores['status'] == 1){
                $status = 0;
            }
            else{
                $status = 1;
            }

            $dadosUpdate = array();
            $dadosUpdate['idvalores'] = $dados['idvalores'];
            $dadosUpdate['status'] = $status;
            inverteStatus($dadosUpdate,$tabela,$id);

            print json_encode($resultado);
        } catch (Exception $e) {
            $resultado['status'] = 'falha';
            print json_encode($resultado);
        }
    break;

	default:
		if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
			header('Location: index.php?mod=home&mensagemerro='.urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}

}
