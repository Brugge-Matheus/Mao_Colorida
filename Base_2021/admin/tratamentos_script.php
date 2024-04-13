<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["ajax"]) || empty($_REQUEST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_TRATAMENTOS") || define("CADASTRO_TRATAMENTOS","cadastroTratamentos");
defined("EDIT_TRATAMENTOS") || define("EDIT_TRATAMENTOS","editTratamentos");
defined("DELETA_TRATAMENTOS") || define("DELETA_TRATAMENTOS","deletaTratamentos");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("LISTA_TRATAMENTOS") || define("LISTA_TRATAMENTOS", "listaTratamentos");
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
	case CADASTRO_TRATAMENTOS:
		include_once 'tratamentos_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

	    $dados = $_REQUEST;
        $imagens = $_FILES;

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("tratamentos", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            $dados['icone'] = $nomeicone;
        }

        $caminhopasta = "files/imagem";

        if(!file_exists($caminhopasta)){
            mkdir($caminhopasta, 0777);
        }

        //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['recursos'])){
            foreach($imagens['recursos'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg as $img){
                $nomeimagem[] = fileImage("recursos", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['recursos'] as $keys => $imagem){
                foreach($nomeimagem as $key => $names){
                    $dados['recursos'][$key]['imagem'] = $names;
                }
            }
        }

        $arrayImg2 = array();
        if(!empty($imagens['testes'])){
            foreach($imagens['testes'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg2[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg2 as $img){
                $nomeimagem2[] = fileImage("testes", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['testes'] as $keys => $imagem){
                foreach($nomeimagem2 as $key => $names){
                    $dados['testes'][$key]['imagem'] = $names;
                }
            }
        }

        $idTratamentos = cadastroTratamentos($dados);

		if (is_int($idTratamentos)) {

            foreach ($dados['idtratamentos_imagem'] as $key => $idpi) {
                editIdTratamentos_imagem(array('idtratamentos'=>$idTratamentos,'idtratamentos_imagem'=>$idpi));
            }


            foreach($dados['recursos'] as $keys => $rec){
                $dados['recursos'][$keys]['idtratamentos'] = $idTratamentos;
                // if(empty($rec['icone'])){
                //  $rec['icone'] = 1;
                // }
                cadastroRecursos($dados['recursos'][$keys]);
            }

            foreach($dados['testes'] as $keys => $rec){
                $dados['testes'][$keys]['idtratamentos'] = $idTratamentos;
                // if(empty($rec['icone'])){
                //  $rec['icone'] = 1;
                // }
                cadastroTestes($dados['testes'][$keys]);
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'tratamentos';
			$log['descricao'] = 'Cadastrou tratamentos ID('.$idTratamentos.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemalerta='.urlencode('Tratamentos criado com sucesso!'));
		} else {
			header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemerro='.urlencode('ERRO ao criar novo Tratamentos!'));
		}

	break;

	case EDIT_TRATAMENTOS:
		include_once 'tratamentos_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';
      
		$dados = $_REQUEST;
        $imagens = $_FILES;

		$antigo = buscaTratamentos(array('idtratamentos'=>$dados['idtratamentos']));
		$antigo = $antigo[0];

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("tratamentos", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            apagarImagemTratamentos($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

      //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['recursos'])){
            foreach($imagens['recursos'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $arrayImg2 = array();
        if(!empty($imagens['testes'])){
            foreach($imagens['testes'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg2[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $idTratamentos = editTratamentos($dados);

      //=============Grid com Imagem===============//
         if(!empty($arrayImg)){
           foreach($arrayImg as $key => $imgsUpload){
               if(!empty($imgsUpload['tmp_name'])){
                   apagarImagemRecursos($dados['recursos'][$key]['imagem']);
                   $nomeimagem[] = fileImage("recursos", "", "", $imgsUpload, 50, 50, 'inside');
                   foreach($nomeimagem as $names){
                       $dados['recursos'][$key]['imagem'] = $names;
                   }
               }
               elseif($dados['recursos'][$key]['idrecursos'] != 0){
                  // $antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$key]['idrecursos'], 'idtratamentos' => $idTratamentos));
                  // $dados['recursos'][$key]['imagem'] = $antigoRecurso[0]['imagem'];
                  $dados['recursos'][$key]['imagem'] = $dados[0]['imagem'];
               }
           }
         }

         if(!empty($arrayImg2)){
           foreach($arrayImg2 as $key => $imgsUpload){
               if(!empty($imgsUpload['tmp_name'])){
                   apagarImagemTestes($dados['testes'][$key]['imagem']);
                   $nomeimagem[] = fileImage("testes", "", "", $imgsUpload, 40, 40, 'inside');
                   foreach($nomeimagem as $names){
                       $dados['testes'][$key]['imagem'] = $names;
                   }
               }
               elseif($dados['testes'][$key]['idtestes'] != 0){
                  // $antigoRecurso = buscaRecursos(array('idtestes'=>$dados['testes'][$key]['idtestes'], 'idtratamentos' => $idTratamentos));
                  // $dados['testes'][$key]['imagem'] = $antigoRecurso[0]['imagem'];
                  $dados['testes'][$key]['imagem'] = $dados[0]['imagem'];
               }
           }
         }

        if(!empty($dados['recursos'])){
            foreach($dados['recursos'] as $keys => $recursos){
                if($dados['recursos'][$keys]['idrecursos'] == 0 && $dados['recursos'][$keys]['excluirRecurso'] != 0){
                    $dados['recursos'][$keys]['idtratamentos'] = $idTratamentos;
                    cadastroRecursos($dados['recursos'][$keys]);
                }
                elseif($dados['recursos'][$keys]['excluirRecurso'] == 0){
                    $antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$keys]['idrecursos']));
                    apagarImagemRecursos($antigoRecurso[0]['imagem']);
                    deletaRecursos2($idTratamentos,$dados['recursos'][$keys]['idrecursos']);
                }
                else{
                    $dados['recursos'][$keys]['idtratamentos'] = $idTratamentos;
                    editRecursos($dados['recursos'][$keys]);
                }
            }
        }

        if(!empty($dados['testes'])){
            foreach($dados['testes'] as $keys => $testes){
                if($dados['testes'][$keys]['idtestes'] == 0 && $dados['testes'][$keys]['excluirRecurso'] != 0){
                    $dados['testes'][$keys]['idtratamentos'] = $idTratamentos;
                    cadastroTestes($dados['testes'][$keys]);
                }
                elseif($dados['testes'][$keys]['excluirRecurso'] == 0){
                    $antigoRecurso = buscaTestes(array('idtestes'=>$dados['testes'][$keys]['idtestes']));
                    apagarImagemTestes($antigoRecurso[0]['imagem']);
                    deletaTestes2($idTratamentos,$dados['testes'][$keys]['idtestes']);
                }
                else{
                    $dados['testes'][$keys]['idtratamentos'] = $idTratamentos;
                    editTestes($dados['testes'][$keys]);
                }
            }
        }

		if ($idTratamentos != FALSE) {

            if(!empty($nomeArquivo)){
                $nomeArquivo = "files/tratamentos/arquivos/".$nomeArquivo;
                if(!file_exists("files/tratamentos/arquivos/")){
                    mkdir("files/tratamentos/arquivos/",0777);
                }

                if(move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)){ 
                    $dados['arquivo'] = $nomeArquivo;
                    $edit = editTratamentos($dados);
                    apagarArquivoTratamentos($antigo['arquivo']);
                } 
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'tratamentos';
			$log['descricao'] = 'Editou tratamentos ID('.$idTratamentos.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$antigo['status'].') PARA nome ('.$dados['nome'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemalerta='.urlencode('Tratamentos salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemerro='.urlencode('ERRO ao salvar Tratamentos!'));
		}

	break;

	case DELETA_TRATAMENTOS:
		include_once 'tratamentos_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('tratamentos_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaTratamentos(array('idtratamentos'=>$dados['idu']));

            apagarImagemTratamentos($antigo[0]['thumbs']);
            apagarImagemTratamentos($antigo[0]['banner_topo']);

            $antigoRecursos = buscaRecursos(array('idtratamentos'=>$dados['idu']));
            $antigoTestes = buscaTestes(array('idtratamentos'=>$dados['idu']));

            foreach ($antigoRecursos as $key => $oldRec) {
                apagarImagemRecursos($oldRec['imagem']);
            }

            foreach ($antigoTestes as $key => $oldRec) {
                apagarImagemTestes($oldRec['imagem']);
            }

			if (deletaTratamentos($dados['idu']) == 1) {
                deletaRecursos($dados['idu']);
                deletaTestes($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'tratamentos';
				$log['descricao'] = 'Deletou tratamentos ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemalerta='.urlencode('Tratamentos deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=tratamentos&acao=listarTratamentos&mensagemerro='.urlencode('ERRO ao deletar Tratamentos!'));
			}
		}

	break;

    case SALVA_IMAGEM:
        include_once('tratamentos_class.php');
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

        $dados = $_POST;
        $imagem = $_FILES;

        if(!empty($dados['idtratamentos'])){
            $tratamentosOld = buscaTratamentos(array('idtratamentos'=>$dados['idtratamentos']));
            $tratamentosOld = $tratamentosOld[0];
        }

        if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("tratamentos", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
            // fileImage("tratamentos", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/tratamentos/'.$nomeimagem;
            compressImage($caminho);

            if(!empty($dados['idtratamentos'])){
                if(!empty($tratamentosOld[$dados['tipo']])){
                    $apgImage = deleteFiles('files/tratamentos/', $tratamentosOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                    $tratamentosOld[$dados['tipo']] = $nomeimagem;
                    $edit = editTratamentos($tratamentosOld);
                }else{
                    $tratamentosOld[$dados['tipo']] = $nomeimagem;
                    $edit = editTratamentos($tratamentosOld);
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
        include_once 'tratamentos_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $tratamentos = buscaTratamentos(array('tratamentos'=>$id));
        $tratamentos = $tratamentos[0];

        $imgAntigo = $tratamentos[$tipo];
        deleteFiles('files/tratamentos/', $imgAntigo, array('','thumb_','original_'));
        $tratamentos[$tipo] = '';
        editTratamentos($tratamentos);

        echo json_encode(array('status'=>true));

    break;

   case LISTA_TRATAMENTOS:
      include_once 'tratamentos_class.php';

      $dados = $_REQUEST;
      $listatratamentos = buscaTratamentos($dados);

      echo json_encode($listatratamentos);

   break;

   case LISTA_SUBCATEGORIAS:
      include_once 'tratamentos_class.php';
      include_once 'subcategoria_tratamentos_class.php';

      $dados = $_REQUEST;
      $listasubcategoria_tratamentos = buscaSubcategoria_tratamentos($dados);

      echo json_encode($listasubcategoria_tratamentos);

   break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
      include_once ('tratamentos_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $idtratamentos = $dados['idtratamentos'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/tratamentos/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("tratamentos/galeria", "", "", $imagem['imagem'], 294, 343, 'resize');
      // $thumb = fileImage("tratamentos/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop');
      // fileImage("tratamentos/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;

      compressImage($caminho);

      //vai cadastrar se já tiver o id do tratamentos, senao so fica na pasta.
      $idtratamentos_imagem = $nomeimagem; 

      if(is_numeric($idtratamentos)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idtratamentos'] = $idtratamentos;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idtratamentos_imagem = salvaImagemTratamentos($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "idtratamentos":"'.$idtratamentos.'", "idtratamentos_imagem":"'.$idtratamentos_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('tratamentos_class.php');
      $dados = $_POST;

      $imagem = buscaTratamentos_imagem(array("idtratamentos_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editTratamentos_imagem($imagem)){
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

      include_once('tratamentos_class.php');

      $dados = $_POST;  
      $idtratamentos = $dados['idtratamentos'];
      $idtratamentos_imagem = $dados['idtratamentos_imagem'];
      $imagem = $dados['imagem']; 

      if(is_numeric($idtratamentos) && $idtratamentos > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemBlogGaleriaTratamentos($idtratamentos_imagem, $idtratamentos);
         $retorno['status'] = apagarImagemBlogTratamentos($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemBlogTratamentos($imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('tratamentos_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemTratamentos($dados);
      print '{"status":true}';

   break; 


   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('tratamentos_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_tratamentos'])){
         $imgs = $dados['imagem_tratamentos'];
         foreach ($imgs as $key => $value) { 
            apagarImagemBlogTratamentos($value);
         }
      } 
      print '{"status":true}'; 
   break; 

   case EXCLUIR_ARQUIVO: 
        include_once('tratamentos_class.php');
        $dados = $_POST;

        // print_r($dados);die;
        $return = excluirArquivoTratamentos($dados);

        if($return == true){
           echo json_encode(array('status'=>true));
        }else{
           echo json_encode(array('status'=>false));
        }
    break; 

    case VERIFICAR_URLREWRITE:

        include_once('tratamentos_class.php');
        include_once('includes/functions.php');

        $dados = $_POST;

        $urlrewrite = converteUrl(utf8_encode(str_replace(" - ", " ", $dados['urlrewrite'])));
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $urlrewrite)));
        // echo $urlrewrite;
        // exit;
        $url = buscaTratamentos(array("urlrewrite" => $urlrewrite, "not_idtratamentos" => $dados['idtratamentos']));

        if (empty($url)) {
            print '{"status":true,"url":"' . $urlrewrite . '"}';
        } else {
            print '{"status":false,"msg":"Url já cadastrada para outro tratamento"}';
        }

    break;


    case INVERTE_STATUS:
        include_once("tratamentos_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';
        include_once("includes/functions.php");
        $tabela = 'tratamentos';
        $id = 'idtratamentos';

        try {
            $tratamentos = buscaTratamentos(array('idtratamentos' => $dados['idtratamentos']));
            $tratamentos = $tratamentos[0];

            // print_r($tratamentos);
            if($tratamentos['status'] == 1){
                $status = 0;
            }
            else{
                $status = 1;
            }

            $dadosUpdate = array();
            $dadosUpdate['idtratamentos'] = $dados['idtratamentos'];
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
