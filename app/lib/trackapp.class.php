<?php
/**
* Classe principal para carregar a aplicação.
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

namespace App\Lib;


class Trackapp{
	public $controller = 'App\Core\Controllers\Visualizacoes';

	public $method 	= 'index';

	public $param;

	public $error404 = 'App\Core\Controllers\NotFound';


	/**
	* Método construtor da classe, altera o valor da propriedade $controller 
	* para o valor informado pela variavel $_GET['route'] recuperada pelo 
	* método getRoutes().
	*/
	function __construct(){
		//Recupera os valores de controller, metodo e parametro via getRoutes()
		$routes = self::getRoutes();

		/**Verifica se o arquivo existe e inclui ele para instanciar a classe 
		* de controller com o prefixo e nome, caso não exista instancia uma 
		* classe com o nome padrão home.
		*/
		if(file_exists(ROOT.'/app/core/controllers/'.$routes[0].'.class.php')){
			$this->controller = "App\Core\Controllers\\".$routes[0];
			unset($routes[0]);
		 }else{
		 	if(file_exists(ROOT.'/app/core/controllers/visualizacoes.class.php')){
		 		$this->controller = "App\Core\Controllers\Visualizacoes";
		 	}else{
		 		$this->controller = $this->error404;
		 	}
		}
		$this->controller = new $this->controller;

		/**
		* Verifica se na classe informada pelo controller existe um método 
		* com o nome de method caso existam define o valor de $routes[1] a
		* method
		*/
		if(isset($routes[1])){
			if(method_exists($this->controller, $routes[1])){
				$this->method = $routes[1];
				unset($routes[1]);
			}
		}

		/**
		* Inclui o restante dos elementos do array $routes na propriedade
		* param reorganizando os indices do array.
		*/
		$this->param = (!empty($routes)) ? array_values($routes) : [];

		/**
		* Chama o method da classe controller passando os param
		*/
		call_user_func_array([$this->controller, $this->method], $this->param);
	}

	/**
	* Método para recuperar e separar os valores passados via GET para o index
	* route
	*/
	function getRoutes(){
		if(isset($_GET['route']) && !empty($_GET['route'])){
			$out = explode('/', $_GET['route']);
			return $out;
		}else{
			return NULL;
		}
	}
}
