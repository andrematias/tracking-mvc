<?php
namespace App\Lib;

/**
 * Classe com os atributos de uma URL
 *
 * @author André Matias
 */
class Url extends Observador
{
    /**
     * Identificação da URL
     * @var int
     */
    private $urlId;

    /**
     * Identificação do cliente
     * @var int
     */
    private $clienteId;

    /**
     * Identificação da Origem
     * @var int
     */
    private $origemId;

    /**
     * Identificação unica do interesse
     * @var string
     */
    private $interesseId;

    /**
     * Url do cliente visitada pelo usuário
     * @var string
     */
    private $url;

    /**
     * Apelido para a Url
     * @var string
     */
    private $shortUrl;


    /**
     * método construtor da classe Url
     */
    public function __construct()
    {
        //Construtor do Banco de dados
        parent::__construct();
    }

    /**
     * Implementação da classe Observador, atualiza a classe com os dados
     * passados pela classe Sujeito.
     * @param \App\Lib\Sujeito $dados instancia da classe Sujeito
     */
    public function Atualizar(Sujeito $dados)
    {
        //Verifica, salva ou atualiza
        $this->clienteId = $this->ClienteId($dados->cliente);
        $this->interesseId = $this->InteresseId($dados->interesse, $dados->linhaDeNegocio);
        $this->origemId = $this->OrigemId($dados->origem, $dados->score);
        $this->shortUrl = $dados->shortUrl;
        $this->url = $dados->url;

        $check = $this->Find($this->url);
        if($check){
           $this->urlId = $check['id_url'];
           $this->url = $check['url'];
           $parameters = array();
           if(!empty($this->shortUrl) && $this->shortUrl != $check['short_url']){
                $parameters['short_url'] = $this->shortUrl;
           }
           
           if(!empty($this->origemId) && $this->origemId != $check['id_source']){
               $parameters['id_source'] = $this->origemId;
           }

           if(!empty($this->interesseId) && $this->interesseId != $check['id_type']){
               $parameters['id_type'] = $this->interesseId;
           }
           var_dump($parameters);
           return parent::Update($this->urlId, 'tr_url', $parameters);
        }else{
            $urlValues = array(
                'url'        => $this->url,
                'short_url'  => $this->shortUrl,
                'id_cliente' => $this->clienteId,
                'id_source'  => $this->origemId,
                'id_type'    => $this->interesseId
            );

            $new = $this->newUrl($urlValues);
            $this->urlId = ($new) ? parent::LastId() : null;
        }
    }
    
    public function newUrl($urlValues)
    {
        return parent::Salvar('tr_url', $urlValues);
    }

    /**
     * Configura e retorna o id do cliente da url atual
     * @param string $clienteName
     * @return int
     */
    private function ClienteId($clienteName)
    {
        $id = parent::Select('tr_cliente', ['id_cliente'], 'WHERE cliente = :cliente', [':cliente' => $clienteName]);
        $this->clienteId = ($id) ? (int)$id['id_cliente'] : null;
        return $this->clienteId;
    }

    /**
     * Configura e retorna o id do interesse cadastrado para a url atual
     * @param string $interesse
     * @param string $bl
     * @return int
     */
    private function InteresseId($interesse, $bl)
    {
        $id = parent::Select('tr_type', ['id_type'], 'WHERE type_interest = :interesse AND type_bl = :linha', [':interesse' => $interesse, ':linha' => $bl]);
        $this->interesseId = ($id) ? (int)$id['id_type'] : null;
        return $this->interesseId;
    }

    /**
     * Configura e retorna o id da Origem configurado na url atual
     * @param string $origem
     * @param int $score
     * @return int
     */
    private function OrigemId($origem, $score)
    {
        $id = parent::Select('tr_source', ['id_source'], 'WHERE source = :origem AND default_score = :score', [':origem' => $origem, ':score'=>$score]);
        $this->origemId = ($id) ? (int)$id['id_source'] : null;
        return $this->origemId;
    }

    /**
     * Retorna os dados da url procurada
     * @param string $url
     * @return array com os dados da url buscada
     */
    public function Find($url)
    {
        $link = parent::Select('tr_url', ['id_url', 'id_cliente', 'id_type', 'id_type', 'id_source', 'url', 'short_url'], 'WHERE url = :url', [':url' => $url]);
        return ( $link )? $link : false;
    }

    /**
     * Retorna a id da url atual
     * @return int
     */
    public function getUrlId()
    {
        return $this->urlId;
    }

    /**
     * Retorna a id do cliente da url atual
     * @return int
     */
    public function getClienteId()
    {
        return $this->clienteId;
    }

    /**
     * Retorna a id da origem da url atual
     * @return int
     */
    public function getOrigemId()
    {
        return $this->origemId;
    }

    /**
     * Retorna a id do interesse da url atual
     * @return int
     */
    public function getInteresseId()
    {
        return $this->interesseId;
    }

    /**
     * Retorna a url atual
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retorna o apelido da URL atual
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

   /**
    * Configura a id da url
    * @param int $urlId
    */
    public function setUrlId($urlId)
    {
        $this->urlId = $urlId;
    }

   /**
    * Configura a id do cliente na url atual
    * @param int $clienteId
    */
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;
    }

   /**
    * Configura a id da origem na url
    * @param int $origemId
    */
    public function setOrigemId($origemId)
    {
        $this->origemId = $origemId;
    }

    /**
     * Configura a id para o interesse da url atual
     * @param int $interesseId
     */
    public function setInteresseId($interesseId)
    {
        $this->interesseId = $interesseId;
    }

    /**
     * Configura a url
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Configura o apelido para a url
     * @param string $shortUrl
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * Lista de todas as urls cadastradas
     * @return array
     */
    public function listUrls()
    {
        return parent::SelectAll('tr_url');
    }

}