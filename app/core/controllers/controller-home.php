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

			//Verifica e chama a view da home
			if(file_exists(ROOT.'/app/core/views/view-home.php')){
				require_once(ROOT.'/app/core/views/view-home.php');
				$this->_home_view = new ViewHome();
				$this->_home_view->ShowHome();
			}else{
				header('Location:'.SITEPATH.'/pageNotFound');
			}
		}
	}