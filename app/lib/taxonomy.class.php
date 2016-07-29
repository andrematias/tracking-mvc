<?php

/**
 * Classe reponsável por atribuir taxonomias aos objetos
 * Atribui, busca e exclui caracteristicas únicas para
 * o objeto referenciado
 * @author André Matias
 *
 *
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
    private $tableTerm = 'tr_term';

    private $tableTaxonomy = 'tr_taxonomy_term';

    private $tableRelationships = 'tr_taxonomy_relationships';

    private $termId;

    private $term;

    private $taxonomyId;

    private $taxonomy;

    private $descricao;

    private $count;

    private $objId;

    private $log;

    //Busca se existir e inclui os dados na classe, se nao cria um novo e atribui a classe
    public function atualizar(Sujeito $dados)
    {
        $taxonomy = $this->findTaxonomyTerm($dados->taxonomy);
        $term     = $this->findTerm($dados->term);

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
        $this->taxonomy  = $arr['taxonomy'];
        $this->objId     = $arr['object_id'];
        $this->term      = $arr['name'];

        $this->log = parent::salvar($this->tableTerm, ['name' => $this->term]);

        if($this->log){
            $this->termId = parent::lastId();

            $taxParam = array(
                'term_id'   => $this->termId,
                'taxonomy'  => $this->taxonomy,
                'descricao' => $this->descricao,
                'count'     => $this->count
            );

            $this->log = parent::salvar($this->tableTaxonomy, $taxParam);
            if($this->log){
                $this->taxonomyId = parent::lastId();
                $relParam = array(
                    'object_id' => $this->objId,
                    'taxonomy_id' => $this->taxonomyId
                );
                $this->log =  parent::salvar($this->tableRelationships, $relParam);
                
                return $this->log;
            }
        }

        return false;
    }

    private function findTaxonomyTerm($taxonomy)
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

    private function findTerm($termName)
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

    public function findObjectTaxonomy($objectId, $objectType)
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

    public function getTerm()
    {
        return $this->term;
    }

    public function test($objectId)
    {
        var_dump($this->findTaxonomyTerm($objectId));
    }
}