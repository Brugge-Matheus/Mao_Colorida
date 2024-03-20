<?php 
	 // Versao do modulo: 3.00.010416

if(!isset($_REQUEST["opx"]) || $_REQUEST["opx"] != "listarSegmento_diferenciais"){
	require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_SEGMENTO_DIFERENCIAIS") || define("CADASTRO_SEGMENTO_DIFERENCIAIS","cadastroSegmento_diferenciais");
defined("EDIT_SEGMENTO_DIFERENCIAIS") || define("EDIT_SEGMENTO_DIFERENCIAIS","editSegmento_diferenciais");
defined("DELETA_SEGMENTO_DIFERENCIAIS") || define("DELETA_SEGMENTO_DIFERENCIAIS","deletaSegmento_diferenciais");
defined("LISTAR_SEGMENTO_DIFERENCIAIS") || define("LISTAR_SEGMENTO_DIFERENCIAIS","listarSegmento_diferenciais");
defined("PESQUISA_ICONE") || define("PESQUISA_ICONE", "pesquisaIcone");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA", "alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO", "alteraOrdemBaixo");
defined("EXCLUIR_IMAGEM") || define("EXCLUIR_IMAGEM","excluirImagem");

switch ($opx) {

	case CADASTRO_SEGMENTO_DIFERENCIAIS:
		include_once 'segmento_diferenciais_class.php';
		include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

		$dados = $_REQUEST;
		
        $imagem = $_FILES;

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("segmento_diferenciais", "", '', $imagem['icone'], $dados['aspectRatioW2'], $dados['aspectRatioH2'], 'inside');

            $caminho = 'files/segmento_diferenciais/'.$nomeicone;
            compressImage($caminho);

            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("segmento_diferenciais", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
            fileImage("segmento_diferenciais", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/segmento_diferenciais/'.$nomeimagem;
            compressImage($caminho);

            $dados['imagem'] = $nomeimagem;
        }

		$idSegmento_diferenciais = cadastroSegmento_diferenciais($dados);

		if (is_int($idSegmento_diferenciais)) {  
			 
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'segmento_diferenciais';
			$log['descricao'] = 'Cadastrou segmento_diferenciais ID('.$idSegmento_diferenciais.') título ('.$dados['titulo'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemalerta='.urlencode('Segmento_diferenciais criado com sucesso!'));
		} else {
			header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemerro='.urlencode('ERRO ao criar novo Segmento_diferenciais!'));
		}

	break;

	case EDIT_SEGMENTO_DIFERENCIAIS:
		include_once 'segmento_diferenciais_class.php';
		include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

		$dados = $_REQUEST;
        $imagem = $_FILES;
        $antigo = buscaSegmento_diferenciais(array('idsegmento_diferenciais'=>$dados['idsegmento_diferenciais']));
		$antigo = $antigo[0]; 

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("segmento_diferenciais", "", '', $imagem['icone'], $dados['aspectRatioW2'], $dados['aspectRatioH2'], 'inside');

            $caminho = 'files/segmento_diferenciais/'.$nomeicone;
            compressImage($caminho);
            
            // editarImagemSegmento_diferenciais($antigo['icone']);  
            $imgAntigo = $antigo['icone'];
            deleteFiles('files/segmento_diferenciais/', $imgAntigo, array('','thumb_','thumb2_','original_'));
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("segmento_diferenciais", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
            fileImage("segmento_diferenciais", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/segmento_diferenciais/'.$nomeimagem;
            compressImage($caminho);

            // apagarImagemEquipe($antigo['imagem']);  
            $imgAntigo = $antigo['imagem'];
            deleteFiles('files/segmento_diferenciais/', $imgAntigo, array('','thumb_','thumb2_','original_'));
            $dados['imagem'] = $nomeimagem;
        }

		$idSegmento_diferenciais = editSegmento_diferenciais($dados);

		if ($idSegmento_diferenciais != FALSE) { 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'segmento_diferenciais';
			$log['descricao'] = 'Editou segmento_diferenciais ID('.$idSegmento_diferenciais.') DE  título ('.$antigo['titulo'].') texto ('.$antigo['texto'].') imagem ('.$antigo['imagem'].') icone ('.$antigo['icone'].') ordem ('.$antigo['ordem'].') PARA  nome ('.$dados['nome'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemalerta='.urlencode('Segmento_diferenciais salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemerro='.urlencode('ERRO ao salvar Segmento_diferenciais!'));
		}

	break;

	case DELETA_SEGMENTO_DIFERENCIAIS:
		include_once 'segmento_diferenciais_class.php';
		include_once 'usuario_class.php';
        include_once 'includes/functions.php';

		if (!verificaPermissaoAcesso('segmento_diferenciais_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaSegmento_diferenciais(array('idsegmento_diferenciais'=>$dados['idu']));

			if (deletaSegmento_diferenciais($dados['idu']) == 1) {
				// editarImagemSegmento_diferenciais($antigo[0]['icone']);  
                $imgAntigo = $antigo[0]['icone'];
                $imgAntigo2 = $antigo[0]['imagem'];
                deleteFiles('files/segmento_diferenciais/', $imgAntigo, array('','thumb_','thumb2_','original_'));
                deleteFiles('files/segmento_diferenciais/', $imgAntigo2, array('','thumb_','thumb2_','original_'));
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'segmento_diferenciais';
				$log['descricao'] = 'Deletou segmento_diferenciais ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemalerta='.urlencode('Segmento_diferenciais deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=segmento_diferenciais&acao=listarSegmento_diferenciais&mensagemerro='.urlencode('ERRO ao deletar Segmento_diferenciais!'));
			}
		}

	break; 

	case LISTAR_SEGMENTO_DIFERENCIAIS: 

		include_once 'segmento_diferenciais_class.php';  
        $dados = $_REQUEST;  
        $retorno = array(); 
        $segmento_diferenciais = buscaSegmento_diferenciais($dados); 
        if(!isset($dados['filtro'])){
	        $retorno['dados'] = $segmento_diferenciais;
	        $dados['totalRecords'] = true;  
	        $total = buscaSegmento_diferenciais($dados); 
	        $total = $total[0]['totalRecords'];   
	        $retorno['total'] = $total; 
	        if($total > 0 && isset($dados['limit'])){ 
	            $paginas = ceil($total / $dados['limit']);
	            $retorno['totalPaginas'] = $paginas;
	        }
    	}
        print json_encode($retorno);
	break; 

    case EXCLUIR_IMAGEM:
        include_once 'segmento_diferenciais_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $segmento_diferenciais = buscaSegmento_diferenciais(array('idsegmento_diferenciais'=>$id));
        $segmento_diferenciais = $segmento_diferenciais[0];

        $imgAntigo = $segmento_diferenciais[$tipo];
        deleteFiles('files/segmento_diferenciais/', $imgAntigo, array('','thumb_','original_'));
        $segmento_diferenciais[$tipo] = '';
        editSegmento_diferenciais($segmento_diferenciais);

        echo json_encode(array('status'=>true));

    break;

   case PESQUISA_ICONE:
      include_once('servico_class.php');
      include_once('includes/functions.php');
      $dados = $_REQUEST;
      $icone = buscaFW3(array('nome' => $dados['nome'], 'ordem' => 'nome', 'dir' => 'asc'));
      if (!empty($icone)) {
         $html = '';
         foreach ($icone as $key => $i) {
            $html .= '<div style="width:6%; display: inline-block;" data-id="' . $i['idfw'] . '" data-toggle="tooltip" title="' . $i['nome'] . '">';
            $html .= '    <i class="fa fa-' . $i['nome'] . ' icone_icone" data-id="' . $i['idfw'] . '" data-nome="' . $i['nome'] . '" style="padding:11px; cursor: pointer;"></i>';
            $html .= '</div>';
         }
      } else {
         $html = '<span>Nenhum icone encontrado</span>';
      }
      echo $html;

   break;

	case ALTERA_ORDEM_CIMA:
		include_once("segmento_diferenciais_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$segmento_diferenciais = buscaSegmento_diferenciais(array('idsegmento_diferenciais' => $dados['idsegmento_diferenciais']));
			$segmento_diferenciais = $segmento_diferenciais[0];

			$ordem = $segmento_diferenciais['ordem'] - 1;

			$segmento_diferenciaisAux = buscaSegmento_diferenciais(array('order' => $ordem));

			if (!empty($segmento_diferenciaisAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idsegmento_diferenciais'] = $dados['idsegmento_diferenciais'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemSegmento_diferenciais($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idsegmento_diferenciais'] = $segmento_diferenciaisAux[0]['idsegmento_diferenciais'];
				$dadosUpdate2['ordem'] = intval($segmento_diferenciais['ordem']);
				editOrdemSegmento_diferenciais($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_BAIXO:
		include_once("segmento_diferenciais_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$segmento_diferenciais = buscaSegmento_diferenciais(array('idsegmento_diferenciais' => $dados['idsegmento_diferenciais']));
			$segmento_diferenciais = $segmento_diferenciais[0];

			$ordem = $segmento_diferenciais['ordem'] + 1;

			$segmento_diferenciaisAux = buscaSegmento_diferenciais(array('order' => $ordem));

			if (!empty($segmento_diferenciaisAux)) {
				$dadosUpdate = array();
				$dadosUpdate['idsegmento_diferenciais'] = $dados['idsegmento_diferenciais'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemSegmento_diferenciais($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idsegmento_diferenciais'] = $segmento_diferenciaisAux[0]['idsegmento_diferenciais'];
				$dadosUpdate2['ordem'] = intval($segmento_diferenciais['ordem']);
				editOrdemSegmento_diferenciais($dadosUpdate2);
			}

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
?>