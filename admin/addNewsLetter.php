<?php
/**
 * This file hadling the add news letter
 *
 * News letter send for particular users criteria
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/addNewsLetter.php';
//Gender List
//Search Options Array List
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['admin']['calendar_page'] = true;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class addNewsLetter --------------->>>//
/**
 * This class hadling the add news letter
 *
 * @category	Rayzz
 * @package		Admin
 */
class addNewsLetter extends FormHandler
	{
		/**
		 * addNewsLetter::insertFormFieldsInTable()
		 * To inset form fields in table
		 *
		 * @param  array $tableName table name to insert
		 * @param  array $fields_to_insert_arr fileds name to insert
		 * @return 	int
		 * @access 	public
		 */
		public function insertFormFieldsInTable($tableName, $fields_to_insert_arr=array())
			{
				$sql = 'INSERT INTO '.$tableName.' SET date_added = NOW(), ';// sql_condition = '.$this->fields_arr['sql_condition'].' , ';
				foreach($fields_to_insert_arr as $field_name)
					if(isset($this->fields_arr[$field_name]))
						$sql .= $field_name.'=\''.addslashes($this->fields_arr[$field_name]).'\', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$result_set = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$result_set)
						trigger_db_error($this->dbObj);
				return($this->dbObj->Insert_ID());
			}

		/**
		 * addNewsLetter::isEmpty()
		 * To check is empty
		 *
		 * @param  $value value to check
		 * @return 	boolean
		 * @access 	public
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * addNewsLetter::buildConditionQuery()
		 * To build the condition query for listing
		 *
		 * @return
		 * @access 	public
		 */
		public function buildConditionQuery()
			{
				$sql_condition = " usr_status!='Deleted'";
				$condition = '';
				if (!$this->isEmpty($this->fields_arr["uname"]))
				    {
						$sql_condition .= " AND user_name LIKE '%".addslashes($this->fields_arr['uname'])."%' ";
				    }
				if (!$this->isEmpty($this->fields_arr["fname"]))
				    {
						$sql_condition .= " AND first_name LIKE '%".addslashes($this->fields_arr['fname'])."%' ";
				    }
				if (!$this->isEmpty($this->fields_arr["lname"]))
				    {
						$sql_condition .= " AND last_name LIKE '%".addslashes($this->fields_arr['lname'])."%' ";
				    }
				if (!$this->isEmpty($this->fields_arr["email"]))
				    {
						$sql_condition .= " AND email LIKE '%".addslashes($this->fields_arr['email'])."%' ";
				    }
				if (!$this->isEmpty($this->fields_arr['gender']))
				    {
						$sql_condition .= " AND gender='".addslashes($this->fields_arr['gender'])."'";
				    }
				if (!$this->isEmpty($this->fields_arr['doj_start']))
				    {
						$dojStart  = $this->fields_arr['doj_start'];
						$sql_condition .= " AND doj >= '".addslashes($dojStart)."'";
				    }
				if (!$this->isEmpty($this->fields_arr['doj_end']))
				    {
						$dojEnd  = $this->fields_arr['doj_end'];
						$sql_condition .= " AND doj <= '".addslashes($dojEnd)."'";
				    }
				if (!$this->isEmpty($this->fields_arr['dob_start']))
				    {
						$dobStart  = $this->fields_arr['dob_start'];
						$sql_condition .= " AND dob >= '".addslashes($dobStart)."'";
				    }
				if (!$this->isEmpty($this->fields_arr['dob_end']))
				    {
						$dobEnd  = $this->fields_arr['dob_end'];
						$sql_condition .= " AND dob <= '".addslashes($dobEnd)."'";
				    }
				if (!$this->isEmpty($this->fields_arr['login_start']))
				    {
						$loginStart  = $this->fields_arr['login_start'];
						$sql_condition .= " AND last_logged <= '".addslashes($loginStart)."'";
				    }
				$statusOk = $this->fields_arr['user_status_Ok'];
				$statusDeActivate = $this->fields_arr['user_status_ToActivate'];
				$statusLocked = $this->fields_arr['user_status_Locked'];
				if ($statusOk OR $statusDeActivate OR $statusLocked)
				    {
						$statusCondition = '( 0 ';
						$statusCondition .= $statusOk?" OR usr_status='Ok'":'';
						$statusCondition .= $statusDeActivate?" OR usr_status='ToActivate'":'';
						$statusCondition .= $statusLocked?" OR usr_status='Locked'":'';
						$statusCondition .= ')';
						$sql_condition .= ' AND '.$statusCondition;
				    }
				$this->fields_arr['sql_condition'] = $sql_condition ;
			}

		/**
		 * addNewsLetter::populateYearsListCurrent()
		 * To build the condition query for listing
		 *
		 * @param  int $highlight_y selected year to highlight
		 * @param  int $min_year start year in display list
		 * @param  int $max_year end year in display list
		 * @return
		 * @access 	public
		 */
		public function populateYearsListCurrent($highlight_y, $min_year, $max_year)
			{
				for($y=$min_year; $y<=$max_year; ++$y)
					{
?>
	<option value="<?php echo $y;?>"<?php echo($highlight_y==$y)? ' selected="selected"' : '';?>><?php echo $y;?></option>
<?php
					}
			}


	}
//<<<<<---------------class addNewsLetter ends -------------///
//--------------------Code begins-------------->>>>>//
$LANG['help']['first_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['first_name']['min'], $LANG['help']['first_name']);
$LANG['help']['first_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['first_name']['max'], $LANG['help']['first_name']);
$LANG['help']['last_name'] = str_replace('VAR_MIN_COUNT', $CFG['fieldsize']['last_name']['min'], $LANG['help']['last_name']);
$LANG['help']['last_name'] = str_replace('VAR_MAX_COUNT', $CFG['fieldsize']['last_name']['max'], $LANG['help']['last_name']);
$addnewsletter = new addNewsLetter();
$addnewsletter->setPageBlockNames(array('block_form_add_letter', 'block_form_confirm','block_form_search'));

$addnewsletter->setFormField('subject', '');
$addnewsletter->setFormField('body', '');

$addnewsletter->setFormField('email', '');
$addnewsletter->setFormField('uname', '');
$addnewsletter->setFormField('fname', '');
$addnewsletter->setFormField('lname', '');
$addnewsletter->setFormField('tagz', '');
$addnewsletter->setFormField('gender', '');
$addnewsletter->setFormField('sql_condition', '');
$addnewsletter->setFormField('user_status_Ok', '');
$addnewsletter->setFormField('user_status_ToActivate', '');
$addnewsletter->setFormField('user_status_Locked', '');
$addnewsletter->setFormField('test_users', '');
$addnewsletter->setFormField('mail_error', '');
$addnewsletter->setFormField('dob_start', '');
$addnewsletter->setFormField('dob_end', '');
$addnewsletter->setFormField('doj_start', '');
$addnewsletter->setFormField('doj_end', '');
$addnewsletter->setFormField('login_start', '');


$addnewsletter->setFormField('withPhotoVideoFriends', '');
$addnewsletter->setFormField('search' ,'');
$addnewsletter->setYearsListMinMax(date('Y')-1, date('Y')+1);

$addnewsletter->setAllPageBlocksHide();

$addnewsletter->setPageBlockShow('block_form_search');
$addnewsletter->setPageBlockShow('block_form_add_letter');

if($addnewsletter->isFormPOSTed($_POST, 'addstock'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$addnewsletter->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$addnewsletter->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$addnewsletter->sanitizeFormInputs($_POST);
				$addnewsletter->chkIsNotEmpty('subject', $addnewsletter->LANG['common_err_tip_compulsory']);
			    $addnewsletter->chkIsNotEmpty('body', $addnewsletter->LANG['common_err_tip_compulsory']);

				$addnewsletter->getFormField('doj_start') and $addnewsletter->chkIsDateGreaterThanNow('doj_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				$addnewsletter->getFormField('doj_end') and $addnewsletter->chkIsDateGreaterThanNow('doj_end', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				(!($addnewsletter->getFormFieldErrorTip('doj_start') or $addnewsletter->getFormFieldErrorTip('doj_end')))?($addnewsletter->chkIsFromDateGreaterThanToDate('doj_start', $addnewsletter->getFormField('doj_start'), $addnewsletter->getFormField('doj_end'), $addnewsletter->LANG['addletter_err_tip_invalid_date_diff'])):('');

				$addnewsletter->getFormField('dob_start') and $addnewsletter->chkIsDateGreaterThanNow('dob_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				$addnewsletter->getFormField('dob_end') and $addnewsletter->chkIsDateGreaterThanNow('dob_end', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				(!($addnewsletter->getFormFieldErrorTip('dob_start') or $addnewsletter->getFormFieldErrorTip('dob_end')))?($addnewsletter->chkIsFromDateGreaterThanToDate('dob_start', $addnewsletter->getFormField('dob_start'), $addnewsletter->getFormField('dob_end'), $addnewsletter->LANG['addletter_err_tip_invalid_date_diff'])):('');

				$addnewsletter->getFormField('login_start') and $addnewsletter->chkIsDateGreaterThanNow('login_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);

			    if($addnewsletter->isValidFormInputs())
					{

						$addnewsletter->buildConditionQuery();
						$addnewsletter->setPageBlockShow('block_form_confirm');
						$addnewsletter->setPageBlockShow('block_form_add_letter');
					}
				else
					{
						$addnewsletter->setAllPageBlocksHide();
						$addnewsletter->setCommonErrorMsg($addnewsletter->LANG['addletter_err_tip_error']);
						$addnewsletter->setPageBlockShow('block_msg_form_error');
						$addnewsletter->setPageBlockShow('block_form_add_letter');
					}
			}
	}
elseif($addnewsletter->isFormPOSTed($_POST,'cancelstock'))
	{
		Redirect2URL($addnewsletter->CFG['site']['url']."admin/addNewsLetter.php");
	}
elseif($addnewsletter->isFormPOSTed($_POST, 'submit_confirm'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$addnewsletter->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$addnewsletter->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$addnewsletter->sanitizeFormInputs($_POST);
				$addnewsletter->chkIsNotEmpty('subject', $addnewsletter->LANG['common_err_tip_compulsory']);
			    $addnewsletter->chkIsNotEmpty('body', $addnewsletter->LANG['common_err_tip_compulsory']);

			    $addnewsletter->getFormField('doj_start') and $addnewsletter->chkIsDateGreaterThanNow('doj_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				$addnewsletter->getFormField('doj_end') and $addnewsletter->chkIsDateGreaterThanNow('doj_end', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				(!($addnewsletter->getFormFieldErrorTip('doj_start') or $addnewsletter->getFormFieldErrorTip('doj_end')))?($addnewsletter->chkIsFromDateGreaterThanToDate('doj_start', $addnewsletter->getFormField('doj_start'), $addnewsletter->getFormField('doj_end'), $addnewsletter->LANG['addletter_err_tip_invalid_date_diff'])):('');

				$addnewsletter->getFormField('dob_start') and $addnewsletter->chkIsDateGreaterThanNow('dob_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				$addnewsletter->getFormField('dob_end') and $addnewsletter->chkIsDateGreaterThanNow('dob_end', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
				(!($addnewsletter->getFormFieldErrorTip('dob_start') or $addnewsletter->getFormFieldErrorTip('dob_end')))?($addnewsletter->chkIsFromDateGreaterThanToDate('dob_start', $addnewsletter->getFormField('dob_start'), $addnewsletter->getFormField('dob_end'), $addnewsletter->LANG['addletter_err_tip_invalid_date_diff'])):('');

				$addnewsletter->getFormField('login_start') and $addnewsletter->chkIsDateGreaterThanNow('login_start', $addnewsletter->LANG['addletter_err_tip_invalid_date']);
			    if($addnewsletter->isValidFormInputs())
					{
						//$addnewsletter->buildConditionQuery();
						$comment = htmlentitydecode($addnewsletter->getFormField('body'));
						//$comment = strip_tags ($comment, $addnewsletter->CFG['html']['allowed_tags']);
						$addnewsletter->setFormField('body', $comment);

						$addnewsletter->setAllPageBlocksHide();
						$addnewsletter->setCommonSuccessMsg($addnewsletter->LANG['addletter_success_message']);
						$addnewsletter->setPageBlockShow('block_msg_form_success');
						$inputArr = array('subject','body', 'sql_condition');
						$currentEventId = $addnewsletter->insertFormFieldsInTable($addnewsletter->CFG['db']['tbl']['news_letter'], $inputArr);
						$addnewsletter->setFormField('subject', '');
						$addnewsletter->setFormField('body', '');
						$addnewsletter->setPageBlockShow('block_form_add_letter');
					}
				else
					{
						$addnewsletter->setAllPageBlocksHide();
						$addnewsletter->setCommonErrorMsg($addnewsletter->LANG['addletter_err_tip_error']);
						$addnewsletter->setPageBlockShow('block_msg_form_error');
						$addnewsletter->setPageBlockShow('block_form_add_letter');
					}
			}
	}
//<<<<<-------------------- Code ends----------------------//

//-------------------- Page block templates begins -------------------->>>>>//
$addnewsletter->left_navigation_div = 'generalList';
$calendar_options_arr = array('minDate' => '-70Y',
							  'maxDate'	=> '-1D',
							  'yearRange'=> '-100:+20'
							 );
$smartyObj->assign('calendar_opts_arr', $calendar_options_arr);
//include the header file
$addnewsletter->includeHeader();

$smartyObj->assign('form_search_ad_hidden_arr', array('subject', 'body', 'sql_condition'));
$smartyObj->assign('gender_list_arr', array('m'=>$addnewsletter->LANG['common_male_option'], 'f'=>$addnewsletter->LANG['common_female_option']));
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('addNewsLetter.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var confirm_message = '';
	function getAction()
		{
			confirm_message	= '<?php echo $LANG['addletter_confirm'];?>';
			$Jq('#confirmMessage').html(confirm_message);
			Confirmation('selMsgConfirm', 'msgConfirmform', Array(),Array(), Array());
		}

	function submitform(){
			$Jq("#submit_confirm").value="Yes";
			document.form_editBuySelltype.submit();

		}
</script>
<?php
$addnewsletter->includeFooter();
?>