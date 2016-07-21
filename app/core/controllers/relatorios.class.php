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
                $dataResult = array(
                    array(
                    'data' => '21/07/2016',
                    'email'=>'andre@gmail.com',
                    'visitor' =>'',
                    'subject' =>'',
                    'description' =>'',
                    'request' =>'',
                    'function' =>'',
                    'telefone' =>'',
                    'empresa' =>'',
                    'sbu' =>'',
                    'endereco' =>'',
                    'cep' =>'',
                    'cidade' =>'',
                    'estado' =>'',
                    'pais' =>'',
                    'cnpj' =>'',
                    'origem' =>'',
                    'content' =>'',
                    'tempo_de_navegacao' =>'',
                    'leadType' =>'',
                    'score' =>'',
                    ),
                    array(
                    'data' => '21/07/2016',
                    'email'=>'andre@gmail.com',
                    'visitor' =>'',
                    'subject' =>'',
                    'description' =>'',
                    'request' =>'',
                    'function' =>'',
                    'telefone' =>'',
                    'empresa' =>'',
                    'sbu' =>'',
                    'endereco' =>'',
                    'cep' =>'',
                    'cidade' =>'',
                    'estado' =>'',
                    'pais' =>'',
                    'cnpj' =>'',
                    'origem' =>'',
                    'content' =>'',
                    'tempo_de_navegacao' =>'',
                    'leadType' =>'',
                    'score' =>'',
                    )
                );
		$this->_view->consolidado($dataResult);
	}

	function detalhado(){
		$this->_view  = new ViewRelatorios;
		$this->_view->detalhado();
	}
}