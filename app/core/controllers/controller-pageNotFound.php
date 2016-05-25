<?php
	/**
	* 
	*/
	class pageNotFound extends MainController{
		
		function index(){
			require_once(ROOT.'/app/core/views/view-pagenotfound.php');
			$notfound = new NotFound();
		}
	}