<?php
/**
* Classe principal para carregar a aplicação.
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

namespace App\Lib;

//Use classes
use App\Core\Controllers\Login;

class Trackapp{
	public $_controller = 'App\Core\Controllers\Visualizacoes';

	public $_method 	= 'index';

	public $_param;

	public $_404 = 'App\Core\Controllers\NotFound';


	/**
	* Método construtor da classe, altera o valor da propriedade $_controller 
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
			$this->_controller = "App\Core\Controllers\\".$routes[0];
			unset($routes[0]);
		 }else{
		 	if(file_exists(ROOT.'/app/core/controllers/visualizacoes.class.php')){
		 		$this->_controller = "App\Core\Controllers\Visualizacoes";
		 	}else{
		 		$this->_controller = $this->_404;
		 	}
		}
		$this->_controller = new $this->_controller;

		/**
		* Verifica se na classe informada pelo _controller existe um método 
		* com o nome de _method caso existam define o valor de $routes[1] a
		* _method
		*/
		if(isset($routes[1])){
			if(method_exists($this->_controller, $routes[1])){
				$this->_method = $routes[1];
				unset($routes[1]);
			}
		}

		/**
		* Inclui o restante dos elementos do array $routes na propriedade
		* _param reorganizando os indices do array.
		*/
		$this->_param = (!empty($routes)) ? array_values($routes) : [];

		/**
		* Chama o _method da classe _controller passando os _param
		*/
		call_user_func_array([$this->_controller, $this->_method], $this->_param);
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
