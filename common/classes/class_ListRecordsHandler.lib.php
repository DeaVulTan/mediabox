<?php
/**
 * Record  handler class
 *
 * This is having class ListRecordsHandler having various methods to
 * handle the DB sql operations
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2004-05-21
 */
//------------------- Class ListRecordsHandler begins ------------------->>>>>//
/**
 * List Records Handler class
 *
 * <b>Class overview</b>
 *
 * FormHandler class is used to inherit various types of methods in other classes such as css related methods
 * form fileds storage query building methods
 *
 * <b>Methods overview</b>
 *
 * The setMinRecordSelectLimit, setMaxRecordSelectLimit etc are used for the number of records to be displayed per page.
 * methods such as setCSSFormLabelCellDefaultClass are used to adpot css styles to the cells.methods related to the query
 * building are buildSelectQuery(), buildConditionQuery().setTableNames, setReturnColumns etc are used to set the table names and
 * the fields to be taken from the tables.
 *
 * <b>How to use this class</b>
 *
 * Create object for the class.call the methods depending upon the situations like setting the records to be displayed, building and executing the
 * sql queries, setting css style to the form fields.
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2004-05-21
 */
class ListRecordsHandler extends FormHandler
	{
		/**
		 * @var	string data base object
		 */
		protected $dbObj = null;
		/**
		 * @var	string array of table names
		 */
		protected $table_names_arr = array();
		/**
		 * @var	string array field alaises
		 */
		protected $field_aliases_arr = null;
		/**
		 * @var	string array of table alaises
		 */
		protected $table_aliases_arr = array();
		/**
		 * @var	string array of return coloumns
		 */
		protected $ret_columns = null; //string or array
		/**
		 * @var 	string sql query
		 */
		protected $sql = '';
		/**
		 * @var 	string condition of sql
		 */
		protected $sql_condition = '';
		/**
		 * @var 	string sql of sorting
		 */
		protected $sql_sort = '';
		/**
		 * @var 	string sql count
		 */
		protected $sql_count = '';
		/**
		 * @var 	string query id of sql
		 */
		protected $search_result_query_id = null;
		/**
		 * @var 	array array of records
		 */
		protected $records_arr; //array
		/**
		 * @var 	string sorting url
		 */
		protected $column_sort_url = '';
		/**
		 * @var 	array array of columns
		 */
		protected $dsc_sort_columns_arr = array();
		/**
		 * @var 	array array of columns
		 */
		protected $asc_sort_columns_arr = array();
		/**
		 * @var 	array array of css class
		 */
		protected $css_class_arr = array();
		/**
		 * @var 	array array of alternate css class for rows
		 */
		protected $css_class_alternative_row_arr = array();
		/**
		 * @var 	integer total numer of pages
		 */
		protected $results_tot_pages_num = 3;
		/**
		 * @var 	integer total of results
		 */
		protected $results_tot_num = 253;
		/**
		 * @var 	integer result of starting
		 */
		protected $results_start_num = 50;
		/**
		 * @var 	integer results of ending
		 */
		protected $results_end_num = 58;
		/**
		 * @var 	integer results per page
		 */
		protected $results_num_per_page = 10;
		/**
		 * @var 	boolean search is enabled or not
		 */
		protected $is_search = false;
		/**
		 * @var 	boolean is colorize search results
		 */
		protected $is_colorize_search_results = false;
		/**
		 * @var 	boolean is use stemming
		 */
		protected $is_use_stemming = false;
		/**
		 * @var 	boolean is fulltext search
		 */
		protected $is_fulltext_search = false;
		/**
		 * @var 	boolean is highlight search results
		 */
		protected $is_highlight_search_results = false;
		/**
		 * @var 	string descending
		 */
		protected $field_name_dsc_sort = 'dsc'; //dsc[]
		/**
		 * @var 	string ascending
		 */
		protected $field_name_asc_sort = 'asc'; //asc[]
		/**
		 * @var 	string field name for search
		 */
		protected $field_name_search = 'q'; //q=search
		/**
		 * @var 	string numbers per page
		 */
		protected $field_name_numpg = 'numpg';
		/**
		 * @var 	string field name for start
		 */
		protected $field_name_start = 'start';
		/**
		 * @var 	array array of number per page list
		 */
		protected $num_per_page_list_arr = array();
		/**
		 * @var 	integer minimum of record select
		 */
		protected $record_select_limit_min = 1;
		/**
		 * @var 	integer maximum of record select
		 */
		protected $record_select_limit_max = 50;
		/**
		 * @var 	array array of language string
		 */
		protected $lang = array('sort_ascending' => 'Sort Ascending',
								'sort_descending' => 'Sort Descending'
								);
		/**
		 * @var record set
		 */
		protected $rs = '';

		/**
		 * Constructor
		 *
		 * @return
		 * @access public
		 */
		public function __construct()
			{
				parent::__construct();//So that, CFG, LANG, db will be assigned to class variables..!
				$this->setFormField('start', '0');
				$this->setFormField('numpg', $this->CFG['data_tbl']['numpg']);

				$this->setCSSColumnHeaderCellAscSortClasses(array('clsColumnHeaderCellAscSort1',
																						'clsColumnHeaderCellAscSort2',
																						'clsColumnHeaderCellAscSort3',
																						'clsColumnHeaderCellAscSort4',
																						'clsColumnHeaderCellAscSort5')
																				);
				$this->setCSSColumnHeaderCellDefaultClass('clsColumnHeaderCellDefault');
				$this->setCSSColumnHeaderCellDescSortClasses(array('clsColumnHeaderCellDscSort1',
																	'clsColumnHeaderCellDscSort2',
																	'clsColumnHeaderCellDscSort3',
																	'clsColumnHeaderCellDscSort4',
																	'clsColumnHeaderCellDscSort5')
															);
				$this->setCSSAlternativeRowClasses($this->CFG['data_tbl']['css_alternative_row_classes']);

				$this->setMinRecordSelectLimit(2);
				$this->setMaxRecordSelectLimit($this->CFG['data_tbl']['max_record_select_limit']);
				$this->setNumPerPageListArr($this->CFG['data_tbl']['numperpage_list_arr']);

				$this->setReturnColumns(array('user_id', 'user_name', 'email', 'first_name', 'last_name'));
			}

		/**
		 * To set the DB object
		 *
		 * @param 		object $dbObj Database object
		 * @return 		void
		 * @access 		public
		 */
		public function setDBObject($dbObj)
			{
				$this->dbObj = $dbObj;
			}

		/**
		 * To set the language strings
		 *
		 * @param 		array $lang_arr Language strings
		 * @return 		void
		 * @access 		public
		 */
		public function setLang($lang_arr)
			{
				$this->lang = $lang_arr;
			}

		/**
		 * To set search form fields
		 *
		 * Association needs when the form uses different field names
		 *
		 * @param 		string $start
		 * @param 		string $numpg
		 * @param 		string $dsc
		 * @param 		string $asc
		 * @param 		string $search
		 * @return		void
		 * @access 		public
		 */
		public function setSearchFormFieldNames($start='start', $numpg='numpg', $dsc='dsc', $asc='asc', $search='q')
			{
				$this->field_name_start = $start;
				$this->field_name_numpg = $numpg;
				$this->field_name_dsc_sort = $dsc;
				$this->field_name_asc_sort = $asc;
				$this->field_name_search = $search;
			}

		/**
		 * To set the return columns
		 *
		 * @param 		string/array $ret_columns Array of fields to select
		 * @return 		void
		 * @access 		public
		 */
		public function setReturnColumns($ret_columns)
			{
				$this->ret_columns = $ret_columns; //array or string
			}

		/**
		 * To set the css column header cell default class
		 *
		 * @param 		string $class_name class name
		 * @return 		void
		 * @access 		public
		 */
		public function setCSSColumnHeaderCellDefaultClass($class_name)
			{
				$this->css_class_arr['column_header_cell_default'] = $class_name;
			}

		/**
		 * To set the css column header cell sort classes
		 *
		 * @param 		array $class_names_arr Array of css class names
		 * @return 		void
		 * @access 		public
		 */
		public function setCSSColumnHeaderCellDescSortClasses($class_names_arr=array())
			{
				$this->css_class_arr['column_header_cell_dsc_sort'] = $class_names_arr;
			}

		/**
		 * To set the css column cell classes
		 *
		 * @param 		array $class_names_arr Array of class anmes
		 * @return 		void
		 * @access 		public
		 */
		public function setCSSColumnHeaderCellAscSortClasses($class_names_arr=array())
			{
				$this->css_class_arr['column_header_cell_asc_sort'] = $class_names_arr;
			}

		/**
		 * To set css alternate row classes
		 *
		 * @param 		array $class_names_arr Array of class names
		 * @return 		void
		 * @access 		public
		 */
		public function setCSSAlternativeRowClasses($class_names_arr=array())
			{
				$this->css_class_alternative_row_arr = $class_names_arr;
			}

		/**
		 * To get css column header class
		 *
		 * @param 		string $column_name column name
		 * @return 		void
		 * @access 		public
		 */
		public function getCSSColumnHeaderCellClass($column_name)
			{
				$class_name = $this->css_class_arr['column_header_cell_default'];
				if (($key=array_search($column_name, $this->asc_sort_columns_arr))!==false)
					{
						$tmp_max_css = count($this->css_class_arr['column_header_cell_asc_sort'])-1;
						if ($key > $tmp_max_css)
								$key = $tmp_max_css;
						$class_name = $this->css_class_arr['column_header_cell_asc_sort'][$key];
					}
				  else if (($key=array_search($column_name, $this->dsc_sort_columns_arr))!==false)
					{
						$tmp_max_css = count($this->css_class_arr['column_header_cell_dsc_sort'])-1;
						if ($key > $tmp_max_css)
								$key = $tmp_max_css;
						$class_name = $this->css_class_arr['column_header_cell_dsc_sort'][$key];
					}
				return $class_name;
			}

		/**
		 * To get the css row classes
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCSSRowClass()
			{
				//Other logic can also be implemented like, different styles for user status
				//loop through alternative css
				$class = current($this->css_class_alternative_row_arr) and
							next($this->css_class_alternative_row_arr) or
								reset($this->css_class_alternative_row_arr);
				return $class;
			}

		/**
		 * To set the form field
		 *
		 * @param 		string $field_name Form field name
		 * @param 		string $field_value Form field value
		 * @return 		void
		 * @access 		public
		 * @todo 		for FormHandler class compatible the setFormField method parameters have been changed.
		 */
		public function setFormField($field_name, $field_value, $validation_scheme = null, $custom_validation_fun_name = null)
			{
				//override parent method
				parent::setFormField($field_name, $field_value);
				if ($field_name==$this->field_name_numpg)
					{
						$this->results_num_per_page = is_int(intval($field_value))?$field_value:$this->CFG['data_tbl']['numpg'];
						parent::setFormField($field_name, $this->results_num_per_page);
					}
				else if ($field_name==$this->field_name_start)
					{
						$this->results_start_num = is_int(intval($field_value))?$field_value:0;
						parent::setFormField($field_name, $this->results_start_num);
				    }
			}

		/**
		 * To sanitize form inputs
		 *
		 * @param 		array $request_arr GET/POSt
		 * @return 		void
		 * @access 		public
		 */
		public function sanitizeFormInputs($request_arr)
			{
				//override parent method for better extraction of form fields into proper properties
				parent::sanitizeFormInputs($request_arr);
				//now stuff to proper properties
				if (isset($this->fields_arr[$this->field_name_dsc_sort]))
					$this->dsc_sort_columns_arr = (array)$this->fields_arr[$this->field_name_dsc_sort];
				if (isset($this->fields_arr[$this->field_name_asc_sort]))
					$this->asc_sort_columns_arr = (array)$this->fields_arr[$this->field_name_asc_sort];
				//remove bad inputs like...
				// dsc[]=id&asc[]=id...
				$this->dsc_sort_columns_arr = array_diff($this->dsc_sort_columns_arr,
															array_intersect($this->dsc_sort_columns_arr, $this->asc_sort_columns_arr)
														);
				//the dsc and asc inputs must be present in the expected $this->ret_columns
				$this->dsc_sort_columns_arr = array_intersect($this->dsc_sort_columns_arr, $this->ret_columns);
				$this->asc_sort_columns_arr = array_intersect($this->asc_sort_columns_arr, $this->ret_columns);
				//fix for invalid select limit...
				$this->results_num_per_page = $this->fields_arr[$this->field_name_numpg];
				if ($this->results_num_per_page < $this->record_select_limit_min)
						$this->results_num_per_page = $this->record_select_limit_min;
					else if ($this->results_num_per_page > $this->record_select_limit_max)
						$this->results_num_per_page = $this->record_select_limit_max;
				//reassign fixed..
				$this->fields_arr[$this->field_name_numpg] = is_numeric($this->results_num_per_page)?(int)$this->results_num_per_page:$this->CFG['data_tbl']['numpg'];
				$this->results_start_num = is_numeric($this->fields_arr[$this->field_name_start])?(int)$this->fields_arr[$this->field_name_start]:0;
			}

		/**
		 * To set the number of minimum records to select for the query
		 *
		 * @param 		int $min_limit Minimum limit
		 * @return 		void
		 * @access 		public
		 */
		public function setMinRecordSelectLimit($min_limit)
			{
				$this->record_select_limit_min = $min_limit;
			}

		/**
		 * To set the number of maximum records to select for the sql query
		 *
		 * @param 		int $max_limit Maximum limit
		 * @return 		void
		 * @access 		public
		 */
		public function setMaxRecordSelectLimit($max_limit)
			{
				$this->record_select_limit_max = $max_limit;
			}

		/**
		 * To get the column value
		 *
		 * @param 		string $column_name column name
		 * @return 		void
		 * @access 		public
		 */
		public function getColumnValue($column_name)
			{
				//if search then, return colorized value
				return $this->records_arr[$column_name];
			}

		/**
		 * To set the column sort URL
		 *
		 * @param 		string $url URL
		 * @return 		void
		 * @access 		public
		 */
		public function setColumnSortUrl($url)
			{
				$this->column_sort_url = $url;
			}

		/**
		 * To get the column header ahref link
		 *
		 * @param 		string $column_name column name
		 * @return 		void
		 * @access 		public
		 */
		public function getColumnHeaderAHref($column_name)
			{
				//form the query strings "appropriately"
				$href = '';
				foreach($this->fields_arr as $field_name=>$field_value)
					{
						if ((is_array($field_value)))
							{
						         $sub_fields_arr = $field_value; //for naming clarity
								 //handle dsc & asc sort columns outside of this loop
				 				 if ($field_name!=$this->field_name_dsc_sort &&
								 		$field_name!=$this->field_name_asc_sort)
									{
										//note the [] as it is array
										foreach($sub_fields_arr as $sub_key=>$sub_value)
											$href .= $field_name.'[]='.urlencode($sub_value).'&amp;';
									}
						     }
							else
								$href .= $field_name.'='.urlencode($field_value).'&amp;';
					}
				//now handle dsc & dsc sort columns...
				//to flip sorting order
				$tmp_dsc_sort_columns_arr = $this->dsc_sort_columns_arr;
				$tmp_asc_sort_columns_arr = $this->asc_sort_columns_arr;
				if (in_array($column_name, $this->dsc_sort_columns_arr))
					 {
			          	//flip sorting order
						unset($tmp_dsc_sort_columns_arr[array_search($column_name, $tmp_dsc_sort_columns_arr)]);
						$tmp_asc_sort_columns_arr[] = $column_name;
			         }
				 else if (in_array($column_name, $this->asc_sort_columns_arr))
				 	{
			          	//flip sorting order
						unset($tmp_asc_sort_columns_arr[array_search($column_name, $tmp_asc_sort_columns_arr)]);
						$tmp_dsc_sort_columns_arr[] = $column_name;
				    }
				  else  //add default asc order...
						$tmp_asc_sort_columns_arr[] = $column_name;
				//now, build sort order values...
				foreach($tmp_asc_sort_columns_arr as $asc_col_name)
					$href .= $this->field_name_asc_sort.'[]='.urlencode($asc_col_name).'&amp;';
				foreach($tmp_dsc_sort_columns_arr as $dsc_col_name)
					$href .= $this->field_name_dsc_sort.'[]='.urlencode($dsc_col_name).'&amp;';

				//remove trailing '&'
				$href = substr($href, 0, strrpos($href, '&amp;'));
				return $this->column_sort_url.'?'.$href;
			}

		/**
		 * To get column header ahref title
		 *
		 * @param 		string $column_name
		 * @return 		void
		 * @access 		public
		 */
		public function getColumnHeaderATitle($column_name)
			{
				if (in_array($column_name, $this->dsc_sort_columns_arr))
						$title = $this->lang['sort_ascending'];
				 else if (in_array($column_name, $this->asc_sort_columns_arr))
						$title = $this->lang['sort_descending'];
				  else  //add default asc order...
						$title = $this->lang['sort_ascending'];
				return $title;
			}

		/**
		 * To set alaises for return columns
		 * for more than 1 table with same field names
		 * 'id'=> users.id, 'name'=>user.ff
		 *
		 * @param 		array $field_aliases_arr Array of alaises fields
		 * @return 		void
		 * @access 		public
		 */
		public function setReturnColumnsAliases($field_aliases_arr)
			{
				$this->field_aliases_arr = $field_aliases_arr;
			}

		/**
		 * To set the table names
		 *
		 * @param 		array $table_names_arr Array of table names
		 * @return 		void
		 * @access 		public
		 */
		public function setTableNames($table_names_arr)
			{
				$this->table_names_arr = $table_names_arr;
			}

		/**
		 * To set the alaises table names
		 *
		 * @param 		array $table_aliases_arr Array of table alaises
		 * @return		void
		 * @access 		public
		 */
		public function setTableNameAliases($table_aliases_arr)
			{
				$this->table_aliases_arr = $table_aliases_arr;
			}

		/**
		 * To bulid select query
		 *
		 * @return void
		 * @access public
		 */
		public function buildSelectQuery()
			{
				$this->sql = 'SELECT ';
				if (is_string($this->ret_columns) && $this->ret_columns=='*')
						$this->sql .= '*';
					else if (is_array($this->ret_columns))
						 {
							foreach($this->ret_columns as $ret_column)
								{
									//if it has alias...
									if (isset($this->field_aliases_arr[$ret_column]))
											$this->sql .= $this->field_aliases_arr[$ret_column].' AS '.$ret_column.', ';
										else
											$this->sql .= $ret_column.', ';
								}
					     }
				$this->sql = substr($this->sql, 0, strrpos($this->sql, ', ')); //remove final ", "
				$this->sql .= ' FROM ';
				foreach($this->table_names_arr as $table_name)
					{
						if (isset($this->table_aliases_arr[$table_name]))
							{
								if (is_string($this->table_aliases_arr[$table_name]))
									$this->sql .= $table_name.' AS '.$this->table_aliases_arr[$table_name].', ';
								else if (is_array($this->table_aliases_arr[$table_name]))
									foreach($this->table_aliases_arr[$table_name] as $sub_alias)
										$this->sql .= $table_name.' AS '.$sub_alias.', ';
							}
						else
							$this->sql .= $table_name.', ';
					}
				$this->sql = substr($this->sql, 0, strrpos($this->sql, ', ')); //remove final ", "
			}

		/**
		 * To set the sql condition
		 * prelim WHERE clause
		 *
		 * @param 		string $sql_condition sql condition
		 * @return 		void
		 * @access 		public
		 */
		public function setRecordSelectConditionSQL($sql_condition)
			{
				$this->sql_condition = $sql_condition;
			}

		/**
		 * To build condition of sql
		 * used along with search??
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function buildConditionQuery()
			{
				//form the query...WHERE clause
				$this->sql_condition = '';
			}

		/**
		 * To build sorting query
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function buildSortQuery()
			{
				$tmp_dsc_sort_columns_arr = $this->dsc_sort_columns_arr;
				$tmp_asc_sort_columns_arr = $this->asc_sort_columns_arr;
				if (is_array($this->field_aliases_arr))
					{
					    foreach($this->field_aliases_arr as $alias=>$original) // 'id'=>'table.id'
							{
								if (($key=array_search($alias, $this->dsc_sort_columns_arr))!==false)
										$tmp_dsc_sort_columns_arr[$key] = $original;
								if (($key=array_search($alias, $this->asc_sort_columns_arr))!==false)
										$tmp_asc_sort_columns_arr[$key] = $original;
							}
					}
				//optimzation.. while-each is faster than foreach
				if ($tmp_asc_sort_columns_arr)
					while(list(, $asc_field)=each($tmp_asc_sort_columns_arr))
						$this->sql_sort .= $asc_field.' ASC, ';
				if ($tmp_dsc_sort_columns_arr)
					while(list(, $dsc_field)=each($tmp_dsc_sort_columns_arr))
						$this->sql_sort .= $dsc_field.' DESC, ';
				$this->sql_sort = substr($this->sql_sort, 0, strrpos($this->sql_sort, ', ')); //remove final ", "
			}

		//avoid it.
		/**
		 * To set the sql query
		 *
		 * @param 		string $sql sql query
		 * @return 		void
		 * @access 		public
		 */
		public function setRecordSelectSQL($sql)
			{
				$this->sql = $sql;
			}

		/**
		 * To build final sql query
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function buildQuery()
			{
				//count query..
				$this->sql_count = 'SELECT COUNT(*) AS count FROM ';

				foreach($this->table_names_arr as $table_name)
					{
						if (isset($this->table_aliases_arr[$table_name]))
							{
								if (is_string($this->table_aliases_arr[$table_name]))
									$this->sql_count .= $table_name.' AS '.$this->table_aliases_arr[$table_name].', ';
								else if (is_array($this->table_aliases_arr[$table_name]))
									foreach($this->table_aliases_arr[$table_name] as $sub_alias)
										$this->sql_count .= $table_name.' AS '.$sub_alias .', ';
							}
						else
							$this->sql_count .= $table_name.', ';
					}

				$this->sql_count = substr($this->sql_count, 0, strrpos($this->sql_count, ',')); //remove final ,
				if ($this->sql_condition)
					$this->sql_count .= ' WHERE '.$this->sql_condition;
				//main query...
				if ($this->sql_condition)
					$this->sql .= ' WHERE '.$this->sql_condition;
				if ($this->sql_sort)
					$this->sql .= ' ORDER BY '.$this->sql_sort;
				$this->sql .= ' LIMIT '.$this->results_start_num.','.$this->results_num_per_page;
			}

		/**
		 * To execute query
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function executeQuery()
			{
				//count...
				// prepare query
				$stmt = $this->dbObj->Prepare($this->sql_count);
				// execute query
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
						trigger_db_error($this->dbObj);
				// fetch array of row
				$row = $rs->fetchRow();
				// counts number of rows
				$this->results_tot_num = $row['count'];
				$this->results_end_num = $this->results_tot_pages_num = 0;
				//main query.. don't query the whole unnecessarily...
				if ($this->results_tot_num)
					{
						$this->results_tot_pages_num = ceil($this->results_tot_num/$this->results_num_per_page);
						// prepare query
						$stmt = $this->dbObj->Prepare($this->sql);
						// execute query
						$this->rs = $this->dbObj->Execute($stmt);
						//raise user error... fatal
						if (!$this->rs)
							trigger_db_error($this->dbObj);
						// sets total number of records
						$this->results_end_num = $this->results_start_num + $this->rs->PO_RecordCount();
					}
			}

		/**
		 * ListRecordsHandler::isGroupByQuery()
		 *
		 * @return
		 */
		public function isGroupByQuery()
			{
				if(strpos($this->sql, ' GROUP BY'))
					return true;
				return false;
			}

		/**
		 * ListRecordsHandler::groupByExecuteQuery()
		 *
		 * @return
		 **/
		public function groupByExecuteQuery()
			{
				//count...
				// prepare query
				$stmt = $this->dbObj->Prepare($this->sql_count);
				// execute query
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
						trigger_db_error($this->dbObj);
				// fetch array of row
				$row = $rs->fetchRow();
				// counts number of rows
				$this->results_tot_num = $rs->PO_RecordCount();
				$this->results_end_num = $this->results_tot_pages_num = 0;
				//main query.. don't query the whole unnecessarily...
				if ($this->results_tot_num)
					{
						$this->results_tot_pages_num = ceil($this->results_tot_num/$this->results_num_per_page);
						// prepare query
						$stmt = $this->dbObj->Prepare($this->sql);
						// execute query
						$this->rs = $this->dbObj->Execute($stmt);
						//raise user error... fatal
						if (!$this->rs)
							trigger_db_error($this->dbObj);
						// sets total number of records
						$this->results_end_num = $this->results_start_num + $this->rs->PO_RecordCount();
					}
			}

		/**
		 * To get the results of sql
		 *
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function isResultsFound()
			{
				return $this->results_tot_num;
			}

		/**
		 * To get the results of sql after fetching
		 *
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function fetchResultRecord()
			{
				return ($this->rs)? ($this->records_arr = $this->rs->FetchRow()) : '';
			}

		/**
		 * To get the starting limit of the query
		 *
		 * @return integer $this->results_start_num Starting limit
		 * @access public
		 */
		public function getResultsStartNum()
			{
				return $this->results_start_num;
			}

		/**
		 * To get the ending limit of the sql query
		 *
		 * @return integer $this->results_end_num Ending limit
		 * @access public
		 */
		public function getResultsEndNum()
			{
				return $this->results_end_num;
			}

		/**
		 * To get the totla number of records of the sql result
		 *
		 * @return integer $this->results_tot_num Total number of records
		 * @access public
		 */
		public function getResultsTotalNum()
			{
				return $this->results_tot_num;
			}

		/**
		 * To get the total number of pages
		 *
		 * @return 		integer $this->results_tot_pages_num Total number of pages
		 * @access 		public
		 */
		public function getResultsTotPagesNum()
			{
				return $this->results_tot_pages_num;
			}

		/**
		 * To populate page numbers in list box
		 *
		 * in index have the start offset, but in value show the page number
		 * <option value="start">Page number</option>
		 *
		 * @param 		$highlight_start High lighted value
		 * @return 		void
		 * @access 		public
		 */
		public function populatePageNumbersList($highlight_start)
			{
				$is_selected = false;
				for($pg=1, $start=0; $pg<=$this->results_tot_pages_num; ++$pg, $start+=$this->results_num_per_page)
					{
?>
	<option value="<?php echo $start;?>"<?php echo (!$is_selected && $start>=$highlight_start)? ' selected="selected"' : '';?>><?php echo $pg;?></option>
<?php
				$is_selected = ($start>=$highlight_start);
					}
			}

		/**
		 * To set the number of pages
		 *
		 * @param 		array $num_per_page_list_arr Array of number of records per page
		 * @return 		void
		 */
		public function setNumPerPageListArr($num_per_page_list_arr)
			{
				$this->num_per_page_list_arr = $num_per_page_list_arr;
			}

		/**
		 * To populate the numper of records per pages in list box
		 *
		 * @param 		array $highlight_numpg hightlighted number
		 * @return 		void
		 * @access 		public
		 */
		public function populateNumPerPageList($highlight_numpg)
			{
				foreach($this->num_per_page_list_arr as $num_per_page)
					{
?>
	<option value="<?php echo $num_per_page;?>"<?php echo ($highlight_numpg==$num_per_page)? ' selected="selected"' : '';?>><?php echo $num_per_page;?></option>
<?php
					}
			}

		/**
		 * To populate hidden form fields
		 *
		 * @param 		array $field_names_arr Array of fields
		 * @return 		void
		 * @access		public
		 */
		public function populateHiddenFormFields($field_names_arr=array())
			{
				foreach($field_names_arr as $field_name)
					{
						if (is_array($this->fields_arr[$field_name]))
						{
							foreach($this->fields_arr[$field_name] as $sub_field_value)
								{
?>
	<input type="hidden" name="<?php echo $field_name;?>[]" value="<?php echo $sub_field_value;?>" />
<?php
								}
						}
						else
							{
?>
	<input type="hidden" name="<?php echo $field_name;?>" value="<?php echo $this->fields_arr[$field_name];?>" />
<?php
							}
					}
			}
///////////////////////////////////////////////////////////////////
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//@todo search part, ie, form field 'q'
///////////////////////////////////////////////////////////////////
		public function setIsSearch($is_search)
			{
				$this->is_search = $is_search;
			}

		//Slide show
		//@link http://www.php-kongress.de/2003/slides/database_track/golubchik_mysql_fulltext_search_2003.pdf
		//@link http://dev.mysql.com/doc/mysql/en/fulltext-search.html
		//Restriction: Only on MyISAM
		//@link http://dev.mysql.com/doc/mysql/en/fulltext-restrictions.html
		public function setIsFullTextSearch($is_fulltext_search)
			{
			//$is_fulltext_search
			}

		public function setIsUseStemming($is_use)
			{
				$this->is_use_stemming = $is_use;
			}

		public function setIsHighlightSearchResults($is_highlight)
			{
				$this->is_highlight_search_results = $is_highlight;
			}


		//@link http://www.phpbuilder.com/mail/php-general/2002112/1670.php
		private function _tokenizeSearchString($input)
			{
			    //logic grabbed at http://www.phpbuilder.com/mail/php-general/2002112/1670.php
				$regexp = '/\s*(.*?)\s*"\s*([^"]*?)\s*"\s*(.*)/s';
			    /* look for 3 groups:
			       a - prematch - anything up to the first quote
			       b - match - anything until the next quote
			       c - postmatch - rest of the string
			    */
			    $tokens = array();
			    while(preg_match($regexp, $input, $result_arr))
					{
				        // result_arr contains: [0]-total [1]-a [2]-b [3]-c
				        // tokenize the prematch
				        if ($result_arr[1])
								$tokens = array_merge($tokens, explode(' ', $result_arr[1]));
//				        array_push($tokens, $result_arr[2]);
						//following line is for optimization. @todo Check if it works
						$tokens[] = $result_arr[2];
				        $input = $result_arr[3];
				    }
			    // $input has the rest of the line
			    if ($input)
						$tokens = array_merge($tokens, explode(' ', $input));
			    return $tokens;
			}

		public function setSearchString($search_str)
			{
				$tokens_arr = $this->_tokenizeSearchString($search_str);
				//process & put them in proper arrays...
				foreach($tokens_arr as $key => $keyword)
					{
						if (substr($keyword, 0, 1)=='-' && strlen($keyword)>1) //if first character of the word is - eg. -ExcludeThisWord
								$this->search_exclude[] = substr($keyword, 1);
							else
								$this->search_include[] = $keyword;
					}
			}

		public function setSearchFieldNames()
			{
				if (is_string())
				{

				}
				else if (is_array())
				{

				}
			}

		/**
		 * ListRecordsHandler::populatePageLinks()
		 *
		 * @param string $highlight_start
		 * @param array $field_names_arr
		 * @return
		 **/
		public function populatePageLinksGET($highlight_start = '0', $field_names_arr=array())
			{
				if(!$this->isPagingRequired())
					return;

				$href_url = getCurrentUrl(false);

				if ($highlight_start >= $this->results_tot_num)
					return false;
				$query_str = '';
				$highlight_start = floor($highlight_start / $this->results_num_per_page) * $this->results_num_per_page;
				foreach($field_names_arr as $field_name)
					{
						if (is_array($this->fields_arr[$field_name]))
						{
							foreach($this->fields_arr[$field_name] as $sub_field_value)
								$query_str .= "&amp;".$field_name."[]=$sub_field_value";
						}
						else
							$query_str .= "&amp;$field_name=".$this->fields_arr[$field_name];
					}

				$is_selected = false;
				$num_pages = 5;
				$num_expect = 10;

				$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
				$start_al = $highlight_start - ($num_pages * $this->results_num_per_page);
				$pg_al = $highlight_start / $this->results_num_per_page - ($num_pages -1 );
				if($highlight_start>1)
					{
						$sss_value = $highlight_start - $this->results_num_per_page;
						$sss_value = ($sss_value==0)?1:$sss_value;
						$PAGING['previous']['start'] = $sss_value;
						$PAGING['previous']['onclick'] = "true";
						$PAGING['previous']['href'] = getCleanUrl($href_url.'?start='.(($sss_value==1)?0:$sss_value).$query_str);
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = 1;
						$PAGING['first']['onclick'] = "true";
						$PAGING['first']['href'] = getCleanUrl($href_url.'?start=0'.$query_str);
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}
				else
					{
						$PAGING['previous']['start'] = '';
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = '';
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}

				if (ceil($highlight_start / $this->results_num_per_page) <= $num_pages)
					{
						$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
						$start_al = 0;
						$pg_al = 1;
					}
				$tot_page_num_for = $tot_page_num<$num_expect?($num_expect):$tot_page_num;

				//$tot_page_num = ($tot_page_num_for*$num_pages>$this->results_tot_num)?$tot_page_num_for:$tot_page_num;

				//$tot_page_num = ($tot_page_num<$num_expect and (ceil($this->results_tot_num/$this->results_num_per_page))>$num_expect)?$num_expect:$tot_page_num;

				$tot_page_num = ($tot_page_num_for*$this->results_num_per_page)>$this->results_tot_num?ceil($this->results_tot_num/$this->results_num_per_page):$tot_page_num_for;

				$pg_al_for = ($tot_page_num-$pg_al)<$num_expect?($tot_page_num-$num_expect+1):$pg_al;

				$pg_al = $pg_al_for<1?1:$pg_al_for;
				$start_al = $pg_al*$this->results_num_per_page-$this->results_num_per_page;

				$inc_count = 0;
				for($pg=$pg_al, $start=$start_al; $pg<=$tot_page_num; ++$pg, $start+=$this->results_num_per_page)
					{
						//$res .= (!$is_selected && $start>=$highlight_start)? "<li class=\"clsCurrPage\"><span>".$pg."</span></li>" : " <li><a href=\"".$href_url."\" onclick=\"return pagingSubmit('".$form_name."','".$start."')\">".$pg."</a></li>";
						//$is_selected = ($start>=$highlight_start);

						if(!$is_selected && ($start>=$highlight_start))
							{
								$PAGING['list']['start'][$inc_count] = '';
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						else
							{
								$sss_value = $start;
								$sss_value = ($sss_value==0)?1:$sss_value;
								$PAGING['list']['start'][$inc_count] = $sss_value;
								$PAGING['list']['onclick'][$inc_count] = "true";
								$PAGING['list']['href'][$inc_count] = getCleanUrl($href_url.'?start='.(($sss_value==1)?0:$sss_value).$query_str);
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						$is_selected = ($start>=$highlight_start);
						$inc_count++;
					}
				if ($this->results_tot_num>$highlight_start + $this->results_num_per_page)
					{
						$next = $highlight_start + $this->results_num_per_page;
						$last = (ceil($this->results_tot_num/$this->results_num_per_page)*$this->results_num_per_page)-$this->results_num_per_page;
						$last = $last<$next?$next:$last;

						$PAGING['next']['start'] = $next;
						$PAGING['next']['onclick'] = "true";
						$PAGING['next']['href'] = getCleanUrl($href_url.'?start='.$next.$query_str);
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = $last;
						$PAGING['last']['onclick'] = "true";
						$PAGING['last']['href'] = getCleanUrl($href_url.'?start='.$last.$query_str);
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				else
					{
						$PAGING['next']['start'] = '';
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = '';
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				return $PAGING;
			}

		/**
		 * ListRecordsHandler::populatePageLinksPOST()
		 *
		 * @param string $highlight_start
		 * @param array $field_names_arr
		 * @return
		 **/
		public function populatePageLinksPOST($highlight_start = '0', $form_name = '')
			{
				if(!$this->isPagingRequired())
					return;

				$href_url = $_SERVER['REQUEST_URI'];

				if ($highlight_start >= $this->results_tot_num)
					return false;
				$query_str = '';
				$highlight_start = floor($highlight_start / $this->results_num_per_page) * $this->results_num_per_page;

				$is_selected = false;
				$num_pages = 5;
				$num_expect = 10;

				$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
				$start_al = $highlight_start - ($num_pages * $this->results_num_per_page);
				$pg_al = $highlight_start / $this->results_num_per_page - ($num_pages -1 );
				if($highlight_start>1)
					{
						$sss_value = $highlight_start - $this->results_num_per_page;
						$sss_value = ($sss_value==0)?1:$sss_value;
						$PAGING['previous']['start'] = $sss_value;
						$PAGING['previous']['onclick'] = "pagingSubmit('".$form_name."','".(($sss_value==1)?0:$sss_value)."')";
						$PAGING['previous']['href'] = getCleanUrl($href_url);
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = 1;
						$PAGING['first']['onclick'] = "pagingSubmit('".$form_name."','0')";
						$PAGING['first']['href'] = getCleanUrl($href_url);
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}
				else
					{
						$PAGING['previous']['start'] = '';
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = '';
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}

				if (ceil($highlight_start / $this->results_num_per_page) <= $num_pages)
					{
						$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
						$start_al = 0;
						$pg_al = 1;
					}
				$tot_page_num_for = $tot_page_num<$num_expect?($num_expect):$tot_page_num;

				//$tot_page_num = ($tot_page_num_for*$num_pages>$this->results_tot_num)?$tot_page_num_for:$tot_page_num;

				//$tot_page_num = ($tot_page_num<$num_expect and (ceil($this->results_tot_num/$this->results_num_per_page))>$num_expect)?$num_expect:$tot_page_num;

				$tot_page_num = ($tot_page_num_for*$this->results_num_per_page)>$this->results_tot_num?ceil($this->results_tot_num/$this->results_num_per_page):$tot_page_num_for;

				$pg_al_for = ($tot_page_num-$pg_al)<$num_expect?($tot_page_num-$num_expect+1):$pg_al;

				$pg_al = $pg_al_for<1?1:$pg_al_for;
				$start_al = $pg_al*$this->results_num_per_page-$this->results_num_per_page;

				$inc_count = 0;
				for($pg=$pg_al, $start=$start_al; $pg<=$tot_page_num; ++$pg, $start+=$this->results_num_per_page)
					{
						//$res .= (!$is_selected && $start>=$highlight_start)? "<li class=\"clsCurrPage\"><span>".$pg."</span></li>" : " <li><a href=\"".$href_url."\" onclick=\"return pagingSubmit('".$form_name."','".$start."')\">".$pg."</a></li>";
						//$is_selected = ($start>=$highlight_start);

						if(!$is_selected && ($start>=$highlight_start))
							{
								$PAGING['list']['start'][$inc_count] = '';
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						else
							{
								$sss_value = $start;
								$sss_value = ($sss_value==0)?1:$sss_value;
								$PAGING['list']['start'][$inc_count] = $sss_value;
								$PAGING['list']['onclick'][$inc_count] = "pagingSubmit('".$form_name."','".(($sss_value==1)?0:$sss_value)."')";
								$PAGING['list']['href'][$inc_count] = getCleanUrl($href_url);
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						$is_selected = ($start>=$highlight_start);
						$inc_count++;
					}
				if ($this->results_tot_num>$highlight_start + $this->results_num_per_page)
					{
						$next = $highlight_start + $this->results_num_per_page;
						$last = (ceil($this->results_tot_num/$this->results_num_per_page)*$this->results_num_per_page)-$this->results_num_per_page;
						$last = $last<$next?$next:$last;

						$PAGING['next']['start'] = $next;
						$PAGING['next']['onclick'] = "pagingSubmit('".$form_name."','".$next."')";
						$PAGING['next']['href'] = getCleanUrl($href_url);
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = $last;
						$PAGING['last']['onclick'] = "pagingSubmit('".$form_name."','".$last."')";
						$PAGING['last']['href'] = getCleanUrl($href_url);
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				else
					{
						$PAGING['next']['start'] = '';
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = '';
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				return $PAGING;
			}

		/**
		 * ListRecordsHandler::populatePageLinksPOSTViaAjax()
		 *
		 * @param string $highlight_start
		 * @param array $field_names_arr
		 * @return
		 **/
		public function populatePageLinksPOSTViaAjax($highlight_start = '0', $form_name, $div_id)
			{
				if(!$this->isPagingRequired())
					return;

				$href_url = $_SERVER['REQUEST_URI'];

				if ($highlight_start >= $this->results_tot_num)
					return false;
				$query_str = '';
				$highlight_start = floor($highlight_start / $this->results_num_per_page) * $this->results_num_per_page;

				$is_selected = false;
				$num_pages = 5;
				$num_expect = 10;

				$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
				$start_al = $highlight_start - ($num_pages * $this->results_num_per_page);
				$pg_al = $highlight_start / $this->results_num_per_page - ($num_pages -1 );
				if($highlight_start>1)
					{
						$sss_value = $highlight_start - $this->results_num_per_page;
						$sss_value = ($sss_value==0)?1:$sss_value;
						$PAGING['previous']['start'] = $sss_value;
						$PAGING['previous']['onclick'] = "pagingSubmitViaAjax('".$form_name."','".$div_id."','".(($sss_value==1)?0:$sss_value)."')";
						$PAGING['previous']['href'] = getCleanUrl($href_url);
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = 1;
						$PAGING['first']['onclick'] = "pagingSubmitViaAjax('".$form_name."','".$div_id."','0')";
						$PAGING['first']['href'] = getCleanUrl($href_url);
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}
				else
					{
						$PAGING['previous']['start'] = '';
						$PAGING['previous']['display_text'] = $this->LANG['common_paging_previous'];

						$PAGING['first']['start'] = '';
						$PAGING['first']['display_text'] = $this->LANG['common_paging_first'];
					}

				if (ceil($highlight_start / $this->results_num_per_page) <= $num_pages)
					{
						$tot_page_num = (($num_pages + floor($highlight_start / $this->results_num_per_page)) < $this->results_tot_pages_num) ? ($num_pages + floor($highlight_start / $this->results_num_per_page)) : $this->results_tot_pages_num;
						$start_al = 0;
						$pg_al = 1;
					}
				$tot_page_num_for = $tot_page_num<$num_expect?($num_expect):$tot_page_num;

				//$tot_page_num = ($tot_page_num_for*$num_pages>$this->results_tot_num)?$tot_page_num_for:$tot_page_num;

				//$tot_page_num = ($tot_page_num<$num_expect and (ceil($this->results_tot_num/$this->results_num_per_page))>$num_expect)?$num_expect:$tot_page_num;

				$tot_page_num = ($tot_page_num_for*$this->results_num_per_page)>$this->results_tot_num?ceil($this->results_tot_num/$this->results_num_per_page):$tot_page_num_for;

				$pg_al_for = ($tot_page_num-$pg_al)<$num_expect?($tot_page_num-$num_expect+1):$pg_al;

				$pg_al = $pg_al_for<1?1:$pg_al_for;
				$start_al = $pg_al*$this->results_num_per_page-$this->results_num_per_page;

				$inc_count = 0;
				for($pg=$pg_al, $start=$start_al; $pg<=$tot_page_num; ++$pg, $start+=$this->results_num_per_page)
					{
						//$res .= (!$is_selected && $start>=$highlight_start)? "<li class=\"clsCurrPage\"><span>".$pg."</span></li>" : " <li><a href=\"".$href_url."\" onclick=\"pagingSubmitViaAjax('".$form_name."','".$div_id."','".$start."')\">".$pg."</a></li>";
						//$is_selected = ($start>=$highlight_start);

						if(!$is_selected && ($start>=$highlight_start))
							{
								$PAGING['list']['start'][$inc_count] = '';
								$PAGING['list']['page_id'][$inc_count] = '';
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						else
							{
								$sss_value = $start;
								$sss_value = ($sss_value==0)?1:$sss_value;
								$PAGING['list']['page_id'][$inc_count] = '';
								$PAGING['list']['start'][$inc_count] = $sss_value;
								$PAGING['list']['onclick'][$inc_count] = "pagingSubmitViaAjax('".$form_name."','".$div_id."','".(($sss_value==1)?0:$sss_value)."')";
								$PAGING['list']['href'][$inc_count] = getCleanUrl($href_url);
								$PAGING['list']['display_text'][$inc_count] = $pg;
							}
						$is_selected = ($start>=$highlight_start);
						$inc_count++;
					}
				if ($this->results_tot_num>$highlight_start + $this->results_num_per_page)
					{
						$next = $highlight_start + $this->results_num_per_page;
						$last = (ceil($this->results_tot_num/$this->results_num_per_page)*$this->results_num_per_page)-$this->results_num_per_page;
						$last = $last<$next?$next:$last;

						$PAGING['next']['start'] = $next;
						$PAGING['next']['onclick'] = "pagingSubmitViaAjax('".$form_name."','".$div_id."','".$next."')";
						$PAGING['next']['href'] = getCleanUrl($href_url);
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = $last;
						$PAGING['last']['onclick'] = "pagingSubmitViaAjax('".$form_name."','".$div_id."','".$last."')";
						$PAGING['last']['href'] = getCleanUrl($href_url);
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				else
					{
						$PAGING['next']['start'] = '';
						$PAGING['next']['display_text'] = $this->LANG['common_paging_next'];

						$PAGING['last']['start'] = '';
						$PAGING['last']['display_text'] = $this->LANG['common_paging_last'];
					}
				return $PAGING;
			}

		/**
		 * ListRecordsHandler::getOrderCss()
		 *
		 * @param $field
		 * @return
		 **/
		public function getOrderCss($field)
			{
				if($this->fields_arr['orderby_field']==$field)
					{
		  				if($this->fields_arr['orderby']=='desc')
							{
		  						return ' clsSort clsDesc';
							}
		  				else
							{
		  						return ' clsSort clsAsc';
							}
					}
				else
					{
		  						return ' clsSort';
					}
			}

		public function isPagingRequired()
			{
				if($this->results_tot_num > $this->results_num_per_page)
					{
						return true;
					}
				return false;
			}

		public function printQuery()
			{
				echo 'SQL: '.$this->sql,'<br><br>';
				echo 'SQL COUNT: '.$this->sql_count,'<br><br>';
			}
	}