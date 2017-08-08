<?php
if(class_exists('MediaHandler'))
	{
		$parent_class = 2;
	}
elseif(class_exists('FormHandler'))
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 2:
			class cron extends MediaHandler{}
			break;
		case 1:
		default:
			class cron extends FormHandler{}
			break;
	}

/**
 * CronHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class CronHandler extends cron
	{
		//Basic SQL Handling Functions
		/**
		 * CronHandler::deleteFromTableWithPrimaryKey()
		 *
		 * @param string $table_name
		 * @param string $primary_key
		 * @param string $key_value
		 * @return
		 */
		public function deleteFromTableWithPrimaryKey($table_name='', $primary_key='', $key_value='')
			{
				$sql = 'DELETE FROM '.$table_name.
						' WHERE '.$primary_key.' = '.$this->dbObj->Param($key_value);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($key_value));

				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * CronHandler::deleteFromTable()
		 *
		 * @param string $table_name
		 * @param string $condition
		 * @param array $paramFields
		 * @return
		 */
		public function deleteFromTable($table_name='', $condition='', $paramFields=array())
			{
				$sql = 'DELETE FROM '.$table_name.' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				if (!$rs)
					trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * CronHandler::updateTable()
		 *
		 * @param string $table_name
		 * @param string $set_fields
		 * @param string $condition
		 * @param array $paramFields
		 * @return
		 */
		public function updateTable($table_name='',$set_fields='' , $condition='', $paramFields=array())
			{
				$sql = 'UPDATE '.$table_name.' SET '.$set_fields. ' WHERE '. $condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				if (!$rs)
					trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * CronHandler::getNumRowsForThisSql()
		 *
		 * @param string $table
		 * @param string $condition
		 * @param array $param_fields
		 * @return
		 */
		public function getNumRowsForThisSql($table='', $condition='0', $param_fields=array())
			{
				$sql = 'SELECT COUNT(*) AS cnt FROM '.$table.' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_fields);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				$count = $row['cnt'];
				return $count;
			}
	}
?>
