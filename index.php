<?php
session_start();
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/src/routes.php';

function url( ){
    $host = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
    $host .= $_SERVER['SERVER_NAME'];
    if($_SERVER['SERVER_PORT'] != '80') {
        $host .= ':'.$_SERVER['SERVER_PORT'];
    };

    return $host.$_SERVER['REQUEST_URI'];

}

$router->run( $router->routes );