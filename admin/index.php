<?php
/**
 * This file is used to show the site statistics an latest product news
 *
 * The site statistics contain following details
 *
 * Total Members
 * Members to be activated
 * Members Joined today
 * Members Joined This week
 * Members Joined This month
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/index.php';
$CFG['mods']['include_files'][] = 'common/classes/class_XmlParser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');

//---------------------------- Class statistics begins -------------------->>>>>//
/**
 * This class is used to show the site statistics an latest product news
 *
 * @category	Rayzz
 * @package		Admin
 */
class statistics extends FormHandler
	{
		/**
		 * statistics::membersStatistics()
		 * To get the statistics list
		 *
		 * @return 		array
		 * @access 		public
		 */
		public function membersStatistics()
			{
				$membersStatistics_arr = array();

				//Total Active member...
				$sql = ' SELECT count(user_id) as total FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['total']!='' or isset($row['total']))
					{
						$membersStatistics_arr['total_active_member'] = $row['total'];
					}
				else
					{
						$membersStatistics_arr['total_active_member'] = 0;
					}
				//Waiting for activation members
				$sql = ' SELECT count(user_id) as total FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'ToActivate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$membersStatistics_arr['total_toactivate_member'] = $row['total'];

				//Today members
				$sql = ' SELECT count(user_id) as total FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'Ok\'  AND DATE_FORMAT(doj,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$membersStatistics_arr['total_today_member'] = $row['total'];

				//This week
				$sql = ' SELECT count(user_id) as total FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 7 DAY ) <= doj';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$membersStatistics_arr['this_week_member'] = $row['total'];

				//This month
				$sql = ' SELECT count(user_id) as total FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status = \'Ok\'  AND DATE_SUB( CURDATE( ) , INTERVAL 30 DAY ) <= doj';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$membersStatistics_arr['this_month_member'] = $row['total'];

				return $membersStatistics_arr;
			}

		/**
		 * statistics::populateNews()
		 * To populate the latest product news list
		 *
		 * @return 		array
		 * @access 		public
		 */
		public function populateNews()
			{
				$getContents_ar = array();
				return $getContents_ar;

				if($content = getContents($this->CFG['members']['productnews']))
					{
						$xmlObj = new XmlParser();
						$output_arr = $xmlObj->parse($content);
						if(isset($output_arr[0]['children']) and $output_arr[0]['children'])
							{
								$output_arr = $output_arr[0]['children'];
								$inc = 0;
								foreach($output_arr as $key=>$value)
									{
										if(!$value or !is_array($value))
											{
												continue;
											}
										foreach($value as $key1=>$value1)
											{
												if(!$value1 or !is_array($value1))
													{
														continue;
													}
												foreach($value1 as $key2=>$value2)
													{
														$getContents_ar[$inc][$value2['name']] = $value2['tagData'];
													}
											}
										$inc++;
										if($inc>=5)
											{
												break;
											}
									}
							}
					}
				return $getContents_ar;
			}
	}
//<<<<<---------------class statistics ends -------------///
//--------------------Code begins-------------->>>>>//
$statistics = new statistics();
$statistics->setPageBlockNames(array('statistics_list', 'latestnews_list'));
$statistics->setAllPageBlocksHide();
$statistics->setPageBlockShow('statistics_list');
$statistics->setPageBlockShow('latestnews_list');
if ($statistics->isShowPageBlock('statistics_list'))
	{
		$statistics->statistics_list['membersStatistics'] = $statistics->membersStatistics();
		$count=0;
		$flag = 0;
		$firstModule='';
		foreach($CFG['site']['modules_arr'] as $value)
			{
				if(chkAllowedModule(array(strtolower($value))))
					{
						$function_name = 'admin'.ucfirst($value).'Statistics';
						if(function_exists($function_name))
							{
								if($flag == 0)
									{
										$firstModule = $value;
										$flag = 1;
									}
								$function_name();
								$count++;
							}
					}
			}
		$statistics->statistics_list['firstModule'] = $firstModule;
	}
if ($statistics->isShowPageBlock('latestnews_list'))
	{
		$statistics->latestnews_list['populateNews'] = $statistics->populateNews();
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
$statistics->left_navigation_div = '';
//include the header file
$statistics->includeHeader();
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('index.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$statistics->includeFooter();
?>