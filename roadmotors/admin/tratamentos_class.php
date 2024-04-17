<?php
// Versao do modulo: 3.00.010416


/**
 * <p>salva tratamentos no banco</p>
 */
function cadastroTratamentos($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $dados['nome'] = trim($dados['nome']);

	$sql = "INSERT INTO tratamentos(nome, urlrewrite, status, imagem, banner_topo, resumo, icone_name, icone, descricao) VALUES (
						'" . $dados['nome'] . "',
						'" . $dados['urlrewrite'] . "',
                        '" . $dados['status'] . "',
                        '" . $dados['imagem'] . "',
                        '" . $dados['banner_topo'] . "',
                        '" . $dados['resumo'] . "',
                        '" . $dados['icone_name'] . "',
                        '" . $dados['icone'] . "',
                        '" . $dados['descricao'] . "'
                    )";

	if (mysqli_query($conexao, $sql)) {
		$resultado = mysqli_insert_id($conexao);
		return $resultado;
	} else {
		return false;
	}
}

/**
 * <p>edita tratamentos no banco</p>
 */
function editTratamentos($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $dados['nome'] = trim($dados['nome']);
   $dados['title'] = trim($dados['title']);
   $dados['description'] = trim($dados['description']);
   $dados['keywords'] = trim($dados['keywords']);

	$sql = "UPDATE tratamentos SET
						nome = '" . $dados['nome'] . "',
						urlrewrite = '" . $dados['urlrewrite'] . "',
						status = '" . $dados['status'] . "',
                        imagem = '" . $dados['imagem'] . "',
                        banner_topo = '" . $dados['banner_topo'] . "',
                        resumo = '" . $dados['resumo'] . "',
                        icone_name = '" . $dados['icone_name'] . "',
                        icone = '" . $dados['icone'] . "',
                        descricao = '" . $dados['descricao'] . "'
					WHERE idtratamentos = " . $dados['idtratamentos'];

	if (mysqli_query($conexao, $sql)) {
		return $dados['idtratamentos'];
	} else {
		return false;
	}
}

/**
 * <p>busca tratamentos no banco</p>
 */
function buscaTratamentos($dados = array())
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v) || $k == "colsSql") continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	//busca pelo id
	$buscaId = '';
	if (array_key_exists('idtratamentos', $dados) && !empty($dados['idtratamentos']))
		$buscaId = ' and tratamentos.idtratamentos = ' . intval($dados['idtratamentos']) . ' ';

	//busca pelo nome
	$buscaNome = '';
	if (array_key_exists('nome', $dados) && !empty($dados['nome']))
		$buscaNome = ' and tratamentos.nome LIKE "%' . $dados['nome'] . '%" ';

	//busca pelo id
	$buscanotId = '';
	if (array_key_exists('not_idtratamentos', $dados) && !empty($dados['not_idtratamentos']))
		$buscanotId = ' and NOT tratamentos.idtratamentos = ' . intval($dados['not_idtratamentos']) . ' ';

	//busca por urlrewrite
	$buscaUrlrewrite = '';
	if (array_key_exists('urlrewrite', $dados) && !empty($dados['urlrewrite']))
		$buscaUrlrewrite = ' and tratamentos.urlrewrite = "' . $dados['urlrewrite'] . '" ';

	//busca pelo status
    $buscaStatus = '';
    if (array_key_exists('status', $dados) && !empty($dados['status']))
        $buscaStatus = ' and tratamentos.status = ' . $dados['status'] . ' ';

    $buscaCount = '';
    if(array_key_exists('count', $dados)){
        $buscaCount = ", (SELECT COUNT(*) FROM tratamentos WHERE tratamentos.idtratamentos = tratamentos.idtratamentos) as qtd_tratamentos";
    }

	//ordem
	$orderBy = "";
	if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])) {
		$orderBy = ' ORDER BY ' . $dados['ordem'] . " " . $dados['dir'];
	}

	//busca pelo limit
	$buscaLimit = '';
	if (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('pagina', $dados)) {
		$buscaLimit = ' LIMIT ' . ($dados['limit'] * $dados['pagina']) . ',' . $dados['limit'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('inicio', $dados)) {
		$buscaLimit = ' LIMIT ' . $dados['limit'] . ',' . $dados['inicio'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit'])) {
		$buscaLimit = ' LIMIT ' . $dados['limit'];
	}

	//colunas que serão buscadas
	$colsSql = 'tratamentos.*';
	if (array_key_exists('totalRecords', $dados)) {
		$colsSql = ' count(idtratamentos) as totalRecords';
		$buscaLimit = '';
		$orderBy = '';
	} elseif (array_key_exists('colsSql', $dados)) {
		$colsSql = ' ' . $dados['colsSql'] . ' ';
	}

	$sql = "SELECT $colsSql FROM tratamentos WHERE 1  $buscaId $buscanotId $buscaUrlrewrite $buscaNome $buscaStatus $orderBy $buscaLimit ";

	$query = mysqli_query($conexao, $sql);
	$resultado = array();
	while ($r = mysqli_fetch_assoc($query)) {
		$r = array_map('utf8_encode', $r);
		if (!array_key_exists('totalRecords', $dados)) {
			$r["status_nome"] = ($r["status"]=='1' ? "Ativo":"Inativo");
            $r["status_icone"] = "<img src='images/estrela".($r["status"]=='1' ? "sim":"nao").".png' class='icone inverteStatus' codigo='".$r['idtratamentos']."' width='20px' />";
		}
		$resultado[] = $r;
	}
	return $resultado;
}

/**
 * <p>deleta tratamentos no banco</p>
 */
function deletaTratamentos($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM tratamentos WHERE idtratamentos = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function apagarImagemTratamentos($imgs) {
   $path = 'files/tratamentos/';
   if(file_exists($path)){
      //apaga os arquivos que foram salvos
      if(is_array($imgs)){
         foreach ($imgs as $img) {
            //imagem fundo
            $arquivo = $img['imagem_old'];
            $arquivo2 = str_replace('_', '', $arquivo);
            $medium = "medium_".$arquivo;
            $tall = "tall_".$arquivo;
            $long = "long_".$arquivo;
            $small = "small_".$arquivo;
            $outros = "outros_".$arquivo;
            if(file_exists($path.$arquivo)){
               unlink($path.$arquivo);
            }
            if(file_exists($path.$arquivo2)){
               unlink($path.$arquivo2);
            }
            if(file_exists($path.$medium)){
               unlink($path.$medium);
            }if(file_exists($path.$tall)){
               unlink($path.$tall);
            }if(file_exists($path.$long)){
               unlink($path.$long);
            }if(file_exists($path.$small)){
               unlink($path.$small);
            }if(file_exists($path.$outros)){
               unlink($path.$outros);
            }
            //imagem fundo
            $arquivo = $img['banner_topo_old'];
            $medium = "medium_".$arquivo;
            if(file_exists($path.$arquivo)){
               unlink($path.$arquivo);
            }
            if(file_exists($path.$medium)){
               unlink($path.$medium);
            }
         }
      }else{
         $arquivo = $imgs;
         $arquivo2 = str_replace('_', '', $arquivo);
         $medium = "medium_".$arquivo;
            $tall = "tall_".$arquivo;
            $long = "long_".$arquivo;
            $small = "small_".$arquivo;
            $outros = "outros_".$arquivo;
         if(file_exists($path.$arquivo)){
            unlink($path.$arquivo);
         }
         if(file_exists($path.$arquivo2)){
            unlink($path.$arquivo2);
         }
         if(file_exists($path.$medium)){
            unlink($path.$medium);
         }if(file_exists($path.$tall)){
            unlink($path.$tall);
         }if(file_exists($path.$long)){
            unlink($path.$long);
         }if(file_exists($path.$small)){
            unlink($path.$small);
         }if(file_exists($path.$outros)){
            unlink($path.$outros);
         }
      }
   }
   return true;
}

    /*===============================================Recursos===================================================*/

        function cadastroRecursos($dados)
        {

            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v)) continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['icone'])){
                if(empty($dados['icone'])){
                    $dados['icone'] = 1;
                }

                $dados['nome'] = trim($dados['nome']);
                $dados['descricao'] = trim($dados['descricao']);

                $sql = "INSERT INTO recursos(idtratamentos, nome, descricao, icone, nome_icone, imagem, ordem) VALUES (
                                '".$dados['idtratamentos']."',
                                '".$dados['nome']."',
                                '".$dados['descricao']."',
                                '".$dados['icone']."',
                                '".$dados['nome_icone']."',
                                '".$dados['imagem']."',
                                '".$dados['ordem']."'
                            )";
                if (mysqli_query($conexao, $sql)) {
                    $resultado = mysqli_insert_id($conexao);
                    return $resultado;
                } else {
                    return false;
                }
            }
        }

        /**
         * <p>edita recursos no banco</p>
         */
        function editRecursos($dados)
        {
            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v)) continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            $dados['nome'] = trim($dados['nome']);
            $dados['descricao'] = trim($dados['descricao']);

            $sql = "UPDATE recursos SET
                            nome = '".$dados['nome']."',
                            descricao = '".$dados['descricao']."',
                            icone = '".$dados['icone']."',
                            nome_icone = '".$dados['nome_icone']."',
                            imagem = '".$dados['imagem']."',
                            ordem = '".$dados['ordem']."'
                        WHERE idtratamentos = ".$dados['idtratamentos']."
                        AND idrecursos = ".$dados['idrecursos'];

            if (mysqli_query($conexao, $sql)) {
                return $dados['idrecursos'];
            } else {
                return false;
            }
        }

        /**
         * <p>busca recursos no banco</p>
         */
        function buscaRecursos($dados = array())
        {
            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v) || $k == "colsSql") continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            //busca pelo id
            $buscaId = '';
            if (array_key_exists('idrecursos',$dados) && !empty($dados['idrecursos']) )
                $buscaId = ' and idrecursos = '.intval($dados['idrecursos']).' '; 

            //busca pelo nome
            $buscaNome = '';
            if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
                $buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

            //busca pelo descricao
            $buscaDescricao = '';
            if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
                $buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

            //busca pelo idtratamentos
            $buscaIdTratamentos = '';
            if (array_key_exists('idtratamentos',$dados) && !empty($dados['idtratamentos']) )
                $buscaIdTratamentos = ' and idtratamentos = '.$dados['idtratamentos'].' '; 

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
                $colsSql = ' count(idrecursos) as totalRecords';
                $buscaLimit = '';
                $orderBy = '';
            } elseif (array_key_exists('colsSql',$dados)) {
                $colsSql = ' '.$dados['colsSql'].' ';
            }

            $sql = "SELECT $colsSql FROM recursos WHERE 1 $buscaId $buscaIdTratamentos $buscaNome $buscaDescricao $buscaImagem $orderBy $buscaLimit ";

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

        /**
         * <p>deleta recursos no banco a partir da edição</p>
         */
        function deletaRecursos2($dados,$dados2)
        {
            include "includes/mysql.php";

            $sql = "DELETE FROM recursos WHERE idtratamentos = $dados AND idrecursos = $dados2";
            if (mysqli_query($conexao, $sql)) {
                return mysqli_affected_rows($conexao);
            } else {
                return FALSE;
            }
        }

        /**
         * <p>deleta recursos no banco</p>
         */
        function deletaRecursos($dados)
        {
            include "includes/mysql.php";

            $sql = "DELETE FROM recursos WHERE idtratamentos = $dados";
            if (mysqli_query($conexao, $sql)) {
                return mysqli_affected_rows($conexao);
            } else {
                return FALSE;
            }
        }

        function editOrdemRecursos($dados)
        {
            include "includes/mysql.php";
           
            $sql = "UPDATE recursos SET                 
                            ordem = '".$dados['ordem']."'                       
                        WHERE idrecursos = " . $dados['idrecursos'];
            
            if (mysqli_query($conexao, $sql)) {
                return $dados['idrecursos'];
            } else {
                return false;
            }
        }

        function apagarImagemRecursos($imgs) {
            $path = 'files/recursos/';
            if(file_exists($path)){
                //apaga os arquivos que foram salvos
                if(is_array($imgs)){
                    foreach ($imgs as $img) {
                        //imagem fundo
                        $arquivo = $img['imagem_old'];
                        $arquivo2 = str_replace('_', '', $arquivo);
                        $original = "original_".$arquivo;

                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$arquivo2)){
                            unlink($path.$arquivo2);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }

                        //imagem fundo
                        $arquivo = $img['imagem_old'];
                        $original = "original_".$arquivo;

                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }
                    }
                }else{
                    $arquivo = $imgs;
                    $arquivo2 = str_replace('_', '', $arquivo);
                    $original = "original_".$arquivo;

                    if(!empty($arquivo)){
                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$arquivo2)){
                            unlink($path.$arquivo2);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }
                    }
                }
            }
            return true;
        }

    // Fim Recursos

    /*===============================================Testes===================================================*/

        function cadastroTestes($dados)
        {

            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v)) continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['icone'])){
                if(empty($dados['icone'])){
                    $dados['icone'] = 1;
                }

                $dados['nome'] = trim($dados['nome']);
                $dados['descricao'] = trim($dados['descricao']);

                $sql = "INSERT INTO testes(idtratamentos, nome, descricao, icone, nome_icone, imagem, ordem) VALUES (
                                '".$dados['idtratamentos']."',
                                '".$dados['nome']."',
                                '".$dados['descricao']."',
                                '".$dados['icone']."',
                                '".$dados['nome_icone']."',
                                '".$dados['imagem']."',
                                '".$dados['ordem']."'
                            )";
                if (mysqli_query($conexao, $sql)) {
                    $resultado = mysqli_insert_id($conexao);
                    return $resultado;
                } else {
                    return false;
                }
            }
        }

        /**
         * <p>edita testes no banco</p>
         */
        function editTestes($dados)
        {
            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v)) continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            $dados['nome'] = trim($dados['nome']);
            $dados['descricao'] = trim($dados['descricao']);

            $sql = "UPDATE testes SET
                            nome = '".$dados['nome']."',
                            descricao = '".$dados['descricao']."',
                            icone = '".$dados['icone']."',
                            nome_icone = '".$dados['nome_icone']."',
                            imagem = '".$dados['imagem']."',
                            ordem = '".$dados['ordem']."'
                        WHERE idtratamentos = ".$dados['idtratamentos']."
                        AND idtestes = ".$dados['idtestes'];

            if (mysqli_query($conexao, $sql)) {
                return $dados['idtestes'];
            } else {
                return false;
            }
        }

        /**
         * <p>busca testes no banco</p>
         */
        function buscaTestes($dados = array())
        {
            include "includes/mysql.php";

            foreach ($dados AS $k => &$v) {
                if (is_array($v) || $k == "colsSql") continue;
                $v = stripslashes($v);
                $v = mysqli_real_escape_string($conexao, utf8_decode($v));
            }

            //busca pelo id
            $buscaId = '';
            if (array_key_exists('idtestes',$dados) && !empty($dados['idtestes']) )
                $buscaId = ' and idtestes = '.intval($dados['idtestes']).' '; 

            //busca pelo nome
            $buscaNome = '';
            if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
                $buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

            //busca pelo descricao
            $buscaDescricao = '';
            if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
                $buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

            //busca pelo idtratamentos
            $buscaIdTratamentos = '';
            if (array_key_exists('idtratamentos',$dados) && !empty($dados['idtratamentos']) )
                $buscaIdTratamentos = ' and idtratamentos = '.$dados['idtratamentos'].' '; 

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
                $colsSql = ' count(idtestes) as totalRecords';
                $buscaLimit = '';
                $orderBy = '';
            } elseif (array_key_exists('colsSql',$dados)) {
                $colsSql = ' '.$dados['colsSql'].' ';
            }

            $sql = "SELECT $colsSql FROM testes WHERE 1 $buscaId $buscaIdTratamentos $buscaNome $buscaDescricao $buscaImagem $orderBy $buscaLimit ";

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

        /**
         * <p>deleta testes no banco a partir da edição</p>
         */
        function deletaTestes2($dados,$dados2)
        {
            include "includes/mysql.php";

            $sql = "DELETE FROM testes WHERE idtratamentos = $dados AND idtestes = $dados2";
            if (mysqli_query($conexao, $sql)) {
                return mysqli_affected_rows($conexao);
            } else {
                return FALSE;
            }
        }

        /**
         * <p>deleta testes no banco</p>
         */
        function deletaTestes($dados)
        {
            include "includes/mysql.php";

            $sql = "DELETE FROM testes WHERE idtratamentos = $dados";
            if (mysqli_query($conexao, $sql)) {
                return mysqli_affected_rows($conexao);
            } else {
                return FALSE;
            }
        }

        function editOrdemTestes($dados)
        {
            include "includes/mysql.php";
           
            $sql = "UPDATE testes SET                 
                            ordem = '".$dados['ordem']."'                       
                        WHERE idtestes = " . $dados['idtestes'];
            
            if (mysqli_query($conexao, $sql)) {
                return $dados['idtestes'];
            } else {
                return false;
            }
        }

        function apagarImagemTestes($imgs) {
            $path = 'files/testes/';
            if(file_exists($path)){
                //apaga os arquivos que foram salvos
                if(is_array($imgs)){
                    foreach ($imgs as $img) {
                        //imagem fundo
                        $arquivo = $img['imagem_old'];
                        $arquivo2 = str_replace('_', '', $arquivo);
                        $original = "original_".$arquivo;

                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$arquivo2)){
                            unlink($path.$arquivo2);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }

                        //imagem fundo
                        $arquivo = $img['imagem_old'];
                        $original = "original_".$arquivo;

                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }
                    }
                }else{
                    $arquivo = $imgs;
                    $arquivo2 = str_replace('_', '', $arquivo);
                    $original = "original_".$arquivo;

                    if(!empty($arquivo)){
                        if(file_exists($path.$arquivo)){
                            unlink($path.$arquivo);
                        }
                        if(file_exists($path.$arquivo2)){
                            unlink($path.$arquivo2);
                        }
                        if(file_exists($path.$original)){
                            unlink($path.$original);
                        }
                    }
                }
            }
            return true;
        }

    // Fim Testes

/*************************************************/
/******************* GALERIA *********************/
/*************************************************/

   /**
    * <p>busca tratamentos_imagem no banco</p>
    */
   function buscaTratamentos_imagem($dados = array())
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v) || $k == "colsSql") continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }


      //busca pelo id
      $buscaId = '';
      if (array_key_exists('idtratamentos_imagem',$dados) && !empty($dados['idtratamentos_imagem']) )
         $buscaId = ' and idtratamentos_imagem = '.intval($dados['idtratamentos_imagem']).' ';

      //busca pelo idtratamentos
      $buscaIdtratamentos = '';
      if (array_key_exists('idtratamentos',$dados) && !empty($dados['idtratamentos']) )
         $buscaIdtratamentos = ' and idtratamentos = "'.$dados['idtratamentos'].'" ';


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
         $colsSql = ' count(idtratamentos_imagem) as totalRecords';
           $buscaLimit = '';
           $orderBy = '';
       } elseif (array_key_exists('colsSql',$dados)) {
         $colsSql = ' '.$dados['colsSql'].' ';
      }

      $sql = "SELECT $colsSql FROM tratamentos_imagem
            WHERE 1  $buscaId  $buscaIdtratamentos
            $buscaDescricao_imagem  $buscaUrlrewrite_imagem
            $buscaPosicao_imagem  $buscaM2y_imagem  $orderBy $buscaLimit ";

      include_once('includes/functions.php');

      $query = mysqli_query($conexao, $sql);
      $resultado = array();
      while ($r = mysqli_fetch_assoc($query)){

         if (!array_key_exists('totalRecords',$dados)){
            
         }

         $r = array_map('utf8_encode', $r);
         $resultado[] = $r;
      }

      return $resultado;
   }


   function cadastroTratamentos_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }
      $sql = "INSERT INTO tratamentos_imagem( idtratamentos, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem ,is_default) VALUES (
               '".$dados['idtratamentos']."',
               '".$dados['nome_imagem']."',
               '".$dados['descricao_imagem']."',
               '".$dados['urlrewrite_imagem']."',
               '".$dados['posicao_imagem']."',
               '".$dados['is_default']."'
            )";
      if (mysqli_query($conexao, $sql)) {
         $resultado = mysqli_insert_id($conexao);
         return $resultado;
      } else {
         return false;
      }
   }

   /**
    * <p>edita tratamentos_imagem no banco</p>
    */
   function editTratamentos_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $sql = "UPDATE tratamentos_imagem SET
                  idtratamentos = '".$dados['idtratamentos']."',
                  descricao_imagem = '".$dados['descricao_imagem']."',
                  urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
                  posicao_imagem = '".$dados['posicao_imagem']."',
                  is_default = '".$dados['is_default']."',
                  nome_imagem = '".$dados['nome_imagem']."',
                  m2y_imagem = '".$dados['m2y_imagem']."'
               WHERE idtratamentos_imagem = " . $dados['idtratamentos_imagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['idtratamentos_imagem'];
      } else {
         return false;
      }
   }

   function editIdTratamentos_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $sql = "UPDATE tratamentos_imagem SET
                  idtratamentos = '".$dados['idtratamentos']."'
               WHERE idtratamentos_imagem = " . $dados['idtratamentos_imagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['idtratamentos_imagem'];
      } else {
         return false;
      }
   }


   function salvaImagemTratamentos($dados){

      include_once "includes/functions.php";
      $dadosGravar = array();

      $idtratamentos = $dados['idtratamentos'];
      //urlrewrite
      $nomeimagem = explode('.', $dados['nome_imagem']);
      $nomeimagem = $nomeimagem[0];
      $dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);
      //atribuir m2y
      $urlrewrite = 'admin/files/tratamentos/'.$idtratamentos.'/galeria/thumbnail/'.$dados['nome_imagem'];

      // $dados['m2y_imagem'] = '';
      // $shorturl = ENDERECO.$urlrewrite;
      // $authkey = "3H34kAfJ36c7VUR3oCqBR15R33P554V6";

      // $returns = file_get_contents("http://www.m2y.me/webservice/create/?url=".$shorturl."&authkey=".$authkey);

      // if($returns != -1 && $returns != -2){
      //    $dados['m2y_imagem'] = $returns;
      // }

      if($dados['posicao_imagem'] == 1){
         $dados['is_default'] = 1;
      }else{
         $dados['is_default'] = 0;
      }

      return cadastroTratamentos_imagem($dados);
   }



    function alterarPosicaoImagemTratamentos($dados){

      include "includes/mysql.php";

      $imagens = $dados['idtratamentos_imagem'];
      $posicao = $dados['posicao_imagem'];
      $idtratamentos = $dados['idtratamentos'];

      if(!empty($imagens)){

         foreach($imagens as $k => $v){
            $sql = 'UPDATE tratamentos_imagem SET
                  posicao_imagem = "'.$posicao[$k].'",
                  is_default = 0
                  WHERE idtratamentos_imagem = '.$v;

            mysqli_query($conexao, $sql);
         }

         $sql = 'UPDATE tratamentos_imagem SET is_default = 1 WHERE idtratamentos = '.$idtratamentos.' and posicao_imagem = 1';
               mysqli_query($conexao, $sql);
               return true;
      }else{
         return true;
      }
    }



  //APAGAR IMAGENS DA PASTA
   function apagarImagemBlogTratamentos($imgs) {
      $path = 'files/tratamentos/galeria/';

      $nameArquivo = array();
      $nameArquivo[] = "";
      $nameArquivo[] = "thumb_";

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


   //APAGA UM IMAGEM ESPECIFICA DA GALERIA
   function deletarImagemBlogGaleriaTratamentos($idtratamentos_imagem, $idpost){

      include "includes/mysql.php";
      $return = false;

      $imagem = buscaTratamentos_imagem(array("idtratamentos_imagem"=>$idtratamentos_imagem));

      apagarImagemBlogTratamentos($imagem);

      $posicao = $imagem[0]['posicao_imagem'];
      $sql = 'DELETE from tratamentos_imagem WHERE idtratamentos_imagem = '.$idtratamentos_imagem;

      if (mysqli_query($conexao, $sql)) {
         //update nas posicao das imagens
         $sql = 'UPDATE tratamentos_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE idtratamentos = '.$idpost.' and posicao_imagem > '.$posicao;
         if (mysqli_query($conexao, $sql)) {
            //marca a primeira posicao como default - caso apague q primeira imagem
            $sql = 'UPDATE tratamentos_imagem SET is_default = 1 WHERE idtratamentos = '.$idpost.' and posicao_imagem = 1';
            mysqli_query($conexao, $sql);
            $return = true;
         }
      } else {
         $return = false;
      }

        return $return;
    }

    function apagarArquivoTratamentos($arq) {
        if(file_exists($arq)){
            //apaga os arquivos que foram salvos
            $arquivo = $arq;
            if(file_exists($path.$arquivo)){
                unlink($path.$arquivo);
            }
        }
        return true;
    }

    function excluirArquivoTratamentos($dados)
    {
       include "includes/mysql.php";
       if (!empty($dados)) {
            $sql = "UPDATE tratamentos SET
                     arquivo = ''
                  WHERE idtratamentos = " . $dados['idtratamentos'];

          if (mysqli_query($conexao, $sql)) {
             $num = mysqli_affected_rows($conexao);

             // $caminho = "files/tratamentos/arquivos/";
                
            if (file_exists($dados['arquivo'])) {
               unlink($dados['arquivo']);
            }
             
             return true;
          } else {
             return FALSE;
          } 
       }
    }
?>