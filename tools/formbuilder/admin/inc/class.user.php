<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 *
 * @version 1.0
 *
 *
 */
	include_once(CLASS_BASE);
	class User extends Base
	{
		public function __construct()
		{
			parent::__construct(TBL_USER);
		}
		/**
		 * get all user first name
		 *
		 * @param string $sqlWhere
		 * @param string $sqlLimit
		 * @param string $sqlOrderBy
		 * @return array
		 */
		public 	function getUsersFirstName($sqlWhere = '', $sqlLimit = '', $sqlOrderBy='')
		{

			$outputs = array();
			$query = "SELECT * FROM `" . $this->tableName . "` " . $sqlWhere . "  " . $sqlOrderBy . " " . $sqlLimit;
			$result = $this->db->query($query);
			if(PEAR::isError($result))
			{
				die($result->getMessage());
			}else
			{
				while ($row = strip_slashes2($result->fetchrow()))
				{
					$outputs[$row['id']] = $row['first_name'] . ' ' . $row['last_name'];
				}
			}
			return $outputs;

		}
		/**
		 * get the list of user full name
		 *
		 * @return array
		 */
		public function getUsersFullName()
		{
			$outputs = array();
			return parent::records('', '', 'first_name, last_name');

		}
	}