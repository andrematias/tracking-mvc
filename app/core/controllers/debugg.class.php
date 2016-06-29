<?php
/**
 * 
 */

namespace App\Core\Controllers;

use \App\Lib\Cliente;
use App\Lib\User;
use \App\Lib\Sessao;
use \App\Lib\Url;
use \App\Lib\Interesse;
use \App\Lib\Origem;
use \App\Lib\Base;

class Debugg
{

    function index()
    {
        $cliente   = new Cliente();
        $user      = new User();
        $sessao    = new Sessao();
        $url       = new Url();
        $interesse = new Interesse();
        $origem    = new Origem();
        $base      = new Base();

        $api                 = new \App\Lib\TrackingAPI();
        $api->cliente        = 'http://dominio.com.br';
        $api->user           = 'Cardoso';
        $api->url            = 'http://gmail.com.br';
        $api->shortUrl       = 'Email do Google';
        $api->sessionDate    = '2016-07-02';
        $api->sessionStart   = '11:45:00';
        $api->sessionEnd     = '12:33:00';
        $api->interesse      = 'Emails';
        $api->linhaDeNegocio = 'Correios';
        $api->origem         = 'Google';
        $api->score          = '100';
        $api->email          = 'andrersmatias@gmail.com';
        $api->nome           = 'André Robson Souza Matias';
        $api->pais           = 'Brasil';

        $api->incluirObservadores($cliente);
        $api->incluirObservadores($user);
        $api->incluirObservadores($interesse);
        $api->incluirObservadores($origem);
        $api->incluirObservadores($url);
        $api->incluirObservadores($sessao);
        $api->incluirObservadores($base);
        $api->notificar();

        
        echo '<pre>';
        var_dump($api);
    }
}