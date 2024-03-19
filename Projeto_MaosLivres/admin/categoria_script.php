<?php @session_start();
	 // Versao do modulo: 3.00.010416

if($_REQUEST["opx"] != "buscarCategorias"){
	require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_CATEGORIA") || define("CADASTRO_CATEGORIA","cadastroCategoria");
defined("EDIT_CATEGORIA") || define("EDIT_CATEGORIA","editCategoria");
defined("DELETA_CATEGORIA") || define("DELETA_CATEGORIA","deletaCategoria");
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");
defined("LISTAR_CATEGORIAS") || define("LISTAR_CATEGORIAS","buscarCategorias");
 

defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("DELETA_CADASTRO_TEMPORARIO") || define("DELETA_CADASTRO_TEMPORARIO","deletaCadastroTemporario");

switch ($opx) {

	case CADASTRO_CATEGORIA:
		include_once 'categoria_class.php';

		$dados = $_REQUEST;
		$imagem = $_FILES;

		if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
			$coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
			$nomeimagem = fileImage("categoria", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
			fileImage("categoria", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

			$caminho = 'files/categoria/'.$nomeimagem;
			compressImage($caminho);

			$dados['imagem'] = $nomeimagem;
	}

		$idtemporario = $dados['idcategoria'];
		if($dados['tipocategoria'] == 1){
			$dados['idcategoria_pai'] = 0;
		}

		if(!isset($dados['destaque'])){
			$dados['destaque'] = 0;
		} 
		$idCategoria = cadastroCategoria($dados);

		if(!is_numeric($idtemporario) && file_exists('files/categoria/'.$idtemporario.'/')){
			rename('files/categoria/'.$idtemporario, 'files/categoria/'.$idCategoria);
		} 

		if (is_int($idCategoria)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'categoria';
			$log['descricao'] = 'Cadastrou categoria ID('.$idCategoria.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') seotitle ('.$dados['seotitle'].') seodescription ('.$dados['seodescription'].') seokeywords ('.$dados['seokeywords'].') iconepositivo ('.$dados['iconepositivo'].') iconenegativo ('.$dados['iconenegativo'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('Categoria criado com sucesso!'));
		} else {
			header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('ERRO ao criar novo Categoria!'));
		}

	break;

	case EDIT_CATEGORIA:
		include_once 'categoria_class.php';

		$dados = $_REQUEST;
		$imagem = $_FILES;

		$antigo = buscaCategoria(array('idcategoria'=>$dados['idcategoria']));
		$antigo = $antigo[0];

		if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
			$coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
			$nomeimagem = fileImage("categoria", "", '', $imagem['imagemCadastrar'], $dados['aspectRatioW'], $dados['aspectRatioH'], 'cropped', $coordenadas);
			fileImage("categoria", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

			$caminho = 'files/categoria/'.$nomeimagem;
			compressImage($caminho);

			$dados['imagem'] = $nomeimagem;
	}
		if($dados['tipocategoria'] == 1){
			$dados['idcategoria_pai'] = 0;
		} 

		$idCategoria = editCategoria($dados);

		if ($idCategoria != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'categoria';
			$log['descricao'] = 'Editou categoria ID('.$idCategoria.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$antigo['urlrewrite'].') seotitle ('.$antigo['seotitle'].') seodescription ('.$antigo['seodescription'].') seokeywords ('.$antigo['seokeywords'].') iconepositivo ('.$antigo['iconepositivo'].') iconenegativo ('.$antigo['iconenegativo'].') status ('.$antigo['status'].') PARA  nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') seotitle ('.$dados['seotitle'].') seodescription ('.$dados['seodescription'].') seokeywords ('.$dados['seokeywords'].') iconepositivo ('.$dados['iconepositivo'].') iconenegativo ('.$dados['iconenegativo'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('Categoria salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('ERRO ao salvar Categoria!'));
		}

	break;

	case DELETA_CATEGORIA:
		include_once 'categoria_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('categoria_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaCategoria(array('idcategoria'=>$dados['idu']));

			if (deletaCategoria($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'categoria';
				$log['descricao'] = 'Deletou categoria ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('Categoria deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=categoria&acao=listarCategoria&mensagemalerta='.urlencode('ERRO ao deletar Categoria!'));
			}
		}

	break;


	case DELETA_CADASTRO_TEMPORARIO:

		include_once('categoria_class.php');
		$dados = $_POST;
 		
 		if(!is_numeric($dados['idtemporario'])){
			apagarPastaImagemCategoria($dados['idtemporario']);  
		}

		print '{"status":true}';

	break; 

	case SALVA_IMAGEM:
		include_once('categoria_class.php');
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';

		$dados = $_POST;
		$imagem = $_FILES;

		if(!empty($dados['idcategoria'])){
				$categoriaOld = buscacategoria(array('idcategoria'=>$dados['idcategoria']));
				$categoriaOld = $categoriaOld[0];
		}

		if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
				$coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
				$nomeimagem = fileImage("categoria", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
				// fileImage("categoria", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

				$caminho = 'files/categoria/'.$nomeimagem;
				compressImage($caminho);

				if(!empty($dados['idcategoria'])){
						if(!empty($categoriaOld[$dados['tipo']])){
								$apgImage = deleteFiles('files/categoria/', $categoriaOld[$dados['tipo']], array('', 'thumb_', 'original_'));
								$categoriaOld[$dados['tipo']] = $nomeimagem;
								$edit = editcategoria($categoriaOld);
						}else{
								$categoriaOld[$dados['tipo']] = $nomeimagem;
								$edit = editcategoria($categoriaOld);
						}
				}

				echo json_encode(array('status'=>true, 'imagem'=>$nomeimagem));
		}else{
				echo json_encode(array('status'=>false, 'msg'=>'Erro ao salvar imagem. Tente novamente'));
		}
	break;  


    case VERIFICAR_URLREWRITE:

		include_once('categoria_class.php');
		include_once('produto_class.php');
		include_once('includes/functions.php');
		
		$dados = $_POST;	 
		$dados['urlrewrite'] = str_replace("-"," ",$dados['urlrewrite']);
		$urlrewrite = converteUrl(utf8_encode($dados['urlrewrite']));
  	 
 		if(!isset($dados['idcategoria']) || $dados['idcategoria'] <= 0){
 			$url = buscaCategoria(array("urlrewrite"=>$urlrewrite));  			
 		}else{  
 			$url = buscaCategoria(array("urlrewrite"=>$urlrewrite,"not_idcategoria"=>$dados['idcategoria'])); 
 		}
  
 		if(empty($url)){  
 			$url = buscaProduto(array("urlrewrite"=>$urlrewrite));
 			if(empty($url)){
 				print '{"status":true,"url":"'.$urlrewrite.'"}';
 			}else{
 				print '{"status":false}';
 			} 
 		}else{
 			print '{"status":false}';
 		} 

	break;  


	case LISTAR_CATEGORIAS:

		include_once('categoria_class.php');
		include_once('includes/functions.php');
		
		$dados = $_POST;
		if(isset($dados['idcategoria_pai']) && !empty($dados['idcategoria_pai'])){
			$categorias = buscaCategoria(array("idcategoria_pai"=>$dados['idcategoria_pai'],"ordem"=>"nome asc"));	
		}
		else if(isset($dados['admin'])){
			$categorias = buscaCategoria($dados);	
		} 
		else{
			$categorias = buscaCategoria(array("status"=>"A","ordem"=>"nome asc"));	
		}
		 
 		print json_encode($categorias);

	break;   



	default:
		if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
			header('Location: index.php?mod=home&mensagemalerta='.urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}

}
?>