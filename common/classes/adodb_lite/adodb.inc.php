<?php

/**
 * ADOdb Lite is a PHP class to encapsulate multiple database APIs and is compatible with
 * a subset of the ADODB Command Syntax.
 * Currently supports Frontbase, MaxDB, miniSQL, MSSQL, MSSQL Pro, MySQLi, MySQLt, MySQL, PostgresSQL,
 * PostgresSQL64, PostgresSQL7, PostgresSQL8, SqLite, SqLite Pro, Sybase and Sybase ASE.
 *
 */

if (!defined('_ADODB_LAYER'))
	define('_ADODB_LAYER',1);

if (!defined('ADODB_DIR'))
	define('ADODB_DIR', dirname(__FILE__));

$ADODB_vers = 'V1.42 ADOdb Lite 11 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL.';

define('ADODB_FETCH_DEFAULT',0);
define('ADODB_FETCH_NUM',1);
define('ADODB_FETCH_ASSOC',2);
define('ADODB_FETCH_BOTH',3);

GLOBAL $ADODB_FETCH_MODE;
$ADODB_FETCH_MODE = ADODB_FETCH_DEFAULT;	// DEFAULT, NUM, ASSOC or BOTH. Default follows native driver default...

/**
 * Database connection
 * Usage: $db = new ADONewConnection('dbtype');
 *
 * @access public
 * @param string $dbtype
 */

function &ADONewConnection( $dbtype = 'mysql', $modules = '' )
{
	global $ADODB_FETCH_MODE;
	$false = false;

	@include( ADODB_DIR . '/adodb.config.php' );

	if (strpos($dbtype,'://')) {
		$dsn_array = @parse_url(rawurldecode($dbtype));

		if (!$dsn_array || !$dsn_array['scheme'])
			return $false;

		$dbtype = $dsn_array['scheme'];
		$modules = (!empty($dsn_array['fragment'])) ? $dsn_array['fragment'] : $modules;
	} else $dsn_array = array('scheme'=>'');

	$dbtype = strtolower($dbtype);
	include_once ADODB_DIR . '/adodbSQL_drivers/' . $dbtype . '/' . $dbtype . '_driver.inc';
	$last_module = $dbtype . '_' . 'driver';
	if(!empty($modules))
	{
		$module_list = explode(":", strtolower($modules));
		$generic_modules = array();
		foreach($module_list as $mod) {
			$mod = trim($mod);
			if(is_file(ADODB_DIR . '/generic_modules/' . $mod . '_module.inc'))
			{
				$generic_modules[] = $mod;
			}
			else
			{
				include_once ADODB_DIR . '/adodbSQL_drivers/' . $dbtype . '/' . $dbtype . '_' . $mod . '_module.inc';
				$last_module = $dbtype . '_' . $mod;
			}
		}

		if(count($generic_modules))
		{
			foreach($generic_modules as $mod) {
				include_once ADODB_DIR . '/generic_modules/' . $mod . '_module.inc';
				$last_module = $mod;
			}
		}
	}

	$extention = $last_module . '_ADOConnection';

	$object = new $extention();
	$object->last_module_name = $last_module;
	$object->raiseErrorFn = (defined('ADODB_ERROR_HANDLER')) ? ADODB_ERROR_HANDLER : false;
	$object->query_count = 0;
	$object->query_time_total = 0;

	if(!empty($dsn_array['scheme']))
	{
		if (isset($dsn_array['port'])) $object->port = $dsn_array['port'];
		$persistent = false;
		$forcenew = false;
	  	if (isset($dsn_array['query'])) {
			$option_array = explode('&', $dsn_array['query']);
			foreach($option_array as $element => $value) {
				$array = explode('=', $value);
				$data = isset($array[1]) ? $array[1] : 1;
				switch(strtolower($array[0])) {
					case 'persist':
					case 'persistent':
						$persistent = $data;
						break;
					case 'debug':
						$object->debug = (integer) $data;
						break;
					case 'fetchmode':
						$ADODB_FETCH_MODE = constant($data);
						break;
					case 'clientflags':
						$object->clientFlags = $data;
						break;
					case 'port':
						$object->port = $data;
						break;
					case 'socket':
						$object->socket = $data;
						break;
					case 'forcenew':
						$forcenew = $data;
						break;
				}
			}
		}

		$dsn_array['host'] = isset($dsn_array['host']) ? $dsn_array['host'] : '';
		$dsn_array['user'] = isset($dsn_array['user']) ? $dsn_array['user'] : '';
		$dsn_array['pass'] = isset($dsn_array['pass']) ? $dsn_array['pass'] : '';
		$dsn_array['path'] = isset($dsn_array['path']) ? substr($dsn_array['path'], 1) : '';

		$result = $object->_connect($dsn_array['host'], $dsn_array['user'], $dsn_array['pass'], $dsn_array['path'], $persistent, $forcenew);

		if (!$result) return $false;
	}

	return $object;
}

/**
 * Alternative Database connection
 * Usage: $db = new NewADOConnection('dbtype');
 *
 * @access public
 * @param string $dbtype
 */

function &NewADOConnection($dbtype='', $module = '' )
{
	$tmp =& ADONewConnection($dbtype, $module);
	return $tmp;
}

function &NewDataDictionary(&$connection, $dbtype=false)
{
	if(!$dbtype)
		$dbtype = $connection->dbtype;
	include_once ADODB_DIR . '/adodb-datadict.inc.php';
	include_once ADODB_DIR . '/adodbSQL_drivers/' . $dbtype . '/' . $dbtype . '_datadict.inc';

	$class = "ADODB2_$dbtype";
	$dict = new $class();
	$dict->connection = &$connection;
	$dict->upperName = strtoupper($dbtype);
	$dict->quote = $connection->nameQuote;
	$dict->debug_echo = $connection->debug_echo;

	return $dict;
}

/**
 * Backwards compatible with ADOdb usage of NewPerfMonitor
 * Change to module basis for PerfMon mean we need only return a reference to $connection object.
 * Usage: $perf =& NewPerfMonitor($conn); - $perf is a reference to $conn
 *
 * @access public
 * @param ADOConnection $connection
 * @param string $dbtype This is an optional parameter with no actual use in ADOdb-Lite; for BC only.
 */
function &NewPerfMonitor(&$connection, $dbtype=false)
{
	return $connection;
}

class ADOConnection
{
	public $connectionId = false;
	public $record_set = false;
	public $database;
	public $dbtype;
	public $dataProvider;
	public $host;
	public $open;
	public $password;
	public $username;
	public $persistent;
	public $debug = false;
	public $debug_console = false;
	public $debug_echo = true;
	public $debug_output;
	public $forcenewconnection = false;
	public $createdatabase = false;
	public $last_module_name;
	public $socket = false;
	public $port = false;
	public $clientFlags = 0;
	public $nameQuote = '"';
	public $sysDate = false; /// name of function that returns the current date
	public $sysTimeStamp = false; /// name of function that returns the current timestamp
	public $sql;
	public $raiseErrorFn = false;
	public $query_count = 0;
	public $query_time_total = 0;
	public $query_list = array();
	public $query_list_time = array();
	public $query_list_errors = array();
	public $_logsql = false;

	function ADOConnection()
	{
	}

	/**
	 * Returns floating point version number of ADOdb Lite
	 * Usage: $db->Version();
	 *
	 * @access public
	 */

	function Version()
	{
		global $ADODB_vers;
		return (float) substr($ADODB_vers,1);
	}

	/**
	 * Returns true if connected to database
	 * Usage: $db->IsConnected();
	 *
	 * @access public
	 */

	function IsConnected()
	{
		if($this->connectionId === false || $this->connectionId == false)
	    	return false;
		else return true;
	}

	/**
	 * Normal Database connection
	 * Usage: $result = $db->Connect('host', 'username', 'password', 'database');
	 *
	 * @access public
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 * @param string $forcenew // private
	 */

	function Connect( $host = "", $username = "", $password = "", $database = "", $forcenew = false)
	{
		return $this->_connect($host, $username, $password, $database, false, $forcenew);
	}

	/**
	 * Persistent Database connection
	 * Usage: $result = $db->PConnect('host', 'username', 'password', 'database');
	 *
	 * @access public
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 */

	function PConnect( $host = "", $username = "", $password = "", $database = "")
	{
		return $this->_connect($host, $username, $password, $database, true, false);
	}

	/**
	 * Force New Database connection
	 * Usage: $result = $db->NConnect('host', 'username', 'password', 'database');
	 *
	 * @access public
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 */

	function NConnect( $host = "", $username = "", $password = "", $database = "")
	{
		return $this->_connect($host, $username, $password, $database, false, true);
	}

	// Format date column in sql string given an input format that understands Y M D
	function SQLDate($fmt, $col=false)
	{
		if (!$col) $col = $this->sysDate;
		return $col; // child class implement
	}

	/**
	 * Returns SQL query and instantiates sql statement & resultset driver
	 * Usage: $linkId =& $db->execute( 'SELECT * FROM foo ORDER BY id' );
	 *
	 * @access public
	 * @param string $sql
	 * @return mixed Resource ID, Array
	 */

	function &Execute( $sql, $inputarr = false )
	{
		// adodb_log_sql will time the query execution and log the sql query
		// note: the later $this->do_query() should not run since adodb_log_sql() independently executes the query itself.
		if($this->_logsql === true)
		{
			$ret =& adodb_log_sql($this, $sql, $inputarr);
			if (isset($ret)) return $ret;
		}
		$rs =& $this->do_query($sql, -1, -1, $inputarr);
		return $rs;
	}

	/**
	 * Returns SQL query and instantiates sql statement & resultset driver
	 * Usage: $linkId =& $db->SelectLimit( 'SELECT * FROM foo ORDER BY id', $nrows, $offset );
	 *        $nrows and $offset are optional
	 *
	 * @access public
	 * @param string $sql
	 * @param string $nrows
	 * @param string $offset
	 * @return mixed Resource ID, Array
	 */

	function &SelectLimit( $sql, $nrows=-1, $offset=-1, $inputarr=false, $secs2cache=0 )
	{
		$rs =& $this->do_query( $sql, $offset, $nrows, $inputarr);
		return $rs;
	}

	 /**
	 * Display debug output and database error.
	 *
	 * @access private
	 */

	function outp($text, $newline = true)
	{
		global $ADODB_OUTP;
		$this->debug_output = "<br>\n(" . $this->dbtype . "): ".htmlspecialchars($text)."<br>\n Error (" . $this->ErrorNo() .'): '. $this->ErrorMsg() . "<br>\n";

		if(defined('ADODB_OUTP'))
		{
			$fn = ADODB_OUTP;
		} else if(isset($ADODB_OUTP))
		{
			$fn = $ADODB_OUTP;
		}

		if(defined('ADODB_OUTP') || isset($ADODB_OUTP))
		{
			$fn($this->debug_output, $newline);
			return;
		}

		if($this->debug_echo)
			echo $this->debug_output;
	}

	/*
		 Returns placeholder for parameter, eg.
		 $DB->Param('a')

		 will return ':a' for Oracle, and '?' for most other databases...

		 For databases that require positioned params, eg $1, $2, $3 for postgresql,
		 	pass in Param(false) before setting the first parameter.
	*/
	function Param($name,$type='C')
	{
		return '?';
	}

	/**
	 * Should prepare the sql statement and return the stmt resource.
	 * For databases that do not support this, we return the $sql. To ensure
	 * compatibility with databases that do not support prepare:
	 *
	 *   $stmt = $db->Prepare("insert into table (id, name) values (?,?)");
	 *   $db->Execute($stmt,array(1,'Jill')) or die('insert failed');
	 *   $db->Execute($stmt,array(2,'Joe')) or die('insert failed');
	 *
	 * @param sql	SQL to send to database
	 *
	 * @return return FALSE, or the prepared statement, or the original sql if
	 * 			if the database does not support prepare.
	 *
	 */
	function Prepare($sql)
	{
		return $sql;
	}

}

/**
 * Empty result record set for updates, inserts, ect
 *
 * @access private
 */

class ADORecordSet_empty
{
	public $fields = false;
	public $EOF = true;
	function MoveNext() {return;}
	function RecordCount() {return 0;}
	function FieldCount() {return 0;}
	function EOF(){return TRUE;}
	function Close(){return true;}
}

class ADOFieldObject {
	public $name = '';
	public $max_length=0;
	public $type="";
}

?>