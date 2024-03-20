<?php
    include_once __DIR__.'/../admin/includes/functions.php';
    include_once __DIR__.'/../admin/blog_post_class.php';
    include_once __DIR__.'/../admin/blog_categoria_class.php';
    include_once __DIR__.'/../admin/blog_tags_class.php';
    include_once __DIR__.'/../admin/blog_comentarios_class.php';
    include_once __DIR__.'/../admin/banner_class.php';
    include_once __DIR__.'/../admin/seo_class.php';
    include_once __DIR__.'/../admin/equipe_class.php';
    include_once __DIR__.'/../admin/timeline_class.php';
    include_once __DIR__.'/../admin/segmento_class.php';
    include_once __DIR__.'/../admin/segmento_diferenciais_class.php';
    include_once __DIR__.'/../admin/features_class.php';
    include_once __DIR__.'/../admin/integracoes_class.php';
    include_once __DIR__.'/../admin/documentos_class.php';
    include_once __DIR__.'/../admin/produto_class.php';
    include_once __DIR__.'/../admin/categoria_class.php';
    include_once __DIR__.'/../admin/marcas_class.php';
    include_once __DIR__.'/../admin/linhas_class.php';

 
    $integracoes = buscaIntegracoes(array('ordem'=>'idintegracoes','dir'=>'asc'));
    if(!empty($integracoes)){
        $googleApi = $integracoes[0]['token'];
        $googleMaps = $integracoes[1]['token'];
    }

    $MODULO = strtolower($MODULO);
    $MODULO = empty($MODULO)?'home':$MODULO;

    $REQUEST_P = empty($_REQUEST['p'])?'home':$_REQUEST['p'];

    if ($MODULO == 'home'){
        $linhas = buscaLinhas(array('status' => 'A'));

        $segmentos = buscaSegmento(array('status' => '1'));

        $banner = buscaBanner(array('status' => '1'));

        $marcas = buscaMarcas(array('status' => 'A'));

        $lancamentos = buscaProduto(array('status' => 'A', 'ordem' => 'idproduto', 'dir' => 'desc','limit' => 8));

        $blog = buscaBlog_post(array('status' => '1', 'ordem' => 'data_hora', 'dir' => 'desc','limit' => 3));

    }
    elseif($MODULO == 'contato'){

    }
    elseif($MODULO == 'cadastro'){

    }
    elseif($MODULO == 'orcamento'){

    }
    elseif($MODULO == 'produtos'){
        $produtos = buscaProduto(array('status' => 'A'));
        $categorias = buscaCategoria(array('status' => 'A'));
        $marcas = buscaMarcas(array('status' => 'A'));
        // $resultadoBusca = buscaProduto(array('status' => 'A', 'totalRecords' => true));
        // $totais = reset($resultadoBusca);

        $search = !empty( $_REQUEST["search"] ) ? $_REQUEST["search"] : null;

        if(!empty($search))
        {
            $produtos = buscaProduto(array('search' => $search, 'ordem'=>'nome', 'dir'=>'asc', 'limit'=>$limit, "pagina" => (!empty($pagina) ? ( $pagina - 1 ) : null) ));
            $totaisBusca = buscaProduto( array( "totalRecords"=> true, 'search' => $search));
            $totais = reset($totaisBusca);

        }
        else if( $_SESSION['idu'] == 'linhas' && !empty($_SESSION['extra']))
        {
             $urlrewrite = $_SESSION['extra'];
             $linhas = buscaLinhas(array('urlrewrite' => $urlrewrite));
             $li = $linhas[0];
             $categorias = buscaCategoria(array('idlinhas' => $li['idlinhas']));

             $urlpag = ENDERECO."/produtos/linhas/".$_SESSION['extra'];
             $produtos = buscaProduto(array('idlinhas' => $li['idlinhas'], 'status'=>'A', 'limit'=>$limit, "pagina" => (!empty($pagina) ? ( $pagina - 1 ) : null) ));
             $totaisBusca = buscaProduto( array('idlinhas' => $li['idlinhas'], "totalRecords"=> true, 'status'=> 'A',   "limit"=> $limit, "ordem"=> $ordem, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null ));
             $totais = reset($totaisBusca);

        }
        else if( $_SESSION['idu'] == 'categoria' && !empty($_SESSION['extra']) )
        {
            $urlrewrite = $_SESSION['extra'];
            $categoria = buscaCategoria(array('urlrewrite' => $urlrewrite));
            $catb = $categoria[0];

            $idlinha = $catb['idlinhas'];
            $linha = buscaLinhas(array('idlinhas' => $idlinha));
            $li1 = $linha[0];

            $categorias = buscaCategoria(array('idlinhas' => $li1['idlinhas']));

            $urlpag = ENDERECO."/produtos/categoria/".$_SESSION['extra'];
            $produtos = buscaProduto(array('categoria' => $_SESSION['extra'], 'ordem'=>'nome', 'dir'=>'asc', 'limit'=>$limit, "pagina" => (!empty($pagina) ? ( $pagina - 1 ) : null) ));
            $totaisBusca = buscaProduto( array( 'categoria' => $_SESSION['extra'], "totalRecords"=> true, 'status'=> 'A',   "limit"=> $limit, "ordem"=> $ordem, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null ));
            $totais = reset($totaisBusca);
        
        }
        else if( $_SESSION['idu'] == 'marcas' && !empty($_SESSION['extra']) )
        {
            $urlrewrite = $_SESSION['extra'];
            
            $marca = buscaMarcas(array('urlrewrite' => $urlrewrite));
            $m = $marca[0];

            $urlpag = ENDERECO."/produtos/marca/".$_SESSION['extra'];
            $produtos = buscaProduto(array('idmarcas' => $m['idmarcas'], 'ordem'=>'nome', 'dir'=>'asc', 'limit'=>$limit, "pagina" => (!empty($pagina) ? ( $pagina - 1 ) : null) ));
            $totaisBusca = buscaProduto( array( 'idmarcas' => $m['idmarcas'], "totalRecords"=> true, 'status'=> 'A',   "limit"=> $limit, "ordem"=> $ordem, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null ));
            $totais = reset($totaisBusca);
        
        }
        else if( !empty($_SESSION['idu']) && empty($_SESSION['extra']) )
        {
            //produto interno
            $produto = buscaProduto(array('urlrewrite'=>$_SESSION['idu']));
            $produtos_relacionados = buscaProduto(array('status' => 'A'));
            
            if(!empty($produto)){
                $produto_imagens = buscaProduto_imagem(array("idproduto" => $produto[0]['idproduto'], "ordem" => 'posicao_imagem', "dir" => 'ASC'));
                $produto = $produto[0];
                
                $MODULO = 'produto-interna';
            }else{
                $produtos = buscaProduto(array( 'ordem'=>'nome', 'dir'=>'asc', 'limit'=>$limit, "pagina" => (!empty($pagina) ? ( $pagina - 1 ) : null) ));
                $totais = reset( buscaProduto( array( "totalRecords"=> true, 'status'=> 'A',   "limit"=> $limit, "ordem"=> $ordem, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null )));
            };
        }
    }
    elseif($MODULO == 'pedido'){

    }
    elseif($MODULO == 'renomear'){

    }
    elseif($MODULO == 'revendedor'){
        $documentos = buscaDocumentos(array('status' => 'A'));
        $features = buscaFeatures(array('status' => 1));

    }
    elseif($MODULO == 'sobre'){
        $equipe = buscaEquipe(array('status' => 1));
        $timeline = buscaTimeline(array('status' => '1'));
        $features = buscaFeatures(array('status' => 1));

    }
    elseif($MODULO == 'segmento'){
       $url = $_SESSION['idu'];
       $segmento = buscaSegmento(array('urlrewrite' => $url));
       $s1 = $segmento[0];

       $idsegmento = $s['idsegmento'];
       
       $relacionados = buscaProduto(array('idsegmento' => $idsegmento));

       $diferenciais = buscaSegmento_diferenciais(array('idsegmento' => $idsegmento, 'status' => '1'));

       $produtos = buscaProduto(array('status' => 'A', 'idsegmento' => $idsegmento));

       $marcas = buscaMarcas(array('status' => 'A'));
    }
    elseif($MODULO == 'blog'){ 
        $pagina = preg_match('/\d/', $_SESSION["idu"]) ? $_SESSION["idu"] : $_SESSION["extra"];
        $pagina = !empty( $pagina ) && is_numeric( $pagina ) ? $pagina : 1;
        $limit = 9;
        $ordem = 'idblog_post ';
        $pag = 0;
        $interna = false;
        $urlrewrite = "";
        $posts = buscaBlog_post(array('status' => '1', 'ordem' => 'idblog_post', 'dir' => 'desc', 'limit' => 3));
        $maisLidos = buscaBlog_post(array('status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
        $arquivos_blog = buscaBlog_post(array('busca4data'=>true));
        $verifica_post = buscaBlog_post(array('urlrewrite'=>$_SESSION['idu']));
        $verfica_categoria_post = buscaBlog_categoria(array('urlrewrite'=>$_SESSION['idu']));
        $verifica_tags_post = buscaBlog_tags(array('urlrewrite'=>$_SESSION['idu']));

        $postsdestaque = buscaBlog_post(array('status'=>'1','ordem' => $ordem ,'dir' => 'desc' ,'limite'=> 3));

        $totalBlog = buscaBlog_post(array('status' => 1, 'limit' => $limit, 'ordem' => $ordem,'dir' => $dir, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null,));

        $busca = buscaBlog_post( array(
            "totalRecords" => true,
            'status' => 1,
            "limit" => $limit,
            "ordem" => $ordem,
            "pagina" => !empty($pagina) ? ($pagina - 1) : null,
        ));
        
        $totais = reset($busca);

        $urlpag = ENDERECO."blog";

        //==Subitens do Menu Blog ==//
        $categorias = buscaBlog_categoria(array('status' => 1));
        $tags = buscaBlog_tags(array('status' => 1));
        $categoria_blog = buscaBlog_categoria(array('inner_post'=>true));
        $maisLidos = buscaBlog_post(array('status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
        $arquivos = buscaBlog_post(array('busca4data'=>true));
    
        $totalBlog = array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'totalRecords'=>true, 'pagina'=>$pag);

        if (!empty($verifica_post) && !empty($_SESSION['idu']) && empty($verfica_categoria_post)){
            $MODULO = 'blog-interna';
            $interna = true;
            $post = buscaBlog_post(array('urlrewrite'=>$_SESSION['idu']));
            $p = $post[0];
            if(isset($p['idblog_post'])){
                $postGaleria = buscaBlog_post_imagem(array('idblog_post'=>$p['idblog_post']));
            }else{
                $postGaleria = array();
            }
            UpdateContador(array('idblog_post'=> $p['idblog_post']));
            $comen = buscaBlog_comentarios(array('idblog_post'=>$p['idblog_post'], 'status'=>2));
            $relacionados = buscaBlog_post(array('limit'=>4, 'not_idblog_post'=>$p['idblog_post'], 'status'=>'1', 'idblog_categoria'=>$p['idblog_categoria']));
            $galeria = buscaBlog_post_imagem(array('idblog_post' => $p['idblog_post']));
            $idcat = $p['idblog_categoria'];
            $idtag = $p['tags'];
            $cate = buscaBlog_categoria(array('idblog_categoria' => $idcat));
            $tags = buscaBlog_tags(array('idblog_tags' => $idtag));
        }
        if(!empty($_SESSION['idu']) && is_numeric($_SESSION['idu'])){
            if($_SESSION['idu'] == 1)
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location:".ENDERECO."blog");
            }
            $pag = $_SESSION['idu'] - 1;
        }else if($_SESSION['idu'] == 'arquivos'){
                $interna = false;
                $MODULO = 'blog';
        }
        if(!$interna){
            if(isset($_POST['busca_blog'])){
                $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora', 'dir'=>'DESC', 'limit'=>$limit, 'nome'=>$_POST['    busca_blog'], 'pagina'=>$pag));
                $totalBlog['nome'] = $_POST['busca_blog'];
                $termoBusca = $_POST['busca_blog'];
            }
            else if (!empty($_SESSION['idu']) && !empty($verfica_categoria_post)){
                $vcp =  $verfica_categoria_post[0];
                $pag = !empty($_SESSION['extra']) ? (int)$_SESSION['extra'] -1 : 0;
                $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'idblog_categoria'=>$vcp['idblog_categoria'], 'pagina'=>$pag));
                $totalBlog['idblog_categoria'] = $vcp['idblog_categoria'];
    
            }else if (!empty($_SESSION['idu']) && !empty($verifica_tags_post)){
                $vtp =  $verifica_tags_post[0];
                $pag = !empty($_SESSION['extra']) ? (int)$_SESSION['extra'] -1 : 0;
                $posts = buscaBlog_post(array('status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'tags'=>$vtp['idblog_tags'], 'pagina'=>$pag));
    
            }else if($_SESSION['idu'] == 'arquivos'){

                $pag = !empty($_SESSION['extra2']) ? (int)$_SESSION['extra2'] -1 : 0;
                $totalBlog['dataBusca'] = $_SESSION['extra'];
                $posts = buscaBlog_post(array('limit'=>$limit, 'pagina'=>$pag, 'dataBusca'=>$_SESSION['extra']));

            }else if($_SESSION['idu'] == 'categoria'){
                $categoria_blog1 = buscaBlog_categoria(array('urlrewrite' => $_SESSION['extra']));
                $categoria1 = $categoria_blog1[0];
                $posts = buscaBlog_post(array('idblog_categoria' => $categoria1['idblog_categoria'], 'status'=>'1', 'ordem'=> $ordem, 'dir'=> 'desc', 'limit' => $limit, 'pagina' => $pag));
                
                $totalBlog = buscaBlog_post(array('status' => 1, 'limit' => $limit, 'ordem' => $ordem,'dir' => $dir, "pagina" => !empty($pagina) ? ( $pagina - 1 ) : null,));

                $busca = buscaBlog_post( array(
                    "totalRecords" => true,
                    'status' => 1,
                    "limit" => $limit,
                    "ordem" => $ordem,
                    "pagina" => !empty($pagina) ? ($pagina - 1) : null,
                ));
                
                $totais = reset($busca);
        
                $urlpag = ENDERECO."blog";
    
            }else{

                $posts = buscaBlog_post(array('status'=>'1', 'ordem'=> $ordem, 'dir'=> 'desc', 'limit' => $limit, 'pagina' => $pag));

            };
    
            //busca total de postagens
            $totalBlog = buscaBlog_post($totalBlog);
            $totalBlog = $totalBlog[0]['totalRecords'];
            $totalPaginas = ceil($totalBlog / $limit);
            $total = $totalPaginas;
            $urlpag = ENDERECO."blog".$urlrewrite;
        }
    }
    else{
        $MODULO = '404';
        $REQUEST_P = '404';
    }
//     else{
//      header("HTTP/1.1 301 Moved Permanently");
//      header("Location:".ENDERECO);
//    }


   // ================SEO================= 
    // $seo = buscaSeo(array('urlrewrite'=>$REQUEST_P));
    if(!empty($seo)){
        $seo = $seo[0];
    }else{
        switch ($MODULO) {
            case 'home':
                $seo['title'] = '';
                $seo['description'] = '';
                $seo['keywords'] = '';
                break;
            
            default:
                $seo['title'] = '';
                $seo['description'] = '';
                $seo['keywords'] = '';
                break;
        }
    }
?>