<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design,
 * Please contact me if you need any such web-based information system
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 *
 *
 */
	define('HTML_AJAX_WINDOW',
		'
		<div class="jqmWindow" id="fireForm" style="display:none">
			<div id="fireFormAjaxProgress">
				<h1>Processing...</h1>
				<p class="fireFormAjaxProgressBody">your submission is being processed, please wait...</p>
			</div>
			<div id="fireFormAjaxError" >
				<h1>Error:</h1>
				<p class="fireFormAjaxErrorBody"></p>
				<a href="javascript:void(0);" class="jqmClose">Close</a>
			</div>
			<div id="fireFormAjaxWarning">
				<h1>Warning:</h1>
				<p class="fireFormAjaxWaringBody">
				<ul>
				</ul>
					</p>
				<a href="javascript:void(0);" class="jqmClose">Close</a>
			</div>

		</div>	'
	);

	define('ERR_QUESTION_INVALID1', 'Some question(s) have not been answered or been given invalid answer');
	define('ERR_QUESTION_INVALID2', 'Please see those question(s) and comments marked in red.');
	define('LOGIN_STATUS', 'Welcome, you loged in as: %s');
	define('LOGOUT', 'Log Out');
	define('DELETE_QUESTION', 'Are you sure to remove this field?');
// ~~~~~~~~~~ control panel
define('PANEL_MENU_QUESTIION', 'Add Question');
define('PANEL_MENU_SETTING', 'Form Settings');
define('PANEL_MENU_TEST', 'Test Form');
// ~~~~~~~~~ form setting on control panel
define('PANEL_FS_FORM_TITLE', 'Form Title');
define('PANEL_FS_CREATOR', 'Form Creator');
define('PANEL_FS_BTN_LABEL', 'Submit Button Label');
define('PANEL_FS_URL', 'Redirect To After Submit');
define('PANEL_FS_MODE', 'Save To ');
define('PANEL_FS_THEME', 'Form Skin');
define('PANEL_FS_SUBJECT', 'Email Subject');
define('PANEL_FS_EMAIL', 'Email Address');
define('PANEL_FS_MODE_BOTH', 'Email & Database');
define('PANEL_FS_MODE_EMAIL', 'Email');
define('PANEL_FS_MODE_DB', 'Database');
define('PANEL_FS_UPDATE_FORM', 'Add Question');



define('LOGIN_REQUIRED', 'Oops! You are logged in yet.');
define('PERMISSION_DENIED', 'Permission denied.');



define('BTN_SAVE', 'Save');
// ~~~~~~~~~~~~~~ normal error
define('ERR_FORM_NOT_SPECIFIED', 'No form has been specified.');
define('ERR_FORM_NOT_FOUND', 'Unable to load up the specified form.');
define('ERR_UNEXPECTED', 'Unexpected results occured. in order keep your data consistent, please refresh your page and try again.');
define('ERR_FAILED_TO_SAVE_FROM', 'Failed to save the form settings, please try again.');
define('ERR_Q_QUESTION_TYPE_EMPTY', 'No question type specified.');
define('ERR_Q_QUESTION_TYPE_INVALID', 'Invalid question type.');
define('ERR_Q_QUESTION_TYPE_NOT_FOUND', 'No question type found.');
define('ERR_Q_QUESTIONS_EMPTY', 'No questions has been spcified.');
define('ERR_Q_QUESTIONS_BLANK', 'No any questions found in the specified form.');
define('ERR_Q_QUESTIONS_NOT_MATCHED', 'There has been some changes on the number of questions since you last load, please refresh your web page.');

// ~~~~~~  db errors
define('ERR_DB_CONN_FAILED', 'Unable to connect to database server, please contact the technical support team.');
define('ERR_DB_TRAN_FAILED', 'The database does not support transactions, please contact the technical support team.');
define('ERR_DB_CREATE_Q_FAILED', 'Failed to create new question, please try again.');
define('ERR_DB_DELETE_Q_FAILED', 'Failed to delete the specified question, please try again.');
define('ERR_DB_RETRIEVE_Q_FAILED', 'Unexpected error occured while retrieve information of the specified question, please try again.');
define('ERR_DB_RETRIEVE_Q_DENIED', "You do not have proper permission to access the specified question.");
define('ERR_DB_SAVE_Q_FAILED', 'Failed to save the information for the specified question, please try again.');
define('ERR_DB_SAVE_ANSWERS_FAILED', 'Failed to process your submit, please try again.');
define('ERR_DB_UNEXPECTED', 'Unexpected DB error while processing your request, please try again.');
//COMMON things
define('CMM_YES', 'Yes');
define('CMM_NO', 'No');
define('CMM_BTN_SAVE', 'Save');
define('CMM_PLEASE_SELECT', 'Select:');
define('CMM_DEFAULT_INSTRUCTION', 'Please enter instruction.');
define('CMM_QUESTION', 'Field Name');
define('CMM_WIDTH', 'Field Width ');
define('CMM_MAX_LENGTH', 'Max Chars ');
define('CMM_ANSWER_REQUIRED', 'Answer Required?');
define('CMM_ERROR_MESSAGE', 'Error Message ');
define('CMM_INSTRUCTION', 'Instructions ');
define('CMM_DEFAULT_VALUE', 'Default Value ');
define('CMM_ROWS', 'Rows');
define('CMM_SPECIFY_ALLOWED', 'Specify Allowed?');
define('CMM_SPECIFY_LABEL', 'Specify Label');
define('CMM_DEFAULT_SPECIFY_LABLE', 'Please specify...');
define('CMM_OPTION1', 'Option One');
define('CMM_OPTION2', 'Option Two');
define('CMM_OTHER', 'Other (Please specify)');
define('CMM_VERTICAL', 'Vertical Display');
define('CMM_HORIZONTAL', 'Horizontal Display');
define('CMM_DISPLAY', 'Display');
	//Consts
	define('CONST_CDATETIME', 'Created At');
	define('CONST_EDIT', 'Edit');
	define('CONST_DELETE', 'Delete');
	define('CONST_ADD', 'Add');
	define('CONST_EXPORT', 'Export');
	define('CONST_VIEW', 'View');
	define('CONST_STATS', 'Stats');
	define('CONST_SUBMIT', 'Submit');
	define('CONST_DUPLICATE', 'Duplicate');
	define('CONST_TEST', 'Test');
	//Common
	define('CMM_DATE_FORMAT', 'd/M/Y');
	define('CMM_MONTHYEAR_FORMAT', 'M/Y');
	define('CMM_DATE_TIME_FORMAT', 'd/M/Y H:i:s');
	define('CMM_FULL_NAME_ORDER_PATTERN', '%1$s %2$s'); //sprintf(CMM_FULL_NAME_ORDER_PATTERN, $firstName, $lastName)
	define('CMM_DATE_ORDER_PATTERN', '%1$s %2$s %3$s'); //sprintf(CMM_DATE_ORDER_PATTERN, $year, $month, $day);

	define('CMM_BTN_RESET', 'Reset');


	define('CMM_MONTH', 'Mon');
	define('CMM_DAY', 'Day');
	define('CMM_AJAX_PRGRESS_HEADING', 'Processing:');
	define('CMM_AJAX_PROGRESS_DESC', 'Your request is under process, please wait untill it finishs...');
	define('CMM_AJAX_ERROR_HEADING', 'Error:');


	define('CMM_PROCEED_TO_NEXT', 'Proceed to Next');
	define('CMM_GO_BACK', 'Go Back');
	define('CMM_NA', 'N/A');
	define('CMM_TOTAL', 'Total');

/**  BACK END */
	define('L_TAB_FORM', 'FORM');
	define('L_TAB_USER', 'User');
	define('L_TAB_INFO', 'Personal Information');
	define('L_TAB_CONFIG', 'Config');

	/** ~~~ Menu Category ~~~ */
	define('L_MENU_CAT_FORM', 'Form Management');
	define('L_MENU_CAT_USER', 'User Management');
	define('L_MENU_CAT_ERR_LOGS', 'Error Logs');
	define('L_MENU_CAT_STATS', 'Stats');
	define('L_MENU_CAT_INFO', 'Peronsal Information');
	/**  Menu   */
	define('L_MENU_FORM_NEW', 'Add New Form');
	define('L_MENU_YOUR_FORM', 'Your Form');
	define('L_MENU_STATS', 'Stats');
	define('QUESTIONS', 'Questions');
	define('L_MENU_UPDATE_INFO', 'Update Information');

	define('L_MENU_USERS', 'Users');
	define('L_MENU_USER_GROUPS', 'User Group');
	define('L_MENU_USER_NEW', 'Add User');
	define('L_MENU_USER_GROUP_ADD', 'Add User Group');
	define('L_MENU_USER_GROUP_EDIT', 'Edit User Group');
	define('L_MENU_USER_EDIT', 'Edit User');


	define('LOGIN_USERNAME', 'Username: ');
	define('LOGIN_PASSWORD', 'Password: ');
	define('LOGIN_VCODE', 'Validation Code: ');
	define('ERR_LOGIN_USERNAME', 'Please enter Username');
	define('ERR_LOGIN_PASSWORD', 'Please enter your password.');
	define('ERR_LOGIN_VCODE', 'Please enter Correct Validation Code.');
	define('ERR_LOGIN_FAILED', 'Invalid Username/Password, please try again.');

	/** ~~~~~~  Action      ~~~~~~~ */
	define('L_ACTION_DELETE', 'Delete');
	define('L_ACTION_EDIT', 'Edit');
	define('L_ACTION_ADD', 'Add');
	define('L_ACTION_CLOSE', 'Close');
	define('L_ACTION_FORM_EDIT', 'Edit Form');

	define('L_ACTION_SAVE', 'Save');
	define('L_ACTION_LOGIN', 'Login');

	// form module
	define('FORM_YOUR_FORM', 'Your Form');
	define('FORM_FORM_TITLE', 'Form Title');
	define('FORM_LOGIN_REQUIRED', 'Login Required?');
	define('FORM_IS_ACTIVE', 'Is Active?');
	define('FORM_FINISH_DATE', 'Finish Date');
	define('FORM_CREATOR', 'Created By');
	define('FORM_NUMBER_RESPONDS', 'Responds');
	//user module
	define('USER_FIRST_NAME', 'First Name');
	define('USER_LAST_NAME', 'Last Name');
	define('USER_IS_SUPLER_ADMIN', 'Super Admin?');
	define('USER_EMAIL', 'Email');
	define('USER_CDATETIME', 'Created At');
	define('USER_USERNAME', 'Username');
	define('USER_PASSWORD', 'Password');
	define('USER_ACTIVE', 'Active?');
	define('USER_CHANGE_PWD', 'Change Password?');
	define('USER_DELETE_CONFIRM', 'Are you sure to delete this user?');
	define('USER_ERR_FAILED_EDIT', 'Failed to update the user information.');
	define('USER_ERR_FAILED_ADD', 'Failed to create a new user.');
	define('USER_CHANGE_DETAILS', 'Change Details');
	define('USER_ERR_FAILED_UPDATE', 'Failed to update your information.');


	//form
	define('BTN_ADD_FORM', 'Create Form');
	define('FAILED_TO_ADD_FORM', 'Failed to create new form.');
	//
	define('FORM_STATS_FILTER', 'Filter:');
	define('FORM_STATS_FILTER_BY', 'Filter By:');
	define('FORM_STATS_DAILY', 'Daily');
	define('FORM_STATS_MONTHLY', 'Monthly');
	define('FORM_STATS_RANGE', 'Date Range');
	define('FORM_STATS_MONTH', 'Month');
	define('FORM_STATS_DAY', 'Day');



