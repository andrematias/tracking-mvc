<?php

namespace App\Lib;

/**
 * <b>User</b>
 * Classe de Usuário único por clientes rastreados
 *
 * @author Enterprise
 */
class User extends Observador
{

    /**
     * Identificação única para um usuário
     * @var int
     */
    private $userId;

    /**
     * Hash única do usuário
     * @var string
     */
    private $user;

    /**
     * Identificação única do cliente que o usuário pertence
     * @var int
     */
    private $clienteId;

    /**
     * Método construtor da classe User
     * @param \App\Lib\DbTrack $dbInstance Instancia do banco de dados
     */
    public function __construct()
    {
        //construtor do Banco de dados
        parent::__construct();
    }

    /**
     * Método para atualizar os dados da classe com os valores passado pelo 
     * sujeito.
     * @param \App\Lib\Sujeito $dados Instancia da classe Observada
     */
    public function atualizar(Sujeito $dados)
    {
        $this->clienteId = $this->clienteId($dados->cliente);
        //Atualizar o usuario, clienteId, salvar e atualizar o userId
        //verifica se existe um usuário com os dados passados
        $check = $this->Find($dados->user);
        if (!empty($check)) {
            $this->user = $check['user'];
            $this->userId = $check['id_user'];
            $this->clienteId = $check['id_cliente'];
        } else {
            $this->user = $dados->user;
            $this->clienteId = $this->clienteId($dados->cliente);

            //salvar
            $userValues = array(
                'user' => $this->user,
                'id_cliente' => $this->clienteId
            );

            $new = $this->newUser($userValues);
            $this->userId = ($new) ? parent::lastId() : null;
        }
    }

    /**
     * Salva um novo usuário no banco de dados
     * @param array $userValues
     * @return boolean
     */
    public function newUser($userValues)
    {
        return parent::salvar('tr_user', $userValues);
    }

    /**
     * Configura a id do cliente atual na classe
     * @param \App\Lib\Cliente $clienteName Instancia de um cliente
     */
    private function clienteId($clienteName)
    {
        $id = parent::select('tr_cliente', ['id_cliente'], 'WHERE cliente = :cliente', [':cliente' => $clienteName]);
        if (!empty($id)) {
            return (int) $id['id_cliente'];
        }
    }

    /**
     * Método para recuperar um usuario do banco de dados
     * @param string $userHash
     * @return int
     */
    public function find($userHash)
    {
        $user = parent::select('tr_user', ['id_user', 'id_cliente', 'user'], 'WHERE user = :user', [':user' => $userHash]);
        if (!empty($user)) {
            return $user;
        }
    }

    /**
     * Retorna o id do usuário atual
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Retorna o usuário da instancia atual
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retorna o clienteId da instancia atual
     * @return int
     */
    public function getClienteId()
    {
        return $this->clienteId;
    }
    
    /**
     * Configura um id para o cliente
     * @param int $id
     */
    public function setClienteId($id)
    {
        $this->clienteId = $id;
    }
    
    /**
     * Configura um usuário
     * @param string $userName
     */
    public function setUser($userName)
    {
        $this->user = $userName;
    }
    
    /**
     * Configura um id de um usuário
     * @param int $id
     */
    public function setUserId($id)
    {
        $this->userId = $$id;
    }
    
}
