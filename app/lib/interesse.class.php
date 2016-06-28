<?php

namespace App\Lib;

/**
 * Classe com atributos para os interesses configurado
 *
 * @author André Matias
 */
class Interesse extends Observador
{

    /**
     * Identificação do interesse
     * @var int
     */
    private $interesseId;

    /**
     * Linha de negócio
     * @var string
     */
    private $linhaDeNegocio;

    /**
     * Tipo de interesse
     * @var string
     */
    private $interesse;

    /**
     * Método Construtor da classe
     */
    public function __construct()
    {
        //Método construtor da classe herdada
        parent::__construct();
    }

    /**
     * Atualiza a classe interesse com os dados passados pela classe observada
     * @param \App\Lib\Sujeito $dados instancia da classe Sujeito
     */
    public function atualizar(Sujeito $dados)
    {
        $this->interesse = $dados->interesse;
        $this->linhaDeNegocio = $dados->linhaDeNegocio;

        //Verifica, salva ou atualiza        
        $interesseValues = array(
            'type_interest' => $this->interesse,
            'type_bl' => $this->linhaDeNegocio
        );

        $check = $this->find($interesseValues);
        if (!empty($check)) {
            $this->interesseId = $check['id_type'];
        } else {
            $interesseValues = array(
                'type_interest' => $this->interesse,
                'type_bl' => $this->linhaDeNegocio
            );

            $new = $this->newInteresse($interesseValues);

            $this->interesseId = ($new) ? parent::LastId() : null;
        }
    }

    /**
     * Salva um novo interesse no Banco de dados
     * @param array $interesseValues
     * @return boolean
     */
    public function newInteresse(Array $interesseValues)
    {
        return parent::Salvar('tr_type', $interesseValues);
    }

    /**
     * Retorna o interesse procurado
     * @param string|array $interesseValues
     * @return array
     */
    public function find($interesseValues)
    {
        if (is_array($interesseValues) && !empty($interesseValues)) {
            $arr = $interesseValues;
            unset($interesseValues);

            $keys = \array_keys($arr);

            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key . ' = :' . $key . ' AND ';
            }

            $cond = trim(rtrim($cond, ' AND '));
        } else {
            $arr = array();
            \parse_str($interesseValues, $arr);

            $keys = \array_keys($arr);

            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key . ' = :' . $key . ' AND ';
            }

            $cond = \trim(\rtrim($cond, ' AND '));
        }

        $interesse = parent::Select('tr_type', [], 'WHERE ' . $cond, $arr);

        return ($interesse) ? $interesse : null;
    }

    /**
     * Retorna a id de interesse
     * @return int
     */
    public function getInteresseId()
    {
        return $this->interesseId;
    }

    /**
     * Retorna a linha de negocio atual
     * @return string
     */
    public function getLinhaDeNegocio()
    {
        return $this->linhaDeNegocio;
    }

    /**
     * Retorna o interesse atual
     * @return string
     */
    public function getInteresse()
    {
        return $this->interesse;
    }

    /**
     * Configura o id do interesse
     * @param int $interesseId
     */
    public function setInteresseId($interesseId)
    {
        $this->interesseId = $interesseId;
    }

    /**
     * Configura a linha de negocio
     * @param string $linhaDeNegocio
     */
    public function setLinhaDeNegocio($linhaDeNegocio)
    {
        $this->linhaDeNegocio = $linhaDeNegocio;
    }

    /**
     * Configura o interesse
     * @param string $interesse
     */
    public function setInteresse($interesse)
    {
        $this->interesse = $interesse;
    }

    /**
     * Retorna a lista de Interesses e linha de negocios
     * @return array
     */
    public function listarInteresses()
    {
        return parent::SelectAll('tr_type');
    }
}
