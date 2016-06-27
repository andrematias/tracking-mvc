<?php
/**
 * Classe de conexão com o Banco de dados
 * @author: André Matias
 * @version: 0.1
 * @link github.com/Andrematias
 * @link andrersmatias@gmail.com
 */

namespace App\Lib;

//Use classes
use \PDO;

class DbTrack
{
    private $dbName;
    private $dbHost;
    private $dbUser;
    private $dbPass;
    private $dbDriver;
    private $dbCharset;
    protected $conn;

    /**
     * Método construtor da classe DbTrack instancia o objeto da PDO com as
     * propriedades configuradas.
     */
    public function __construct()
    {
        //Definindo os valores das propriedades
        $this->dbDriver = DB_DRIVER;
        $this->dbName = DB_NAME;
        $this->dbHost = DB_HOSTNAME;
        $this->dbPass = DB_PASS;
        $this->dbUser = DB_USER;
        $this->dbCharset = DB_CHARSET;

        //Instanciando a classe PDO
        try {
            //Variavel temporaria para detalhes do tipo de conexão
            $details = $this->dbDriver . ":host=" . $this->dbHost . ";dbname=" . $this->dbName . ";" . $this->dbCharset;

            //Instancia da classe PDO nativa do php
            $this->conn = new PDO($details, "$this->dbUser", "$this->dbPass");

            //Destruindo as propriedades que não serão utilizadas
            unset($details);
            unset($this->dbUser);
            unset($this->dbCharset);
            unset($this->dbDriver);
            unset($this->dbHost);
            unset($this->dbName);
            unset($this->dbPass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Método para retornar o Obj de conexão instanciado.
     * @access public
     * @return Obj PDO conn
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * Método para executar uma Query no Banco de dados instanciado em conn
     * @access public
     * @param String $sql a query a ser executada
     * @param String $values os valores para a sql caso existam
     * @return Obj PDO $sttm or Boolean false
     */
    protected function Query($sql, Array $values = NULL)
    {
        $sttm = $this->conn->prepare($sql);
        return $sttm->execute($values);
    }

    /**
     * Retorna o ultimo id incluido no Banco de dados
     * @return int
     */
    protected function LastId()
    {
        return (int) $this->conn->lastInsertId();
    }

    /**
     * Método para recuperar os dados de uma tabela do banco de dados
     * @access public
     * @param Array $colls, Array com os nomes das colunas
     * @param String $Cond, String com a condição
     * @param Array $CondValues, Array com os valores para a condição
     * @return Array Assoc ou Booleano false
     */
    protected function Select
    (
    $tableName, Array $colls = [], $cond = NULL, Array $condValues = NULL
    )
    {

        if (!empty($colls) && is_array($colls)) {
            $colunas = implode(', ', $colls);
        } else {
            $colunas = '*';
        }

        //Requisição com a Query formada
        $sql = 'SELECT ' . $colunas . ' FROM ' . $tableName . ' ' . $cond;

        $sttm = $this->getConn();
        $query = $sttm->prepare($sql);
        $query->execute($condValues);
        return $query->fetch();
    }
    
    /**
     * Método para recuperar todos os dados de uma tabela do banco de dados
     * @access public
     * @param Array $colls, Array com os nomes das colunas
     * @param String $Cond, String com a condição
     * @param Array $CondValues, Array com os valores para a condição
     * @return Array Assoc ou Booleano false
     */
    protected function SelectAll
    (
    $tableName, Array $colls = [], $cond = NULL, Array $condValues = NULL
    )
    {

        if (!empty($colls) && is_array($colls)) {
            $colunas = implode(', ', $colls);
        } else {
            $colunas = '*';
        }

        //Requisição com a Query formada
        $sql = 'SELECT ' . $colunas . ' FROM ' . $tableName . ' ' . $cond;

        $sttm = $this->getConn();
        $query = $sttm->prepare($sql);
        $query->execute($condValues);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Método para alterar dados no Banco de dados
     * @param string tableName, string com o nome da tabela ou JOIN de tabelas
     * @param array updatesColumns. array com a coluna e o novo valor
     * @param string cond, string com a condição e bindName
     * @param array condValues, array com os bindValues da condição
     * @return bool
     */
    protected function Update
    (
    $id, $tableName, Array $parameters
    )
    {
        $campos = null;
        foreach ($parameters as $key => $value) {
            $campos .= $key . ' = :' . $key . ', ';
        }

        $campos = rtrim($campos, ', ');

        $tableId = str_replace('tr_', 'id_', $tableName);

        $parameters['id'] = $id;

        //executa a query
        return $this->Query('UPDATE ' . $tableName . ' SET ' . $campos . ' WHERE ' . $tableId . ' = :id', $parameters);
    }

    /**
     * Método para deletar linhas no Banco de Dados
     * @param string tableName, string com o nome da tabela
     * @param string cond, string com a condição SQL para deletar a linha
     * @param Array $valuesCond array com os bindValues para a condição
     * @return bool
     */
    protected function Delete
    (
    $id, $tableName
    )
    {
        $tableId = str_replace('tr_', 'id_', $tableName);

        $parameters['id'] = $id;

        return $this->Query('DELETE FROM ' . $tableName . ' WHERE ' . $tableId . ' = :id', $parameters);
    }

    /**
     * Método para incluir dados em uma tabela do Banco de dados instanciado
     * @param type $tableName
     * @param array $inputs
     * @return type bool
     */
    protected function Salvar
    (
    $tableName, Array $inputs
    )
    {
        if (is_array($inputs) && !empty($inputs)) {
            $keys = array_keys($inputs);
            $colunas = implode(', ', $keys);
            $bind = ':' . implode(', :', $keys);
        }

        return $this->Query('INSERT INTO ' . $tableName . ' (' . $colunas . ') VALUES (' . $bind . ')', $inputs);
    }
}
