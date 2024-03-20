<?php @ob_start(); @session_start();
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["opx"]) || ($_REQUEST["opx"] != "listarProduto")){  
	require_once 'includes/verifica.php'; // checa user logado
}


if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_PRODUTO") || define("CADASTRO_PRODUTO","cadastroProduto");
defined("EDIT_PRODUTO") || define("EDIT_PRODUTO","editProduto");
defined("DELETA_PRODUTO") || define("DELETA_PRODUTO","deletaProduto");

defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");
defined("LISTAR_PRODUTO") || define("LISTAR_PRODUTO","listarProduto");
  
defined("SALVA_IMAGEM_PRODUTO") || define("SALVA_IMAGEM_PRODUTO","salvaImagem");
defined("DELETA_CADASTRO_TEMPORARIO") || define("DELETA_CADASTRO_TEMPORARIO","deletaCadastroTemporario");
 
//PRODUTO
defined("SALVA_GALERIA") || define("SALVA_GALERIA","salvarGaleria");
defined("SALVA_PRODUTO") || define("SALVA_PRODUTO","salvarProduto");
defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");

 
switch ($opx) {

	case CADASTRO_PRODUTO:
		include_once 'produto_class.php';
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';

		$dados = $_REQUEST;
		$imagem = $_FILES;

		$idtemporario = $dados['idproduto'];

		if(!isset($dados['destaque'])){
			$dados['destaque'] = 0;	
		} 

		$caminho = "files/produto/";
		if (!file_exists($caminho)) {
			mkdir($caminho, 0777);
		}

		$Arquivo = explode(".", $_FILES['arquivo']['name']);
		$ext = $Arquivo[count($Arquivo) - 1];
		$NomeArquivo = $dados['nome'];
		$NomeArquivo = urlImage($NomeArquivo) . '.' . $ext;
		$dados['arquivo'] = $NomeArquivo;
		move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho . $NomeArquivo);
		 
		$idProduto = cadastroProduto($dados); 
		if (is_int($idProduto)) { 
			$dados['idproduto'] = $idProduto;

			// $cadCategoria = cadastrarProduto_categoria($dados);
			
			foreach ($dados['categorias'] as $idcategoria => $linha) {
				$dados_categoria["idproduto"] = $idProduto;
				if(isset($linha["checked"])){
					$dados_categoria["idcategoria"] = $idcategoria;
					cadastroProduto_categoria($dados_categoria);
				};
			}

			if(!is_numeric($idtemporario) && file_exists('files/produto/'.$idtemporario.'/')){
				rename('files/produto/'.$idtemporario, 'files/produto/'.$idProduto);
			} 
			  
			$imagens = $dados['imagem_produto']; 
			if(!empty($imagens)){
				$descricao = $dados['descricao_imagem'];
				$posicao = $dados['posicao_imagem']; 
				foreach($imagens as $k=>$v){
					$imagem['idproduto'] = $idProduto;
					$imagem['descricao_imagem'] = $descricao[$k];
					$imagem['posicao_imagem'] = $posicao[$k];
					$imagem['nome_imagem'] = $v; 
					salvaImagemProduto($imagem);					
				} 
			} 
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'produto';
			$log['descricao'] = 'Cadastrou produto ID('.$idProduto.') nome ('.$dados['nome'].') codigo ('.$dados['codigo'].') urlrewrite ('.$dados['urlrewrite'].') destaque ('.$dados['destaque'].') imagem ('.$dados['imagem'].') informacoes ('.$dados['informacoes'].') resumo_tecnico ('.$dados['resumo_tecnico'].') descricao ('.$dados['descricao'].') title ('.$dados['title'].') description ('.$dados['description'].') keywords ('.$dados['keywords'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('Produto criado com sucesso!'));
		} else {
			header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('ERRO ao criar novo Produto!'));
		} 
	break;

	case EDIT_PRODUTO:
		include_once 'produto_class.php';
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php'; 

		$dados = $_REQUEST;
		$antigo = buscaProduto(array('idproduto'=>$dados['idproduto']));
		$antigo = $antigo[0]; 
		$imagem = $_FILES;


		$caminho = "files/produto/";
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

		$idProduto = editProduto($dados); 
		if ($idProduto != FALSE) { 
			// $cadCategoria = cadastrarProduto_categoria($dados); 

			deletaProduto_categoria($idProduto);
			
			foreach ($dados['categorias'] as $idcategoria => $linha) {
				$dados_categoria["idproduto"] = $idProduto;
				if(isset($linha["checked"])){
					$dados_categoria["idcategoria"] = $idcategoria;
					cadastroProduto_categoria($dados_categoria);
				};
			} 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'produto';
			$log['descricao'] = 'Editou produto ID('.$idProduto.') DE  nome ('.$antigo['nome'].') codigo ('.$antigo['codigo'].') urlrewrite ('.$antigo['urlrewrite'].') destaque ('.$antigo['destaque'].') imagem ('.$antigo['imagem'].') informacoes ('.$antigo['informacoes'].') resumo_tecnico ('.$antigo['resumo_tecnico'].') descricao ('.$antigo['descricao'].') title ('.$antigo['title'].') description ('.$antigo['description'].') keywords ('.$antigo['keywords'].') PARA  nome ('.$dados['nome'].') codigo ('.$dados['codigo'].') urlrewrite ('.$dados['urlrewrite'].') destaque ('.$dados['destaque'].') imagem ('.$dados['imagem'].') informacoes ('.$dados['informacoes'].') resumo_tecnico ('.$dados['resumo_tecnico'].') descricao ('.$dados['descricao'].') title ('.$dados['title'].') description ('.$dados['description'].') keywords ('.$dados['keywords'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('Produto salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('ERRO ao salvar Produto!'));
		} 
	break;

	case DELETA_PRODUTO:
		include_once 'produto_class.php';
		include_once 'usuario_class.php'; 
		if (!verificaPermissaoAcesso('produto_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaProduto(array('idproduto'=>$dados['idu']));
 			if (deletaProduto($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'produto';
				$log['descricao'] = 'Deletou produto ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('Produto deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=produto&acao=listarProduto&mensagemalerta='.urlencode('ERRO ao deletar Produto!'));
			}
		} 
	break;

	case DELETA_CADASTRO_TEMPORARIO: 
		include_once('produto_class.php');
		$dados = $_POST; 
 		if(!is_numeric($dados['idtemporario'])){
			apagarPastaImagemProduto($dados['idtemporario']);  
		} 
		print '{"status":true}';
	break; 

	 ////IMAGENS 
	//SALVA IMAGEM DO BANNER_CINEMA FULL OU MOBILE
    case SALVA_IMAGEM_PRODUTO:
        include_once('produto_class.php'); 
				require_once 'includes/fileImage.php'; 

				$dados = $_POST; 
		
        $idproduto = $dados['idproduto'];  

        $imagem = $_FILES;
				
        if(empty($idproduto)){
           $idproduto = md5(uniqid(rand(), true));
        } 

        $caminho = 'produto/'.$idproduto;

        $filename =  md5($idproduto.uniqid(rand(), true)).".".getExt($imagem['imagem']['tmp_name']);
       	
        //original, galeria grande - zoom
        $image = fileImage($caminho, $filename, "", $imagem['imagem'], 800, 800, 'resize'); 
       
       	//home destaque, listagem, veja mais interna - ok
        $thumb = fileImage($caminho, $filename, "thumb", $imagem['imagem'],180, 150, 'inside'); 
        
        //home - dos produts
        $thumb2 = fileImage($caminho, $filename, "thumb2", $imagem['imagem'], 235, 85, 'inside'); 
       
        //thumb - produto interna - pequenas 
        $thumb3 = fileImage($caminho, $filename, "thumb3", $imagem['imagem'], 138, 134, 'crop'); 
        
        //imagem produto - interna
        $thumb4 = fileImage($caminho, $filename, "thumb4", $imagem['imagem'], 600, 430, 'inside'); 

        
        $caminho = 'files/'.$caminho; 
        
        if(file_exists($caminho.'/'.$image)){ 

        		//apaga os arquivos anteriores que foram salvos
						$sizes =  array(
							"", "thumb_", "thumb2_", "thumb3_", "thumb4_", 
						);

						if(is_numeric($idproduto)){
							//edita o nome do produto, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
							$produto = buscaProduto(array("idproduto"=>$idproduto));
							if(!empty($produto)){
								$produto = $produto[0];
								$produto['imagem'] = $image;
								$edita = editProduto($produto);
							}
						} 
            echo '{"status":true, "caminho":"'.$caminho.'/'.$image.'", "idproduto":"'.$idproduto.'", "nome_arquivo":"'.$image.'"}'; 
        }else{
            echo '{"status":false, "idproduto":"'.$idproduto.'", "msg":"erro ao salvar a imagem. Tente novamente"}'; 
        }
        
    break;   


    case VERIFICAR_URLREWRITE:

		include_once('produto_class.php');
		include_once('categoria_class.php');
		include_once('includes/functions.php');
		
		$dados = $_POST;	
		$urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
 		
 		if($dados['idproduto'] && $dados['idproduto'] <= 0){
 			$url = buscaProduto(array("urlrewrite"=>$urlrewrite)); 	
 		}else{ 
 			$url = buscaProduto(array("urlrewrite"=>$urlrewrite,"not_idproduto"=>$dados['idproduto'])); 
 		} 

 		if(empty($url)){ 
 			$url = buscaCategoria(array("urlrewrite"=>$urlrewrite));
 			if(empty($url)){
 				print '{"status":true,"url":"'.$urlrewrite.'"}';
 			}else{
 				print '{"status":false}';
 			}  
 		}else{
 			print '{"status":false}';
 		} 

	break;  


	case LISTAR_PRODUTO:
        
		include_once 'produto_class.php'; 
        
        $dados = $_REQUEST;

        $retorno = array(); 
        $produto = buscaProduto($dados);

        if(!isset($dados['filtro'])){
	        $retorno['dados'] = $produto;
	        $dados['totalRecords'] = true;  
	        $total = buscaProduto($dados); 
	        $retorno['total'] = 0;   
	        if(count($total) > 0 && isset($dados['limit'])){ 
	            $paginas = ceil($total[0]['totalRecords'] / $dados['limit']);
	            $retorno['totalPaginas'] = $paginas;
	        } 
    	}else{
            $retorno['dados'] = $produto;
        }
        print json_encode($retorno);
	break;


	/***************************************************/


    //SALVA IMAGENS DA PRODUTO 
    case SALVA_GALERIA:
            
        include_once('produto_class.php');

		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';
            
		$dados = $_POST; 

        $idproduto = $dados['idproduto'];
        $posicao = $dados['posicao'];

        $files = $_FILES; 

        $imagem = $_FILES;

        // var_export( $imagem['imagem']['tmp_name']);
        // die();
        if(empty($idproduto)){
            $idproduto = md5(uniqid(rand(), true));
        }

        $caminhopasta = "produto/".$idproduto."/galeria";

        $filename =  md5($idproduto.uniqid(rand(), true)).".".getExt($imagem['imagem']['tmp_name']);

        //original
        $image = fileImage($caminhopasta, $filename, '', $imagem['imagem'], 800, 800, 'resize'); 
       
        // //thumb - produto interna 
        $thumb2 = fileImage($caminhopasta, $filename, "thumb", $imagem['imagem'], 138, 134, 'crop'); 
        
        // //imagem produto - interna
        $thumb3 = fileImage($caminhopasta, $filename, "thumb2", $imagem['imagem'], 600, 430, 'inside'); 
       
       	
       	
        $caminho = "files/".$caminhopasta.'/'.$image;

        //vai cadastrar se já tiver o id do produto, senao so fica na pasta.
        $idproduto_imagem = $image; 

        if(is_numeric($idproduto)){ 
        	//CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO PRODUTO
			$imagem['idproduto'] = $idproduto;
			$imagem['descricao_imagem'] = "";
			$imagem['posicao_imagem'] = $posicao;
			$imagem['nome_imagem'] = $image; 
			$idproduto_imagem = salvaImagemProduto($imagem);	
        } 
       
        print '{"status":true, "caminho":"'.$caminho.'", "idproduto":"'.$idproduto.'", "idproduto_imagem":"'.$idproduto_imagem.'", "nome_arquivo":"'.$image.'"}'; 
          
    break; 
 
    case SALVAR_DESCRICAO_IMAGEM:
		include_once('produto_class.php');
		$dados = $_POST;

		$imagem = buscaProduto_imagem(array("idproduto_imagem"=>$dados['idImagem']));
		$imagem = $imagem[0];
		if($imagem){
			$imagem['descricao_imagem'] = $dados['descricao'];
			if(editProduto_imagem($imagem)){
				print '{"status":true}';
			}else{
				print '{"status":false}';
			}
		}else{
			print '{"status":false}';
		}
		
	break; 

	//EXCLUI A IMAGEM DA PRODUTO SELECIONADA
	case EXCLUIR_IMAGEM_GALERIA:
				
		include_once('produto_class.php');
		$dados = $_POST;   
		$idproduto = $dados['idproduto'];
		$idproduto_imagem = $dados['idproduto_imagem'];
		$imagem = $dados['imagem'];

		$retorno['status'] = true;

		if(is_numeric($idproduto)){ 
			//ESTA EDITANDO OS DADOS, APAGAR IMAGEM DA PASTA E DO BANCO REORDENANDO A POSICAO
			$retorno['status'] = apagarImagemProduto($idproduto, $imagem, $idproduto_imagem);			
		}else{ 
			//ESTA CADASTRANDO - APAGAR IMAGEM SO DA PASTA
			$retorno['status'] = apagarImagemProduto($idproduto, $imagem,''); 
		} 

		print json_encode($retorno);

	break; 

	//ALTERAR POSICAO DA IMAGEM
	case ALTERAR_POSICAO_IMAGEM:
				
		include_once('produto_class.php');
		$dados = $_POST;  
		alterarPosicaoImagemProduto($dados);
		print '{"status":true}';

	break;

	//EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
	case EXCLUIR_IMAGENS_TEMPORARIAS:
				
		include_once('produto_class.php');
		$dados = $_POST;	 

	 	apagarPastaImagemProduto($dados['idproduto']);
		print '{"status":true}';

	break; 

	case INVERTE_STATUS:
		include_once("produto_class.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';
		include_once("includes/functions.php");
		$tabela = 'produto';
		$id = 'idproduto';

		try {
			 $produto = buscaProduto(array('idproduto' => $dados['idproduto']));
			 $produto = $produto[0];

			 // print_r($produto);
			 if($produto['status'] == 'A'){
					$status = 'I';
			 }
			 else{
					$status = 'A';
			 }

			 $dadosUpdate = array();
			 $dadosUpdate['idproduto'] = $dados['idproduto'];
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
			header('Location: index.php?mod=home&mensagemalerta='.urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}

}
?>