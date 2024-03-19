<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva segmento_diferenciais no banco</p>
	 */

	function cadastroSegmento_diferenciais($dados)
	{
		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			$v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		if(empty($dados['icone'])){
			$dados['icone'] = 1;
		}

		$sql = "INSERT INTO segmento_diferenciais(idsegmento,icone,icone_name,nome, status) VALUES (
							'".$dados['idsegmento']."',
							'".$dados['icone']."',
							'".$dados['icone_name']."',
							'".$dados['nome']."',
							'".$dados['status']."'
					)";

		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita segmento_diferenciais no banco</p>
	 */
	function editSegmento_diferenciais($dados)
	{

		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			$v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE segmento_diferenciais SET
							idsegmento = '".$dados['idsegmento']."',
							icone = '".$dados['icone']."',
							icone_name = '".$dados['icone_name']."',
							nome = '".$dados['nome']."',
							status = '".$dados['status']."'
					WHERE idsegmento_diferenciais = " . $dados['idsegmento_diferenciais'];

	 	if (mysqli_query($conexao, $sql)) {
			return $dados['idsegmento_diferenciais'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca segmento_diferenciais no banco</p>
	 */

	function buscaSegmento_diferenciais($dados = array())
	{
		include "includes/mysql.php";
		include_once "includes/functions.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			$v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idsegmento_diferenciais',$dados) && !empty($dados['idsegmento_diferenciais']) )
			$buscaId = ' and C.idsegmento_diferenciais = '.intval($dados['idsegmento_diferenciais']).' '; 
		
		//busca pelo id
		$buscaIdsegmento = '';
		if (array_key_exists('idsegmento',$dados) && !empty($dados['idsegmento']) )
			$buscaIdsegmento = ' and C.idsegmento = '.intval($dados['idsegmento']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" '; 

	    //busca pelo status
	    $buscaStatus = '';
	    if (array_key_exists('status',$dados) && !empty($dados['status']) )
	        $buscaStatus = ' and C.status = "'.$dados['status'].'" '; 

         //ordem
        $orderBy = "";                   
        if (array_key_exists('ordem',$dados) && !empty($dados['ordem'])){ 
	    	$orderBy = ' ORDER BY '.$dados['ordem']; 
	    	if (array_key_exists('dir',$dados) && !empty($dados['dir'])){ 
		    	$orderBy .= " ". $dados['dir']; 
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


		$buscaMax = '';
		if(array_key_exists('max',$dados))
			$buscaMax = ', max('.$dados['max'].') as max ';

		//colunas que serão buscadas
		$colsSql = 'C.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idsegmento_diferenciais) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql $buscaMax FROM segmento_diferenciais as C 
				WHERE 1  $buscaId $buscaIdsegmento $buscaNome $buscaStatus $buscaOrdem $orderBy $buscaLimit ";
				
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;        
		$tot =  mysqli_affected_rows($conexao);

		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r); 
			if (!array_key_exists('totalRecords',$dados)){
				$r["status_nome"] = ($r["status"]=='1' ? "Ativo":"Inativo");
				$r["status_icone"] = ($r["status"]=='1' ? "<img src='images/estrelasim.png' class='icone inverteStatus' codigo='".$r['idsegmento_diferenciais']."' width='20px' />":"<img src='images/estrelanao.png' class='icone inverteStatus' codigo='".$r['idsegmento_diferenciais']."' width='20px'/>"); 				
                $iAux++;
	        }  
			$resultado[] = $r;
		}
		return $resultado;
		
 	}

	/**
	 * <p>deleta segmento_diferenciais no banco</p>
	 */
	function deletaSegmento_diferenciais($dados)
	{
		include "includes/mysql.php";

		$segmento_diferenciais = buscaSegmento_diferenciais(array("idsegmento_diferenciais"=>$dados));
		$ordem = $segmento_diferenciais[0]['ordem'];
		$imagem = $segmento_diferenciais[0]['imagem_icone']; 
		 
		$sql = "DELETE FROM segmento_diferenciais WHERE idsegmento_diferenciais = $dados";
		if (mysqli_query($conexao, $sql)) {
			$num = mysqli_affected_rows($conexao);
			$sql ="UPDATE segmento_diferenciais SET ordem = (ordem - 1) WHERE ordem > ".$ordem;
			mysqli_query($conexao, $sql);
			return $num;
		} else {
			return FALSE;
		}
	} 
 
 	function editarImagemSegmento_diferenciais($imgs) {
		$path = 'files/segmento_diferenciais/';

		$nameArquivo = array();
		$nameArquivo[] = "";
		$nameArquivo[] = "thumb_";
		$nameArquivo[] = "original_";

		if(file_exists($path)){
			if(is_array($imgs)){
				foreach ($imgs as $img) {
					foreach ($nameArquivo as $key => $_name) {
						$arquivo = $_name.$img['nome_imagem'];
						if(file_exists($path.$arquivo)){
							unlink($path.$arquivo);
						}
					}
				}
			}else{
				foreach ($nameArquivo as $key => $_name) {
					$arquivo = $_name.$imgs;
					if(file_exists($path.$arquivo)){
						unlink($path.$arquivo);
					}
				}
			}
    	}
		return true;
	}

    function editOrdemSegmento_diferenciais($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE segmento_diferenciais SET					
						ordem = '".$dados['ordem']."'						
					WHERE idsegmento_diferenciais = " . $dados['idsegmento_diferenciais'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idsegmento_diferenciais'];
	    } else {
	        return false;
	    }
	}


?>