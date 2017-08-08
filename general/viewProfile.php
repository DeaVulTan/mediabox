<?php
//-------------------------class MyProfileFormHandler ----------------------->>>
/*
 * @category	Rayzz
 * @package MyProfileFormHandler
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class MyProfileFormHandler extends MediaHandler
	{
	  	public $right_arr=true;
	  	public $left_arr=true;
	  	public $isValidUser = false;
	  	public $isCurrentUser = false;
	  	public $showEditableLink = false;
	  	public $this_profileurl_script = '';
	  	public $js_string_data = '';

	  	/**
	  	 * MyProfileFormHandler::chkUserReOrderBlock()
	  	 *
	  	 * @return
	  	 */
	  	public function chkUserReOrderBlock()
			{
				$sql= 'SELECT block_name FROM '.$this->CFG['db']['tbl']['users_profile_block'].
						' WHERE user_id='.$this->dbObj->Param('user_id');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

		 		if($row = $rs->FetchRow())
					return true;
				return false;
		  	}

	  	/**
	  	 * MyProfileFormHandler::getTotalProfileBlock()
	  	 *
	  	 * @return
	  	 */
	  	public function getTotalProfileBlock()
		  	{
		 		$sql = 'SELECT count(block_name) as total_block'.
						' FROM '.$this->CFG['db']['tbl']['profile_block'].
						' WHERE display=\'Yes\' ORDER BY order_no';
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

		 		if($row = $rs->FetchRow())
					return $row['total_block'];
		  	}

		/**
		 * MyProfileFormHandler::chkBlockToDisplay()
		 *
		 * @param mixed $block_name
		 * @return
		 */
		public function chkBlockToDisplay($block_name)
		  	{
		 		$sql = 'SELECT block_name'.
						' FROM '.$this->CFG['db']['tbl']['profile_block'].
						' WHERE display=\'Yes\' AND block_name='.$this->dbObj->Param('block_name');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($block_name));
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

		 		if($row = $rs->FetchRow())
					return true;
				return false;
		  	}

		/**
		 * MyProfileFormHandler::getRemainProfileBlock()
		 *
		 * @param mixed $block_names_arr
		 * @return
		 */
		public function getRemainProfileBlock($block_names_arr)
		  	{
		     	$block_names=array();
		     	$inc=0;
				if(!empty($block_names_arr['left']))
					{
						$block_names_left_arr=$block_names_arr['left'];
				     	foreach($block_names_arr['left'] as $value)
						 	{
						   		$block_names[$inc]= $value['block_name'];
						   		$inc++;
					     	}
					}
				if(!empty($block_names_arr['right']))
					{
						$block_names_right_arr=$block_names_arr['right'];
				     	foreach($block_names_arr['right'] as $value)
						 	{
							   	$block_names[$inc]= $value['block_name'];
							   	$inc++;
					     	}
					}
		     	$block_names=implode('\',\'',$block_names);
		 	 	$sql = 'SELECT module_name,block_name, position, display, order_no'.
						' FROM '.$this->CFG['db']['tbl']['profile_block'].
						' WHERE display=\'Yes\' AND block_name NOT IN (\''.$block_names.'\')'.
						' ORDER BY order_no ASC';
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

				$not_in_user_block_name_arr = array();
		   	 	$inc = 0;
		 		while($row = $rs->FetchRow())
			    	{
			        	$not_in_user_block_name_arr[$inc]['position']=$row['position'];
			          	$not_in_user_block_name_arr[$inc]['block_name']=$row['block_name'];
			          	$not_in_user_block_name_arr[$inc]['module_name']=$row['module_name'];
			          	$not_in_user_block_name_arr[$inc]['order_no']=$row['order_no'];
			          	$inc++;
			        }
				return $not_in_user_block_name_arr;
		  	}

	  	/**
	  	 * MyProfileFormHandler::getProfileBlock()
	  	 *
	  	 * @return
	  	 */
	  	public function getProfileBlock()
	    	{
	      		global $smartyObj;
	      		global $__myProfile;
	       		$this->data_arr='';
	       		if($this->chkUserReOrderBlock())
	        		{
			 			$sql = 'SELECT module_name,block_name, position, order_no'.
								' FROM '.$this->CFG['db']['tbl']['users_profile_block'].
								' WHERE user_id='.$this->dbObj->Param('user_id').
								' ORDER BY order_no ASC';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
						if (!$rs)
					        trigger_db_error($this->dbObj);

					 	$data_arr = array();
					 	$left_inc = 0;
					 	$right_inc = 0;

						while($row = $rs->FetchRow())
				          	{
				          		//check the module
								if($this->chkIsModuleBlockToDisplay($row['module_name']))
									{
										// $user_block_arr=$this->getUserReOrderBlock($row['block_name']);
										if($this->chkBlockToDisplay($row['block_name']))
											 {
												if($row['position'] == 'left')
													{
														$common_inc = $left_inc;
														$left_inc++;
													}
												else
													{
														$common_inc = $right_inc;
														$right_inc++;
													}
												$sel_profile_category = $this->getProfileCategory($row['block_name']);
												$this->data_arr[$row['position']][$common_inc]['block_name'] = $row['block_name'];
												$this->data_arr[$row['position']][$common_inc]['position'] = $row['position'];
												$this->data_arr[$row['position']][$common_inc]['order_no'] = $row['order_no'];
												$this->data_arr[$row['position']][$common_inc]['include_filename']=$this->getIncludeFileName($row['module_name'], $row['block_name'],$sel_profile_category);
												$this->data_arr[$row['position']][$common_inc]['module_folder']=$row['module_name'];
												$this->data_arr[$row['position']][$common_inc]['sel_category'] = $sel_profile_category;
											}// end of chkBlockToDisplay if closed
									}
	                      	}//while;
                      	$left_arr_tot = $right_arr_tot = 0;
                      	if(!empty($this->data_arr['left']))
					  	 	$left_arr_tot=count($this->data_arr['left']);
                      	if(!empty($this->data_arr['right']))
					 		$right_arr_tot=count($this->data_arr['right']);

                     	$tota_user_blocks=$left_arr_tot+$right_arr_tot;

	                 	if($this->getTotalProfileBlock()>$tota_user_blocks)
	                    	{
	                       		foreach($this->getRemainProfileBlock($this->data_arr) as $user_block_arr)
			          	    		{
				          				//check the module
										if($this->chkIsModuleBlockToDisplay($user_block_arr['module_name']))
			          						{
												if($user_block_arr['position']=='left')
													{
														$left_inc++;
														$common_inc = $left_inc;
													}
										 	 	else
										 	 	 	{
										 	 	 		$right_inc++;
													    $common_inc = $right_inc;
													}
												$sel_profile_category = $this->getProfileCategory($user_block_arr['block_name']);
												$this->data_arr[$user_block_arr['position']][$common_inc]['block_name'] = $user_block_arr['block_name'];
												$this->data_arr[$user_block_arr['position']][$common_inc]['position'] = $user_block_arr['position'];
												$this->data_arr[$user_block_arr['position']][$common_inc]['order_no'] = $user_block_arr['order_no'];
												$this->data_arr[$user_block_arr['position']][$common_inc]['include_filename']=$this->getIncludeFileName($user_block_arr['module_name'],$user_block_arr['block_name'],$sel_profile_category);
												$this->data_arr[$user_block_arr['position']][$common_inc]['module_folder']=$user_block_arr['module_name'];
												$this->data_arr[$user_block_arr['position']][$common_inc]['sel_category'] = $sel_profile_category;
											}
                           			}//foreach;

	                   		}//end if $this->getTotalProfileBlock()>$tota_user_blocks

						$this->right_arr = true;
						if($right_inc == 0)
							$this->right_arr = false;

						$this->left_arr = true;
						if($left_inc == 0)
							$this->left_arr = false;

						return $this->data_arr;
					}
				else
					{
				    	$sql = 'SELECT module_name,block_name, position, display, order_no, profile_category_id'.
								' FROM '.$this->CFG['db']['tbl']['profile_block'].
								' WHERE display=\'Yes\' ORDER BY order_no';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
					        trigger_db_error($this->dbObj);

					 	$data_arr = array();
					 	$left_inc = 0;
					 	$right_inc = 0;
						while($row = $rs->FetchRow())
				        	{
				          		//check the module
								if($this->chkIsModuleBlockToDisplay($row['module_name']))
			          				{
						 	 	 		if($row['position']=='left')
						 	 	 			{
						 	 	 				$common_inc = $left_inc;
						 	 	 				$left_inc++;
											}
						 	 	 		else
						 	 	 			{
									    		$common_inc = $right_inc;
									    		$right_inc++;
									    	}
						  	  	  	   	$this->data_arr[$row['position']][$common_inc]['block_name'] = $row['block_name'];
						  	  	  	   	$this->data_arr[$row['position']][$common_inc]['position'] = $row['position'];
						  	  	  	   	$this->data_arr[$row['position']][$common_inc]['display'] = $row['display'];
						  	  	  	   	$this->data_arr[$row['position']][$common_inc]['order_no'] = $row['order_no'];
									   	$this->data_arr[$row['position']][$common_inc]['include_filename']=$this->getIncludeFileName($row['module_name'],$row['block_name'],$row['profile_category_id']);
									   	$this->data_arr[$row['position']][$common_inc]['module_folder']=$row['module_name'];
									   	$this->data_arr[$row['position']][$common_inc]['sel_category'] = $row['profile_category_id'];
									}
							} //while
						$this->right_arr = true;
						if($right_inc == 0)
							$this->right_arr = false;

						$this->left_arr = true;
						if($left_inc == 0)
							$this->left_arr = false;

						return $this->data_arr;
					}//else closed
		    }

		/**
		 * MyProfileFormHandler::getIncludeFileName()
		 *
		 * @param mixed $module
		 * @param mixed $block_tpl_name
		 * @return
		 */
		public function getIncludeFileName($module,$block_tpl_name,$sel_category = 0)
			{
				global $smartyObj;
			   	global $__myProfile;
			   	global $aboutme_tpl;

				$module_path = $module.'/';
			    if($module == 'default')
				  	$module_path = '';

				$include_filename='';
				$this->this_profileurl_script = '';
			   	if(file_exists($this->CFG['site']['project_path'].$module_path.'/general/profile'.ucfirst($module).'Block.php'))
					{
						require_once($this->CFG['site']['project_path'].$module_path.'/general/profile'.ucfirst($module).'Block.php');
						$template = $this->CFG['html']['template']['default'];
						if($module_path != '')
							$template = $this->chkTemplateForModuleAndSwitch($module_path, $this->CFG['html']['template']['default'], $block_tpl_name);

						if(file_exists($this->CFG['site']['project_path'].$module_path.'design/templates/'.$template.'/general/profile'.ucfirst($block_tpl_name).'Block.tpl') || $sel_category)
						  	{
						  		if(isset($this_profileurl_script) && !empty($this_profileurl_script))
									$this->this_profileurl_script = $this_profileurl_script;

								$block_tpl=$block_tpl_name.'_tpl';

								if($sel_category)
									{
										$include_filename = 'profileAllprofileinfoBlock.tpl';
									}
								else if($block_tpl=='aboutme_tpl')
								    {
								   	   	// to chk whether data is available or not var -> boolean -> Fix for empty space
								   	   	$include_filename = '';
									   	if(isset($$block_tpl) && !empty($$block_tpl))
								   	    	$include_filename = 'profile'.ucfirst($block_tpl_name).'Block.tpl';
								    }
								else
									{
										$include_filename = 'profile'.ucfirst($block_tpl_name).'Block.tpl';
									}
				  	  	  	    if(isset($js_string_data) && !empty($js_string_data))
									$this->js_string_data = $js_string_data;
		  	  	  	       	}
		  	  	  	    else
				 	  	  	{
				 			 	$include_filename='';
							}
				    }
				return $include_filename;
			}

		/**
		 * MyProfileFormHandler::getProfileCategory()
		 *
		 * @return
		 */
		public function getProfileCategory($block_tpl_name)
			 {
			 	$sql = 'SELECT profile_category_id FROM '.$this->CFG['db']['tbl']['profile_block'].
				 		' WHERE display = \'Yes\'AND block_name = '.$this->dbObj->Param('title');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($block_tpl_name));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			 	if($row = $rs->FetchRow())
					return $form_id = $row['profile_category_id'];
				return 0;
			 }

		/**
		 * MyProfileFormHandler::updateUsersAgeValue()
		 *
		 * @return
		 */
		public function updateUsersAgeValue()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
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
		 * MyProfileFormHandler::checkUserId()
		 *
		 * @return
		 */
		public function checkUserId()
			{
				$user_id = $this->fields_arr['user_id'];
				$this->isValidUser = false;
				if($row = getUserDetail('user_id', $user_id))
					{
						$this->isValidUser = true;
					}
				$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
				$edit = $this->fields_arr['edit'];
				$edit = (strcmp($edit, '1')==0);
				$this->showEditableLink = ($this->isCurrentUser and $edit);
			}

		/**
		 * MyProfileFormHandler::isValidUserId()
		 *
		 * @return
		 */
		public function isValidUserId()
			{
				return $this->isValidUser;
			}

		/**
		 * MyProfileFormHandler::chkIsAlreadyFriend()
		 *
		 * @return
		 */
		public function chkIsAlreadyFriend()
			{
				$ownerId  = $this->CFG['user']['user_id'];
				$friendId = $this->fields_arr['user_id'];
				$sql = 	'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param($ownerId).
						' AND friend_id='.$this->dbObj->Param($friendId).
					    ' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$isAlreadyFriend = false;
				if ($rs->PO_RecordCount())
					{
						$isAlreadyFriend = true;
				    }
				return $isAlreadyFriend;
			}

		/**
		 * MyProfileFormHandler::getUserDetailsArrFromDB()
		 *
		 * @param mixed $table_name
		 * @param array $fields_arr
		 * @param array $alias_fields_arr
		 * @return
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE user_id='.$this->dbObj->Param($user_id).' AND usr_status=\'Ok\'';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
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
		 * MyProfileFormHandler::chkProfileViewSettings()
		 *
		 * @param mixed $status
		 * @return
		 */
		public function chkProfileViewSettings($status)
			{
				$user_id = $this->fields_arr['user_id'];

				if($this->CFG['user']['user_id'] == $user_id OR $status=='All')
					{
						return true;
					}
				else if($status=='Members' AND isMember())
					{
						return true;
					}
				else if($status == 'Friends')
					{
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE owner_id='.$this->dbObj->Param('owner_id').
								' AND friend_id='.$this->dbObj->Param('friend_id').
								' LIMIT 0, 1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $user_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							return true;
					}
				return false;
			}

		/**
		 * MyProfileFormHandler::setUserId()
		 *
		 * @return
		 */
		public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param($userName).
						' AND usr_status=\'Ok\' LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userName));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
				        $row = $rs->FetchRow();
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->isValidUser = true;
						$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
						$edit = $this->fields_arr['edit'];
						$edit = (strcmp($edit, '1')==0);
						$this->showEditableLink = ($this->isCurrentUser and $edit);
					}
			}

		/**
		 * MyProfileFormHandler::getCurrentUserId()
		 *
		 * @return
		 */
		public function getCurrentUserId()
			{
				return $this->fields_arr['user_id'];
			}

		/**
		 * MyProfileFormHandler::updateProfileViewCount()
		 *
		 * @return
		 */
		public function updateProfileViewCount()
			{
				$userId = $this->getCurrentUserId();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET profile_hits = profile_hits + 1'.
						' WHERE user_id='.$this->dbObj->Param($userId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->updateUserViews($userId);
			}

		/**
		 * MyProfileFormHandler::updateUserViews()
		 *
		 * @param integer $userId
		 * @return
		 */
		public function updateUserViews($userId='')
			{
				$viewed_user_id = $this->CFG['user']['user_id'];

				if(!$userId OR !$viewed_user_id)
					return false;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_views'].
						' SET total_views = total_views + 1, last_viewed_date = NOW()'.
						' WHERE user_id = '.$this->dbObj->Param($userId).
						' AND viewed_user_id = '.$this->dbObj->Param($viewed_user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId, $viewed_user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$this->dbObj->Affected_Rows())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_views'].
								' SET total_views=1, last_viewed_date=now(), date_added=now()'.
								', user_id='.$this->dbObj->Param($userId).
								', viewed_user_id='.$this->dbObj->Param($viewed_user_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($userId, $viewed_user_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * MyProfileFormHandler::haveRightToViewThisProfile()
		 *
		 * @return
		 */
		public function haveRightToViewThisProfile()
			{
				$current = $this->CFG['user']['user_id'];
				$friend  = $this->getCurrentUserId();
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param($current).
						' AND friend_id='.$this->dbObj->Param($friend).
						' LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($current, $friend));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				return $rs->PO_RecordCount();
			}

		/**
		 * MyProfileFormHandler::getUserStyle()
		 *
		 * @return
		 */
		public function getUserStyle()
			{
				$userId = $this->getCurrentUserId();
				$sql = 'SELECT user_style FROM '.$this->CFG['db']['tbl']['users_profile_theme'].
						' WHERE user_id='.$this->dbObj->Param($userId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$style = '';
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$style = $row['user_style'];
					}
				return $style;
			}

		/**
		 * MyProfileFormHandler::displayEditLink()
		 *
		 * @param string $link
		 * @param string $text
		 * @return
		 */
		public function displayEditLink($link='#', $text='Edit')
			{
				if ($this->isEditableLinksAllowed())
				    {
						$link = $link;
					}
				return $link;
			}

		/**
		 * MyProfileFormHandler::isEditableLinksAllowed()
		 *
		 * @return
		 */
		public function isEditableLinksAllowed()
			{
				return $this->showEditableLink;
			}

	    /**
	     * MyProfileFormHandler::getValueFromArray()
	     *
	     * @param array $array
	     * @param string $index
	     * @param mixed $comma
	     * @return
	     */
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

		/**
		 * MyProfileFormHandler::displayRecord()
		 *
		 * @param string $caption
		 * @param string $text
		 * @param mixed $displayAll
		 * @return
		 */
		public function displayRecord($caption='', $text='', $displayAll=false)
			{
				$caption = trim($caption);
				$text	 = trim($text)?trim($text):'';
				$display = (($caption and $text) OR $displayAll OR $this->isEditableLinksAllowed());
				$record=array();
				if ($display and $caption)
					{
				    	$record['caption']=$caption;
				    	$record['text']=$text;
				    }
				return $record;
			}

		/**
		 * MyProfileFormHandler::getZodiacSign()
		 *
		 * @param mixed $date
		 * @return
		 */
		public function getZodiacSign($date)
			{
	           	list($day,$month)=explode("-",$date);
	           	if(($month==1 && $day>20)||($month==2 && $day<20)){
	                return $this->LANG['aquarius'];
	           	}else if(($month==2 && $day>18 )||($month==3 && $day<21)){
	                return $this->LANG['pisces'];
	           	}else if(($month==3 && $day>20)||($month==4 && $day<21)){
	                return $this->LANG['aries'];
	           	}else if(($month==4 && $day>20)||($month==5 && $day<22)){
	                return $this->LANG['taurus'];
	           	}else if(($month==5 && $day>21)||($month==6 && $day<22)){
	                return $this->LANG['gemini'];
	           	}else if(($month==6 && $day>21)||($month==7 && $day<24)){
	                return $this->LANG['cancer'];
	           	}else if(($month==7 && $day>23)||($month==8 && $day<24)){
	                return $this->LANG['leo'];
	           	}else if(($month==8 && $day>23)||($month==9 && $day<24)){
	                return $this->LANG['virgo'];
	           	}else if(($month==9 && $day>23)||($month==10 && $day<24)){
	                return $this->LANG['libra'];
	           	}else if(($month==10 && $day>23)||($month==11 && $day<23)){
	                return $this->LANG['scorpio'];
	           	}else if(($month==11 && $day>22)||($month==12 && $day<23)){
	                return $this->LANG['sagittarius'];
	           	}else if(($month==12 && $day>22)||($month==1 && $day<21)){
	                return $this->LANG['capricorn'];
	           	}
	    	}

	    /**
	     * MyProfileFormHandler::getNextUserDetails()
	     *
	     * @param integer $userId
	     * @return
	     */
	    public function getNextUserDetails($userId = 0)
			{
				$sql = 'SELECT user_id,user_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id > '.$this->dbObj->Param($userId).
						' AND usr_status=\'Ok\''.
						' ORDER BY user_id ASC LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);

				$nextUserId = array();
				if ($rs->PO_RecordCount())
					{
			          	$row = $rs->FetchRow();
				     	$nextUserId['id'] = $row['user_id'];
						$nextUserId['name'] = $row['user_name'];
					}
				else
					{
						$sql = 'SELECT user_id, user_name FROM '.$this->CFG['db']['tbl']['users'].
								' WHERE user_id < '.$this->dbObj->Param($userId).
								' AND usr_status=\'Ok\''.
								' ORDER BY user_id ASC LIMIT 1';
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($userId));
						//raise user error... fatal
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = array();
						if ($rs->PO_RecordCount())
							{
						        $row = $rs->FetchRow();
						     	$nextUserId['id'] = $row['user_id'];
								$nextUserId['name'] = $row['user_name'];
						    }
					}
				return $nextUserId;
		  }

		/**
		 * MyProfileFormHandler::getCurrentUserOnlineStatus()
		 *
		 * @param string $privacy
		 * @param string $status_msg_id
		 * @return
		 */
		public function getCurrentUserOnlineStatus($privacy='', $status_msg_id='')
			{
				$currentStatus = $this->LANG['members_list_online_status_default'];
				$Online = $Offline = $Custom = false;
				if ($privacy)
				    {
				        $$privacy = true;
				    }
				if ($Online)
				    {
						$currentStatus = $this->LANG['members_list_online_status_online'];
				    }
				elseif($Offline)
					{
						$currentStatus = $this->LANG['members_list_online_status_offline'];
					}
				elseif($Custom AND $status_msg_id)
					{
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
								' WHERE status_msg_id='.$this->dbObj->Param($status_msg_id);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($status_msg_id));
						//raise user error... fatal
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
		 * MyProfileFormHandler::updateRightBlockPosition()
		 *
		 * @param mixed $right_arr
		 * @return
		 */
		public function updateRightBlockPosition($right_arr)
			{
		   	 	foreach($right_arr as $order_no=>$value)
		   	 		{
		  	  			if($this->chkBlogNameExists($value))
			   	  			{
				   	  			$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_block'].
									 	' SET position=\'right\', order_no='.$order_no.'+1'.
										' WHERE block_name='.$this->dbObj->Param('block_name');

					  			$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt,array($value));
								if (!$rs)
						        	trigger_db_error($this->dbObj);
				 			}
				 		else
				 			{
				   				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_block'].
								   		' SET position=\'right\', order_no='.$order_no.'+1'.
										', user_id='.$this->dbObj->Param('user_id').
										', module_name='.$this->dbObj->Param('module_name').
										', block_name='.$this->dbObj->Param('block_name');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->getModuleName($value), $value));
								if (!$rs)
						        	trigger_db_error($this->dbObj);
				 			}
		 			}
		  	}

		/**
		 * MyProfileFormHandler::updateLeftBlockPosition()
		 *
		 * @param mixed $left_arr
		 * @return
		 */
		public function updateLeftBlockPosition($left_arr)
		  	{
		   	 	foreach($left_arr as $order_no=>$value)
		   	 		{
			   	 		if($this->chkBlogNameExists($value))
			   	  			{
					   	  		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_profile_block'].
									 	' SET position=\'left\', order_no='.$order_no.'+1'.
										' WHERE block_name='.$this->dbObj->Param('block_name');

						  		$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value));
								if (!$rs)
							        trigger_db_error($this->dbObj);
				   			}
				   		else
					   		{
						   	  	$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_profile_block'].
									 	' SET position=\'left\',order_no='.$order_no.'+1'.
										', user_id='.$this->dbObj->Param('user_id').
										', module_name='.$this->dbObj->Param('module_name').
										', block_name='.$this->dbObj->Param('block_name');

							  	$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->getModuleName($value), $value));
								if (!$rs)
							        trigger_db_error($this->dbObj);
					   		}
			 		}
		  	}

	  	/**
	  	 * MyProfileFormHandler::chkBlogNameExists()
	  	 *
	  	 * @param mixed $block_name
	  	 * @return
	  	 */
	  	public function chkBlogNameExists($block_name)
		  	{
		 		$sql = 'SELECT profile_block_id FROM '.$this->CFG['db']['tbl']['users_profile_block'].
				 		' WHERE block_name = '.$this->dbObj->Param('block_name').
						' AND user_id='.$this->dbObj->Param('user_id');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($block_name, $this->CFG['user']['user_id']));
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

		 		if($row = $rs->FetchRow())
					return true;
				return false;
		  	}

		/**
		 * MyProfileFormHandler::getModuleName()
		 *
		 * @param mixed $block_name
		 * @return
		 */
		public function getModuleName($block_name)
		  	{
		 		$sql= 'SELECT module_name FROM '.$this->CFG['db']['tbl']['profile_block'].
				 		' WHERE block_name = '.$this->dbObj->Param('block_name');
		 		$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($block_name));
			  	if (!$rs)
			    	trigger_db_error($this->dbObj);

		 		if($row = $rs->FetchRow())
					return $row['module_name'];
		  	}

		/**
		 * MyProfileFormHandler::chkAlreadyBlock()
		 *
		 * @return
		 */
		public function  chkAlreadyBlock()
			{
		  		$sql = 'SELECT COUNT(id) AS count'.
						' FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND block_id='.$this->dbObj->Param('block_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}

		/**
		 * MyProfileFormHandler::chkIsModuleBlockToDisplay()
		 *
		 * @param string $module_name
		 * @return boolean
		 */
		public function chkIsModuleBlockToDisplay($module_name)
			{
		    	if($module_name == 'default' OR chkAllowedModule(array($module_name)))
					return true;
				return false;
			}

		/**
		 * MyProfileFormHandler::chkTemplateForModuleAndSwitch()
		 *	Check template for given module change to available template if given
		 * 		template is not available
		 *
		 * @param string $module_path
		 * @param string $template
		 * @param string $block_tpl_name
		 * @return void
		 */
		public function chkTemplateForModuleAndSwitch($module_path, $template, $block_tpl_name)
			{
				global $CFG;

				$template_dir_module = $CFG['site']['project_path'].$module_path.'design/templates/'.$template.'/general/';
				$template_module_tpl = $CFG['site']['project_path'].$module_path.'design/templates/'.
											$template.'/general/profile'.ucfirst($block_tpl_name).'Block.tpl';

				if(!is_dir($template_dir_module) && !file_exists($template_module_tpl))
					{
						foreach($CFG['html']['template']['allowed'] as $available_template)
							{
								$available_template_dir = $CFG['site']['project_path'].$module_path.
																'design/templates/'.$available_template.'/general/';

								$module_tpl = $CFG['site']['project_path'].$module_path.
												'design/templates/'.$available_template.
													'/general/profile'.ucfirst($block_tpl_name).'Block.tpl';

								if(is_dir($available_template_dir) && file_exists($module_tpl))
									{
										return $available_template;
									}
							}
					}
				return $template;
			}

		/**
		 * MyProfileFormHandler::chkCSSForModuleAndSwitch()
		 *	Check template for given module change to available template and css file if given
		 * 		template is not available {profile_VAR_MODULE.css}
		 *
		 * @param string $module
		 * @param string $template
		 * @param string $screen
		 * @return void
		 */
		public function chkCSSForModuleAndSwitch($module, $template, $screen)
			{
				global $CFG;
				$css_template_arr['template'] = $template;
				$css_template_arr['screen'] = $screen;

				$template_dir_module = $CFG['site']['project_path'].$module.
											'/design/templates/'.$template.'/root/css/'.$screen.'/';

				$template_module_css = $CFG['site']['project_path'].$module.
											'/design/templates/'.$template.'/root/css/'.
												$screen.'/profile_'.strtolower($module).'.css';

				if(!is_dir($template_dir_module) && !file_exists($template_module_css))
					{
						foreach($CFG['html']['template']['allowed'] as $available_template)
							{
								$available_template_dir = $CFG['site']['project_path'].$module.
																'/design/templates/'.$available_template.'/root/css/';

								if(is_dir($available_template_dir))
									{
										foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_css)
											{
												$available_css_path  = $CFG['site']['project_path'].$module.
																			'/design/templates/'.$available_template.'/root/css/'.$available_css.'/';

												$available_css_file  = $CFG['site']['project_path'].$module.
																			'/design/templates/'.$available_template.
																				'/root/css/'.$available_css.'/profile_'.strtolower($module).'.css';

												if(is_dir($available_css_path) && file_exists($available_css_file))
													{
														$css_template_arr['template'] = $available_template;
														$css_template_arr['screen'] = $available_css;
														return $css_template_arr;
													}
											}
									}
							}
					}
				return $css_template_arr;
			}

		/**
		 * MyProfileFormHandler::getProfileBackgroud()
		 *
		 * @return booleand
		 */
		public function getProfileBackgroud()
			{
				$sql = 'SELECT background_color, background_ext, background_offset, background_repeat'.
						' FROM '.$this->CFG['db']['tbl']['users_profile_background'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->background_color = $row['background_color'];
						$this->background_ext = $row['background_ext'];
						$this->background_offset = $row['background_offset'];
						$this->background_repeat = $row['background_repeat'];
						return true;
					}
				return false;
			}

		/**
		 * MyProfileFormHandler::getProfileBackgroundImage()
		 *
		 * @return
		 */
		public function getProfileBackgroundImage()
			{
				//$this->background_folder = $folder = $this->media_relative_path.$this->CFG['profile']['background_image_folder'];
				$this->background_folder = $folder = $this->CFG['profile']['background_image_folder'];

				$this->background_image = $folder.$this->fields_arr['user_id'].'.'.$this->background_ext;

				if(file_exists($this->background_image))
					{
						$this->background_image .= '?'.time();
						$this->background_image = ' url('.$this->background_image.')';
					}
				else
					{
						$this->background_image = '';
					}
			}

		/**
		 * MyProfileFormHandler::insertReportsInTable()
		 *
		 * @return
		 */
		public function insertReportsInTable()
			{
				global $LANG_LIST_ARR;

				if($this->fields_arr['reports'])
					{
						$sql_count = 'SELECT report_id FROM ' . $this->CFG['db']['tbl']['reported_users'] .
									' WHERE reporter_id = '. $this->dbObj->Param('reporter_id') .
									' AND reported_user_id = ' . $this->dbObj->Param('user_id');
						$stmt_count = $this->dbObj->Prepare($sql_count);

						$rs_count = $this->dbObj->Execute($stmt_count, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
					    if (!$rs_count)
						    trigger_db_error($this->dbObj);

						if($rs_count->PO_RecordCount())
							{
								$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['reported_users']  .
										' WHERE reporter_id = '. $this->dbObj->Param('reporter_id') .
										' AND reported_user_id = ' . $this->dbObj->Param('user_id');
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								while($row = $rs_count->FetchRow())
									{
										$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['reported_users_info'] .
												' WHERE report_id = ' . $row['report_id'];
										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
									    if (!$rs)
										    trigger_db_error($this->dbObj);
									}
							}
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['reported_users'].
								' SET reported_user_id='.$this->dbObj->Param('user_id').
								', reporter_id='.$this->dbObj->Param('reporter_id').
								', custom_message ='. $this->dbObj->Param('custom_message') .
								', date_added=NOW()';

						$stmt = $this->dbObj->Prepare($sql);

						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $this->CFG['user']['user_id'], $this->fields_arr['custom_message']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$inserted_report_id = $this->dbObj->Insert_ID();

						$report_type = explode(',',$this->fields_arr['reports']);
						foreach($report_type as $report)
							{
								if( trim($report) && $report != '')
									{
										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['reported_users_info'].
												' SET report_id='.$this->dbObj->Param('report_id').
												', flag ='. $this->dbObj->Param('report');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($inserted_report_id, $report));
									    if (!$rs)
										    trigger_db_error($this->dbObj);
									}
							}
						$this->setFormField('custom_message','');
						$this->setPageBlockShow('block_msg_form_success');
						$this->setCommonSuccessMsg($this->LANG['success_reporting']);
					}
				else
					{
						$this->setCommonErrorMsg($this->LANG['error_reporting']);
						$this->setPageBlockShow('block_msg_form_error');
					}
			}

		/**
		 * EditProfile::getReportBlock()
		 * To show report user block
		 * @return void
		 * @access public
		 */
		public function getReportBlock()
			{
				global $smartyObj;

				$this->includeAjaxHeader();

				$this->reportingUrl = $this->CFG['site']['url'].'viewProfile.php?user_id='.$this->getFormField('user_id');
				setTemplateFolder('members/');
				$smartyObj->display('reportUser.tpl');

				$this->includeAjaxFooter();
			}

		/**
		 * MyProfileFormHandler::PopulateSelectDataArray()
		 * for populating the data array to be used for edit in place ..
		 *
		 * @param mixed $id
		 * @param mixed $options_value
		 * @param mixed $ans
		 * @return
		 */
		public function PopulateSelectDataArray($id, $options_array, $ans, $default=0)
			{
				$explode_arr = $options_array;
				$option_arr=array();
				if($default)
					$option_arr[' ']= $this->LANG['common_select_option'];

				foreach($explode_arr as $key=>$value)
					{
						if(strlen(trim($value)))
							{
							    $option_arr[$key]=trim($value);
							}
					}
				$option_arr['selected'] = $ans;
				$this->js_string_data .= 'var infoarray_'.$id. ' = '.json_encode($option_arr).";\r\n";
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function blockUser()
			{
				$sql = 	'INSERT INTO '.$this->CFG['db']['tbl']['block_members'].
						' SET user_id ='.$this->dbObj->Param($this->CFG['user']['user_id']).
						', block_id='.$this->dbObj->Param($this->fields_arr['user_id']).
						', date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function unblockUser()
			{
				$sql = 	'DELETE FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE user_id ='.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND block_id='.$this->dbObj->Param($this->fields_arr['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}
		/**
		 * viewProfile::populateDiscussionRecentBoards()
		 *
		 * @return
		 */
		public function populateDiscussionRecentBoards()
			{
				global $smartyObj;
				require_once('common/classes/class_DiscussionHandler.lib.php');
				$discuzzRecentBoards = new DiscussionHandler();
				$discuzzRecent =  $discuzzRecentBoards->displayRecentBoards(5,NULL,$this->fields_arr['user_id']);
				$smartyObj->assign('recentDiscussionBoards',$discuzzRecent);
				setTemplateFolder('general/');
				$smartyObj->display('mainProfileOtherRecentBoard.tpl');
			}
		/**
		 * viewProfile::populateArticleRecent()
		 *
		 * @return
		 */
		public function populateArticleRecent()
			{
				global $smartyObj;
				require_once('common/classes/class_ArticleHandler.lib.php');
				$articleRecentBoards = new ArticleHandler();
				$articleRecent =  $articleRecentBoards->populateCarousalarticleBlock('articlerecent',0,false,$this->fields_arr['user_id']); //$smartyObj->assign('populateArticleRecentBlock_arr', $blogRecentBoards);
				setTemplateFolder('general/');
				$smartyObj->display('mainProfileOtherRecentArticle.tpl');
			}
		/**
		 * viewProfile::populateBlogRecent()
		 *
		 * @return
		 */
		public function populateBlogRecent()
			{
				global $smartyObj;
				require_once('common/classes/class_BlogHandler.lib.php');
				$blogRecentBoards = new BlogHandler();
				$blogRecentBoards =  $blogRecentBoards->populateBlogRecentBlock('blogrecent',0,false,$this->fields_arr['user_id']);
				$smartyObj->assign('populateBlogRecentBlock_arr', $blogRecentBoards);
				setTemplateFolder('general/');
				$smartyObj->display('mainProfileOtherRecentBlog.tpl');
			}

		public function populateRecent($case='recentboard')
		{
				switch($case)
					{
						case 'recentboard':
								if (chkAllowedModule(array('discussions'))) {
									$this->populateDiscussionRecentBoards();
								}
						break;
						case 'recentblog':
								if (chkAllowedModule(array('blog'))) {
								$this->populateBlogRecent();
								}
						break;

						case 'recentarticle':
								if (chkAllowedModule(array('article'))) {
									$this->populateArticleRecent();
								}
						break;
					}
		}
	}
//<<<<<---------------class MyProfileFormHandler------///
//--------------------Code begins-------------->>>>>//
$myprofile = new MyProfileFormHandler();
$myprofile->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'show_profile_block', 'msg_form_private_account','form_show_profile', 'form_preview_layout'));

$myprofile->setMediaPath('');
if(isMember())
	$myprofile->setMediaPath('../');

$smartyObj->assign('myprofileObj', $myprofile);
$smartyObj->assign('LANG', $LANG);
$smartyObj->assign('LANG_LIST_ARR', $LANG_LIST_ARR);

$myprofile->setFormField('user_id', 0);
$myprofile->setFormField('block_id', 0);
$myprofile->setFormField('user', 0);
$myprofile->setFormField('edit', 0);
$myprofile->setFormField('design', '');
$myprofile->setFormField('layout', '');
$myprofile->setFormField('page_title', '');
$myprofile->setFormField('page_meta_keywords', '');
$myprofile->setFormField('left', '');
$myprofile->setFormField('right', '');
$myprofile->setFormField('custom_message', '');
$myprofile->setFormField('action', '');
$myprofile->setFormField('reports', '');
$myprofile->setFormField('msg', '');

if ($myprofile->isPageGETed($_GET, 'user_id'))
    {
        $myprofile->sanitizeFormInputs($_GET);
		$myprofile->checkUserId();
    }

if ($myprofile->isPageGETed($_GET, 'user'))
    {
        $myprofile->sanitizeFormInputs($_GET);
		$myprofile->setUserId();
    }

if ($myprofile->isFormGETed($_REQUEST, 'action'))
	{
		$myprofile->sanitizeFormInputs($_REQUEST);
		switch($myprofile->getFormField('action'))
			{
				case 'report':
					if(isMember() and isAjax() and $myprofile->isValidUserId() and !$myprofile->isCurrentUser)
						{
							$myprofile->includeAjaxHeader();
							$myprofile->reportingUrl = $CFG['site']['url'].'viewProfile.php?user_id='.$myprofile->getFormField('user_id');
							setTemplateFolder('members');
							$smartyObj->display('reportUser.tpl');
							$myprofile->includeAjaxFooter();
						}
					break;
				case 'Block':
					if(isMember() and $myprofile->isValidUserId() and !$myprofile->isCurrentUser)
						{
							$myprofile->blockUser();
							Redirect2URL(getUrl('viewprofile', '?user='.$myprofile->getFormField('user').'&msg=blocked', $myprofile->getFormField('user').'/?msg=blocked', 'members'));
						}
				case 'Unblock':
					if(isMember() and $myprofile->isValidUserId() and !$myprofile->isCurrentUser)
						{
							$myprofile->unblockUser();
							Redirect2URL(getUrl('viewprofile', '?user='.$myprofile->getFormField('user').'&msg=unblocked', $myprofile->getFormField('user').'/?msg=unblocked', 'members'));
						}
					break;
			}
	}
else if($myprofile->isFormGETed($_REQUEST, 'reports'))
	{
		if(isMember() and isAjax() and $myprofile->isValidUserId() and !$myprofile->isCurrentUser)
			{
				$myprofile->sanitizeFormInputs($_REQUEST);
				$myprofile->insertReportsInTable();
				$myprofile->getReportBlock();
			}
		exit;
	}

if (isset($__myProfile)) //its declared in members/myProfile.php
    {
        $myprofile->setFormField('user_id', $CFG['user']['user_id']);
		$myprofile->setFormField('edit', '1');
		$myprofile->checkUserId();
    }

$myprofile->profile_url_members = getUrl('viewprofile', '?user='.$myprofile->getFormField('user'), $myprofile->getFormField('user').'/', 'members');
$myprofile->profile_background = $myprofile->getProfileBackgroud();
if($myprofile->profile_background)
	$myprofile->getProfileBackgroundImage();

if ($myprofile->isFormPOSTed($_POST, 'update_order'))
	{
	   	$myprofile->sanitizeFormInputs($_POST);
		$left_str = substr($myprofile->getFormField('left'),0,strlen($myprofile->getFormField('left'))-1);
		$left_arr=explode(',',$left_str);
		$myprofile->updateLeftBlockPosition($left_arr);

		$right_str = substr($myprofile->getFormField('right'),0,strlen($myprofile->getFormField('right'))-1);
		$right_arr=explode(',',$right_str);
		$myprofile->updateRightBlockPosition($right_arr);
	}

$userId = $myprofile->getFormField('user_id');
if (!is_numeric($userId))
    {
        $myprofile->setFormField('user_id', intval($userId));
    }
$myprofile->setAllPageBlocksHide();
$myprofile->updateUsersAgeValue();
$UserNotFound = true;
$currentAccount = false;
$user_details_arr['user_id']=0;
if ($myprofile->isValidUserId())
    {
		$UserNotFound = false;
		$currentAccount = (strcmp($CFG['user']['user_id'], $myprofile->getFormField('user_id'))==0);
		$last_logged = 'last_logged';
		if(isMember() && $currentAccount)
			$last_logged = '\''.$_SESSION['user']['last_logged'].'\'';

		$user_details_arr = $myprofile->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
																	 array(	'user_id','user_name','password','sex', 'icon_type', 'image_ext', 'age', 'relation_status','icon_id','country','total_videos', 'total_games', 'total_musics', 'total_photos', 'total_friends', 'total_posts', 'profile_hits','about_me','web_url','email','first_name','last_name','theme','show_profile','total_friends','total_photos','show_dob', 'allow_comment','hometown','city',
																	 		'privacy', 'status_msg_id', 'profile_tags', 'show_profile',
																			'last_logged', 'doj', 'dob',
																			'DATE_FORMAT(dob, \'%Y-%m-%d\') as dob_edit',
																			'DATE_FORMAT(dob, \'%d-%m\') as dob_zodiac',
																			'last_active',
																			'DATE_FORMAT(dob, \'%b %d\') as birthday',
																			'(logged_in=\'1\' AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active) AS logged_in_currently', 'usr_status'
																		  ),
																	array('doj', 'last_logged', 'dob', 'dob_edit', 'dob_zodiac','last_active', 'birthday', 'logged_in_currently')
																	);
		$myprofile->form_show_profile['user_details_arr'] = $user_details_arr;
		$myprofile->form_show_profile['user_details_arr']['profile_url'] = getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']);
		$status = $user_details_arr['usr_status'];
		$_UserStatus_Ok = $_UserStatus_ToActivate = $_UserStatus_Cancelled = $_UserStatus_Deleted = false;
		$statusVar = '_UserStatus_'.$status;
		$$statusVar = true;

		if ($_UserStatus_Ok)
		    {
				if($myprofile->chkProfileViewSettings($user_details_arr['show_profile']))
					{
						$toAll = (strcmp($user_details_arr['show_profile'], 'All')==0);
						$toMembers = (strcmp($user_details_arr['show_profile'], 'Members')==0);
						$toFriends = (strcmp($user_details_arr['show_profile'], 'Friends')==0);
						$myprofile->form_show_profile['currentAccount']=$currentAccount = (strcmp($CFG['user']['user_id'], $myprofile->getFormField('user_id'))==0);

						if ($currentAccount OR $toAll OR $toMembers OR ($toFriends AND $myprofile->haveRightToViewThisProfile()))
						    {
								$myprofile->setPageBlockShow('form_show_profile');
								$myprofile->setPageBlockShow('show_profile_block');
								$myprofile->show_profile_block['profile_block']=$myprofile->getProfileBlock();
								$userIcon = getMemberAvatarDetails($user_details_arr['user_id']);
								$myprofile->form_show_profile['userIcon']=$userIcon;
								if (!$currentAccount AND isset($_SERVER['HTTP_REFERER']))
								    {
								        $myprofile->updateProfileViewCount();
										$user_details_arr['profile_hits'] += 1;
								    }
								$myprofile->setFormField('page_title', $user_details_arr['user_name']);
								$myprofile->setFormField('page_meta_keywords', $user_details_arr['profile_tags']);
							}
						else
							{
								$myprofile->setAllPageBlocksHide();
								$myprofile->setPageBlockShow('msg_form_private_account');
								$myprofile->setFormField('page_title', $LANG['viewprofile_page_title_private_account']);
							}
					}
				else
					{
						$myprofile->setCommonErrorMsg($LANG['not_aallowed_to_view']);
						$myprofile->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$UserNotFound = true;
			}
	}
if ($myprofile->isFormPOSTed($_GET, 'msg'))
	{
		switch($myprofile->getFormField('msg')){
			case 'blocked':
				$myprofile->setCommonSuccessMsg($LANG['viewprofile_block_success']);
				break;
			case 'unblocked':
				$myprofile->setCommonSuccessMsg($LANG['viewprofile_unblock_success']);
				break;
		} // switch
		$myprofile->setPageBlockShow('block_msg_form_success');
	}
if ($UserNotFound)
    {
		$myprofile->setCommonErrorMsg($LANG['myprofile_msg_invalid_user']);
		$myprofile->setPageBlockShow('block_msg_form_error');
		$myprofile->setFormField('page_title', $LANG['viewprofile_page_title_page_not_found']);
	}
if(!isAjax())
	{
		$CFG['html']['meta']['keywords'] = str_replace('VAR_DEFAULT_TAGS', $CFG['html']['meta']['keywords'], $LANG['member_profile_meta_tag']);
		$CFG['html']['meta']['keywords'] = str_replace('VAR_TAGS', $myprofile->getFormField('page_meta_keywords'), $CFG['html']['meta']['keywords']);

		$CFG['site']['title'] = str_replace('VAR_SITE_TITLE', $CFG['site']['title'], $LANG['member_profile_top_title']);
		$CFG['site']['title'] = str_replace('VAR_TITLE', $myprofile->getFormField('page_title'), $CFG['site']['title']);
		$CFG['site']['title'] = str_replace('VAR_MODULE', $LANG['window_title_member'], $CFG['site']['title']);
	}

$layout_submit_preview=false;
if ($myprofile->isShowPageBlock('form_show_profile'))
    {
    	 if ($myprofile->isFormPOSTed($_GET, 'layout_submit_preview'))
		  	{
			  	$layout_submit_preview=true;
				$style = '';
				$myprofile->setPageBlockShow('form_preview_layout');
		  	}
	  	else
			{
			 	$style = $myprofile->getUserStyle();
			}
		$myprofile->sanitizeFormInputs($_REQUEST);
     	$myprofile->form_show_profile['style']=html_entity_decode($style);
     	$defaultTableBgColor = '';
     	$myprofile->defaultTableBgColor='';
        $defaultBlockTitle = '';
        $myprofile->defaultBlockTitle='';
        $myprofile->form_show_profile['displayPhotoEditLink'] = '';
	    if (chkAllowedModule(array('photo')))
	    	{
				$myprofile->form_show_profile['displayPhotoEditLink']=$myprofile->displayEditLink(getUrl('photolist','?pg=myphotos', 'photolist/myphotos/', '','photo'), $LANG['viewProfile_edit_link_icon']);
			}
		$myprofile->form_show_profile['displayBasicEditLink']=$myprofile->displayEditLink(getUrl('profilebasic'), $LANG['viewProfile_edit_link']);
		$myprofile->form_show_profile['displayAvatarEditLink']=$myprofile->displayEditLink(getUrl('profileavatar'), $LANG['viewProfile_edit_link']);
		$currentStatus = $LANG['members_list_offline_status_default'];
        $onlineStatusClass = 'viewProfileOfflineStatus';
        if ($user_details_arr['logged_in_currently'])
	       {
				$currentStatus = $myprofile->getCurrentUserOnlineStatus($user_details_arr['privacy'], $user_details_arr['status_msg_id']);
				$onlineStatusClass = 'viewProfileOnlineStatus';
	       }
	    $age = $user_details_arr['age'];
		$details = '';
		$details .= ($LANG_LIST_ARR['gender'][$user_details_arr['sex']])?$LANG_LIST_ARR['gender'][$user_details_arr['sex']].',':'';
		$details .= ($age > 0)?$age.', ':'';
		$relationStatus = $myprofile->getValueFromArray($LANG_LIST_ARR['user_relation_status'], $user_details_arr['relation_status']);
		$details .= ($relationStatus)?$relationStatus.', ':'';
		$country = $myprofile->getValueFromArray($LANG_LIST_ARR['countries'], $user_details_arr['country']);
		$details .= $country?$country:'';

		if (!$currentAccount)
		    {
				$myprofile->form_show_profile['profileMemberBlock']=getUrl('memberblock','?block_id='.$user_details_arr['user_id'],'?block_id='.$user_details_arr['user_id'],'members');
				$myprofile->form_show_profile['profileMemberUnBlock']=getUrl('memberblock','?unblock_id='.$user_details_arr['user_id'],'?unblock_id='.$user_details_arr['user_id'],'members');

	            if(chkAllowedModule(array('mail')))
	               $myprofile->form_show_profile['profileMailCompose']=getUrl('mailcompose','?viewprofile='.$user_details_arr['user_id'],'?viewprofile='.$user_details_arr['user_id'],'members');
		    }
		$about_me = '';
		$about_me = $user_details_arr['about_me'];
		if (!trim($about_me) AND $CFG['user']['user_id'] == $myprofile->getFormField('user_id'))
			$about_me = $LANG['commmon_tell_about_yourself'];
		$myprofile->form_show_profile['is_about_me']=false;
		if($about_me)
			$myprofile->form_show_profile['is_about_me']=true;
		$myprofile->form_show_profile['about_me'] = $about_me;
    	$myprofile->form_show_profile['myUrlTitle']= str_replace('VAR_SITE_NAME', $myprofile->CFG['site']['title'], $LANG['index_user_rayzz_url']);
        $myprofile->form_show_profile['myProfileUrl'] = getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']);
        $myprofile->form_show_profile['myProfileUrl_wbr'] = wordWrap_mb_ManualWithSpace(getMemberProfileUrl($user_details_arr['user_id'], $user_details_arr['user_name']),50);
        $myprofile->form_show_profile['myweburl'] = '';
		if($user_details_arr['web_url']!='')
		  	$myprofile->form_show_profile['myweburl'] = wordWrap_mb_ManualWithSpace($user_details_arr['web_url'],50);
		$myprofile->form_show_profile['myweburl_id']='sel_myweburl';
		$myprofile->form_show_profile['myweburl_class']='editablearea_basic';
        $myprofile->form_show_profile['defaultBlockTitle']=$defaultBlockTitle;
        $myprofile->form_show_profile['displayPersonalEditLink']=$myprofile->displayEditLink(getUrl('profilepersonal'), $LANG['viewProfile_edit_link']);

        // Prsonal info start
        $myprofile->form_show_profile['myprofile_age']=$myprofile->displayRecord($LANG['myprofile_age'], $user_details_arr['age']);

		$sex = $myprofile->getValueFromArray($LANG_LIST_ARR['gender'], $user_details_arr['sex']);
		$myprofile->form_show_profile['gender']=$myprofile->displayRecord($LANG['myprofile_gender'], $sex);
		$myprofile->form_show_profile['gender_class']='editableselect_basic';
		$myprofile->form_show_profile['gender_id']='sel_gender';
		$myprofile->PopulateSelectDataArray('gender', $LANG_LIST_ARR['gender'], $user_details_arr['sex']);

		$country = $myprofile->getValueFromArray($LANG_LIST_ARR['countries'], $user_details_arr['country']);
		$myprofile->form_show_profile['myprofile_country']=$myprofile->displayRecord($LANG['myprofile_country'], $country);
		$myprofile->form_show_profile['country_class']='editableselect_basic clsCountrySelect';
		$myprofile->form_show_profile['country_id']='sel_country';
		$myprofile->PopulateSelectDataArray('country', $LANG_LIST_ARR['countries'], $user_details_arr['country'], 1);

		$relation = $myprofile->getValueFromArray($LANG_LIST_ARR['user_relation_status'], $user_details_arr['relation_status']);
		$myprofile->form_show_profile['myprofile_relation_status']=$myprofile->displayRecord($LANG['myprofile_relation_status'], $relation);
		$myprofile->form_show_profile['relation_class']='editableselect_basic';
		$myprofile->form_show_profile['relation_id']='sel_relation';
		$myprofile->PopulateSelectDataArray('relation', $LANG_LIST_ARR['user_relation_status'], $user_details_arr['relation_status']);

		$hometown= $user_details_arr['hometown'];
		$myprofile->form_show_profile['hometown']=$myprofile->displayRecord($LANG['myprofile_hometown'], $hometown);
		$city= $user_details_arr['city'];
		$myprofile->form_show_profile['city']=$myprofile->displayRecord($LANG['myprofile_city'], $city);
	    $myprofile->form_show_profile['myprofile_personal_url']=$myprofile->displayRecord($LANG['myprofile_personal_url'], $user_details_arr['web_url']);
	    $myprofile->form_show_profile['show_dob'] = false;
		if ($user_details_arr['show_dob'])
		    {
		       $myprofile->form_show_profile['show_dob'] = true;
		  	   $myprofile->form_show_profile['dob_zodiac']=$myprofile->getZodiacSign($user_details_arr['dob_zodiac']);
		  	   $myprofile->form_show_profile['birthday']=$user_details_arr['birthday'];
		  	   //$myprofile->form_show_profile['dob_edit']=$user_details_arr['dob_edit'];
		  	   $myprofile->form_show_profile['birthday_class']='editablecalendar_basic';
		  	   $myprofile->form_show_profile['birthday_id']='sel_birthday';
		  	   $option_arr=array();
		  	   $option_arr['selected'] = $user_details_arr['birthday'].$myprofile->content_separator.$user_details_arr['dob_edit'];
		  	   $myprofile->js_string_data .= 'var infoarray_birthday  = '.json_encode($option_arr).";\r\n";
			}

		//list blog details start
		if (!$currentAccount)
		    {
				$nextUserDetails = $myprofile->getNextUserDetails($user_details_arr['user_id']);
			    $myprofile->form_show_profile['nextUserDetails']=$nextUserDetails;
			    $myprofile->form_show_profile['AlreadyFriend']=true;
		       	if(!$myprofile->chkIsAlreadyFriend())
			      	{
				      	$myprofile->form_show_profile['AlreadyFriend']=false;
				      	$myprofile->form_show_profile['AddFriendUrl']=getUrl('friendadd','?friend='.$user_details_arr['user_id'],'?friend='.$user_details_arr['user_id'],'members');
			      	}
			   	$myprofile->form_show_profile['SendMessage']=getUrl('mailcompose','?mcomp='.$user_details_arr['user_name'],'?mcomp='.$user_details_arr['user_name'],'members');
			   	$myprofile->form_show_profile['NextProfile']=true;
			   	if (!$myprofile->isEditableLinksAllowed() AND $nextUserDetails)
		        	{
			          	$myprofile->form_show_profile['NextProfile']=false;
			          	$myprofile->form_show_profile['NextProfileUrl']=getMemberProfileUrl($nextUserDetails['id'], $nextUserDetails['name']);
		          	}
		    }//blog details end

		$block_name_arr=array();
		if($myprofile->show_profile_block['profile_block'])
			{
			   if(isset($myprofile->show_profile_block['profile_block']['left']))
					{
						foreach($myprofile->show_profile_block['profile_block']['left'] as $key=>$value)
							{
								$block_name_arr[]=$value['block_name'];
							}
					}
				if(isset($myprofile->show_profile_block['profile_block']['right']))
					{
						foreach($myprofile->show_profile_block['profile_block']['right'] as $key=>$value)
							{
								$block_name_arr[]=$value['block_name'];
							}
					}
				$blog_names=implode('\',\'',$block_name_arr);
			}
    }
$myprofile->isMyProfilPage = false;
if(isset($__myProfile))
	$myprofile->isMyProfilPage = $__myProfile;
$myprofile->reportLink = $CFG['site']['url'].'viewProfile.php?user_id='.$myprofile->getFormField('user_id').'&action=report';
if (isset($_SESSION['friend_request_message']) and !empty($_SESSION['friend_request_message']))
    {
        $myprofile->setPageBlockShow('block_msg_form_success');
		$myprofile->setCommonSuccessMsg($_SESSION['friend_request_message']);
		unset($GLOBALS['_SESSION']['friend_request_message']);
    }
//<<<<--------------------Code Ends----------------------//
//include the header file
$myprofile->includeHeader();
?>
<script type="text/javascript">
	var block_arr = new Array('selMsgConfirmCommon');
</script>
<?php
//include the content of the page
if($myprofile->this_profileurl_script != '')
	echo $myprofile->this_profileurl_script;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/profile.css" />
<?php
foreach($CFG['site']['modules_arr'] as $value)
	{
	   if(chkAllowedModule(array(strtolower($value))))
			{
				//check the available template for module and load the css
				$template_screen_arr = $myprofile->chkCSSForModuleAndSwitch($value, $CFG['html']['template']['default'], $CFG['html']['stylesheet']['screen']['default']);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'].strtolower($value); ?>/design/templates/<?php echo $template_screen_arr['template'];?>/root/css/<?php echo $template_screen_arr['screen']; ?>/profile_<?php echo strtolower($value);?>.css">
<?php
			}
	}
?>
<link rel="stylesheet" id="personalStyleLink" type="text/css" href="<?php echo $CFG['site']['url'];?>profileCss.php?user_id=<?php echo $user_details_arr['user_id'];?>&amp;d=<?php echo date('dmyhis');?>" />

<?php
setTemplateFolder('general/');
if($CFG['profile_block']['re_order'] && isMember() && $currentAccount && isset($__myProfile))
	{
?>
<script type="text/javascript">
var reorder_section_count = 2;
var modules=Array('<?php echo $blog_names;?>');
</script>

<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/reOrder.js"></script>
<?php if(isset($__myProfile)) { ?>
	<style type="text/css">
	ul.clsDraglist th{
		cursor:move;
	}
	</style>
<?php }
	}
$smartyObj->display('viewProfile.tpl');
?>
<?php
// coding to allow edit in place for the profile blocks
//if the logged in user is the viewed profile
// and allow edit in place is turned on for profile ..
if($CFG['user']['user_id'] AND $CFG['user']['user_id'] == $myprofile ->getFormField('user_id') AND $CFG['profile']['allow_edit_in_place'] AND !isset($__myProfile))
	{
		$calendar_params_array = array('minDate' => '-70Y',
									  'maxDate'	=> '-1D',
									  'yearRange'=> '-100:+20'
									 );
		if ($calendar_params_array['minDate'] != '')
			{
				$date_res = ','.'minDate: \''.$calendar_params_array['minDate'].'\'';
			}
		if ($calendar_params_array['maxDate'] != '')
			{
				$date_res .= ','.'maxDate: \''.$calendar_params_array['maxDate'].'\'';
			}
		if ($calendar_params_array['yearRange'] != '')
			{
				$date_res .= ','.'yearRange: \''.$calendar_params_array['yearRange'].'\'';
			}

?>
<script language="javascript" type="text/javascript">
<?php
if($myprofile->js_string_data != '')
	echo $myprofile->js_string_data;
?>
/**
 *
 * @access public
 * @return void
 **/
var textarea_rows = 3;
$Jq(document).ready(function() {
     $Jq('.editablearea_basic').editable(function(value, settings){
     		var divid = $Jq(this).attr('id');
     		var elements = divid.split('_');
     		var element_name = elements[1];
     		var question_type = '';
     		var original_value = this.revert;
	   		openAjaxWindow('true', 'ajaxupdate', 'updateProfileDataText', divid, element_name, value, question_type, original_value, 'profileBasic.php');
     		//return '<?php //echo $LANG['edit_in_place_updating'];?>';
	  },
      {
      	 indicator :  '<img src="<?php echo $CFG['site']['url']?>design/templates/<?php echo $CFG['html']['template']['default']?>/images/indicator.gif">',
         type      : 'textarea',
         rows      : textarea_rows,
         cancel    : '<?php echo $LANG['edit_in_place_cancel'];?>',
         submit    : '<?php echo $LANG['edit_in_place_ok'];?>',
         tooltip   : '<?php echo $LANG['click_here_to_edit'];?>'
     });


     $Jq('.editablearea_info').editable(function(value, settings){
     		var divid = $Jq(this).attr('id');
     		var elements = divid.split('_');
     		var element_name = elements[1];
     		var question_type = elements[2]
     		var original_value = this.revert;
     		openAjaxWindow('true', 'ajaxupdate', 'updateProfileDataText', divid, question_type, value, element_name, original_value);
	  },
      {
      	 indicator :  '<img src="<?php echo $CFG['site']['url']?>design/templates/<?php echo $CFG['html']['template']['default']?>/images/indicator.gif">',
         type      : 'textarea',
         rows      : textarea_rows,
         cancel    : '<?php echo $LANG['edit_in_place_cancel'];?>',
         submit    : '<?php echo $LANG['edit_in_place_ok'];?>',
         tooltip   : '<?php echo $LANG['click_here_to_edit'];?>'
     });

     $Jq('.editableselect_info').editable(function(value, settings){
     		var divid = $Jq(this).attr('id');
     		var elements = divid.split('_');
     		var element_name = elements[1];
     		var question_type = elements[2];
     		var original_value = this.revert;
     		openAjaxWindow('true', 'ajaxupdate', 'updateProfileDataText', divid, question_type, value, element_name, original_value);
	  },
      {
      	 data	   :  function(value, settings)
      	 				{
      	 					divid1 = $Jq(this).attr('id');
     						elements1 = divid1.split('_');
     						element_name1 = elements1[1];
     						arr_name = 'infoarray_'+element_name1;
      	 					return arr_name;
      	 				},
      	 indicator :  '<img src="<?php echo $CFG['site']['url']?>design/templates/<?php echo $CFG['html']['template']['default']?>/images/indicator.gif">',
         type      : 'select',
         cancel    : '<?php echo $LANG['edit_in_place_cancel'];?>',
         submit    : '<?php echo $LANG['edit_in_place_ok'];?>',
         tooltip   : '<?php echo $LANG['click_here_to_edit'];?>'
     });

     $Jq('.editablecheck_info').editable(function(value, settings){
     		var divid = $Jq(this).attr('id');
     		var elements = divid.split('_');
     		var element_name = elements[1];
     		var question_type = elements[2];
     		var original_value = this.revert;
     		openAjaxWindow('true', 'ajaxupdate', 'updateProfileDataText', divid, question_type, value, element_name, original_value);
     		//return '<?php echo $LANG['edit_in_place_updating'];?>';
	  },
      {
      	 data	   :  function(value, settings)
      	 				{
      	 					divid1 = $Jq(this).attr('id');
     						elements1 = divid1.split('_');
     						element_name1 = elements1[1];
     						arr_name = 'infoarray_'+element_name1;
      	 					return arr_name;
      	 				},
      	 indicator :  '<img src="<?php echo $CFG['site']['url']?>design/templates/<?php echo $CFG['html']['template']['default']?>/images/indicator.gif">',
         type      : 'multipleselect',
         cancel    : '<?php echo $LANG['edit_in_place_cancel'];?>',
         submit    : '<?php echo $LANG['edit_in_place_ok'];?>',
         tooltip   : '<?php echo $LANG['click_here_to_edit'];?>'
     });

     $Jq('.editableselect_basic').editable(function(value, settings){
     		var divid = $Jq(this).attr('id');
     		var elements = divid.split('_');
     		var element_name = elements[1];
     		var question_type = element_name;
     		var original_value = this.revert;
     		openAjaxWindow('true', 'ajaxupdate', 'updateProfileDataText', divid, element_name, value, question_type, original_value, 'profileBasic.php');
     		//return '<?php echo $LANG['edit_in_place_updating'];?>';
	  },
      {
      	 data	   :  function(value, settings)
      	 				{
      	 					divid1 = $Jq(this).attr('id');
     						elements1 = divid1.split('_');
     						element_name1 = elements1[1];
     						arr_name = 'infoarray_'+element_name1;
      	 					return arr_name;
      	 				},
      	 indicator :  '<img src="<?php echo $CFG['site']['url']?>design/templates/<?php echo $CFG['html']['template']['default']?>/images/indicator.gif">',
         type      : 'select',
         cancel    : '<?php echo $LANG['edit_in_place_cancel'];?>',
         submit    : '<?php echo $LANG['edit_in_place_ok'];?>',
         tooltip   : '<?php echo $LANG['click_here_to_edit'];?>'
     });

 });
</script>
<?php } ?>
<?php
if($layout_submit_preview)
	{
?>
<script language="javascript">
	var theme = window.opener.document.formAddLayout.layout.value;
	$Jq('#userLayout').html(theme);
</script>
<?php
	}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$myprofile->includeFooter();
?>
