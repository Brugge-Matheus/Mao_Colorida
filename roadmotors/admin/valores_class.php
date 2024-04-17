<?php
// Versao do modulo: 3.00.010416


/**
 * <p>salva valores no banco</p>
 */
function cadastroValores($dados){
   include "includes/mysql.php";

   foreach ($dados AS $k => &$v) {
        if (is_array($v)) continue;
        // if (get_magic_quotes_gpc()) 
        $v = stripslashes($v);
        $v = mysqli_real_escape_string($conexao, utf8_decode($v));
     }

   $sql = "INSERT INTO valores (idvalor,nome,texto,icone,icone_name,status) VALUES (
           '".$dados['idvalor']."',
           '".$dados['nome']."',
           '".$dados['texto']."',
           '".$dados['icone']."',
           '".$dados['icone_name']."',
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
   * <p>Edita Valores no banco</p>
   */

 function editValores($dados){
     include "includes/mysql.php";

     foreach ($dados AS $k => &$v) {
       // if (is_array($v)) continue;
        $v = stripslashes($v);
        $v = mysqli_real_escape_string($conexao, utf8_decode($v));
     }

   $sql = "UPDATE valores SET
              idvalor = '".$dados['idvalor']."',
              nome = '".$dados['nome']."',
              texto = '".$dados['texto']."',
              icone = '".$dados['icone']."',
              icone_name = '".$dados['icone_name']."',
              status = '".$dados['status']."'
           WHERE idvalores = ".$dados['idvalores'];
     if (mysqli_query($conexao, $sql)) {
     return $dados['idvalores'];
  } else {
     return false;
  }
 }

 /**
   * <p>Busca Valores no banco</p>
   */

 function buscaValores($dados){
   include "includes/mysql.php";

   foreach ($dados AS $k => &$v) {
        if (is_array($v) || $k == "colsSql") continue;
           $v = stripslashes($v);
        $v = mysqli_real_escape_string($conexao, utf8_decode($v));
     }

  //busca pelo id
  $buscaId = '';
  if (array_key_exists('idvalores',$dados) && !empty($dados['idvalores']) )
     $buscaId = ' and idvalores = '.intval($dados['idvalores']).' ';

        //busca pelo id
  $buscaIdNot = '';
  if (array_key_exists('not_idvalores',$dados) && !empty($dados['not_idvalores']) )
     $buscaIdNot = ' and idvalores != '.intval($dados['not_idvalores']).' ';
  
       //busca pelo id
  $buscaIdvalor = '';
  if (array_key_exists('idvalor',$dados) && !empty($dados['idvalor']) )
     $buscaIdvalor = ' and idvalor = '.intval($dados['idvalor']).' ';

  //busca pelo nome
  $buscaNome = '';
  if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
     $buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" ';

  //busca pelo status
  $buscaStatus = '';
  if (array_key_exists('status',$dados) && !empty($dados['status']) )
     $buscaStatus = ' and status = "'.$dados['status'].'" ';
     
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
     $colsSql = ' count(idvalores) as totalRecords';
     $buscaLimit = '';
     $orderBy = '';
  } elseif (array_key_exists('colsSql',$dados)) {
     $colsSql = ' '.$dados['colsSql'].' ';
  } 

  $sql = "SELECT $colsSql FROM valores WHERE 1  $buscaId $buscaIdvalor $buscaIdNot $buscaNome $buscaStatus $orderBy $buscaLimit ";

  $query = mysqli_query($conexao, $sql);
  $resultado = array();
  
  while ($r = mysqli_fetch_assoc($query)){
     $r = array_map('utf8_encode', $r);

     if (!array_key_exists('totalRecords',$dados)){
        $r["status_nome"] = ($r["status"]=='A' ? "Ativo":"Inativo");
        $r["status_icone"] = ($r["status"]=='A' ? "<img src='images/estrelasim.png' class='icone inverteStatus' codigo='".$r['idvalores']."' width='20px' />":"<img src='images/estrelanao.png' class='icone inverteStatus' codigo='".$r['idvalores']."' width='20px'/>"); 				
     }        
     $resultado[] = $r;
  } 
  return $resultado;

 }


 /**
 * 
 * <p>deleta valores no banco</p>
 */
function deletaValores($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM valores WHERE idvalores = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}

function apagarImagemValores($imgs) {
   $path = 'files/valores/';
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