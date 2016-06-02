<?php
/**
* View da NotFound
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
	namespace App\Core\Views;
	
	class NotFound{
		
		function __construct()
		{
			$_404 = file_get_contents(TEMPLATES.'/_includes/404.tpl');
			echo $_404;
		}
	}