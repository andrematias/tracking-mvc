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
}