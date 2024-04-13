<?php @session_start();
   $opx = $_REQUEST["opx"];

   $destinatario = 'adrian@agencia.red';
      
   switch ($opx) {
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

      case 'cotacao':
         include_once 'includes/functions.php';
         
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['telefone'] = '';
         $dados['mensagem'] = '';
         $dados['assunto'] = 'Cotações Rápidas';

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].'</p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.ucwords(strtolower($dados['email'])).'</p>';
         $texto .= '<p>Whatsapp: '.strtolower($dados['whatsapp']).'</p>';
            
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
         ****         Script de Envio de Email        ****
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
   }
   
?>