<?php
	/**
	* Controler inicial
	*/
	class Home extends MainController{

		public $_home_view;
		
		function Index(){
			/*Chama o view para mostrar a página inicial da App se houver 
			uma sessão iniciada verificada pelo método da parent que herda 
			da parent dela */
			if(parent::CheckSession() != TRUE){
				header('Location:'.SITEPATH.'/login');
			}
			// if(isset($_REQUEST['go']) && $_REQUEST['go'] == 'loggout'){
			// 	parent::SessionDestroy();
			// }
			$this->redirect();

			//Verifica e chama a view da home
			if(file_exists(ROOT.'/App/core/views/view-home.php')){
				require_once(ROOT.'/App/core/views/view-home.php');
				$this->_home_view = new ViewHome();
				$this->_home_view->ShowHome();
			}else{
				header('Location:'.SITEPATH.'/pageNotFound');
			}
			// echo 'HOME METODO INDEX <a href="'.SITEPATH.'?go=loggout">Sair</a>';
		}


		protected function redirect(){
			$go = (isset($_REQUEST['go'])) ? $_REQUEST['go'] : NULL;

			switch ($go) {
				case 'loggout':
					parent::SessionDestroy();
					break;

				case 'configuracoes':
					header('Location:'.SITEPATH.'/configuracoes');
					break;					

				case 'home':
					header('Location:'.SITEPATH);
					break;					
			}
		}
	}