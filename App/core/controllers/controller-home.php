<?php
	/**
	* Controler inicial
	*/
	class Home extends MainController{
		
		function Index(){
			/*Chama o view para mostrar a página inicial da App se houver 
			uma sessão iniciada verificada pelo método da parent que herda 
			da parent dela */
			if(parent::CheckSession() != TRUE){
				header('Location:'.SITEPATH.'/login');
			}
			echo 'HOME METODO INDEX ';
		}
	}