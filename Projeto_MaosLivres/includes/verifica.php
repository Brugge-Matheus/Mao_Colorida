<?php @ob_start();
    @session_start();

    $postArray = isset($_REQUEST['p']) ? explode("/",$_REQUEST['p']) : array();
    $testa =  getcwd();

	// TROCAR _padroes/Base_2021 PELO NOME DO PROJETO

	if($testa == "/home/admin/web/in.agencia.red/public_html/gamma"){
        @define('ENDERECO', 'http://'.$_SERVER['HTTP_HOST'].'/gamma/');
    }elseif($testa == "C:\\xampp\htdocs\gamma.com.br"){
        @define('ENDERECO', 'http://'.$_SERVER['HTTP_HOST'].'/gamma.com.br/');
    }elseif($testa == "/home3/web/public_html/gamma"){
        @define('ENDERECO', 'https://'.$_SERVER['HTTP_HOST'].'/gamma/');
    }else{
        @define('ENDERECO', 'https://'.$_SERVER['HTTP_HOST'].'/');
    }

	// ATÉ AQUI

	$_SESSION['modulo'] = isset($postArray[0]) ? $postArray[0] : '';
	$_SESSION['idu'] = isset($postArray[1]) ? $postArray[1] : '';
	$_SESSION['extra'] = isset($postArray[2]) ? $postArray[2] : '';
	$_SESSION['extra2'] = isset($postArray[3]) ? $postArray[3] : '';
	$_SESSION['extra3'] = isset($postArray[4]) ? $postArray[4] : '';
	$_SESSION['extra4'] = isset($postArray[5]) ? $postArray[5] : '';
	$MODULO = $_SESSION['modulo'];

	switch($_SESSION['modulo']){
		default :
			$PAGINA = 'index';
		break;
	}

	include_once("verifica_link.php");
?>
