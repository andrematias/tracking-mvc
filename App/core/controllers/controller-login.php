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
			if(isset($_POST['op']) && !empty($_POST['user']) && !empty($_POST['pass'])){
				@$this->_params = [$_POST['user'], parent::encode64($_POST['pass'])];
				$this->_logged = $this->_modelLogin->CheckUser($this->_params);
			}
			// $_REQUEST['error'] = ((bool)$check == false) ? TRUE : false;

			//Envia os clientes rastreados para as opções no painel de login
			$clientes = $this->_modelLogin->getTrackingsClient();

			//Mostra o painel de Login ao usuário
			$this->_viewPainel->ShowPainel($clientes);


			//definir as variaveis de sessão e enviar o usuário para home
			if($this->_logged == true){
				$this->_modelLogin->setSessionVars();
				header('Location:'.SITEPATH);
			}

		}else{
			header('Location:'.SITEPATH.'/pageNotFound');
		}
	}
}