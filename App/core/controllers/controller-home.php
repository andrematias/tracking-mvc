<?php
	/**
	* Controler inicial
	*/
	class Home extends MainController{
		
		function index(){
			/*Chama o view para mostrar a página inicial da App se houver 
			uma sessão iniciada verificada pelo método da parent que herda 
			da parent dela */
			echo 'HOME METODO INDEX ';
		}
	}