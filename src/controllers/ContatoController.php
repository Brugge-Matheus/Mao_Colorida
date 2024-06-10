<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Contato;
use \src\models\Curriculo;

class ContatoController extends Controller {
    
   //  public function contato() {
   //      $this->render('/contato');
        
   //  }

   public function contato() {
    $flash = ''; 
    $correct = '';

    if(!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        $_SESSION['flash'] = '';
    }

    if(!empty($_SESSION['correct'])) {
        $correct = $_SESSION['correct'];
        $_SESSION['correct'] = '';
    }

    $this->render('contato', [
        'flash' => $flash,
        'correct' => $correct
    ]);
}

    public function contatoAction() {
      $name = filter_input(INPUT_POST, 'nome');
      $phone = filter_input(INPUT_POST, 'telefone');
      $email = filter_input(INPUT_POST, 'email');
      $body = filter_input(INPUT_POST, 'body');

    
      if($name && $email && $phone) {
         $data = Contato::select()->where('email', $email)->execute();

         if(count($data) === 0) {
            // insert
            Contato::insert([
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'body' => $body
            ])->execute();

            $_SESSION['correct'] = 'Campos enviado com sucesso';
            $this->redirect('/contato#sac-contato');
         } 

      } 
      $_SESSION['flash'] = 'Campos não preenchidos corretamente!';
      $this->redirect('/contato#sac-contato');
   }

   public function trabalheAction() {
      $name = filter_input(INPUT_POST, 'nome');
      $phone = filter_input(INPUT_POST, 'telefone');
      $email = filter_input(INPUT_POST, 'email');
      $curriculo = filter_input(INPUT_POST, 'curriculo');

    
      if($name && $email && $phone) {
         $data = Curriculo::select()->where('email', $email)->execute();

         if(count($data) === 0) {
            // insert
            Curriculo::insert([
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'curriculo' => $curriculo
            ])->execute();

            $_SESSION['correct'] = 'Campos enviados com sucesso';
            $this->redirect('/contato#sac-contato');
         } 

      }
      $_SESSION['flash'] = 'Campos não preenchidos corretamente!';
      $this->redirect('/contato#sac-contato');
   }

}