<?php
/**
* Controler da Visualizacoes Page
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

	namespace App\Core\Controllers;

	//Use Classes
	use App\Lib\Main\MainController as MainController;
	use App\Core\Models\Visualizacoes AS VisualizacoesModel;
	use App\Core\Views\Visualizacoes AS VisualizacoesView;
	
	class Visualizacoes extends MainController{

		public $_view;
		
		function Index(){
			//Verifica se esta logado senão redireciona para o painel de login
			MainController::toLogin();

			//Verifica e chama a view da home
			if(file_exists(ROOT.'/app/core/views/Visualizacoes.class.php')){
				$this->_view = new VisualizacoesView;
				$this->_view->VisualizacoesPorPeriodo();
			}else{
				header('Location:'.SITEPATH.'/pageNotFound');
			}
		}

		function Assunto(){
			//Verifica se esta logado senão redireciona para o painel de login
			MainController::toLogin();

			//Verifica e chama a view da home
			if(file_exists(ROOT.'/app/core/views/Visualizacoes.class.php')){
				$this->_view = new VisualizacoesView;
				$this->_view->VisualizacoesPorAssunto();
			}else{
				header('Location:'.SITEPATH.'/pageNotFound');
			}
		}
	}