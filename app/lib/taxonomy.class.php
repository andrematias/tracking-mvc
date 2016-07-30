<?php

/**
 * Classe reponsável por atribuir taxonomias aos objetos
 * Atribui, busca e exclui caracteristicas únicas para
 * o objeto referenciado
 * 
 * @author André Matias
 * @version 0.1
 * @link http://github.com/andrematias Perfil no GitHub
 * @link andrersmatias@gmail.com email para contato direto
 *
 * Queries utilizadas com o banco de dados
 * 
 * SQL de Criação de taxonomia para um objeto:
 * INSERT INTO tr_term (name) VALUES ([value_for_term]);
 * INSERT INTO tr_taxonomy_term (term_id, taxonomy, [descricao], [count])
 *  VALUES ([INT term_id], [VARCHAR(50) taxonomy], [VARCHAR(50) descricao], [INT count]);
 * INSERT INTO tr_taxonomy_relationships (object_id, taxonomy_id)
 *  VALUES ([INT object_id], [INT taxonomy_id]);
 *
 * SQL de busca por taxonomia:
 *  SELECT * FROM [tabela_do_objeto] AS [table_alias]
 *  JOIN tr_taxonomy_relationshipt AS [taxonomy_relationshipt_alias]
 *      ON [taxonomy_relationshipt_alias].object_id = [table_alias].object_id
 *  JOIN tr_taxonomy_term AS [taxonomy_term_alias]
 *      ON [taxonomy_term_alias].taxonomy_id = [taxonomy_relationshipt_alias].taxonomy_id
 *  JOIN tr_term AS [term_alias]
 *      ON [term_alias].term_id = [taxonomy_term_alias].term_id
 *  WHERE [taxonomy_term_alias] = [term_busca]
 *
 */
namespace App\Lib;

class Taxonomy extends Observador
{
    /**
     * Tabela de termos
     * @var string 
     */
    private $tableTerm = 'tr_term';

    /**
     * Tabela de taxonomia
     * @var string 
     */
    private $tableTaxonomy = 'tr_taxonomy_term';

    /**
     * Tabela de relação entre taxonomia e objetos
     * @var string 
     */
    private $tableRelationships = 'tr_taxonomy_relationships';

    /**
     * Identificação do termo
     * @var int
     */
    private $termId;

    /**
     * Nome do termo
     * @var string
     */
    private $term;

    /**
     * Identificação da taxonomia
     * @var string
     */
    private $taxonomyId;

    /**
     * Nome da taxonomia
     * @var string 
     */
    private $taxonomy;

    /**
     * Descrição da taxonomia
     * @var string 
     */
    private $descricao;

    /**
     * Quantidade da taxonomia
     * @var int
     */
    private $count;

    
    /**
     * Implementação da classe Observador, método para atualizar os dados da 
     * classe e do banco de dados com as informações recebidas da classe Sujeito
     * @param \App\Lib\Sujeito $dados classe observada
     * @return boolean
     */
    public function atualizar(Sujeito $dados)
    {
        $taxonomy = $this->loadTaxonomyTerm($dados->taxonomy);
        $term     = $this->loadTerm($dados->term);

        $dataReceived = array(
            'taxonomy'  => $dados->taxonomy,
            'name'      => $dados->term,
            'object_id' => $dados->taxonomyObjectId,
            'descricao' => $dados->taxonomyDescription,
            'count'     => $dados->taxonomyCount
        );

        if($term && $taxonomy){

        }else{
            return $this->newTaxonomy($dataReceived);
        }

    }

    /**
     * Salva uma nova taxonomia atribuida a um objeto
     * @param array|string $taxonomyInfos
     * indices do parametro:
     *  string  name      [obrigatório]
     *  string  taxonomy  [obrigatório]
     *  integer object_id [obrigatorio]
     *  string  descricao [opcional]
     *  integer count     [opcional]
     * e.g.: string name=[valorName]&taxonomy=[taxonomyName]&object_id=[number]
     * e.g.: array associative ['name' => 'ValueTerm', 'taxonomy' => 'ValueTaxonomy']
     * @return boolean
     */
    public function newTaxonomy($taxonomyInfos){

        $arr = array();

        if( !empty($taxonomyInfos) && !is_array($taxonomyInfos) ){
            parse_str($taxonomyInfos, $arr);
            unset($taxonomyInfos);
        }else{
            $arr = $taxonomyInfos;
            unset($taxonomyInfos);
        }

        $this->descricao = (isset($arr['descricao'])) ? $arr['descricao'] : NULL;
        $this->count     = (isset($arr['count'])) ? $arr['count'] : NULL;


        $this->log = $this->loadTerm($arr['name']);
        if(!isset($this->termId)){
           parent::salvar($this->tableTerm, ['name' => $arr['name']]);
           $this->termId = parent::lastId();
        }
        
        $this->loadTaxonomyTerm($arr['taxonomy']);
        if(!isset($this->taxonomyId)){
            $taxParam = array(
                'term_id'   => $this->termId,
                'taxonomy'  => $arr['taxonomy'],
                'descricao' => $this->descricao,
                'count'     => $this->count
            );

            parent::salvar($this->tableTaxonomy, $taxParam);
            $this->taxonomyId = parent::lastId();
        }
            
        $relParam = array(
            'object_id' => $arr['object_id'],
            'taxonomy_id' => $this->taxonomyId
        );
        return parent::salvar($this->tableRelationships, $relParam);                
    }

    /**
     * Carrega para a instancia atual os valores da taxonomia gravada no Banco
     * @param string $taxonomy o nome da taxonomia
     * @return boolean
     */
    private function loadTaxonomyTerm($taxonomy)
    {
        $tax = parent::select(
            $this->tableTaxonomy,
            [],
            'WHERE taxonomy = :taxonomy',
            [':taxonomy' => $taxonomy]
        );

        if($tax){
            $this->taxonomy      = $tax['taxonomy'];
            $this->descricao     = $tax['descricao'];
            $this->count         = $tax['count'];
            $this->termId        = $tax['term_id'];
            $this->taxonomyId    = $tax['taxonomy_id'];
            unset($tax);
            return true;
        }

        return false;
    }

    /**
     * Carrega para a instancia atual os valores do termo cadastrados no banco
     * @param string $termName o nome do termo procurado
     * @return boolean
     */
    private function loadTerm($termName)
    {
        $term = parent::select(
            $this->tableTerm,
            ['term_id', 'name'],
            'WHERE name = :term',
            [':term' => $termName]
        );

        if($term){
            $this->termId = $term['term_id'];
            $this->term = $term['name'];
            unset($term);
            return true;
        }

        return false;
    }

    /**
     * Retorna todas as taxonomias de um objeto
     * @param int $objectId identificação do objeto
     * @param string $objectType tipo do objeto que possui a taxonomia
     * @return array
     */
    public function getObjectTaxonomies($objectId, $objectType)
    {
        $prefix = 'tr_';

        $taxonomies = parent::selectAll(
            //Tables Join
            $prefix.$objectType.' AS obj'
            . ' JOIN '.$this->tableRelationships.' AS tr ON tr.object_id = obj.id_'.$objectType
            . ' JOIN '.$this->tableTaxonomy.' AS tt ON tt.taxonomy_id = tr.taxonomy_id'
            . ' JOIN '.$this->tableTerm.' AS tm ON tm.term_id = tt.term_id',

            //Columns
            ['taxonomy', 'descricao', 'count', 'name'],

            //Where
            'WHERE tr.object_id = :objectId',

            //Where Values
            [':objectId' => $objectId]
        );
        return $taxonomies;
    }
}