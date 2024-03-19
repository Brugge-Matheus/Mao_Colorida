<?php 
	 // Versao do modulo: 3.00.010416

   if(!isset($_POST["ajax"]) || empty($_POST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
  }

  if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

  $opx = $_REQUEST["opx"];

  defined("CADASTRO_SEGMENTO")          || define("CADASTRO_SEGMENTO", "cadastroSegmento");
  defined("EDIT_SEGMENTO")              || define("EDIT_SEGMENTO", "editSegmento");
  defined("DELETA_SEGMENTO")            || define("DELETA_SEGMENTO", "deletaSegmento");
  defined("INVERTE_STATUS")               || define("INVERTE_STATUS", "inverteStatus");
  defined("SALVA_IMAGEM")                 || define("SALVA_IMAGEM","salvaImagem");
  defined("EXCLUIR_IMAGEM")               || define("EXCLUIR_IMAGEM","excluirImagem");
  defined("CANCELAR_IMAGEM")              || define("CANCELAR_IMAGEM","cancelarImagem");
  defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");

  //GALERIA
  defined("SALVA_GALERIA")                || define("SALVA_GALERIA","salvarGaleria");
  defined("SALVAR_DESCRICAO_IMAGEM")      || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
  defined("EXCLUIR_IMAGEM_GALERIA")       || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
  defined("ALTERAR_POSICAO_IMAGEM")       || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
  defined("EXCLUIR_IMAGENS_TEMPORARIAS")  || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");

switch ($opx) {

  case CADASTRO_SEGMENTO:
    include_once 'segmento_class.php';
    include_once 'includes/fileImage.php';
    include_once 'includes/functions.php';

        $dados = $_REQUEST;

        $imagem = $_FILES;

        $arquivo = $_FILES['arquivo'];
        $nomeArquivo1 = "";

        $arquivo2 = $_FILES['arquivo2'];
        $nomeArquivo2 = "";
 
        if (isset($arquivo['name']) && $arquivo['error'] == 0) {
            $nome = $arquivo['name'];
            $nome = explode(".", $nome);
            $ext = $nome[count($nome) - 1];
            $nomeArquivo1 = converteUrl($nome[0]) . "." . $ext;
            $destinoArquivo = "files/arquivos/" . $nomeArquivo1;
         
            if (move_uploaded_file($arquivo['tmp_name'], $destinoArquivo)) {
              $dados['arquivo'] = $destinoArquivo;
            }
          }

          if (isset($arquivo2['name']) && $arquivo2['error'] == 0) {
            $nome = $arquivo2['name'];
            $nome = explode(".", $nome);
            $ext = $nome[count($nome) - 1];
            $nomeArquivo2 = converteUrl($nome[0]) . "." . $ext;
            $destinoArquivo = "files/arquivos/" . $nomeArquivo2;
         
            if (move_uploaded_file($arquivo2['tmp_name'], $destinoArquivo)) {
              $dados['arquivo1'] = $destinoArquivo;
            }
          }

        if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("segmento", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'resize', $coordenadas);
            fileImage("segmento", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/segmento/'.$nomeimagem;
            compressImage($caminho);

            $dados['imagem'] = $nomeimagem;
        }

        if (isset($_FILES['imagemCadastrar2']) && $_FILES['imagemCadastrar2']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("segmento", "", '', $imagem['imagemCadastrar2'], $dados['aspectRatioW2'], $dados['aspectRatioH2'], 'resize', $coordenadas);
            fileImage("segmento", $nomeimagem, 'original', $imagem['imagemCadastrar2'], '', '', 'original');

            $caminho = 'files/segmento/'.$nomeimagem;
            compressImage($caminho);

            $dados['banner'] = $nomeimagem;
        }

        if (isset($_FILES['imagemCadastrar3']) && $_FILES['imagemCadastrar3']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("segmento", "", '', $imagem['imagemCadastrar3'], $dados['aspectRatioW3'], $dados['aspectRatioH3'], 'cropped', $coordenadas);
            fileImage("segmento", $nomeimagem, 'original', $imagem['imagemCadastrar3'], '', '', 'original');

            $caminho = 'files/segmento/'.$nomeimagem;
            compressImage($caminho);

            $dados['imagem2'] = $nomeimagem;
        }

         $dados['urlrewrite'] = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($dados['urlrewrite']))));

    $idSegmento = cadastroSegmento($dados);

    if (is_int($idSegmento)) {      

      if(!empty($dados['segmento_faq'])){
        foreach($dados['segmento_faq'] as $keys => $segmento_faq){
  
            if($dados['segmento_faq'][$keys]['idsegmento_faq'] == 0 && $dados['segmento_faq'][$keys]['excluirSegmento_faq'] != 0){
                $dados['segmento_faq'][$keys]['idsegmento'] = $idSegmento;
                cadastroSegmento_faq($dados['segmento_faq'][$keys]);
            }
            elseif($dados['segmento_faq'][$keys]['excluirSegmento_faq'] == 0){
                $antigoSegmento_faq = buscaSegmento_faq(array('idsegmento_faq'=>$dados['segmento_faq'][$keys]['idsegmento_faq']));
                $antigoRecurso = buscaSegmento_faq(array('idsegmento_faq'=>$dados['segmento_faq'][$keys]['idsegmento_faq']));
                apagarImagemSegmento_faq($antigoRecurso[0]['imagem']);
                deletaSegmento_faq2($idSegmento,$dados['segmento_faq'][$keys]['idsegmento_faq']);
            }
            else{
                $dados['segmento_faq'][$keys]['idsegmento'] = $idSegmento;
                editSegmento_faq($dados['segmento_faq'][$keys]);
            }
        }
      }
      //salva log
      include_once 'log_class.php';
      $log['idusuario'] = $_SESSION['sgc_idusuario'];
      $log['modulo'] = 'segmento';
      $log['avaliacao'] = 'Cadastrou segmento ID('.$idSegmento.') titulo ('.$dados['titulo'].') nome_autor ('.$dados['nome_autor'].') avaliacao ('.$dados['avaliacao'].') valor ('.$dados['valor'].') imagem ('.$dados['imagem'].') status ('.$dados['status'].')';
      $_REQUEST['id_last_segmento'] = $idSegmento;
      $log['request'] = $_REQUEST;
        $log['operacao'] = 'cadastroSegmento';
      novoLog($log);
      header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemalerta='.urlencode('Segmento criado com sucesso!'));
    } else {
      header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemerro='.urlencode('ERRO ao criar novo Segmento!'));
    }

  break;

  case EDIT_SEGMENTO:
		include_once 'segmento_class.php';
    include_once 'includes/fileImage.php';
    include_once 'includes/functions.php';

		$dados = $_REQUEST;
		$arquivos = $_FILES;

    $antigo = buscaSegmento(array('idsegmento'=>$dados['idsegmento']));
		$antigo = $antigo[0];

    $imagens = $_FILES;

    if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
      $coordenadas = getDataImageCrop($imagens, $_POST['coordenadas']);
      $nomeimagem = fileImage("segmento", "", '', $imagens['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'resize', $coordenadas);
      fileImage("segmento", $nomeimagem, 'original', $imagens['imagemCadastrar'], '', '', 'original');

      $caminho = 'files/segmento/'.$nomeimagem;
      compressImage($caminho);

      $imgAntigo = $antigo['imagem'];
      deleteFiles('files/segmento/', $imgAntigo, array('','thumb_','thumb2_','original_'));
      $dados['imagem'] = $nomeimagem;
    }

    if (isset($_FILES['imagemCadastrar2']) && $_FILES['imagemCadastrar2']['error'] == 0) {
      $coordenadas = getDataImageCrop($imagens, $_POST['coordenadas']);
      $nomeimagem = fileImage("segmento", "", '', $imagens['imagemCadastrar2'], $dados['aspectRatioW2'], $dados['aspectRatioH2'], 'resize', $coordenadas);
      fileImage("segmento", $nomeimagem, 'original', $imagens['imagemCadastrar2'], '', '', 'original');

      $caminho = 'files/segmento/'.$nomeimagem;
      compressImage($caminho);

      $imgAntigo = $antigo['banner'];
      deleteFiles('files/segmento/', $imgAntigo, array('','thumb_','thumb2_','original_'));
      $dados['banner'] = $nomeimagem;
  }

    if (isset($arquivos['arquivo']['name']) && $arquivos['arquivo']['error'] == 0) {
			$arquivos = $arquivos['arquivo'];
			$nome = $arquivos['name'];
			$nome = explode(".", $nome);
			$ext = $nome[count($nome) - 1];
			$nomeArquivo = converteUrl($nome[0]) . "." . $ext;
		}

		$dados['arquivo'] = $antigo['arquivo'];

    if (isset($arquivos['arquivo1']['name']) && $arquivos['arquivo1']['error'] == 0) {
			$arquivos = $arquivos['arquivo1'];
			$nome = $arquivos['name'];
			$nome = explode(".", $nome);
			$ext = $nome[count($nome) - 1];
			$nomeArquivo = converteUrl($nome[0]) . "." . $ext;
		}

		$dados['arquivo1'] = $antigo['arquivo1'];

		$idSegmento = editSegmento($dados);

    if(!empty($dados['segmento_faq'])){
      foreach($dados['segmento_faq'] as $keys => $segmento_faq){

          if($dados['segmento_faq'][$keys]['idsegmento_faq'] == 0 && $dados['segmento_faq'][$keys]['excluirSegmento_faq'] != 0){
              $dados['segmento_faq'][$keys]['idsegmento'] = $idSegmento;
              cadastroSegmento_faq($dados['segmento_faq'][$keys]);
          }
          elseif($dados['segmento_faq'][$keys]['excluirSegmento_faq'] == 0){
              $antigoSegmento_faq = buscaSegmento_faq(array('idsegmento_faq'=>$dados['segmento_faq'][$keys]['idsegmento_faq']));
              $antigoRecurso = buscaSegmento_faq(array('idsegmento_faq'=>$dados['segmento_faq'][$keys]['idsegmento_faq']));
              apagarImagemSegmento_faq($antigoRecurso[0]['imagem']);
              deletaSegmento_faq2($idSegmento,$dados['segmento_faq'][$keys]['idsegmento_faq']);
          }
          else{
              $dados['segmento_faq'][$keys]['idsegmento'] = $idSegmento;
              editSegmento_faq($dados['segmento_faq'][$keys]);
          }
      }
    }

  if ($idSegmento != FALSE) {
    //salva log
    include_once 'log_class.php';
    if (!empty($nomeArquivo)) {
      $nomeArquivo = "files/arquivos/" . $idSegmento . $nomeArquivo;
      if (!file_exists("files/arquivos/")) {
        mkdir("files/arquivos/", 0777);
      }

      if (move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)) {
        $dados['arquivo'] = $nomeArquivo;
        $edit = editSegmento($dados);
      }
      if (move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)) {
        $dados['arquivo1'] = $nomeArquivo;
        $edit = editSegmento($dados);
      }

    }
    $log['idusuario'] = $_SESSION['sgc_idusuario'];
    $log['modulo'] = 'segmento';
    $log['avaliacao'] = 'Editou segmento ID('.$idSegmento.') DE  titulo ('.$antigo['titulo'].') imagem ('.$antigo['imagem'].') PARA  titulo ('.$dados['titulo'].') imagem ('.$dados['imagem'].')';
          $_REQUEST['id_last_segmento'] = $idSegmento;
    $log['request'] = $_REQUEST;
    novoLog($log);
    header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemalerta='.urlencode('Segmento salvo com sucesso!'));
  } else {
    header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemerro='.urlencode('ERRO ao salvar Segmento!'));
  }
  break;

  case DELETA_SEGMENTO:
    include_once 'segmento_class.php';
		include_once 'usuario_class.php';
    include_once 'includes/functions.php';

		if (!verificaPermissaoAcesso('segmento_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaSegmento(array('idsegmento'=>$dados['idu']));
            
            $imgAntigo = $antigo[0]['imagem'];

            $duvidas = buscaSegmento_faq(array('idsegmento'=>$dados['idu']));

            deletaSegmento_faq($duvida['idduvidas']);

			// apagarImagemSegmento($antigo[0]['imagem']);
            deleteFiles('files/segmento/', $imgAntigo, array('','thumb_','original_'));

			if (excluirSegmento($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'segmento';
				$log['avaliacao'] = 'Deletou segmento ID('.$dados['idu'].') ';
                $_REQUEST['id_last_segmento'] = $dados['idu'];
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemalerta='.urlencode('Segmento deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=segmento&acao=listarSegmento&mensagemerro='.urlencode('ERRO ao deletar Segmento!'));
			}
		}


  break;

  case INVERTE_STATUS:
		include_once("segmento_class.php");
		include_once("includes/functions.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';

		$tabela = 'segmento';
		$id = 'idsegmento';

		try {
			$segmento = buscaSegmento(array('idsegmento' => $dados['idsegmento']));
			$segmento = $segmento[0];

			// print_r($segmento);
			if($segmento['status'] == 'A'){
				$status = 'I';
			}
			else{
				$status = 'A';
			}

			$dadosUpdate = array();
			$dadosUpdate['idsegmento'] = $dados['idsegmento'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

			print json_encode($resultado);
		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

  case SALVA_IMAGEM:
    include_once('segmento_class.php');
    include_once 'includes/fileImage.php';
    include_once 'includes/functions.php';

    $dados = $_POST;
    $imagem = $_FILES;

    if(!empty($dados['idsegmento'])){
        $segmentoOld = buscaSegmento(array('idsegmento'=>$dados['idsegmento']));
        $segmentoOld = $segmentoOld[0];
    }

    if ((isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) || 
        (isset($imagem['imagemCadastrar2']) && $imagem['imagemCadastrar2']['error'] == 0) ||
        (isset($imagem['imagemCadastrar3']) && $imagem['imagemCadastrar3']['error'] == 0)) {

        if(isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0){
            $imagemCadastrar = $imagem['imagemCadastrar'];
        }else if(isset($imagem['imagemCadastrar2']) && $imagem['imagemCadastrar2']['error'] == 0){
            $imagemCadastrar = $imagem['imagemCadastrar2'];
        }else{
            $imagemCadastrar = $imagem['imagemCadastrar3'];
        };

        $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
        $nomeimagem = fileImage("segmento", "", '', $imagemCadastrar, $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);

        $caminho = 'files/segmento/'.$nomeimagem;
        compressImage($caminho);

        if(!empty($dados['idsegmento'])){
            if(!empty($segmentoOld[$dados['tipo']])){
                $apgImage = deleteFiles('files/segmento/', $segmentoOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                $segmentoOld[$dados['tipo']] = $nomeimagem;
                $edit = editSegmento($segmentoOld);
            }else{
                $segmentoOld[$dados['tipo']] = $nomeimagem;
                $edit = editSegmento($segmentoOld);
            }
        }

        echo json_encode(array('status'=>true, 'imagem'=>$nomeimagem));
    }else{
        echo json_encode(array('status'=>false, 'msg'=>'Erro ao salvar imagem. Tente novamente'));
    }
  break;

  case EXCLUIR_IMAGEM:
      include_once 'segmento_class.php';
      include_once 'includes/functions.php';

      $dados = $_REQUEST;
      $id = $dados['id'];
      $tipo = $dados['tipo'];
      $img = $dados['img'];
      $segmento = buscaSegmento(array('segmento'=>$id));
      $segmento = $segmento[0];

      $imgAntigo = $segmento[$tipo];
      deleteFiles('files/segmento/', $imgAntigo, array('','thumb_','original_'));
      $segmento[$tipo] = '';
      editSegmento($segmento);

      echo json_encode(array('status'=>true));

  break;

  case CANCELAR_IMAGEM:
    $dados = $_REQUEST;

    if(file_exists('files/'.$dados['pasta'].'/'.$dados['imagem'])){
        unlink('files/'.$dados['pasta'].'/'.$dados['imagem']);
    }

    echo json_encode(array('status'=>true));

  break;

  case VERIFICAR_URLREWRITE:

		include_once('segmento_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		 
		$urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
 		
 		if($dados['idsegmento'] && $dados['idsegmento'] <= 0){
 			$url = buscasegmento(array("urlrewrite"=>$urlrewrite));
 		}else{ 
 			$url = buscasegmento(array("urlrewrite"=>$urlrewrite,"not_idsegmento"=>$dados['idsegmento'])); 
 		} 

        // $url2 = buscaBlog_tags(array("urlrewrite"=>$urlrewrite));
        // $url3 = buscaBlog_categoria(array("urlrewrite"=>$urlrewrite));

 		if(empty($url) && empty($url2) && empty($url3)){ 
 			print '{"status":true,"url":"'.$urlrewrite.'"}';
 		}else{
 			print '{"status":false}';
 		} 

	break;

  //SALVA IMAGENS DA GALERIA 
  case SALVA_GALERIA:
      include_once ('segmento_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $idsegmento = $dados['idsegmento'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/segmento/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("segmento/galeria", "", "", $imagem['imagem'], 270, 370, 'resize');
      $thumb = fileImage("segmento/galeria", $nomeimagem, "thumb", $imagem['imagem'], 535, 370, 'resize');
        $thumb2 = fileImage("segmento/galeria", $nomeimagem, "thumb2", $imagem['imagem'], 530, 540, 'resize');
      // fileImage("segmento/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;
      $caminho2 = $caminhopasta.'/'.$thumb;
      $caminho3 = $caminhopasta.'/'.$thumb2;

      compressImage($caminho);
      compressImage($caminho2);
      compressImage($caminho3);

      //vai cadastrar se já tiver o id do segmento, senao so fica na pasta.
      $idsegmento_imagem = $nomeimagem; 

      if(is_numeric($idsegmento)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idsegmento'] = $idsegmento;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idsegmento_imagem = salvaImagemSegmento($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "idsegmento":"'.$idsegmento.'", "idsegmento_imagem":"'.$idsegmento_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
  break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('segmento_class.php');
      $dados = $_POST;

      $imagem = buscaSegmento_imagem(array("idsegmento_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editSegmento_imagem($imagem)){
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

      include_once('segmento_class.php');

      $dados = $_POST;  
      $idsegmento = (int)$dados['idsegmento'];
      $idsegmento_imagem = $dados['idsegmento_imagem'];
      $imagem = $dados['imagem']; 

      

      if(!empty($idsegmento) && $idsegmento > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemGSegmento($idsegmento_imagem, $idsegmento, $imagem);
         $retorno['status'] = deletarImagemGSegmento($idsegmento_imagem, $idsegmento, $imagem);
      }else{
         $retorno['status'] = deletarImagemGSegmento($idsegmento_imagem, $idsegmento, $imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('segmento_class.php');
      $dados = $_POST;  

      alterarPosicaoImagemSegmento($dados);
      print '{"status":true}';

   break; 

   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('segmento_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_segmento'])){
         $imgs = $dados['imagem_segmento'];
         foreach ($imgs as $key => $value) { 
            apagarImagemSegmento($value);
         }
      } 
      print '{"status":true}'; 
   break;

}
?>