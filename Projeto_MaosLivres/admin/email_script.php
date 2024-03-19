<?php @session_start();
   $opx = $_REQUEST["opx"];

   $destinatario = 'gabriel@agencia.red';
      
   switch ($opx) {

    case 'contato':
      include_once 'includes/functions.php';
      include_once 'contatos_class.php';
      
      $dados = $_POST;

      if($dados['opcao_contato'] == 'sac'){
        $dados['assunto'] = 'SAC';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
          
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
        $email['destinatario'] = array(
          'Gamma Distribuidora SAC' => 'gabriel@agencia.red'
        );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
      }elseif($dados['opcao_contato'] == 'financeiro'){
        $dados['assunto'] = 'Financeiro';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
          
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
        $email['destinatario'] = array(
          'Gamma Distribuidora Financeiro' => 'gabriel@agencia.red'
        );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
      }elseif($dados['opcao_contato'] == 'comercial'){
        $dados['assunto'] = 'Comercial';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
          
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
        $email['destinatario'] = array(
          'Gamma Distribuidora Comercial' => 'gabriel@agencia.red'
        );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
      }else{
        $dados['assunto'] = 'RH';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
          
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
        $email['destinatario'] = array(
          'Gamma Distribuidora RH' => 'gabriel@agencia.red'
        );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
      }
    break;
    
    case 'revendedor':
      include_once 'includes/functions.php';
      include_once 'contatos_class.php';
      
      $dados = $_POST;

        $dados['assunto'] = 'Revendedor';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Interesse: '.ucwords(strtolower($dados['interesse'])).'</p>';
        $texto .= '<p>Mensagem: </p><br/>';
        $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';
          
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
        $email['destinatario'] = array(
          'Gamma Distribuidora' => $destinatario
        );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
    break;

    case 'trabalhe-conosco':
      include_once 'includes/functions.php';
      include_once 'area_pretendida_class.php';
      
      $dados = $_POST;

      $texto = '<p>Trabalhe conosco </p>';
      $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
      $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
      $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
      $texto .= '<p>Baixar Curriculum: '.strtolower($link).'</p>';
      $texto .= '<p>Mensagem: </p><br/>';
      $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';

      /*******************************************************
     ****           Script de Envio de Email             ****
      ********************************************************/

      $email = array(); 

      $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
      $email['email_remetente'] = strtolower($dados['email']);    

      $email['destinatario'] = array('[CLIENTE]' => $destinatario);

      $email['assunto'] = 'E-mail vindo do site';

      $email['texto'] = $texto;     

      if(enviaEmail($email)){
        echo '{"status" : true}';
      }else{
        echo '{"status" : false}'; 
      }
    break;

    case 'newsletter':
        include_once 'includes/functions.php';
        // 
        include_once 'newsletter_class.php';
        
        $dados = $_POST;

        $idcontato = cadastroNewsletter($dados);

        $texto = '<p>Solicitou receber novidades</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
        
        /*******************************************************
       ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = strtolower($dados['email']);      
        
        $email['destinatario'] = array(
          '[CLIENTE]' => $destinatario
          );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
    break;

    case 'newsletter-blog':
        include_once 'includes/functions.php';
        // 
        include_once 'newsletter_class.php';
        
        $dados = $_POST;

        $idcontato = cadastroNewsletter($dados);

        $texto = '<p>Solicitou receber novidades do blog</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
        
        /*******************************************************
       ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = strtolower($dados['email']);      
        
        $email['destinatario'] = array(
          '[CLIENTE]' => $destinatario
          );
        
        $email['assunto'] = 'E-mail vindo do site';
        
        $email['texto'] = $texto;    
        
        if(enviaEmail($email)){
          echo '{"status" : true}';
        }else{
          echo '{"status" : false}';
        }
    break;

    case 'cadastro-orcamento':
      include_once 'includes/functions.php';
      include_once 'orcamento_class.php';

      session_start();

      function gerarNumeroAleatorio() {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $tamanhoMaximo = 5;
        $numeroAleatorio = '';

        for ($i = 0; $i < $tamanhoMaximo; $i++) {
            $numeroAleatorio .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $numeroAleatorio;
      }

      // Verifica se a variável $_SESSION['dados'] existe, se não existir, cria um array vazio
      if (!isset($_SESSION['dados'])) {
        $_SESSION['dados'] = array();
      }

      $dados = $_POST;
      $numeroAleatorio = gerarNumeroAleatorio();
      $dados['numero_orcamento'] = $numeroAleatorio;

      $_SESSION['dados']['numero_orcamento'] = $numeroAleatorio;

      $dados['assunto'] = 'Orçamento';

      $dados['status_orcamento'] = 'Orçamento Recebido';

      
      $idorcamento = cadastroOrcamento($dados);

      $texto = '<p>'.$dados['assunto'].'</p>';
      $texto .= '<p>Número de Orçamento: Nº: '.ucwords(strtolower($dados['numero_orcamento'])).'</p>';
      $texto .= '<p>ID do Produto: '.ucwords(strtolower($dados['idproduto'])).'</p>';
      $texto .= '<p>Nome Produto: '.ucwords(strtolower($dados['nomeproduto'])).'</p>';
      $texto .= '<p>Qtde: '.ucwords(strtolower($dados['qtde'])).'</p>';
      $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
      $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
      $texto .= '<p>Telefone: '.ucwords(strtolower($dados['telefone'])).'</p>';
      $texto .= '<p>CPF: '.ucwords(strtolower($dados['cpf'])).'</p>';
        
      /*******************************************************
      ****         Script de Envio de Email        ****
      ********************************************************/
      
      $email = array();
              
      $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
      $email['email_remetente'] = $destinatario;
      
      $email['destinatario'] = array(
        'Gamma Distribuidora' => $destinatario
      );
      
      $email['assunto'] = 'Orçamento Solicitado';
      
      $email['texto'] = $texto;    
      
      if(enviaEmail($email)){
        echo '{"status" : true}';
      }else{
        echo '{"status" : false}';
      }

    break;
   }
   
?>