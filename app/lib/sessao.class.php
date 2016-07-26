<?php

namespace App\Lib;

/**
 * Classe relacionado ao registro de acessos ao cliente rastreado
 *
 * @author André Matias
 */
class Sessao extends Observador
{
    private $sessionTable = 'tr_session';
    /**
     * Identificação única para a sessão atual
     * @var int
     */
    private $sessaoId;

    /**
     * Identificação única para o usuário
     * @var int
     */
    private $userId;

    /**
     * Identificação única para a URL acessada
     * @var int
     */
    private $urlId;

    /**
     * Data que ocorre a sessão
     * e.g. 2016-06-27
     * @var string
     */
    private $sessionDate;

    /**
     * Hora que inicia a sessão
     * e.g. 11:12:00
     * @var string
     */
    private $sessionStart;

    /**
     * Hora que finalize a sessão
     * e.g. 11:12:00
     * @var string
     */
    private $sessionEnd;

    /**
     * Método construtor da classe Sessao
     */
    public function __construct()
    {
        //Construtor da classe herdada DbTrack
        parent::__construct();
    }

    /**
     * Instancia da classe Observador
     * @param \App\Lib\Sujeito $dados instancia da classe Sujeito
     */
    public function atualizar(Sujeito $dados)
    {
        $this->sessionDate   = $dados->sessionDate;
        $this->sessionStart  = $dados->sessionStart;
        $this->sessionEnd    = $dados->sessionEnd;
        $this->userId        = $this->userId($dados->user);
        $this->urlId         = $this->urlId($dados->url);
        
        //Verifica, salva ou atualiza
        if(!empty($this->sessionEnd) && $this->sessionEnd != Null){
            $dadosSessao = array(
               'id_user' => $this->userId,
               'session_start' => $this->sessionStart,
               'session_date'  => $this->sessionDate
            );

           $check = $this->find($dadosSessao);

           if($check){
               $this->sessaoId = $check['id_session'];
               $this->userId = $check['id_user'];
               $this->urlId  = $check['id_url'];
               $this->sessionDate = $check['session_date'];
               $this->sessionStart = $check['session_start'];
               $this->sessionEnd = $dados->sessionEnd;
               
               $parameters = array(
                   'session_end' => $this->sessionEnd
               );
               
               return parent::update($this->sessaoId, $this->sessionTable, $parameters);
           }else{
               $dadosSessao = array(
                'session_date'  => $this->sessionDate,
                'session_start' => $this->sessionStart,
                'session_end'   => $this->sessionEnd,
                'id_user'       => $this->userId,
                'id_url'        => $this->urlId
            );

            $new = $this->newSession($dadosSessao);

            $this->sessaoId = ($new) ? parent::lastId() : null;
           }
        }else{
            $dadosSessao = array(
                'session_date'  => $this->sessionDate,
                'session_start' => $this->sessionStart,
                'session_end'   => $this->sessionEnd,
                'id_user'       => $this->userId,
                'id_url'        => $this->urlId
            );

            $new = $this->newSession($dadosSessao);

            $this->sessaoId = ($new) ? parent::lastId() : null;
        }
    }

    /**
     * Salva uma nova sessão no banco de dados
     * @param array $dadosSessao
     * @return boolean
     */
    public function newSession(Array $dadosSessao)
    {
        return parent::salvar($this->sessionTable, $dadosSessao);
    }

    /**
     * Procura no banco de dados uma sessão com os valores passados
     * @param Array|String $sessionData
     * $sessionData string e.g. "session_start=10:40:00&session_end=10:40:00"
     * @return Array se existir dados correspondentes ou false
     */
    public function find($sessionData)
    {
        if( !is_array($sessionData) ){
            $arr = array();
            \parse_str($sessionData, $arr);
            $keys = array_keys($arr);

            /* @var $cond string para armazenar a string formada pelas chaves
             * do array $arr */
            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key.' = :'.$key.' AND ';
            }

            $cond = (trim(rtrim($cond, ' AND ')));            
        }else{
            $arr = $sessionData;
            $keys = \array_keys($arr);
            $cond = null;

            foreach ($keys as $key) {
                $cond .= $key.' = :'.$key.' AND ';
            }

            $cond = (trim(rtrim($cond, ' AND ')));
        }
        $link = parent::select($this->sessionTable, array(), 'WHERE '.$cond, $arr);
        return (!empty($link)) ? $link : false;
    }

    /**
     * Retorna o id da sessão atual
     * @return int
     */
    public function getSessaoId()
    {
        return $this->sessaoId;
    }

    /**
     * Retorna o id do usuário
     * @return int
     */
    public function getuserId()
    {
        return $this->userId;
    }

    /**
     * Retorna a id da Url
     * @return int
     */
    public function geturlId()
    {
        return $this->urlId;
    }

    /**
     * Retorna a sessionDate da sessão atual
     * @return int
     */
    public function getSessionDate()
    {
        return $this->sessionDate;
    }

    /**
     * Retorna a sessionStart da sessão atual
     * @return int
     */
    public function getSessionStart()
    {
        return $this->sessionStart;
    }

    /**
     * Retorna a sessionEnd da sessão atual
     * @return int
     */
    public function getSessionEnd()
    {
        return $this->sessionEnd;
    }

    /**
     * Configura o id da sessão
     */
    public function setSessaoId($sessaoId)
    {
        $this->sessaoId = $sessaoId;
    }

    /**
     * Configura o id do usuario para a sessão atual
     * @param string $user, hash única do usuário
     * @return boolean
     */
    private function userId( $user )
    {
        $id = parent::select('tr_user', ['id_user'], 'WHERE user = :user', [':user' => $user]);
        $this->userId = ( !empty( $id ) ) ? (int)$id['id_user'] : null;
        return $this->userId;
    }

    /**
     * Configura a id da url na sessão atual
     * @param string $url
     * @return int
     */
    private function urlId($url)
    {
        $id = parent::select('tr_url', ['id_url'], 'WHERE url = :url', [':url' => $url]);
        $this->urlId = (!empty($id)) ? $id['id_url'] : null;
        return $this->urlId;
    }

    /**
     * Configura um id para o usuario da sessão 
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    /**
     * Configura um id para a url da sessão
     * @param int $urlId
     */
    public function setUrlId($urlId)
    {
        $this->urlId = $urlId;
    }


    /**
     * Configura uma data para a sessão atual
     * @param date $sessionDate
     */
    public function setSessionDate($sessionDate)
    {
        $this->sessionDate = $sessionDate;
    }

    /**
     * Configura uma hora de ínicio para a sessão
     * @param time $sessionStart
     */
    public function setSessionStart($sessionStart)
    {
        $this->sessionStart = $sessionStart;
    }

    /**
     * Configura uma hora de finalizção para a sessão
     * @param time $sessionEnd
     */
    public function setSessionEnd($sessionEnd)
    {
        $this->sessionEnd = $sessionEnd;
    }

    /**
     * Retorna o tempo total de navegação do usuário no mês
     * @param int $userId
     * @return array
     */
    public function navigationTime($userId, $dateStart, $dateEnd)
    {
        $conn = parent::getConn();
        $query = $conn->prepare('SELECT session_date, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(session_end, session_start)))) AS tempo_de_navegacao FROM '.$this->sessionTable.' WHERE id_user = :userID AND session_date BETWEEN :sessionStart AND :sessionEnd GROUP BY MONTH(session_date) DESC');
        $query->execute([
            ':userID' => $userId,
            ':sessionStart' => $dateStart,
            ':sessionEnd' => $dateEnd
        ]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Retorna a quantidade de páginas visitadas por um usuário durante o mês
     * @param int $userId
     * @return array
     */
    public function countContent($userId, $dateStart, $dateEnd)
    {
        $conn = parent::getConn();
        $query = $conn->prepare('SELECT  session_date, COUNT(id_user) as content FROM '.$this->sessionTable.' WHERE id_user = :userID AND session_date BETWEEN :sessionStart AND :sessionEnd GROUP BY MONTH(session_date) DESC');
        $query->execute([
            ':userID' => $userId,
            ':sessionStart' => $dateStart,
            ':sessionEnd' => $dateEnd
        ]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}