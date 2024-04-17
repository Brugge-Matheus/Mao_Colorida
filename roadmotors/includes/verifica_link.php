<?php
    include_once __DIR__.'/../admin/includes/functions.php';
    include_once __DIR__.'/../admin/valor_class.php';
    include_once __DIR__.'/../admin/valores_class.php';
    include_once __DIR__.'/../admin/banner_class.php';
    include_once __DIR__.'/../admin/equipe_class.php';
    include_once __DIR__.'/../admin/depoimento_class.php';
    include_once __DIR__.'/../admin/features_class.php';
    include_once __DIR__.'/../admin/diferenciais_class.php';
    include_once __DIR__.'/../admin/servicos_class.php';
    include_once __DIR__.'/../admin/seo_class.php';
    include_once __DIR__.'/../admin/integracoes_class.php';

    $integracoes = buscaIntegracoes(array('ordem'=>'idintegracoes','dir'=>'asc'));
    if(!empty($integracoes)){
        $googleApi = $integracoes[0]['token'];
        $googleMaps = $integracoes[1]['token'];
    }

    $MODULO = strtolower($MODULO);
    $MODULO = empty($MODULO)?'home':$MODULO;

    $REQUEST_P = empty($_REQUEST['p'])?'home':$_REQUEST['p'];

    if ($MODULO == 'home'){
        $equipe = buscaEquipe(array('status'=>1));
        $depoimento = buscaDepoimento(array('status' => 1));
        $features = buscaFeatures(array('ordem' => 'ordem', 'dir' => 'asc'));
        $diferenciais = buscaDiferenciais(array('status' => 'A'));
        $servicos = buscaServicos(array('status' => 'A'));
        $banners = buscaBanner(array('status' => '1'));

        $valor = buscaValor(array('status' => '1'));
        $v = $valor[0];
        
        $valores = buscaValores(array('idvalor' => $v['idvalor']));
    }
    else{
        $MODULO = '404';
        $REQUEST_P = '404';
    }

    // ================SEO================= 
    $seo = buscaSeo(array('urlrewrite'=>$REQUEST_P));
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