<?php
	/**
	* Executa métodos globais para todas os controllers
	*/
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
		protected function CheckSession(){
			if(isset($_SESSION['user']) && isset($_SESSION['pass'])){
				return $this->_logged = true;
			}else{
				return false;
			}
		}
	}