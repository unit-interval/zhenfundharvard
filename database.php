<?php

if (! isset($start_including))
    err('403');

/**
 * extend the builtin mysqli class
 * add error handling
 * redirect user to error page if database error occurs
 * since db error are considered fatal
 */
class mysqli_ext extends mysqli {
	public $last_query;
	/**
	 * connect and set utf8 as default charset
	 */
	public function __construct() {
		parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($this->connect_error)
			err("db-connect-error");
	}
	/** preserve the original query method */
	public function rquery($query) {
		$this->last_query = $query;
		return parent::query($query);
	}
	/** exit on error for common queries */
	public function query($query) {
		$this->last_query = $query;
		if(!($result = parent::query($query)))
            err('db-error');
		return $result;
	}
	/** exit if pareparation of statement fails */
	public function prepare($query) {
		$this->last_query = $query;
		if(!($stmt = parent::prepare($query)))
            err('db-error');
		return $stmt;
	}
}


/** prepare the global variable $db for database queries */
$db = new mysqli_ext();
