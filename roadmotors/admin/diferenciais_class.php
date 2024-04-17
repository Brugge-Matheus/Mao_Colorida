<?php
// Versao do modulo: 3.00.010416
/**
 * <p>salva diferenciais no banco</p>
 */
function cadastroDiferenciais($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $dados['nome'] = trim($dados['nome']);

	$sql = "INSERT INTO diferenciais(nome, titulo, resumo, imagem,status) VALUES (
                '".$dados['nome']."',
                '".$dados['titulo']."',
                '".$dados['resumo']."',
                '".$dados['imagem']."',
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
 * <p>edita diferenciais no banco</p>
 */
function editDiferenciais($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		// if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

   $sql = "UPDATE diferenciais SET
                nome = '".$dados['nome']."',
                titulo = '".$dados['titulo']."',
                resumo = '".$dados['resumo']."',
                imagem = '".$dados['imagem']."',
                status = '".$dados['status']."'
            WHERE iddiferenciais = " . $dados['iddiferenciais'];

	if (mysqli_query($conexao, $sql)) {
		return $dados['iddiferenciais'];
	} else {
		return false;
	}
}

/**
 * <p>busca diferenciais no banco</p>
 */
function buscaDiferenciais($dados = array())
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
    if (array_key_exists('iddiferenciais',$dados) && !empty($dados['iddiferenciais']) )
        $buscaId = ' and S.iddiferenciais = '.intval($dados['iddiferenciais']).' '; 

            //busca pelo id
    $buscaNome = '';
    if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
        $buscaNome = ' and S.nome = '.intval($dados['nome']).' '; 

    //busca pelo imagem
    $buscaImagem = '';
    if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
        $buscaImagem = ' and S.imagem LIKE "%'.$dados['imagem'].'%" '; 

        //busca pelo status
    $buscaStatus = '';
    if (array_key_exists('status',$dados) && !empty($dados['status']) )
        $buscaStatus = ' and S.status = "'.$dados['status'].'" ';

    //busca pelo resumo
    $buscaResumo = '';
    if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
        $buscaResumo = ' and resumo LIKE "%'.$dados['resumo'].'%" '; 

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
        $colsSql = ' count(DISTINCT S.iddiferenciais) as totalRecords';
        $buscaLimit = '';
        $orderBy = '';
        $group_by = '';
    } elseif (array_key_exists('colsSql',$dados)) {
        $colsSql = ' '.$dados['colsSql'].' ';
    }

    $sql = "SELECT $colsSql FROM diferenciais as S WHERE 1  
               $buscaId $buscaNome
                $buscaImagem
               $buscaStatus 
               $group_by $orderBy $buscaLimit";

    $query = mysqli_query($conexao, $sql);
    $resultado = array();
    while ($r = mysqli_fetch_assoc($query)){
        $r = array_map('utf8_encode', $r); 
        if (!array_key_exists('totalRecords',$dados)){   	
            $r["status_nome"] = ($r["status"] == 'A' ? "Ativo" : "Inativo");
            $r["status_icone"] = "<img src='images/estrela" . ($r["status"] == 'A' ? "sim" : "nao") . ".png' class='icone inverteStatus' codigo='" . $r['iddiferenciais'] . "' width='20px' />";
            $r['caminhoimg'] = 'admin/files/diferenciais/'.$r['iddiferenciais']."/";
            
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
 * <p>deleta diferenciais no banco</p>
 */
function deletaDiferenciais($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM diferenciais WHERE iddiferenciais = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function apagarImagemDiferenciais($imgs) {
   $path = 'files/diferenciais/';
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

/*===============================================Diferenciais_faq===================================================*/

function cadastroDiferenciais_faq($dados)
{

	include "includes/mysql.php";

	foreach ($dados AS $k => &$v) {
		if (is_array($v)) continue;
		$v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	if(!empty($dados['pergunta']) || !empty($dados['resposta'])){

		$dados['pergunta'] = trim($dados['pergunta']);
		$dados['resposta'] = trim($dados['resposta']);

		$sql = "INSERT INTO diferenciais_faq(iddiferenciais, pergunta, resposta, ordem) VALUES (
						'".$dados['iddiferenciais']."',
						'".$dados['pergunta']."',
						'".$dados['resposta']."',
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
 * <p>edita diferenciais_faq no banco</p>
 */
function editDiferenciais_faq($dados)
{
	include "includes/mysql.php";

	foreach ($dados AS $k => &$v) {
		if (is_array($v)) continue;
		$v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	$dados['pergunta'] = trim($dados['pergunta']);
	$dados['resposta'] = trim($dados['resposta']);

	$sql = "UPDATE diferenciais_faq SET
					pergunta = '".$dados['pergunta']."',
					resposta = '".$dados['resposta']."',
					ordem = '".$dados['ordem']."'
				WHERE iddiferenciais = ".$dados['iddiferenciais']."
				AND iddiferenciais_faq = ".$dados['iddiferenciais_faq'];

	if (mysqli_query($conexao, $sql)) {
		return $dados['iddiferenciais_faq'];
	} else {
		return false;
	}
}

/**
 * <p>busca diferenciais_faq no banco</p>
 */
function buscaDiferenciais_faq($dados = array())
{
	include "includes/mysql.php";

	foreach ($dados AS $k => &$v) {
		if (is_array($v) || $k == "colsSql") continue;
		$v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	//busca pelo id
	$buscaId = '';
	if (array_key_exists('iddiferenciais_faq',$dados) && !empty($dados['iddiferenciais_faq']) )
		$buscaId = ' and iddiferenciais_faq = '.intval($dados['iddiferenciais_faq']).' '; 

	//busca pelo iddiferenciais
	$buscaIdDiferenciais = '';
	if (array_key_exists('iddiferenciais',$dados) && !empty($dados['iddiferenciais']) )
		$buscaIdDiferenciais = ' and iddiferenciais = '.$dados['iddiferenciais'].' '; 

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
		$colsSql = ' count(iddiferenciais_faq) as totalRecords';
		$buscaLimit = '';
		$orderBy = '';
	} elseif (array_key_exists('colsSql',$dados)) {
		$colsSql = ' '.$dados['colsSql'].' ';
	}

	$sql = "SELECT $colsSql FROM diferenciais_faq WHERE 1 $buscaId $buscaIdDiferenciais $orderBy $buscaLimit ";

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
 * <p>deleta diferenciais_faq no banco a partir da edição</p>
 */
function deletaDiferenciais_faq2($dados,$dados2)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM diferenciais_faq WHERE iddiferenciais = $dados AND iddiferenciais_faq = $dados2";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

/**
 * <p>deleta diferenciais_faq no banco</p>
 */
function deletaDiferenciais_faq($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM diferenciais_faq WHERE iddiferenciais = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function editOrdemDiferenciais_faq($dados)
{
	include "includes/mysql.php";
   
	$sql = "UPDATE diferenciais_faq SET                 
					ordem = '".$dados['ordem']."'                       
				WHERE iddiferenciais_faq = " . $dados['iddiferenciais_faq'];
	
	if (mysqli_query($conexao, $sql)) {
		return $dados['iddiferenciais_faq'];
	} else {
		return false;
	}
}

// Fim Diferenciais_faq

/*************************************************/
/******************* GALERIA *********************/
/*************************************************/

   /**
    * <p>busca diferenciais_imagem no banco</p>
    */
   function buscaDiferenciais_imagem($dados = array())
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v) || $k == "colsSql") continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }


      //busca pelo id
      $buscaId = '';
      if (array_key_exists('iddiferenciais_imagem',$dados) && !empty($dados['iddiferenciais_imagem']) )
         $buscaId = ' and iddiferenciais_imagem = '.intval($dados['iddiferenciais_imagem']).' ';

      //busca pelo iddiferenciais
      $buscaIddiferenciais = '';
      if (array_key_exists('iddiferenciais',$dados) && !empty($dados['iddiferenciais']) )
         $buscaIddiferenciais = ' and iddiferenciais = "'.$dados['iddiferenciais'].'" ';


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
         $colsSql = ' count(iddiferenciais_imagem) as totalRecords';
           $buscaLimit = '';
           $orderBy = '';
       } elseif (array_key_exists('colsSql',$dados)) {
         $colsSql = ' '.$dados['colsSql'].' ';
      }

      $sql = "SELECT $colsSql FROM diferenciais_imagem
            WHERE 1  $buscaId  $buscaIddiferenciais
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


   function cadastroDiferenciais_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }
      $sql = "INSERT INTO diferenciais_imagem( iddiferenciais, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem ,is_default) VALUES (
               '".$dados['iddiferenciais']."',
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
    * <p>edita diferenciais_imagem no banco</p>
    */
   function editDiferenciais_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $sql = "UPDATE diferenciais_imagem SET
                  iddiferenciais = '".$dados['iddiferenciais']."',
                  descricao_imagem = '".$dados['descricao_imagem']."',
                  urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
                  posicao_imagem = '".$dados['posicao_imagem']."',
                  is_default = '".$dados['is_default']."',
                  nome_imagem = '".$dados['nome_imagem']."',
                  m2y_imagem = '".$dados['m2y_imagem']."'
               WHERE iddiferenciais_imagem = " . $dados['iddiferenciais_imagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['iddiferenciais_imagem'];
      } else {
         return false;
      }
   }

   function editIdDiferenciais_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         // if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $sql = "UPDATE diferenciais_imagem SET
                  iddiferenciais = '".$dados['iddiferenciais']."'
               WHERE iddiferenciais_imagem = " . $dados['iddiferenciais_imagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['iddiferenciais_imagem'];
      } else {
         return false;
      }
   }

   function salvaImagemDiferenciais($dados){

      include_once "includes/functions.php";
      $dadosGravar = array();

      $iddiferenciais = $dados['iddiferenciais'];
      //urlrewrite
      $nomeimagem = explode('.', $dados['nome_imagem']);
      $nomeimagem = $nomeimagem[0];
      $dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);
      //atribuir m2y
      $urlrewrite = 'admin/files/diferenciais/'.$iddiferenciais.'/galeria/thumbnail/'.$dados['nome_imagem'];

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

      return cadastroDiferenciais_imagem($dados);
   }

    function alterarPosicaoImagemDiferenciais($dados){

      include "includes/mysql.php";

      $imagens = $dados['iddiferenciais_imagem'];
      $posicao = $dados['posicao_imagem'];
      $iddiferenciais = $dados['iddiferenciais'];

      if(!empty($imagens)){

         foreach($imagens as $k => $v){
            $sql = 'UPDATE diferenciais_imagem SET
                  posicao_imagem = "'.$posicao[$k].'",
                  is_default = 0
                  WHERE iddiferenciais_imagem = '.$v;

            mysqli_query($conexao, $sql);
         }

         $sql = 'UPDATE diferenciais_imagem SET is_default = 1 WHERE iddiferenciais = '.$iddiferenciais.' and posicao_imagem = 1';
               mysqli_query($conexao, $sql);
               return true;
      }else{
         return true;
      }
    }

  //APAGAR IMAGENS DA PASTA
   function apagarImagemBlogDiferenciais($imgs) {
      $path = 'files/diferenciais/galeria/';

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
   function deletarImagemBlogGaleriaDiferenciais($iddiferenciais_imagem, $idpost){

      include "includes/mysql.php";
      $return = false;

      $imagem = buscaDiferenciais_imagem(array("iddiferenciais_imagem"=>$iddiferenciais_imagem));

      apagarImagemBlogDiferenciais($imagem);

      $posicao = $imagem[0]['posicao_imagem'];
      $sql = 'DELETE from diferenciais_imagem WHERE iddiferenciais_imagem = '.$iddiferenciais_imagem;

      if (mysqli_query($conexao, $sql)) {
         //update nas posicao das imagens
         $sql = 'UPDATE diferenciais_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE iddiferenciais = '.$idpost.' and posicao_imagem > '.$posicao;
         if (mysqli_query($conexao, $sql)) {
            //marca a primeira posicao como default - caso apague q primeira imagem
            $sql = 'UPDATE diferenciais_imagem SET is_default = 1 WHERE iddiferenciais = '.$idpost.' and posicao_imagem = 1';
            mysqli_query($conexao, $sql);
            $return = true;
         }
      } else {
         $return = false;
      }

        return $return;
    }

    function apagarArquivoDiferenciais($arq) {
        if(file_exists($arq)){
            //apaga os arquivos que foram salvos
            $arquivo = $arq;
            if(file_exists($path.$arquivo)){
                unlink($path.$arquivo);
            }
        }
        return true;
    }

    function excluirArquivoDiferenciais($dados)
    {
       include "includes/mysql.php";
       if (!empty($dados)) {
            $sql = "UPDATE diferenciais SET
                     arquivo = ''
                  WHERE iddiferenciais = " . $dados['iddiferenciais'];

          if (mysqli_query($conexao, $sql)) {
             $num = mysqli_affected_rows($conexao);

             // $caminho = "files/diferenciais/arquivos/";
                
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