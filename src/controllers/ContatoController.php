<?php

namespace src\controllers;

use \core\Controller;
use \src\models\Contato;
use \src\models\Curriculo;

class ContatoController extends Controller
{

   public function contato()
   {
      $flash = filter_input(INPUT_GET, 'flash', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $correct = filter_input(INPUT_GET, 'correct', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $this->render('contato', [
         'flash' => $flash,
         'correct' => $correct
      ]);
   }

   public function contatoAction()
   {
      $name = filter_input(INPUT_POST, 'nome');
      $phone = filter_input(INPUT_POST, 'telefone');
      $email = filter_input(INPUT_POST, 'email');
      $body = filter_input(INPUT_POST, 'body');

      if ($name && $email && $phone) {
         $data = Contato::select()->where('email', $email)->execute();

         if (count($data) === 0) {
            // insert
            Contato::insert([
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'body' => $body
            ])->execute();

            $this->redirect('/contato?correct=Campos+enviados+com+sucesso#sac-contato');
            return;
         }
      }
      $this->redirect('/contato?flash=Campos+n%C3%A3o+preenchidos+corretamente!#sac-contato');
   }

   public function trabalheAction()
   {
      $name = filter_input(INPUT_POST, 'nome');
      $phone = filter_input(INPUT_POST, 'telefone');
      $email = filter_input(INPUT_POST, 'email');
      $curriculo = filter_input(INPUT_POST, 'curriculo');

      if ($name && $email && $phone) {
         $data = Curriculo::select()->where('email', $email)->execute();

         if (count($data) === 0) {
            // insert
            Curriculo::insert([
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'curriculo' => $curriculo
            ])->execute();

            $this->redirect('/contato?correct=Campos+enviados+com+sucesso#sac-contato');
            return;
         }
      }
      $this->redirect('/contato?flash=Campos+n%C3%A3o+preenchidos+corretamente!#sac-contato');
   }
}
