<?php
	/**
	* 
	*/
	class ViewHome extends MainView{

		public $_title;
		
		function ShowHome(){
			//Carrega os templates
			$header = file_get_contents(TEMPLATES.'/_includes/header.tpl');
			$nav = file_get_contents(TEMPLATES.'/_includes/nav.tpl');
			$sidebar = file_get_contents(TEMPLATES.'/_includes/sidebar.tpl');
			$content = file_get_contents(TEMPLATES.'/home.tpl');
			$footer = file_get_contents(TEMPLATES.'/_includes/footer.tpl');

			//Incluindo o titulo na página
			$this->_title = 'Tracking::Home';
			$header = str_replace('%%TITLE%%', $this->_title, $header);

			//Incluindo o arquivo de estilo css
			$header = str_replace('%%LINK_CSS_MAIN%%', PUBLIC_PATH.'_css/style.css', $header);
			$header = str_replace('%%LINK_JS_MAIN%%', PUBLIC_PATH.'_js/main.js', $header);

			//Alterando tags dos links no menu
			$nav = str_replace('%%PERFIL%%', SITEPATH.'/perfil', $nav);
			$nav = str_replace('%%LOGGOUT%%', '?go=loggout', $nav);
			$nav = str_replace('%%HOME%%', SITEPATH, $nav);
			$nav = str_replace('%%RELATORIOS%%', SITEPATH.'/relatorios', $nav);
			$nav = str_replace('%%CONFIGURACOES%%', SITEPATH.'/configuracoes', $nav);

			//Alterando o nome do usuário
			$nav = str_replace('%%USER_NAME%%', $_SESSION['user'], $nav);

			//Incluindo o avatar do usuário
			$nav = str_replace('%%USER_AVATAR%%', PUBLIC_PATH.'/_imagens/user_avatar.png', $nav);

			echo $header;
			echo $nav;
			echo $sidebar;

			$this->newMessage('Teste de mensagem de sucesso', 'success');
			$this->showMessages();

			//Grafico
			$content = str_replace('%%TITULO%%', 'Visualizações no Período', $content);
			
			echo $content;
			echo $footer;
		}
	}
