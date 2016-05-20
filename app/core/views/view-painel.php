<?php
/**
* 
*/
class ViewLogin{

	public $_title = 'Painel de Login';
	
	function ShowPainel($clientes){
		//Carrega os templates
		$header = file_get_contents(TEMPLATES.'header-painelLogin.tpl');
		$content = file_get_contents(TEMPLATES.'content-painelLogin.tpl');
		$footer  = file_get_contents(TEMPLATES.'footer-painelLogin.tpl');

		//Atribui o titulo a página
		$header = str_replace('%%TITLE%%', $this->_title, $header);
		//Inclui o link do css
		$header = str_replace('%%LINK_CSS_MAIN%%', PUBLIC_PATH.'_css/main.css', $header);

		//Renderiza o cabeçalho do painel
		echo $header;

		//Substitui o valor da tag de imagem pelo caminho absoluto para o logo
		$content = str_replace('%%IMAGE_LOGO%%', PUBLIC_PATH.'_imagens/logo_painel.png', $content);

		//Mensagem de erro
		if(isset($_REQUEST['error']) && $_REQUEST['error'] == true){
			$content = str_replace('%%CLASS_MSG%%', 'error', $content);
			$content = str_replace('%%MSG_ERROR%%', 'error', $content);
		}else{
			$content = str_replace('%%CLASS_MSG%%', '', $content);
			$content = str_replace('%%MSG_ERROR%%', '', $content);
		}

		if(!empty($clientes) && is_array($clientes)){
			/*Variavel para armazenar as options da lista de clientes passadas
			* pelo parametro Array $clientes
			*/
			$listClients = '';

			/*Iteração para criar as options*/
			foreach($clientes as $cliente) {
				$listClients .= '<option>'.$cliente['cliente'].'</option>';
			}

			//Substitui a tag pela lista formatada de options com os clientes
			$content = str_replace('%%CLIENT_OPTIONS%%', $listClients, $content);

			//eliminando a string da $listClients
			unset($listClients);
		}

		//Rederiza o conteudo do painel
		echo $content;

		//Renderiza o rodapé
		echo $footer;
	}
}