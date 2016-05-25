<?php

	/**
	* 
	*/
	class NotFound{
		
		function __construct()
		{
			$_404 = file_get_contents(TEMPLATES.'/_includes/404.tpl');
			echo $_404;
		}
	}