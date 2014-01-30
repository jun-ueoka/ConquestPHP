<?php

/** require list **/
require_once('MDB2/MDB2.php');

define('GARUDA_CONNECTTYPE_DEFAULT',	0);
define('GARUDA_CONNECTTYPE_MYSQL',		1);
define('GARUDA_CONNECTTYPE_MYSQLI',		2);

define('GARUDA_SQL_TYPE_NONE',			0);
define('GARUDA_SQL_TYPE_SELECT',		1);
define('GARUDA_SQL_TYPE_SHOW',			2);
define('GARUDA_SQL_TYPE_INSERT',		3);
define('GARUDA_SQL_TYPE_UPDATE',		4);
define('GARUDA_SQL_TYPE_DELETE',		5);

define('GARUDA_SETDEFAULT_FETCHMODE',	MDB2_FETCHMODE_ASSOC);

/**
 *	Garuda
 *		Simple DB Connecter By MDB2
 */
class GarudaDatabase {
	private	$db			= '';
	private	$dsn		= '';
	private	$type		= '';
	private	$id			= '';
	private	$password	= '';
	private	$host		= '';
	private	$db_name	= '';
	private	$b_connect	= FALSE;
	
	public function __construct($in_type, $in_id, $in_password, $in_host, $in_db_name) {
		$res	= $this->connect($in_type, $in_id, $in_password, $in_host, $in_db_name);
	}
	
	public function connect($in_type, $in_id, $in_password, $in_host, $in_db_name) {
		$type_str	= '';
		switch($in_type) {
			case GARUDA_CONNECTTYPE_MYSQL:
				$type_str	= 'mysql';
				break;
			case GARUDA_CONNECTTYPE_MYSQLI:
				$type_str	= 'mysqli';
				break;
			default:
				$in_type	= GARUDA_CONNECTTYPE_MYSQL;
				$type_str	= 'mysql';
				break;
		}
		$this->dsn	= "{$type_str}://{$in_id}:{$in_password}@{$in_host}/{$in_db_name}";
		$this->db	=& MDB2::connect($this->dsn);
		
		if(PEAR::isError($this->db)) {
			$this->b_connect = FALSE;
			return	FALSE;
		}
		
		$this->db->setFetchMode(GARUDA_SETDEFAULT_FETCHMODE); 
		$this->type			= $in_type;
		$this->id			= $in_id;
		$this->password		= $in_password;
		$this->host			= $in_host;
		$this->db_name		= $in_db_name;
		$this->b_connect	= TRUE;
		
		return	TRUE;
	}
	
	public function checkConnect() {
		return	$this->b_connect;
	}
	
	protected function checkError() {
		if(!$this->b_connect) {
			throw new Exception('DB Connect Error : ' . $this->host);
		}
	}
	
	private function query($sql) {
		$this->checkError();
		return	$this->db->queryAll($sql);
	}
	
	private function exec($sql) {
		$this->checkError();
		return	$this->db->exec($sql);
	}
	
	public function select($sql) {
		if(!(strtoupper(substr($sql, 0, 6)) == 'SELECT')) {
			throw new Exception('DB SQL Error : Not Select SQL [ ' . $sql . ' ]');
		}
		return	$this->query($sql);
	}
	
	public function show($sql) {
		if(!(strtoupper(substr($sql, 0, 4)) == 'SHOW')) {
			throw new Exception('DB SQL Error : Not Show SQL [ ' . $sql . ' ]');
		}
		return	$this->query($sql);
	}
	
	public function insert($sql) {
		if(!(strtoupper(substr($sql, 0, 6)) == 'INSERT')) {
			throw new Exception('DB SQL Error : Not Insert SQL [ ' . $sql . ' ]');
		}
		return	$this->exec($sql);
	}
	
	public function update($sql) {
		if(!(strtoupper(substr($sql, 0, 6)) == 'UPDATE')) {
			throw new Exception('DB SQL Error : Not Update SQL [ ' . $sql . ' ]');
		}
		return	$this->exec($sql);
	}
	
	public function delete($sql) {
		if(!(strtoupper(substr($sql, 0, 6)) == 'DELETE')) {
			throw new Exception('DB SQL Error : Not Delete SQL [ ' . $sql . ' ]');
		}
		return	$this->exec($sql);
	}
}

class GarudaFactory {
	static	private	$list_database	= array();
	
	static	public	function setDatabese($database_key, $in_type, $in_id, $in_password, $in_host, $in_db_name) {
		$db	= new GarudaDatabase($in_type, $in_id, $in_password, $in_host, $in_db_name);
		if(!$db->checkConnect()) {
			throw new Exception('DB Connect Error By GarudaFactory Set: ' . $in_db_name);
		}
		
		self::$list_database[$database_key]	= $db;
		return	$db;
	}
	
	static	public	function getDatabase($database_key) {
		if(!isset(self::$list_database[$database_key])) {
			throw new Exception('DB Connect Error By GarudaFactory Get: ' . $database_key);
		}
		
		return	self::$list_database[$database_key];
	}
}

class GarudaAccesser {
	private	$database	= null;
	private	$table_name	= '';

	private	$sql_type	= 0;
	private	$sql_field	= array();
	private	$sql_where	= array();
	private	$sql_limit	= null;
	private	$sql_offset	= null;
	
	static	private	$sql_type_list	= array(
		1	=> 'SELECT',
		2	=> 'SHOW',
		3	=> 'INSERT',
		4	=> 'UPDATE',
		5	=> 'DELETE',
	);
	
	public function __construct($database_key, $table_name) {
		$this->database		= GarudaFactory::getDatabase($database_key);
		$this->table_name	= $table_name;
	}
	
	public function select($field = '*') {
		$this->sql_type	= GARUDA_SQL_TYPE_SELECT;
		return	$this;
	}
	
	public function show() {
		$this->sql_type	= GARUDA_SQL_TYPE_SHOW;
		return	$this;
	}
	
	public function insert() {
		$this->sql_type	= GARUDA_SQL_TYPE_INSERT;
		return	$this;
	}
	
	public function update() {
		$this->sql_type	= GARUDA_SQL_TYPE_UPDATE;
		return	$this;
	}

	public function delete() {
		$this->sql_type	= GARUDA_SQL_TYPE_DELETE;
		return	$this;
	}
	
	public function createSql() {
		if(!isset(self::$sql_type_list[$this->sql_type])) {
			throw new Exception('DB SQL Error By GarudaAccesser createSql sql_type: ' . $this->sql_type);
		}
		$sql_base	= '';
		return	$sql_base;
	}
	
	private function runSql($sql) {
		$res	= null;
		switch($this->sql_type) {
			case GARUDA_SQL_TYPE_SELECT:
				$res	= $this->database->select($sql);
				break;
			case GARUDA_SQL_TYPE_SHOW:
				$res	= $this->database->show($sql);
				break;
			case GARUDA_SQL_TYPE_INSERT:
				$res	= $this->database->insert($sql);
				break;
			case GARUDA_SQL_TYPE_UPDATE:
				$res	= $this->database->update($sql);
				break;
			case GARUDA_SQL_TYPE_DELETE:
				$res	= $this->database->delete($sql);
				break;
			default:
				throw new Exception('DB SQL Error By GarudaAccesser runSql: ' . $sql);
		}
		return $res;
	}
	
	public function where() {
	}
	
	public function findAll() {
		if($this->sql_type == GARUDA_SQL_TYPE_SELECT ||
		   $this->sql_type == GARUDA_SQL_TYPE_SHOW) {
		} else {
			throw new Exception('DB SQL Error By GarudaAccesser findAll: No Select or Show');
		}
	}
	
	public function findOne() {
		if($this->sql_type == GARUDA_SQL_TYPE_SELECT) {
		} else {
			throw new Exception('DB SQL Error By GarudaAccesser findOne: No Select');
		}
	}
	
	public function exec() {
		if($this->sql_type == GARUDA_SQL_TYPE_INSERT ||
		   $this->sql_type == GARUDA_SQL_TYPE_UPDATE ||
		   $this->sql_type == GARUDA_SQL_TYPE_DELETE) {
		} else {
			throw new Exception('DB SQL Error By GarudaAccesser exec: No Insert or Update or Delete');
		}
	}

/*
	public function __construct($database_key, $table_key);
	
	public function getTableName();
	
	public function getQuery();
*/
}

?>