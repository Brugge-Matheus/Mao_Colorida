<?php
// Versao do modulo: 3.00.010416
require_once 'includes/verifica.php'; // checa user logado

if (!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_DOCUMENTOS") || define("CADASTRO_DOCUMENTOS", "cadastroDocumentos");
defined("EDIT_DOCUMENTOS") || define("EDIT_DOCUMENTOS", "editDocumentos");
defined("DELETA_DOCUMENTOS") || define("DELETA_DOCUMENTOS", "deletaDocumentos");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
 
switch ($opx) {
	 
	case INVERTE_STATUS:
    include_once 'includes/functions.php';

		$dados = $_REQUEST;
		inverteStatus($dados,$tabela,$id);
  break;

	case CADASTRO_DOCUMENTOS:
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';
		include_once 'documentos_class.php';

		$dados = $_REQUEST;
		$imagem = $_FILES;

		if(isset($_FILES['capa']) && $_FILES['capa']['error'] == 0){
            $nomeimagem = fileImage("documentos", "", '', $imagem['capa'], 477, 640, 'inside');
            $dados['capa'] = $nomeimagem;
        }

		$caminho = "files/documentos/";
		if (!file_exists($caminho)) {
			mkdir($caminho, 0777);
		}

		$Arquivo = explode(".", $_FILES['arquivo']['name']);
		$ext = $Arquivo[count($Arquivo) - 1];
		$NomeArquivo = $dados['nome'];
		$NomeArquivo = urlImage($NomeArquivo) . '.' . $ext;
		$dados['arquivo'] = $NomeArquivo;
		move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho . $NomeArquivo);

		$idDocumentos = cadastroDocumentos($dados);

		if (is_int($idDocumentos)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'documentos';
			$log['descricao'] = 'Cadastrou documentos ID(' . $idDocumentos . ') nome (' . $dados['nome'] . ') arquivo (' . $dados['arquivo'] . ') categoria (' . $dados['categoria'] . ') status (' . $dados['status'] . ') ididiomas (' . $dados['ididiomas'] . ')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('Documento criado com sucesso!'));
		} else {
			header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('ERRO ao criar novo Documento!'));
		}

		break;

	case EDIT_DOCUMENTOS:
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';
		include_once 'documentos_class.php';

		$dados = $_REQUEST;
		$antigo = buscaDocumentos(array('iddocumentos' => $dados['iddocumentos']));
		$antigo = $antigo[0];
		$imagem = $_FILES;

		if(isset($_FILES['capa']) && $_FILES['capa']['error'] == 0){
				$nomeimagem = fileImage("documentos", "", '', $imagem['capa'], 477, 640, 'inside');
				apagaImagens($antigo['capa'], 'documentos');
				$dados['capa'] = $nomeimagem;
		}
		
		$caminho = "files/documentos/";
		if (!file_exists($caminho)) {
			mkdir($caminho, 0777);
		}

		if (empty($_FILES['arquivo']['name']) && ($antigo['nome'] <> $dados['nome'] || $antigo['nome'] == $dados['nome'])) {
			$arquivo_antigo = $caminho.$antigo['arquivo'];
			$Arquivo = explode(".", $antigo['arquivo']);
			$ext = $Arquivo[count($Arquivo) - 1];
			$NomeArquivo = $dados['nome'];
			$NomeArquivo = urlImage($NomeArquivo) . '.' . $ext;
			$arquivo_atual  = $caminho.$NomeArquivo;
			rename($arquivo_antigo, $arquivo_atual);
			$dados['arquivo'] = $NomeArquivo;
		}
		else {
			$Arquivo = explode(".", $_FILES['arquivo']['name']);
			$ext = $Arquivo[count($Arquivo) - 1];
			$NomeArquivo = $dados['nome'];
			$NomeArquivo = urlImage($NomeArquivo) . '.' . $ext;
			$dados['arquivo'] = $NomeArquivo;
			move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho . $NomeArquivo);		
		}

		$idDocumentos = editDocumentos($dados);

		if ($idDocumentos != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'documentos';
			$log['descricao'] = 'Editou documentos ID(' . $idDocumentos . ') DE  nome (' . $antigo['nome'] . ') arquivo (' . $antigo['arquivo'] . ') categoria (' . $antigo['categoria'] . ') status (' . $antigo['status'] . ') ididiomas (' . $antigo['ididiomas'] . ') PARA  nome (' . $dados['nome'] . ') arquivo (' . $dados['arquivo'] . ') categoria (' . $dados['categoria'] . ') status (' . $dados['status'] . ') ididiomas (' . $dados['ididiomas'] . ')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('Documentos salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('ERRO ao salvar Documentos!'));
		}

		break;

	case DELETA_DOCUMENTOS:
		include_once 'documentos_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('documentos_deletar', $_SESSION['sgc_idusuario'])) {
			header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaDocumentos(array('iddocumentos' => $dados['idu']));

			if (deletaDocumentos($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'documentos';
				$log['descricao'] = 'Deletou documentos ID(' . $dados['idu'] . ') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('Documento deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=documentos&acao=listarDocumentos&mensagemalerta=' . urlencode('ERRO ao deletar Documento!'));
			}
		}

		break;

	default:
		if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
			header('Location: index.php?mod=home&mensagemalerta=' . urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}
}
