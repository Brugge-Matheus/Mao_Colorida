<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva equipe no banco</p>
	 */
	function cadastroEquipe($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

      $dados['nome'] = trim($dados['nome']);

		$sql = "INSERT INTO equipe( nome, imagem, status, especialidade) VALUES (
						'".$dados['nome']."',
						'".$dados['imagem']."',
						'".$dados['status']."',
						'".$dados['especialidade']."')";

		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita equipe no banco</p>
	 */
	function editEquipe($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "UPDATE equipe SET
						nome = '".$dados['nome']."',
            imagem = '".$dados['imagem']."',
						status = '".$dados['status']."',
						especialidade = '".$dados['especialidade']."'
					WHERE idequipe = " . $dados['idequipe'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idequipe'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca equipe no banco</p>
	 */
	function buscaEquipe($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
            $v = stripslashes($v);
			// $v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idequipe',$dados) && !empty($dados['idequipe']) )
			$buscaId = ' and idequipe = '.intval($dados['idequipe']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

      //busca pelo status
      $buscaStatus = '';
      if (array_key_exists('status',$dados) && !empty($dados['status']) )
         $buscaStatus = ' and status LIKE "%'.$dados['status'].'%" '; 


		//busca pelo descricao
		$buscaDescricao = '';
		if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
			$buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 


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
			$colsSql = ' count(idequipe) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM equipe WHERE 1  $buscaId  $buscaNome $buscaStatus $buscaDescricao  $buscaImagem  $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;
		$tot =  mysqli_affected_rows($conexao);

		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r); 
			if (!array_key_exists('totalRecords',$dados)){
				!empty($r['imagem']) ? $r['imagem-caminho'] = '<img style="width: 80px;margin: 10px;" src="files/equipe/'.$r['imagem'].'" class="img-equipe"/>' : $r['imagem-caminho'] = 'SEM IMAGEM';
	        }  
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta equipe no banco</p>
	 */
	function deletaEquipe($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM equipe WHERE idequipe = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemEquipe($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE equipe SET					
						ordem = '".$dados['ordem']."'						
					WHERE idequipe = " . $dados['idequipe'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idequipe'];
	    } else {
	        return false;
	    }
	}
?>