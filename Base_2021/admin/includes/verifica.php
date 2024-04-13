<?php
	session_start();
	$chavex = isset($_SESSION["sgc_BRGKE8921U13HJRUI2389234"]) ? $_SESSION["sgc_BRGKE8921U13HJRUI2389234"] : '';
	
	if((empty($chavex)) || ($chavex != "BRGjd8932u39rj2o3542j903je")){
		header("location:login.php?msg=".urlencode('Acesso Negado!'));
		exit;
	}else{
		include_once 'usuario_class.php';		
		salvaUltimaAcao($_SESSION['sgc_idusuario']);
				
		$tmpQuery = explode('&', str_replace('mod=', '', $_SERVER['QUERY_STRING']));
		$MODULOACESSO['modulo'] = $tmpQuery[0];
		$MODULOACESSO['usuario'] = $_SESSION['sgc_idusuario'];
	}
?>