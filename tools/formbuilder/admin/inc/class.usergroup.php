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
	class UserGroup extends Base 
	{
		public function __construct()
		{
			parent::__construct(TBL_USER_GROUP);
		}
		
		public function getAllName()
		{
			$outputs = array();
			foreach ($this->records('', '', ' `sort`') as $k=>$v)
			{
				$outputs[$v['id']] = $v['title'];
			}
			return $outputs;
		}
	

	}