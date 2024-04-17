<?php 
     // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_VALOR") || define("CADASTRO_VALOR","cadastroValor");
defined("EDIT_VALOR") || define("EDIT_VALOR","editValor");
defined("DELETA_VALOR") || define("DELETA_VALOR","deletaValor");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA","alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO","alteraOrdemBaixo");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");

switch ($opx) {

    case CADASTRO_VALOR:
        include_once 'valor_class.php';

        $dados = $_REQUEST;
        $idValor = cadastroValor($dados);
        
        if (is_int($idValor)) {
            //salva log
            include_once 'log_class.php';
            $log['idusuario'] = $_SESSION['sgc_idusuario'];
            $log['modulo'] = 'valor';
            $log['descricao'] = 'Cadastrou valor ID('.$idValor.') title ('.$dados['title'].') description ('.$dados['description'].')';
            $log['request'] = $_REQUEST;
            novoLog($log);
            header('Location: index.php?mod=valor&acao=listarValor&mensagemalerta='.urlencode('Valor criado com sucesso!'));
        } else {
            header('Location: index.php?mod=valor&acao=listarValor&mensagemerro='.urlencode('ERRO ao criar novo Valor!'));
        }

    break;

    case EDIT_VALOR:
        include_once 'valor_class.php';

        $dados = $_REQUEST;
        $antigo = buscaValor(array('idvalor'=>$dados['idvalor']));
        $antigo = $antigo[0];

        $idValor = editValor($dados);

        if ($idValor != FALSE) {
            //salva log
            include_once 'log_class.php';
            $log['idusuario'] = $_SESSION['sgc_idusuario'];
            $log['modulo'] = 'valor';
            $log['descricao'] = 'Editou valor ID('.$idValor.') DE  title ('.$antigo['title'].') description ('.$antigo['description'].') PARA  title ('.$dados['title'].') description ('.$dados['description'].')';
            $log['request'] = $_REQUEST;
            novoLog($log);
            header('Location: index.php?mod=valor&acao=listarValor&mensagemalerta='.urlencode('Valor salvo com sucesso!'));
        } else {
            header('Location: index.php?mod=valor&acao=listarValor&mensagemerro='.urlencode('ERRO ao salvar Valor!'));
        }

    break;

    case DELETA_VALOR:
        include_once 'valor_class.php';
        include_once 'usuario_class.php';

        if (!verificaPermissaoAcesso('valor_deletar', $_SESSION['sgc_idusuario'])){
            header('Location: index.php?mod=valor&acao=listarValor&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
            exit;
        } else {
            $dados = $_REQUEST;
            $antigo = buscaValor(array('idvalor'=>$dados['idu']));

            if (deletaValor($dados['idu']) == 1) {
                //salva log
                include_once 'log_class.php';
                $log['idusuario'] = $_SESSION['sgc_idusuario'];
                $log['modulo'] = 'valor';
                $log['descricao'] = 'Deletou valor ID('.$dados['idu'].') ';
                $log['request'] = $_REQUEST;
                novoLog($log);
                header('Location: index.php?mod=valor&acao=listarValor&mensagemalerta='.urlencode('Valor deletado com sucesso!'));
            } else {
                header('Location: index.php?mod=valor&acao=listarValor&mensagemerro='.urlencode('ERRO ao deletar Valor!'));
            }
        }

    break;


    case ALTERA_ORDEM_BAIXO:
        include_once("valor_class.php");

        $dados = $_REQUEST;
        $resultado['status'] = 'sucesso';
        try {
            $valor = buscaValor(array('idvalor'=>$dados['idvalor']));
            $valor = $valor[0];

            $ordemAux = 0;
            $ordem = $valor['ordem'];
            
            while($ordemAux == 0){
                 $ordem = $ordem + 1;
                 $valorAux = buscaValor(array('ordenacao'=>$ordem));
                 if(!empty($valorAux)){
                    $valorAux = $valorAux[0];
                    $ordemAux = $valorAux['ordem'];
                 }
            }
            if(!empty($valorAux)){
                $valorAux['ordem'] = $valor['ordem'];
                $valor['ordem'] = $ordemAux;
                editValor($valor);
                editValor($valorAux);
             }

            print json_encode($resultado);

        } catch (Exception $e) {
            $resultado['status'] = 'falha';
            print json_encode($resultado);
        }
    break;
    
    case ALTERA_ORDEM_CIMA:
        include_once("valor_class.php");

        $dados = $_REQUEST; 
        $resultado['status'] = 'sucesso';
        try {
            $valor = buscaValor(array('idvalor'=>$dados['idvalor']));
            $valor = $valor[0];
            $ordemAux = 0;
            $ordem = $valor['ordem'];
            while($ordemAux == 0)
            {
                 $ordem = $ordem - 1;

                 $valorAux = buscaValor(array('ordenacao'=>$ordem));
                 if(!empty($valorAux)){
                    $valorAux = $valorAux[0];
                    $ordemAux = $valorAux['ordem'];
                 }
            }
            if(!empty($valorAux)){

                $valorAux['ordem'] = $valor['ordem'];
                $valor['ordem'] = $ordemAux;

                editValor($valor);
                editValor($valorAux);
             }

            print json_encode($resultado);

        } catch (Exception $e) {
            $resultado['status'] = 'falha';
            print json_encode($resultado);
        }
    break;

    case INVERTE_STATUS:
        include_once("valor_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';

        try {
            $valor = buscaValor(array('idvalor' => $dados['idvalor']));
            $valor = $valor[0];

            // print_r($valor);
            if($valor['status'] == 'A'){
                $status = 'I';
            }
            else{
                $status = 'A';
            }

            $dadosUpdate = array();
            $dadosUpdate['idvalor'] = $dados['idvalor'];
            $dadosUpdate['status'] = $status;
            inverteStatus($dadosUpdate);

            print json_encode($resultado);
        } catch (Exception $e) {
            $resultado['status'] = 'falha';
            print json_encode($resultado);
        }
    break;

    case VERIFICAR_URLREWRITE:

        include_once('valor_class.php'); 
        include_once('includes/functions.php');
        
        $dados = $_POST;
         
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
        
        if($dados['idvalor'] && $dados['idvalor'] <= 0){
            $url = buscaValor(array("urlrewrite"=>$urlrewrite));    
        }else{ 
            $url = buscaValor(array("urlrewrite"=>$urlrewrite,"not_idvalor"=>$dados['idvalor'])); 
        } 

        if(empty($url)){ 
            print '{"status":true,"url":"'.$urlrewrite.'"}';
        }else{
            print '{"status":false}';
        } 

    break;

    default:
        if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
            header('Location: index.php?mod=home&mensagemerro='.urlencode('Nenhuma acao definida...'));
        } else {
            trigger_error('Erro...', E_USER_ERROR);
            exit;
        }

}
?>