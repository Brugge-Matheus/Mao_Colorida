<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva categoria no banco</p>
	 */
	function cadastroCategoria($dados)
	{
		include "includes/mysql.php";  
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}
		$sql = "INSERT INTO categoria( nome, urlrewrite, seotitle, resumo, imagem, status, cor, destaque,idlinhas) VALUES (
						'".$dados['nome']."',
						'".removeUrlProduto($dados['urlrewrite'])."',
						'".$dados['seotitle']."',
						'".$dados['resumo']."',
						'".$dados['imagem']."',
						'".$dados['status']."',
						'".$dados['cor']."',
						'".$dados['destaque']."',
						'".$dados['idlinhas']."'
					)";
 
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita categoria no banco</p>
	 */
	function editCategoria($dados)
	{
		include "includes/mysql.php"; 

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE categoria SET
						nome = '".$dados['nome']."',
						urlrewrite = '".removeUrlProduto($dados['urlrewrite'])."',
						seotitle = '".$dados['seotitle']."',
						resumo = '".$dados['resumo']."',
						imagem = '".$dados['imagem']."',
						status = '".$dados['status']."',
						cor = '".$dados['cor']."',
						destaque = '".$dados['destaque']."',
						idlinhas = '".$dados['idlinhas']."'
					WHERE idcategoria = " . $dados['idcategoria'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idcategoria'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca categoria no banco</p>
	 */
	function buscaCategoria($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idcategoria',$dados) && !empty($dados['idcategoria']) )
			$buscaId = ' and C.idcategoria = '.intval($dados['idcategoria']).' '; 

		//busca pelo id
		$buscaIdIn = '';
		if (array_key_exists('idcategoria_in',$dados) && !empty($dados['idcategoria_in']) )
			$buscaIdIn = ' and C.idcategoria in ('.$dados['idcategoria_in'].')'; 


		//busca pelo id
		$buscaIdNot = '';
		if (array_key_exists('not_idcategoria',$dados) && !empty($dados['not_idcategoria']) )
			$buscaIdNot = ' and C.idcategoria != '.intval($dados['not_idcategoria']).' '; 
 	

		// //busca pelo tipocategoria
		// $buscaTipoCategoria = '';
		// if (array_key_exists('tipocategoria',$dados) && !empty($dados['tipocategoria']) )
		// 	$buscaTipoCategoria = ' and C.tipocategoria = '.intval($dados['tipocategoria']).' '; 


		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" '; 


		//busca pelo urlrewrite
		$buscaUrlrewrite = '';
		if (array_key_exists('urlrewrite',$dados) && !empty($dados['urlrewrite']) )
			$buscaUrlrewrite = ' and C.urlrewrite = "'.$dados['urlrewrite'].'" '; 

		//busca pelo destaque
		$buscaDestaque = '';
		if (array_key_exists('destaque',$dados) && (!empty($dados['destaque']) || is_numeric($dados['destaque'])))
			$buscaDestaque = ' and C.destaque = '.$dados['destaque'].' '; 

		//busca pelo seotitle
		$buscaSeotitle = '';
		if (array_key_exists('seotitle',$dados) && !empty($dados['seotitle']) )
			$buscaSeotitle = ' and C.seotitle LIKE "%'.$dados['seotitle'].'%" '; 


		//busca pelo seodescription
		$buscaResumo = '';
		if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
			$buscaResumo = ' and C.resumo LIKE "%'.$dados['resumo'].'%" '; 


		//busca pelo resumo
		$buscaResumo = '';
		if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
			$buscaResumo = ' and C.resumo LIKE "%'.$dados['resumo'].'%" '; 


		// //busca pelo idcategoria_pai
		// $buscaIdCategoria_pai = '';
		// if (array_key_exists('idcategoria_pai',$dados) && !empty($dados['idcategoria_pai']) )
		// 	$buscaIdCategoria_pai = ' and C.idcategoria_pai = "'.$dados['idcategoria_pai'].'" '; 

  	// 	//busca pelo not_idsubcategorais
		// $buscaIdNot_Sub = '';
		// if (array_key_exists('idcategoria_pai',$dados) && array_key_exists('not_idsubcategoria',$dados) && !empty($dados['not_idsubcategoria']) ){
		// 	$buscaIdNot_Sub = ' and C.idcategoria not in ('.$dados['not_idsubcategoria'].')';  
		// }


		//busca pelo status
		$buscaStatus = '';
		if (array_key_exists('status',$dados) && !empty($dados['status']) )
			$buscaStatus = ' and C.status = "'.$dados['status'].'" ';


		// //busca pela pesquisa
		// $buscaPesquisar = '';
		// if (array_key_exists('pesquisar',$dados) && !empty($dados['pesquisar']) )
		// 	$buscaPesquisar = ' and (P.nome LIKE "%'.$dados['pesquisar'].'%" || P.codigo LIKE "%'.$dados['pesquisar'].'%")'; 	


		// //busca categoria com produtos cadastrados
		// $buscaCategoriaProduto = '';
		// if (array_key_exists('relcategoria_produto',$dados)){  
		// 	$buscaCategoriaProduto	 = 'AND idcategoria in (
		// 							 	SELECT if(CT.idcategoria_pai = 0, CT.idcategoria, CT.idcategoria_pai)
		// 								FROM produto_categoria as PC 
		// 								INNER JOIN produto as P on P.idproduto = PC.idproduto
		// 								INNER JOIN categoria as CT on PC.idcategoria = CT.idcategoria
		// 								WHERE (C.idcategoria = CT.idcategoria_pai || C.idcategoria = CT.idcategoria) and P.`status` = "A"
		// 								'.$buscaPesquisar.'
		// 								GROUP BY CT.idcategoria_pai )';
		// }

		// //busca subcategoria com produtos cadastrados
		// $buscaSubCategoriaProduto = '';
		// if (array_key_exists('relsubcategoria_produto',$dados)){
		// 	 $buscaCategoriaProduto	 = 'AND idcategoria in (
		// 							 	SELECT CT.idcategoria
		// 								FROM produto_categoria as PC 
		// 								INNER JOIN produto as P on P.idproduto = PC.idproduto
		// 								INNER JOIN categoria as CT on PC.idcategoria = CT.idcategoria
		// 								WHERE C.idcategoria = CT.idcategoria and P.`status` = "A"
		// 								'.$buscaPesquisar.'
		// 								GROUP BY CT.idcategoria)';
		// }

				//busca pelo idlinhas
				$buscaIdlinhas = '';
				if (array_key_exists('idlinhas',$dados) && !empty($dados['idlinhas']) )
					$buscaIdlinhas = ' and C.idlinhas = '.intval($dados['idlinhas']).' '; 

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
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('inicio',$dados)){
            $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['inicio'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
            $buscaLimit = ' LIMIT '.$dados['limit'];
        }

		//colunas que serão buscadas
		$colsSql = 'C.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(C.idcategoria) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM categoria as C WHERE 1
				$buscaIdIn $buscaId $buscaIdNot
				$buscaNome $buscaUrlrewrite $buscaDestaque $buscaSeotitle  
				$buscaResumo  $buscaResumo  
				$buscaStatus $buscaIdlinhas $orderBy $buscaLimit "; 

		 if(!mysqli_query($conexao, $sql)){
		 	//print $sql;die;
		 }
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){   
                $r["status_nome"] = ($r["status"]=='A' ? "Ativo":"Inativo");
                $r["status_icone"] = ($r["status"]=='A' ? "<img src='images/estrelasim.png' width='20px' />":"<img src='images/estrelanao.png' width='20px'/>");

                $r["destaque_home"] = (($r["destaque"]) ? "<img src='images/logado.png' width='20px' />":"<img src='images/naologado.png' width='20px'/>");

                $r['_cor'] = "#".$r['cor']; 
                $r['cor_'] = "";
 			}
			$resultado[] = $r;
		} 
		return $resultado; 
 	}

	/**
	 * <p>deleta categoria no banco</p>
	 */
	function deletaCategoria($dados)
	{
		include "includes/mysql.php"; 
 		
 		if(!empty($dados)){
			$sql = "DELETE FROM categoria WHERE idcategoria = $dados";
			if (mysqli_query($conexao, $sql)) {
				$num = mysqli_affected_rows($conexao);
				$imagens = apagarPastaImagemCategoria($dados);
				
				$sql = "UPDATE categoria set idcategoria_pai = 0 WHERE idcategoria_pai = $dados";
				mysqli_query($conexao, $sql);

				$sql = "DELETE FROM produto_categoria WHERE idcategoria = $dados";
				mysqli_query($conexao, $sql);

				return $num;
			} else {
				return FALSE;
			}
		}	
	}


	function apagarPastaImagemCategoria($id){ 
		 
        if(!empty($id) && file_exists('files/categoria/'.$id."/")){ 
        	//apaga os arquivos que foram salvos
			$pastas =  array(); 
			$pastas[] = 'thumb';  

			foreach ($pastas as $pasta) {
                $caminho = 'files/categoria/'.$id.'/'.$pasta.'/'; 
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

            $scan = scandir('files/categoria/'.$id.'/');
            if(count($scan) <= 2) {
                chmod('files/categoria/'.$id.'/', 0777);
                rmdir('files/categoria/'.$id.'/'); 
            } 
        }
        return true;		
    } 

    function removeUrlProduto($url){
	 	$end = ENDERECO;
	 	$url = str_replace($end, "", $url);
	 	return $url;
	}



?>