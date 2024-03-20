<?php
session_start(); // Certifique-se de iniciar a sessão

// Verifique se a operação foi recebida e se a variável de sessão existe
if (isset($_POST['operacao']) && isset($_SESSION['orcamento'][1]['qtde'])) {
    $operacao = $_POST['operacao'];

    // Obtenha a quantidade atual da variável de sessão
    $quantidade = $_SESSION['orcamento'][1]['qtde'];

    // Realize a operação de adicionar ou remover
    if ($operacao === 'adicionar') {
        $quantidade++;
    } elseif ($operacao === 'remover') {
        if ($quantidade > 0) { // Verifique se a quantidade é maior que zero antes de remover
            $quantidade--;
        }
    }

    // Atualize a variável de sessão com a nova quantidade
    $_SESSION['orcamento'][1]['qtde'] = $quantidade;

    // Envie de volta a nova quantidade como resposta para o JavaScript
    echo $quantidade;
  } else {
    // Se a operação não foi recebida ou a variável de sessão não existe, retorne um erro ou um valor padrão
    echo "Erro ao atualizar a quantidade. Operação: ".$_POST['operacao']." - Sessão: ".$_SESSION['orcamento'][1]['qtde'];
}

?>
