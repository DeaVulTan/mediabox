<?php
//--------------class DiscussionsFormHandler--------------->>>//
/**
 * @category	Discuzz
 * @package		DiscussionsFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2008-12-22
 **/
class DiscussionsFormHandler extends FormHandler
	{
		public $category_titles;
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getUnpublishedBoards($discussion_id)
			{
				$sql = 'SELECT count(board_id) as total_unpublished_boards '.
						'FROM '.$this->CFG['db']['tbl']['boards'].' '.
						'WHERE discussion_id = '.$this->dbObj->Param($discussion_id).' '.
						'AND status = \'ToActivate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row;
			}

		/**
		 * To display the discussions titles
		 *
		 * @access public
		 * @return void
		 **/
		public function showDiscussionTitles()
			{
				$sql = 'SELECT cat_id, cat_name, seo_title, has_child, total_discussions'.
						' FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE status = \'Active\'';

				$field_values = array();
				if ($this->fields_arr['cat'] AND $cat_id = $this->getCategoryId($this->fields_arr['cat']))
					{
						$sql .= ' AND cat_id ='.$this->dbObj->Param($cat_id);
						$field_values[] = $cat_id;
					}
				else
					{
						$sql .=' AND parent_id = 0';
					}
				$sql .= ' ORDER BY disporder';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$showDiscussionTitles_arr = array();
				while($row = $rs->FetchRow()) {
						$row['subforum_titles'] = $this->getSubForumTitles($row['cat_id']);
						//if(!$row['subforum_titles'])
						$row['discussion_titles'] = $this->getDiscussionTitles($row['cat_id']);
						//else $row['discussion_titles'] = '';
						if($row['discussion_titles'] or $row['subforum_titles']){
						$showDiscussionTitles_arr[] = $row;
						}
				}
				return $showDiscussionTitles_arr;
			}

		/**
		 * To display the subcategory titles
		 *
		 * @access public
		 * @return void
		 **/
		public function getSubForumTitles($cat_id)
			{
				$sql = 'SELECT c.cat_id, c.cat_name, c.seo_title, c.has_child, c.description, c.total_discussions, c.total_boards, c.total_solutions, c.last_post_user_id'.
						', DATE_FORMAT(last_post_date, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') AS last_post_date, DATE_FORMAT(last_post_date, \''.$this->CFG['mysql_format']['new_date'].'\') AS last_post_date_only'.
						', DATE_FORMAT(last_post_date, \'%h:%m %p\') AS last_post_time_only, lp.'.getUserTableField('name').' AS last_post_user, lp.'.getUserTableField('display_name').' AS last_post_name'.
						' FROM '.$this->CFG['db']['tbl']['category'].' As c LEFT JOIN '.$this->CFG['db']['tbl']['users'].' As lp ON c.last_post_user_id=lp.'.getUserTableField('user_id').
						' WHERE status = \'Active\' AND parent_id = '.$this->dbObj->Param($cat_id);

				$field_values = array();
				$field_values[] = $cat_id;
				$sql .= ' ORDER BY disporder';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$showDiscussionTitles_arr = array();
				while($row = $rs->FetchRow()) {
					$catqryN = '?cat='.$row['seo_title'];
					$catqryH = 'dir/'.$row['seo_title'].'/';
					$row['subforum']['url'] = getUrl('discussions', $catqryN, $catqryH, '', $this->CFG['admin']['index']['home_module']);
					$row['category_description_manual'] = nl2br(wordWrapManual($row['description'], 15, 100));
					$row['lastPost']['url'] = getMemberUrl($row['last_post_user_id'], $row['last_post_user']);
					$row['last_post_name1'] = stripString($row['last_post_name'], 20);
					$showDiscussionTitles_arr[] = $row;
				}
				return $showDiscussionTitles_arr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getDiscussionTitles($cat_id)
			{
				$sql = 'SELECT d.discussion_title, d.discussion_id, d.user_id, u.'.getUserTableField('name').' AS name, d.seo_title, d.description, d.total_boards, d.total_solutions, d.last_post_user_id'.
						', DATE_FORMAT(last_post_date, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') AS last_post_date, DATE_FORMAT(last_post_date, \''.$this->CFG['mysql_format']['new_date'].'\') AS last_post_date_only'.
						', DATE_FORMAT(last_post_date, \'%h:%m %p\') AS last_post_time_only, lp.'.getUserTableField('name').' as last_post_user, lp.'.getUserTableField('display_name').' as last_post_name'.
						', u.'.getUserTableField('name').' AS post_user, u.'.getUserTableField('display_name').' AS post_name FROM '.$this->CFG['db']['tbl']['discussions'].' AS d'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON d.user_id = u.'.getUserTableField('user_id').
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS lp on d.last_post_user_id = lp.'.getUserTableField('user_id').
						' WHERE d.pcat_id = '.$this->dbObj->Param($cat_id).' AND d.status = \'Active\' AND u.'.getUserTableField('user_status').'=\'Ok\' ';
				$field_values[] = $cat_id;
				if ($this->fields_arr['my'])
					{
						$sql .= ' AND d.user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);
						$field_values[] = $this->CFG['user']['user_id'];
					}

				if($this->fields_arr['cat'])
					$sql .= ' ORDER BY d.discussion_id DESC';
				else
					$sql .= ' ORDER BY d.discussion_id DESC LIMIT 0, 5';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $field_values);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$discussion_titles  = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow()){
							$row['discussionBoards']['url'] = getUrl('boards', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
							$row['discussionBoards']['title'] = wordWrapManual($row['discussion_title'], 15);
							$row['discussion_description_manual'] = nl2br(wordWrapManual($row['description'], 15));
							$row['myanswers']['url'] = getMemberUrl($row['user_id'], $row['post_user']);
							$row['lastPost']['url'] = getMemberUrl($row['last_post_user_id'], $row['last_post_user']);
							$row['last_post_name1'] = stripString($row['last_post_name'], 20);
							if($row['user_id'] == $this->CFG['user']['user_id'] and ($this->fields_arr['my']))
								{
									$publish_details = $this->getUnpublishedBoards($row['discussion_id']);
									$row['discussions_unpublished_boards']['content'] = $this->LANG['unpublished_boards'].' : <a href="'.getUrl('boards', '?title='.$row['seo_title'].'&unpublished=1', $row['seo_title'].'/?unpublished=1', '', $this->CFG['admin']['index']['home_module']).'">'.$publish_details['total_unpublished_boards'].'</a>';
								}
							$discussion_titles[] = $row;
						}
					}
				return $discussion_titles;
			}

		public function getCategoryId($seo_title)
			{
				$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE seo_title = '.$this->dbObj->Param($seo_title).
						' AND status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($seo_title));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$cat_id = '';
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$cat_id = $row['cat_id'];
					}
				return $cat_id;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCategoryName($seo_title)
			{
				$sql = 'SELECT cat_name, parent_id, seo_title FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE seo_title = '.$this->dbObj->Param($seo_title).
						' AND status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($seo_title));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$cat_name = '';
				$category_info = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$cat_name = $row['cat_name'];
						$category_info['cat_name'] = $cat_name;
						$catqryN = '?cat='.$row['seo_title'];
						$catqryH = 'dir/'.$row['seo_title'].'/';
						$category_info['cat_url'] = stripString($row['cat_name']);
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
				return $cat_name;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCategoryTitles($cat_id)
			{
				$sql = 'SELECT cat_name, seo_title, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id = '.$this->dbObj->Param($cat_id).
						' AND status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$category_info = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$category_info['cat_name'] = $row['cat_name'];
						$catqryN = '?cat='.$row['seo_title'];
						$catqryH = 'dir/'.$row['seo_title'].'/';
						$category_info['cat_url'] = '<a href="'.getUrl('discussions', $catqryN, $catqryH, '', $this->CFG['admin']['index']['home_module']).'">'.stripString($row['cat_name']).'</a>';
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
			}
	}
//<<<<<<<--------------class DiscussionsFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$discussions = new DiscussionsFormHandler();
if(!chkIsAllowedModule(array($CFG['admin']['index']['home_module'])))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));
$discussions->setPageBlockNames(array('form_show_discussions', 'form_confirm'));

$discussions->setAllPageBlocksHide();

//default form fields and values...
$discussions->setFormField('my', '');
$discussions->setFormField('cat', '');
$discussions->sanitizeFormInputs($_REQUEST);

$condition = $discussions->discussions_cattitle = '';
$discussions->discussions_sitetitle = $discussions->discussions_pagetitle = $LANG['discussions_text'];
$catqry = '';
if ($discussions->getFormField('cat'))
	{
		$discussions->discussions_pagetitle = '<a href="'.getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']).'">'.$discussions->discussions_pagetitle.'</a>';
		$catqry = '&amp;cat='.$discussions->getFormField('cat');
		//$discussions->discussions_sitetitle .= ' - '.$discussions->discussions_cattitle = $discussions->getCategoryName($discussions->getFormField('cat'));
		$discussions->getCategoryName($discussions->getFormField('cat'));
		if(is_array($discussions->category_titles))
			{
				$discussions->category_titles = array_reverse($discussions->category_titles);
				foreach($discussions->category_titles as $key=>$cat_value)
					{
						$discussions->discussions_sitetitle .= ' - '.$cat_value['cat_name'];
						$discussions->discussions_cattitle  .= $cat_value['cat_url'];
					}
			}
	}
if(isMember())
	{
		//$discussions->discussions_sitetitle .= ' - '.$LANG['discussions_mytitles'];
		//$discussions->discussions_mytitle = '<a href="'.getUrl('discussions', '?my=1'.$catqry, '?my=1'.$catqry, 'members', $CFG['admin']['index']['home_module']).'">'.$LANG['discussions_mytitles'].'</a>';
	}

if ($discussions->isFormPOSTed($_GET, 'my') AND $discussions->getFormField('my') AND isMember())
	{
		$discussions->discussions_pagetitle = '<a href="'.getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']).'">'.$discussions->discussions_pagetitle.'</a>';
		$catqryN = $catqryH = '';
		if ($discussions->getFormField('cat'))
			{
				$catqryN = '?cat='.$discussions->getFormField('cat');
				$catqryH = 'dir/'.$discussions->getFormField('cat').'/';
				$discussions->discussions_cattitle = '<a href="'.getUrl('discussions', $catqryN, $catqryH, '', $CFG['admin']['index']['home_module']).'">'.$discussions->discussions_cattitle.'</a>';
			}
		//$discussions->discussions_mytitle = $LANG['discussions_mytitles'];
	}

$discussions->setPageBlockShow('form_show_discussions'); //default page block. show it. All others hidden
$discussions->discussionsAddTitle_url = getUrl('adddiscussion', '', '', 'members', $CFG['admin']['index']['home_module']);
$discussions->login_url = getUrl('login', '?light_url='.$discussions->discussionsAddTitle_url, '?light_url='.$discussions->discussionsAddTitle_url, 'root');
if ($discussions->isFormPOSTed($_GET, 'msg'))
	{
		if($CFG['admin']['discussions']['auto_publish']['allowed'])
			$discussions->setCommonSuccessMsg($LANG['discussions_title_created_successfully']);
		else
			$discussions->setCommonSuccessMsg($LANG['discussions_title_waiting_for_approval']);
		$discussions->setPageBlockShow('block_msg_form_success');
	}
//<<<<--------------------Code Ends----------------------//
$CFG['site']['title'] = $discussions->discussions_sitetitle.' - '.$CFG['site']['title'];
//--------------------Page block templates begins-------------------->>>>>//
if ($discussions->isShowPageBlock('form_show_discussions'))
	{
		$discussions->showDiscussionTitles = $discussions->showDiscussionTitles();
	}
//include the header file
$discussions->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('discussions.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
//include the footer of the page
$discussions->includeFooter();
?>