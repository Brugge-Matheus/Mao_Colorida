<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva segmento no banco</p>
	 */
	function cadastroSegmento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "INSERT INTO segmento(nome, urlrewrite, imagem ,valor, banner,status) VALUES (
						'".$dados['nome']."',
						'".$dados['urlrewrite']."',
						'".$dados['imagem']."',
						'".$dados['valor']."',
						'".$dados['banner']."',
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
	 * <p>edita segmento no banco</p>
	 */
	function editSegmento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);

		$sql = "UPDATE segmento SET
						nome = '".$dados['nome']."',
						urlrewrite = '".$dados['urlrewrite']."',
						imagem = '".$dados['imagem']."',
						valor = '".$dados['valor']."',
						banner = '".$dados['banner']."',
						status = '".$dados['status']."'
					WHERE idsegmento = " . $dados['idsegmento'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idsegmento'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca segmento no banco</p>
	 */
	function buscaSegmento($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
            $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idsegmento',$dados) && !empty($dados['idsegmento']) )
			$buscaId = ' and segmento.idsegmento = '.intval($dados['idsegmento']).' '; 

		//busca pelo id
		$buscaimagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaimagem = ' and segmento.imagem = '.intval($dados['imagem']).' ';

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and segmento.nome LIKE "%'.$dados['nome'].'%" '; 

	    //busca pelo urlrewrite
	    $buscaUrlrewrite = '';
	    if (array_key_exists('urlrewrite',$dados) && !empty($dados['urlrewrite']) )
	        $buscaUrlrewrite = ' and segmento.urlrewrite = "'.$dados['urlrewrite'].'" '; 

	    //busca pelo status
	    $buscaStatus = '';
	    if (array_key_exists('status',$dados) && !empty($dados['status']) )
	        $buscaStatus = ' and segmento.status = "'.$dados['status'].'" '; 

        //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])){
			$orderBy = ' ORDER BY segmento.'.$dados['ordem'] ." ". $dados['dir'];
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
		$colsSql = 'segmento.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(segmento.idsegmento) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM segmento 
				WHERE 1  $buscaId $buscaimagem $buscaUrlrewrite $buscaStatus $buscaNome $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){

		 		$r["status_nome"] = ($r["status"]=='1' ? "Ativo":"Inativo");
                $r["status_icone"] = ($r["status"]=='1' ? "<img src='images/estrelasim.png' class='icone inverteStatus' codigo='".$r['idsegmento']."' width='20px' />":"<img src='images/estrelanao.png' class='icone inverteStatus' codigo='".$r['idsegmento']."' width='20px'/>"); 				
 			}
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta segmento no banco</p>
	 */
	function deletaSegmento($dados)
	{
		include "includes/mysql.php";

		$segmento = buscaSegmento(array("idsegmento" => $dados));

		$sql = "DELETE FROM segmento WHERE idsegmento = $dados";

		if (mysqli_query($conexao, $sql)) {
			$num = mysqli_affected_rows($conexao);
			return $num;
		} else {
			return FALSE;
		}
	}

	function editOrdemSegmento($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE segmento SET					
						ordem = '".$dados['ordem']."'						
					WHERE idsegmento = " . $dados['idsegmento'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idsegmento'];
	    } else {
	        return false;
	    }
	}
?>