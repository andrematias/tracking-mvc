<?php
/**
* Classe padrão para as atividades das Models
* @author: André Matias
* @version: 0.1
* @link github.com/Andrematias
* @link andrersmatias@gmail.com
*/

namespace App\Lib\Main;
use App\Lib\DbTrack as DbTrack;

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