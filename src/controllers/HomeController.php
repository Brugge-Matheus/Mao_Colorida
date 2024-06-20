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
        $itensEstrutura = null;
        $itensMarcas = null;

        $caminhoEstrutura = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/estrutura/';
        $caminhoMarcas =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/marcas/';
            if (is_dir($caminhoEstrutura) && is_dir($caminhoMarcas)) {

                // Obtém a lista de itens na pasta
                $itensEstrutura = scandir($caminhoEstrutura);
                $itensMarcas = scandir($caminhoMarcas);

                // Filtra os itens especiais
                $itensEstrutura = array_diff($itensEstrutura, array('.', '..'));
                $itensMarcas = array_diff($itensMarcas, array('.', '..'));

                // Reinicia os índices do array
                $itensEstrutura = array_values($itensEstrutura);
                $itensMarcas = array_values($itensMarcas);
                
                // Conta o número de itens
                $numItensEstrutura = count($itensEstrutura);
                $numItensMarcas = count($itensMarcas);

            } else  {
                $numItensEstrutura = 0;
                $numItensMarcas = 0;
            }
    
        $this->render('home', [
            'estruturas' => $estruturas,
            'itensEstrutura' => $itensEstrutura,
            'itensMarcas' => $itensMarcas,
            'numItensEstrutura' => $numItensEstrutura,
            'numItensMarcas' => $numItensMarcas
        ]);
    }
}