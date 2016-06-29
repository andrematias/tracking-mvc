<?php

namespace App\Lib;

/**
 * Classe com atributos para os origems configurado
 *
 * @author André Matias
 */
class Origem extends Observador
{

    /**
     * Identificação do origem
     * @var int
     */
    private $origemId;

    /**
     * Linha de negócio
     * @var string
     */
    private $score;

    /**
     * Tipo de origem
     * @var string
     */
    private $origem;

    /**
     * Método Construtor da classe
     */
    public function __construct()
    {
        //Método construtor da classe herdada
        parent::__construct();
    }

    /**
     * Atualiza a classe origem com os dados passados pela classe observada
     * @param \App\Lib\Sujeito $dados instancia da classe Sujeito
     */
    public function atualizar(Sujeito $dados)
    {
        $this->origem = $dados->origem;
        $this->score = $dados->score;

        //Verifica, salva ou atualiza        
        $origemValues = array(
            'source' => $this->origem,
            'default_score' => $this->score
        );

        $check = $this->find($origemValues);
        if (!empty($check)) {
            $this->origemId = $check['id_source'];
        } else {
            $origemValues = array(
                'source' => $this->origem,
                'default_score' => $this->score
            );

            $new = $this->newOrigem($origemValues);

            $this->origemId = ($new) ? parent::LastId() : null;
        }
    }

    /**
     * Salva um novo origem no Banco de dados
     * @param array $origemValues
     * @return boolean
     */
    public function newOrigem(Array $origemValues)
    {
        return parent::Salvar('tr_source', $origemValues);
    }

    /**
     * Retorna o origem procurado
     * @param string|array $origemValues
     * @return array
     */
    public function find($origemValues)
    {
        if (is_array($origemValues) && !empty($origemValues)) {
            $arr = $origemValues;
            unset($origemValues);

            $keys = \array_keys($arr);

            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key . ' = :' . $key . ' AND ';
            }

            $cond = trim(rtrim($cond, ' AND '));
        } else {
            $arr = array();
            \parse_str($origemValues, $arr);

            $keys = \array_keys($arr);

            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key . ' = :' . $key . ' AND ';
            }

            $cond = \trim(\rtrim($cond, ' AND '));
        }

        $origem = parent::Select('tr_source', [], 'WHERE ' . $cond, $arr);

        return ($origem) ? $origem : null;
    }

    /**
     * Retorna a id de origem
     * @return int
     */
    public function getOrigemId()
    {
        return $this->origemId;
    }

    /**
     * Retorna a linha de negocio atual
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Retorna o origem atual
     * @return string
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * Configura o id do origem
     * @param int $origemId
     */
    public function setOrigemId($origemId)
    {
        $this->origemId = $origemId;
    }

    /**
     * Configura a linha de negocio
     * @param string $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Configura o origem
     * @param string $origem
     */
    public function setOrigem($origem)
    {
        $this->origem = $origem;
    }

    /**
     * Retorna a lista de Origem e score
     * @return array
     */
    public function listarOrigem()
    {
        return parent::SelectAll('tr_source');
    }
}