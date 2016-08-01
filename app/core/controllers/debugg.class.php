<?php
/**
 * 
 */

namespace App\Core\Controllers;

use App\Lib\Taxonomy;
use App\Lib\TrackingAPI;

class Debugg
{

    function index()
    {
        //''
        $tax = new Taxonomy();
        $api = new TrackingAPI();

        $api->taxonomy = 'ee';
        $api->term = 'tt';
        $api->taxonomyDescription = 'ss';
        $api->taxonomyCount = 12;
        $api->taxonomyObjectId = 47;


//        var_dump(
//            //$tax->newTaxonomy('name=testeTerm&taxonomy=locatite   416&descricao=adesivos&count=100&object_id=47')
//            $tax->findTerm('testeTerm')
//        );

        var_dump($tax->atualizar($api));

    }
}