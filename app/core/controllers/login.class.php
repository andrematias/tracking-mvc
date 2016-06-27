<?php
/**
* Classe para controlar as ações no painel de Login
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
namespace App\Core\Controllers;

//Use classes
use App\Lib\Main\MainController as MainController;
use App\Core\Views\Painel AS ViewPainel;
use App\Core\Models\Painel AS ModelPainel;

class Login extends MainController{

	/**
	* viewPainel propriedade para o Obj da classe que renderiza o painel na 
	* tela.
	*/
	public $viewPainel;

	/**
	* modelLogin propriedade para o Obj da classe de modelagem dos dados 
	* obtidos pelo painel.
	*/
	public $modelLogin;

	public $params = [];


	/**
	* Método padrão da classe implementa a view do painel, modelagem dos dados
	* e redirecionadores
	*/
	public function Index(){
		//Verifica se o usuário já esta logado.
		MainController::toHome();
		
		if(file_exists(ROOT.'app/core/views/painel.class.php')){
			$this->viewPainel = new ViewPainel();
			$this->modelLogin = new ModelPainel();

			//Verificar se existe o usuário 
			if(isset($_POST['op']) && !empty($_POST['user']) && !empty($_POST['pass'])){
				/*
				* Descomentar a linha abaixo para ativar a encriptação de senha
				* e comentar a próxima linha
				*/
				@$this->params = [$_POST['user'], parent::encode64($_POST['pass'])];
				//@$this->params = [$_POST['user'], $_POST['pass']];
				$this->logged = $this->modelLogin->CheckUser($this->params);
			}

			//Envia os clientes rastreados para as opções no painel de login
			$clientes = $this->modelLogin->getTrackingsClient();

			//Mostra o painel de Login ao usuário
			$this->viewPainel->ShowPainel($clientes);


			//definir as variaveis de sessão e enviar o usuário para home
			if($this->logged == true){
				$this->modelLogin->setSessionVars();
				header('Location:'.SITEPATH);
			}

		}else{
			header('Location:'.SITEPATH.'/notfound');
		}
	}
}