<?php
/**
 * This file Lists all the members in our Rayzz
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-01
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/membersBrowse.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class MemberListHandler-------------------->>>
/*
 *
 * @category	Rayzz
 * @package		Members
 * @author 		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-05-01
 */
class MemberListHandler extends ListRecordsHandler
	{
		private $browseTitle = '';

		/**
		 * MemberListHandler::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				$sort_result = $this->fields_arr['sort_result'];
				if (strcmp($sort_result, 'last_active')==0)
					{
				 		$this->sql_sort .= ' last_active DESC ';
				    }
				else if (strcmp($sort_result, 'doj')==0)
			        {
			            $this->sql_sort .= ' user_id DESC ';
			        }
				else if (strcmp($sort_result, 'last_logged')==0)
			        {
			            $this->sql_sort .= ' last_logged DESC ';
			        }
				else if (strcmp($sort_result, 'distance')==0)
			        {
			            $this->sql_sort .= ' last_active DESC ';
			        }
			}

		/**
		 * MemberListHandler::storeCriteriaOptions()
		 *
		 * @param array $requiredFields
		 * @return
		 */
		public function storeCriteriaOptions($requiredFields=array())
			{
				$storedOptions = array();
				foreach($requiredFields as $key=>$value)
					{
						$storedOptions[$value] = $this->fields_arr[$value];
					}
				$options  = serialize($storedOptions);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET browse_criteria='.$this->dbObj->Param($options).
						' WHERE user_id='.$this->dbObj->Param('user_id');
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($options, $this->CFG['user']['user_id']));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * MemberListHandler::getCriteriaOptions()
		 *
		 * @return
		 */
		public function getCriteriaOptions()
			{
				$return = array();
				$sql = 'SELECT browse_criteria FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$return = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$criteria = $row['browse_criteria'];
						if (is_string($criteria) and !empty($criteria))
						    {
								$return = unserialize($criteria);
								if (!is_array($return))
								    {
										$return = array();
								    }
						    }
				    }
				return $return;
			}

		/**
		 * MemberListHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = 'usr_status=\'Ok\'';
				$this->sql_sort = '';

				$relationStatus = $this->fields_arr['relation_status'];
				if ($relationStatus)
				    {
				        $this->sql_condition .= ' AND relation_status IN (\''.implode( '\',\'', $relationStatus).'\')';
				    }

				$gender = $this->fields_arr['gender'];
				if ($this->fields_arr['user_with_photos'])
				    {
				        $this->sql_condition .= ' AND icon_id>0';
				    }
				if (strcmp($gender, 'male')==0)
				    {
				        $this->sql_condition .= ' AND sex=\'male\'';
				    }
				if (strcmp($gender, 'female')==0)
				    {
				        $this->sql_condition .= ' AND sex=\'female\'';
				    }
				$agePreference = $this->fields_arr['age_prefer'];
				if ($agePreference)
				    {
						$ageStart = $this->fields_arr['age_start'];
						if ($ageStart)
						    {
						        $this->sql_condition .= ' AND age >= '.$ageStart;
						    }

						$ageEnd = $this->fields_arr['age_end'];
						if ($ageEnd)
						    {
						        $this->sql_condition .= ' AND age <='.$ageEnd;
						    }
				    }

				$country = $this->fields_arr['country'];
				if ($country)
				    {
				        $this->sql_condition .= ' AND country=\''.$country.'\'';
				    }
				if($this->personalInfoSearch())
				    {
				    	$this->sql_condition.= ' AND (user_id IN ( SELECT user_id  FROM '.$this->CFG['db']['tbl']['users_profile_info'].' WHERE '.$this->personalInfoSearch().' ))';
				    }
			}

		/**
		 * MemberListHandler::personalInfoSearch()
		 *
		 * @return
		 */
		public function personalInfoSearch()
			{
		   	 	$question_ids=$this->fields_arr['question_ids'];
		   	 	$question_ids_arr=explode(',',$question_ids);
		   	 	$sql_condition='';
		   	 	$and_cond_chk=0;
		   	 	$and_cond='';

		   	 	foreach($question_ids_arr as $value)
		   	 		{
		   	 			$search_list=(isset($this->fields_arr[$value])?$this->fields_arr[$value]:array());
				  		if (is_array($search_list) and $search_list)
					 		{
					 			if($and_cond_chk!=0)
				        			$and_cond='AND';
								$search_list_values = implode('\',\'', $search_list);
								if($and_cond_chk==0)
									{
							        	$sql_condition .= ' '.$and_cond.' (question_id ='.$value.' AND answer IN (\''.$search_list_values.'\'))';
									}
								else
									{
										$sql_condition .= ' AND user_id IN ( SELECT user_id FROM '.$this->CFG['db']['tbl']['users_profile_info'].' WHERE question_id ='.$value.' AND answer IN (\''.$search_list_values.'\'))';
									}
						        $and_cond_chk++;
					 		}
					 	else if($search_list)
					 		{
					 			if($and_cond_chk!=0)
				        			$and_cond='AND';
								if($and_cond_chk==0)
									{
							        	$sql_condition .= ' '.$and_cond.' (question_id ='.$value.' AND answer LIKE \'%'.$search_list.'%\')';
									}
								else
									{
										$sql_condition .= ' AND user_id IN ( SELECT user_id FROM '.$this->CFG['db']['tbl']['users_profile_info'].' WHERE question_id ='.$value.' AND answer LIKE \'%'.$search_list.'%\')';
									}
						        $and_cond_chk++;
							}
		   	    	}
		   	  return $sql_condition;
		   }

		/**
		 * MemberListHandler::showOptionButtonList()
		 *
		 * @param mixed $list_array
		 * @param mixed $field_name
		 * @param array $firstArray
		 * @param array $lastArray
		 * @return
		 */
		public function showOptionButtonList($list_array, $field_name, $firstArray=array(), $lastArray = array())
			{
				$list_array = $firstArray + $list_array + $lastArray;
				if (empty($list_array))
				    {
				        return;
				    }
				$count = 0;
				$checkBox_arr = array();
				$inc = 0;
				foreach($list_array as $key=>$desc)
					{
						$id = $field_name. '_' .($count++);
						$checked = (strcmp($key, $this->fields_arr[$field_name])==0)?'checked="checked"':'';
						$checkBox_arr[$inc]['id'] = $id;
						$checkBox_arr[$inc]['values'] = $key;
						$checkBox_arr[$inc]['description'] = $desc;
						$checkBox_arr[$inc]['field_name'] = $field_name;
						$checkBox_arr[$inc]['checked'] = $checked;
						$inc++;
					}
				return $checkBox_arr;
			}

		/**
		 * MemberListHandler::showCheckBoxList()
		 *
		 * @param mixed $list_array
		 * @param mixed $field_name
		 * @return
		 */
		public function showCheckBoxList($list_array, $field_name)
			{
				if (empty($list_array))
				    {
				        return;
				    }
				$count = 0;
				$checkBox_arr = array();
			    $inc = 0;
				foreach($list_array as $key=>$desc)
					{
						if(empty($key))
							continue;
						$id = $field_name.'_id_'.($count++);
						$checked = (in_array($key, $this->fields_arr[$field_name]))?'checked="checked"':'';
						$checkBox_arr[$inc]['checked'] = $checked;
						$checkBox_arr[$inc]['id'] = $id;
						$checkBox_arr[$inc]['values'] = $key;
						$checkBox_arr[$inc]['description'] = $desc;
						$checkBox_arr[$inc]['field_name'] = $field_name;
						$inc++;
					}
				return $checkBox_arr;
			}

		/**
		 * MemberListHandler::populateAgeSet()
		 *
		 * @param string $fieldName
		 * @param integer $startNo
		 * @param integer $endNo
		 * @return
		 */
		public function populateAgeSet($fieldName='', $startNo=5, $endNo=95)
			{
				$value = $this->getFormField($fieldName);
				$ageSet_arr = array();
				$inc = 0;

				for ( $i = $startNo; $i <= $endNo; $i++)
					{
						$selected = ($i==$value)?'selected="selected"':'';
						$ageSet_arr[$inc]['values'] = $i;
						$ageSet_arr[$inc]['selected'] = $selected;
						$inc++;
					}
				return $ageSet_arr;
			}

		/**
		 * MemberListHandler::populateHtmlFields()
		 *
		 * @return
		 */
		public function populateHtmlFields()
			{
				$non_display_question_types = array('text','password','textarea');
				$sql_cat = 'SELECT id AS cat_id, title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
							' WHERE status = \'Yes\' AND search_field_status = \'Yes\'';
				$stmt_cat = $this->dbObj->Prepare($sql_cat);
				$rs_cat = $this->dbObj->Execute($stmt_cat);
				if (!$rs_cat)
					    trigger_db_error($this->dbObj);
				$return_html_field_arr = array();
				$cat_cnt = 0;
				while($row_cat = $rs_cat->FetchRow())
					{

						$sql = 'SELECT id,form_id,question,question_type,rows,order_no,width,instruction,options,answer_required,error_message,default_value,max_length,display'.
								' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
								' WHERE form_id = '.$row_cat['cat_id'].
								' ORDER BY order_no';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

					    $html_field_arr = array();
					    $inc=0;
						while($row = $rs->FetchRow())
							{
								if(!in_array($row['question_type'],$non_display_question_types)){
									$html_field_arr[$inc]['id'] = $row['id'];
									$html_field_arr[$inc]['form_id'] = $row['form_id'];
									$html_field_arr[$inc]['question'] = $row['question'];
									if($row['question_type']=='text')
										{
										  	$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
										  	$html_field_arr[$inc]['answer_result']='';
										}
									if($row['question_type']=='textarea')
										{
										  	$html_field_arr[$inc]['rows'] = !empty($row['rows'])?$rows['rows']:3;
										  	$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
										  	$html_field_arr[$inc]['answer_result']='';
										}
									if($row['question_type']=='password')
										{
											$html_field_arr[$inc]['width']=(!empty($row['width'])?'width:'.intval($row['width']).'px;':'');
										   	$html_field_arr[$inc]['answer_result']='';
										}
									if($row['question_type']=='select')
										{
										  	$explode_arr = explode("\n", $row['options']);
										  	$option_arr=array();
											foreach($explode_arr as $key=>$value)
												{
													if(strlen(trim($value)))
														{
														    $option_arr[$value]=$value;
														}
												}
										  	$html_field_arr[$inc]['option_arr']=$option_arr;
										  	$html_field_arr[$inc]['answer_result']='';

										}
									if($row['question_type']=='checkbox')
										{
										  	$html_field_arr[$inc]['display']=($row['display']=='vertical'?'<br>':'');
										  	$html_field_arr[$inc]['option_arr'] = explode("\n", $row['options']);
										  	$chk=0;
											foreach($html_field_arr[$inc]['option_arr'] as $value)
												{
													if(strlen(trim($value)))
														{

														   	 $answer_result='';
														    $html_field_arr[$inc][$value]=($value == $answer_result?'checked="checked"':'');
														    $chk++;
														}
												}
										}
									if($row['question_type']=='radio')
										{
											$html_field_arr[$inc]['display']=($row['display']=='vertical'?'<br>':'');
										    $html_field_arr[$inc]['option_arr'] = explode("\n", $row['options']);
										    foreach($html_field_arr[$inc]['option_arr'] as $value)
												{
													if(strlen(trim($value)))
														{
												 		  	$answer_result='';
														    $html_field_arr[$inc][$value]=($value == $answer_result?'checked="checked"':'');
														}
												}
										}
									$html_field_arr[$inc]['id'] = $row['id'];
									$html_field_arr[$inc]['question_type'] = $row['question_type'];
									$html_field_arr[$inc]['instruction'] = $row['instruction'];
									$html_field_arr[$inc]['options'] = $row['options'];
									$html_field_arr[$inc]['answer_required'] = $row['answer_required'];
									$html_field_arr[$inc]['max_length'] = $row['max_length'];
									$html_field_arr[$inc]['default_value'] = $row['default_value'];
									$html_field_arr[$inc]['instruction'] = $row['instruction'];
									$html_field_arr[$inc]['label_cell_class']=$this->getCSSFormLabelCellClass($row['question']);
									$html_field_arr[$inc]['field_cell_class']=$this->getCSSFormFieldCellClass($row['question']);
									$this->setFormFieldErrorTip($row['question'],$row['error_message']);
									$inc++;
								}
							}
						if($inc)
							{
								$return_html_field_arr[$cat_cnt]['questions'] = $html_field_arr;
								$return_html_field_arr[$cat_cnt]['cat_id'] = $row_cat['cat_id'];
								$return_html_field_arr[$cat_cnt]['title'] = $row_cat['title'];
								$cat_cnt++;
							}
					}
				return $return_html_field_arr;
			}

		/**
		 * MemberListHandler::getCurrentUserOnlineStatus()
		 *
		 * @param string $privacy
		 * @param string $status_msg_id
		 * @return
		 */
		public function getCurrentUserOnlineStatus($privacy='', $status_msg_id='')
			{
				$currentStatus = $this->LANG['members_browse_online_status_default'];
				$Online = $Offline = $Custom = false;
				if ($privacy)
				    {
				        $$privacy = true;
				    }
				if ($Online)
				    {
						$currentStatus = $this->LANG['members_browse_online_status_online'];
				    }
				elseif($Offline)
					{
						$currentStatus = $this->LANG['members_browse_online_status_offline'];
					}
				elseif($Custom AND $status_msg_id)
					{
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
								' WHERE status_msg_id='.$this->dbObj->Param($status_msg_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($status_msg_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								$currentStatus = $row['message'];
								$rs->Free();
						    }
					}
				return $currentStatus;
			}

		/**
		 * MemberListHandler::displayMembers()
		 *
		 * @return
		 */
		public function displayMembers()
			{
				global $LANG_LIST_ARR;
				$usersPerRow = 5;
				$count = 0;
				$found = false;
				$this->listDetails =  true;
				$this->friendsCount = true;
				$videoCount = chkAllowedModule(array('video'));
				$showVideoIcon = $this->CFG['admin']['members_listing']['video_icon'];
				$showOnlineIcon = $this->CFG['admin']['members_listing']['online_icon'];
				$showOnlineStatus = $this->CFG['admin']['members_listing']['online_status'];
				$member_list_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$found = true;
						if(isMember())
							{
								$member_list_arr[$inc]['friend'] = '';
								$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
										' WHERE (friend_id='.$this->dbObj->Param('friend_id1').
										' AND owner_id='.$this->dbObj->Param('owner_id1').')';
								$fields_val_arr = array($row['user_id'], $this->CFG['user']['user_id']);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $fields_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								if ($rs->PO_RecordCount())
									{
										$member_list_arr[$inc]['friend'] = 'yes';
								    }
							}
						$joined = 0;
						$member_list_arr[$inc]['profileIcon'] = getMemberAvatarDetails($row['user_id']);
						$member_list_arr[$inc]['online'] = ($row['logged_in'])?$this->CFG['admin']['members']['online_anchor_attributes']:$this->CFG['admin']['members']['offline_anchor_attributes'];
						$member_list_arr[$inc]['open_tr'] = false;
						$member_list_arr[$inc]['online'] = $this->CFG['admin']['members']['offline_anchor_attributes'];
						$member_list_arr[$inc]['currentStatus'] = $this->LANG['members_list_offline_status_default'];
						$member_list_arr[$inc]['onlineStatusClass'] = 'memListUserStatusOffline';
						if ($count%$usersPerRow==0)
						    {
						   	   $member_list_arr[$inc]['open_tr'] = true;
						    }
						if ($showOnlineIcon AND $row['logged_in'])
						    {
						        $member_list_arr[$inc]['currentStatus'] = $this->getCurrentUserOnlineStatus($row['privacy'], $row['status_msg_id']);
								$onlineAnchorAttr = $this->CFG['admin']['members']['online_anchor_attributes'];
								$member_list_arr[$inc]['online'] = str_replace('{online_status}', $member_list_arr[$inc]['currentStatus'], $onlineAnchorAttr);
								if($member_list_arr[$inc]['currentStatus']!='Offline')
									{
										$member_list_arr[$inc]['onlineStatusClass'] = 'memListUserStatusOnline';
									}
						    }
							$member_list_arr[$inc]['userLink']= '';
			                //To display stats in images
			                foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
			                    {
			                        $member_list_arr[$inc][$value.'ListUrl'] = '';
			                        if(chkAllowedModule(array(strtolower($value))))
			                            {
			                                $image_url1 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_icon_mini.jpg';
			                                $image_url2 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_no_icon_mini.jpg';
			                                $member_list_arr[$inc][$value.'_image1_exists'] = false;
			                                if(is_file($image_url1))
			                                    $member_list_arr[$inc][$value.'_image1_exists'] = true;

			                                $member_list_arr[$inc][$value.'_image2_exists'] = false;
			                                if(is_file($image_url2))
			                                    $member_list_arr[$inc][$value.'_image2_exists'] = true;
			                                $function_name = 'getTotal'.ucfirst($value).'s';
			                                if(function_exists($function_name))
			                                    {
			                                        $stats = $function_name($row['user_id']);
			                                        $member_fulldetails_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
			                                        $member_list_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
			                                        $member_list_arr[$inc][$value.'_icon_title'] = sprintf($this->CFG['admin']['members'][$value.'_icon_title'], $stats);
			                                        if ($value == 'discussions') {
			                                            $member_list_arr[$inc][$value.'ListUrl'] = getUrl($value,'?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
			                                        }
			                                        else
			                                            $member_list_arr[$inc][$value.'ListUrl'] = getUrl($value.'list','?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
			                                    }
			                            }
			                    }
						if (chkAllowedModule(array('video')) AND $showVideoIcon AND $videoCount AND ($row['total_videos'] > 0))
						    {
								$title = sprintf($this->CFG['admin']['members']['video_icon_title'], $row['total_videos']);
								$videoListUrl =  getUrl('videolist','?pg=uservideolist&user_id='.$row['user_id'], 'uservideolist/?user_id='.$row['user_id'],'','video');
						     	$member_list_arr[$inc]['videoLink'] = '&nbsp;<a class="videoIcon" href="'.$videoListUrl.'" title="'.$title.'"><img src="'.$this->CFG['admin']['members']['video_icon'].'" /></a>';
						    }
						else
						 	{
						   		$title = sprintf($this->CFG['admin']['members']['video_icon_title'], $row['total_videos']);
						   		$member_list_arr[$inc]['videoLink'] = '&nbsp;<a class="videoIcon"  title="'.$title.'"><img src="'.$this->CFG['admin']['members']['no_video_icon'].'" /></a>';
						 	}
						$member_list_arr[$inc]['friend_icon_title'] = sprintf($this->CFG['admin']['members']['friend_icon_title'], $row['total_friends']);
						$member_list_arr[$inc]['viewfriendsUrl'] = getUrl('viewfriends','?user='.$row['user_name'], $row['user_name'].'/');
						$member_list_arr[$inc]['mailComposeUrl'] = getUrl('mailcompose','?mcomp='.$row['user_name'],'?mcomp='.$row['user_name'], 'members');
						$member_list_arr[$inc]['friendAddUrl'] = getUrl('friendadd','?friend='.$row['user_id'],'?friend='.$row['user_id'], 'members');
						$member_list_arr[$inc]['country'] = isset($LANG_LIST_ARR['countries'][$row['country']])?$LANG_LIST_ARR['countries'][$row['country']]:'';
						$member_list_arr[$inc]['last_logged'] =($row['last_logged']!='')?$row['last_logged']:$this->LANG['members_browse_member_first_login'];
						$member_list_arr[$inc]['record']=$row;
						$member_list_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$member_list_arr[$inc]['end_tr'] = false;
						$count++;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$member_list_arr[$inc]['end_tr'] = true;
						    }
						 $inc++;
					}//while
				$this->final_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
					{
						$this->final_tr_close  = true;
						$this->member_per_row=$usersPerRow-$count;
					}
				return $member_list_arr;
			}

		/**
		 * MemberListHandler::displayMembersWithFullDetails()
		 *
		 * @return
		 */
		public function displayMembersWithFullDetails()
			{
				$usersPerRow = 5;
				$count = 0;
				$this->resultFound =  $found = false;

				$videoCount = chkAllowedModule(array('video'));
				$showVideoIcon = $this->CFG['admin']['members_listing']['video_icon'];
				$member_fulldetails_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$this->resultFound = 	$found = true;
						$joined = 0;
						$member_fulldetails_arr[$inc]['profileIcon'] = getMemberAvatarDetails($row['user_id']);
						$member_fulldetails_arr[$inc]['online'] = ($row['logged_in'])?$this->CFG['admin']['members']['online_anchor_attributes']:'';
						$member_fulldetails_arr[$inc]['opentr'] = false;
						if ($count%$usersPerRow==0)
						    {
						   	   $member_fulldetails_arr[$inc]['opentr'] = true;
						    }
						//To display stats in images
			                foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
			                    {
			                        $member_fulldetails_arr[$inc][$value.'ListUrl'] = '';
			                        if(chkAllowedModule(array(strtolower($value))))
			                            {
			                                $image_url1 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_icon_mini.jpg';
			                                $image_url2 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'_no_icon_mini.jpg';
			                                $member_fulldetails_arr[$inc][$value.'_image1_exists'] = false;
			                                if(is_file($image_url1))
			                                    $member_fulldetails_arr[$inc][$value.'_image1_exists'] = true;

			                                $member_fulldetails_arr[$inc][$value.'_image2_exists'] = false;
			                                if(is_file($image_url2))
			                                    $member_fulldetails_arr[$inc][$value.'_image2_exists'] = true;
			                                $function_name = 'getTotal'.ucfirst($value).'s';
			                                if(function_exists($function_name))
			                                    {
			                                        $stats = $function_name($row['user_id']);
			                                        $member_fulldetails_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
			                                        $member_fulldetails_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
			                                        $member_fulldetails_arr[$inc][$value.'_icon_title'] = sprintf($this->CFG['admin']['members'][$value.'_icon_title'], $stats);
			                                        if ($value == 'discussions') {
			                                            $member_fulldetails_arr[$inc][$value.'ListUrl'] = getUrl($value,'?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
			                                        }
			                                        else
			                                            $member_fulldetails_arr[$inc][$value.'ListUrl'] = getUrl($value.'list','?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
			                                    }
			                            }
			                    }
						$member_fulldetails_arr[$inc]['videoLink'] = '<img src="'.$this->CFG['admin']['members']['no_video_icon'].'" />';
						if (chkAllowedModule(array('video')) AND $showVideoIcon AND $videoCount AND ($row['total_videos'] > 0))
						    {
								$title = sprintf($this->CFG['admin']['members']['video_icon_title'], $row['total_videos']);
								$videoListUrl = getUrl('videolist','?pg=uservideolist&user_id='.$row['user_id'], 'uservideolist/?user_id='.$row['user_id'],'','video');
						     	$member_fulldetails_arr[$inc]['videoLink'] = '&nbsp;<a class="videoIcon" href="'.$videoListUrl.'" title="'.$title.'"><img src="'.$this->CFG['admin']['members']['video_icon'].'" /></a>';
						    }
						 else
							 {
								$title = sprintf($this->CFG['admin']['members']['video_icon_title'], $row['total_videos']);
								$member_fulldetails_arr[$inc]['videoLink'] = '&nbsp;<a class="videoIcon"  title="'.$title.'"><img src="'.$this->CFG['admin']['members']['no_video_icon'].'" /></a>';
							 }
						$member_fulldetails_arr[$inc]['records']=$row;
						$member_fulldetails_arr[$inc]['memberProfileLink'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$member_fulldetails_arr[$inc]['friend_icon_title'] = sprintf($this->CFG['admin']['members']['friend_icon_title'], $row['total_friends']);
						$member_fulldetails_arr[$inc]['viewfriendsUrl'] = getUrl('viewfriends','?user='.$row['user_name'], $row['user_name'].'/');
						$member_fulldetails_arr[$inc]['endtr'] = false;
						foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
					    	{
								if(chkAllowedModule(array(strtolower($value))))
									{
										$image_url1 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'-in.jpg';
										$image_url2 = $this->CFG['site']['project_path'].'design/templates/'.$this->CFG['html']['template']['default'].'/images/'.$value.'-no.jpg';
										$member_fulldetails_arr[$inc][$value.'_image1_exists'] = false;
										if(is_file($image_url1))
											$member_fulldetails_arr[$inc][$value.'_image1_exists'] = true;

										$member_fulldetails_arr[$inc][$value.'_image2_exists'] = false;
										if(is_file($image_url2))
											$member_fulldetails_arr[$inc][$value.'_image2_exists'] = true;

										$function_name = 'getTotal'.ucfirst($value).'s';
										$stats = $function_name($row['user_id']);
										$member_fulldetails_arr[$inc]['total_'.strtolower($value).'s'] = $stats;
										$member_fulldetails_arr[$inc][$value.'_icon_title'] = sprintf($this->CFG['admin']['members'][$value.'_icon_title'], $stats);
										$member_fulldetails_arr[$inc][$value.'ListUrl'] = getUrl($value.'list','?pg=user'.$value.'list&user_id='.$row['user_id'], 'user'.$value.'list/?user_id='.$row['user_id'],'',$value);
									}
							}

						$count++;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$member_fulldetails_arr[$inc]['endtr'] = true;
						    }
						$inc++;
				    } // while
				$this->last_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
				    {
						$this->last_tr_close  = true;
						$this->user_per_row=$usersPerRow-$count;
				    }
				return $member_fulldetails_arr;
			}

		/**
		 * MemberListHandler::populateHeightFeetArray()
		 *
		 * @param integer $start_no
		 * @param integer $end_no
		 * @param string $highLight
		 * @return
		 */
		public function populateHeightFeetArray($start_no=3, $end_no=7, $highLight='')
			{
			   	$heightFeet_arr = array();
				$inc = 0;
				for($i=$start_no; $i<=$end_no; $i++)
					{
						$selected = (strcmp($i, $highLight)==0)?'selected="selected"':'';
						$heightFeet_arr[$inc]['values'] = $i;
						$heightFeet_arr[$inc]['selected'] = $selected;
						$inc++;
					}
				return $heightFeet_arr;
			}

		/**
		 * MemberListHandler::getMyFriends()
		 *
		 * @return
		 */
		public function getMyFriends()
			{
				$currentUserId = $this->CFG['user']['user_id'];
				$sql = 'SELECT friend_id as myFriend FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param($currentUserId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$friends = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
							    $friends[] = $row['myFriend'];
						    } // while
					}
				return $friends;
			}

		/**
		 * MemberListHandler::multiSelectPopulateArray()
		 *
		 * @param mixed $list
		 * @param string $highlight_value
		 * @return
		 */
		public function multiSelectPopulateArray($list, $highlight_value='')
			{
			   	$showOption_arr = array();
			    $inc = 0;
				foreach($list as $key=>$value)
					{
						$selected = $highlight_value == trim($key)?'selected="selected"':'';
						$showOption_arr[$inc]['values']=trim($key);
						$showOption_arr[$inc]['selected']=$selected;
						$showOption_arr[$inc]['optionvalue']=$value;
						$inc++;

					}
				return $showOption_arr;
			}
	}
//<<<<<---------------class MemberListHandler------///
//--------------------Code begins-------------->>>>>//
$memberList = new MemberListHandler();

$memberList->setPageBlockNames(array('msg_form_info', 'form_list_members', 'form_browse_criteria','show_result_heading'));
$memberList->setAllPageBlocksHide();

$memberList->setFormField('user_id', $CFG['user']['user_id']);
$memberList->setFormField('numpg', $CFG['admin']['members_list']['num_pg']);
$memberList->setFormField('start', '0');

$memberList->setCountriesListArr($LANG_LIST_ARR['countries'],
							array('' => $LANG['browse']['country_choose'])
							);

$memberList->setCSSAlternativeRowClasses($CFG['data_tbl']['css_alternative_row_classes']);
$memberList->setMinRecordSelectLimit(2);
$memberList->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$memberList->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$memberList->setTableNames(array($CFG['db']['tbl']['users']));
$memberList->setReturnColumns(array('user_id', 'user_name', 'total_videos', 'total_photos', 'icon_id', 'icon_type','image_ext','doj', 'profile_hits', 'total_friends', 'logged_in', 'sex', 'privacy', 'status_msg_id', 'age','dob','country', 'last_logged', 'total_friends'));

$memberList->setFormField('gender', 'both');
$memberList->setFormField('age_prefer', '');
$memberList->setFormField('age_start', '');
$memberList->setFormField('age_end', '');
$memberList->setFormField('country', '');
$memberList->setFormField('show_details', '');
$memberList->setFormField('user_with_photos', '');

$memberList->setFormField('relation_status', array());
$memberList->setFormField('sort_result', 'last_active');
$memberList->setFormField('question_ids', '');
$question_id_arr=array();
//
$memberList->hide_details_checked='';
$memberList->show_details_checked='';
$memberList->sanitizeFormInputs($_REQUEST);

$memberList->hide_details_checked='checked="checked"';
$memberList->show_details_checked='';
if($memberList->getFormField('show_details'))
	{
		$memberList->hide_details_checked='';
		$memberList->show_details_checked='checked="checked"';
	}
$memberList->block_show_htmlfields = $memberList->populateHtmlFields();
if($memberList->block_show_htmlfields){
	foreach($memberList->block_show_htmlfields as $cat_details)
		{

			foreach($cat_details['questions'] as $value)
				{
			   		$memberList->setFormField('gender', 'both');
					$memberList->setFormField('age_prefer', '');
					$memberList->setFormField('age_start', '');
					$memberList->setFormField('age_end', '');
					$memberList->setFormField('country', '');
					$memberList->setFormField('show_details', '');
					$memberList->setFormField('user_with_photos', '');

					$memberList->setFormField('relation_status', array());
					$memberList->setFormField('sort_result', 'last_active');
					$memberList->setFormField('question_ids', '');
					$question_id_arr[] = $value['id'];
				 	if($value['question_type']=='text' || $value['question_type']=='textarea' || $value['question_type']=='password')
						{
						 	$memberList->setFormField($value['id'], $value['answer_result']);
						}
					else if ($value['question_type']=='checkbox' || $value['question_type']=='radio' || $value['question_type']=='select')
						{
							$memberList->setFormField($value['id'], array());
						}
				}
		}
}
$memberList->question_ids=implode(',',$question_id_arr);
$memberList->setPageBlockShow('form_browse_criteria');

$memberList->setFormField('start', 0);
$memberList->setReturnColumnsAliases(array(
			'logged_in'		=> '(logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active)',
			'age' => 'DATE_FORMAT(NOW(), \'%Y\') - DATE_FORMAT(dob, \'%Y\') - (DATE_FORMAT(NOW(), \'00-%m-%d\') < DATE_FORMAT(dob, \'00-%m-%d\'))',
			)
		);

if ($memberList->isPageGETed($_GET, 'start'))
    {
		$memberList->sanitizeFormInputs($_GET);
		$start = $memberList->getFormField('start');
		if (!is_numeric($start))
		    {
				$memberList->setFormField('start', 0);
		    }
		else
			{
				$memberList->setFormField('start', abs($start));
			}
    }
if ($memberList->isFormPOSTed($_POST, 'browse_reset'))
    {
		foreach($memberList->block_show_htmlfields as $value)
			{
				$question_id_arr[]= $value['id'];
				if($value['question_type']=='text' || $value['question_type']=='textarea' || $value['question_type']=='password')
				 	{
						$memberList->setFormField($value['id'], $value['answer_result']);
					}
				else if ($value['question_type']=='checkbox' || $value['question_type']=='radio' || $value['question_type']=='select')
					{
				   		$memberList->setFormField($value['id'], array());
				 	}
			}
	}
if ($memberList->isFormPOSTed($_POST, 'browse_submit'))
    {
		$memberList->sanitizeFormInputs($_POST);
		$requiredFields = array(
								'gender',
								'age_prefer',
								'age_start',
								'age_end',
								'country',
								'show_details',
								'relation_status',
								'user_with_photos' ,
								'sort_result'
								);
		$memberList->storeCriteriaOptions($requiredFields);
		$memberList->setPageBlockShow('show_result_heading');
	}
else if($memberList->isFormGETed($_GET, 'start'))
	{
		$storedOptions = $memberList->getCriteriaOptions();
		$memberList->sanitizeFormInputs($storedOptions);
		$memberList->setPageBlockShow('show_result_heading');
	}
$memberList->buildSelectQuery();
$memberList->buildConditionQuery();
$memberList->buildSortQuery();
$memberList->buildQuery();
//$memberList->printQuery();
$memberList->executeQuery();
$totalResults = $memberList->getResultsTotalNum();
$memberList->resultFound =false;
if ($totalResults)
    {
    	$memberList->resultFound =true;
		$memberList->setPageBlockShow('form_list_members');
    }
else
	{
		$memberList->setPageBlockShow('block_msg_form_alert');
        $memberList->setCommonAlertMsg($LANG['msg_no_records']);
	}
$showDetails = ($memberList->getFormField('show_details'));
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if (isset($_SESSION['friend_request_message']) and !empty($_SESSION['friend_request_message']))
    {
	    $memberList->setPageBlockShow('block_msg_form_alert');
		$memberList->setCommonAlertMsg($_SESSION['friend_request_message']);
		unset($GLOBALS['_SESSION']['friend_request_message']);
    }
if ($memberList->isShowPageBlock('form_browse_criteria'))
    {
		$male = $female = $both = '';
		$gender = $memberList->getFormField('gender');
		$$gender = 'checked="checked"';
		$formAction = getUrl('membersbrowse');
		$memberList->form_browse_criteria['female']=$female;
		$memberList->form_browse_criteria['male']=$male;
		$memberList->form_browse_criteria['both']=$both;
		$agePrefer = $memberList->getFormField('age_prefer');
		$memberList->form_browse_criteria['agePreferNo'] = $agePrefer?'':'checked="checked"';
		$memberList->form_browse_criteria['agePreferYes'] = $agePrefer?'checked="checked"':'';
		$memberList->form_browse_criteria['ageSetStart_arr']=$memberList->populateAgeSet('age_start', $CFG['admin']['members_browse']['age_start'], $CFG['admin']['members_browse']['age_end']);
		$memberList->form_browse_criteria['ageSetEnd_arr']=$memberList->populateAgeSet('age_end', $CFG['admin']['members_browse']['age_start'], $CFG['admin']['members_browse']['age_end']);
		$memberList->form_browse_criteria['relation_status']=$memberList->showCheckBoxList($LANG_LIST_ARR['user_relation_status'], 'relation_status');
		$memberList->form_browse_criteria['showDetails']=($showDetails)?'':'checked="checked"';

		$last_active = $last_logged = $doj = $distance = '';
		$sort_result = $memberList->getFormField('sort_result');
		$$sort_result = 'checked="checked"';
		$memberList->form_browse_criteria['last_active']=$last_active;
		$memberList->form_browse_criteria['last_logged']=$last_logged;
		$memberList->form_browse_criteria['doj']		=$doj;
		$memberList->form_browse_criteria['distance']	=$distance;
    }
if ($memberList->isShowPageBlock('form_list_members'))
	{
		$memberList->form_search_member_arr = array();
		$memberList->form_search_member_arr['hidden_arr'] = array('start', 'browse');
		$memberList->form_browse_criteria['showDetails']=$showDetails;
		$memberList->form_list_members['total']  = $memberList->getResultsTotalNum();
		$memberList->form_list_members['MembersWithFullDetails']='';
		$smartyObj->assign('smarty_paging_list', $memberList->populatePageLinksGET($memberList->getFormField('start')));

		if ($showDetails)
		    {
		        $memberList->form_list_members['MembersWithFullDetails'] = $memberList->displayMembersWithFullDetails();
		    }
		else
			{
				$memberList->form_list_members['displayMembers'] = $memberList->displayMembers();
			}
	}
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$memberList->includeHeader();
?>
<script language="javascript" type="text/javascript">
	showSearchForm = function(){
		searchTable = 'selBrowseCriteria';
		sanchor = 'anchorToggleSearchForm';
			if($Jq('#'+searchTable).is(':visible')){
				$Jq("#"+searchTable).hide();
				$Jq("#"+sanchor).removeClass('clsHideFilterSearch');
				$Jq("#"+sanchor).addClass('clsShowFilterSearch');
				$Jq("#"+sanchor).html('<span><?php echo $LANG['browse']['form_title_anchor_show_search_form'];?></span>')
			} else {
				$Jq("#"+searchTable).show();
				$Jq("#"+sanchor).removeClass('clsShowFilterSearch');
				$Jq("#"+sanchor).addClass('clsHideFilterSearch');
				$Jq("#"+sanchor).html('<span><?php echo $LANG['browse']['form_title_anchor_hide_search_form'];?></span>')
			}
	}
	agePreferOptions = function(){
		ageYes = $Jq('#age_prefer_yes');
		ageNo = $Jq('#age_prefer_no');
		ageStart = $Jq('#age_start');
		ageEnd = $Jq('#age_end');
		if(ageNo.is(':checked')){
			ageStart.val('');
			ageEnd.val('');
		}
		if((ageStart.val() != '') || (ageEnd.val() != '')){
			ageYes.attr('checked', true);
		}
	}
</script>
<?php
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('membersBrowse.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//
//includ the footer of the page
$memberList->includeFooter();
?>
