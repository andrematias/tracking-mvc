<?php
	/**
	* Configura novas variaveis de sessão, inicia sessões, finaliza sessões, 
	* verifica se existe alguma sessão iniciada, gerencia cookies.
	*/
	class UserLogin	{

		protected $_logged = false;
		
		/**
		* Método para ativar o valor das variaeis $_SESSION em todas
		* as páginas que ela estiver presente.
		*/
		protected function InitSession(){
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
		protected function SessionDestroy(){
			if(session_id() != null){
				$_SESSION = array();
				session_destroy();
			}
		}
	}