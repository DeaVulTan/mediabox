<?php
//-------------------------class MemberListHandler-------------------->>>
/*
 *
 * @category	Rayzz
 * @package		Members
 * @author 		vijayanand39ag05
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-05-01
 */
class MemberListHandler extends MusicHandler
	{
		private $showPageNavigationLinks = false;
		private $browseTitle = '';
		public $relatedTags  = array();
		public $currentPageUrl = '';

		public function makeGlobalize($cfg=array(), $lang=array())
			{
				parent::makeGlobalize($cfg, $lang);
				$url = getUrl('memberslist');
				$this->tagListUrl = $url;
				$this->setPageUrl($url);
			}

		public function setPageUrl($url)
			{
				$this->currentPageUrl = $url;
			}

		public function getPageUrl()
			{
				return $this->currentPageUrl;
			}

		public function getUserProfileTagSet($tags = '', $query_tag='')
			{
				$url = $this->tagListUrl;
				if(empty($tags))
					{
						return false;
					}
				$tags_arr = array();
			    $inc = 0;
			    /*_parse_tages_member name changed from _parse_tages.(Strict Standards error occures when
			    not chenage this modification)*/
				if ($tags = $this->_parse_tags_member($tags))
				    {
				        foreach($tags as $key=>$value)
							{
							$value = strtolower($value);
							if (!in_array($value, $query_tag) AND !in_array($value, $this->relatedTags))
							    {
									$this->relatedTags[] = $value;
							    }

							  $tags_arr[$inc]['tags']= $value;
							  $inc++;
							}
				    }
				return $tags_arr;
			}

        /**
        * Displays all members with their profile icon
        *
        * @return void
		* @access public
        **/
		public function displayMembers()
			{
				$usersPerRow = $this->CFG['admin']['members_list']['cols'];
				$count = 0;
				$found = false;
				$browse = $this->getFormField('browse');
				$tagSearch = $this->getFormField('tags');
				$tagSearch = (!empty($tagSearch));


				/*_parse_tages_member name changed from _parse_tages.(Strict Standards error occures when
			    not chenage this modification)*/
				$query_tag = $this->_parse_tags_member(strtolower($this->fields_arr['tags']));

				$rank = $this->fields_arr['start']+1;

				$member_list_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$found = true;

						$member_list_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$joined = 0;
						$member_list_arr[$inc]['profileIcon']= getMemberAvatarDetails($row['user_id']);
						$member_list_arr[$inc]['open_tr'] = false;

						if ($count%$usersPerRow==0)
						    {
						    	$member_list_arr[$inc]['open_tr'] = true;
						    }
						$member_list_arr[$inc]['userLink']= '';
						$member_list_arr[$inc]['record'] = $row;
						$member_list_arr[$inc]['country'] = $this->getValueFromArray($this->fields_arr['countries'], $row['country']);
						$member_list_arr[$inc]['UserProfileTag_arr']=$this->getUserProfileTagSet($row['profile_tags'], $query_tag);
						$member_list_arr[$inc]['end_tr'] = false;
						$count++;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$member_list_arr[$inc]['end_tr'] = true;
						    }
						$inc++;
					}// while
				$this->last_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
					{
					 	$this->last_tr_close  = true;
					 	$this->user_per_row=$usersPerRow-$count;
					}
				return $member_list_arr;
			}

		/**
		 * MemberListHandler::buildSortQuery()
		 *
		 * @return void
		 */
		public function buildSortQuery()
			{
				//$this->sql_sort .= ',doj DESC ';
			}

		/**
		 * MemberListHandler::membersRelRayzz()
		 *
		 * @param mixed $row
		 * @return void
		 */
		public function membersRelRayzz($row)
			{
				membersRelRayzz($row);
			}


		public function buildConditionQuery()
		{
			/*$myFriends = $this->getMyFriends();
			array_push($myFriends, $this->CFG['user']['user_id']);
			sort($myFriends);
			$avoid = implode(',', $myFriends);
			$this->sql_condition = 'usr_status=\'Ok\' AND user_id NOT IN ('.$avoid.') ';*/
			$this->sql_condition = 'usr_status=\'Ok\' AND af.artist_id='.$this->fields_arr['artist_id'].' ';
			$this->sql_sort = '';
			$browse  = $this->getFormField('browse');
			$this->sql_condition .= '';
			$this->buildExtraConditionQuery();
			//$this->sql_sort .= ' doj DESC ';

			$pg_title = $this->LANG['members_artist_hits_list_members'];
            $name = $this->getUserDetail('user_id', $this->fields_arr['artist_id'], 'user_name');
			$name = '<a href="'.getUrl('viewprofile','?user='.$name, $name.'/').'">'.ucfirst($name).'</a>';
            $this->browseTitle = str_replace('VAR_USER_NAME', $name, $pg_title);

			$this->showPageNavigationLinks = true;
			$this->setIndirectFormField('browse', 'viewAllMembers');
//						Redirect2URL('membersList.php');

		}

	/**
	 * MemberListHandler::buildExtraConditionQuery()
	 *
	 * @return void
	 */
	public function buildExtraConditionQuery()
		{
			//$this->sql_condition = 'u.user_id<>'.$this->CFG['user']['user_id'].' AND u.usr_status=\'Ok\'';
			if (!$this->isEmpty($this->fields_arr['uname']) AND
					strcmp($this->fields_arr['uname'], $this->LANG['search_user_name']) != 0)
		    {
				$this->sql_condition .= 'AND user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' ';
				$this->linkFieldsArray[] = 'uname';
		    }
			if (!$this->isEmpty($this->fields_arr['country']))
		    {
				$this->sql_condition .= 'AND country=\''.addslashes($this->fields_arr['country']).'\' ';
				$this->linkFieldsArray[] = 'country';
		    }
		}


		public function getDurationSelectionOption()
		{
			$doj = '%s';
			$durOption = array('YEAR', 'MONTH', 'WEEK', 'DAY', 'HOUR', 'MINUTE', 'SECOND');
			for ($i=0; $i<sizeof($durOption); $i++)
				{
					$option  = 'IF (TIMESTAMPDIFF('.$durOption[$i].',doj, NOW())>0,CONCAT( TIMESTAMPDIFF('.$durOption[$i].',doj, NOW())," '.$durOption[$i].'"),%s)';
					$doj = sprintf($doj, $option);
				}
			$doj = sprintf($doj, 0);
		die($doj);				//Check it out..
		}


		public function buildTagSearchQuery()
		{
			/*$myFriends = $this->getMyFriends();
			array_push($myFriends, $this->CFG['user']['user_id']);
			sort($myFriends);
			$avoid = implode(',', $myFriends);
			$this->sql_condition = 'user_id NOT IN ('.$avoid.') ';*/
			$this->sql_condition = 'usr_status=\'Ok\'';
			$this->sql_sort = '';

			if (!$this->isEmpty($this->fields_arr['tags']))
			    {
					$this->sql_condition .= ' AND ('.getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'profile_tags', '').') OR (user_name LIKE \'%'.addslashes($this->fields_arr['tags']).'%\')';
					$this->linkFieldsArray[] = 'tags';
			    }
			$this->browseTitle = str_replace('VAR_TAGS_NAME',$this->fields_arr['tags'],$this->LANG['members_title_tag_search']);
		}

		public function getPageTitle()
		{
			return $this->browseTitle;
		}

		public function isAllowNavigationLinks()
			{
				return ($this->showPageNavigationLinks);
			}

		public function isEmpty($value)
		{
			$is_not_empty = is_string($value)?trim($value)=='':empty($value);
			return $is_not_empty;
		}
		/*_parse_tages_member name changed from _parse_tages.(Strict Standards error occures when
			    not chenage this modification. this method name alredy used in parent class so that
				the strict error occurs)*/
		public function _parse_tags_member($tag_string)
		{
				$newwords = array();
				$tag_string = trim($tag_string);

				if ($tag_string == '') {
					// If the tag string is empty, return the empty set.
					return $newwords;
				}
				# Perform tag parsing
				if(get_magic_quotes_gpc()) {
					$query = stripslashes(trim($tag_string));
				} else {
					$query = trim($tag_string);
				}
				$words = preg_split('/(")/', $query,-1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

				$delim = 0;
				foreach ($words as $key => $word)
				{
					if ($word == '"') {
						$delim++;
						continue;
					}

					if (($delim % 2 == 1) && $words[$key - 1] == '"') {
						if((strlen($word)<$this->CFG['admin']['tag_minimum_size']) or (strlen($word)>$this->CFG['admin']['tag_maximum_size']))
						    {
						        continue;
						    }
						$newwords[] = $word;
					} else {
						if((strlen($word)<$this->CFG['admin']['tag_minimum_size']) or (strlen($word)>$this->CFG['admin']['tag_maximum_size']))
						    {
						        continue;
						    }
						$newwords = array_merge($newwords, preg_split('/\s+/', $word, -1, PREG_SPLIT_NO_EMPTY));
					}
				}
				if ($newwords)
				    {
						$temp = array();
				        foreach($newwords as $key=>$value)
							{
								if (strlen($value)>3)
								    {
										$temp[] = $value;
								    }

							}
						$newwords = $temp;
				    }
				return $newwords;
		}


		public function showRelatedTags()
		{
			$relatedTags = $this->relatedTags;
			$url = $this->tagListUrl;
			$tags_arr = array();
			$inc = 0;

				if (is_array($relatedTags) and $relatedTags )
				    {
				        foreach($relatedTags as $key=>$value)
							{
							if((strlen($value)<$this->CFG['admin']['tag_minimum_size']) or (strlen($value)>$this->CFG['admin']['tag_maximum_size']))
							    {
							        continue;
							    }

							 	 $tags_arr[$inc]['tags']=$value;
							 	 $inc++;
							}
				    }
			 return $tags_arr;
		}

		public function chkIsValidUser($user_id='')
		{
			$sql = 'SELECT user_name FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id).' AND usr_status=\'Ok\' ';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($user_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$row = array();
			$this->isValidUser = ($rs->PO_RecordCount() > 0);
    		if($row = $rs->FetchRow())
				$this->user_name=$row['user_name'];
			return $this->isValidUser;
		}

		public function getValueFromArray($array=array(), $index='', $comma=false)
		{
			$value = '';
			if($comma)
			{
				$index_arr = explode(',', $index);
				foreach($index_arr as $index_key=>$index_value)
				{
					$index_value = trim($index_value);
					if (is_array($array) and isset($array[$index_value]))
				    {
				        $value .= $array[$index_value].', ';
				    }
				}
				$value = substr($value, 0, strrpos($value, ','));
			}
			else
			{
				if (is_array($array) and isset($array[$index]))
			    {
			        $value = $array[$index];
			    }
			}
			return $value;
		}

	}
//<<<<<---------------class MemberListHandler------///
//--------------------Code begins-------------->>>>>//
$fanslist = new MemberListHandler();

$fanslist->setPageBlockNames(array('msg_form_info', 'form_list_members'));
// To set the DB object
$fanslist->setDBObject($db);
$fanslist->makeGlobalize($CFG, $LANG);
$fanslist->setFormField('user_id', $CFG['user']['user_id']);

$fanslist->setFormField('numpg', $CFG['admin']['members_list']['num_pg']);
$fanslist->setFormField('start', '0');

$fanslist->setMinRecordSelectLimit(2);
$fanslist->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$fanslist->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$fanslist->setTableNames(array($CFG['db']['tbl']['users'].' as u LEFT JOIN '.$CFG['db']['tbl']['artist_fans_list'].' as af ON af.fan_id=u.user_id'));
$fanslist->setReturnColumns(array('user_id', 'user_name', 'icon_id','sex', 'icon_type', 'image_ext' , 'doj', 'country','profile_tags'));
$fanslist->setFormField('browse', '');
$fanslist->setFormField('user_id', '');
$fanslist->setFormField('artist_id', '');
$fanslist->setFormField('tags', '');
$fanslist->setFormField('action', '');
$fanslist->setFormField('uname', $LANG['search_user_name']);
$fanslist->setFormField('sex', $LANG['members_search_sex']);
$fanslist->setFormField('ucity', $LANG['search_ucity']);
$fanslist->setFormField('uhometown', $LANG['search_uhometown']);
$fanslist->setFormField('country', '');
$fanslist->setFormField('countries', $LANG_LIST_ARR['countries']);
$fanslist->setCountriesListArr($LANG_LIST_ARR['countries'],
									array('' => $LANG['search_country_choose'])
									);

$fanslist->showRelatedTags = false;
$validuser = true;

$fanslist->stats_display_as_text = true;
if(count($CFG['site']['modules_arr'])>1)
	$fanslist->stats_display_as_text = false;

$fanslist->sanitizeFormInputs($_REQUEST);
if($fanslist->getFormField('artist_id')=='' OR !$fanslist->isValidArtistMemberID())
{
	$validuser = false;
	$fanslist->setAllPageBlocksHide();
	$fanslist->setCommonErrorMsg($LANG['fanslist_invalid_artist_id']);
	$fanslist->setPageBlockShow('block_msg_form_error');
}


if($fanslist->getFormField('browse') == 'mostActiveUsers')
	{
		if(!$fanslist->getFormField('action')) $fanslist->setFormField('action', '0');
		$sub_page = 'mostActiveUsers_'.$fanslist->getFormField('action');
		$membersRightNavigation_arr[$sub_page] = ' class="clsActiveTabNavigation"';
	}

if($fanslist->getFormField('browse')=='viewedusers')
	 $validuser=$fanslist->chkIsValidUser($fanslist->getFormField('user_id'));

if($validuser)
	{
		$fanslist->setReturnColumnsAliases(array(
			'logged_in_currently'		=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
			'doj' => 'DATE_FORMAT(doj, \''.$CFG['format']['date'].'\')',
			'tag_match' => '1'
			)
		);
		$tags = $fanslist->getFormField('tags');
		$tags = trim($tags);
		if ($tags)
		    {
		        $fanslist->buildTagSearchQuery();
				$fanslist->setReturnColumnsAliases(array(
						'logged_in_currently'		=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
						'doj' => 'DATE_FORMAT(doj, \''.$CFG['format']['date'].'\')',
							'tag_match' => getSearchRegularExpressionQueryModified($fanslist->getFormField('tags'), 'profile_tags', '')
							)
						);
				$fanslist->showRelatedTags = true;
		    }
		else
			{
				$fanslist->buildConditionQuery();
				$fanslist->buildSortQuery();
			}

		$fanslist->buildSelectQuery();
		$fanslist->buildQuery();

		$group_array = array('mostActiveUsers');
		if(in_array($fanslist->getFormField('browse'), $group_array))
			$fanslist->homeExecuteQuery();
		else
			$fanslist->executeQuery();

		//$fanslist->printQuery();

		$fanslist->totalResults = $fanslist->getResultsTotalNum();
		$fanslist->setPageBlockShow('form_list_members');

		$start = $fanslist->getFormField('start');
		$resultTotal = $fanslist->getResultsTotalNum();
		if (($start > $resultTotal) OR (!is_numeric($start)))
	        {
	            $fanslist->setIndirectFormField('start', intval($resultTotal / $CFG['data_tbl']['numpg'])*$CFG['data_tbl']['numpg']);
				$fanslist->buildSelectQuery();
				$fanslist->buildConditionQuery();
				$fanslist->buildSortQuery();
				$fanslist->buildQuery();
				$fanslist->executeQuery();
				//$fanslist->printQuery();
	        }
	}

//--------------------Page block templates begins-------------------->>>>>//
$fanslist->form_list_members['page_title']=$fanslist->getPageTitle();
if (isset($_SESSION['friend_request_message']) and !empty($_SESSION['friend_request_message']))
    {
        $fanslist->setPageBlockShow('block_msg_form_success');
		$fanslist->setCommonSuccessMsg($_SESSION['friend_request_message']);
		unset($GLOBALS['_SESSION']['friend_request_message']);
    }

if ($fanslist->isShowPageBlock('form_list_members'))
	{
		$fanslist->gender_arr = array_merge(array('All'=>$LANG['members_search_sex']), $LANG_LIST_ARR['gender']);
		$fanslist->gender_arr = array_merge($fanslist->gender_arr, array(''=>$LANG['search_sex_option_both']));


		$fanslist->form_list_members['display_members'] = $fanslist->displayMembers();
		$paging_arr=array('browse', 'user_id', 'action');
		$smartyObj->assign('smarty_paging_list', $fanslist->populatePageLinksGET($fanslist->getFormField('start'), $paging_arr));

		if ($fanslist->showRelatedTags)
		    {
		        $fanslist->form_list_members['related_tags']=$fanslist->showRelatedTags();
		    }
	}
if ($fanslist->isFormPOSTed($_POST, 'search_reset'))
	{
		$fanslist->setFormField('uname', $LANG['search_user_name']);
		$fanslist->setFormField('sex', $LANG['members_search_sex']);
		$fanslist->setFormField('ucity', $LANG['search_ucity']);
		$fanslist->setFormField('uhometown', $LANG['search_uhometown']);
		$fanslist->setFormField('country', '');
		Redirect2URL(getUrl('fanslist','?artist_id='.$fanslist->getFormField('artist_id'),'?artist_id='.$fanslist->getFormField('artist_id'),'','music'));
	}

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$fanslist->includeHeader();
//include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('fansList.tpl');
?>
<script type="text/javascript" language="javascript">
var popup_info_left_position = '<?php echo $CFG['admin'][$CFG['html']['template']['default']]['members_list_popupinfo_left']; ?>';
var popup_info_top_position = '<?php echo $CFG['admin'][$CFG['html']['template']['default']]['members_list_popupinfo_top']; ?>';
var form_name_array = new Array('membersAdvancedFilters');
<?php
if(($fanslist->getFormField('uname') != '' AND strcmp($fanslist->getFormField('uname'), $LANG['search_user_name']) != 0)
	OR (strcmp($fanslist->getFormField('sex'), $LANG['members_search_sex']) != 0)
	OR ($fanslist->getFormField('ucity') != '' AND strcmp($fanslist->getFormField('ucity'), $LANG['search_ucity']) != 0)
	OR ($fanslist->getFormField('uhometown') != '' AND strcmp($fanslist->getFormField('uhometown'), $LANG['search_uhometown']) != 0)
	OR ($fanslist->getFormField('country') != ''))
		{
			echo "divShowHide('advanced_search', 'show_link', 'hide_link');";
		}
?>
</script>
<?php
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$fanslist->includeFooter();
?>
