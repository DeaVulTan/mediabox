<?php
//-------------------------class TagListHandler-------------------->>>
/*
 *
 * @category	Rayzz
 * @package		Members
 * @author 		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-05-01
 */
class TagListHandler extends MediaHandler
	{
		private $showPageNavigationLinks = false;
		private $browseTitle = '';
		public $relatedTags  = array();
		public $currentPageUrl = '';

		/**
		 * TagListHandler::makeGlobalize()
		 *
		 * @param array $cfg
		 * @param array $lang
		 * @return
		 */
		public function makeGlobalize($cfg=array(), $lang=array())
			{
				parent::makeGlobalize($cfg, $lang);
				$url = getUrl('memberslist');
				$this->tagListUrl = $url;
				$this->setPageUrl($url);
			}

		/**
		 * TagListHandler::setPageUrl()
		 *
		 * @param mixed $url
		 * @return
		 */
		public function setPageUrl($url)
			{
				$this->currentPageUrl = $url;
			}

		/**
		 * TagListHandler::getPageUrl()
		 *
		 * @return
		 */
		public function getPageUrl()
			{
				return $this->currentPageUrl;
			}



		/**
		 * TagListHandler::buildSortQuery()
		 *
		 * @return void
		 */
		public function buildSortQuery()
			{
				//$this->sql_sort .= ',doj DESC ';
			}

		/**
		 * TagListHandler::membersRelRayzz()
		 *
		 * @param mixed $row
		 * @return void
		 */
		public function membersRelRayzz($row)
			{
				membersRelRayzz($row);
			}



		/**
		 * TagListHandler::getPageTitle()
		 *
		 * @return
		 */
		public function getPageTitle()
			{
				return $this->browseTitle;
			}

		/**
		 * TagListHandler::isAllowNavigationLinks()
		 *
		 * @return
		 */
		public function isAllowNavigationLinks()
			{
				return ($this->showPageNavigationLinks);
			}

		/**
		 * TagListHandler::isEmpty()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

	}
//<<<<<---------------class TagListHandler------///
//--------------------Code begins-------------->>>>>//
$tagsList = new TagListHandler();
$tagsList->setPageBlockNames(array( 'tags_list'));
// To set the DB object
$tagsList->setDBObject($db);
$tagsList->makeGlobalize($CFG, $LANG);
$tagsList->setFormField('user_id', $CFG['user']['user_id']);
$tagsList->setFormField('numpg', $CFG['admin']['members_list']['num_pg']);
$tagsList->setFormField('start', '0');
$tagsList->setMinRecordSelectLimit(2);
$tagsList->setFormField('tags', '');
$tagsList->setFormField('action', '');
$tagsList->setCountriesListArr($LANG_LIST_ARR['countries'],
									array('' => $LANG['search_country_choose'])
									);

$tagsList->showRelatedTags = false;
$validuser = true;

$tagsList->stats_display_as_text = true;
$tagsList->sanitizeFormInputs($_REQUEST);

//--------------------Page block templates begins-------------------->>>>>//
$tagsList->form_list_members['page_title']=$tagsList->getPageTitle();
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$tagsList->includeHeader();
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('searchList.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$tagsList->includeFooter();
?>
