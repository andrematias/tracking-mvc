<?php
	/**
	* 
	*/
	namespace App\Core\Controllers;
	use App\Lib\DbTrack AS Banco;
        use App\Lib\TrackingAPI as API;
        use App\Lib\Cliente;
        use App\Lib\User;

	class Debugg extends Banco
	{
		
		function index()
		{
                    $arr = ['cliente' => 'blog.com'];

                    $keys = array_keys( $arr );
                    $colunas = implode(', ', $keys);
                    $campos = ':'.implode(', :', $keys);
                    $valores = array_values($arr);

                    //var_dump($keys);
                    //var_dump($this->Salvar('tr_cliente', array( 'cliente' => 'http://copcorental.solutions' )));

                    //var_dump($this->Query('SELECT * FROM tr_cliente WHERE cliente = :cliente AND id_cliente = :id_cliente', array('cliente' => 'http://copcorental.solutions', 'id_cliente'=>1)));

                    var_dump($this->Update('tr_cliente', array('cliente'), 'WHERE cliente = ?', array('http://copcorental.solutions')));
		}
	}