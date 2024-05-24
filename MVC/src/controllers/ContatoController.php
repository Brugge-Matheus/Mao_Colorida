<?php
namespace src\controllers;

use \core\Controller;

class ContatoController extends Controller {
    public function contato() {
        $this->render('/contato');
    }

}