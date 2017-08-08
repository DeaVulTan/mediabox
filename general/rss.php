<?php
/**
 * File to handle the rss video
 *
 * @category	Rayzz
 * @package		general
 */
class Rss extends FormHandler
	{
		/**
		 * Rss::getRssUrl()
		 *
		 * @param $page
		 * @return string
		 * @access pubo
		 **/
		public function getRssUrl($page)
			{
				//return $this->CFG['site']['url'].'rss/'.$page.'.rss';
				return getUrl('rssfeedvideo', '?pg='.$page, $page.'/', 'root', 'video');
			}

		/**
		 * Rss::getYahooLink()
		 *
		 * @param $page
		 * @return string
		 * @access public
		 **/
		public function getYahooLink($page)
			{
				$title = $this->CFG['site']['title'].' '.$this->LANG[$page];
				$return = 'http://us.rd.yahoo.com/my/atm/';
				$return .= $this->CFG['site']['title'].'/'.$title.'/*http://add.my.yahoo.com/rss?url=';
				$return .= $this->getRssUrl($page);
				return $return;
			}

		/**
		 * Rss::getGoogleLink()
		 * To get the google rss url
		 * @param $page
		 * @return string
		 * @access public
		 **/
		public function getGoogleLink($page)
			{
				$return = 'http://fusion.google.com/add?feedurl=';
				$return .= $this->getRssUrl($page);
				return $return;
			}

		/**
		 * Rss::getItunesLink()
		 * To get the itunes rss url
		 * @param $page
		 * @return string
		 * @access public
		 **/
		public function getItunesLink($page)
			{
				//$return = 'itpc://www.cisco.com/cdc_content_elements/rss/podcast/add?feedurl=';
				$return = $this->getItunesUrl($page);
				return $return;
			}

		/**
		 * Rss::getItunesUrl()
		 *
		 * @param $page
		 * @return string
		 * @access public
		 **/
		public function getItunesUrl($page)
			{
				return $this->CFG['site']['itunes']['url'].'video/rss/itunesFeed.php?pg='.$page;
			}
	}
//<<<<<-------------- Class Rss begins ---------------//
//-------------------- Code begins -------------->>>>>//
$Rss = new Rss();
$Rss->setDBObject($db);
$Rss->makeGlobalize($CFG,$LANG);
$Rss->setPageBlockNames(array('rssListBlock'));
$Rss->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$Rss->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$Rss->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$Rss->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$Rss->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$Rss->setAllPageBlocksHide();
$Rss->setPageBlockShow('rssListBlock');

$Rss->sanitizeFormInputs($_REQUEST);
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$Rss->includeHeader();
setTemplateFolder('general/');
$smartyObj->display('rss.tpl');
$Rss->includeFooter();
?>