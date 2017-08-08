<?php
/**
 * This file is to Change Member's Profile Page Theme
 *
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profileTheme.php 1868 2006-07-27 09:30:22Z vijayanand39ag05 $
 * @since 		2006-04-01
 */

/**
 * To include config file
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTheme.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTabText.php';
$CFG['lang']['include_files'][] = 'common/configs/config_members_profile.inc.php';
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
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
/*
 * @category	Rayzz
 * @package		EditPasswordFormHandler
 * @author 		manonmani_51ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2005-10-08
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
		 * ThemeEditor::populateFontListArray()
		 *
		 * @param string $highLight
		 * @return
		 */
		public function populateFontListArray($highLight='')
			{
			   $showOption_arr = array();
			   $inc = 0;
				if ($this->fontList)
				    {
				        foreach($this->fontList as $key=>$value)
							{
								$selected = (strcmp($key, $highLight)==0)?'SELECTED':'';
								$showOption_arr[$inc]['values']=$key;
								$showOption_arr[$inc]['selected']=$selected;
								$showOption_arr[$inc]['optionvalue']=$value;
								$inc++;
							}
						return $showOption_arr;
				    }
				else
				   	 return 0;
			}

		/**
		 * ThemeEditor::setMyStyle()
		 *
		 * @return
		 */
		public function setMyStyle()
			{
				$sql = 'SELECT style, user_style FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);

				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
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
				    }
				$this->myStyle = $style;
			}

		/**
		 * ThemeEditor::getMyStyle()
		 *
		 * @return
		 */
		public function getMyStyle()
			{
				return $this->myStyle;
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
				$box_td = $boxId.'__TD';
				if (isset($style[$box_td]))
				    {
						$styles['main_bg'] = isset($style[$box_td]['background-color'])?$style[$box_td]['background-color']:'';
						$styles['main_font'] = isset($style[$box_td]['font-family'])?$style[$box_td]['font-family']:'';
						$styles['main_color'] = isset($style[$box_td]['color'])?$style[$box_td]['color']:'#000000';
				    }
				else
					{
						$styles['main_color'] = '#000000';
					}
				$boxId = $boxId.'__th';
				if (isset($style[$boxId]))
				    {
						$styles['header_bg'] = isset($style[$boxId]['background-color'])?$style[$boxId]['background-color']:'#252525';
						$styles['header_font'] = isset($style[$boxId]['font-family'])?$style[$boxId]['font-family']:'';
						$styles['header_color'] = isset($style[$boxId]['color'])?$style[$boxId]['color']:'';
				    }
				else
					{
						$styles['header_bg'] = '#252525';
					}
				return $styles;
			}

		/**
		 * ThemeEditor::updateStyles()
		 *
		 * @return
		 */
		public function updateStyles()
			{
				$box = $this->fields_arr['box_id'];
				$header = $box.'__th';
				$box_td = $box.'__TD';
				$newStyle = array();
				$newStyle[$box_td]['background-color'] = $this->fields_arr['main_bg'];
				$newStyle[$box_td]['color'] = $this->fields_arr['main_color'];
				$newStyle[$box_td]['font-family'] = $this->fields_arr['main_font'];
				$newStyle[$header]['background-color'] = $this->fields_arr['header_bg'];
				$newStyle[$header]['color'] = $this->fields_arr['header_color'];
				$newStyle[$header]['font-family'] = $this->fields_arr['header_font'];
				$newStyle = array_merge($this->myStyle, $newStyle);
				$tag = '';/*
				ob_start();
					foreach($newStyle as $id=>$attr){
						$id = str_replace('__', ' ', $id);
						echo 'div#main #'.$id.'{';
						if($attr and is_array($attr)){
							foreach($attr as $st=>$val){
							echo "\n";
							echo $st.':'.$val.';';
							echo "\n";
							}
						}
						echo '}';
				echo "\n";*/
				$tag = '';
				foreach($newStyle as $id=>$attr){
					$id = str_replace('__', ' ', $id);
					$tag .= '.'.$id.'{';
					if($attr){
						foreach($attr as $st=>$val){
							$tag .= "\n";
							$tag .= $st.':'.$val.';';
							$tag .= "\n";
						}
					}
					$tag .= '}';
				$tag .= "\n";
				}
				//$tag = ob_get_contents();ob_clean();
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).' LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				$updated = false;
				$sql_style = serialize($newStyle);
				$sql_tag = urlencode($tag);
				$sql_user = $this->CFG['user']['user_id'];

				if ($rs->PO_RecordCount())
					{
				    	$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_theme'].
								' SET style='.$this->dbObj->Param($sql_style).', style_tags='.$this->dbObj->Param($sql_tag).
								' WHERE user_id='.$this->dbObj->Param($sql_user);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($sql_style, $sql_tag, $sql_user));
						//raise user error... fatal
						if (!$rs)
							trigger_db_error($this->dbObj);
						$updated = ( $this->dbObj->Affected_Rows()>0 );
			  		}
				else
					{
				     	$sql = 'INSERT INTO  '.$this->CFG['db']['tbl']['users_profile_theme'].
						 		' SET style='.$this->dbObj->Param($sql_style).
								 ', style_tags='.$this->dbObj->Param($sql_tag).
								 ', user_id='.$this->dbObj->Param($sql_user);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($sql_style, $sql_tag, $sql_user));
						//raise user error... fatal
						if (!$rs)
							trigger_db_error($this->dbObj);
						$updated = true;
					}
				return $updated;
			}

		/**
		 * ThemeEditor::updateUserStyle()
		 *
		 * @return
		 */
		public function updateUserStyle()
			{
				//$StripTags = new StripTags();
				$layout = trim($this->fields_arr['layout']);
				//$layout = $StripTags->StripTagsAndClass($layout,'textarea', $this->CFG['admin']['members_profile']['disallowed_tag'],$this->CFG['admin']['members_profile']['disallowed_empty_tag'], $this->CFG['admin']['members_profile']['disallowed_style_class'], $this->CFG['admin']['members_profile']['disallowed_attributes']);
				$layout = html_entity_decode($layout);
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->CFG['user']['user_id'].' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$updated = false;
				if ($rs->PO_RecordCount())
				    {
				     	$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_theme'].
						 		' SET user_style=\''.addslashes($layout).'\',style=\'\', style_tags=\'\' WHERE user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$updated = ( $this->dbObj->Affected_Rows() > 0 );
		  		    }
				else
					{
				     	$sql = 'INSERT INTO  '.$this->CFG['db']['tbl']['users_profile_theme'].
						 		' SET user_style=\''.addslashes($layout).'\', user_id='.$this->CFG['user']['user_id'];

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$updated = ( $this->dbObj->Affected_Rows() > 0 );
					}
				return $updated;
			}

		/**
		 * ThemeEditor::getProfileCategoryName()
		 *
		 * @return
		 */
		public function getProfileCategoryName($block_name)
			 {
			 	$sql = 'SELECT title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
				 		' AS pc, '.$this->CFG['db']['tbl']['profile_block'].' AS pb
						  WHERE pc.id = pb.profile_category_id AND pb.block_name = '.$this->dbObj->Param('title');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($block_name));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			 	if($row = $rs->FetchRow())
					return $form_id = $row['title'];
				return $block_name;
			 }
	}
//<<<<<---------------class ThemeEditor------///
//--------------------Code begins-------------->>>>>//
$theme = new ThemeEditor();
$theme->setDBObject($db);
$theme->makeGlobalize($CFG, $LANG);

if(!chkAllowedModule(array('customize_profile')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$theme->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'form_basic_blocks_handling', 'form_add_layout'));
$theme->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$theme->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$theme->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$theme->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$theme->setCSSFormFieldCellErrorClass('clsFormFieldCellError');

$theme->setFontListArr($LANG_LIST_ARR['profile_design_fonts']);
$theme->setMyStyle();

$theme->profileBlocks_arr =  $theme->getProfileBlocks();

$theme->setFormField('user_id', $CFG['user']['user_id']);
$theme->setFormField('username', $CFG['user']['user_name']);
$theme->setFormField('block', 'myscraps');
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

if ($theme->isFormPOSTed($_POST, 'theme_submit'))
	{
		$theme->sanitizeFormInputs($_POST);
		$theme->setAllPageBlocksHide();
		$updated = $theme->updateStyles();
		if ($updated)
		    {
				$theme->setMyStyle();
				$theme->setPageBlockShow('block_msg_form_success');
				$theme->setCommonSuccessMsg($LANG['profile_theme_success_message']);
		    }
		$theme->setPageBlockShow('form_basic_blocks_handling');
	}

if ($theme->isFormPOSTed($_POST, 'layout_submit'))
    {
        $theme->sanitizeFormInputs($_POST);
		$updated = $theme->updateUserStyle();
		$theme->setAllPageBlocksHide();
		if ($updated)
		    {
				$theme->setMyStyle();
				$theme->setPageBlockShow('block_msg_form_success');
				$theme->setCommonSuccessMsg($LANG['profile_theme_success_message']);
		    }
		$theme->setPageBlockShow('form_add_layout');
    }

if ($theme->isPageGETed($_GET, 'block'))
    {
        $theme->sanitizeFormInputs($_GET);
    }
!in_array($theme->getFormField('block'), $theme->profileBlocks_arr['block_name'])?$theme->setFormField('block', 'myscraps'):'';
$block = $theme->getFormField('block');
$LANG['block_title'] = '';

if(in_array($block, $theme->profileBlocks_arr['block_name']))
	{
        $theme->setPageBlockShow('form_basic_blocks_handling');
		$theme->setFormField('box_id', isset($CFG['profile_box_id'][$block])?$CFG['profile_box_id'][$block]:'cls'.ucfirst($block).'Table');
		$LANG['block_title'] = isset($LANG[$block.'_box_design'])?$LANG[$block.'_box_design']:str_replace('VAR_BLOCK_NAME',$theme->getProfileCategoryName($block),$LANG['profile_theme_box_design']);
	}

$style = $theme->getMyStyle();
$boxId = $theme->getFormField('box_id');

$blockStyles = $theme->getBlockStyles($boxId);
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
$block = $theme->getFormField('block');
if($block and ctype_alpha($block))
	{
		$$block = 'clsActivePhotoSubLink';
	}
if ($theme->isShowPageBlock('form_basic_blocks_handling'))
	{
		$theme->block_title=$LANG['block_title'];
		$theme->form_basic_blocks_handling['main_bg']=$blockStyles['main_bg'];
		$theme->form_basic_blocks_handling['main_color']=$blockStyles['main_color'];
		$theme->form_basic_blocks_handling['header_bg']= $blockStyles['header_bg'];
		$theme->form_basic_blocks_handling['header_color']= $blockStyles['header_color'];
		$theme->form_basic_blocks_handling['main_font_arr']= $theme->populateFontListArray($blockStyles['main_font']);
		$theme->form_basic_blocks_handling['header_font_arr']= $theme->populateFontListArray($blockStyles['header_font']);
		$theme->form_basic_blocks_handling['main_font_arr']= $theme->populateFontListArray($blockStyles['main_font']);
		$theme->formAction = getUrl('profiletheme','?block='.$theme->getFormField('block'),'?block='.$theme->getFormField('block'));
		$theme->form_basic_blocks_handling['hidden_arr'] = array('box_id', 'block');
	}
if ($theme->isShowPageBlock('form_add_layout'))
	{
	  	$theme->form_add_layout['hidden_arr'] = array('block');
	}
$theme->includeHeader();
?>
<link rel="stylesheet" id="personalStyleLink" type="text/css" href="<?php echo $CFG['site']['url'];?>profileCss.php?user_id=<?php echo $CFG['user']['user_id'];?>&amp;d=<?php echo date('dmyhis');?>" />
<?php

//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profileTheme.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$theme->includeFooter();
?>