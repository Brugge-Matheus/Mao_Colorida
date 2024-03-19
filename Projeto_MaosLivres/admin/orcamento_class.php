<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva orcamento no banco</p>
	 */
	function cadastroOrcamento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);
		
		$sql = "INSERT INTO orcamento(idproduto,nome,nomeproduto, numero_orcamento,email, telefone, cpf, status_orcamento, qtde, assunto) VALUES (
				'".$dados['idproduto']."',
				'".$dados['nome']."',
				'".$dados['nomeproduto']."',
				'".$dados['numero_orcamento']."',
				'".((isset($dados['email']))?$dados['email']:'')."',
				'".$dados['telefone']."',
				'".$dados['cpf']."',
				'".$dados['status_orcamento']."',
				'".$dados['qtde']."',
				'".$dados['assunto']."'
      )";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao); 
			return $resultado;
		} else {
			return false;
		}
	} 

	/**
	 * <p>edita orcamento no banco</p>
	 */
	function editOrcamento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "UPDATE orcamento SET
						idproduto = '".$dados['idproduto']."', 
						nome = '".$dados['nome']."', 
						nomeproduto = '".$dados['nomeproduto']."', 
						numero_orcamento = '".$dados['numero_orcamento']."',
						email = '".$dados['email']."', 
						telefone = '".$dados['telefone']."', 
						cpf = '".$dados['cpf']."', 
						status_orcamento = '".$dados['status_orcamento']."', 
						aqtde = '".$dados['aqtde']."', 
						assunto = '".$dados['assunto']."'
					WHERE idorcamento = " . $dados['idorcamento'];
		 
		if (mysqli_query($conexao, $sql)) {
			return $dados['idorcamento'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca orcamento no banco</p>
	 */
	function buscaOrcamento($dados = array())
	{
		include "includes/mysql.php";
		include_once "includes/functions.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idorcamento',$dados) && !empty($dados['idorcamento']) )
			$buscaId = ' and C.idorcamento = '.intval($dados['idorcamento']).' '; 
		
		//busca pelo id
		$buscaIdproduto = '';
		if (array_key_exists('idproduto',$dados) && !empty($dados['idproduto']) )
			$buscaIdproduto = ' and C.idproduto = '.intval($dados['idproduto']).' '; 

		//busca pelo nome
		$buscaNomeproduto = '';
		if (array_key_exists('nomeproduto',$dados) && !empty($dados['nomeproduto']) )
			$buscaNomeproduto = ' and C.nomeproduto LIKE "%'.$dados['nomeproduto'].'%" '; 

			//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" '; 

		//busca pelo telefone
		$buscaTelefone = '';
		if (array_key_exists('telefone',$dados) && !empty($dados['telefone']) )
			$buscaTelefone = ' and C.telefone LIKE "%'.$dados['telefone'].'%" ';			

		//busca pelo email
		$buscaEmail = '';
		if (array_key_exists('email',$dados) && !empty($dados['email']) )
			$buscaEmail = ' and C.email LIKE "%'.$dados['email'].'%" ';

	 
	 	//busca pelo cpf
		$buscaCpf = '';
		if (array_key_exists('cpf',$dados) && !empty($dados['cpf']) )
			$buscaCpf = ' and C.cpf = "'.$dados['cpf'].'" '; 

		//busca pelo status
		$buscaStatus_orcamento = '';
		if (array_key_exists('status_orcamento',$dados) && !empty($dados['status_orcamento']) )
			$buscaStatus_orcamento = ' and C.status_orcamento = "'.$dados['status_orcamento'].'" '; 

	 	//busca pelo quantidade
		 $buscaQuantidade = '';
		 if (array_key_exists('qtde',$dados) && !empty($dados['qtde']) )
			 $buscaQuantidade = ' and C.qtde = "'.$dados['qtde'].'" '; 
		
		//busca pelo assunto
		$buscaAssunto = '';
		if (array_key_exists('assunto',$dados) && !empty($dados['assunto']) )
			$buscaAssunto = ' and C.assunto = "'.$dados['assunto'].'" '; 
			


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
		// $colsSql = 'C.*, I.idioma'; 
		$colsSql = 'C.*'; 

		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(C.idorcamento) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM orcamento as C 
		WHERE 1 $buscaId $buscaIdproduto $buscaNome $buscaNomeproduto $buscaAssunto $buscaEmail $buscaTelefone $buscaCpf $buscaQuantidade $buscaStatus_orcamento $orderBy $buscaLimit ";
		
		
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			$resultado[] = $r;
		} 
		return $resultado;  
 	}

	/**
	 * <p>deleta orcamento no banco</p>
	 */
	function deletaOrcamento($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM orcamento WHERE idorcamento = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	} 
	 
?>