<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva produto no banco</p>
	 */
	function cadastroProduto($dados)
	{
		include "includes/mysql.php";
		include_once "includes/functions.php"; 

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['urlrewrite'] = converteUrl(str_replace("-", " ", $dados['urlrewrite']));
		$sql = "INSERT INTO produto(nome, codigo, urlrewrite, resumo, imagem, informacoes, arquivo, numero_whatsapp, status, idmarcas, nome_arquivo, resumo_arquivo, idlinhas, idsegmento) VALUES (
						'".$dados['nome']."',
						'".$dados['codigo']."',
						'".$dados['urlrewrite']."',
						'".$dados['resumo']."',
						'".$dados['imagem']."',
						'".$dados['informacoes']."',
						'".$dados['arquivo']."',
						'".$dados['numero_whatsapp']."',
						'".$dados['status']."',
						'".$dados['idmarcas']."',
						'".$dados['nome_arquivo']."',
						'".$dados['resumo_arquivo']."',
						'".$dados['idlinhas']."',
						'".$dados['idsegmento']."'
						)";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita produto no banco</p>
	 */
	function editProduto($dados)
	{
		include "includes/mysql.php"; 
		include_once "includes/functions.php"; 
	 
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}  

		$dados['urlrewrite'] = converteUrl(str_replace("-", " ", $dados['urlrewrite']));

		$sql = "UPDATE produto SET
						nome = '".$dados['nome']."',
						codigo = '".$dados['codigo']."',
						urlrewrite = '".$dados['urlrewrite']."',
						resumo = '".$dados['resumo']."',
						imagem = '".$dados['imagem']."',
						informacoes = '".$dados['informacoes']."',
						arquivo = '".$dados['arquivo']."',
						numero_whatsapp = '".$dados['numero_whatsapp']."',
						status = '".$dados['status']."',
						idmarcas = '".$dados['idmarcas']."',
						nome_arquivo = '".$dados['nome_arquivo']."',
						resumo_arquivo = '".$dados['resumo_arquivo']."',
						idlinhas = '".$dados['idlinhas']."',
						idsegmento = '".$dados['idsegmento']."'
					WHERE idproduto = " . $dados['idproduto'];
		if (mysqli_query($conexao, $sql)) {
			return $dados['idproduto'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca produto no banco</p>
	 */
	function buscaProduto($dados = array())
	{
		include "includes/mysql.php";
		include_once "includes/functions.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idproduto',$dados) && !empty($dados['idproduto']) )
			$buscaId = ' and P.idproduto = '.intval($dados['idproduto']).' '; 


		//busca pelo not_idproduto
		$buscaNotId = '';
		if (array_key_exists('not_idproduto',$dados) && !empty($dados['not_idproduto']) )
			$buscaNotId = ' and P.idproduto != '.intval($dados['not_idproduto']).' ';

		//busca pelo not_inproduto
		$buscaNotInProdutos = '';
		if (array_key_exists('not_inproduto',$dados) && !empty($dados['not_inproduto']) )
			$buscaNotInProdutos = ' and P.idproduto not in ('.$dados['not_inproduto'].')';


	 	//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and P.nome LIKE "%'.$dados['nome'].'%" '; 

			//busca pelo status
		$buscaStatus = '';
		if (array_key_exists('status',$dados) && !empty($dados['status']) )
			$buscaStatus = ' and P.status = "'.$dados['status'].'" ';


		//busca pelo codigo
		$buscaCodigo = '';
		if (array_key_exists('codigo',$dados) && !empty($dados['codigo']) )
			$buscaCodigo = ' and P.codigo LIKE "%'.$dados['codigo'].'%" '; 


		//busca pelo urlrewrite
		$buscaUrlrewrite = '';
		if (array_key_exists('urlrewrite',$dados) && !empty($dados['urlrewrite']) )
			$buscaUrlrewrite = ' and P.urlrewrite = "'.$dados['urlrewrite'].'" '; 


		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and P.imagem LIKE "%'.$dados['imagem'].'%" '; 


		//busca pelo informacoes
		$buscaInformacoes = '';
		if (array_key_exists('informacoes',$dados) && !empty($dados['informacoes']) )
			$buscaInformacoes = ' and P.informacoes LIKE "%'.$dados['informacoes'].'%" '; 

		//busca pelo id
		$buscaIdsegmento = '';
		if (array_key_exists('idsegmento',$dados) && !empty($dados['idsegmento']) )
			$buscaIdsegmento = ' and P.idsegmento = '.intval($dados['idsegmento']).' '; 

		//busca pelo group by
		$group_by = "";
		if (array_key_exists('group_by',$dados) && !empty($dados['group_by']) )
			$group_by = ' GROUP BY '.$dados['group_by'];


		$innerCategoria = "";
		$camposCategoria = "";
		$status_categoria = "";
		$buscaCategoria = ""; 
		

		if (array_key_exists('inner_categoria',$dados) 
			|| (isset($dados['idcategoria']) && !empty($dados['idcategoria'])) 
			|| (isset($dados['not_idcategoria']) && !empty($dados['not_idcategoria'])) 
			||(isset($dados['status_categoria']) && !empty($dados['status_categoria'])))
		{
			$innerCategoria = "INNER JOIN produto_categoria as PC on P.idproduto = PC.idproduto
							   INNER JOIN categoria as C on PC.idcategoria = C.idcategoria";

			$camposCategoria = ", PC.idproduto_categoria, C.idcategoria, C.idcategoria_pai, C.nome as nome_categoria, C.urlrewrite as urlcategoria,  concat('#', if(C.idcategoria_pai = 0, C.cor, (select cor from categoria as Cat where Cat.idcategoria = C.idcategoria_pai))) as _cor ";				   
			
			if (array_key_exists('status_categoria',$dados) && !empty($dados['status_categoria']) ){
				$status_categoria = " and C.status = '".$dados['status_categoria']."' ";
			}

			if (array_key_exists('idcategoria',$dados) && !empty($dados['idcategoria']) ){
				$buscaCategoria = " and (CP.idcategoria = '".$dados['idcategoria']."' OR PC.idcategoria = '".$dados['idcategoria']."') ";
			}

			if (array_key_exists('not_idcategoria',$dados) && !empty($dados['not_idcategoria']) ){
				$innerCategoria .= " and PC.idcategoria != '".$dados['not_idcategoria']."' and P.idproduto not in( select idproduto from produto_categoria where idcategoria = ".$dados['not_idcategoria'].")";
			 }

			if (array_key_exists('groupby_produto',$dados) && !empty($dados['groupby_produto']) ){
					$group_by = "group by idproduto"; 
			}	
		}

		//busca pela pesquisa
		$buscaPesquisar = '';
		if (array_key_exists('search',$dados) && !empty($dados['search']) )
			$buscaPesquisar = ' and (P.nome LIKE "%'.$dados['search'].'%" || P.codigo LIKE "%'.$dados['search'].'%")'; 	

		//busca pelo idmarcas
		$buscaIdLinhas = '';
		if (array_key_exists('idlinhas',$dados) && !empty($dados['idlinhas']) )
			$buscaIdLinhas = ' and P.idlinhas = '.intval($dados['idlinhas']).' '; 

					//busca pelo idmarcas
		$buscaIdMarcas = '';
		if (array_key_exists('idmarcas',$dados) && !empty($dados['idmarcas']) )
			$buscaIdMarcas = ' and P.idmarcas = '.intval($dados['idmarcas']).' '; 


        //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem'])){
			$orderBy = ' ORDER BY '.$dados['ordem'];
			if (isset($dados['dir']) && !empty($dados['dir'])){
				$orderBy .= ' '.$dados['dir'];
	        }
        }

        //busca pelo limit
		$buscaLimit = '';
		if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados) && !empty($dados['pagina']) ) {
            $buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('inicio',$dados)){
            $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['inicio'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
            $buscaLimit = ' LIMIT '.$dados['limit'];
        }

		//colunas que serão buscadas
		$colsSql = 'P.* ';

		 
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(DISTINCT P.idproduto) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
            $group_by = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM produto as P 
				$innerCategoria
				WHERE 1  $buscaId $buscaNotId $buscaCategoria $buscaNotInProdutos $buscaNome $buscaIdMarcas 
				$buscaCodigo  $idservico  $buscaUrlrewrite $buscaImagem  
				$buscaInformacoes $buscaPesquisar 
				$buscaStatus $status_categoria
				$group_by $buscaIdLinhas $buscaIdsegmento $orderBy $buscaLimit";

		// echo $sql;
		// exit;

		$query = mysqli_query($conexao, $sql);

		if (!$query) {
			die("Erro na consulta: " . mysqli_error($conexao));
	}
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r); 
			if (!array_key_exists('totalRecords',$dados)){   	
								$r["status_nome"] = ($r["status"] == 'A' ? "Ativo" : "Inativo");
								$r["status_icone"] = "<img src='images/estrela" . ($r["status"] == 'A' ? "sim" : "nao") . ".png' class='icone inverteStatus' codigo='" . $r['idproduto'] . "' width='20px' />";
                $r['caminhoimg'] = 'admin/files/produto/'.$r['idproduto']."/";
                
                $r['original'] = $r['caminhoimg']."original/".$r['imagem'];
                $r['thumb'] = $r['caminhoimg']."thumb_".$r['imagem'];
                $r['thumb2'] = $r['caminhoimg']."thumb2_".$r['imagem'];
                $r['thumb3'] = $r['caminhoimg']."thumb3_".$r['imagem'];
                $r['thumb4'] = $r['caminhoimg']."thumb4_".$r['imagem'];
            }
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	 
	/**
	 * <p>deleta produto no banco</p>
	 */
	function deletaProduto($dados)
	{
		include "includes/mysql.php"; 
		if(!empty($dados)){ 
			$sql = "DELETE FROM produto WHERE idproduto = $dados";
			if (mysqli_query($conexao, $sql)) {
				$num = mysqli_affected_rows($conexao);
				
				$sql = "DELETE FROM produto_categoria WHERE idproduto = $dados";
				mysqli_query($conexao, $sql);
				
				$sql = "DELETE FROM produto_imagem WHERE idproduto = $dados";
				mysqli_query($conexao, $sql);

				$sql = "DELETE FROM arquivo WHERE idproduto = $dados";
				mysqli_query($conexao, $sql);
				
				$imagens = apagarPastaImagemProduto($dados);
				return $num;
			} else {
				return FALSE;
			}
		}
	}


	function apagarPastaImagemProduto($id){ 
		 
        if(!empty($id) && file_exists('files/produto/'.$id."/")){ 
        	//apaga os arquivos que foram salvos
			$pastas =  array(); 
			$pastas[] = 'thumb';  
			$pastas[] = 'thumb2'; 
			$pastas[] = 'thumb3'; 
			$pastas[] = 'thumb4';   
			$pastas[] = 'galeria/thumb'; 
			$pastas[] = 'galeria/thumb2';
			$pastas[] = 'galeria/thumb3';
			$pastas[] = 'galeria';

			foreach ($pastas as $pasta) {
                $caminho = 'files/produto/'.$id.'/'.$pasta.'/'; 
				if(file_exists($caminho)){
					//APAGAR IMG ANTERIOR
					$path = $caminho;
					$diretorio = dir($path); 	 
					while($arquivo = $diretorio -> read()){	 
						if($arquivo != "." && $arquivo != ".."){				
							if(file_exists($path.$arquivo)){  
								unlink($path.$arquivo);
							}				
						}
					}  

                    $scan = scandir($caminho);
                    if(count($scan) <= 2) {
                        chmod($caminho, 0777);
                        rmdir($caminho); 
                    }  
				} 
			}

            $scan = scandir('files/produto/'.$id.'/');
            if(count($scan) <= 2) {
                chmod('files/produto/'.$id.'/', 0777);
                rmdir('files/produto/'.$id.'/'); 
            } 
        }
        return true;		
    } 



/////////////PRODUTO CATEGORIA//////////////////////////	

function cadastrarProduto_categoria($dados){

	include "includes/mysql.php"; 

	$idproduto = $dados['idproduto']; 
	$idcategoria = $dados['idcategoria']; 
	$idsubcategoria = $dados['idsubcategoria']; 
	$idproduto_categoria = $dados['idproduto_categoria'];
	$delete = $dados['remover']; 

	foreach($idproduto_categoria as $k => $v){ 

		$idsub = $idsubcategoria[$k];
		$deletar = $delete[$k];

		if(empty($idsub)){
			$idsub = $idcategoria[$k];
		}

		if($v == 0){
			//insert
			$sql = "INSERT INTO produto_categoria(idproduto, idcategoria) 
					VALUES(".$idproduto.",'".$idsub."')";			
		}else{
			if($deletar < 0){
				//delete
				$sql = "DELETE FROM produto_categoria WHERE idproduto_categoria = ".$v;
			}else{  
				//update
				$sql = "UPDATE produto_categoria SET 
							idcategoria = '".$idsub."'  
						WHERE idproduto_categoria = ".$v;
			}			
		}  
		 $query = mysqli_query($conexao, $sql);
	}  
	 
}  
 


//////////////////////////////////////////////////////

	/**
	 * <p>busca produto_imagem no banco</p>
	 */
	function buscaProduto_imagem($dados = array())
	{
		include "includes/mysql.php";
 
		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		} 
	 

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idproduto_imagem',$dados) && !empty($dados['idproduto_imagem']) )
			$buscaId = ' and idproduto_imagem = '.intval($dados['idproduto_imagem']).' '; 

		//busca pelo idproduto
		$buscaIdproduto = '';
		if (array_key_exists('idproduto',$dados) && !empty($dados['idproduto']) )
			$buscaIdproduto = ' and idproduto = "'.$dados['idproduto'].'" '; 


		//busca pelo descricao_imagem
		$buscaDescricao_imagem = '';
		if (array_key_exists('descricao_imagem',$dados) && !empty($dados['descricao_imagem']) )
			$buscaDescricao_imagem = ' and descricao_imagem LIKE "%'.$dados['descricao_imagem'].'%" '; 


		//busca pelo urlrewrite_imagem
		$buscaUrlrewrite_imagem = '';
		if (array_key_exists('urlrewrite_imagem',$dados) && !empty($dados['urlrewrite_imagem']) )
			$buscaUrlrewrite_imagem = ' and urlrewrite_imagem LIKE "%'.$dados['urlrewrite_imagem'].'%" '; 


		//busca pelo m2y_imagem
		$buscaM2y_imagem = '';
		if (array_key_exists('m2y_imagem',$dados) && !empty($dados['m2y_imagem']) )
			$buscaM2y_imagem = ' and m2y_imagem LIKE "%'.$dados['m2y_imagem'].'%" ';


		//busca pela posicao_imagem
		$buscaPosicao_imagem = '';
		if (array_key_exists('posicao_imagem',$dados) && !empty($dados['posicao_imagem']) )
			$buscaM2y_imagem = ' and posicao_imagem = '.$dados['posicao_imagem'].' '; 


	    //ordem
	    $orderBy = "";                   
	    if (isset($dados['ordem']) && !empty($dados['ordem'])){ 
			$orderBy = ' ORDER BY '.$dados['ordem'];
			if (isset($dados['dir']) && !empty($dados['dir'])){ 
				$orderBy .= ' '.$dados['dir'];
			}
		} 
	    
	    //busca pelo limit
		$buscaLimit = '';
		if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados)) { 
	        $buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';  
	    } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('data_hora',$dados)){
	        $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['data_hora'].' ';
	    } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
	        $buscaLimit = ' LIMIT '.$dados['limit'];
	    } 
	            
		//colunas que serão buscadas
		$colsSql = '*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idproduto_imagem) as totalRecords'; 
	        $buscaLimit = '';
	        $orderBy = '';
	    } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}  

		$sql = "SELECT $colsSql FROM produto_imagem 
				WHERE 1  $buscaId  $buscaIdproduto  
				$buscaDescricao_imagem  $buscaUrlrewrite_imagem 
				$buscaPosicao_imagem  $buscaM2y_imagem  $orderBy $buscaLimit ";
  
		include_once('includes/functions.php');

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			if(isset($dados['url'])){
				$r['descricao_imagem_url']= converteUrl($r['descricao_imagem']); 
			} 

			if(isset($dados['tamanho'])){
				$tamanhoImagem = getimagesize('files/produto/'.$r['idproduto'].'/galeria/thumbnail/'.$r['nome_imagem']);
			    $r['w'] = $tamanhoImagem[0];
			    $r['h']= $tamanhoImagem[1]; 
			}    
			 
			$r = array_map('utf8_encode', $r); 
			$resultado[] = $r;
		}
		
		return $resultado; 
	}


	function cadastroProduto_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}
		$sql = "INSERT INTO produto_imagem( idproduto, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem, m2y_imagem,is_default) VALUES (
					'".$dados['idproduto']."',
					'".$dados['nome_imagem']."',
					'".$dados['descricao_imagem']."',
					'".$dados['urlrewrite_imagem']."',
					'".$dados['posicao_imagem']."', 
					'".$dados['m2y_imagem']."',
					'".$dados['is_default']."')"; 

		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita produto_imagem no banco</p>
	 */
	function editProduto_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v); 
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE produto_imagem SET
						idproduto = '".$dados['idproduto']."',
						descricao_imagem = '".$dados['descricao_imagem']."',
						urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
						posicao_imagem = '".$dados['posicao_imagem']."',
						is_default = '".$dados['is_default']."',
						nome_imagem = '".$dados['nome_imagem']."',
						m2y_imagem = '".$dados['m2y_imagem']."'
					WHERE idproduto_imagem = " . $dados['idproduto_imagem'];
  
		if (mysqli_query($conexao, $sql)) {
			return $dados['idproduto_imagem'];
		} else {
			return false;
		}
	}


	function salvaImagemProduto($dados){   

		include_once "includes/functions.php"; 
		$dadosGravar = array(); 

		$idproduto = $dados['idproduto'];
		//urlrewrite
		$nomeimagem = explode('.', $dados['nome_imagem']);
		$nomeimagem = $nomeimagem[0];
		$dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);	
		//atribuir m2y 
		$urlamigavel = 'admin/files/produto/'.$idproduto.'/galeria/'.$dados['nome_imagem'];
	 
		$dados['m2y_imagem'] = ''; 
		$shorturl = ENDERECO.$urlamigavel;
		$authkey = "3H34kAfJ36c7VUR3oCqBR15R33P554V6";
		
		$returns = file_get_contents("http://www.m2y.me/webservice/create/?url=".$shorturl."&authkey=".$authkey);
		
		$dados['m2y_imagem'] = $returns;

		if($dados['posicao_imagem'] == 1){
			$dados['is_default'] = 1;
		}else{
			$dados['is_default'] = 0;
		} 

		return cadastroProduto_imagem($dados); 
	}

	//APAGA UM IMAGEM ESPECIFICA DA GALERIA
	function apagarImagemProduto($idproduto, $imagem, $idproduto_imagem){ 

		include "includes/mysql.php"; 
        if(!empty($idproduto) && file_exists('files/produto/'.$idproduto."/galeria/".$imagem)){ 
        	
        	unlink('files/produto/'.$idproduto."/galeria/".$imagem);

        	//apaga a imagem da galeria 
			$sizes =  array(
				"thumb_", "thumb2_", "thumb3_", "thumb4_", 
			);


			foreach ($sizes as $size) {
                $caminho = 'files/produto/'.$idproduto.'/galeria/'.$size; 

				if(file_exists($caminho.$imagem)){  
					unlink($caminho.$imagem);
				} 
			}

            // $scan = scandir('files/produto/'.$idproduto.'/');
            // if(count($scan) <= 2) {
            //     chmod('files/produto/'.$idproduto.'/', 0777);
            //     rmdir('files/produto/'.$idproduto.'/'); 
            // }

            if(!empty($idproduto_imagem)){
            	//APAGAR IMAGEM DO BANCO
            	$imagem = buscaProduto_imagem(array("idproduto_imagem"=>$idproduto_imagem));
            	 
            	$posicao = $imagem[0]['posicao_imagem'];
            	$sql = 'DELETE from produto_imagem WHERE idproduto_imagem = '.$idproduto_imagem;
            	 
            	if (mysqli_query($conexao, $sql)) {
            		//update nas posicao das imagens
					$sql = 'UPDATE produto_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE idproduto = '.$idproduto.' and posicao_imagem > '.$posicao;
					if (mysqli_query($conexao, $sql)) {
						//marca a primeira posicao como default - caso apague q primeira imagem
						$sql = 'UPDATE produto_imagem SET is_default = 1 WHERE idproduto = '.$idproduto.' and posicao_imagem = 1';
						mysqli_query($conexao, $sql);
						return true;
					}
				} else {
					return false;
				}
            }else{ 
            	return true;
            }
        }
        return false;		
    }   

    function alterarPosicaoImagemProduto($dados){

    	include "includes/mysql.php"; 	

    	$imagens = $dados['idproduto_imagem'];
    	$posicao = $dados['posicao_imagem'];
    	$idproduto = $dados['idproduto'];

		if(!empty($imagens)){
			 
			foreach($imagens as $k => $v){
				$sql = 'UPDATE produto_imagem SET 
						posicao_imagem = "'.$posicao[$k].'",
						is_default = 0
						WHERE idproduto_imagem = '.$v;
				 
				mysqli_query($conexao, $sql);		
			} 

			$sql = 'UPDATE produto_imagem SET is_default = 1 WHERE idproduto = '.$idproduto.' and posicao_imagem = 1';
		  			mysqli_query($conexao, $sql);
					return true;  
		}else{ 
			return true;
		}
    }

function deletaProduto_categoria($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM produto_categoria WHERE idproduto = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function cadastroProduto_categoria($dados)
{

	include "includes/mysql.php";

	foreach ($dados AS $k => &$v) {
		if (is_array($v)) continue;
		$v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	$sql = "INSERT INTO produto_categoria(idproduto, idcategoria) VALUES (
					'".$dados['idproduto']."',
					'".$dados['idcategoria']."'
				)";
	if (mysqli_query($conexao, $sql)) {
		$resultado = mysqli_insert_id($conexao);
		return $resultado;
	} else {
		return false;
	}
}

function buscaProduto_categoria($dados = array())
{
	include "includes/mysql.php";

	foreach ($dados AS $k => &$v) {
		if (is_array($v) || $k == "colsSql") continue;
		$v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	//busca pelo id
	$buscaId = '';
	if (array_key_exists('idproduto_categoria',$dados) && !empty($dados['idproduto_categoria']) )
		$buscaId = ' and idproduto_categoria = '.intval($dados['idproduto_categoria']).' '; 

	//busca pelo idproduto
	$buscaIdProduto = '';
	if (array_key_exists('idproduto',$dados) && !empty($dados['idproduto']) )
		$buscaIdProduto = ' and idproduto = '.$dados['idproduto'].' '; 

	//busca pelo idcategoria
	$buscaIdCategoria = '';
	if (array_key_exists('idcategoria',$dados) && !empty($dados['idcategoria']) )
		$buscaIdcategoria = ' and idcategoria = '.$dados['idcategoria'].' '; 

	//busca pelo limit
	$buscaLimit = '';
	if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados)) {
		$buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';
	} elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('inicio',$dados)){
		$buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['inicio'].' ';
	} elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
		$buscaLimit = ' LIMIT '.$dados['limit'];
	}

	$orderBy = '';
	//colunas que serão buscadas
	$colsSql = '*';
	if (array_key_exists('totalRecords',$dados)){
		$colsSql = ' count(idproduto_categoria) as totalRecords';
		$buscaLimit = '';
		$orderBy = '';
	} elseif (array_key_exists('colsSql',$dados)) {
		$colsSql = ' '.$dados['colsSql'].' ';
	}

	$sql = "SELECT $colsSql FROM produto_categoria WHERE 1 $buscaId $buscaIdProduto $buscaIdCategoria $orderBy $buscaLimit ";

	$query = mysqli_query($conexao, $sql);
	$resultado = array();
	while ($r = mysqli_fetch_assoc($query)){
		$r = array_map('utf8_encode', $r);
		if (!array_key_exists('totalRecords',$dados)){

		}
		$resultado[] = $r;
	}
	return $resultado; 
}
?>
