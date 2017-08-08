<?php
/**
 * ADOdb Lite Example Module
 *
 * This example module can be used to create your own extention to ADOdb Lite.
 *
 * The module prefix name and class prefix name should all be the same and lowercase.
 * If the new module name is 'blob' then rename this file to 'blob_module.inc'. Rename
 * the following class designators.
 *
 * query_EXTENDER renamed to blob_EXTENDER
 * example_generic_ADOConnection renamed to blob_ADOConnection
 * example_generic_resultset_EXTENDER renamed to blob_resultset_EXTENDER
 * example_generic_ResultSet renamed to blob_ResultSet
 *
 * Functions that interact with the database should be placed inside the
 * blob_ADOConnection class.  These are functions accessed using
 * $db->function().
 *
 * Functions that interact with the resetset created by a query should
 * be placed inside the blob_ResultSet class.  These are functions accessed using
 * $result->function().
 *
 * Example:
 * $result = $db->Execute($sql);
 * echo $result->function();
 *
 * Place the file into the approriate database driver directory.  You should create one
 * for each database you would like to support.
 *
 * To use your blob module start ADOdb Lite using.
 *
 * $db = ADONewConnection($databasetype, 'blob');
 *
 * Remember to replace every instance of mysql in the statements below with the database name
 * the module is to be used.
 *
 */

eval('class query_EXTENDER extends '. $last_module . '_ADOConnection { }');

class query_ADOConnection extends query_EXTENDER
{
		function Prepare($sql)
	{
		return $sql;
	}

		function Param($name,$type='C')
	{
		return '?';
	}
	// Format date column in sql string given an input format that understands Y M D
	function SQLDate($fmt, $col=false)
	{
		if (!$col) $col = $this->sysDate;
		return $col; // child class implement
	}

	/**
	* PEAR DB Compat - do not use internally
	*/
	function Disconnect()
	{
		return $this->Close();
	}



}

eval('class query_resultset_EXTENDER extends '. $last_module . '_ResultSet { }');

class query_ResultSet extends query_resultset_EXTENDER
	{
		public function &FetchRow()
			{
				if ($this->EOF) {
					$false = false;
					return $false;
				}
				$arr = $this->fields;
				$this->_currentRow++;
				if (!$this->_fetch()) $this->EOF = true;
				return $arr;
			}
		public function PO_RecordCount($table="", $condition="")
			{

				$lnumrows = $this->_numOfRows;
				// the database doesn't support native recordcount, so we do a workaround
				if ($lnumrows == -1 && $this->connection) {
					IF ($table) {
						if ($condition) $condition = " WHERE " . $condition;
						$resultrows = &$this->connection->Execute("SELECT COUNT(*) FROM $table $condition");
						if ($resultrows) $lnumrows = reset($resultrows->fields);
					}
				}
				return $lnumrows;
			}
		public function Free()
		{
		return $this->Close();
		}




}
?>