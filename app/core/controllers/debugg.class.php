<?php
	/**
	* 
	*/
	namespace App\Core\Controllers;
	use App\Lib\DbTrack AS Banco;
	use \PDO;

	class Debugg extends Banco
	{
		
		function index()
		{
			/*$delete = parent::Delete
			(
				'tr_user',
				"WHERE cliente = ?",
				['invalido']
			);

			var_dump($delete);*/
			var_dump
			(
				$db = parent::Select
				(
					'tr_user', 
					['cliente'], 
					'WHERE cliente LIKE ? LIMIT 10', 
					['%invalido%']
				)
			);
		}
	}