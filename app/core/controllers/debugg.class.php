<?php
	/**
	* 
	*/
	namespace App\Core\Controllers;
    use \App\Lib\Cliente;
    use App\Lib\User;

	class Debugg
	{
		
		function index()
		{
            $cliente = new Cliente();          
            
            $user = new User();
            $api = new \App\Lib\TrackingAPI();
            $api->cliente = 'http://blogar.com.br';
            $api->user = 'Cardoso';
            

            $api->IncluirObservadores($cliente);
            $api->IncluirObservadores($user);
            $api->Notificar();
            echo '<pre>';
            var_dump($user);
            var_dump($cliente);
            
		}
	}