<?php
/**
 * UserProfiles
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class UserProfiles extends ListRecordsHandler
	{
		/**
		 * GroupsFormHandler::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'usr_status=\'Ok\'';

				if($this->getFormField('user_name'))
					{
						$this->sql_condition .= ' AND user_name LIKE \'%'.addslashes($this->getFormField('user_name')).'%\'';
					}

				if($this->getFormField('email'))
					{
						$this->sql_condition .= ' AND email = \''.addslashes($this->getFormField('email')).'\'';
					}

				if($this->getFormField('gender'))
					{
						$this->sql_condition .= ' AND gender = \''.addslashes($this->getFormField('gender')).'\'';
					}
			}

		/**
		 * UserProfiles::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * UserProfiles::showUserProfiles()
		 *
		 * @return
		 **/
		public function populateUserProfiles()
			{
				global $smartyObj;
				$data_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$data_arr[$inc] = $row;
						$data_arr[$inc]['name'] = getUserDisplayName($row);
						$data_arr[$inc]['profile_url'] = getUrl('profile', '?uname='.$row['user_name'], $row['user_name'], 'root');
						$data_arr[$inc]['send_mail_link'] = $this->getUrl('mailcompose', '?username='.$row['user_name'], '?username='.$row['user_name'], 'members');
						$inc++;
					}
				$smartyObj->assign('populateUserProfiles_arr', $data_arr);
			}
	}
//<<<<<-------------- Class GroupsFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$UserProfiles = new UserProfiles();
$UserProfiles->setPageBlockNames(array('block_userList', 'block_userSearch'));
//default form fields and values...
$UserProfiles->setFormField('uname', '');
$UserProfiles->setFormField('user_name', '');
$UserProfiles->setFormField('email', '');
$UserProfiles->setFormField('gender', '');

/*********** Page Navigation Start *********/
$UserProfiles->setFormField('orderby_field', 'user_id');
$UserProfiles->setFormField('orderby', 'DESC');
$UserProfiles->setTableNames(array($UserProfiles->CFG['db']['tbl']['users']));
$UserProfiles->setReturnColumns(array('user_id', 'user_name', 'email', 'first_name', 'last_name'));
/************ page Navigation stop *************/
$UserProfiles->setPageBlockShow('block_userList');
$UserProfiles->setPageBlockShow('block_userSearch');
$UserProfiles->sanitizeFormInputs($_REQUEST);
//<<<<<-------------------- Code ends----------------------//

//-------------------- Page block templates begins -------------------->>>>>//
if($UserProfiles->isShowPageBlock('block_userList'))
	{
		/****** navigtion continue*********/
		$UserProfiles->buildSelectQuery();
		$UserProfiles->buildConditionQuery();
		$UserProfiles->buildSortQuery();
		$UserProfiles->buildQuery();
		$UserProfiles->executeQuery();

		if(!$UserProfiles->isResultsFound())
			{
				$UserProfiles->setPageBlockShow('block_msg_form_alert');
				$UserProfiles->setPageBlockHide('block_userList');
				$UserProfiles->setCommonAlertMsg($LANG['common_no_records_found']);
			}
		else
			{
				$UserProfiles->populateUserProfiles();
				$smartyObj->assign('smarty_paging_list', $UserProfiles->populatePageLinksGET($UserProfiles->getFormField('start'), array('orderby_field', 'orderby', 'user_name', 'email', 'gender')));
			}
	}
$UserProfiles->msgConfirmForm_hidden_arr = array('uname', 'act', 'orderby', 'orderby_field', 'start', 'user_name', 'email', 'gender');
$UserProfiles->userListForm_hidden_arr = array('orderby', 'orderby_field', 'start', 'user_name', 'email', 'gender');
//include the header file
$UserProfiles->includeHeader();
if($UserProfiles->isShowPageBlock('block_userList'))
	{
?>
		<script type="text/javascript" language="javascript">
			var block_arr= new Array('selMsgConfirmWindow');
			var lang_arr = new Array();
		</script>
<?php
}
//include the content of the page
setTemplateFolder('general/');
$smartyObj->display('userProfiles.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$UserProfiles->includeFooter();
?>