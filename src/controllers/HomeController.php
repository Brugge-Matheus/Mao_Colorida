<?php
namespace src\controllers;

use \core\Controller;

class HomeController extends Controller {

    public function index() {
        $estruturas = [
        'ADMINISTRATIVO',
        'ALMOXARIFADO',
        'RECORTES',
        'MARCENARIA',
        'LASER',
        'METALÚRGICA',
        'PINTURA LÍQUIDA',
        'MONTAGEM',
        'IMPRESSÃO 3D',
        'SERIGRAFIA'];

        $this->render('home', [
            'estruturas' => $estruturas
        ]);
    }
}