<?php
//----------------------------- Class NewsFormHandler begins ---------------------->>>>>//
/**
 * NewsFormHandler
 * News form handler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class NewsFormHandler extends FormHandler
 	{
		/**
		 * Checks whether the value from array
		 *
		 * @param		string $arr array array of news
		 * @param		array $field_name value the news id
		 * @param		string $err_tip error tips
		 * @return		void
		 * @access		public
		 **/
		public function chkNewsExist($arr, $field_name, $err_tip='')
			{
				$is_ok = isset($arr[$this->fields_arr[$field_name]]);
				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $err_tip);
					}
				return $is_ok;
			}
	}
//<<<<<-------------- Class NewsFormHandler ends ---------------//
//-------------------- Code begins ------------->>>>>//
$newsfrm = new NewsFormHandler();
$newsfrm->setPageBlockNames(array('block_news_index', 'block_detail_news'));
$newsfrm->setFormField('news_id', '');
$newsfrm->setAllPageBlocksHide();
$newsfrm->setPageBlockShow('block_news_index');
//check for show a news in separate page
if ($newsfrm->isFormGETed($_GET, 'news_id'))
	{
		$newsfrm->sanitizeFormInputs($_GET);
		$newsfrm->chkIsNotEmpty('news_id', $newsfrm->LANG['common_err_tip_compulsory']);
		//checks whether the news id exist
		$newsfrm->chkNewsExist($LANG_LIST_ARR['news'], 'news_id', $newsfrm->LANG['common_err_tip_compulsory']);
		if ($newsfrm->isValidFormInputs())
			{
				$newsfrm->setAllPageBlocksHide();
				$newsfrm->setPageBlockShow('block_detail_news');
			}
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($newsfrm->isShowPageBlock('block_news_index'))
	{
		foreach($LANG_LIST_ARR['news'] as $key=>$value)
			{
				 $LANG_LIST_ARR['news'][$key]['subject_more'] = false;
				 if (strlen($LANG_LIST_ARR['news'][$key]['subject']) > 150)
				 	{
						$LANG_LIST_ARR['news'][$key]['subject'] = substr($LANG_LIST_ARR['news'][$key]['subject'], 0, 150);
						$LANG_LIST_ARR['news'][$key]['subject_more'] = true;
					}
			}
	}
if ($newsfrm->isShowPageBlock('block_detail_news'))
    {
		$smartyObj->assign('news_id', $newsfrm->getFormField('news_id'));
	}
$smartyObj->assign('LANG_LIST_ARR', $LANG_LIST_ARR);
//include the header file
$newsfrm->includeHeader();
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('news.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$newsfrm->includeFooter();
?>