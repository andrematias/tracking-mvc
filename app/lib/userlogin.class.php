<?php
/**
* Configura novas variaveis de sessão, inicia sessões, finaliza sessões, 
* verifica se existe alguma sessão iniciada, gerencia cookies.
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

	namespace App\Lib;
	
	class UserLogin	{

		protected $logged;
		
		/**
		* Método para ativar o valor das variaeis $_SESSION em todas
		* as páginas que ela estiver presente.
		*/
		protected function initSession(){
			if(session_id() == null){
				ini_set('session.name', 'tracking_session');
				ini_set('session.hash_function', 'sha512');
				if(is_writable(session_save_path()) != 1 ) session_save_path('/tmp');
				session_start();
				session_regenerate_id(true);
			}
		}
		

		/**
		* Método para destruir uma sessão e seus valores
		*/
		protected function sessionDestroy(){
			if(session_id() != null){
				$_SESSION = array();
				session_destroy();
				header('Location:'.SITEPATH);
			}
		}

		/**
		* Método para codificar uma senha
		*/

		protected function encode64($password){
			$password = base64_encode($password);
			if($password) return $password;
			return false;
		}

		/**
		* Método para decodificar uma senha
		*/

		protected function decode64($password){
			$password = base64_decode($password);
			if($password) return $password;
			return false;
		}
	}