<?php
namespace src\controllers;

use \core\Controller;

class HomeController extends Controller {

    public function index() {
        $estruturas = [
        'RECORTE',
        'MARCENARIA',
        'EMBALAGEM',
        'EXPEDIÇÃO',
        'PINTURA LIQUIDA',
        'METALÚRGICA',
        'LASER',
        'MONTAGEM'
        ];
    
        $this->render('home', [
            'estruturas' => $estruturas
        ]);
    }
}