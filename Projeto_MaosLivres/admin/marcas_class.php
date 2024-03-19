<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva marcas no banco</p>
	 */
	function cadastroMarcas($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "INSERT INTO marcas(nome, urlrewrite,imagem, status) VALUES (
						'".$dados['nome']."',
						'".$dados['urlrewrite']."',
						'".$dados['imagem']."',
						'".$dados['status']."')";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita marcas no banco</p>
	 */
	function editMarcas($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "UPDATE marcas SET
						nome = '".$dados['nome']."',
						urlrewrite = '".$dados['urlrewrite']."',
						imagem = '".$dados['imagem']."',	
						status = '".$dados['status']."'
					WHERE idmarcas = " . $dados['idmarcas'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idmarcas'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca marcas no banco</p>
	 */
	function buscaMarcas($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idmarcas',$dados) && !empty($dados['idmarcas']) )
			$buscaId = ' and idmarcas = '.intval($dados['idmarcas']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

		//busca pelo nome
		$buscaUrlrewrite = '';
		if (array_key_exists('urlrewrite',$dados) && !empty($dados['urlrewrite']) )
			$buscaUrlrewrite = ' and urlrewrite LIKE "%'.$dados['urlrewrite'].'%" '; 

      //busca pelo status
      $buscaStatus = ''; 
      if (array_key_exists('status',$dados) && !empty($dados['status']) )
         $buscaStatus = ' and status = "'.$dados['status'].'" '; 

		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and imagem LIKE "%'.$dados['imagem'].'%" '; 

        //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])){
			$orderBy = ' ORDER BY '.$dados['ordem'] ." ". $dados['dir'];
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
		$colsSql = '*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idmarcas) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM marcas WHERE 1  $buscaId $buscaStatus $buscaNome $buscaUrlrewrite $buscaImagem  $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
				!empty($r['imagem']) ? $r['imagem-caminho'] = '<img class="card-autor-adm" src="files/marcas/'.$r['imagem'].'" class="img-depoimento"/>' : $r['imagem-caminho'] = 'SEM IMAGEM';

		 		$r["status_nome"] = ($r["status"]=='A' ? "Ativo":"Inativo");
                $r["status_icone"] = ($r["status"]=='A' ? "<img src='images/estrelasim.png' class='icone inverteStatus' codigo='".$r['idmarcas']."' width='20px' />":"<img src='images/estrelanao.png' class='icone inverteStatus' codigo='".$r['idmarcas']."' width='20px'/>"); 				
 			}
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta marcas no banco</p>
	 */
	function deletaMarcas($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM marcas WHERE idmarcas = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemMarcas($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE marcas SET					
						ordem = '".$dados['ordem']."'						
					WHERE idmarcas = " . $dados['idmarcas'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idmarcas'];
	    } else {
	        return false;
	    }
	}
?>