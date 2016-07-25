<?php

namespace App\Lib;

/**
 * <b>Cliente</b>
 * Classe de configuração de clientes rastreados
 *
 * @author André Matias
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
    public function atualizar(Sujeito $dados)
    {
        //Atribui os valores informados para instancia atual
        $setCliente = $this->SetCliente($dados->cliente);

        //Verifica se já existe o cliente no Banco de dados
        $find = $this->Find($this->cliente);

        if (empty($find) && $setCliente) {
            //Salva as informações no Banco de dados
            $value = array(
                'cliente' => $this->cliente
            );
            $new = $this->newCliente($value);
            $this->clienteId = ($new) ? parent::LastId() : null;
        } else {
            $this->cliente   = $find['cliente'];
            $this->clienteId = $find['id_cliente'];
        }
    }

    public function newCliente(Array $values)
    {
        return parent::Salvar('tr_cliente', $values);
    }
    /**
     * Recupera o id de um cliente no banco de dados
     * @param string $cliente
     * @return int
     */
    public function find($cliente)
    {
        $out = parent::select(
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
    public function getId()
    {
        return $this->clienteId;
    }

    /**
     * Método para retornar o nome do cliente
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Configura um novo cliente para a instancia atual
     * @param string $cliente
     * @return boolean
     */
    public function setCliente($cliente)
    {
        if ($this->checkDomain($cliente)) {
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
    private function checkDomain($cliente)
    {
        return \preg_match('/^http[s]?:\/\/(www\.)?[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,10}$/', $cliente);
    }

    /**
     * Método para listar todas os clientes cadastrados no banco
     * @return Array Assoc
     */
    public function listarClientes()
    {
        return parent::selectAll('tr_cliente');
    }

    /**
     * Retorna o id do cliente procurado
     * @param string $cliente
     * @return int id cliente
     */
    public function getClienteId($cliente){
        $id = parent::select('tr_cliente', ['id_cliente'], 'WHERE cliente = :cliente', [':cliente' => $cliente]);
        return (int)$id['id_cliente'];
    }
}