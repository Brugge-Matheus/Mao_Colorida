<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["ajax"]) || empty($_REQUEST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_DIFERENCIAIS") || define("CADASTRO_DIFERENCIAIS","cadastroDiferenciais");
defined("EDIT_DIFERENCIAIS") || define("EDIT_DIFERENCIAIS","editDiferenciais");
defined("DELETA_DIFERENCIAIS") || define("DELETA_DIFERENCIAIS","deletaDiferenciais");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("LISTA_DIFERENCIAIS") || define("LISTA_DIFERENCIAIS", "listaDiferenciais");
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
	case CADASTRO_DIFERENCIAIS:
		include_once 'diferenciais_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

	    $dados = $_REQUEST;
        $imagens = $_FILES;

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
            $dados['icone3'] = $nomeicone;
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

        $idDiferenciais = cadastroDiferenciais($dados);

		if (is_int($idDiferenciais)) {

            foreach ($dados['iddiferenciais_imagem'] as $key => $idpi) {
                editIdDiferenciais_imagem(array('iddiferenciais'=>$idDiferenciais,'iddiferenciais_imagem'=>$idpi));
            }

			foreach($dados['diferenciais_faq'] as $keys => $apl){
                $dados['diferenciais_faq'][$keys]['iddiferenciais'] = $idDiferenciais;
                cadastroDiferenciais_faq($dados['diferenciais_faq'][$keys]);
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'diferenciais';
			$log['descricao'] = 'Cadastrou diferenciais ID('.$idDiferenciais.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemalerta='.urlencode('Diferenciais criado com sucesso!'));
		} else {
			header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemerro='.urlencode('ERRO ao criar novo Diferenciais!'));
		}

	break;

	case EDIT_DIFERENCIAIS:
		include_once 'diferenciais_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';
      
		$dados = $_REQUEST;
        $imagens = $_FILES;

		$antigo = buscaDiferenciais(array('iddiferenciais'=>$dados['iddiferenciais']));
		$antigo = $antigo[0];

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            apagarImagemDiferenciais($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("diferenciais", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
            $dados['icone3'] = $nomeicone;
        }

      //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['caracteristicas'])){
            foreach($imagens['caracteristicas'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $idDiferenciais = editDiferenciais($dados);

      //=============Grid com Imagem===============//
         if(!empty($arrayImg)){
           foreach($arrayImg as $key => $imgsUpload){
               if(!empty($imgsUpload['tmp_name'])){
                   //apagarImagemCaracteristicas($dados['caracteristicas'][$key]['imagem']);
                   $nomeimagem[] = fileImage("caracteristicas", "", "", $imgsUpload, 50, 50, 'inside');
                   foreach($nomeimagem as $names){
                       $dados['caracteristicas'][$key]['imagem'] = $names;
                   }
               }
               elseif($dados['caracteristicas'][$key]['idcaracteristicas'] != 0){
                  // $antigoCaracteristicas = buscaCaracteristicas(array('idcaracteristicas'=>$dados['caracteristicas'][$key]['idcaracteristicas'], 'iddiferenciais' => $idDiferenciais));
                  // $dados['caracteristicas'][$key]['imagem'] = $antigoCaracteristicas[0]['imagem'];
                  $dados['caracteristicas'][$key]['imagem'] = $dados[0]['imagem'];
               }
           }
         } 
         
         if(!empty($dados['diferenciais_faq'])){

            deletaDiferenciais_faq($idDiferenciais);
            foreach($dados['diferenciais_faq'] as $keys => $apl){
                $dados['diferenciais_faq'][$keys]['iddiferenciais'] = $idDiferenciais;
                cadastroDiferenciais_faq($dados['diferenciais_faq'][$keys]);
            }
        }

		if ($idDiferenciais != FALSE) {

            if(!empty($nomeArquivo)){
                $nomeArquivo = "files/diferenciais/arquivos/".$nomeArquivo;
                if(!file_exists("files/diferenciais/arquivos/")){
                    mkdir("files/diferenciais/arquivos/",0777);
                }

                if(move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)){ 
                    $dados['arquivo'] = $nomeArquivo;
                    $edit = editDiferenciais($dados);
                    apagarArquivoDiferenciais($antigo['arquivo']);
                } 
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'diferenciais';
			$log['descricao'] = 'Editou diferenciais ID('.$idDiferenciais.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$antigo['status'].') PARA nome ('.$dados['nome'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemalerta='.urlencode('Diferenciais salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemerro='.urlencode('ERRO ao salvar Diferenciais!'));
		}

	break;

	case DELETA_DIFERENCIAIS:
		include_once 'diferenciais_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('diferenciais_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaDiferenciais(array('iddiferenciais'=>$dados['idu']));

            apagarImagemDiferenciais($antigo[0]['thumbs']);
            apagarImagemDiferenciais($antigo[0]['banner_topo']);

           // $antigoCaracteristicas = buscaCaracteristicas(array('iddiferenciais'=>$dados['idu']));
            //$antigoUtilizadores = buscaUtilizadores(array('iddiferenciais'=>$dados['idu']));

            // foreach ($antigoCaracteristicas as $key => $oldRec) {
            //     apagarImagemCaracteristicas($oldRec['imagem']);
            // }

			if (deletaDiferenciais($dados['idu']) == 1) {
                //deletaCaracteristicas($dados['idu']);
                //deletaUtilizadores($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'diferenciais';
				$log['descricao'] = 'Deletou diferenciais ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemalerta='.urlencode('Diferenciais deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=diferenciais&acao=listarDiferenciais&mensagemerro='.urlencode('ERRO ao deletar Diferenciais!'));
			}
		}

	break;

    case SALVA_IMAGEM:
        include_once('diferenciais_class.php');
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

        $dados = $_POST;
        $imagem = $_FILES;

        if(!empty($dados['iddiferenciais'])){
            $diferenciaisOld = buscaDiferenciais(array('iddiferenciais'=>$dados['iddiferenciais']));
            $diferenciaisOld = $diferenciaisOld[0];
        }

        if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("diferenciais", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
            // fileImage("diferenciais", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/diferenciais/'.$nomeimagem;
            compressImage($caminho);

            if(!empty($dados['iddiferenciais'])){
                if(!empty($diferenciaisOld[$dados['tipo']])){
                    $apgImage = deleteFiles('files/diferenciais/', $diferenciaisOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                    $diferenciaisOld[$dados['tipo']] = $nomeimagem;
                    $edit = editDiferenciais($diferenciaisOld);
                }else{
                    $diferenciaisOld[$dados['tipo']] = $nomeimagem;
                    $edit = editDiferenciais($diferenciaisOld);
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
        include_once 'diferenciais_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $diferenciais = buscaDiferenciais(array('diferenciais'=>$id));
        $diferenciais = $diferenciais[0];

        $imgAntigo = $diferenciais[$tipo];
        deleteFiles('files/diferenciais/', $imgAntigo, array('','thumb_','original_'));
        $diferenciais[$tipo] = '';
        editDiferenciais($diferenciais);

        echo json_encode(array('status'=>true));

    break;

   case LISTA_DIFERENCIAIS:
      include_once 'diferenciais_class.php';

      $dados = $_REQUEST;
      $listadiferenciais = buscaDiferenciais($dados);

      echo json_encode($listadiferenciais);

   break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
      include_once ('diferenciais_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $iddiferenciais = $dados['iddiferenciais'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/diferenciais/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("diferenciais/galeria", "", "", $imagem['imagem'], 294, 343, 'resize');
      // $thumb = fileImage("diferenciais/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop');
      // fileImage("diferenciais/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;

      compressImage($caminho);

      //vai cadastrar se já tiver o id do diferenciais, senao so fica na pasta.
      $iddiferenciais_imagem = $nomeimagem; 

      if(is_numeric($iddiferenciais)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['iddiferenciais'] = $iddiferenciais;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $iddiferenciais_imagem = salvaImagemDiferenciais($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "iddiferenciais":"'.$iddiferenciais.'", "iddiferenciais_imagem":"'.$iddiferenciais_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('diferenciais_class.php');
      $dados = $_POST;

      $imagem = buscaDiferenciais_imagem(array("iddiferenciais_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editDiferenciais_imagem($imagem)){
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

      include_once('diferenciais_class.php');

      $dados = $_POST;  
      $iddiferenciais = $dados['iddiferenciais'];
      $iddiferenciais_imagem = $dados['iddiferenciais_imagem'];
      $imagem = $dados['imagem']; 

      if(is_numeric($iddiferenciais) && $iddiferenciais > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemBlogGaleriaDiferenciais($iddiferenciais_imagem, $iddiferenciais);
         $retorno['status'] = apagarImagemBlogDiferenciais($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemBlogDiferenciais($imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('diferenciais_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemDiferenciais($dados);
      print '{"status":true}';

   break; 


   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('diferenciais_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_diferenciais'])){
         $imgs = $dados['imagem_diferenciais'];
         foreach ($imgs as $key => $value) { 
            apagarImagemBlogDiferenciais($value);
         }
      } 
      print '{"status":true}'; 
   break; 

   case EXCLUIR_ARQUIVO: 
        include_once('diferenciais_class.php');
        $dados = $_POST;

        // print_r($dados);die;
        $return = excluirArquivoDiferenciais($dados);

        if($return == true){
           echo json_encode(array('status'=>true));
        }else{
           echo json_encode(array('status'=>false));
        }
    break; 

    case VERIFICAR_URLREWRITE:
        include_once('diferenciais_class.php');
        include_once('includes/functions.php');

        $dados = $_POST;

        $urlrewrite = converteUrl(utf8_encode(str_replace(" - ", " ", $dados['urlrewrite'])));
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $urlrewrite)));

        $url = buscaDiferenciais(array("urlrewrite" => $urlrewrite, "not_iddiferenciais" => $dados['iddiferenciais']));

        if (empty($url)) {
            print '{"status":true,"url":"' . $urlrewrite . '"}';
        } else {
            print '{"status":false,"msg":"Url já cadastrada para outro tratamento"}';
        }

    break;


    case INVERTE_STATUS:
        include_once("diferenciais_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';
        include_once("includes/functions.php");
        $tabela = 'diferenciais';
        $id = 'iddiferenciais';

        try {
            $diferenciais = buscaDiferenciais(array('iddiferenciais' => $dados['iddiferenciais']));
            $diferenciais = $diferenciais[0];

            // print_r($diferenciais);
            if($diferenciais['status'] == 1){
                $status = 0;
            }
            else{
                $status = 1;
            }

            $dadosUpdate = array();
            $dadosUpdate['iddiferenciais'] = $dados['iddiferenciais'];
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
