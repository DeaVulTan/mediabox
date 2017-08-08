<?php
//<<<<<-------------- Class StaticPage begins ---------------//
/**
 * StaticPage
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class StaticPage extends FormHandler
	{
		/**
		 * StaticPage::populateStaticPage()
		 *
		 * @return
		 **/
		public function populateStaticPage()
			{
				$sql = 'SELECT content FROM '.$this->CFG['db']['tbl']['static_pages'].' WHERE'.
						' page_name='.$this->dbObj->Param('page_name').' AND'.
						' status=\'Activate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['pg']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
			     	return $row['content'];
			}
	}
//<<<<<-------------- Class StaticPage ends ---------------//
//-------------------- Code begins -------------->>>>>//
$StaticPage = new StaticPage();
$StaticPage->setPageBlockNames(array('block_staticPage'));
$StaticPage->setFormField('pg', '');
$StaticPage->setPageBlockShow('block_staticPage');

$StaticPage->sanitizeFormInputs($_REQUEST);
//<<<<<-------------------- Code ends----------------------//

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$StaticPage->includeHeader();
if($StaticPage->isShowPageBlock('block_staticPage'))
	{
		$smartyObj->assign('static_page_content', $StaticPage->populateStaticPage());
	}
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('staticPage.tpl');
/**
 * File to include the footer file and show benchmarking for developer
 */
$StaticPage->includeFooter();
?>