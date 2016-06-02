<?php
	require_once('config.php');

	/**
	* Verifica se o modo Debug esta ativo
	*/

	if(DEBUG === false){
		ini_set('display_errors', 'OFF');
		error_reporting(0);
	}else{
		ini_set('display_errors', 'ON');
		error_reporting(E_ALL);
	}

	/**
	* Carrega as classes automaticamente com a spl_autoload_register('__load');
	* @param __load nome da classe que sera carregado, atribuido automaticamente
	* quando instanciado uma classe.
	*/
	if(!function_exists('__load')){
		function __load($className){
			$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
			$file_path = strtolower(ROOT.$className.'.class.php');

			if(file_exists($file_path)){
				require_once($file_path);
			}else{
				echo 'Infelizmente a classe '.$className.' não existe.';
				exit();
			}
		}

		spl_autoload_register('__load');
	}
