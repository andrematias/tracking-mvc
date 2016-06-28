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

class Debugg
{

    function index()
    {
        //$banco = new Banco();

        $cliente = new Cliente();
        $user    = new User();
        $sessao  = new Sessao();
        $url     = new Url();
        $interesse = new Interesse();
        $origem = new Origem();
        
        $api          = new \App\Lib\TrackingAPI();
        //$api->cliente = 'http://blogar.com.br';
        //$api->user    = 'Cardoso';
        $api->url = 'http://bing.com.br';
        $api->shortUrl = 'Bing';
        //$api->sessionDate = '2016-06-30';
        //$api->sessionStart = '14:00:00';
        //$api->sessionEnd = '17:20:00';
        //$api->interesse = 'interesse';
        //$api->linhaDeNegocio = 'business Line';
        //$api->origem = 'google';
        //$api->score = '10';


        //$api->incluirObservadores($cliente);
        //$api->incluirObservadores($user);
        //$api->incluirObservadores($interesse);
        //$api->incluirObservadores($origem);
        $api->incluirObservadores($url);
        //$api->incluirObservadores($sessao);
        $api->notificar();
        
        echo '<pre>';
        var_dump($api);
    }
}