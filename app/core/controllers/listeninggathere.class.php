<?php
/**
 * Classe ListeningGathere para registro de dados enviados via POST
 * @author: André Matias
 * @link: andrersmatias@gmail.com
 * @link: http://github.com/andrematias
 */

namespace App\Core\Controllers;

use \App\Lib\Cliente;
use \App\Lib\User;
use \App\Lib\Sessao;
use \App\Lib\Url;
use \App\Lib\Base;

class ListeningGathere
{

    function index()
    {
        //Observadores
        $cliente   = new Cliente();
        $user      = new User();
        $sessao    = new Sessao();
        $url       = new Url();
        $base      = new Base();

        //Preenchimento do Sujeito
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
        $api->email          = \filter_var(\urldecode(\filter_input(INPUT_POST, 'email')), FILTER_VALIDATE_EMAIL);
        $api->nome           = \filter_input(INPUT_POST, 'nome');
        $api->pais           = \filter_input(INPUT_POST, 'pais');
        $api->cnpj           = \filter_input(INPUT_POST, 'cnpj');
        $api->cargo          = \filter_input(INPUT_POST, 'cargo');
        $api->empresa        = \filter_input(INPUT_POST, 'empresa');
        $api->ramo           = \filter_input(INPUT_POST, 'ramo');
        $api->telefone       = \filter_input(INPUT_POST, 'telefone');
        $api->cep            = \filter_input(INPUT_POST, 'cep');
        $api->cidade         = \filter_input(INPUT_POST, 'cidade');
        $api->estado         = \filter_input(INPUT_POST, 'estado');
        $api->uf             = \filter_input(INPUT_POST, 'uf');
        $api->leadType       = \filter_input(INPUT_POST, 'leadType');
        $api->endereco       = \filter_input(INPUT_POST, 'endereco');


        //Inclui os Observadores no sujeito
        $api->incluirObservadores($cliente);
        $api->incluirObservadores($user);
        $api->incluirObservadores($url);
        $api->incluirObservadores($sessao);
        $api->incluirObservadores($base);


        //Remove as classes observadoras da classe sujeito se não atender as condicionais
        if(empty($api->cliente)){
            $api->removerObservadores($cliente);
        }
        if( empty($api->email) ){
            $api->removerObservadores($base);
        }
        if(empty($api->url)){
            $api->removerObservadores($url);
        }
        if(empty($api->user)){
            $api->removerObservadores($user);
        }
        if(empty($api->sessionDate) || empty($api->sessionStart)){
            $api->removerObservadores($sessao);
        }

        //Atualiza os Observadores com os dados coletados pela classe sujeito ($api)
        $api->notificar();

        //Debugg response
        /*
          echo "<pre>";
          var_dump($api);
         */
    }
}