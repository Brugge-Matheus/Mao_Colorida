<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/contato', 'ContatoController@contato');
$router->post('/contato', 'ContatoController@contatoAction');
$router->post('/trabalhe', 'ContatoController@trabalheAction');

$router->get('/sobre', 'SobreController@sobreAction');

$router->get('/recursos', 'RecursosController@recursosAction');

$router->get('/ambiental', 'AmbientalController@ambientalAction');

$router->get('/qualidade', 'QualidadeController@qualidadeAction');

$router->get('/Segurancas', 'SegurancasController@segurancasAction');