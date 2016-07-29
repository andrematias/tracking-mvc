<?php
namespace App\Lib;

/**
 * Classe com os atributos de uma URL
 *
 * @author André Matias
 */
class Url extends Observador
{

    private $urlTable = 'tr_url';
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
    public function atualizar(Sujeito $dados)
    {
        //Verifica, salva ou atualiza
        $this->clienteId = $this->clienteId($dados->cliente);      
        $this->url = $dados->url;

        $check = $this->find($this->url);
        if($check){
           $this->urlId = $check['id_url'];
           $this->url = $check['url'];
           $parameters = array();
           return parent::update($this->urlId, $this->urlTable, $parameters);
        }else{
            $urlValues = array(
                'url'        => $this->url,
                'id_cliente' => $this->clienteId
            );

            $new = $this->newUrl($urlValues);
            $this->urlId = ($new) ? parent::lastId() : null;
        }
    }
    
    public function newUrl($urlValues)
    {
        return parent::Salvar($this->urlTable, $urlValues);
    }

    /**
     * Configura e retorna o id do cliente da url atual
     * @param string $clienteName
     * @return int
     */
    private function clienteId($clienteName)
    {
        $id = parent::select('tr_cliente', ['id_cliente'], 'WHERE cliente = :cliente', [':cliente' => $clienteName]);
        $this->clienteId = ($id) ? (int)$id['id_cliente'] : null;
        return $this->clienteId;
    }


    /**
     * Retorna os dados da url procurada
     * @param string $url
     * @return array com os dados da url buscada
     */
    public function find($url)
    {
        $link = parent::select($this->urlTable, ['id_url', 'id_cliente', 'id_type', 'id_type', 'id_source', 'url', 'short_url'], 'WHERE url = :url', [':url' => $url]);
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
     * Retorna a url atual
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Configura a url
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Lista de todas as urls cadastradas
     * @return array
     */
    public function listUrls()
    {
        return parent::selectAll($this->urlTable);
    }

}