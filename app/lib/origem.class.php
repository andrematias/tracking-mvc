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
    
    /**
     * Retorna todas as origens de um usuário separada por "," baseado na 
     * navegação entre as urls das sessões
     * @param int $userId
     * @return string todas as origens separadas por ","
     */
    public function getOrigensByUserId($userId)
    {
        $conn = parent::getConn();
        $query = $conn->prepare(
            "SELECT source AS origem FROM tr_source "
            . "JOIN tr_url USING(id_source)"
            . "JOIN tr_session USING(id_url)"
            . "JOIN tr_user USING(id_user)"
            . "WHERE id_user = :userId "
            . "GROUP BY origem"
        );
        
        $query->execute([':userId' => $userId]);
        $results = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        $out = null;
        
        foreach ($results as $result){
            $out .= $result['origem'].", ";
        }
        
        return \rtrim($out, ', ');
    }
    
    /**
     * Retorna a soma de todos os scores acumulados durante as sessões do usuário
     * @param int $userId
     * @return int soma dos scores
     */
    public function getScoreByUserId($userId)
    {
        $conn = parent::getConn();
        $query = $conn->prepare(
            "SELECT default_score AS score FROM tr_source "
            . "JOIN tr_url USING(id_source)"
            . "JOIN tr_session USING(id_url)"
            . "JOIN tr_user USING(id_user)"
            . "WHERE id_user = :userId "
        );
        
        $query->execute([':userId' => $userId]);
        $results = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        $score = null;
        
        foreach ($results as $result){
            $score += (int)$result['score'];
        }
        
        return $score;
    }
}
