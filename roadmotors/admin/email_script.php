<?php @session_start();
   $opx = $_REQUEST["opx"];

   $destinatario = 'gabriel@agencia.red';
      
   switch ($opx) {
      case 'contato':
         include_once 'includes/functions.php';
         
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['assunto'] = 'Contato';

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].'</p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Placa: '.strtolower($dados['placa']).'</p>';
            
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
         $email = array();
                 
         $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
         $email['email_remetente'] = $destinatario;
         
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
      
      case 'contato2':
        include_once 'includes/functions.php';
        
        include_once 'contatos_class.php';
        
        $dados = $_POST;

        $dados['assunto'] = 'Contato';

        $idcontato = cadastroContatos($dados);

        $texto = '<p>'.$dados['assunto'].'</p>';
        $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
        $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
        $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
       $texto .= '<p>Placa: '.strtolower($dados['placa']).'</p>';
           
        /*******************************************************
        ****         Script de Envio de Email        ****
        ********************************************************/
        
        $email = array();
                
        $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
        $email['email_remetente'] = $destinatario;
        
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
   }
   
?>