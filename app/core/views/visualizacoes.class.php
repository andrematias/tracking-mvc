<?php
/**
* View da Home page
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
	namespace App\Core\Views;

	//Use classes
	use App\Lib\Main\MainView;
	
	class Visualizacoes extends MainView{
		
		public $_pageTitle;
		/**
		* Método para renderizar as visualizações por periodo
		*/

		function VisualizacoesPorPeriodo(){

			$this->_pageTitle = 'Tracking::Visualizações por Período';
			// Renderizando o Cabeçalho, menu e sidebar
			echo parent::getDefaultHeader($this->_pageTitle);
			echo parent::getDefaultNav();
			echo parent::getDefaultSidebar();
			echo parent::getDefaultPeriod();

			//Tratando o conteúdo da página
			$content = file_get_contents(TEMPLATES.'/visualizacoes_periodo.tpl');

			//Mensagens
			$this->newMessage('Teste de mensagem de sucesso', 'error');
			$this->showMessages();

			//Substituindo o nome do cliente
			$content = str_replace('%%CLIENTE%%', $_SESSION['cliente'], $content);
			
			//Tratando o Gráfico
			$graphTags = array(
				'%%TITULO%%', 
				'%%SUBTITULO%%',
				'%%CATEGORIAS%%',
				'%%TITULO_Y%%',
				'%%SERIES%%'
			);

			$graphValues = [
				['name'=>'Sessões', 'data' => array(39,146,222,68,70,155,211,90,77,28,33,100,58,23,207,98,557,378,412,345)]
			];

			/*[{"name":"Sessões", "data": [20, 15, 30.1, 10]}]*/

			$graphData = array(
				'Visualizações no Período', 
				'de 25/Maio até 28/Maio',
				'"2016-05-11","2016-05-12","2016-05-13","2016-05-14","2016-05-15","2016-05-16","2016-05-17","2016-05-18","2016-05-19","2016-05-20","2016-05-21","2016-05-22","2016-05-23","2016-05-24","2016-05-25","2016-05-26","2016-05-27","2016-05-28","2016-05-29","2016-05-30"',
				'Quandidade de sessões',
				json_encode($graphValues),
			);

			//Substituindo o conteudo do gráfico
			$content = str_replace($graphTags, $graphData, $content);

			//Renderizando o conteudo da página e o rodapé
			echo $content;
			echo parent::getDefaultFooter();
		}

		/**
		* Método para renderizar as visualizações por assunto
		*/
		public function visualizacoesPorAssunto(){

			$this->_pageTitle = 'Tracking::Visualizações por Assunto';

			// Renderizando o Cabeçalho, menu e sidebar
			echo parent::getDefaultHeader($this->_pageTitle);
			echo parent::getDefaultNav();
			echo parent::getDefaultSidebar();
                        echo parent::getDefaultPeriod();


			//Tratando o conteúdo da página
			$content = file_get_contents(TEMPLATES.'/visualizacoes_assunto.tpl');

			//Mensagens
			$this->newMessage('Teste de mensagem de sucesso', 'success');
			$this->showMessages();

			//Substituindo o nome do cliente
			$content = str_replace('%%CLIENTE%%', $_SESSION['cliente'], $content);
			echo $content;

			// renderizando o rodapé
			echo parent::getDefaultFooter();;
		}
	}
