<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];
 
defined("INVERTE_STATUS") || define("INVERTE_STATUS", "inverteStatus");
defined("CADASTRO_PARCEIROS") || define("CADASTRO_PARCEIROS","cadastroMarcas");
defined("EDIT_PARCEIROS") || define("EDIT_PARCEIROS","editMarcas");
defined("DELETA_PARCEIROS") || define("DELETA_PARCEIROS","deletaMarcas");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("EXCLUIR_IMAGEM") || define("EXCLUIR_IMAGEM","excluirImagem");

switch ($opx) {

	case CADASTRO_PARCEIROS:
		include_once 'marcas_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

		$dados = $_REQUEST;

        $imagem = $_FILES;

        if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("marcas", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
            fileImage("marcas", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/marcas/'.$nomeimagem;
            compressImage($caminho);

            $dados['imagem'] = $nomeimagem;
        }

		$idMarcas = cadastroMarcas($dados);

		if (is_int($idMarcas)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'marcas';
			$log['avaliacao'] = 'Cadastrou marcas ID('.$idMarcas.') titulo ('.$dados['titulo'].') nome_autor ('.$dados['nome_autor'].') avaliacao ('.$dados['avaliacao'].') valor ('.$dados['valor'].') imagem ('.$dados['imagem'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemalerta='.urlencode('Marcas criado com sucesso!'));
		} else {
			header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemerro='.urlencode('ERRO ao criar novo Marcas!'));
		}

		break;

	case EDIT_PARCEIROS:
		include_once 'marcas_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

		$dados = $_REQUEST;
		$antigo = buscaMarcas(array('idmarcas'=>$dados['idmarcas']));
		$antigo = $antigo[0];

        $imagem = $_FILES;
        if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
            $nomeimagem = fileImage("marcas", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
            fileImage("marcas", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/marcas/'.$nomeimagem;
            compressImage($caminho);

            // apagarImagemEquipe($antigo['imagem']);  
            $imgAntigo = $antigo['imagem'];
            deleteFiles('files/marcas/', $imgAntigo, array('','thumb_','thumb2_','original_'));
            $dados['imagem'] = $nomeimagem;
        }

		$idMarcas = editMarcas($dados);

		if ($idMarcas != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'marcas';
			$log['avaliacao'] = 'Editou marcas ID('.$idMarcas.') DE  titulo ('.$antigo['titulo'].') imagem ('.$antigo['imagem'].') PARA  titulo ('.$dados['titulo'].') imagem ('.$dados['imagem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemalerta='.urlencode('Marcas salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemerro='.urlencode('ERRO ao salvar Marcas!'));
		}

		break;

	case DELETA_PARCEIROS:
		include_once 'marcas_class.php';
		include_once 'usuario_class.php';
        include_once 'includes/functions.php';

		if (!verificaPermissaoAcesso('marcas_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaMarcas(array('idmarcas'=>$dados['idu']));

            $imgAntigo = $antigo[0]['imagem'];

			// apagarImagemMarcas($antigo[0]['imagem']);
            deleteFiles('files/marcas/', $imgAntigo, array('','thumb_','original_'));

			if (deletaMarcas($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'marcas';
				$log['avaliacao'] = 'Deletou marcas ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemalerta='.urlencode('Marcas deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=marcas&acao=listarMarcas&mensagemerro='.urlencode('ERRO ao deletar Marcas!'));
			}
		}

	break;
    
	case INVERTE_STATUS:
		include_once("marcas_class.php");
		include_once("includes/functions.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';

		$tabela = 'marcas';
		$id = 'idmarcas';

		try {
			$marcas = buscaMarcas(array('idmarcas' => $dados['idmarcas']));
			$marcas = $marcas[0];

			// print_r($marcas);
			if($marcas['status'] == 'A'){
				$status = 'I';
			}
			else{
				$status = 'A';
			}

			$dadosUpdate = array();
			$dadosUpdate['idmarcas'] = $dados['idmarcas'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

			print json_encode($resultado);
		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

    case EXCLUIR_IMAGEM:
        include_once 'marcas_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $marcas = buscaMarcas(array('idmarcas'=>$id));
        $marcas = $marcas[0];

        $imgAntigo = $marcas[$tipo];
        deleteFiles('files/marcas/', $imgAntigo, array('','thumb_','original_'));
        $marcas[$tipo] = '';
        editMarcas($marcas);

        echo json_encode(array('status'=>true));

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