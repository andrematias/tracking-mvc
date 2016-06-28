<?php

/**
* 
*/

namespace App\Core\Views;

use App\Lib\Main\MainView;

class Relatorios extends MainView
{
	public $_pageTitle;
	
	function consolidado()
	{
		$this->_pageTitle = 'Trakcing::Relatório Consolidado';

		echo parent::getDefaultHeader($this->_pageTitle);
		echo parent::getDefaultNav();
		echo parent::getDefaultSidebar();
		$content = file_get_contents(TEMPLATES.'/relatorio_consolidado.tpl');
		
		echo $content;
		echo parent::getDefaultFooter();
	}

	function detalhado()
	{
		$this->_pageTitle = 'Trakcing::Relatório Detalhado';

		echo parent::getDefaultHeader($this->_pageTitle);
		echo parent::getDefaultNav();
		echo parent::getDefaultSidebar();
		$content = file_get_contents(TEMPLATES.'/relatorio_detalhado.tpl');
		
		echo $content;

		echo parent::getDefaultFooter();
	}
}