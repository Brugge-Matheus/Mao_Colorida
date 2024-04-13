<?php
    // include_once __DIR__.'/../admin/includes/functions.php';
    // include_once __DIR__.'/../admin/blog_post_class.php';
    // include_once __DIR__.'/../admin/blog_categoria_class.php';
    // include_once __DIR__.'/../admin/blog_tags_class.php';
    // include_once __DIR__.'/../admin/blog_comentarios_class.php';
    // include_once __DIR__.'/../admin/banner_class.php';
    // include_once __DIR__.'/../admin/seo_class.php';
    // include_once __DIR__.'/../admin/integracoes_class.php';

    // $integracoes = buscaIntegracoes(array('ordem'=>'idintegracoes','dir'=>'asc'));
    // if(!empty($integracoes)){
    //     $googleApi = $integracoes[0]['token'];
    //     $googleMaps = $integracoes[1]['token'];
    // }

    // $MODULO = strtolower($MODULO);
    // $MODULO = empty($MODULO)?'home':$MODULO;

    // $REQUEST_P = empty($_REQUEST['p'])?'home':$_REQUEST['p'];

    // if ($MODULO == 'home'){
    //     $banner = buscaBanner(array('status'=>1, 'ordem'=>'ordem', 'dir'=>'asc'));
    //     $maisRecentes = buscaBlog_post(array('status'=>'1', 'ordem'=>'data_hora', 'dir'=>'desc', 'limit'=>3));
    // }
    // elseif($MODULO == 'contato'){

    // }
    // elseif($MODULO == 'blog'){
    //     $limit = 3;
    //     $pag = 0;
    //     $interna = false;
    //     $urlrewrite = "";
    //     $maisLidos = buscaBlog_post(array('status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
    //     $arquivos_blog = buscaBlog_post(array('busca4data'=>true));
    //     $verifica_post = buscaBlog_post(array('urlrewrite'=>$_SESSION['idu']));
    //     $verfica_categoria_post = buscaBlog_categoria(array('urlrewrite'=>$_SESSION['idu']));
    //     $verifica_tags_post = buscaBlog_tags(array('urlrewrite'=>$_SESSION['idu']));
    
    //     //==Subitens do Menu Blog ==//
    //     $categorias = buscaBlog_categoria(array('status' => 1));
    //     $tags = buscaBlog_tags(array('status' => 1));
    //     $categoria_blog = buscaBlog_categoria(array('inner_post'=>true));
    //     $maisLidos = buscaBlog_post(array('status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
    //     $arquivos = buscaBlog_post(array('busca4data'=>true));
    
    //     $totalBlog = array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'totalRecords'=>true, 'pagina'=>$pag);
    
    //     if (!empty($verifica_post) && !empty($_SESSION['idu']) && empty($verfica_categoria_post)){
    //         $MODULO = 'blog-interna';
    //         $interna = true;
    //         $post = buscaBlog_post(array('urlrewrite'=>$_SESSION['idu']));
    //         $p = $post[0];
    //         if(isset($p['idblog_post'])){
    //             $postGaleria = buscaBlog_post_imagem(array('idblog_post'=>$p['idblog_post']));
    //         }else{
    //             $postGaleria = array();
    //         }
    //         UpdateContador(array('idblog_post'=> $p['idblog_post']));
    //         $comen = buscaBlog_comentarios(array('idblog_post'=>$p['idblog_post'], 'status'=>2));
    //         $relacionados = buscaBlog_post(array('limit'=>4, 'not_idblog_post'=>$p['idblog_post'], 'status'=>'1', 'idblog_categoria'=>$p['idblog_categoria']));
    //         $galeria = buscaBlog_post_imagem(array('idblog_post' => $p['idblog_post']));
    //     }
    //     if(!empty($_SESSION['idu']) && is_numeric($_SESSION['idu'])){
    //         if($_SESSION['idu'] == 1)
    //         {
    //             header("HTTP/1.1 301 Moved Permanently");
    //             header("Location:".ENDERECO."blog");
    //         }
    //         $pag = $_SESSION['idu'] - 1;
    //     }else if($_SESSION['idu'] == 'arquivos'){
    //             $interna = false;
    //             $MODULO = 'blog';
    //     }
    //     if(!$interna){
    //         if(isset($_POST['busca_blog'])){
    //             $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora', 'dir'=>'DESC', 'limit'=>$limit, 'nome'=>$_POST['    busca_blog'], 'pagina'=>$pag));
    //             $totalBlog['nome'] = $_POST['busca_blog'];
    //             $termoBusca = $_POST['busca_blog'];
    //         }
    //         else if (!empty($_SESSION['idu']) && !empty($verfica_categoria_post)){
    //             $vcp =  $verfica_categoria_post[0];
    //             $pag = !empty($_SESSION['extra']) ? (int)$_SESSION['extra'] -1 : 0;
    //             $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'idblog_categoria'=>$vcp['idblog_categoria'], 'pagina'=>$pag));
    //             $totalBlog['idblog_categoria'] = $vcp['idblog_categoria'];
    
    //         }else if (!empty($_SESSION['idu']) && !empty($verifica_tags_post)){
    //             $vtp =  $verifica_tags_post[0];
    //             $pag = !empty($_SESSION['extra']) ? (int)$_SESSION['extra'] -1 : 0;
    //             $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'tags'=>$vtp['idblog_tags'], 'pagina'=>$pag));
    //             // $totalBlog['idblog_categoria'] = $vtp['idblog_categoria'];
    
    //         }else if($_SESSION['idu'] == 'arquivos'){
    //             // echo '<pre>';var_dump($_SESSION['extra']);exit;
    //             $pag = !empty($_SESSION['extra2']) ? (int)$_SESSION['extra2'] -1 : 0;
    //             $totalBlog['dataBusca'] = $_SESSION['extra'];
    //             $posts = buscaBlog_post(array('limit'=>$limit, 'pagina'=>$pag, 'dataBusca'=>$_SESSION['extra']));
    //         }else{
    //             $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora', 'dir'=> 'desc', 'limit'=>$limit, 'pagina'=>$pag));
    //         };
    
    //         //busca total de postagens
    //         $totalBlog = buscaBlog_post($totalBlog);
    //         $totalBlog = $totalBlog[0]['totalRecords'];
    //         $totalPaginas = ceil($totalBlog / $limit);
    //         $total = $totalPaginas;
    //         $urlpag = ENDERECO."blog".$urlrewrite;
    //     }
    // }
    // else{
    //     $MODULO = '404';
    //     $REQUEST_P = '404';
    // }
   //  else{
   //   header("HTTP/1.1 301 Moved Permanently");
   //   header("Location:".ENDERECO);
   // }


    // ================SEO================= 
    // $seo = buscaSeo(array('urlrewrite'=>$REQUEST_P));
    // if(!empty($seo)){
    //     $seo = $seo[0];
    // }else{
    //     switch ($MODULO) {
    //         case 'home':
    //             $seo['title'] = '';
    //             $seo['description'] = '';
    //             $seo['keywords'] = '';
    //             break;
            
    //         default:
    //             $seo['title'] = '';
    //             $seo['description'] = '';
    //             $seo['keywords'] = '';
    //             break;
    //     }
    // }
?>