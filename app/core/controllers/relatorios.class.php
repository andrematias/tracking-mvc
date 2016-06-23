<?php
/**
* 
*/
namespace App\Core\Controllers;

use App\Lib\Main\MainController AS MainController;
use App\Core\Views\Relatorios AS ViewRelatorios;

class Relatorios extends MainController
{
	public $_view;
	
	function index()
	{
		$this->Consolidado();
	}

	function Consolidado(){
		$this->_view = new ViewRelatorios;
		$this->_view->Consolidado();
	}

	function Detalhado(){
		$this->_view  = new ViewRelatorios;
		$this->_view->Detalhado();
	}
}