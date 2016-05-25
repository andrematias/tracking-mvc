<?php
/**
* 
*/
class MainModel extends DbTrack{
	protected $_db;

	function __construct(){
		parent::__construct();
		$this->_db = $this->getConn();
	}

	/**
	* Método para adicionar mensagem ao buffer
	* @param msg, string mensagem para ser adicionada
	* @param type, string success ou error 
	*/
	public function newMessage($msg, $type){
		global $msgPool;
		if(!is_array($msgPool)){
			$msgPool = array();
		}

		$messages = array(
			'msg'  => $msg,
			'type' => $type
		);

		array_push($msgPool, $messages);
	}
}