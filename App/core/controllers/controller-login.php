<?php
/**
* Classe para controlar as ações no painel de Login
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
class Login extends MainController{

	/**
	* _viewPainel propriedade para o Obj da classe que renderiza o painel na 
	* tela.
	*/
	public $_viewPainel;

	/**
	* _modelLogin propriedade para o Obj da classe de modelagem dos dados 
	* obtidos pelo painel.
	*/
	public $_modelLogin;

	public $_params = [];

	/**
	* _404 propriedade para chamar a página em caso de alguma falha
	*/
	public $_404 = '_includes/404.html';


	/**
	* Método padrão da classe implementa a view do painel, modelagem dos dados
	* e redirecionadores
	*/
	public function Index(){
		if(file_exists(ROOT.'/App/core/views/view-painel.php')){
			require_once(ROOT.'/App/core/views/view-painel.php');
			require_once(ROOT.'/App/core/models/model-painelLogin.php');
			$this->_viewPainel = new ViewLogin();
			$this->_modelLogin = new ModelLogin();

			//Verificar se existe o usuário 
			// $this->_modelLogin->CheckLogin();
			@$this->_params = [$_POST['user'], $_POST['pass']];
			$this->_logged = call_user_func_array([$this->_modelLogin, 'CheckUser'], @$this->_params);

			//definir as variaveis de sessão
			if($this->_logged == true){
				$this->_modelLogin->setSessionVars();
			}

			//Redireciona o usuário para a página após o login
			if(parent::CheckSession() == true){
				header('Location:'.SITEPATH);
			}
		}else{
			include_once(TEMPLATES.$this->_404);
		}
	}
}