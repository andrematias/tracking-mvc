<?php
/**
 * Classe responsável por gerar os dados para a exibição do relatório consolidado
 * e detalhado segundo o período estabelecido pelo usuário e o cliente atual
 * @version 0.1
 * @link andrersmatias@gmail.com
 * @link http://github.com/andrematias
 * @author André Matias
 */

namespace App\Core\Models;

//Carregando as bibliotecas necessárias
use App\Lib\Base;
use App\Lib\Sessao;
use App\Lib\User;
use App\Lib\Cliente;
use App\Lib\Origem;
use \App\Lib\Interesse;


class Results extends \App\Lib\Main\MainModel
{
    private $startDate;

    private $endDate;

    private $clienteId;

    private $userId;

    private $interesses;

    private $businessLine;

    private $score;

    private $origem;

    private $timeNavigation;

    private $totalContent;
    
    private $infoUser;

    /**
     * Método para retornar todos os dados para o relatório do tipo consolidado
     * @return Array com todos os dados
     */
    public function consolidado(){
        //Classes necessárias para gerar o relatório
        $base = new Base;
        $sessao = new Sessao;
        $user = new User;
        $cliente = new Cliente;
        $origem = new Origem;
        $interesse = new Interesse;

        //Recupera o id do cliente atual
        $this->clienteId = $cliente->getClienteId($_SESSION['cliente']);
        //Verifica todos os usuários deste cliente
        $this->userId = $user->allUsersFromCliente($this->clienteId);

        //Captura as datas se passadas via POST
        $this->startDate = (filter_input(INPUT_POST, 'date') ? filter_input(INPUT_POST, 'date') : '1990-01-01');
        $this->endDate = (filter_input(INPUT_POST, 'date_end') ? filter_input(INPUT_POST, 'date_end') : date('Y-m-d', time()));


        $out = [];

        /**
         *  @var $id string
         * Identificação do usuário
         **/
        foreach ($this->userId as $id){

            /*Atribui os valores das classes externas aos atributos da classe atual*/

            $this->interesses = $interesse->getUserInterest($id['id_user']);
            $this->businessLine = $interesse->getUserBusinessLine($id['id_user']);
            $this->origem = $origem->getOrigensByUserId($id['id_user']);
            $this->score = $origem->getScoreByUserId($id['id_user']);
            $this->timeNavigation = $sessao->navigationTime($id['id_user'], $this->startDate, $this->endDate);
            $this->infoUser = $base->allFromUser($id['id_user']);
            $this->totalContent = $sessao->countContent($id['id_user'], $this->startDate, $this->endDate);

            /*Só monta o array mesclado com todas as informações se existir as
             * informações do usuário
             */
            if($this->infoUser && isset($this->timeNavigation['session_date'])){
            
                $merge = \array_merge(
                    $this->timeNavigation,
                    $this->infoUser,
                    $this->totalContent,
                    array(
                    'interesses' => $this->interesses ,
                    'businessLine' => $this->businessLine ,
                    'origem' => $this->origem,
                    'score' => $this->score,
                    'subject' => $this->interesses,
                    'description' => '',
                    'visitor' => 'Prospect',
                    )
                );
                //atribui os valores de merge em um array matriz
                $out[] = $merge;
            }
        }

        /*
         * Coloca as mensagens no buffer para ser exibida na view conforme a
         * situação do array $out
         */
        if(empty($out)){
            parent::newMessage('Não existem dados para este periodo', 'error');
        }else{
            parent::newMessage('Requisição realizada com sucesso', 'success');
        }

        return $out;
    }
}