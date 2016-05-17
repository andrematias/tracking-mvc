<?php
	require_once('config.php');

	if(DEBUG === false){
		ini_set('display_errors', 'OFF');
		error_reporting(0);
	}else{
		ini_set('display_errors', 'ON');
		error_reporting(E_ALL);
	}

	if(!function_exists('__load')){
		function __load($calssName){
			$file_path = strtolower(ROOT.'/App/lib/'.$calssName.'.class.php');
			if(file_exists($file_path)){
				require_once($file_path);
			}else{
				echo 'Infelizmente a classe '.$calssName.' não existe.';
				exit();
			}
		}

		spl_autoload_register('__load');
	}