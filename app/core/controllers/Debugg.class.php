<?php
	/**
	* 
	*/
	namespace App\Core\Controllers;
	use App\Lib\DbTrack AS Banco;
	use \PDO;

	class Debugg extends Banco{
		
		function index(){
			$db = parent::Select(
				'tr_session', 
				['COUNT(session_date) AS qtd','session_date'], 
				'WHERE session_date BETWEEN ? AND ? GROUP BY session_date',
				['2016-05-11', '2016-05-30']
			);
			echo "<pre>";
			// var_dump($db);
			$datas = [];
			$dados = [];
			foreach ($db as $key => $value) {
				array_push($datas, $value['session_date']);
				array_push($dados, (int)$value['qtd']);
				// echo $value['qtd']."<br>";
			}
			$graphData = [['name' => 'Sessões', 'data' => $dados]];
			echo json_encode($graphData);
		}
	}