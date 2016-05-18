<?php
/**
* Classe para tratar as informações do painel de login e definir as variaveis 
* de sessão em $_SESSION
*/
class ModelLogin extends MainModel{
	/**
	* Propriedade padrão para inserir dados na tabela de login
	* @access private
	*/
	private $_sqlInsert = 'INSERT INTO user (nome, senha) VALUES(?, ?)';

	/**
	* Propriedade padrão para update de dados na tabela de login
	* @access private
	*/
	private $_sqlUpdate = 'UPDATE user SET user = ?, senha = ? WHERE id = ?';

	/**
	* Propriedade padrão para selecionar dados na tabela de login
	* @access private
	*/
	private $_sqlSelect = 'SELECT * FROM user WHERE nome = ? AND senha = ?';

	/**
	* Propriedade para guardar o nome de usuário
	* @access private
	*/
	private $_user;

	/**
	* Propriedade para guardar a senha do usuário
	* @access private
	*/
	private $_senha;


	/**
	* Método para verificar a correspondencia de um usuário na tabela de Login
	* @param passados via função call_user_func_array no controller de Login
	* @access public
	* @return Booleano.
	*/
	public function CheckUser(){
		parent::__construct();
		$users = $this->Select($this->_sqlSelect, func_get_args());
		if($users){
			foreach ($users as $user) {
				if(($user['nome'] == func_get_arg(0)) &&($user['senha'] == func_get_arg(1))){
					$this->setUser(func_get_arg(0));
					$this->setSenha(func_get_arg(1));
					return true;
				}else{
					return false;
					exit();
				}
			}
		}
	}

	/**
	* Método para definir as variáveis de sessão em $_SESSION
	* Utiliza os métodos desta classe para definir os valores pelos parametros
	* _user e _senha
	* @return GLOBAL $_SESSION
	* @access public
	*/
	public function setSessionVars(){
		$_SESSION['user'] = $this->getUser();
		$_SESSION['pass'] = $this->getSenha();
		return $_SESSION;
	}

	/**
	* Método para configurar o valor do parametro _user
	* @access public
	*/
	public function setUser($userName){
		$this->_user = $userName;
	}

	/**
	* Método para configurar o valor do parametro _senha
	* @access public
	*/
	public function setSenha($userSenha){
		$this->_senha = $userSenha;
	}

	/**
	* Método para recuperar o valor do parametro _user
	* @access public
	*/
	public function getUser(){
		return $this->_user;
	}

	/**
	* Método para recuperar o valor do parametro _senha
	* @access public
	*/
	public function getSenha(){
		return $this->_senha;
	}
}