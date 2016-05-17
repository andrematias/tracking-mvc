<?php
	/**
	* Configura novas variaveis de sessão, inicia sessões, finaliza sessões, 
	* verifica se existe alguma sessão iniciada, gerencia cookies.
	*/
	class UserLogin	{
		
		function initSession(){
			session_start();
			$_SESSION['user'] = 'Matias';
		}
	}