<?php
/**
* Controller da NotFound
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
	namespace App\Core\Controllers;

	//Use classes
	use App\Lib\Main\MainController;
	use App\Core\Views\NotFound as ViewNotFound;
	
	class NotFound extends MainController{
		
		function index(){
			// require_once(ROOT.'/app/core/views/vNotFound.class.php');
			$notfound = new ViewNotFound();
		}
	}