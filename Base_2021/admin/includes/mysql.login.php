<?php

	$host = "localhost";

	$user = "web_sites";
	$password = "NMzK0T&13bf;";
	//NOME DATABASE DO PROJETO
	$database = "web_Base_2021";

	$ENDERECO = 'https://'.$_SERVER['HTTP_HOST'].'/Base_2021/admin/';

	$conexao = mysqli_connect($host, $user, $password) or exit(mysqli_connect_error());

	mysqli_select_db($conexao, $database) || exit(mysqli_error($conexao));

	defined('ENDERECO') || define('ENDERECO', $ENDERECO);
