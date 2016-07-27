<?php 
/**
* Classe MainView com métodos comuns para as Views
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

	namespace App\Lib\Main;
	
	class MainView{
		/**
		* Método para adicionar mensagem ao buffer
		* @param msg, string mensagem para ser adicionada
		* @param type, string success ou error 
		*/
		public function newMessage($msg, $type){
			global $msgPool;
			if(!is_array($msgPool)){
				$msgPool = array();
			}

			$messages = array(
				'msg'  => $msg,
				'type' => $type
			);

			array_push($msgPool, $messages);
		}

		/**
		* Escreve a mesagem que contem na var global msgPool
		*/
		function showMessages(){
			global $msgPool;
			if(is_array($msgPool) && !empty($msgPool)){
				foreach ($msgPool as $key => $msg) {
					echo '<div id="type_message" class="'.$msg['type'].'">'
							.$msg['msg'].
							'<span id="close">x</span>
						</div>';
				}
			}
		}

		/**
		* Método para carregar o template do header padrão já formatado
		* @return string formatada com o header
		*/
		public function getDefaultHeader($pageTitle){
			$header = file_get_contents(TEMPLATES.'/_includes/header.tpl');

			$headerArray = array(
				'%%TITLE%%',
				'%%LINK_CSS_MAIN%%',
				'%%LINK_JS_MAIN%%'
			);

                        $scripts = array(
                            '<script type="text/javascript" src="'.PUBLIC_PATH.'_js/jquery-1.10.2.js"></script>'."\n",
                            '<script type="text/javascript" src="'.PUBLIC_PATH.'_js/gathere/main.js"></script>'."\n",
                            '<script type="text/javascript" src="'.PUBLIC_PATH.'_js/hightchart/highcharts.js"></script>'."\n",
                            '<script type="text/javascript" src="'.PUBLIC_PATH.'_js/main.js"></script>',
                            '<script src="'.PUBLIC_PATH.'_js/jquery-ui.js"></script>
'
                        );

                        $styles = array(
                            '<link rel="stylesheet" type="text/css" href="'.PUBLIC_PATH.'_css/style.css">'."\n",
                            '<link href="http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext" rel="stylesheet" type="text/css">'."\n",
                            '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">'
                        );

			$headerValues= array(
				$pageTitle,
                                implode('',$scripts),
                                implode('',$styles)
			);


			//Substituindo os valores e retornando seu valor
			return str_replace($headerArray, $headerValues, $header);
		}


		/**
		* Método para carregar o template da barra de Navegação padrão já 
		* formatado
		* @return string formatada com a NavBar
		*/
		public function getDefaultNav(){
			$nav = file_get_contents(TEMPLATES.'/_includes/nav.tpl');
			$navArray = array(
				'%%PERFIL%%',
				'%%LOGGOUT%%',
				'%%HOME%%', 
				'%%RELATORIOS%%', 
				'%%CONFIGURACOES%%', 
				'%%USER_NAME%%',
				'%%USER_AVATAR%%'
			);

			$navValues = array(
				SITEPATH.'/perfil', 
				'?go=loggout', 
				SITEPATH, 
				SITEPATH.'/relatorios', 
				SITEPATH.'/configuracoes',  
				$_SESSION['user'],
				PUBLIC_PATH.'/_imagens/user_avatar.png'
			);

			//Substituindo os valores do NavBar
			return str_replace($navArray, $navValues, $nav);
		}


		/**
		* Método para carregar o template do sidebar padrão já formatado
		* @return string formatada com o sidebar
		*/
		public function getDefaultSidebar(){
			$sidebar = file_get_contents(TEMPLATES.'/_includes/sidebar.tpl');
			$sidebarTags = array(
					'%%VISUALIZACOES_POR_PERIODO%%',
					'%%VISUALIZACOES_POR_ASSUNTO%%',
					'%%MEDIA_PERMANENCIA%%',
					'%%POST_FACEBOOK%%',
					'%%POST_LINKEDIN%%',
					'%%POST_GOOGLE_PLUS%%',
					'%%TRAFEGO_ATUAL%%',
					'%%PONTUACAO%%',
					'%%MAILING%%',
					'%%LEADS%%'
				);

			$sidebarValues = array(
					SITEPATH.'/visualizacoes/periodo',
					SITEPATH.'/visualizacoes/assunto',
					SITEPATH.'/media/permanencia',
					SITEPATH.'/posts/facebook',
					SITEPATH.'/posts/linkedin',
					SITEPATH.'/posts/google',
					SITEPATH.'/trafego',
					SITEPATH.'/pontuacao',
					SITEPATH.'/mailing',
					SITEPATH.'/leads',
				);
			return str_replace($sidebarTags, $sidebarValues, $sidebar);
		}


		/**
		* Método para carregar o template do footer padrão já formatado
		* @return string formatada com o footer
		*/
		public function getDefaultFooter(){
			return file_get_contents(TEMPLATES.'/_includes/footer.tpl');
		}

                public function getDefaultPeriod(){
                    $period = file_get_contents(TEMPLATES.'_includes/period.tpl');
                    $periodTags = array(
                        '%%CLIENTE%%'
                    );

                    $periodTagValues = array(
                        $_SESSION['cliente']
                    );

                    return str_replace($periodTags, $periodTagValues, $period);
                }
	}