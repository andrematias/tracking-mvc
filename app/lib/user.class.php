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
    public function Atualizar(Sujeito $dados)
    {
        $this->clienteId = $this->GetClienteId($dados->cliente);
        //Atualizar o usuario, clienteId, salvar e atualizar o userId
        //verifica se existe um usuário com os dados passados
        $check = $this->Find($dados->user);
        if (!empty($check)) {
            $this->user = $check['user'];
            $this->userId = $check['id_user'];
            $this->clienteId = $check['id_cliente'];
        } else {
            $this->user = $dados->user;
            $this->clienteId = $this->GetClienteId($dados->cliente);

            //Salvar
            parent::Salvar('tr_user', ['user' => $this->user, 'id_cliente' => $this->clienteId]);
            $this->userId = parent::LastId();
        }
    }

    /**
     * Configura a id do cliente atual na classe
     * @param \App\Lib\Cliente $clienteName Instancia de um cliente
     */
    public function GetClienteId($clienteName)
    {
        $id = parent::Select('tr_cliente', ['id_cliente'], 'WHERE cliente = :cliente', [':cliente' => $clienteName]);
        if (!empty($id)) {
            return (int) $id['id_cliente'];
        }
    }

    /**
     * Método para recuperar um usuario do banco de dados
     * @param string $userHash
     * @return int
     */
    public function Find($userHash)
    {
        $user = parent::Select('tr_user', ['id_user', 'id_cliente', 'user'], 'WHERE user = :user', [':user' => $userHash]);
        if (!empty($user)) {
            return $user;
        }
    }

    /**
     * Retorna o id do usuário atual
     * @return int
     */
    public function GetId()
    {
        return $this->userId;
    }
}
