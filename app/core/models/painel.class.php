<?php
/**
 * Classe para tratar as informações do painel de login e definir as variaveis 
 * de sessão em $_SESSION
 * @author: André Matias
 * @version: 0.1
 * @link github.com/Andrematias
 * @link andrersmatias@gmail.com
 */

namespace App\Core\Models;

//Use classes
use App\Lib\Main\MainModel;

class Painel extends MainModel
{

    /**
     * Propriedade para guardar o nome de usuário
     * @access private
     */
    private $user;

    /**
     * Propriedade para guardar a senha do usuário
     * @access private
     */
    private $senha;

    /**
     * Propriedade para guardar o cliente rastreado
     * @access private
     */
    private $cliente;

    /**
     * Método para verificar a correspondencia de um usuário na tabela de Login
     * @param Array com usuário e senha.
     * @access public
     * @return Booleano.
     */
    public function checkUser(Array $infoUser)
    {
        $users = $this->selectAll
            (
            'tr_login', ['name', 'password'], 'WHERE name = ? AND password = ?', $infoUser
        );
        if ($users) {
            foreach ($users as $user) {
                if (
                    ($user['name'] == $infoUser[0]) && ($user['password'] == $infoUser[1])) {
                    $this->setUser($_POST['user']);
                    $this->setSenha($_POST['pass']);
                    $this->setCliente($_POST['clientes']);
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * Método para recuperar do banco de dados os clientes rastreados
     * @return array com os clientes
     */
    public function getTrackingsClient()
    {
        $clientes = new \App\Lib\Cliente($this);
        return $clientes->ListarClientes();
    }

    /**
     * Método para definir as variáveis de sessão em $_SESSION
     * Utiliza os métodos desta classe para definir os valores pelos parametros
     * _user e _senha
     * @return GLOBAL $_SESSION
     * @access public
     */
    public function setSessionVars()
    {
        $_SESSION['user'] = $this->getUser();
        $_SESSION['pass'] = $this->getSenha();
        $_SESSION['cliente'] = $this->getCliente();
        return $_SESSION;
    }

    /**
     * Método para configurar o valor da propriedade _user
     * @access public
     */
    public function setUser($userName)
    {
        $this->_user = $userName;
    }

    /**
     * Método para configurar o valor da propriedade _senha
     * @access public
     */
    public function setSenha($userSenha)
    {
        $this->_senha = $userSenha;
    }

    /**
     * Método para configurar o valor da propriedade _cliente
     * @access public
     */
    public function setCliente($cliente)
    {
        $this->_cliente = $cliente;
    }

    /**
     * Método para recuperar o valor da propriedade _user
     * @access public
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Método para recuperar o valor da propriedade _senha
     * @access public
     */
    public function getSenha()
    {
        return $this->_senha;
    }

    /**
     * Método para recuperar o valor da propriedade _cliente
     * @access public
     */
    public function getCliente()
    {
        return $this->_cliente;
    }
}
