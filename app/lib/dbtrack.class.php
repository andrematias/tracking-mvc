<?php
/**
* Classe de conexão com o Banco de dados
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/
class DbTrack{
	private $_db_name;
	private $_db_host;
	private $_db_user;
	private $_db_pass;
	private $_db_driver;
	private $_db_charset;

	protected $_conn;

	/**
	* Método construtor da classe DbTrack instancia o objeto da PDO com as
	* propriedades configuradas.
	*/
	
	public function __construct(){
		//Definindo os valores das propriedades
		$this->_db_driver  = DB_DRIVER;
		$this->_db_name    = DB_NAME;
		$this->_db_host    = DB_HOSTNAME;
		$this->_db_pass    = DB_PASS;
		$this->_db_user    = DB_USER;
		$this->_db_charset = DB_CHARSET;

		//Instanciando a classe PDO
		try{
			//Variavel temporaria para detalhes do tipo de conexão
			$details = $this->_db_driver.":host=".$this->_db_host.";dbname=".$this->_db_name.";".$this->_db_charset;

			//Instancia da classe PDO nativa do php
			$this->_conn = new PDO($details, "$this->_db_user", "$this->_db_pass");

			//Destruindo as propriedades que não serão utilizadas
			unset($details);
			unset($this->_db_user);
			unset($this->_db_charset);
			unset($this->_db_driver);
			unset($this->_db_host);
			unset($this->_db_name);
			unset($this->_db_pass);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	/**
	* Método para retornar o Obj de conexão instanciado.
	* @access protected
	* @return Obj PDO _conn
	*/
	protected function getConn(){
		return $this->_conn;
	}

	/**
	* Método para executar uma Query no Banco de dados instanciado em _conn
	* @access protected
	* @param String $sql, a query a ser executada
	* @param String $sql, os valores para a sql caso existam
	* @return Obj PDO $sttm or Boolean false
	*/
	protected function Query($sql, Array $values = []){
		$sttm = $this->_conn->prepare($sql);
		$sttm->execute($values);
		if($sttm){
			return $sttm;
		}
		return false;
	}

	/**
	* Método para recuperar os dados de uma tabela do banco de dados
	* @access protected
	* @param Array $colls, Array com os nomes das colunas
	* @param Array $whereColluns, Array com os nomes das colunas para a comparação
	* @param Array $whereValues, Array com os valores para a comparação
	* @return Array Assoc ou Booleano false
	*/
	protected function Select($tableName, Array $colls = [], Array $whereColluns = [], Array $whereValues = []){
		if(!empty($colls) && is_array($colls)){
			$colunas = implode(', ', $colls);
		}else{
			$colunas = '*';
		}

		if(!empty($whereColluns) && is_array($whereColluns)){
			$where = ' WHERE ';
			/*
			* Se existir mais do que um valor de coluna implode com = ? AND 
			* formando a string e.g.: var1 = ? AND var2 = ?
			* sendo que o segundo = ? é adicionado na concatenação após o implode
			*/
			$whereColl = implode(' = ? AND ', $whereColluns) . ' = ? ';

			$whereCond = $where.$whereColl;
		}else{
			$whereCond = '';
		}

		//Requisição com a Query formada
		$sttm = $this->Query('SELECT '.$colunas.' FROM '.$tableName.$whereCond, $whereValues);
		$results = $sttm->fetchAll(PDO::FETCH_ASSOC);
		if($results){
			return $results;
		}else{
			return false;
		}
	}
}