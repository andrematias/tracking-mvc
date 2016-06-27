<?php
/**
 * 
 */

namespace App\Core\Controllers;

use \App\Lib\Cliente;
use App\Lib\User;
use \App\Lib\Sessao;
use App\Lib\DbTrack AS Banco;
use \App\Lib\Url;

class Debugg
{

    function index()
    {
        //$banco = new Banco();

        $cliente = new Cliente();
        $user    = new User();
        $sessao  = new Sessao();
        $url     = new Url();
        
        $api          = new \App\Lib\TrackingAPI();
        $api->cliente = 'http://blogar.com.br';
        $api->user    = 'Cardoso';
        $api->url = 'http://bind.com.br';
        $api->shortUrl = 'Bing';
        $api->sessionDate = '2016-06-30';
        $api->sessionStart = '14:00:00';
        $api->sessionEnd = '17:20:00';
        $api->interesse = 'interesse teste';
        $api->linhaDeNegocio = 'bl100';
        $api->origem = 'google';
        $api->score = '10';


        $api->IncluirObservadores($cliente);
        $api->IncluirObservadores($user);
        $api->IncluirObservadores($url);
        $api->IncluirObservadores($sessao);
        $api->Notificar();
        
        echo '<pre>';
        var_dump($api);
        //var_dump( $banco->Update($cliente->GetId(), 'tr_cliente', ['cliente' => 'http://testeDominio.com']) );
    }
}