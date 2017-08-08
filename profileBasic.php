<?php
/**
 * This file is to edit Member's Personal Information
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profilePersonal.php 1157 2006-06-09 07:16:00Z vijayanand39ag05 $
 * @since 		2006-04-01
 */
/**
 * To include config file
 */
require_once('./common/configs/config.inc.php'); //configurations
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileBasic.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/profileTabText.php';
$CFG['mods']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_inputfilter_clean.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ProfileHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_inputfilter_clean.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
//To load Calendar related JS files
$CFG['admin']['calendar_page'] = true;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class EditPersonalProfileFormHandler-------------------->>>
/**
 * EditPersonalProfileFormHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class EditPersonalProfileFormHandler extends ProfileHandler
	{
		/**
		 * EditPersonalProfileFormHandler::updateUserSessionVars()
		 *
		 * @return
		 */
		public function updateUserSessionVars()
			{
				$_SESSION['user']['name'] = $this->fields_arr['user_session_name'];
				$_SESSION['user']['email'] = $this->fields_arr['email'];

				if(chkAllowedModule(array('content_filter')))
					$_SESSION['user']['adult'] = chkIsAdultUser($this->fields_arr['dob']);
				else
					$_SESSION['user']['adult'] = true;
			}

		/**
		 * EditPersonalProfileFormHandler::updateUsersAgeValue()
		 *
		 * @param string $user_table
		 * @return
		 */
		public function updateUsersAgeValue($user_table='')
			{
				$sql = 'UPDATE '.$user_table.
						' SET age = DATE_FORMAT(NOW(), \'%Y\') - DATE_FORMAT(dob, \'%Y\') - (DATE_FORMAT(NOW(), \'00-%m-%d\') < DATE_FORMAT(dob, \'00-%m-%d\'))'.
						' WHERE user_id='.$this->dbObj->Param($this->fields_arr['user_id']);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * EditPersonalProfileFormHandler::saveHtmlCodes()
		 *
		 * @param array $fields
		 * @return
		 */
		public function saveHtmlCodes($fields = array())
			{
				if ($fields)
				    {
				        foreach($fields as $key=>$field_name)
							{
								if (isset($this->fields_arr[$field_name]))
								    {
								        $this->fields_arr[$field_name] = html_entity_decode($this->fields_arr[$field_name]);
									}
							}
				    }
			}

		/**
		* EditPersonalProfileFormHandler::displayMandatoryIcon()
		* Displays manadatory icon for required fields
		*
		* @param  string $field_name
		* @access public
		*
		**/
		public function displayMandatoryIcon($field_name='')
			{
				$mandatoryFields = array('email', 'first_name', 'last_name', 'sex', 'country', 'dob', 'pin_code', 'postal_code');
				if($field_name == '*' OR (in_array($field_name, $mandatoryFields)))
					{
						$this->displayCompulsoryIcon();
					}
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateAjaxFormFieldsInUsersTable($table_name, $user_id, $field_name, $field_value)
			{
				$sql = 'UPDATE '.$table_name.
						' SET '.$field_name.'='.$this->dbObj->Param('field_value').
						' WHERE user_id ='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($field_value, $user_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			}
	}
//<<<<<---------------class EditPersonalProfileFormHandler------///
//--------------------Code begins-------------->>>>>//
$LANG['personal_profile_dob'] = str_replace('VAR_DOB_FORMAT', 'yyyy-mm-dd', $LANG['personal_profile_dob']);
$LANG['help']['first_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['first_name']['min'], $LANG['help']['first_name']);
$LANG['help']['first_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['first_name']['max'], $LANG['help']['first_name']);
$LANG['help']['last_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['last_name']['min'], $LANG['help']['last_name']);
$LANG['help']['last_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['last_name']['max'], $LANG['help']['last_name']);
$LANG['personal_profile_submit'] = str_replace('VAR_SITE_NAME', $CFG['site']['name'], $LANG['personal_profile_submit']);

$personal = new EditPersonalProfileFormHandler();
$personal->makeGlobalize($CFG,$LANG);
$personal->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'form_editprofile'));
$personal->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$personal->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$personal->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$personal->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
// To set the DB object
$personal->setDBObject($db);
$personal->setFormField('user_id', $CFG['user']['user_id']);
$personal->setFormField('username', $CFG['user']['user_name']);
$personal->setFormField('user_session_name', '');
$user_details_arr = $personal->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
															 array(	'user_name','email','first_name', 'last_name', 'dob', 'show_dob' , 'sex',  'relation_status', 'about_me', 'web_url' ,
															 		'hometown', 'city', 'postal_code', 'country', 'profile_tags'));
// Set the form fields
$personal->setFormField('user_name', $user_details_arr['user_name']);
$personal->setFormField('email', $user_details_arr['email']);
$personal->setFormField('sex', $user_details_arr['sex']);
$personal->setFormField('dob', $user_details_arr['dob']);
$personal->setFormField('show_dob', $user_details_arr['show_dob']);
$personal->setFormField('first_name', $user_details_arr['first_name']);
$personal->setFormField('last_name', $user_details_arr['last_name']);
$personal->setFormField('relation_status', $user_details_arr['relation_status']);
$personal->setFormField('about_me', $user_details_arr['about_me']);
$personal->setFormField('web_url', $user_details_arr['web_url']);
$personal->setFormField('profile_tags', $user_details_arr['profile_tags']);

$personal->setFormField('hometown', $user_details_arr['hometown']);
$personal->setFormField('city', $user_details_arr['city']);
$personal->setFormField('postal_code', $user_details_arr['postal_code']);
$personal->setFormField('country', $user_details_arr['country']);
$personal->setFormField('user_image', '');
//added form fields for jEditable ..
$personal->setFormField('infotype', '');
$personal->setFormField('infovalue', '');
$LANG['personal_profile_tags_info_2'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['profile_tag']['min'], $LANG['personal_profile_tags_info_2']);
$LANG['personal_profile_tags_info_2'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['profile_tag']['max'], $LANG['personal_profile_tags_info_2']);
$personal->profile_tag_length_info=$LANG['personal_profile_tags_info_2'];

$personal->setCountriesListArr($LANG_LIST_ARR['countries'],
							array('' => $LANG['personal_profile_choose'])
							);

$personal->setMonthsListArr($LANG_LIST_ARR['months']);
$profile_image_max_size = ($CFG['admin']['members_profile']['profile_image_max_size'] * 1024);

// Default page block
$personal->setAllPageBlocksHide();
$personal->sanitizeFormInputs($_POST);
$personal->setPageBlockShow('form_editprofile');
//added for jEditable in profile page ...
if ($personal->isFormPOSTed($_POST, 'updateprofile') AND isAjax())
	{
		$personal->sanitizeFormInputs($_POST);
		switch($personal->getFormField('infotype'))
			{
				case 'aboutme':
					// create the new InputFilter instance
					$filter = new InputFilter($CFG['fckeditor']['allowed_tags'], $CFG['fckeditor']['allowed_attr']);
					// use the new filter to process the string
					$_POST['infovalue'] = ($filter->process($_POST['infovalue']));
					//convert HTML tags
					$personal->saveHtmlCodes(array('infovalue'));
					//Update about in users table
					$personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'], 'about_me', $personal->getFormField('infovalue'));;
					if ($personal->getFormField('infovalue') == '')
						$return_value =  $LANG['commmon_tell_about_yourself'];
					else
						$return_value = $personal->getFormField('infovalue');
					break;

				case 'myweburl':
						if($personal->getFormField('infovalue') != '' AND (!$personal->chkIsValidURLRevised('infovalue')))
							{
								$return_value =  $personal->content_separator.'error'.$personal->content_separator.$LANG['personal_profile_err_tip_invalid_url'];
							}
						else
							{
								$updated = $personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],'web_url', $personal->getFormField('infovalue'));
								$return_value = $personal->getFormField('infovalue');
								if ($personal->getFormField('infovalue') == '')
									$return_value =  $LANG['edit_in_place_no_web_url'];
							}
						break;
				case 'birthday':
						if($personal->getFormField('infovalue') != '' AND (!$personal->chkIsValidDate('infovalue')))
							{
								$return_value =  $personal->content_separator.'error'.$personal->content_separator.$LANG['common_err_tip_date_invalid'];
							}
						else
							{
								if($personal->chkIsCorrectDateSignup($personal->getFormField('infovalue'), 'infovalue'))
									{
										$updated = $personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],'dob', $personal->getFormField('infovalue'));
										$dob_arr = explode('-', $personal->getFormField('infovalue'));
										//date is in yyyy-mm-dd format
										$formated_date = date('M d', mktime(0, 0, 0, $dob_arr[1], $dob_arr[2], $dob_arr[0]));
										$return_value = $formated_date.$personal->content_separator.$personal->getFormField('infovalue');
									}
								else
									{
										$return_value =  $personal->content_separator.'error'.$personal->content_separator.$LANG['common_err_tip_date_invalid'];
									}
							}
						break;
				case 'gender':
								$updated = $personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],'sex', $personal->getFormField('infovalue'));
								$return_value = $LANG_LIST_ARR['gender'][$personal->getFormField('infovalue')].$personal->content_separator.$personal->getFormField('infovalue');
						break;
				case 'country':
								if($personal->getFormField('infovalue') == '' AND (!$personal->chkIsNotEmpty('infovalue', $LANG['common_err_tip_compulsory'])))
								{
									$return_value =  $personal->content_separator.'error'.$personal->content_separator.$LANG['common_err_tip_country'];
								}
								else
								{
									$updated = $personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],'country', $personal->getFormField('infovalue'));
									$return_value = $LANG_LIST_ARR['countries'][$personal->getFormField('infovalue')].$personal->content_separator.$personal->getFormField('infovalue');
								}

						break;
				case 'relation':
								$updated = $personal->updateAjaxFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],'relation_status', $personal->getFormField('infovalue'));
								$return_value = $LANG_LIST_ARR['user_relation_status'][$personal->getFormField('infovalue')].$personal->content_separator.$personal->getFormField('infovalue');
						break;
			}
		$personal->includeAjaxHeader();
		echo $return_value;
		ob_end_flush();
		die();
		break;
	}
if ($personal->isFormPOSTed($_POST, 'editprofile_submit'))
	{
		if(isAdmin() and $CFG['admin']['is_demo_site'])
			{
				$personal->setAllPageBlocksHide();
				$personal->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
				$personal->setPageBlockShow('block_msg_form_error');
				$personal->setPageBlockShow('form_editprofile');
			}
		else
			{
				// Validations
				$personal->chkIsNotEmpty('email', $LANG['common_err_tip_compulsory']) and
					$personal->chkIsValidEmail('email', $LANG['common_err_tip_email']) and
						$personal->chkIsNotEditDuplicateEmail($CFG['db']['tbl']['users'], 'email', $CFG['user']['user_id'], $LANG['personal_profile_err_tip_email_already_exists']);
				$personal->chkIsNotEmpty('first_name', $LANG['common_err_tip_compulsory']) and
				$personal->chkIsValidSize('first_name', 'first_name', $LANG['common_err_tip_invalid_size']);
				$personal->chkIsNotEmpty('last_name', $LANG['common_err_tip_compulsory']) and
				$personal->chkIsValidSize('last_name', 'first_name', $LANG['common_err_tip_invalid_size']);
				$personal->chkIsNotEmpty('dob', $LANG['common_err_tip_required']) ;
				if($personal->chkIsValidDate('dob',$LANG['common_err_tip_date_invalid']))
					{
						// check age limit......
						$personal->chkIsCorrectDateSignup($personal->getFormField('dob'), 'dob', $LANG['common_err_tip_date_invalid'], $LANG['common_err_tip_date_invalid']);
					}
				if($personal->getFormField('web_url')!='')
				   	$personal->chkIsValidURLRevised('web_url',$LANG['personal_profile_err_tip_invalid_url']);

				if($personal->getFormField('profile_tags'))
		    		$personal->chkValidTagList('profile_tags','profile_tag',$LANG['common_err_tip_invalid_tag']);

				$personal->chkIsNotEmpty('country', $LANG['common_err_tip_compulsory']);
				$personal->chkIsNotEmpty('postal_code', $LANG['common_err_tip_compulsory']);

				$personal->show_dob_value=0;
				if(isset($_POST['show_dob_check']))
				   	$personal->show_dob_value=1;

				if ($personal->isValidFormInputs())
					{
						// create the new InputFilter instance
						$filter = new InputFilter($CFG['fckeditor']['allowed_tags'], $CFG['fckeditor']['allowed_attr']);
						// use the new filter to process the string
						$_POST['about_me'] = ($filter->process($_POST['about_me']));

						$personal->setFormField('user_session_name', getUserDetail('user_name', $CFG['user']['user_name'], 'display_name'));
						//$personal->setFormField('about_me', html_entity_decode($personal->getFormField('about_me')));
						$personal->saveHtmlCodes(array('about_me', 'web_url'));
						$updated = $personal->updateFormFieldsInUsersTable($CFG['db']['tbl']['users'], $CFG['user']['user_id'],
							     				 array('first_name', 'last_name', 'dob', 'show_dob','sex', 'relation_status', 'about_me', 'web_url', 'email',
												 'hometown', 'city', 'postal_code', 'country', 'profile_tags')
												 );

						if ($updated)
						    {
						        $personal->updateUsersAgeValue( $CFG['db']['tbl']['users'] );
								$personal->updateUserSessionVars();

								$user_details_arr = $personal->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
																							 array(	'email','first_name', 'last_name', 'dob', 'show_dob' , 'sex',  'relation_status', 'about_me', 'web_url' ,
																							 		'hometown', 'city', 'postal_code', 'country'));
								$personal->profile_updated=false;

						    }
						$personal->setAllPageBlocksHide();
						$personal->setPageBlockShow('form_editprofile');
						$personal->setPageBlockShow('block_msg_form_success');
						$personal->setCommonSuccessMsg($LANG['personal_profile_success_message']);
					}
				else //error in form inputs
					{
						$personal->setAllPageBlocksHide();
						$personal->setPageBlockShow('block_msg_form_error');
						$personal->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$personal->setPageBlockShow('form_editprofile');
					}
			}
	}

if ($personal->isShowPageBlock('form_editprofile'))
	{
		$personal->LANG['personal_profile_first_name_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['first_name']['min'], $LANG['common_err_tip_invalid_character_size']);
		$personal->LANG['personal_profile_first_name_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['first_name']['max'], $personal->LANG['personal_profile_first_name_errormsg']);
		$personal->LANG['personal_profile_last_name_errormsg'] = str_replace('VAR_MIN', $CFG['fieldsize']['last_name']['min'], $LANG['common_err_tip_invalid_character_size']);
		$personal->LANG['personal_profile_last_name_errormsg'] = str_replace('VAR_MAX', $CFG['fieldsize']['last_name']['max'], $personal->LANG['personal_profile_last_name_errormsg']);
		$first_option_arr = array(''=>$LANG['personal_profile_choose']);
		$smartyObj->assign('smarty_country_list', $first_option_arr + $LANG_LIST_ARR['countries']);
	}

$calendar_options_arr = array('minDate' => '-70Y',
							  'maxDate'	=> '-1D',
							  'yearRange'=> '-100:+20'
							 );
$smartyObj->assign('dob_calendar_opts_arr', $calendar_options_arr);
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
$personal->sanitizeFormInputs($_REQUEST);
if ($personal->isShowPageBlock('form_editprofile'))
	{
		$personal->show_dob_value=$user_details_arr['show_dob'];
		$personal->getCurrenryear=date("Y");
		$personal->populateGender=$personal->populateListArray($LANG_LIST_ARR['gender'], $user_details_arr['sex']);
		if($personal->isFormPOSTed($_POST, 'editprofile_submit') && isset($_POST['show_dob_check']))
			{
				$personal->dobChecked='CHECKED';
				$personal->show_dob_value=1;
			}
		else if($personal->isFormPOSTed($_POST, 'editprofile_submit') && !isset($_POST['show_dob_check']))
			{
				$personal->dobChecked='';
				$personal->show_dob_value=0;
			}
		else
			{
				$personal->dobChecked=($user_details_arr['show_dob'])?'CHECKED':'';
				$personal->show_dob_value=$user_details_arr['show_dob'];
			}
		$personal->populateUserRelation=$personal->populateListArray($LANG_LIST_ARR['user_relation_status'], $personal->getFormField('relation_status'));
	}
$personal->user_details_arr=$user_details_arr;
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$personal->includeHeader();
//include the content of the page
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
	function chekc_show_dob() {
	  	if($Jq('#show_dob_check').is(':checked')) {
	  		$Jq('#show_dob').val(1);
		} else {
	  		$Jq('#show_dob').val(0);
	  	}
	}
</script>

<?php
setTemplateFolder('members/');
$smartyObj->display('profileBasic.tpl');
if ($CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#selFormEditPersonalProfile").validate({
		errorClass: "clsFormFieldErrTip",
		rules: {
		    email: {
		    	required: true,
				isValidEmail: true
		    },
		    first_name: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['first_name']['min']; ?>,
		    	maxlength: <?php echo $CFG['fieldsize']['first_name']['max']; ?>
		    },
		    last_name: {
		    	required: true,
		    	minlength: <?php echo $CFG['fieldsize']['last_name']['min']; ?>,
		    	maxlength: <?php echo $CFG['fieldsize']['last_name']['max']; ?>
		    },
		    dob: {
		    	required: true,
		    	isValidDate: true,
		    	dateISO: true,
		    	isValidDateVal: true,
		    	isValidMinAge: <?php echo $personal->CFG['admin']['members_signup']['age_limit_start']; ?>,
		    	isValidMaxAge: <?php echo $personal->CFG['admin']['members_signup']['age_limit_end']; ?>
			},
		    country: {
		    	selectCountry: true
		    },
		    postal_code: {
		    	required: true
		    }
		},
		messages: {
			email: {
				required: "<?php echo $personal->LANG['common_err_tip_required'];?>",
				isValidEmail: "<?php echo $personal->LANG['common_err_tip_email'];?>"
			},
			first_name: {
				required: "<?php echo $personal->LANG['personal_profile_first_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $personal->LANG['common_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $personal->LANG['common_err_tip_max_characters'];?> {0}")
			},
			last_name: {
				required: "<?php echo $personal->LANG['personal_profile_last_name_errormsg'];?>",
				minlength: jQuery.format("{0} <?php echo $personal->LANG['common_err_tip_min_characters'];?>"),
				maxlength: jQuery.format("<?php echo $personal->LANG['common_err_tip_max_characters'];?> {0}")
			},
		    dob: {
		    	required: "<?php echo $personal->LANG['common_err_tip_required'];?>",
		    	isValidDate: "<?php echo $personal->LANG['common_err_tip_date_formate'];?>",
		    	dateISO: "<?php echo $personal->LANG['common_err_tip_date_invalid'];?>",
		    	isValidDateVal: "<?php echo $personal->LANG['common_err_tip_date_invalid'];?>",
		    	isValidMinAge: "<?php echo str_replace('VAR_MIN_AGE', $personal->CFG['admin']['members_signup']['age_limit_start'], $personal->LANG['common_err_tip_age_min']);?>",
		    	isValidMaxAge: "<?php echo str_replace('VAR_MAX_AGE', $personal->CFG['admin']['members_signup']['age_limit_end'], $personal->LANG['commom_err_tip_age_max']);?>"
		    },
			postal_code: {
				required: "<?php echo $personal->LANG['common_err_tip_required'];?>"
			}
		}
	});
</script>
<?php
}
$personal->includeFooter();
?>