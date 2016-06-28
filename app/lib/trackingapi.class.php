<?php
namespace App\Lib;

/**
 * <b> Classe TrackingAPI </b>
 * Callback dos dados enviados dos clientes rastreados
 *
 * @author André Matias
 * @version 0.1
 */
class TrackingAPI extends Sujeito
{
    /**
     * Lista de observadores
     * @var array
     */
    public $observadores = array();

    /**
     * Hash do usuário
     * @var string
     */
    public $user;

    /**
     * Link visitado
     * @var string
     */
    public $url;

    /**
     * Nome abreviado para um link
     * @var string
     */
    public $shortUrl;

    /**
     * Email fornecido por formulários ou tag %%emailaddress%%
     * @var string
     */
    public $email;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * Empresa do usuário
     * @var string
     */
    public $empresa;

    /**
     * Cargo do usuário na empresa fornecida
     * @var string
     */
    public $cargo;

    /**
     * Pais de origem, valor padrão Brasil
     * @var string
     */
    public $pais = 'Brasil';

    /**
     * Tipo de lead, valor padrão Indireto
     * @var string
     */
    public $leadType = 'Indireto';

    /**
     * Origem dos dados configurado no painel da app
     * @var string
     */
    public $origem;

    /**
     * tipo de interesse do usuário, configurado no painel da app
     * @var string
     */
    public $interesse;

    /**
     * Tipo da Businness Line configurado no painel da app
     * @var string
     */
    public $linhaDeNegocio;

    /**
     * Pontuação para a URL, Tempo e Origem, configurado no painel da app
     * @var int
     */
    public $score;

    /**
     * Nome do cliente que esta sendo rastreado
     * @var string
     */
    public $cliente;

    /**
     * Texto do comentário realizado em posts ou em formulários de solicitações
     * @var text
     */
    public $comentario;

    /**
     * Hora de inicio da sessão
     * @var string
     */
    public $sessionStart;

    /**
     * Hora da saida da sessão
     * @var string
     */
    public $sessionEnd;

    /**
     * Data da sessão
     * @var string
     */
    public $sessionDate;


    /**
     * Inclui na array list o observador informado
     * @param \App\Lib\Observador $observador Instancia do Observador
     */
    public function incluirObservadores( Observador $observador ){
        try {
            $this->observadores[] = $observador;
            return true;
        } catch (Exception $exc) {
            echo "Falha ao adicionar um novo Observador no array List <br>";
            echo $exc->getTraceAsString();
            return false;
        }
    }

    /**
     * Remove o observador informado da array list
     * @param \App\Lib\Observador $observador Instancia do Observador
     */
    public function removerObservadores( Observador $observador ){
        $key = array_search($observador, $this->observadores, true);

        if( $key ){
            unset( $this->observadores[ $key ] );
            return true;
        }else{
            return false;
        }
    }

    /**
     * Método para notificar a lista de observadores sobre a inclusão dos dados
     * na classe TrackingAPI
     */
    public function notificar(){
        foreach ( $this->observadores as $observador ){
            $observador->atualizar( $this );
        }
    }

}