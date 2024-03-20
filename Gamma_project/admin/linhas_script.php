<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["ajax"]) || empty($_REQUEST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_LINHAS") || define("CADASTRO_LINHAS","cadastroLinhas");
defined("EDIT_LINHAS") || define("EDIT_LINHAS","editLinhas");
defined("DELETA_LINHAS") || define("DELETA_LINHAS","deletaLinhas");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("LISTA_LINHAS") || define("LISTA_LINHAS", "listaLinhas");
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
	case CADASTRO_LINHAS:
		include_once 'linhas_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

	    $dados = $_REQUEST;
        $imagens = $_FILES;

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
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

        $idLinhas = cadastroLinhas($dados);

		if (is_int($idLinhas)) {

            foreach ($dados['idlinhas_imagem'] as $key => $idpi) {
                editIdLinhas_imagem(array('idlinhas'=>$idLinhas,'idlinhas_imagem'=>$idpi));
            }

			foreach($dados['linhas_faq'] as $keys => $apl){
                $dados['linhas_faq'][$keys]['idlinhas'] = $idLinhas;
                cadastroLinhas_faq($dados['linhas_faq'][$keys]);
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'linhas';
			$log['descricao'] = 'Cadastrou linhas ID('.$idLinhas.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemalerta='.urlencode('Linhas criado com sucesso!'));
		} else {
			header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemerro='.urlencode('ERRO ao criar novo Linhas!'));
		}

	break;

	case EDIT_LINHAS:
		include_once 'linhas_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';
      
		$dados = $_REQUEST;
        $imagens = $_FILES;

		$antigo = buscaLinhas(array('idlinhas'=>$dados['idlinhas']));
		$antigo = $antigo[0];

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            apagarImagemLinhas($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("linhas", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
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

        $idLinhas = editLinhas($dados);

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
                  // $antigoCaracteristicas = buscaCaracteristicas(array('idcaracteristicas'=>$dados['caracteristicas'][$key]['idcaracteristicas'], 'idlinhas' => $idLinhas));
                  // $dados['caracteristicas'][$key]['imagem'] = $antigoCaracteristicas[0]['imagem'];
                  $dados['caracteristicas'][$key]['imagem'] = $dados[0]['imagem'];
               }
           }
         } 
         
         if(!empty($dados['linhas_faq'])){

            deletaLinhas_faq($idLinhas);
            foreach($dados['linhas_faq'] as $keys => $apl){
                $dados['linhas_faq'][$keys]['idlinhas'] = $idLinhas;
                cadastroLinhas_faq($dados['linhas_faq'][$keys]);
            }
        }

		if ($idLinhas != FALSE) {

            if(!empty($nomeArquivo)){
                $nomeArquivo = "files/linhas/arquivos/".$nomeArquivo;
                if(!file_exists("files/linhas/arquivos/")){
                    mkdir("files/linhas/arquivos/",0777);
                }

                if(move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)){ 
                    $dados['arquivo'] = $nomeArquivo;
                    $edit = editLinhas($dados);
                    apagarArquivoLinhas($antigo['arquivo']);
                } 
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'linhas';
			$log['descricao'] = 'Editou linhas ID('.$idLinhas.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$antigo['status'].') PARA nome ('.$dados['nome'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemalerta='.urlencode('Linhas salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemerro='.urlencode('ERRO ao salvar Linhas!'));
		}

	break;

	case DELETA_LINHAS:
		include_once 'linhas_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('linhas_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaLinhas(array('idlinhas'=>$dados['idu']));

            apagarImagemLinhas($antigo[0]['thumbs']);
            apagarImagemLinhas($antigo[0]['banner_topo']);

           // $antigoCaracteristicas = buscaCaracteristicas(array('idlinhas'=>$dados['idu']));
            //$antigoUtilizadores = buscaUtilizadores(array('idlinhas'=>$dados['idu']));

            // foreach ($antigoCaracteristicas as $key => $oldRec) {
            //     apagarImagemCaracteristicas($oldRec['imagem']);
            // }

			if (deletaLinhas($dados['idu']) == 1) {
                //deletaCaracteristicas($dados['idu']);
                //deletaUtilizadores($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'linhas';
				$log['descricao'] = 'Deletou linhas ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemalerta='.urlencode('Linhas deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=linhas&acao=listarLinhas&mensagemerro='.urlencode('ERRO ao deletar Linhas!'));
			}
		}

	break;

    case SALVA_IMAGEM:
        include_once('linhas_class.php');
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

        $dados = $_POST;
        $imagem = $_FILES;

        if(!empty($dados['idlinhas'])){
            $linhasOld = buscaLinhas(array('idlinhas'=>$dados['idlinhas']));
            $linhasOld = $linhasOld[0];
        }

        if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("linhas", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
            // fileImage("linhas", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/linhas/'.$nomeimagem;
            compressImage($caminho);

            if(!empty($dados['idlinhas'])){
                if(!empty($linhasOld[$dados['tipo']])){
                    $apgImage = deleteFiles('files/linhas/', $linhasOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                    $linhasOld[$dados['tipo']] = $nomeimagem;
                    $edit = editLinhas($linhasOld);
                }else{
                    $linhasOld[$dados['tipo']] = $nomeimagem;
                    $edit = editLinhas($linhasOld);
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
        include_once 'linhas_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $linhas = buscaLinhas(array('linhas'=>$id));
        $linhas = $linhas[0];

        $imgAntigo = $linhas[$tipo];
        deleteFiles('files/linhas/', $imgAntigo, array('','thumb_','original_'));
        $linhas[$tipo] = '';
        editLinhas($linhas);

        echo json_encode(array('status'=>true));

    break;

   case LISTA_LINHAS:
      include_once 'linhas_class.php';

      $dados = $_REQUEST;
      $listalinhas = buscaLinhas($dados);

      echo json_encode($listalinhas);

   break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
      include_once ('linhas_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $idlinhas = $dados['idlinhas'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/linhas/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("linhas/galeria", "", "", $imagem['imagem'], 294, 343, 'resize');
      // $thumb = fileImage("linhas/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop');
      // fileImage("linhas/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;

      compressImage($caminho);

      //vai cadastrar se já tiver o id do linhas, senao so fica na pasta.
      $idlinhas_imagem = $nomeimagem; 

      if(is_numeric($idlinhas)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idlinhas'] = $idlinhas;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idlinhas_imagem = salvaImagemLinhas($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "idlinhas":"'.$idlinhas.'", "idlinhas_imagem":"'.$idlinhas_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('linhas_class.php');
      $dados = $_POST;

      $imagem = buscaLinhas_imagem(array("idlinhas_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editLinhas_imagem($imagem)){
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

      include_once('linhas_class.php');

      $dados = $_POST;  
      $idlinhas = $dados['idlinhas'];
      $idlinhas_imagem = $dados['idlinhas_imagem'];
      $imagem = $dados['imagem']; 

      if(is_numeric($idlinhas) && $idlinhas > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemBlogGaleriaLinhas($idlinhas_imagem, $idlinhas);
         $retorno['status'] = apagarImagemBlogLinhas($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemBlogLinhas($imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('linhas_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemLinhas($dados);
      print '{"status":true}';

   break; 


   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('linhas_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_linhas'])){
         $imgs = $dados['imagem_linhas'];
         foreach ($imgs as $key => $value) { 
            apagarImagemBlogLinhas($value);
         }
      } 
      print '{"status":true}'; 
   break; 

   case EXCLUIR_ARQUIVO: 
        include_once('linhas_class.php');
        $dados = $_POST;

        // print_r($dados);die;
        $return = excluirArquivoLinhas($dados);

        if($return == true){
           echo json_encode(array('status'=>true));
        }else{
           echo json_encode(array('status'=>false));
        }
    break; 

    case VERIFICAR_URLREWRITE:
        include_once('linhas_class.php');
        include_once('includes/functions.php');

        $dados = $_POST;

        $urlrewrite = converteUrl(utf8_encode(str_replace(" - ", " ", $dados['urlrewrite'])));
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $urlrewrite)));

        $url = buscaLinhas(array("urlrewrite" => $urlrewrite, "not_idlinhas" => $dados['idlinhas']));

        if (empty($url)) {
            print '{"status":true,"url":"' . $urlrewrite . '"}';
        } else {
            print '{"status":false,"msg":"Url já cadastrada para outro tratamento"}';
        }

    break;


    case INVERTE_STATUS:
        include_once("linhas_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';
        include_once("includes/functions.php");
        $tabela = 'linhas';
        $id = 'idlinhas';

        try {
            $linhas = buscaLinhas(array('idlinhas' => $dados['idlinhas']));
            $linhas = $linhas[0];

            // print_r($linhas);
            if($linhas['status'] == 1){
                $status = 0;
            }
            else{
                $status = 1;
            }

            $dadosUpdate = array();
            $dadosUpdate['idlinhas'] = $dados['idlinhas'];
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
