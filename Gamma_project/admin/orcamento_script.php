<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_CONTATOS") || define("CADASTRO_CONTATOS","cadastroOrcamento");
defined("EDIT_CONTATOS") || define("EDIT_CONTATOS","editOrcamento");
defined("DELETA_CONTATOS") || define("DELETA_CONTATOS","deletaOrcamento");

switch ($opx) {

	case CADASTRO_CONTATOS:
		include_once 'orcamento_class.php';

		$dados = $_REQUEST;
		$idOrcamento = cadastroOrcamento($dados);

		if (is_int($idOrcamento)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'orcamento';
			$log['descricao'] = 'Cadastrou orcamento ID('.$idOrcamento.') nome ('.$dados['nome'].') email ('.$dados['email'].') ';
			$log['request'] = $_REQUEST;
			novoLog($log);
			$status = true;
			$msg = "Contato enviado com sucesso, em breve entraremos em contato!";
			//header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemalerta='.urlencode('Orcamento criado com sucesso!'));
		} else {
			$status = false;
			$msg = "falha ao enviar mensagem!";
			
			//header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemerro='.urlencode('ERRO ao criar novo Orcamento!'));
		}
		die(json_encode(array('status'=>$status,'msg'=>$msg)));
	break;

	case EDIT_CONTATOS:
		include_once 'orcamento_class.php';

		$dados = $_REQUEST;
		$antigo = buscaOrcamento(array('idorcamento'=>$dados['idorcamento']));
		$antigo = $antigo[0];

		$idOrcamento = editOrcamento($dados);

		if ($idOrcamento != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'orcamento';
			$log['descricao'] = 'Editou orcamento ID('.$idOrcamento.') DE  nome ('.$antigo['nome'].') email ('.$antigo['email'].') telefone ('.$antigo['telefone'].')   PARA  nome ('.$dados['nome'].') email ('.$dados['email'].') telefone ('.$dados['telefone'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemalerta='.urlencode('Orcamento salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemerro='.urlencode('ERRO ao salvar Orcamento!'));
		}

	break;

	case DELETA_CONTATOS:
		include_once 'orcamento_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('orcamento_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaOrcamento(array('idorcamento'=>$dados['idu']));

			if (deletaOrcamento($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'orcamento';
				$log['descricao'] = 'Deletou orcamento ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemalerta='.urlencode('Orcamento deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=orcamento&acao=listarOrcamento&mensagemerro='.urlencode('ERRO ao deletar Orcamento!'));
			}
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