<?php
/**
 * This file is to edit Member's Account Information
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profileSettings.php 2241 2006-08-10 04:57:26Z vijayanand39ag05 $
 * @since 		2006-04-01
 */

/**
 * To include config file
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/profileSettings.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTabText.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
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
//-------------------------class EditAccountProfileFormHandler-------------------->>>
/**
 * EditAccountProfileFormHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class EditAccountProfileFormHandler extends MediaHandler
	{
		 /**
		  * To update the form values into users table
		  *
		  * @param 		string $table_name Table name
		  * @param 		integer $user_id User id
		  * @param 		array $fields_to_update_arr Array of fields to update
		  * @return 	void
		  * @access 	public
		  */
		public function updateFormFieldsInUsersTable($table_name, $user_id, $fields_to_update_arr=array())
			{
				$sql = 'UPDATE '.$table_name.' SET ';
				foreach($fields_to_update_arr as $field_name){
					if (isset($this->fields_arr[$field_name]))
						{
							$sql .= $field_name.'='.$this->dbObj->Param($this->fields_arr[$field_name]).', ';
							$paramFields[] = $this->fields_arr[$field_name];
						}
				}
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' WHERE user_id ='.$this->dbObj->Param($user_id);
				$paramFields[] = $user_id;
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, $paramFields);
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if($this->dbObj->Affected_Rows())
					{
						$_SESSION['user']['content_filter'] = $this->fields_arr['content_filter'];
						$this->setLangCookie();
						$this->setTemplateCookie();
					}
			}

		/**
		 * Settings::getLanguage()
		 * To display the published languag
		 * @return  array language array
		 * @action public
		 */
		public function getLanguage()
			{
				if ($this->CFG['lang']['is_multi_lang_support'])
					{
						//$displayLangugeSwitcher_arr['default_language'] = $this->CFG['lang']['available_languages'][$this->CFG['lang']['default']];
						$displayLangugeSwitcher_arr['available_languages'] = array();
						foreach($this->CFG['lang']['available_languages'] as $lang_code=>$lang_name)
							{
								if($this->CFG['published_languages'][$lang_code] === 'false')
									{
										continue;
									}
								$displayLangugeSwitcher_arr['available_languages'][$lang_code] = $lang_name;
							}
						return $displayLangugeSwitcher_arr;
					}
			}

		/**
		 * Settings::setLangCookie()
		 * To set the new lang in cookie
		 * @return void
		 * @access public
		 */
		public function setLangCookie()
			{
				//set cookie and session...
				setcookie('lang', $this->fields_arr['pref_lang'], time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
				unset($_SESSION['user']['pref_lang']);
				$_SESSION['user']['pref_lang'] = $this->fields_arr['pref_lang'];
				$this->CFG['user']['pref_lang'] = $_SESSION['user']['pref_lang'];
			}

		/**
		 * Settings::setTemplateCookie()
		 * To set the new template in cookie
		 * @return void
		 * @access public
		 */
		public function setTemplateCookie()
			{
				//set cookie and session...
				if($this->fields_arr['pref_template'])
					{
						$template = explode('__', $this->fields_arr['pref_template']);
						setcookie('template', $template[0], time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
						setcookie('style', $template[1], time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
						unset($_SESSION['user']['pref_template']);
						unset($_SESSION['user']['pref_style']);
						$_SESSION['user']['pref_template'] = $template[0];
						$_SESSION['user']['pref_style'] = $template[1];
						$this->CFG['user']['pref_template'] = $template[0];
						$this->CFG['user']['pref_style'] = $template[1];
					}
			}

		/**
		 * To get the user details from the DB
		 *
		 * @param 		string $table_name table name
		 * @param 		array $fields_arr Array of fields
		 * @param 		integer $user_id user id
		 * @return 		array has array with field values
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
			{
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
					}
				$ret_fields_arr = array();
				$fields_arr = array_merge($fields_arr, $alias_fields_arr);
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				return $ret_fields_arr;
			}

		/**
		 * EditAccountProfileFormHandler::populateStatusMessages()
		 *
		 * @param string $status_table
		 * @param string $highLight
		 * @return
		 */
		public function populateStatusMessages($status_table='', $highLight='')
			{
			   	$sql = 'SELECT status_msg_id, message FROM '.$status_table.
				   		' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']).
						' ORDER BY date_added desc';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$showOption_arr = array();
			    $inc = 0;
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$selected = ($highLight==$row['status_msg_id'])?'selected="selected"':'';
								$showOption_arr[$inc]['values']=$row['status_msg_id'];
								$showOption_arr[$inc]['selected']=$selected;
								$showOption_arr[$inc]['optionvalue']=$row['message'];
								$inc++;
						    } // while
						return $showOption_arr;
				    }
				return 0;
			}

		/**
		*
		* Populates the option List
		*
		* @param array $sex_array Sex Array
		* @param string $field_name name of the radio button
		* @access public
		*
		**/
		public function showOptionButtons($list_array, $field_name)
			{
				if (empty($list_array))
				    {
				        return;
				    }
				$count = 1;
				$showOption_arr = array();
			    $inc = 0;
				foreach($list_array as $key=>$desc)
					{
						$checked = (strcmp($key, $this->fields_arr[$field_name])==0)?'checked="checked"':"";
						$field_name_id = $field_name.''.$count;$count++;
						$showOption_arr[$inc]['field_name']=$field_name;
						$showOption_arr[$inc]['checked']=$checked;
						$showOption_arr[$inc]['field_name_id']=$field_name_id;
						$showOption_arr[$inc]['values']=$key;
						$showOption_arr[$inc]['desc']=$desc;
						$inc++;
					}
				return $showOption_arr;
			}

		/**
		 * EditAccountProfileFormHandler::updateStatusMessageDetails()
		 *
		 * @param mixed $status_table
		 * @return
		 */
		public function updateStatusMessageDetails($status_table)
			{
				$return_status_id = $this->getFormField('status_msg_id_old');

				$custom_status = $this->getFormField('custom_status');

				$status = $this->getFormField('privacy');
				if (strcmp($status, 'Custom')==0 and strcmp($custom_status,'new')==0)
				    {
						$new_status = $this->getFormField('new_status_hidden');
						$new_status = str_replace('\'', '`', $new_status);
						$new_status = str_replace('"', '``', $new_status);

						$not_empty =(is_string($new_status))?($new_status!='') : (!empty($new_status));

						if ($not_empty)
						    {
								$sql = 'SELECT status_msg_id FROM '.$status_table.
										' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']).
										' AND message='.$this->dbObj->Param($new_status).' LIMIT 1';
								// prepare sql
								$stmt = $this->dbObj->Prepare($sql);
								// execute sql
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $new_status));
								//raise user error... fatal
								if (!$rs)
									trigger_db_error($this->dbObj);
								$row = array();
								if ($rs->PO_RecordCount())
									{
									 	if($row = $rs->FetchRow())
									   		$return_status_id=$row['status_msg_id'];
									}
								else
									{
										$sql = 'INSERT INTO '.$status_table.
											   ' SET user_id='.$this->dbObj->Param($this->fields_arr['user_id']).
											   ', message = '.$this->dbObj->Param($new_status).
											   ', date_added = NOW()';
										// prepare sql
										$stmt = $this->dbObj->Prepare($sql);
										// execute sql
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $new_status));
										//raise user error... fatal
										if (!$rs)
											trigger_db_error($this->dbObj);

										$return_status_id=$this->dbObj->Insert_ID();
									}
						    }
					}
				return $return_status_id;
			}
	}
//<<<<<---------------class EditAccountProfileFormHandler------///
//--------------------Code begins-------------->>>>>//
$account = new EditAccountProfileFormHandler();
$account->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'form_edit_account_profile'));
$account->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$account->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$account->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$account->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$account->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
// To set the DB object
$account->setDBObject($db);
$account->setFormField('user_id', $CFG['user']['user_id']);

$user_details_arr = $account->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
															 array('show_profile', 'icon_use_last_uploaded', 'allow_comment',
															 		'allow_bulletin', 'privacy', 'status_msg_id', 'content_filter', 'pref_lang', 'pref_template','facebook_image') );
// Set the form fields
$account->setFormField('submit', '');
$account->setFormField('show_profile', $user_details_arr['show_profile']);
$account->setFormField('icon_use_last_uploaded', $user_details_arr['icon_use_last_uploaded']);
$account->setFormField('allow_comment', $user_details_arr['allow_comment']);
$account->setFormField('allow_bulletin', $user_details_arr['allow_bulletin']);
$account->setFormField('privacy', $user_details_arr['privacy']);
$account->setFormField('status_msg_id', $user_details_arr['status_msg_id']);
$account->setFormField('status_msg_id_old', $user_details_arr['status_msg_id']);
$account->setFormField('new_status_hidden', '');
$account->setFormField('custom_status', '');
$account->setFormField('content_filter', $user_details_arr['content_filter']);
$account->setFormField('pref_lang', $user_details_arr['pref_lang']);
$account->setFormField('pref_template', $user_details_arr['pref_template']);
$account->setFormField('facebook_image', $user_details_arr['facebook_image']);

// Default page block
$account->setAllPageBlocksHide();
$account->setPageBlockShow('form_edit_account_profile');
if ($account->isFormPOSTed($_POST, 'account_submit'))
	{
		$account->sanitizeFormInputs($_POST);
        if($account->getFormField('privacy')=='Custom' && ($account->getFormField('status_msg_id_old')==0  || $account->getFormField('status_msg_id_old')=='new') && ($account->getFormField('custom_status')=='new' || $account->getFormField('custom_status')==0) && $account->getFormField('new_status_hidden')=='')
           	$account->setFormFieldErrorTip('privacy',$LANG['err_tip_select_status']);
        $account->setFormField('status_msg_id', $account->getFormField('status_msg_id_old'));

		if ($account->isValidFormInputs())
			{
				$status_msg_id = $account->updateStatusMessageDetails($CFG['db']['tbl']['users_status_messages']);
				$account->setFormField('status_msg_id', $status_msg_id);
				$account->updateFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],
					     				array('show_profile', 'icon_use_last_uploaded', 'allow_comment',
										 		'allow_bulletin', 'privacy', 'status_msg_id', 'content_filter', 'pref_lang', 'pref_template','facebook_image') );
				$account->setAllPageBlocksHide();
				$account->setPageBlockShow('form_edit_account_profile');
				$account->setPageBlockShow('block_msg_form_success');
				$account->setCommonSuccessMsg($LANG['account_profile_success_message']);
			}
		else //error in form inputs
			{
				$account->setAllPageBlocksHide();
				$account->setPageBlockShow('block_msg_form_error');
				$account->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$account->setPageBlockShow('form_edit_account_profile');
			}
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($account->isShowPageBlock('form_edit_account_profile'))
	{
		$Online = $Offline = $Custom = "";
		$privacy = $account->getFormField('privacy');
		$$privacy = 'checked="checked"';
		$account->Online=$Online;
		$account->Offline=$Offline;
		$account->Custom=$Custom;
		$account->populateStatus=$account->populateStatusMessages($CFG['db']['tbl']['users_status_messages'], $account->getFormField('status_msg_id'));
		$account->populateShowProfile=$account->showOptionButtons($LANG_LIST_ARR['show_profile'], 'show_profile');
		if (chkAllowedModule(array('photo')))
		    {
				$account->populateProfileIcon = $account->showOptionButtons($LANG_LIST_ARR['icon_use_last_uploaded'], 'icon_use_last_uploaded');
			}
		if ($account->isFacebookUser())
		    {
				$account->updateFacebook = $account->showOptionButtons($LANG_LIST_ARR['facebook_image'], 'facebook_image');
			}
		$account->populateAllowComment = $account->showOptionButtons($LANG_LIST_ARR['allow_comment'], 'allow_comment');
		if (chkAllowedModule(array('content_filter')))
		    {
				if(isAdultUser('settings'))
					{
						$account->populateContentFilter = $account->showOptionButtons(array('On'=>$LANG['on'], 'Off'=>$LANG['off']), 'content_filter');
					    $CFG['user']['content_filter'] = $account->getFormField('content_filter');
			   	   	}
			   	 else
					{
						$account->populateHidden_arr = array('content_filter');
					}
			}
	}
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$account->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('profileSettings.tpl');
?>
<script language="javascript" type="text/javascript">
	var index = document.selFormEditAccountProfile.custom_status.options.length;
	var firstSelected = document.selFormEditAccountProfile.custom_status.selectedIndex
	if($Jq('#privacyCustom').is(':checked')){
	  	$Jq('#custom_msg_select').css('display', 'block');
	}
	function addNewStatusMessage(selObj ){
		var val = selObj.value;
		var sample = '<?php echo $LANG['account_profile_javascript_new_status_sample'];?>';
		var newstatusMsg = '<?php echo $LANG['account_profile_javascript_new_status'];?>';
		var exceedsMsg = '<?php echo str_replace('VAR_MAX',20,$LANG['common_err_tip_invalid_max_character_size']);?>';
		var invalidMsg = '<?php echo $LANG['account_profile_javascript_new_status_error_message'];?>';
		document.selFormEditAccountProfile.status_msg_id_old.value = val;

		if( val.indexOf('add')==0){

			$Jq('#selPomptDialog').dialog({
				open: true,
				height: 100,
				width: 350,
				modal: true,
				buttons: {
					Cancel: function() {
						$Jq(this).dialog('close');
						document.selFormEditAccountProfile.custom_status.options[firstSelected].selected = 'selected';
						document.selFormEditAccountProfile.status_msg_id_old.value = document.selFormEditAccountProfile.custom_status.options[firstSelected].value;
					},
					'Ok': function() {
						var bValid = true;

						if(Trim(newStatus.val()) == ''){
							alert(newstatusMsg);
							bValid = false;
						}

						bValid = bValid && checkRegexp(newStatus,/^[A-Za-z0-9\s]+$/, invalidMsg);
						bValid = bValid && checkRegexp(newStatus,/^[A-Za-z0-9\s]{0,20}$/, exceedsMsg);

						if (bValid) {
							$Jq('#custom_status').append('<option value="new" selected="selected">'+newStatus.val()+'</option>');
							$Jq('#new_status_hidden').val(newStatus.val());
							document.selFormEditAccountProfile.privacy[2].checked="checked";
							$Jq(this).dialog('close');
						}
					}
				},
				close: function() {
					allFields.val('').removeClass('ui-state-error');
					if( document.selFormEditAccountProfile.custom_status.options[document.selFormEditAccountProfile.custom_status.selectedIndex].value == 'add') {
						document.selFormEditAccountProfile.custom_status.options[firstSelected].selected = 'selected';
						document.selFormEditAccountProfile.status_msg_id_old.value = document.selFormEditAccountProfile.custom_status.options[firstSelected].value;
					}
				}
			});
		}
	}

	var newStatus = $Jq("#newStatus"),
		allFields = $Jq([]).add(newStatus);

	function checkRegexp(o, regexp, err_msg) {
		if ( !( regexp.test( Trim(o.val()) ) ) ) {
			//o.addClass('ui-state-error');
			alert_manual(err_msg);
			return false;
		} else {
			return true;
		}
	}

  	function showCustomMsgSelectBox(param) {
   		document.selFormEditAccountProfile.custom_status.value=0;
   		document.selFormEditAccountProfile.new_status_hidden.value='';
   		document.selFormEditAccountProfile.status_msg_id_old.value=0;
   		var status_options =  document.selFormEditAccountProfile.custom_status.childNodes;
   		if(document.selFormEditAccountProfile.custom_status.options.length==index+1){
    		document.selFormEditAccountProfile.custom_status.removeChild(status_options[index+3]);
   		}
   		$Jq('#custom_msg_select').css('display', 'none');
   		if(param == 'Custom'){
    		$Jq('#custom_msg_select').css('display', 'block');
    	}
  	}
</script>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//$smartyObj->display('viewProfile.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if ($account->isShowPageBlock('form_edit_account_profile') and  $CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
	$Jq("#selFormEditAccountProfile").validate({
	  rules: {
	    custom_status: {
	      required: "#privacyCustom:checked"
	    }
	  },
	  messages: {
	  		custom_status: {
		    	required: "<?php echo $account->LANG['err_tip_select_status'];?>"
		    }
		}
	});
	$Jq("#privacyCustom").click(function() {
	  $Jq("#custom_status").valid();
	});

</script>
<?php
}
$account->includeFooter();
?>