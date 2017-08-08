<?php
/**
 *  This class is used to edit forum messages
 *
 *
 * @category	Rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/articleWriting.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class CategoryFormHandler--------------->>>//
class CategoryFormHandler extends FormHandler
	{
		/**
		 * CategoryFormHandler::populateSubCategories()
		 *
		 * @param mixed $cid
		 * @return
		 */
		public function populateSubCategories($category_id)
		    {
				if (!$category_id)
					return ;
				$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].' WHERE parent_category_id='.$this->dbObj->Param('category_id').' AND article_category_status=\'Yes\' ORDER BY article_category_name';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								?>
								<option value="<?php echo $row['article_category_id'];?>"><?php echo $row['article_category_name'];?></option>
								<?php
							} // while
					}
		    }

		/**
		 * CategoryFormHandler::populateSubCategoriesCount()
		 *
		 * @param mixed $cid
		 * @return
		 */
		public function populateSubCategoriesCount($cid)
		    {
				if (!$cid or $cid == 'new')
					return ;
				$sql = 'SELECT count(cat_id) as count FROM '.$this->CFG['db']['tbl']['questions_category'].' WHERE parent_id='.$this->dbObj->Param('cid').' AND status=\'1\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['count'];
					}
				else
					{
						return 0;
					}
		    }
	}
//<<<<<<<--------------class CategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$categoryfrm = new CategoryFormHandler();

$categoryfrm->setPageBlockNames();

$categoryfrm->setFormField('category_id','');
$categoryfrm->setFormField('t','');
$categoryfrm->setFormField('new','');
$categoryfrm->sanitizeFormInputs($_GET);

//<<<<--------------------Code Ends----------------------//
$cid = $categoryfrm->getFormField('category_id');
$sub_cat_tab_index = $categoryfrm->getFormField('t');
$new = $categoryfrm->getFormField('new');
//--------------------Page block templates begins-------------------->>>>>//
$categoryfrm->includeAjaxHeader();
?>
<select name="article_sub_category_id" id="article_sub_category_id" tabIndex="<?php echo $sub_cat_tab_index;?>">
<option value=""><?php echo $LANG['articlewriting_select_sub_category'];?></option>
<?php $categoryfrm->populateSubCategories($categoryfrm->getFormField('category_id'));?>
</select>
<?php

$categoryfrm->includeAjaxFooter();
?>