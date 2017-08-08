<?php
/**
 *  to populate question categories
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		CategoryFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-22
 * @filesource
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/boards.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='discussions';
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//FOR RAYZZ INTEGRATION
if(class_exists('DiscussionHandler'))
	{
		$discussionHandler = new DiscussionHandler();
		$smartyObj->assign_by_ref('discussion', $discussionHandler);
	}
//--------------class CategoryFormHandler--------------->>>//
class CategoryFormHandler extends FormHandler
	{
		/**
		 * CategoryFormHandler::populateSubCategories()
		 *
		 * @param mixed $cid
		 * @return
		 */
		public function populateSubCategories($cid)
		    {
				if (!$cid or $cid == 'new')
					return ;
				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].' WHERE parent_id='.$this->dbObj->Param('cid').' AND status=\'Active\'ORDER BY cat_name';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								?>
								<option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
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
				$sql = 'SELECT count(cat_id) as count FROM '.$this->CFG['db']['tbl']['category'].' WHERE parent_id='.$this->dbObj->Param('cid').' AND status=\'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
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

$categoryfrm->setFormField('cid','');
$categoryfrm->setFormField('t','');
$categoryfrm->setFormField('new','');
$categoryfrm->sanitizeFormInputs($_GET);

//<<<<--------------------Code Ends----------------------//
$cid = $categoryfrm->getFormField('cid');
$sub_cat_tab_index = $categoryfrm->getFormField('t');
$new = $categoryfrm->getFormField('new');
//--------------------Page block templates begins-------------------->>>>>//
$categoryfrm->includeAjaxHeader();
if(!$new)
	{
?>
<select name="sub_category" id="sub_category" tabIndex="<?php echo $sub_cat_tab_index;?>">
<option value=""><?php echo $LANG['discuzz_common_select_choose'];?></option>
<?php $categoryfrm->populateSubCategories($categoryfrm->getFormField('cid'));?>
</select>
<?php
	}
else
	{
?>
<select name="sub_category" id="sub_category" tabIndex="<?php echo $sub_cat_tab_index;?>">
<option value=""><?php echo $LANG['discuzz_common_select_choose'];?></option>
<?php $categoryfrm->populateSubCategories($categoryfrm->getFormField('cid'));?>
</select>
<?php
	}
$categoryfrm->includeAjaxFooter();
?>