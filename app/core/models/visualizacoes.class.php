<?php
	/**
	* 
	*/
	namespace App\Core\Models;

	use App\Lib\Main\MainModel;

	class Home extends MainModel{
		
		function getUsers()	{
			echo 'Lista de Users';
		}
	}