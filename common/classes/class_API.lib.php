<?php
/**
 * Class Handle the api gnerator related functions
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 */

class API extends FormHandler
	{		
		//format may be xml or json
		public $format = 'xml';
		
		//table names to get the data
		public $table_names = '';
		
		//column names to return
		public $return_columns = array();
		
		//query condition
		public $sql_condition;
		
		public $limit_start;
		
		public $limit_end;
		
		public $orderby_column;
		
		//may be ASC or DESC
		public $orderby;
		
		public function API()
			{
				global $db, $CFG, $LANG;
				$this->setDBObject($db);
				$this->makeGlobalize($CFG, $LANG);
			}		

		public function generateTablesAPI()
			{
				$columns = '*';
				if($this->return_columns)
					$columns = implode(', ', $this->return_columns);
				
				$sql = 'SELECT '.$columns.' FROM '.$this->table_names;
				
				$condition = '1';
				if($this->sql_condition)
					$condition = $this->sql_condition;			
				
				$sql .= ' WHERE '.$condition;
				
				if($this->orderby_column)
					$sql .= ' ORDER BY '.$this->orderby_column;
				
				if($this->orderby_column and $this->orderby)
					$sql .= ' '.$this->orderby;
				
				if(!$this->limit_start and $this->limit_end)
					$this->limit_start = 0;
				
				if($this->limit_end)
					$sql .= ' LIMIT '.$this->limit_start.', '.$this->limit_end;
				
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				
				switch($this->format)
					{
						case 'xml':
								setHeaderStart();
?>
								<table_content>
<?php
								if($rs->PO_RecordCount())
									{
										while($row = $rs->FetchRow())
											{
?>
										<recordset>
<?php
												foreach($row as $key=>$value)
													{
														if(is_int($key))
															continue;
?>
											<<?php echo $key;?>><?php echo $value;?></<?php echo $key;?>>
<?php
													}
?>
										</recordset>
<?php
											}
									}
								else
									{
?>
										<norecords>No records found</norecords>
<?php
									}
?>
								</table_content>
<?php
								setHeaderEnd();
							break;
							
							case 'json':
								$json_code = '{"messages": [';
								$json_code = '';
								if($rs->PO_RecordCount())
									{
										while($row = $rs->FetchRow())
											{
												$json_code .= '{';
												foreach($row as $key=>$value)
													{
														if(is_int($key))
															continue;
														$json_code .= '"'.$key.'": "'.$value.'",';
													}
												$json_code = substr($json_code, 0, strrpos($json_code, ','));
												$json_code .='}';
											}
									}
								echo '{"table_content": [', $json_code, ']}';
							break;
					}
			}
	}
?>