<?php
/**
 * This file hadling the new product update related news
 *
 * It will display the product update and new module release related news from product development team
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'languages/%s/admin/latestNews.php';
$CFG['mods']['include_files'][] = 'common/classes/class_XmlParser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * This class hadling the new product update related news
 *
 * @category	Rayzz
 * @package		Admin
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class editConfigData begins --------------->>>>>//

class latestNews extends FormHandler
	{
		/**
		 * latestNews::populateNews()
		 * To listout the product news details
		 *
		 * @return 	array
		 * @access 	public
		 */
		 public function populateNews()
			{
				$getContents_ar = array();
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
									}
							}
					}
				return $getContents_ar;
			}
	}

//<<<<<-------------- Class editConfigData begins ---------------//
//-------------------- Code begins -------------->>>>>//
$latestNews = new latestNews();
$latestNews->setPageBlockNames(array('block_main_ionformation'));
//default form fields and values...
$latestNews->setFormField('contact_name', '');

$latestNews->setAllPageBlocksHide();
$latestNews->setPageBlockShow('block_main_ionformation'); //default page block. show it. All others hidden
$latestNews->sanitizeFormInputs($_REQUEST);
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
$latestNews->left_navigation_div = 'generalList';
if($latestNews->isShowPageBlock('block_main_ionformation'))
	{
		$latestNews->block_main_ionformation['populateNews'] = $latestNews->populateNews();
	}
//include the header file
if(!isAjaxPage())
	{
		$latestNews->includeHeader();
	}
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('latestNews.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if(!isAjaxPage())
	{
		$latestNews->includeFooter();
	}
?>