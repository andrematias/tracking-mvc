<?php
/**
* 
*/
namespace App\Core\Controllers;

use App\Lib\Main\MainController AS MainController;
use App\Core\Views\Relatorios AS ViewRelatorios;
use App\Core\Models\Results AS ModelResults;

class Relatorios extends MainController
{
	public $view;
	public $model;
	
	public function index()
	{
		$this->consolidado();
	}

	public function consolidado(){
		$this->view = new ViewRelatorios;
		$this->model = new ModelResults();
		$this->view->consolidado($this->model->consolidado());
                $this->model->consolidado2();
	}

	public function detalhado(){
		$this->view  = new ViewRelatorios;
		$this->view->detalhado();
	}
}