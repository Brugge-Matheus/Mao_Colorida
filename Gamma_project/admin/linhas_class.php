<?php
// Versao do modulo: 3.00.010416


/**
 * <p>salva linhas no banco</p>
 */
function cadastroLinhas($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $dados['nome'] = trim($dados['nome']);

	$sql = "INSERT INTO linhas(nome, urlrewrite, status, imagem, imagem2,resumo) VALUES (
                '".$dados['nome']."',
                '".$dados['urlrewrite']."',
                '".$dados['status']."',
                '".$dados['imagem']."',
                '".$dados['imagem2']."',
                '".$dados['resumo']."'
            )";

	if (mysqli_query($conexao, $sql)) {
		$resultado = mysqli_insert_id($conexao);
		return $resultado;
	} else {
		return false;
	}
}

/**
 * <p>edita linhas no banco</p>
 */
function editLinhas($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $sql = "UPDATE linhas SET
                nome = '".$dados['nome']."',
                urlrewrite = '".$dados['urlrewrite']."',
                status = '".$dados['status']."',
                imagem = '".$dados['imagem']."',
                imagem2 = '".$dados['imagem2']."',
                resumo = '".$dados['resumo']."'
            WHERE idlinhas = " . $dados['idlinhas'];

	if (mysqli_query($conexao, $sql)) {
		return $dados['idlinhas'];
	} else {
		return false;
	}
}

/**
 * <p>busca linhas no banco</p>
 */
function buscaLinhas($dados = array())
{
    include "includes/mysql.php";
    include_once "includes/functions.php";

    foreach ($dados AS $k => &$v) {
        if (is_array($v) || $k == "colsSql") continue;
        //if (get_magic_quotes_gpc()) $v = stripslashes($v);
        $v = mysqli_real_escape_string($conexao, utf8_decode($v));
    }

    //busca pelo id
    $buscaId = '';
    if (array_key_exists('idlinhas',$dados) && !empty($dados['idlinhas']) )
        $buscaId = ' and S.idlinhas = '.intval($dados['idlinhas']).' '; 


    //busca pelo not_idlinhas
    $buscaNotId = '';
    if (array_key_exists('not_idlinhas',$dados) && !empty($dados['not_idlinhas']) )
        $buscaNotId = ' and S.idlinhas != '.intval($dados['not_idlinhas']).' ';

    //busca pelo not_inlinhas
    $buscaNotInLinhas = '';
    if (array_key_exists('not_inlinhas',$dados) && !empty($dados['not_inlinhas']) )
        $buscaNotInLinhas = ' and S.idlinhas not in ('.$dados['not_inlinhas'].')';


     //busca pelo nome
    $buscaNome = '';
    if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
        $buscaNome = ' and S.nome LIKE "%'.$dados['nome'].'%" '; 
        
    //busca pelo urlrewrite
    $buscaUrlrewrite = '';
    if (array_key_exists('urlrewrite',$dados) && !empty($dados['urlrewrite']) )
        $buscaUrlrewrite = ' and S.urlrewrite = "'.$dados['urlrewrite'].'" '; 

    //busca pelo destaque
    $buscaDestaque = '';
    if (array_key_exists('destaque',$dados) && !empty($dados['destaque']) )
        $buscaDestaque = ' and S.destaque = '.$dados['destaque'].' '; 

    //busca pelo imagem
    $buscaImagem = '';
    if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
        $buscaImagem = ' and S.imagem LIKE "%'.$dados['imagem'].'%" '; 

    //busca pelo imagem2
    $buscaImagem2 = '';
    if (array_key_exists('imagem2',$dados) && !empty($dados['imagem2']) )
        $buscaImagem2 = ' and S.imagem2 LIKE "%'.$dados['imagem2'].'%" '; 

        //busca pelo title
        $buscaTitle = '';
        if (array_key_exists('title',$dados) && !empty($dados['title']) )
            $buscaTitle = ' and S.title LIKE "%'.$dados['title'].'%" '; 


        //busca pelo description
        $buscaDescription = '';
        if (array_key_exists('description',$dados) && !empty($dados['description']) )
            $buscaDescription = ' and description LIKE "%'.$dados['description'].'%" '; 


        //busca pelo keywords
        $buscaKeywords = '';
        if (array_key_exists('keywords',$dados) && !empty($dados['keywords']) )
            $buscaKeywords = ' and S.keywords LIKE "%'.$dados['keywords'].'%" '; 

        //busca pelo status
    $buscaStatus = '';
    if (array_key_exists('status',$dados) && !empty($dados['status']) )
        $buscaStatus = ' and S.status = "'.$dados['status'].'" ';

    //busca pelo Slogan
    $buscaSlogan = '';
    if (array_key_exists('slogan',$dados) && !empty($dados['slogan']) )
        $buscaSlogan = ' and S.slogan = "'.$dados['slogan'].'" ';

    //busca pelo Slogan
    $buscaSlogan2 = '';
    if (array_key_exists('slogan2',$dados) && !empty($dados['slogan2']) )
        $buscaSlogan2 = ' and S.slogan2 = "'.$dados['slogan2'].'" ';

    //busca pelo resumo
    $buscaResumo = '';
    if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
        $buscaResumo = ' and resumo LIKE "%'.$dados['resumo'].'%" '; 

    //busca pelo descricao
    $buscaDescricao = '';
    if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
        $buscaDescricao = ' and S.descricao LIKE "%'.$dados['descricao'].'%" '; 

    //busca pelo informacoes
    $buscaBeneficio1 = '';
    if (array_key_exists('beneficios1',$dados) && !empty($dados['beneficios1']) )
        $buscaBeneficio1 = ' and S.beneficios1 LIKE "%'.$dados['beneficios1'].'%" '; 

    //busca pelo informacoes
   //  $buscaIcone1 = '';
   //  if (array_key_exists('icone',$dados) && !empty($dados['icone']) )
   //      $buscaIcone1 = ' and S.icone LIKE "%'.$dados['icone'].'%" '; 
        
    //busca pelo informacoes
    $buscaTexto1 = '';
    if (array_key_exists('texto1',$dados) && !empty($dados['texto1']) )
        $buscaTexto1 = ' and S.texto1 LIKE "%'.$dados['texto1'].'%" '; 

    //busca pelo informacoes
    $buscaBeneficio2 = '';
    if (array_key_exists('beneficios2',$dados) && !empty($dados['beneficios2']) )
        $buscaBeneficio2 = ' and S.beneficios2 LIKE "%'.$dados['beneficios2'].'%" '; 

        //busca pelo informacoes
   //  $buscaIcone2 = '';
   //  if (array_key_exists('icone2',$dados) && !empty($dados['icone2']) )
   //      $buscaIcone2 = ' and S.icone2 LIKE "%'.$dados['icone2'].'%" '; 
        
    //busca pelo informacoes
    $buscaTexto2 = '';
    if (array_key_exists('texto2',$dados) && !empty($dados['texto2']) )
        $buscaTexto2 = ' and S.texto2 LIKE "%'.$dados['texto2'].'%" '; 

    //busca pelo informacoes
    $buscaBeneficio3 = '';
    if (array_key_exists('beneficios3',$dados) && !empty($dados['beneficios3']) )
        $buscaBeneficio3 = ' and S.beneficios3 LIKE "%'.$dados['beneficios3'].'%" '; 

    //busca pelo informacoes
   //  $buscaIcone3 = '';
   //  if (array_key_exists('icone3',$dados) && !empty($dados['icone3']) )
   //      $buscaIcone3 = ' and S.icone3 LIKE "%'.$dados['icone3'].'%" '; 
        
    //busca pelo informacoes
    $buscaTexto3 = '';
    if (array_key_exists('texto3',$dados) && !empty($dados['texto3']) )
        $buscaTexto3 = ' and S.texto3 LIKE "%'.$dados['texto3'].'%" '; 

    //busca pelo group by
    $group_by = "";
    if (array_key_exists('group_by',$dados) && !empty($dados['group_by']) )
        $group_by = ' GROUP BY '.$dados['group_by'];

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
    $colsSql = 'S.* ';
     
    if (array_key_exists('totalRecords',$dados)){
        $colsSql = ' count(DISTINCT S.idlinhas) as totalRecords';
        $buscaLimit = '';
        $orderBy = '';
        $group_by = '';
    } elseif (array_key_exists('colsSql',$dados)) {
        $colsSql = ' '.$dados['colsSql'].' ';
    }

    $sql = "SELECT $colsSql FROM linhas as S WHERE 1  
               $buscaId $buscaNotId $buscaNotInLinhas 
               $buscaNome $buscaUrlrewrite $buscaDestaque $buscaImagem
               $buscaImagem2 $buscaTitle $buscaDescription  $buscaKeywords
               $buscaStatus $buscaSlogan $buscaSlogan2 $buscaResumo  $buscaDescricao 
               $buscaBeneficio1 $buscaTexto1
               $buscaBeneficio2 $buscaTexto2
               $buscaBeneficio3 $buscaTexto3
               $group_by $orderBy $buscaLimit";

    $query = mysqli_query($conexao, $sql);
    $resultado = array();
    while ($r = mysqli_fetch_assoc($query)){
        $r = array_map('utf8_encode', $r); 
        if (!array_key_exists('totalRecords',$dados)){   	
                            $r["status_nome"] = ($r["status"] == 'A' ? "Ativo" : "Inativo");
                            $r["status_icone"] = "<img src='images/estrela" . ($r["status"] == 'A' ? "sim" : "nao") . ".png' class='icone inverteStatus' codigo='" . $r['idlinhas'] . "' width='20px' />";
            $r['caminhoimg'] = 'admin/files/linhas/'.$r['idlinhas']."/";
            
            $r['original'] = $r['caminhoimg']."original/".$r['imagem'];
            $r['thumb'] = $r['caminhoimg']."thumb_".$r['imagem'];
            $r['thumb2'] = $r['caminhoimg']."thumb2_".$r['imagem'];
            $r['thumb3'] = $r['caminhoimg']."thumb3_".$r['imagem'];
            $r['thumb4'] = $r['caminhoimg']."thumb4_".$r['imagem'];

            // $r['original'] = $r['caminhoimg']."original/".$r['imagem2'];
            // $r['thumb'] = $r['caminhoimg']."thumb_".$r['imagem2'];
            // $r['thumb2'] = $r['caminhoimg']."thumb2_".$r['imagem2'];
            // $r['thumb3'] = $r['caminhoimg']."thumb3_".$r['imagem2'];
            // $r['thumb4'] = $r['caminhoimg']."thumb4_".$r['imagem2'];
        }
        $resultado[] = $r;
    }
    return $resultado; 
 }

/**
 * <p>deleta linhas no banco</p>
 */
function deletaLinhas($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM linhas WHERE idlinhas = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function apagarImagemLinhas($imgs) {
   $path = 'files/linhas/';
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
?>