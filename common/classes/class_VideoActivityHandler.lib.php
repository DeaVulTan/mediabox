<?php
/**
 * Class to handle the Video Activities module
 *
 * This is having class videoActivity to handle
 *
 *
 * @category	Rayzz
 * @package		Common/Classes
 */
//------------------- Class videoActivityHandler begins ------------------->>>>>//
class VideoActivityHandler extends FormHandler
	{
		private $dbObj;

		private $CFG = array();

		private $LANG = array();

		public function __construct()
			{
				global $CFG, $LANG, $db;
				$this->dbObj 	= $db;
				$this->CFG 		= $CFG;
				$this->LANG 	= $LANG;
			}

		public function strReplace($subject, $operation = 'add')
			{
				if($operation == 'add')
					{
						$search = '~';
						$replace = '***!!!***';
						return str_replace($search, $replace, $subject, $count);
					}
				elseif ($operation == 'display')
					{
						$search = '***!!!***';
						$replace = '~';
						return str_replace($search, $replace, $subject, $count);
					}
			}

		/**
		 * VideoActivityHandler::addActivity()
		 *  To add video activities
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function addActivity($activity_arr)
			{
			  /*1.	video_uploaded
				2.	video_comment
				3.	video_rated
				4.	video_favorite
				5.	video_featured
				6.	video_responded
				7.	video_share
				8.	delete_video_favorite
				9.	delete_video_featured*/
				switch($activity_arr['action_key'])
					{
						case 'video_uploaded':
							$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
							$action_value = $activity_arr['upload_user_id'].'~'.
												$activity_arr['upload_user_name'].'~'.
												$activity_arr['video_id'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~';

								$activity_val_arr = array($activity_arr['upload_user_id'],
															$activity_arr['upload_user_id']);

								$video_activity_val_arr = array($activity_arr['video_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['upload_user_id'],
																$activity_arr['upload_user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'video_comment':
							$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
							$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['comment_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['comment_user_id']);

								$video_activity_val_arr = array($activity_arr['video_comment_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['comment_user_id'],
																	$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'video_rated':
							$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
							$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['rating_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~'.
												$activity_arr['rate'].'~';

							//Cheack actor already rate same content..
							$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['video_activity'].
									' WHERE action_key= \'video_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
									' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

							$row['content_id'] = $rs->FetchRow();
							//die('I am in rating');


							if(empty($row['content_id']))
								{
									$activity_val_arr = array($activity_arr['user_id'],
																$activity_arr['rating_user_id']);

									$video_activity_val_arr = array($activity_arr['rating_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['rating_user_id'],
																	$activity_arr['user_id']);

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
											' SET module = \'video\','.
											' owner_id = '.$this->dbObj->Param('user_id').','.
											' actor_id = '.$this->dbObj->Param('rating_user_id').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

									$parent_id = $this->dbObj->Insert_ID();

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
											' SET parent_id = '.$parent_id.','.
											' content_id = '.$this->dbObj->Param('content_id').','.
											' action_key = '.$this->dbObj->Param('action_key').','.
											' action_value = '.$this->dbObj->Param('action_value').','.
											' actor_id = '.$this->dbObj->Param('actor_id').','.
											' owner_id = '.$this->dbObj->Param('action_value').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

									$child_id = $this->dbObj->Insert_ID();

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
											' SET child_id = '.$child_id.
											' WHERE parent_id = '.$parent_id;

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								}
							else
								{
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_activity'].
											' SET date_added = NOW(), '.
											' action_value = \''.$action_value.'\' '.
											' WHERE action_key= \'video_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
											' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								}
							break;

						case 'video_favorite':
								$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
								$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['favorite_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['favorite_user_id']);

								$video_activity_val_arr = array($activity_arr['video_favorite_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['favorite_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'video_featured':
							$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
							$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['featured_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['featured_user_id']);

								$video_activity_val_arr = array($activity_arr['video_featured_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['featured_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'video_responded':
								$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
								$activity_arr['old_video_title'] = $this->strReplace($activity_arr['old_video_title']);
								$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['responses_user_id'].'~'.
												$activity_arr['responses_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['old_video_id'].'~'.
												$activity_arr['old_video_title'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['responses_user_id']);

								$video_activity_val_arr = array($activity_arr['video_responses_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['responses_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('responses_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'video_share':
								$activity_arr['video_title'] = $this->strReplace($activity_arr['video_title']);
								$action_value = $activity_arr['video_id'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['video_title'].'~'.
												$activity_arr['video_server_url'].'~'.
												$activity_arr['is_external_embed_video'].'~'.
												$activity_arr['embed_video_image_ext'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'].'~';


								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$video_activity_val_arr = array($activity_arr['video_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'video\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $video_activity_val_arr);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							break;

						case 'delete_video_favorite';
								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['video_activity'].
										' WHERE action_key= \'video_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['video_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);

								if($row = $rs->FetchRow())
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET status = \'Deleted\' '.
												' WHERE parent_id= '.$row['parent_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_activity'].
												' SET status = \'Deleted\' '.
												' WHERE action_key= \'video_favorite\' AND actor_id= '.
												$activity_arr['favorite_user_id'].' '.
												' AND owner_id= '.$activity_arr['user_id'].
												' AND  content_id= '.$activity_arr['video_favorite_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
							break;

						case 'delete_video_featured';
								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['video_activity'].
										' WHERE action_key= \'video_featured\' AND actor_id= '.$activity_arr['featured_user_id'].
										' AND owner_id= '.$activity_arr['user_id'].
										' AND content_id= '.$activity_arr['video_featured_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.
										$this->dbObj->ErrorMsg(), E_USER_ERROR);

								if($row = $rs->FetchRow())
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET status = \'Deleted\' '.
												' WHERE parent_id= '.$row['parent_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_activity'].
												' SET status = \'Deleted\' '.
												' WHERE action_key= \'video_featured\''.
												' AND actor_id= '.$activity_arr['featured_user_id'].' '.
												' AND owner_id= '.$activity_arr['user_id'].
												' AND  content_id= '.$activity_arr['video_featured_id'];

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

									}
							break;
					}
			}

		/**
		 * VideoActivityHandler::getActivities()
		 *  To get activity details from geral_activity table
		 *
		 * @param array $activityID_arr
		 * @return void
		 */
		public function getActivities($activityID_arr)
			{
				$getActivities_arr = array();
				$inc = 0;
				$activityIDs = implode(',', $activityID_arr);
				//foreach($activityID_arr as $key=>$value)
					{
						$sql = 'SELECT content_id, action_key, action_value, owner_id,'.
								' actor_id, parent_id, TIMEDIFF(NOW(), date_added) as date_added FROM '.$this->CFG['db']['tbl']['video_activity'].
								' WHERE status=\'Yes\' AND id IN ('.$activityIDs.')';

						/*$sql = 'SELECT content_id, action_key, action_value, owner_id, actor_id'.
								' FROM '.$this->CFG['db']['tbl']['video_activity'].
								' WHERE status=\'Yes\' AND id='.$this->dbObj->Param('activity_id');*/

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if ($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow()) //if($row = $rs->FetchRow())
								    {
										//echo $row['action_key'].'ac   '.$row['action_value'].' <br />';
										$getActivities_arr[] = $row;
			 					    }
			 					$inc++;
							}
					}
				//return $this->generateActivities($getActivities_arr);
				$this->generateActivities($getActivities_arr);
			}

		/**
		 * VideoActivityHandler::generateActivities()
		 *  To generate activities for different actions
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function generateActivities($activity_arr)
			{
				global $smartyObj;
				$generateActivities_arr = array();
				//$rayzz = new RayzzHandler($this->dbObj, $this->CFG);
				$videos_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['videos']['folder'] . '/' . $this->CFG['admin']['videos']['thumbnail_folder'] . '/';
				require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/video/videoActivity.php');
				//require_once('languages/'.$this->CFG['lang']['default'].'/video/videoActivity.php');
				for($i=0;$i<count($activity_arr);$i++)
					{
						$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
						$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
						switch($activity_arr[$i]['action_key'])
							{
								case 'video_uploaded':
										/*	0.upload_user_id
											1.upload_user_name
											2.video_id
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
										*/
										$generateActivities_arr[$i]['video_uploaded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details = $this->getUserDetail('user_id',$value[0], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_uploaded']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_uploaded']['user_name'] = $value[1];
													}
												$generateActivities_arr[$i]['video_uploaded']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_uploaded']['uploaded_user']['url'] = getMemberProfileUrl($value[0], $value[1]);
												$generateActivities_arr[$i]['video_uploaded']['profileIcon']=getMemberAvatarDetails($value[0]);

												//$generateActivities_arr[$i]['video_uploaded']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[2]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_uploaded']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_uploaded']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[2].'&amp;title='.$this->changeTitle($value[3]), $value[2].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_uploaded']['lang'] = $LANG['videoactivity_upload_text'];
												$generateActivities_arr[$i]['video_uploaded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'video_comment':
										/*	0.video_id
											1.comment_user_id
											2.user_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
										*/
										$generateActivities_arr[$i]['video_comment'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_comment']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_comment']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['video_comment']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['video_comment']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[5] == 'Yes' && $value[6] == '')
													$generateActivities_arr[$i]['video_comment']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_comment']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_comment']['lang'] = $LANG['videoactivity_comment_text'];
												$generateActivities_arr[$i]['video_comment']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_comment']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
								break;

								case 'video_rated':
										/*	0.video_id
											1.rating_user_id
											2.user_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
											7.rate
										*/
										$generateActivities_arr[$i]['video_rated'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_rated']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_rated']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['video_rated']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_rated']['rate'] = $value[7];
												$generateActivities_arr[$i]['video_rated']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['video_rated']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_rated']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_rated']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_rated']['lang'] = str_replace('{rate}',$value[7],$LANG['videoactivity_rating_text']);
												$generateActivities_arr[$i]['video_rated']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_rated']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
								break;

								case 'video_favorite':
										/*	0.video_id
											1.favorite_user_id
											2.user_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
										*/
										$generateActivities_arr[$i]['video_favorite'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_favorite']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_favorite']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['video_favorite']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['video_favorite']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_favorite']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_favorite']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_favorite']['lang'] = $LANG['videoactivity_favorite_text'];
												$generateActivities_arr[$i]['video_favorite']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_favorite']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
									break;

								case 'video_featured':
										/*	0.video_id
											1.favorite_user_id
											2.user_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
										*/
										$generateActivities_arr[$i]['video_featured'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_featured']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_featured']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['video_featured']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['video_featured']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_featured']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_featured']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_featured']['lang'] = $LANG['videoactivity_featured_text'];
												$generateActivities_arr[$i]['video_featured']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_featured']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
								break;

								case 'video_responded':
										/*	0.video_id
											1.responses_user_id
											2.responses_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
											7.user_id
											8.user_name
											9.old_video_id
											10.old_video_title
										*/
										$generateActivities_arr[$i]['video_responded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$value[10] = $this->strReplace($value[10], 'display');
										$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_responded']['responses_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_responded']['responses_user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['video_responded']['video_title'] = $value[3];
												$generateActivities_arr[$i]['video_responded']['responses_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['video_responded']['old_user_name'] = $value[8];
												$generateActivities_arr[$i]['video_responded']['old_user']['url'] = getMemberProfileUrl($value[7], $value[8]);
												$generateActivities_arr[$i]['video_responded']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_responded']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_responded']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_responded']['old_video_title'] = $value[10];
												$generateActivities_arr[$i]['video_responded']['old_viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[9].'&amp;title='.$this->changeTitle($value[10]), $value[9].'/'.$this->ChangeTitle($value[10]).'/', '', 'video');
												$generateActivities_arr[$i]['video_responded']['lang'] = $LANG['videoactivity_responded_text'];
												$generateActivities_arr[$i]['video_responded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_responded']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
								break;

								case 'video_share':
										/*	0.video_id
											1.user_id
											2.user_name
											3.video_title
											4.video_server_url
											5.is_external_embed_video
											6.embed_video_image_ext
											7.sender_user_id
											8.sender_user_name
											9.firend_list
										*/
										$generateActivities_arr[$i]['video_share'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$generateActivities_arr[$i]['video_share']['video_title'] = $value[3];
										$generateActivities_arr[$i]['video_share']['sender']['url'] = getMemberProfileUrl($value[7], $value[8]);
										$user_details = $this->getUserDetail('user_id',$value[7], 'user_name');
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['video_share']['sender_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['video_share']['sender_user_name'] = $value[8];
													}

												$generateActivities_arr[$i]['video_share']['video']['imgsrc'] = $value[4] . $videos_folder . getVideoImageName($value[0]) . $this->CFG['admin']['videos']['small_name'] . '.' . $this->CFG['video']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['video_share']['video']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-video.gif';

												$generateActivities_arr[$i]['video_share']['firend_list'] = array();
												$firend_list = explode(',', $value[9]);

												for($inc = 0; $inc < count($firend_list)-1; $inc++)
													{
														$sql = 'SELECT u.user_name, u.user_id, u.first_name, u.last_name'.
																' FROM '.$this->CFG['db']['tbl']['users'].' as u '.
																' WHERE u.email = \''.$firend_list[$inc].'\'';

														$stmt = $this->dbObj->Prepare($sql);
														$rs = $this->dbObj->Execute($stmt);
														if (!$rs)
															trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

														$row = $rs->FetchRow();
														if(!empty($row))
															{
																$generateActivities_arr[$i]['video_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
																if($this->CFG['admin']['display_first_last_name'])
																	{
																		$generateActivities_arr[$i]['video_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].
																																						' '.$row['last_name'];
																	}
																else
																	{
																		$generateActivities_arr[$i]['video_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
																	}
															}
													}

												$generateActivities_arr[$i]['video_share']['viewvideo']['url'] = getUrl('viewvideo', '?video_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'video');
												$generateActivities_arr[$i]['video_share']['lang1'] = $LANG['videoactivity_shared_text1'];
												$generateActivities_arr[$i]['video_share']['lang2'] = $LANG['videoactivity_shared_text2'];
												$generateActivities_arr[$i]['video_share']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
												$generateActivities_arr[$i]['video_share']['profileIcon']=getMemberAvatarDetails($value[1]);
											}
								break;
							}
					}
				$smartyObj->assign('videoActivity_arr', $generateActivities_arr);
			}
	}
?>