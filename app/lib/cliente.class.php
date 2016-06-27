<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib;

/**
 * Description of cliente
 *
 * @author Enterprise
 */
class Cliente extends Observador
{

    /**
     * Identificação única para um cliente
     * @var int
     */
    private $clienteId;

    /**
     * Nome do cliente cadastrado para o rastreamento
     * @var string
     */
    private $cliente;

    /**
     * Recupera uma conexão com um Banco de Dados instanciado fora da classe
     * @param \App\Lib\DbTrack $dbInstance instancia de um Banco de dados
     */
    public function __construct()
    {
        //Método construtor do Banco de dados
        parent::__construct();
    }

    /**
     * Método para atualizar os dados da classe
     * @param \App\Lib\Sujeito $dados instancia da classe que esta sendo
     * observada
     */
    public function Atualizar(Sujeito $dados)
    {
        //Atribui os valores informados para instancia atual
        $setCliente = $this->SetCliente($dados->cliente);

        //Verifica se já existe o cliente no Banco de dados
        $find = $this->Find($this->cliente);

        if (empty($find) && $setCliente) {
            //Salva as informações no Banco de dados
            parent::Salvar('tr_cliente', ['cliente' => $this->cliente]);
            $this->clienteId = parent::LastId();
        } else {
            $this->cliente   = $find['cliente'];
            $this->clienteId = $find['id_cliente'];
        }
    }

    /**
     * Recupera o id de um cliente no banco de dados
     * @param string $cliente
     * @return int
     */
    public function Find($cliente)
    {
        $out = parent::Select(
                'tr_cliente', ['id_cliente', 'cliente'], 'WHERE cliente = :cliente', [':cliente' => $cliente]
        );
        if (!empty($out)) {
            return $out;
        }
    }

    /**
     * Método para pegar o id corrente da instancia
     * @return int
     */
    public function GetId()
    {
        return $this->clienteId;
    }

    /**
     * Método para retornar o nome do cliente
     * @return string
     */
    public function GetCliente()
    {
        return $this->cliente;
    }

    /**
     * Configura um novo cliente para a instancia atual
     * @param string $cliente
     * @return boolean
     */
    public function SetCliente($cliente)
    {
        if ($this->CheckDomain($cliente)) {
            $this->cliente = \str_replace('www.', '', $cliente);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verificar se o cliente é um dominio válido
     * e.g. http://www.dominio.com.br
     * @param string $cliente
     * @return boolean
     */
    private function CheckDomain($cliente)
    {
        return \preg_match('/^http[s]?:\/\/(www\.)?[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,10}$/', $cliente);
    }

    /**
     * Método para listar todas os clientes cadastrados no banco
     * @return Array Assoc
     */
    public function ListarClientes()
    {
        return parent::SelectAll('tr_cliente');
    }
}