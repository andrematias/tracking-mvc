<?php
/**
* 
*/
namespace App\Core\Controllers;

use App\Lib\Main\MainController AS MainController;
use App\Core\Views\Relatorios AS ViewRelatorios;

class Relatorios extends MainController
{
	public $view;
	
	function index()
	{
		$this->consolidado();
	}

	function consolidado(){
		$this->_view = new ViewRelatorios;
		$this->_view->consolidado();
	}

	function detalhado(){
		$this->_view  = new ViewRelatorios;
		$this->_view->detalhado();
	}
}