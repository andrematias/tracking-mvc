<?php
/**
* 
*/
class ViewLogin{

	public $_title = 'Painel de Login';
	
	function __construct(){
		$header = file_get_contents(TEMPLATES.'header-painelLogin.tpl');
		$content = file_get_contents(TEMPLATES.'content-painelLogin.tpl');
		$footer  = file_get_contents(TEMPLATES.'footer-painelLogin.tpl');
		$header = str_replace('%%TITLE%%', $this->_title, $header);
		$header = str_replace('%%LINK_CSS_MAIN%%', SITEPATH.'/public/main.css', $header);
		echo $header;
		echo $content;
		echo $footer;
	}
}