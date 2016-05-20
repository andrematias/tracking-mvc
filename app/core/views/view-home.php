<?php
	/**
	* 
	*/
	class ViewHome{

		public $_title;
		
		function ShowHome(){
			//Carrega os templates
			$header = file_get_contents(TEMPLATES.'/_includes/header.tpl');
			$nav = file_get_contents(TEMPLATES.'/_includes/nav.tpl');
			$content = file_get_contents(TEMPLATES.'/table_sessions-home.tpl');
			$footer = file_get_contents(TEMPLATES.'/_includes/footer.tpl');

			//Incluindo o titulo na página
			$this->_title = 'Tracking::Sessões';
			$header = str_replace('%%TITLE%%', $this->_title, $header);

			//Incluindo o arquivo de estilo css
			$header = str_replace('%%LINK_CSS_MAIN%%', PUBLIC_PATH.'_css/main.css', $header);

			//Alterando tags dos links no menu
			$nav = str_replace('%%LINK_PERFIL%%', '?go=perfil', $nav);
			$nav = str_replace('%%LINK_LOGGOUT%%', '?go=loggout', $nav);
			$nav = str_replace('%%LINK_SESSOES%%', '?go=home', $nav);
			$nav = str_replace('%%LINK_CONFIGURACOES%%', '?go=configuracoes', $nav);

			//Alterando o nome do usuário
			$nav = str_replace('%%USER_NAME%%', $_SESSION['user'], $nav);

			//Incluindo o avatar do usuário
			$nav = str_replace('%%USER_AVATAR%%', PUBLIC_PATH.'/_imagens/user_avatar.png', $nav);

			echo $header;
			echo $nav;
			echo $content;
			echo $footer;
		}

		function ListSessionsInfos(){
			// echo "TABELA COM INFORMAÇÕES <br>";
		}
	}
