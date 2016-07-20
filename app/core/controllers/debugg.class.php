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
        $api->cliente        = \filter_input(INPUT_POST, 'dominio');
        $api->user           = \filter_input(INPUT_POST, 'userHash');
        $api->url            = \filter_input(INPUT_POST, 'url');
        $api->shortUrl       = \filter_input(INPUT_POST, 'shortUrl');
        $api->sessionDate    = \filter_input(INPUT_POST, 'data');
        $api->sessionStart   = \filter_input(INPUT_POST, 'start');
        $api->sessionEnd     = \filter_input(INPUT_POST, 'end');
        $api->interesse      = \filter_input(INPUT_POST, 'interesse');
        $api->linhaDeNegocio = \filter_input(INPUT_POST, 'linhaDeNegocio');
        $api->origem         = \filter_input(INPUT_POST, 'origem');
        $api->score          = \filter_input(INPUT_POST, 'score', FILTER_VALIDATE_INT);
        $api->email          = urldecode(\filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $api->nome           = \filter_input(INPUT_POST, 'nome');
        $api->pais           = \filter_input(INPUT_POST, 'pais');


        //Inclui os Observadores no sujeito
        $api->incluirObservadores($cliente);
        $api->incluirObservadores($user);
        $api->incluirObservadores($interesse);
        $api->incluirObservadores($origem);
        $api->incluirObservadores($url);
        $api->incluirObservadores($sessao);
        $api->incluirObservadores($base);


        //Remove as classes observadoras da classe sujeito se não atender as condicionais
        if( empty($api->email) ){
            $api->removerObservadores($base);
        }
        if(empty($api->origem) && empty($api->score)){
            $api->removerObservadores($origem);
        }
        if(empty($api->interesse) && empty($api->linhaDeNegocio)){
            $api->removerObservadores($interesse);
        }

        $api->notificar();
    }
}