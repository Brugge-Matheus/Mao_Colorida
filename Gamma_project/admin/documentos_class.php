<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva download no banco</p>
	 */
	function cadastroDocumentos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}
		$sql = "INSERT INTO documentos( nome, resumo, capa, arquivo, tipo, status) VALUES (
						'".$dados['nome']."',
						'".$dados['resumo']."',
						'".$dados['capa']."',
						'".$dados['arquivo']."',
						'".$dados['tipo']."',
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
	 * <p>edita download no banco</p>
	 */
	function editDocumentos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}

		$sql = "UPDATE documentos SET
						nome = '".$dados['nome']."',
						resumo = '".$dados['resumo']."',
						capa = '".$dados['capa']."',
						arquivo = '".$dados['arquivo']."',
						tipo = '".$dados['tipo']."',
						status = '".$dados['status']."'
					WHERE iddocumentos = " . $dados['iddocumentos'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['iddocumentos'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca download no banco</p>
	 */
	function buscaDocumentos($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('iddocumentos',$dados) && !empty($dados['iddocumentos']) )
			$buscaId = ' and iddocumentos = '.intval($dados['iddocumentos']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

			//busca pelo arquivo
			$buscaCapa = '';
			if (array_key_exists('capa',$dados) && !empty($dados['capa']) )
				$buscaCapa = ' and capa LIKE "%'.$dados['capa'].'%" '; 			

		//busca pelo arquivo
		$buscaArquivo = '';
		if (array_key_exists('arquivo',$dados) && !empty($dados['arquivo']) )
			$buscaArquivo = ' and arquivo LIKE "%'.$dados['arquivo'].'%" ';

		//busca pelo arquivo
		$buscaTipo = '';
		if (array_key_exists('tipo',$dados) && !empty($dados['tipo']) )
			$buscaTipo = ' and tipo LIKE "%'.$dados['tipo'].'%" ';
			
		//busca pelo status
		$buscaStatus = '';
		if (array_key_exists('status',$dados))
			$buscaStatus = ' and status LIKE "%'.$dados['status'].'%" '; 

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
			$colsSql = ' count(iddocumentos) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM documentos WHERE 1  $buscaId  $buscaNome $buscaArquivo  $buscaCapa $buscaTipo $buscaStatus $orderBy $buscaLimit";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();

		while ($r = mysqli_fetch_assoc($query)){
			if (!array_key_exists('totalRecords',$dados)){
						$r["status_nome"] = ($r["status"]=='A' ? "Ativo":"Inativo");
            $r["status_icone"] = "<img src='images/estrela".($r["status"]=='A' ? "sim":"nao").".png' class='icone' onclick='inverteStatus(".$r['iddocumentos'].",".$r['status'].", ".'"documentos"'.", function (retorno){dataTableDocumentos();})' width='20px' />";
			}				
			$resultado[] = $r;
		}
		
		return $resultado; 
 	}

	/**
	 * <p>deleta download no banco</p>
	 */
	function deletaDocumentos($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM documentos WHERE iddocumentos = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}


?>