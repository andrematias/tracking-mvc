<?php
/**
* Executa métodos globais para todas os controllers
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

	namespace App\Lib\Main;
	use App\Lib\UserLogin as UserLogin;
	
	class MainController extends UserLogin{

		function __construct(){
			parent::InitSession();
			$go = (isset($_REQUEST['go'])) ? $_REQUEST['go'] : NULL;

			switch ($go) {
				case 'loggout':
					parent::SessionDestroy();
					break;				
			}
		}

		/*Checar se existe uma sessão logada*/
		protected static function CheckSession(){
			if(isset($_SESSION['user'])){
				return true;
			}else{
				return false;
			}
		}

		/**
		* Verifica se existe uma sessão ativa e redireciona para a pagina de 
		* login.
		*/
		public static function toLogin(){
			if(self::CheckSession() == false) header('Location:'.SITEPATH.'/login');
		}

		/**
		* Verifica se existe uma sessão ativa e redireciona para a pagina de 
		* Inicial da aplicação.
		*/
		public static function toHome(){
			if(self::CheckSession()) header('Location:'.SITEPATH.'/home');
		}

		/**
		* Método para adicionar mensagem ao buffer
		* @param msg, string mensagem para ser adicionada
		* @param type, string success ou error 
		*/
		public function newMessage($msg, $type){
			global $msgPool;
			if(!is_array($msgPool)){
				$msgPool = array();
			}

			$messages = array(
				'msg'  => $msg,
				'type' => $type
			);

			array_push($msgPool, $messages);
		}

	}