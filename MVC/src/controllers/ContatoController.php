<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Contato;

class ContatoController extends Controller {
    
    public function contato() {
        $this->render('/contato');
    }

    // public function contatoAction() {
    //     echo 'PAGINA ENCONTRADA';
    // }

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

            $this->redirect('/contato');
         } 

      } 
      $this->redirect('/');
   }

   public function trabalheAction() {
      $name = filter_input(INPUT_POST, 'nome');
      $phone = filter_input(INPUT_POST, 'telefone');
      $email = filter_input(INPUT_POST, 'email');
      $curriculo = filter_input(INPUT_POST, 'curriculo');

    
      if($name && $email && $phone) {
         $data = Contato::select()->where('email', $email)->execute();

         if(count($data) === 0) {
            // insert
            Contato::insert([
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'curriculo' => $curriculo
            ])->execute();

            $this->redirect('/contato');
         } 

      } 
      $this->redirect('/');
   }

}