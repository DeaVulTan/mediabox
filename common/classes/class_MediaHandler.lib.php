<?php
/**
 * Class to handle the form fields
 *
 * This is having class FormHandler to handle the validation of form fields, to
 * set or get values for form fields, to handle page blocks, to handle CSS for
 * form fields and to populate the common static array file.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 */
if(class_exists('ListRecordsHandler'))
	{
		if(!class_exists('MainMediaHandler'))
			{
				$parent_class = 2;
			}
	}
else
	{
		if(!class_exists('MainMediaHandler'))
			{
				$parent_class = 1;
			}
	}

switch($parent_class)
	{
		case 2:
			class MainMediaHandler extends ListRecordsHandler{}
			break;
		case 1:
		default:
			class MainMediaHandler extends FormHandler{}
			break;
	}

/**
 * MediaHandler
 *
 * @package
 * @author
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MediaHandler extends MainMediaHandler
	{
		/**
		 * MediaHandler::getTotalFriends()
		 *
		 * @param mixed $owner_id
		 * @return
		 */
		public function getTotalFriends($owner_id)
			{
				if(isset($this->TotalFriends_arr[$owner_id]))
					{
						return $this->TotalFriends_arr[$owner_id];
					}
				$sql = 'SELECT total_friends FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
				    {
				        $this->TotalFriends_arr[$owner_id] = $row['total_friends'];
						return $row['total_friends'];
				    }
				$this->TotalFriends_arr[$owner_id] = 0;
				return 0;
			}

		/**
		 * MediaHandler::getFriendsList()
		 *
		 * @param mixed $owner_id
		 * @param integer $total_friends
		 * @return
		 */
		public function getFriendsList($owner_id, $total_friends = 0)
			{
				if(isset($this->FriendsList_arr[$owner_id]))
					{
						return;
					}

				$additional_query = '';
				if($total_friends)
					$additional_query = ' LIMIT '.$total_friends;

				$sql = 'SELECT id, friend_id FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id='.$this->dbObj->Param('owner_id').$additional_query;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$friends = array();
				$id  = array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$friends[] = $row['friend_id'];
								$id[] = $row['id'];
							}
					}
				$this->FriendsList_arr[$owner_id] = 'true';
				$this->FriendsList = implode(',', $friends);
				$this->FriendsListIds = implode(',', $id);
			}

		/**
		 * MediaHandler::getAdditionalQuery()
		 *
		 * @param string $alias
		 * @return
		 */
		public function getAdditionalQuery($alias = '')
			{
				$additional = '';
				if(isMember())
					{
						$user_id = $this->CFG['user']['user_id'];
						if ($total_friends = $this->getTotalFriends($user_id))
						    {
								$this->getFriendsList($user_id, $total_friends);

								if(!($this->FriendsListIds and $this->FriendsList))
									return $additional;

								/*$additional = ' OR ((relation_id=\'\' AND  '.$alias.'user_id IN('.$this->FriendsList.')) OR ( SELECT fr.relation_id FROM'.
												' '.$this->CFG['db']['tbl']['friends_relation'].' AS fr	WHERE FIND_IN_SET(fr.relation_id, '.$alias.'relation_id) > 0 '.
												' AND friendship_id IN ('.$this->FriendsListIds.') LIMIT 1'.
												' ))';*/

								$additional = ' OR (( SELECT SQL_CACHE fr.relation_id FROM'.
												' '.$this->CFG['db']['tbl']['friends_relation'].' AS fr	WHERE FIND_IN_SET(fr.relation_id, '.$alias.'relation_id) > 0 '.
												' AND friendship_id IN ('.$this->FriendsListIds.') LIMIT 1'.
												' ))';
						    }
					}
				return $additional;
			}

		/**
		 * MediaHandler::populateCheckBoxForRelationList()
		 *
		 * @param mixed $admin
		 * @return
		 */
		public function populateCheckBoxForRelationList($admin = false)
			{
				$return= array();
				global $smartyObj;
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param('user_id').' AND total_contacts>0'.
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$inc=0;
				$this->relation_list_count=0;
				if($rs->PO_RecordCount())
					{
						$this->relation_list_count=$rs->PO_RecordCount();
						while($row = $rs->FetchRow())
						{
							$return[$inc]['record']=$row;
							$inc++;
						}
					}
				$smartyObj->assign('populateCheckBoxForRelationList', $return);
				if($admin)
					setTemplateFolder('admin/');
				else
					setTemplateFolder('general/');
				$smartyObj->display('populateCheckBoxForRelationList.tpl');

			}

		/**
		 * MediaHandler::changeMyContentFilterSettings()
		 *
		 * @param mixed $user_id
		 * @param mixed $status
		 * @return
		 */
		public function changeMyContentFilterSettings($user_id, $status)
			{
				global $CFG;
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' content_filter='.$this->dbObj->Param('content_filter').' WHERE'.
						' user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status, $user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$CFG['user']['content_filter'] = $this->CFG['user']['content_filter'] = $_SESSION['user']['content_filter'] = $status;
			}

		/**
		 * MediaHandler::setMediaPath()
		 *
		 * @param string $path
		 * @return
		 */
		public function setMediaPath($path='../../')
			{
				$this->media_relative_path = $path;
			}

		/**
		 * MediaHandler::getAdultQuery()
		 *
		 * @param string $additional
		 * @return
		 */
		public function getAdultQuery($alias = '', $table='video')
			{
				$additional = '';

				if(isAdultUser('list'))
					return $additional;

				if($table=='playlist' or $table=='video_playlist')
					return $additional;

				$additional = ' AND exists(SELECT '.$table.'_category_id FROM '.$this->CFG['db']['tbl'][$table.'_category'].
							' AS vca WHERE '.$table.'_category_type!=\'Porn\' AND'.
							' '.$alias.$table.'_category_id=vca.'.$table.'_category_id)';

				return $additional;
			}

		/**
		 * MediaHandler::homeExecuteQuery()
		 *
		 * @return
		 **/
		public function homeExecuteQuery()
			{
				//count...
				// prepare query
				$stmt = $this->dbObj->Prepare($this->sql_count);
				// execute query
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				// fetch array of row
				$row = $rs->fetchRow();
				// counts number of rows
				$this->results_tot_num = $rs->PO_RecordCount();
				$this->results_end_num = $this->results_tot_pages_num = 0;
				//main query.. don't query the whole unnecessarily...
				if ($this->results_tot_num)
					{
						$this->results_tot_pages_num = ceil($this->results_tot_num/$this->results_num_per_page);
						// prepare query
						$stmt = $this->dbObj->Prepare($this->
						sql);
						// execute query
						$this->rs = $this->dbObj->Execute($stmt);
						//raise user error... fatal
						if (!$this->rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						// sets total number of records
						$this->results_end_num = $this->results_start_num + $this->rs->PO_RecordCount();
					}
			}

		public function createErrorLogFile($prefixFileName='')
		{
			$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/temp_log'.'/';
			$this->chkAndCreateFolder($temp_dir);
			$temp_file_path = $temp_dir.$prefixFileName.'_'.$this->CFG['user']['user_id'].time().'.txt';
			@$this->fp = fopen($temp_file_path, 'w');
			$this->writePHPSettings();
		}

		public function writePHPSettings()
		{
			$log_str  = date("F j, Y, g:i a")."\r\n";
			$log_str .= 'Memory Limit : '.(string)ini_get('memmory_limit')."\r\n";
			$log_str .= 'Max execution time : '.(string)ini_get('max_execution_time')."\r\n";
			$log_str .= 'max Input TIme : '.(string)ini_get('max_input_time')."\r\n";
			$log_str .= 'Post Max Size : '.(string)ini_get('post_max_size')."\r\n";
			$log_str .= 'Upload Max size : '.(string)ini_get('upload_max_filesize')."\r\n";
			$this->writetoTempFile($log_str);
		}
		public function writetoTempFile($video_upload_str)
			{
				if(@!$this->fp)
				{
				$this->createErrorLogFile();
				}
					@fwrite($this->fp, $video_upload_str);
			}
		public function closeErrorLogFile()
			{
				if ($this->fp)
				{
					fclose($this->fp);
				}
			}

		public function _parse_tags($tag_string, $field_size_min=false)
			{
				if(empty($field_size_min))
					$field_size_min = $this->CFG['fieldsize']['tags']['min'];

				$newwords = array();
				$tag_string = trim($tag_string);

				if ($tag_string == '')
					{
						// If the tag string is empty, return the empty set.
						return $newwords;
					}

				# Perform tag parsing
				if(get_magic_quotes_gpc())
					{
						$query = stripslashes(trim($tag_string));
					}
				else
					{
						$query = trim($tag_string);
					}

				$words = preg_split('/ /', $query,-1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

				$delim = 0;
				foreach ($words as $key => $word)
					{
						if ($word == '"')
							{
								$delim++;
								continue;
							}
						if (($delim % 2 == 1) && $words[$key - 1] == '"')
							{
								##strlen function has to be replace for Arabic language. In getStringLength() fucntion Multi byte String is checked and returing the string length.
								if (getStringLength($word) <= $field_size_min)
								    {
								        continue;
						    		}
								$newwords[] = $word;
							}
						else
							{
								## Modifed below line to Remove Static configuration to Tag minimum sixe configuration
								if (getStringLength($word) <= $field_size_min)
								    {
										$newwords[] = $word;
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
								## Modifed below line to Remove Static configuration to Tag minimum sixe configuration
								if (getStringLength($value) >= $field_size_min)
								    {
										$temp[] = $value;
								    }
							}
						$newwords = $temp;
				    }
				return $newwords;
			}

		public function getMultiUserDetails($user_ids, $fields_list = array(), $usr_status = false)
			{
				$fields_list_arr = $fields_list;
				$fields_list = implode(',', $fields_list);

				$condition = '';
				if($usr_status)
					$condition = ' AND usr_status =\'Ok\'';

				$sql = 'SELECT '.$fields_list.',user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE FIND_IN_SET(user_id,'.$this->dbObj->Param('user_id').')'.
						$condition;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_ids));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->UserDetails = array();

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$this->UserDetails[$row['user_id']] = $row;
								$this->memberProfileUrl[$row['user_id']] = getMemberProfileUrl($row['user_id'], $row['user_name']);
							}
					}
			}

		public function fileWrite($file_path, $text)
			{
				$file = fopen($file_path, 'w');
				fwrite($file, $text);
				fclose($file);
			}
		public function removeDirectory($dirname)
			{
				if (is_dir($dirname))
			   		{
				       	$result = array();
				   		if (substr($dirname,-1) != '/')
							{
								$dirname.='/';
							}
					  	$handle = opendir($dirname);
					    while (false !== ($file = readdir($handle)))
						   {
					   			if ($file != '.' && $file != '..')
							   		{    //Ignore . and ..
						               $path = $dirname.$file;
						               	if (is_dir($path))
									   		{    //Recurse if subdir, Delete if file
						                   		$result=array_merge($result, $this->removeDirectory($path));
						            		}
										else
											{
								            	unlink($path);
								                $result[].=$path;
					               			}
				           			}
			       			}
					     closedir($handle);
					     rmdir($dirname);
					     $result[].=$dirname;
					     return $result;
			   		}
				else
					{
				       return false;
				   	}
			}
		public function setFontSizeInsteadOfSearchCountSidebar($tag_array=array())
			{
				$formattedArray = $tag_array;
				$max_qty = max(array_values($formattedArray));
				$min_qty = min(array_values($formattedArray));
				$max_font_size = 27;
				$min_font_size = 12;
				$spread = $max_qty - $min_qty;
				if (0 == $spread) { // Divide by zero
					$spread = 1;
				}
				$step = ($max_font_size - $min_font_size)/($spread);
					foreach ($tag_array as $catname => $count)
					{
						$size = $min_font_size + ($count - $min_qty) * $step;
						$formattedArray[$catname] = ceil($size);
					}
				return $formattedArray;
			}
		public function populateRatingImages($rating = 0,$imagePrefix='',$condition='',$url='', $module='video')
			{
				global $smartyObj;
				if($module!= '')
					$module .= '/';
				$populateRatingImages_arr = array();
				$populateRatingImages_arr['rating'] = $rating;
				$populateRatingImages_arr['condition'] = $condition;
				$populateRatingImages_arr['url'] = $url;
				$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
				if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
					$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];

				$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'ratehover.gif';
				$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'rate.gif';
				$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
				setTemplateFolder('general/');
				$smartyObj->display('populateRatingImages.tpl');
			}



	}
?>
