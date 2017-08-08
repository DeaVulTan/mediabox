<?php
/**
 * This file is to Change Member's Profile Page Theme
 *
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		edwin_90ag08
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profileTheme.php 1854 2006-07-26 13:07:42Z vijayanand39ag05 $
 * @since 		2009-03-25
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'common/configs/config_members_profile.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileThemeDesign.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTabText.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class EditPasswordFormHandler-------------------->>>
/**
 * ThemeEditor
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class ThemeEditor extends FormHandler
	{
		private $fontList = array();

		public $myStyle = array();

		public $userLayout = '';

		/**
		 * ThemeEditor::setFontListArr()
		 *
		 * @param array $font
		 * @return
		 */
		public function setFontListArr($font=array())
			{
				$this->fontList = $font;
			}

		/**
		 * ThemeEditor::setMyStyle()
		 *
		 * @return
		 */
		public function setMyStyle()
			{
				$user_id = $this->CFG['user']['user_id'];
				$sql = 'SELECT style,user_style FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$style = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['style'])
							{
								$_style = unserialize($row['style']);
								if (is_array($_style) and $_style)
								    {
								        $style = $_style;
								    }
							}
						$this->userLayout = trim($row['user_style']);
					//	$rs->Free();
				    }
				$this->myStyle = $style;
			}

		/**
		 * ThemeEditor::getBlockStyles()
		 *
		 * @param string $boxId
		 * @return
		 */
		public function getBlockStyles($boxId='')
			{
				$styles = array();

				$styles['main_bg'] = '';
				$styles['main_font'] = '';
				$styles['main_color'] = '';
				$styles['header_bg'] = '';
				$styles['header_font'] = '';
				$styles['header_color'] = '';
				$boxId = $this->getFormField('box_id');
				$style = $this->myStyle;
				if (isset($style[$boxId]))
				    {
						$styles['main_bg'] = isset($style[$boxId]['background-color'])?$style[$boxId]['background-color']:'';
						$styles['main_font'] = isset($style[$boxId]['font-family'])?$style[$boxId]['font-family']:'';
						$styles['main_color'] = isset($style[$boxId]['color'])?$style[$boxId]['color']:'';
				    }
				$boxId = $boxId.'__h3';
				if (isset($style[$boxId]))
				    {
						$styles['header_bg'] = isset($style[$boxId]['background-color'])?$style[$boxId]['background-color']:'';
						$styles['header_font'] = isset($style[$boxId]['font-family'])?$style[$boxId]['font-family']:'';
						$styles['header_color'] = isset($style[$boxId]['color'])?$style[$boxId]['color']:'';
				    }
				return $styles;
			}

		/**
		 * ThemeEditor::updateUserStyle()
		 *
		 * @return
		 */
		public function updateUserStyle()
			{
				$user_id = $this->CFG['user']['user_id'];
				//$StripTags = new StripTags();
				$layout = trim($this->fields_arr['layout']);
				//$layout = $StripTags->StripTagsAndClass($layout,'textarea', $this->CFG['admin']['members_profile']['disallowed_tag'],$this->CFG['admin']['members_profile']['disallowed_empty_tag'], $this->CFG['admin']['members_profile']['disallowed_style_class'], $this->CFG['admin']['members_profile']['disallowed_attributes']);
				$layout = html_entity_decode($layout);
				$layout = str_ireplace('uppercase', 'none' , $layout);
				$layout = str_ireplace('lowercase', 'none' , $layout);
				$layout = str_ireplace('font-size', 'font' , $layout);

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$updated = false;
				if ($rs->PO_RecordCount())
					{
				     	$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_theme'].
						 		' SET user_style='.$this->dbObj->Param($layout).',style=\'\', style_tags=\'\' WHERE user_id='.$this->dbObj->Param($user_id);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($layout, $user_id));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$updated = ( $this->dbObj->Affected_Rows()>0 );
		  		    }
				else
					{
				     	$sql = 'INSERT INTO  '.$this->CFG['db']['tbl']['users_profile_theme'].
						 		' SET user_style='.$this->dbObj->Param($layout).', user_id='.$this->dbObj->Param($user_id);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($layout, $user_id));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
						$updated = true;
					}
				return $updated;
			}

		/**
		 * ThemeEditor::setUserLayout()
		 *
		 * @return
		 */
		public function setUserLayout()
			{
				$this->setFormField('layout', $this->userLayout);
			}
	}
//<<<<<---------------class ThemeEditor------///
//--------------------Code begins-------------->>>>>//
$theme = new ThemeEditor();
$theme->setDBObject($db);
$theme->makeGlobalize($CFG, $LANG);

if(!chkAllowedModule(array('customize_profile')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$theme->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'msg_form_info', 'form_add_layout'));
$theme->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$theme->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$theme->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$theme->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$theme->setCSSFormFieldCellErrorClass('clsFormFieldCellError');

$theme->setFontListArr($LANG_LIST_ARR['profile_design_fonts']);
$theme->setMyStyle();

$theme->setFormField('user_id', $CFG['user']['user_id']);
$theme->setFormField('username', $CFG['user']['user_name']);
$theme->setFormField('block', 'videos');
$theme->setFormField('box_id', 'unknown');
$theme->setFormField('main_bg', '');
$theme->setFormField('main_font', '');
$theme->setFormField('main_color', '');
$theme->setFormField('header_bg', '');
$theme->setFormField('header_font', '');
$theme->setFormField('header_color', '');
$theme->setFormField('layout', '');

// Default page block
$theme->setAllPageBlocksHide();
$theme->setPageBlockShow('form_add_layout');
$theme->setMyStyle();
$theme->setUserLayout();
if ($theme->isFormPOSTed($_POST, 'cancel_layout'))
	{
		Redirect2URL(getUrl('myprofile'));
	}
else if ($theme->isFormPOSTed($_POST, 'layout'))
    {
		$theme->sanitizeFormInputs($_POST);
		if ($theme->isFormPOSTed($_POST, 'save_layout'))
		    {
				$updated = $theme->updateUserStyle();
				if ($updated)
				    {
						$theme->setPageBlockShow('block_msg_form_success');
						$theme->setCommonSuccessMsg($LANG['profile_theme_success_message']);
				    }
				else
					{
						$theme->setPageBlockShow('block_msg_form_error');
						$theme->setCommonErrorMsg($LANG['profile_theme_no_change']);
					}
		    }
		if ($theme->isFormPOSTed($_POST, 'reset_layout'))
		    {
		       	$theme->setFormField('layout', '');
		       	$updated = $theme->updateUserStyle();
				if ($updated)
				    {
						$theme->setPageBlockShow('block_msg_form_success');
						$theme->setCommonSuccessMsg($LANG['profile_theme_reset_success_message']);
				    }
				else
					{
						$theme->setPageBlockShow('block_msg_form_error');
						$theme->setCommonErrorMsg($LANG['profile_theme_no_change']);
					}
		    }
    }
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($theme->isShowPageBlock('form_add_layout'))
    {
    	$theme->MemberProfileUrl=getMemberProfileUrl($CFG['user']['user_id'], $CFG['user']['user_name'], 'layout_submit_preview=true');
    	$theme->poulatehidden_arr=array('block');
    }
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$theme->includeHeader();
?>
<script language="javascript">
	function popupWindow(url){
		 window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
		 return false;
	}
</script>
<?php
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profileThemeDesign.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$theme->includeFooter();
?>