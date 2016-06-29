<?php

namespace App\Lib;

/**
 * Classe Base com as propriedades de mailing dos cliente cadastrados.
 *
 * @author André Matias
 */
class Base extends Observador
{
    /**
     * Identificação dos dados na base
     * @var int
     */
    private $baseId;

    /**
     * Identificação do cliente cadastrado na base
     * @var int
     */
    private $clienteId;

    /**
     * Identificação do usuário relacionado a base
     * @var int
     */
    private $userId;

    /**
     * Email do usuário
     * @var string
     */
    private $email;

    /**
     * Nome do usuário
     * @var string
     */
    private $nome;

    /**
     * Nome da empresa
     * @var string
     */
    private $empresa;

    /**
     * Cargo do usuário na empresa
     * @var string
     */
    private $cargo;

    /**
     * Endereço do usuário
     * @var string
     */
    private $endereco;

    /**
     * Cep da rua do usuário ou empresa
     * @var string
     */
    private $cep;

    /**
     * Estado do usuário
     * @var string
     */
    private $estado;

    /**
     * Cidade do usuário
     * @var string
     */
    private $cidade;

    /**
     * Pais do usuário
     * @var string
     */
    private $pais;

    /**
     * CNPJ da empresa
     * @var string
     */
    private $cnpj;

    /**
     * Ramo de atividade da empresa
     * @var string
     */
    private $ramo;

    /**
     * Telefone para contato do usuário ou empresa
     * @var string
     */
    private $telefone;

    /**
     * Tipo de lead, indireto ou direto
     * @var string
     */
    private $leadType;

    /**
     * Construtor da classe
     */
    public function __construct()
    {
        //Construtor da classe herdada DbTrack
        parent::__construct();
    }

    /**
     * Método para atualizar os dados da classe com as informações notificadas
     * @param \App\Lib\Sujeito $dados instancia da classe Sujeito
     * @return boolean
     */
    public function atualizar(Sujeito $dados)
    {
        $this->clienteId = $this->clienteId($dados->cliente);
        $this->userId    = $this->userId($dados->user);
        $this->email     = $dados->email;
        $this->nome      = $dados->nome;
        $this->empresa   = $dados->empresa;
        $this->cargo     = $dados->cargo;
        $this->endereco  = $dados->endereco;
        $this->cep       = $dados->cep;
        $this->estado    = $dados->estado;
        $this->cidade    = $dados->cidade;
        $this->pais      = $dados->pais;
        $this->cnpj      = $dados->cnpj;
        $this->ramo      = $dados->ramo;
        $this->telefone  = $dados->telefone;
        $this->leadType  = $dados->leadType;


        $baseParams = array(
            'id_cliente' => $this->clienteId,
            'email' => $this->email
        );
        $check      = $this->find($baseParams);
        if (!empty($check)) {
            $this->baseId = $check['id_base'];

            //cria um array associativo com os valores informados a classe
            $vars = array(
                'id_cliente' => $this->clienteId,
                'id_user' => $this->userId,
                'email' => $this->email,
                'empresa' => $this->empresa,
                'nome' => $this->nome,
                'telefone' => $this->telefone,
                'ramo' => $this->ramo,
                'cnpj' => $this->cnpj,
                'pais' => $this->pais,
                'cidade' => $this->cidade,
                'estado' => $this->estado,
                'cep' => $this->cep,
                'endereco' => $this->endereco,
                'cargo' => $this->cargo,
                'lead_type' => $this->leadType
            );

            //Remove os valores vazios do array vars
            foreach ($vars as $key => $value) {
                \trim($value);
                if (empty($value)) {
                    unset($vars[$key]);
                }
            }

            //Verifica os valores diferentes com o banco de dados
            $up = \array_diff($vars, $check);

            //Atualiza o banco com os valores diferentes
            return parent::update($this->baseId, 'tr_base', $up);
        } else {
            $baseValues = array(
                'id_cliente' => $this->clienteId,
                'id_user' => $this->userId,
                'email' => $this->email,
                'empresa' => $this->empresa,
                'nome' => $this->nome,
                'telefone' => $this->telefone,
                'ramo' => $this->ramo,
                'cnpj' => $this->cnpj,
                'pais' => $this->pais,
                'cidade' => $this->cidade,
                'estado' => $this->estado,
                'cep' => $this->cep,
                'endereco' => $this->endereco,
                'cargo' => $this->cargo,
                'lead_type' => $this->leadType
            );

            $new = $this->newBase($baseValues);

            $this->baseId = ($new) ? parent::lastId() : null;
        }
    }

    /**
     * Salva novos dados na Base do Banco de dados
     * @param array $baseValues
     * @return boolean
     */
    public function newBase(Array $baseValues)
    {
        return parent::salvar('tr_base', $baseValues);
    }

    /**
     * Retorna o id do cliente cadastrado no banco de dados
     * @param string $clienteName
     * @return int
     */
    private function clienteId($clienteName)
    {
        $id = parent::select('tr_cliente', ['id_cliente'],
                'WHERE cliente = :cliente', [':cliente' => $clienteName]);
        return (!empty($id)) ? (int) $id['id_cliente'] : null;
    }

    /**
     * Retorna o id do usuário cadastrado no banco
     * @param string $userName
     * @return int
     */
    private function userId($userName)
    {
        $id = parent::select('tr_user', ['id_user'], 'WHERE user = :user',
                [':user' => $userName]);
        return (!empty($id)) ? (int) $id['id_user'] : null;
    }

    /**
     * Retorna a base de dados cadastrada para o email e id cliente cadastrado
     * @param string|Array $baseParams
     * @return array
     */
    public function find($baseParams)
    {
        if (is_array($baseParams) && !empty($baseParams)) {
            $arr  = $baseParams;
            unset($baseParams);
            $keys = \array_keys($arr);

            $cond = null;
            foreach ($keys as $key) {
                $cond .= $key.' = :'.$key.' AND ';
            }
            $cond = \trim(\rtrim($cond, ' AND '));
        } else {
            $arr = array();
            \parse_str($baseParams, $arr);

            $keys = \array_keys($arr);

            $cond = null;
            foreach ($keys as $key) {
                $cond .= $key.' = :'.$key.' AND ';
            }
            $cond = \trim(\rtrim($cond, ' AND '));
        }

        $base = parent::select('tr_base', [], 'WHERE '.$cond, $arr);
        return ($base) ? $base : null;
    }

    /**
     * Configura um novo valor para a propriedade escolhida
     * @param string $proprerty o nome da propriedade
     * @param string $value valor a definir na propriedade
     */
    public function set($proprerty, $value)
    {
        $this->{$proprerty} = $value;
    }

    /**
     * Retorna o valor da propriedade solicitada
     * @param string $property o nome da propriedade
     * @return string
     */
    public function get($property)
    {
        return $this->{$property};
    }
}