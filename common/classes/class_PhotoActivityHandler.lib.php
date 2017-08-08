<?php
/**
 * Class to handle the photo Activities module
 *
 * This is having class photoActivity to handle
 * IMP action_value format: first letter must be photo_id or playlist_id
 *
 * @category	Rayzz
 * @package		Common/Classes
 */

class photoActivityHandler extends FormHandler
	{
		private $dbObj;
		private $CFG = array();
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
		 * photoActivityHandler::addActivity()
		 *  To add photo activities
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function addActivity($activity_arr)
			{


			  /*1.	photo_uploaded
				2.	photo_comment
				3.	photo_rated
				4.	photo_favorite
				5.	photo_featured
				6.	photo_responded
				7.	photo_share
				8.	delete_photo_favorite
				9.	delete_photo_featured
				10.	photo_movie_created*/
			switch($activity_arr['action_key'])
					{

						case 'photo_uploaded':
							$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
							$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['upload_user_id'].'~'.
												$activity_arr['upload_user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'];

								$activity_val_arr = array($activity_arr['upload_user_id'],
															$activity_arr['upload_user_id']);
								$photo_activity_val_arr = array($activity_arr['photo_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['upload_user_id'],
																$activity_arr['upload_user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);
								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'photo_comment':
							$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
							$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['comment_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['comment_user_id']);
								$photo_activity_val_arr = array($activity_arr['photo_comment_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['comment_user_id'],
																	$activity_arr['user_id']);
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'photo_rated':
							$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
							$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['rating_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['rate'].'~';

							//Cheack actor already rate same content..
							$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
									' WHERE action_key= \'photo_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
									' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['photo_rating_id'].'\' ';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row['content_id'] = $rs->FetchRow();

							if(empty($row['content_id']))
								{
									$activity_val_arr = array($activity_arr['user_id'],
																$activity_arr['rating_user_id']);

									$photo_activity_val_arr = array($activity_arr['photo_rating_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['rating_user_id'],
																	$activity_arr['user_id']);

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
											' SET module = \'photo\','.
											' owner_id = '.$this->dbObj->Param('user_id').','.
											' actor_id = '.$this->dbObj->Param('rating_user_id').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);
									$parent_id = $this->dbObj->Insert_ID();
									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
											' SET parent_id = '.$parent_id.','.
											' content_id = '.$this->dbObj->Param('content_id').','.
											' action_key = '.$this->dbObj->Param('action_key').','.
											' action_value = '.$this->dbObj->Param('action_value').','.
											' actor_id = '.$this->dbObj->Param('actor_id').','.
											' owner_id = '.$this->dbObj->Param('action_value').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);

									$child_id = $this->dbObj->Insert_ID();

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
											' SET child_id = '.$child_id.
											' WHERE parent_id = '.$parent_id;
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);
								}
							else
								{
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
											' SET date_added = NOW(), '.
											' action_value = \''.$action_value.'\' '.
											' WHERE action_key= \'photo_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
											' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['photo_rating_id'].'\' ';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);
								}
							break;

						case 'photo_favorite':
								$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
								$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['favorite_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['favorite_user_id']);
								$photo_activity_val_arr = array($activity_arr['photo_favorite_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['favorite_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'photo_featured':
							$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
							$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['featured_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['featured_user_id']);

								$photo_activity_val_arr = array($activity_arr['photo_featured_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['featured_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'photo_responded':
								$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
								$activity_arr['old_photo_title'] = $this->strReplace($activity_arr['old_photo_title']);
								$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['responses_user_id'].'~'.
												$activity_arr['responses_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['old_photo_id'].'~'.
												$activity_arr['old_photo_title'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['responses_user_id']);

								$photo_activity_val_arr = array($activity_arr['photo_responses_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['responses_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('responses_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'photo_share':
								$activity_arr['photo_title'] = $this->strReplace($activity_arr['photo_title']);
								$action_value = $activity_arr['photo_id'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_title'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'].'~'.
												$activity_arr['photo_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$photo_activity_val_arr = array($activity_arr['photo_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'delete_photo_favorite';
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
										' SET status = \'Deleted\' '.
										' WHERE action_key= \'photo_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
										' WHERE action_key= \'photo_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
								$row = $rs->FetchRow();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET status = \'Deleted\' '.
										' WHERE parent_id= '.$row['parent_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);


							break;

						case 'delete_photo_featured';
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
										' SET status = \'Deleted\' '.
										' WHERE action_key= \'photo_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_featured_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
										' WHERE action_key= \'photo_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_featured_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
								$row = $rs->FetchRow();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET status = \'Deleted\' '.
										' WHERE parent_id= '.$row['parent_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						case 'playlist_comment': // PLAYLIST //
							$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
							$action_value = $activity_arr['playlist_id'].'~'.
												$activity_arr['comment_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['playlist_name'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['photo_id'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['comment_user_id']);
								$photo_activity_val_arr = array($activity_arr['playlist_comment_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['comment_user_id'],
																	$activity_arr['user_id']);
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

							case 'playlist_rated':
								$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
								$action_value = $activity_arr['playlist_id'].'~'.
													$activity_arr['rating_user_id'].'~'.
													$activity_arr['user_name'].'~'.
													$activity_arr['playlist_name'].'~'.
													$activity_arr['photo_server_url'].'~'.
													$activity_arr['photo_ext'].'~'.
													$activity_arr['rate'].'~'.
													$activity_arr['photo_id'].'~';

								//Cheack actor already rate same content..
								$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
										' WHERE action_key= \'photo_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
										' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['photo_rating_id'].'\' ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row['content_id'] = $rs->FetchRow();

								if(empty($row['content_id']))
									{
										$activity_val_arr = array($activity_arr['user_id'],
																	$activity_arr['rating_user_id']);

										$photo_activity_val_arr = array($activity_arr['rating_id'],
																		$activity_arr['action_key'],
																		$action_value,
																		$activity_arr['rating_user_id'],
																		$activity_arr['user_id']);

										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
												' SET module = \'photo\','.
												' owner_id = '.$this->dbObj->Param('user_id').','.
												' actor_id = '.$this->dbObj->Param('rating_user_id').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);
										$parent_id = $this->dbObj->Insert_ID();
										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
												' SET parent_id = '.$parent_id.','.
												' content_id = '.$this->dbObj->Param('content_id').','.
												' action_key = '.$this->dbObj->Param('action_key').','.
												' action_value = '.$this->dbObj->Param('action_value').','.
												' actor_id = '.$this->dbObj->Param('actor_id').','.
												' owner_id = '.$this->dbObj->Param('action_value').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);

										$child_id = $this->dbObj->Insert_ID();

										$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
												' SET child_id = '.$child_id.
												' WHERE parent_id = '.$parent_id;
										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_db_error($this->dbObj);
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
												' SET date_added = NOW(), '.
												' action_value = \''.$action_value.'\' '.
												' WHERE action_key= \'photo_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
												' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['photo_rating_id'].'\' ';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt);
										if (!$rs)
											trigger_db_error($this->dbObj);
									}
							break;

						case 'playlist_featured':
							$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
							$action_value = $activity_arr['playlist_id'].'~'.
												$activity_arr['featured_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['playlist_name'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['photo_id'].'~';

							$activity_val_arr = array($activity_arr['user_id'],
														$activity_arr['featured_user_id']);

							$photo_activity_val_arr = array($activity_arr['photo_playlist_featured_id'],
															$activity_arr['action_key'],
															$action_value,
															$activity_arr['featured_user_id'],
															$activity_arr['user_id']);

							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
									' SET module = \'photo\','.
									' owner_id = '.$this->dbObj->Param('user_id').','.
									' actor_id = '.$this->dbObj->Param('featured_user_id').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$parent_id = $this->dbObj->Insert_ID();
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
									' SET parent_id = '.$parent_id.','.
									' content_id = '.$this->dbObj->Param('content_id').','.
									' action_key = '.$this->dbObj->Param('action_key').','.
									' action_value = '.$this->dbObj->Param('action_value').','.
									' actor_id = '.$this->dbObj->Param('actor_id').','.
									' owner_id = '.$this->dbObj->Param('action_value').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$child_id = $this->dbObj->Insert_ID();
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
									' SET child_id = '.$child_id.
									' WHERE parent_id = '.$parent_id;

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);
						break;

						case 'delete_playlist_featured';

							$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
										' WHERE action_key= \'playlist_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_playlist_featured_id'];

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row = $rs->FetchRow();

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
									' SET status = \'Deleted\' WHERE parent_id = '.$this->dbObj->Param('parent_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($row['parent_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
									' SET status = \'Deleted\' '.
									' WHERE action_key= \'playlist_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
									' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_playlist_featured_id'];

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);
						break;

						case 'playlist_favorite':
								$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
								$action_value = $activity_arr['playlist_id'].'~'.
												$activity_arr['favorite_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['playlist_name'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['photo_id'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['favorite_user_id']);
								$photo_activity_val_arr = array($activity_arr['photo_playlist_favorite_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['favorite_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;
						case 'delete_playlist_favorite';

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].
										' WHERE action_key= \'playlist_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_playlist_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET status = \'Deleted\' WHERE parent_id = '.$this->dbObj->Param('parent_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($row['parent_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_activity'].
										' SET status = \'Deleted\' '.
										' WHERE action_key= \'playlist_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['photo_playlist_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;
							case 'playlist_share':
								$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
								$action_value = $activity_arr['playlist_id'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['playlist_name'].'~'.
												$activity_arr['photo_server_url'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'].'~'.
												$activity_arr['photo_ext'].'~'.
												$activity_arr['photo_id'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$photo_activity_val_arr = array($activity_arr['playlist_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('sender_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

							case 'playlist_create':
								$activity_arr['photo_playlist_name'] = $this->strReplace($activity_arr['photo_playlist_name']);
								$action_value = $activity_arr['photo_playlist_id'].'~'.
													$activity_arr['created_by_user_id'].'~'.
													$activity_arr['user_name'].'~'.
													$activity_arr['photo_playlist_name'].'~'.
													$activity_arr['photo_server_url'].'~'.
													$activity_arr['photo_ext'].'~'.
													$activity_arr['photo_id'].'~';

									$activity_val_arr = array($activity_arr['created_by_user_id'],	$activity_arr['created_by_user_id']);
									$photo_activity_val_arr = array($activity_arr['photo_playlist_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['created_by_user_id'],
																	$activity_arr['created_by_user_id']);

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
											' SET module = \'photo\','.
											' owner_id = '.$this->dbObj->Param('user_id').','.
											' actor_id = '.$this->dbObj->Param('user_id').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);

									$parent_id = $this->dbObj->Insert_ID();

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
											' SET parent_id = '.$parent_id.','.
											' content_id = '.$this->dbObj->Param('content_id').','.
											' action_key = '.$this->dbObj->Param('action_key').','.
											' action_value = '.$this->dbObj->Param('action_value').','.
											' actor_id = '.$this->dbObj->Param('actor_id').','.
											' owner_id = '.$this->dbObj->Param('action_value').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);
									$child_id = $this->dbObj->Insert_ID();

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
											' SET child_id = '.$child_id.
											' WHERE parent_id = '.$parent_id;

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);
							break;

						 case 'photo_movie_created':
							$activity_arr['photo_movie_name'] = $this->strReplace($activity_arr['photo_movie_name']);
							$action_value = $activity_arr['photo_movie_id'].'~'.
												$activity_arr['created_user_id'].'~'.
												$activity_arr['created_user_name'].'~'.
												$activity_arr['photo_movie_name'];

								$activity_val_arr = array($activity_arr['created_user_id'],
															$activity_arr['created_user_id']);
								$photo_activity_val_arr = array($activity_arr['photo_movie_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['created_user_id'],
																$activity_arr['created_user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);
								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;

						  case 'photo_movie_share':
								$activity_arr['photo_movie_name'] = $this->strReplace($activity_arr['photo_movie_name']);
								$action_value = $activity_arr['photo_movie_id'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['photo_movie_name'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'];


								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$photo_activity_val_arr = array($activity_arr['photo_movie_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'photo\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $photo_activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$child_id = $this->dbObj->Insert_ID();

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
										' SET child_id = '.$child_id.
										' WHERE parent_id = '.$parent_id;

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							break;



					}
			}

		/**
		 * photoActivityHandler::getActivities()
		 *  To get activity details from geral_activity table
		 *
		 * @param array $activityID_arr
		 * @return void
		 */
		public function getActivities($activityID_arr)
			{
				//echo '<pre>'; print_r($activityID_arr); echo '</pre>';
				$getActivities_arr = array();
				$inc = 0;
				$activityIDs = implode(',', $activityID_arr);

						$sql = 'SELECT content_id, action_key, action_value, owner_id,'.
								' actor_id, parent_id, date_added, NOW() as date_current FROM '.$this->CFG['db']['tbl']['photo_activity'].
								' WHERE status=\'Yes\' AND id IN ('.$activityIDs.')';

      					$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow())
								    {

										$getActivities_arr[] = $row;
			 					    }
			 					$inc++;
							}


				$this->generateActivities($getActivities_arr);
			}

		/**
		 * photoActivityHandler::generateActivities()
		 *  To generate activities for different actions
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function generateActivities($activity_arr)
			{
				//echo '<pre>'; print_r($activity_arr); echo '</pre>';
				global $smartyObj;
				$generateActivities_arr = array();
				$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.
									$this->CFG['admin']['photos']['photo_folder'].'/';
				require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/photo/photoActivity.php');
				for($i=0;$i<count($activity_arr);$i++)
					{
						$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
						$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
						switch($activity_arr[$i]['action_key'])
							{
								case 'photo_uploaded':
										/*	0.photo_id
											1.upload_user_id
											2.upload_user_name
											3.photo_title
											4.photo_server_url
											5.photo_ext
											6.photo_ext
										*/
										$generateActivities_arr[$i]['photo_uploaded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										//echo '<pre>'; print_r($value); echo '</pre>';
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_uploaded']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_uploaded']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_uploaded']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_uploaded']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_uploaded']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
                                                $thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
												if(empty($value[5]))
													$generateActivities_arr[$i]['photo_uploaded']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																															$this->CFG['html']['template']['default'].
																																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																																	'/no_image/noImage_S.jpg';
												else
													$generateActivities_arr[$i]['photo_uploaded']['photo']['imgsrc'] = $this->CFG['site']['url'].$photos_folder.
																														getphotoName($value[0]).
																															$this->CFG['admin']['photos']['small_name'].'.'.
																																$value[5];

												$generateActivities_arr[$i]['photo_uploaded']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_uploaded']['lang'] = $LANG['photoactivity_upload_text'];
												$generateActivities_arr[$i]['photo_uploaded']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'photo_comment':
										/*	0.photo_id
											1.comment_user_id
											2.user_name
											3.photo_title
											4.photo_server_url
											5.photo_ext
										*/

										$generateActivities_arr[$i]['photo_comment'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_comment']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_comment']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_comment']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_comment']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['photo_comment']['photo']['imgsrc'] = $value[4] . $photos_folder . getphotoName($value[0]) . $this->CFG['admin']['photos']['small_name'] . '.' . $value[5];

												if ($value[5] == '')
													$generateActivities_arr[$i]['photo_comment']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																															$this->CFG['html']['template']['default'].
																																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																																	'/no_image/noImage_S.jpg';

												$generateActivities_arr[$i]['photo_comment']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_comment']['lang'] = $LANG['photoactivity_comment_text'];
												$generateActivities_arr[$i]['photo_comment']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'photo_rated':
										/*	0.photo_id
											1.rating_user_id
											2.user_name
											3.photo_title
											4.photo_server_url
											5.photo_ext
											6.rate
										*/
										$generateActivities_arr[$i]['photo_rated'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_rated']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_rated']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_rated']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_rated']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_rated']['rate'] = $value[6];
												$generateActivities_arr[$i]['photo_rated']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['photo_rated']['photo']['imgsrc'] = $value[4].$photos_folder.
																													getphotoName($value[0]).
																														$this->CFG['admin']['photos']['small_name'].
																														'.'.$value[5];

												if (empty($value[5]))
													$generateActivities_arr[$i]['photo_rated']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																														$this->CFG['html']['template']['default'].
																															'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																															'/no_image/noImage_S.jpg';

												$generateActivities_arr[$i]['photo_rated']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_rated']['lang'] = str_replace('VAR_RATE',$value[6],$LANG['photoactivity_rating_text']);
												$generateActivities_arr[$i]['photo_rated']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'photo_favorite':
										/*	0.photo_id
											1.favorite_user_id
											2.user_name
											3.photo_title
											4.photo_server_url
											5.photo_ext
										*/
										$generateActivities_arr[$i]['photo_favorite'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_favorite']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];

													}
												else
													{
														$generateActivities_arr[$i]['photo_favorite']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_favorite']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_favorite']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

												if(empty($value[5]))
													$generateActivities_arr[$i]['photo_favorite']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																															$this->CFG['html']['template']['default'].
																																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																																	'/no_image/noImage_S.jpg';
												else
													$generateActivities_arr[$i]['photo_favorite']['photo']['imgsrc'] = $this->CFG['site']['url'].$photos_folder.
																														 getphotoName($value[0]).
																														  $this->CFG['admin']['photos']['small_name'].'.'.
																															$value[5];

												$generateActivities_arr[$i]['photo_favorite']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.
																													  $value[0].'&amp;title='.$this->changeTitle($value[3]),
																													    $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_favorite']['lang'] = $LANG['photoactivity_favorite_text'];
												$generateActivities_arr[$i]['photo_favorite']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
									break;

								case 'photo_featured':
										/*	0.photo_id
											1.favorite_user_id
											2.user_name
											3.photo_title
											4.photo_server_url
											5.photo_ext
										*/
										$generateActivities_arr[$i]['photo_featured'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_featured']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_featured']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_featured']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_featured']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												if(!empty($value[5]))
													$generateActivities_arr[$i]['photo_featured']['photo']['imgsrc'] = $this->CFG['site']['url'].$photos_folder.
																													     getphotoName($value[0]).
																														   $this->CFG['admin']['photos']['small_name'].'.'.
																														     $value[5];
												else
													$generateActivities_arr[$i]['photo_featured']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.
																														 $this->CFG['html']['template']['default'].'/root/images/'.
																														 	$this->CFG['html']['stylesheet']['screen']['default'].
																															 '/no_image/noImage_S.jpg';

												$generateActivities_arr[$i]['photo_featured']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.
																														$this->changeTitle($value[3]), $value[0].'/'.
																															$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_featured']['lang'] = $LANG['photoactivity_featured_text'];
												$generateActivities_arr[$i]['photo_featured']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'photo_responded':
										/*	0.photo_id
											1.responses_user_id
											2.responses_name
											3.photo_title
											4.photo_server_url
											5.is_external_embed_photo
											6.embed_photo_image_ext
											7.user_id
											8.user_name
											9.old_photo_id
											10.old_photo_title
										*/
										$generateActivities_arr[$i]['photo_responded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$value[10] = $this->strReplace($value[10], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_responded']['responses_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_responded']['responses_user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_responded']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_responded']['photo_title'] = $value[3];
												$generateActivities_arr[$i]['photo_responded']['responses_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['photo_responded']['old_user_name'] = $value[8];
												$generateActivities_arr[$i]['photo_responded']['old_user']['url'] = getMemberProfileUrl($value[7], $value[8]);
												$generateActivities_arr[$i]['photo_responded']['photo']['imgsrc'] = $value[4] . $photos_folder . getphotoImageName($value[0]) . $this->CFG['admin']['photos']['small_name'] . '.' . $this->CFG['photo']['image']['extensions'];

												if ($value[4] == 'Yes' && $value[5] == '')
													$generateActivities_arr[$i]['photo_responded']['photo']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-photo.gif';

												$generateActivities_arr[$i]['photo_responded']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_responded']['old_photo_title'] = $value[10];
												$generateActivities_arr[$i]['photo_responded']['old_viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[9].'&amp;title='.$this->changeTitle($value[10]), $value[9].'/'.$this->ChangeTitle($value[10]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_responded']['lang'] = $LANG['photoactivity_responded_text'];
												$generateActivities_arr[$i]['photo_responded']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'photo_share':
										/*	0.photo_id
											1.user_id
											2.user_name
											3.photo_title
											4.photo_server_url
											5.is_external_embed_photo
											6.embed_photo_image_ext
											7.sender_user_id
											8.sender_user_name
											9.firend_list
										*/
										$generateActivities_arr[$i]['photo_share'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$generateActivities_arr[$i]['photo_share']['photo_title'] = $value[3];
										$generateActivities_arr[$i]['photo_share']['sender']['url'] = getMemberProfileUrl($value[5], $value[6]);
										$user_details['user'] = getUserDetail('user_id', $value[5]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_share']['sender_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_share']['sender_user_name'] = $value[6];
													}
												$generateActivities_arr[$i]['photo_share']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[5]);
												if(empty($value[8]))
													$generateActivities_arr[$i]['photo_share']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																															$this->CFG['html']['template']['default'].
																																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																																'/no_image/noImage_S.jpg';
												else
													$generateActivities_arr[$i]['photo_share']['photo']['imgsrc'] = $this->CFG['site']['url'].$photos_folder.
																														getphotoName($value[0]).
																															$this->CFG['admin']['photos']['small_name'].'.'.
																																$value[8];

												$generateActivities_arr[$i]['photo_share']['firend_list'] = array();
												$firend_list = explode(',', $value[7]);

												for($inc = 0; $inc < count($firend_list)-1; $inc++)
													{
														$sql = 'SELECT u.user_name, u.user_id, u.first_name, u.last_name'.
																' FROM '.$this->CFG['db']['tbl']['users'].' as u '.
																' WHERE u.email = \''.$firend_list[$inc].'\'';

														$stmt = $this->dbObj->Prepare($sql);
														$rs = $this->dbObj->Execute($stmt);
														if (!$rs)
															trigger_db_error($this->dbObj);

														$row = $rs->FetchRow();
														if(!empty($row))
															{
																$generateActivities_arr[$i]['photo_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
																if($this->CFG['admin']['display_first_last_name'])
																	{
																		$generateActivities_arr[$i]['photo_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].
																																						' '.$row['last_name'];
																	}
																else
																	{
																		$generateActivities_arr[$i]['photo_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
																	}
															}
													}

												$generateActivities_arr[$i]['photo_share']['viewphoto']['url'] = getUrl('viewphoto', '?photo_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_share']['lang1'] = $LANG['photoactivity_shared_text1'];
												$generateActivities_arr[$i]['photo_share']['lang2'] = $LANG['photoactivity_shared_text2'];
												$generateActivities_arr[$i]['photo_share']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'playlist_comment':
										/*	0.playlist_id
											1.comment_user_id
											2.user_name
											3.playlist_name
											4.photo_server_url
											5.photo_ext
											6.photo_id
										*/
										$generateActivities_arr[$i]['playlist_comment'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['playlist_comment']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['playlist_comment']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['playlist_comment']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_comment']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_comment']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[6]).$this->CFG['admin']['photos']['small_name'].'.'.$value[5];
												if ($value[5] == '')
													$generateActivities_arr[$i]['playlist_comment']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';

												$generateActivities_arr[$i]['playlist_comment']['viewphoto']['url'] = getUrl('flashshow', '??slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
												$generateActivities_arr[$i]['playlist_comment']['lang'] = $LANG['photoplaylistactivity_comment_text'];
												$generateActivities_arr[$i]['playlist_comment']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;
								case 'playlist_rated':
										/*	0.playlist_id
											1.rating_user_id
											2.user_name
											3.playlist_name
											4.photo_server_url
											5.photo_ext
											6.rate
											7.photo_id
										*/
										$generateActivities_arr[$i]['playlist_rated'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['playlist_rated']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['playlist_rated']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['playlist_rated']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_rated']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_rated']['rate'] = $value[6];
												$generateActivities_arr[$i]['playlist_rated']['rate_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_rated']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[7]).$this->CFG['admin']['photos']['small_name'].'.'.$value[5];
												if ($value[5] == '')
													$generateActivities_arr[$i]['playlist_rated']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';
												$generateActivities_arr[$i]['playlist_rated']['viewphoto']['url'] = getUrl('flashshow', '?slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
												$generateActivities_arr[$i]['playlist_rated']['lang'] = str_replace('VAR_RATE',$value[6],$LANG['photoplaylistactivity_rating_text']);
												$generateActivities_arr[$i]['playlist_rated']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'playlist_featured':
										/*	0.playlist_id
											1.favorite_user_id
											2.user_name
											3.playlist_name
											4.photo_server_url
											5.photo_ext
											6.photo_id
										*/
										$generateActivities_arr[$i]['playlist_featured'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['playlist_featured']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['playlist_featured']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['playlist_featured']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_featured']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_featured']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[6]).$this->CFG['admin']['photos']['small_name'].'.'.$value[5];
												if ($value[5] == '')
													$generateActivities_arr[$i]['playlist_featured']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';
												$generateActivities_arr[$i]['playlist_featured']['viewphoto']['url'] = getUrl('flashshow', '?slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
												$generateActivities_arr[$i]['playlist_featured']['lang'] = $LANG['photoplaylistactivity_featured_text'];
												$generateActivities_arr[$i]['playlist_featured']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

								case 'playlist_favorite':
										/*	0.playlist_id
											1.favorite_user_id
											2.user_name
											3.playlist_name
											4.photo_server_url
											5.photo_ext
											6.photo_id
										*/
										$generateActivities_arr[$i]['playlist_favorite'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['playlist_favorite']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];

													}
												else
													{
														$generateActivities_arr[$i]['playlist_favorite']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['playlist_favorite']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_favorite']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_favorite']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[6]).$this->CFG['admin']['photos']['small_name'].'.'.$value[5];
												if($value[5] == '')
													$generateActivities_arr[$i]['playlist_favorite']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';
												$generateActivities_arr[$i]['playlist_favorite']['viewphoto']['url'] = getUrl('flashshow', '?slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
												$generateActivities_arr[$i]['playlist_favorite']['lang'] = $LANG['photoplaylistactivity_favorite_text'];
												$generateActivities_arr[$i]['playlist_favorite']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
									break;
								case 'playlist_share':
										/*	0.playlist_id
											1.user_id
											2.user_name
											3.playlist_name
											4.photo_server_url
											5.sender_user_id
											6.sender_user_name
											7.firend_list
											8.photo_ext
											9.photo_id
										*/
										$generateActivities_arr[$i]['playlist_share'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$generateActivities_arr[$i]['playlist_share']['playlist_name'] = $value[3];
										$generateActivities_arr[$i]['playlist_share']['sender']['url'] = getMemberProfileUrl($value[5], $value[6]);
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['playlist_share']['sender_user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['playlist_share']['sender_user_name'] = $value[6];
													}
												$generateActivities_arr[$i]['playlist_share']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_share']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[9]).$this->CFG['admin']['photos']['small_name'].'.'.$value[8];
												if($value[8] == '')
													$generateActivities_arr[$i]['playlist_share']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';
												$generateActivities_arr[$i]['playlist_share']['firend_list'] = array();
												$firend_list = explode(',', $value[7]);
												for($inc = 0; $inc < count($firend_list)-1; $inc++)
													{
														$sql = 'SELECT u.user_name, u.user_id, u.first_name, u.last_name'.
																' FROM '.$this->CFG['db']['tbl']['users'].' as u '.
																' WHERE u.email = \''.$firend_list[$inc].'\'';

														$stmt = $this->dbObj->Prepare($sql);
														$rs = $this->dbObj->Execute($stmt);
														if (!$rs)
															trigger_db_error($this->dbObj);

														$row = $rs->FetchRow();
														if(!empty($row))
															{
																$generateActivities_arr[$i]['playlist_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
																if($this->CFG['admin']['display_first_last_name'])
																	{
																		$generateActivities_arr[$i]['playlist_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].' '.$row['last_name'];
																	}
																else
																	{
																		$generateActivities_arr[$i]['playlist_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
																	}
															}
													}
												$generateActivities_arr[$i]['playlist_share']['viewphoto']['url'] = getUrl('flashshow', '?slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
												$generateActivities_arr[$i]['playlist_share']['lang1'] = $LANG['photoplaylistactivity_shared_text1'];
												$generateActivities_arr[$i]['playlist_share']['lang2'] = $LANG['photoplaylistactivity_shared_text2'];
												$generateActivities_arr[$i]['playlist_share']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;
								case 'playlist_create':
									/*	0.playlist_id
										1.user_id
										2.user_name
										3.playlist_name
										4.photo_server_url
										5.photo_ext
										6.photo_id
									*/
									$generateActivities_arr[$i]['playlist_create'] = array();
									$value = explode('~', $activity_arr[$i]['action_value']);
									$value[3] = $this->strReplace($value[3], 'display');
									$user_details['user'] = getUserDetail('user_id', $value[1]);
									if(!empty($user_details['user']))
										{
											if($this->CFG['admin']['display_first_last_name'])
												{
													$generateActivities_arr[$i]['playlist_create']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
												}
											else
												{
													$generateActivities_arr[$i]['playlist_create']['user_name'] = $value[2];
												}
											$generateActivities_arr[$i]['playlist_create']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
											$generateActivities_arr[$i]['playlist_create']['playlist_name'] = $value[3];
											$generateActivities_arr[$i]['playlist_create']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
											$generateActivities_arr[$i]['playlist_create']['photo']['imgsrc'] = $value[4].$photos_folder.getphotoName($value[6]).$this->CFG['admin']['photos']['small_name'].'.'.$value[5];
											if($value[5] == '')
												$generateActivities_arr[$i]['playlist_create']['photo']['imgsrc'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_S.jpg';
											$generateActivities_arr[$i]['playlist_create']['viewphoto']['url'] = getUrl('flashshow', '?slideshow=pl&playlist='.$value[0], 'pl/'.$value[0].'/', '', 'photo');
											$generateActivities_arr[$i]['playlist_create']['lang'] = $LANG['photoplaylistactivity_upload_text'];
											$generateActivities_arr[$i]['playlist_create']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
										}
								break;

								case 'photo_movie_created':
										/*	0.photo_movie_id
											1.created_user_id
											2.created_user_name
											3.photo_movie_name
										*/
										$generateActivities_arr[$i]['photo_movie_created'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										//echo '<pre>'; print_r($value); echo '</pre>';
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_movie_created']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_movie_created']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['photo_movie_created']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['photo_movie_created']['photo_movie_name'] = $value[3];
												$generateActivities_arr[$i]['photo_movie_created']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

												$generateActivities_arr[$i]['photo_movie_created']['viewphotomovie']['url'] = getUrl('viewphotomovie', '?photo_movie_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_movie_created']['lang'] = $LANG['photomovieactivity_created_text'];
												$generateActivities_arr[$i]['photo_movie_created']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

						    	case 'photo_movie_share':
										/*	0.photo_movie_id
											1.user_id
											2.user_name
											3.photo_movie_name
											4.sender_user_id
											5.sender_user_name
											6.firend_list
										*/
										$generateActivities_arr[$i]['photo_movie_share'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$generateActivities_arr[$i]['photo_movie_share']['photo_movie_name'] = $value[3];
										$generateActivities_arr[$i]['photo_movie_share']['sender']['url'] = getMemberProfileUrl($value[4], $value[5]);
										$user_details['user'] = getUserDetail('user_id', $value[4]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['photo_movie_share']['sender_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['photo_movie_share']['sender_user_name'] = $value[5];
													}
												$generateActivities_arr[$i]['photo_movie_share']['user_photo']['imgsrc'] = getMemberAvatarDetails($value[4]);
												if(empty($value[8]))
													$generateActivities_arr[$i]['photo_movie_share']['photo']['imgsrc'] = $this->CFG['site']['url'].
																														'photo/design/templates/'.
																															$this->CFG['html']['template']['default'].
																																'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																																'/no_image/noImage_S.jpg';
												else
													$generateActivities_arr[$i]['photo_movie_share']['photo']['imgsrc'] = $this->CFG['site']['url'].$photos_folder.
																														getphotoName($value[0]).
																															$this->CFG['admin']['photos']['small_name'].'.'.
																																$value[8];

												$generateActivities_arr[$i]['photo_movie_share']['firend_list'] = array();
												$firend_list = explode(',', $value[6]);

												for($inc = 0; $inc < count($firend_list)-1; $inc++)
													{
														$sql = 'SELECT u.user_name, u.user_id, u.first_name, u.last_name'.
																' FROM '.$this->CFG['db']['tbl']['users'].' as u '.
																' WHERE u.email = \''.$firend_list[$inc].'\'';

														$stmt = $this->dbObj->Prepare($sql);
														$rs = $this->dbObj->Execute($stmt);
														if (!$rs)
															trigger_db_error($this->dbObj);

														$row = $rs->FetchRow();
														if(!empty($row))
															{
																$generateActivities_arr[$i]['photo_movie_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
																if($this->CFG['admin']['display_first_last_name'])
																	{
																		$generateActivities_arr[$i]['photo_movie_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].
																																						' '.$row['last_name'];
																	}
																else
																	{
																		$generateActivities_arr[$i]['photo_movie_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
																	}
															}
													}

												$generateActivities_arr[$i]['photo_movie_share']['viewphotomovie']['url'] = getUrl('viewphotomovie', '?photo_movie_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'photo');
												$generateActivities_arr[$i]['photo_movie_share']['lang1'] = $LANG['photoactivity_movie_shared_text1'];
												$generateActivities_arr[$i]['photo_movie_share']['lang2'] = $LANG['photoactivity_movie_shared_text2'];
												$generateActivities_arr[$i]['photo_movie_share']['date_added'] = getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current']));
											}
								break;

							}
					}
				$smartyObj->assign('photoActivity_arr', $generateActivities_arr);
			}
	}
?>