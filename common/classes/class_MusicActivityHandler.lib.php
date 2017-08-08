<?php
/**
 * Class to handle the Music Activities module
 *
 * This is having class musicActivity to handle
 * IMP action_value format: first letter must be music_id or playlist_id
 *
 * @category	Rayzz
 * @package		Common/Classes
 */

class MusicActivityHandler extends FormHandler
	{
		private $dbObj;
		protected $CFG = array();
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
		 * MusicActivityHandler::addActivity()
		 *  To add music activities
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function addActivity($activity_arr)
			{


			  /*1.	music_uploaded
				2.	music_comment
				3.	music_rated
				4.	music_favorite
				5.	music_featured
				6.	music_responded
				7.	music_share
				8.	delete_music_favorite
				9.	delete_music_featured*/
			switch($activity_arr['action_key'])
					{

						case 'music_uploaded':
							$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
							$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['upload_user_id'].'~'.
												$activity_arr['upload_user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_ext'].'~'.
												$activity_arr['music_thumb_ext'].'~';

								$activity_val_arr = array($activity_arr['upload_user_id'],
															$activity_arr['upload_user_id']);
								$music_activity_val_arr = array($activity_arr['music_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['upload_user_id'],
																$activity_arr['upload_user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'music_comment':
							$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
							$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['comment_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['comment_user_id']);
								$music_activity_val_arr = array($activity_arr['music_comment_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['comment_user_id'],
																	$activity_arr['user_id']);
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'music_rated':
							$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
							$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['rating_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['rate'].'~';

							//Cheack actor already rate same content..
							$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['music_activity'].
									' WHERE action_key= \'music_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
									' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row['content_id'] = $rs->FetchRow();

							if(empty($row['content_id']))
								{
									$activity_val_arr = array($activity_arr['user_id'],
																$activity_arr['rating_user_id']);

									$music_activity_val_arr = array($activity_arr['rating_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['rating_user_id'],
																	$activity_arr['user_id']);

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
											' SET module = \'music\','.
											' owner_id = '.$this->dbObj->Param('user_id').','.
											' actor_id = '.$this->dbObj->Param('rating_user_id').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);
									$parent_id = $this->dbObj->Insert_ID();
									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
											' SET parent_id = '.$parent_id.','.
											' content_id = '.$this->dbObj->Param('content_id').','.
											' action_key = '.$this->dbObj->Param('action_key').','.
											' action_value = '.$this->dbObj->Param('action_value').','.
											' actor_id = '.$this->dbObj->Param('actor_id').','.
											' owner_id = '.$this->dbObj->Param('action_value').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
											' SET date_added = NOW(), '.
											' action_value = \''.$action_value.'\' '.
											' WHERE action_key= \'music_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
											' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);
								}
							break;

						case 'music_favorite':
								$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
								$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['favorite_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['favorite_user_id']);
								$music_activity_val_arr = array($activity_arr['music_favorite_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['favorite_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'music_featured':
							$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
							$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['featured_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['featured_user_id']);

								$music_activity_val_arr = array($activity_arr['music_featured_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['featured_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'music_responded':
								$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
								$activity_arr['old_music_title'] = $this->strReplace($activity_arr['old_music_title']);
								$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['responses_user_id'].'~'.
												$activity_arr['responses_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['old_music_id'].'~'.
												$activity_arr['old_music_title'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['responses_user_id']);

								$music_activity_val_arr = array($activity_arr['music_responses_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['responses_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('responses_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'music_share':
								$activity_arr['music_title'] = $this->strReplace($activity_arr['music_title']);
								$action_value = $activity_arr['music_id'].'~'.
												$activity_arr['user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['music_title'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'].'~'.
												$activity_arr['music_thumb_ext'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$music_activity_val_arr = array($activity_arr['music_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('featured_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

						case 'delete_music_favorite';

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE action_key= \'music_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_favorite_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
								{
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
											' SET status = \'Deleted\' '.
											' WHERE parent_id= '.$row['parent_id'];

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
									' SET status = \'Deleted\' '.
									' WHERE action_key= \'music_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
									' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_favorite_id'];

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);
								}
							break;

						case 'delete_music_featured';

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE action_key= \'music_featured\' AND actor_id= '.$activity_arr['featured_user_id'].
										' AND owner_id= '.$activity_arr['user_id'].
										' AND content_id= '.$activity_arr['music_featured_id'];

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
								{
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
											' SET status = \'Deleted\' '.
											' WHERE parent_id= '.$row['parent_id'];

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
									' SET status = \'Deleted\' '.
									' WHERE action_key= \'music_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
									' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_featured_id'];

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_db_error($this->dbObj);

								}
							break;

						case 'playlist_comment': // PLAYLIST //
							$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
							$action_value = $activity_arr['playlist_id'].'~'.
												$activity_arr['comment_user_id'].'~'.
												$activity_arr['user_name'].'~'.
												$activity_arr['playlist_name'].'~'.
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['music_id'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['comment_user_id']);
								$music_activity_val_arr = array($activity_arr['playlist_comment_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['comment_user_id'],
																	$activity_arr['user_id']);
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('comment_user_id').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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
													$activity_arr['music_server_url'].'~'.
													$activity_arr['music_thumb_ext'].'~'.
													$activity_arr['rate'].'~'.
													$activity_arr['music_id'].'~';

								//Cheack actor already rate same content..
								$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE action_key= \'music_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
										' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row['content_id'] = $rs->FetchRow();

								if(empty($row['content_id']))
									{
										$activity_val_arr = array($activity_arr['user_id'],
																	$activity_arr['rating_user_id']);

										$music_activity_val_arr = array($activity_arr['rating_id'],
																		$activity_arr['action_key'],
																		$action_value,
																		$activity_arr['rating_user_id'],
																		$activity_arr['user_id']);

										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
												' SET module = \'music\','.
												' owner_id = '.$this->dbObj->Param('user_id').','.
												' actor_id = '.$this->dbObj->Param('rating_user_id').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
										if (!$rs)
											trigger_db_error($this->dbObj);
										$parent_id = $this->dbObj->Insert_ID();
										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
												' SET parent_id = '.$parent_id.','.
												' content_id = '.$this->dbObj->Param('content_id').','.
												' action_key = '.$this->dbObj->Param('action_key').','.
												' action_value = '.$this->dbObj->Param('action_value').','.
												' actor_id = '.$this->dbObj->Param('actor_id').','.
												' owner_id = '.$this->dbObj->Param('action_value').','.
												' date_added = NOW()';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
												' SET date_added = NOW(), '.
												' action_value = \''.$action_value.'\' '.
												' WHERE action_key= \'music_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
												' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

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
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['music_id'].'~';

							$activity_val_arr = array($activity_arr['user_id'],
														$activity_arr['featured_user_id']);

							$music_activity_val_arr = array($activity_arr['music_playlist_featured_id'],
															$activity_arr['action_key'],
															$action_value,
															$activity_arr['featured_user_id'],
															$activity_arr['user_id']);

							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
									' SET module = \'music\','.
									' owner_id = '.$this->dbObj->Param('user_id').','.
									' actor_id = '.$this->dbObj->Param('featured_user_id').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
							if (!$rs)
								trigger_db_error($this->dbObj);

							$parent_id = $this->dbObj->Insert_ID();
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
									' SET parent_id = '.$parent_id.','.
									' content_id = '.$this->dbObj->Param('content_id').','.
									' action_key = '.$this->dbObj->Param('action_key').','.
									' action_value = '.$this->dbObj->Param('action_value').','.
									' actor_id = '.$this->dbObj->Param('actor_id').','.
									' owner_id = '.$this->dbObj->Param('action_value').','.
									' date_added = NOW()';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

							$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE action_key= \'playlist_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_playlist_featured_id'];

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

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
									' SET status = \'Deleted\' '.
									' WHERE action_key= \'playlist_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
									' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_playlist_featured_id'];

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
												$activity_arr['music_server_url'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['music_id'].'~';
								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['favorite_user_id']);
								$music_activity_val_arr = array($activity_arr['music_playlist_favorite_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['favorite_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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

								$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['music_activity'].
										' WHERE action_key= \'playlist_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_playlist_favorite_id'];

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

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_activity'].
										' SET status = \'Deleted\' '.
										' WHERE action_key= \'playlist_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
										' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['music_playlist_favorite_id'];

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
												$activity_arr['music_server_url'].'~'.
												$activity_arr['sender_user_id'].'~'.
												$activity_arr['sender_user_name'].'~'.
												$activity_arr['firend_list'].'~'.
												$activity_arr['music_thumb_ext'].'~'.
												$activity_arr['music_id'].'~';

								$activity_val_arr = array($activity_arr['user_id'],
															$activity_arr['sender_user_id']);

								$music_activity_val_arr = array($activity_arr['playlist_id'],
																$activity_arr['action_key'],
																$action_value,
																$activity_arr['sender_user_id'],
																$activity_arr['user_id']);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
										' SET module = \'music\','.
										' owner_id = '.$this->dbObj->Param('user_id').','.
										' actor_id = '.$this->dbObj->Param('sender_user_id').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
								if (!$rs)
									trigger_db_error($this->dbObj);

								$parent_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
										' SET parent_id = '.$parent_id.','.
										' content_id = '.$this->dbObj->Param('content_id').','.
										' action_key = '.$this->dbObj->Param('action_key').','.
										' action_value = '.$this->dbObj->Param('action_value').','.
										' actor_id = '.$this->dbObj->Param('actor_id').','.
										' owner_id = '.$this->dbObj->Param('action_value').','.
										' date_added = NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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
								$activity_arr['playlist_name'] = $this->strReplace($activity_arr['playlist_name']);
								$action_value = $activity_arr['playlist_id'].'~'.
													$activity_arr['user_id'].'~'.
													$activity_arr['user_name'].'~'.
													$activity_arr['playlist_name'].'~'.
													$activity_arr['music_server_url'].'~'.
													$activity_arr['music_thumb_ext'].'~'.
													$activity_arr['music_id'].'~';

									$activity_val_arr = array($activity_arr['user_id'],	$activity_arr['user_id']);
									$music_activity_val_arr = array($activity_arr['playlist_id'],
																	$activity_arr['action_key'],
																	$action_value,
																	$activity_arr['user_id'],
																	$activity_arr['user_id']);

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
											' SET module = \'music\','.
											' owner_id = '.$this->dbObj->Param('user_id').','.
											' actor_id = '.$this->dbObj->Param('user_id').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
									if (!$rs)
										trigger_db_error($this->dbObj);

									$parent_id = $this->dbObj->Insert_ID();

									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_activity'].
											' SET parent_id = '.$parent_id.','.
											' content_id = '.$this->dbObj->Param('content_id').','.
											' action_key = '.$this->dbObj->Param('action_key').','.
											' action_value = '.$this->dbObj->Param('action_value').','.
											' actor_id = '.$this->dbObj->Param('actor_id').','.
											' owner_id = '.$this->dbObj->Param('action_value').','.
											' date_added = NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $music_activity_val_arr);
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
		 * MusicActivityHandler::getActivities()
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

						$sql = 'SELECT content_id, action_key, action_value, owner_id,'.
								' actor_id, parent_id, TIMEDIFF(NOW(), date_added) as date_added FROM '.$this->CFG['db']['tbl']['music_activity'].
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
	 * MusicActivityHandler::chkTemplateImagePathForMusicAndSwitch()
	 *
	 * @param string $module
	 * @param string $template
	 * @param string $screen
	 * @return void
	 */
	public function chkTemplateImagePathForMusicAndSwitch($module, $template, $screen)
		{
			global $CFG, $smartyObj;
			$css_template_arr['template'] = $template;
			$css_template_arr['screen'] = $screen;

			$template_dir_module = $CFG['site']['project_path'].$module.
										'/design/templates/'.$template.'/root/images/'.$screen.'/';

			if(!is_dir($template_dir_module))
				{
					foreach($CFG['html']['template']['allowed'] as $available_template)
						{
							$available_template_dir = $CFG['site']['project_path'].$module.
															'/design/templates/'.$available_template.'/root/images/';

							if(is_dir($available_template_dir))
								{
									foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_image)
										{
											$available_image_path  = $CFG['site']['project_path'].$module.
																		'/design/templates/'.$available_template.'/root/images/'.$available_image.'/';

											if(is_dir($available_image_path))
												{
													$css_template_arr['template'] = $available_template;
													$css_template_arr['screen'] = $available_image;
													break;
												}
										}
								}
						}
				}

				$this->CFG['html']['template']['default'] = $css_template_arr['template'];
				$this->CFG['html']['stylesheet']['screen']['default']  = $css_template_arr['screen'];

				$smartyObj->assign('CFG', $this->CFG);
				$smartyObj->assign('LANG', $this->LANG);
				$smartyObj->assign_by_ref('myobj', $this);

		}

		/**
		 * MusicActivityHandler::generateActivities()
		 *  To generate activities for different actions
		 *
		 * @param array $activity_arr
		 * @return void
		 */
		public function generateActivities($activity_arr)
			{
				global $smartyObj;
				$generateActivities_arr = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.
									$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/music/musicActivity.php');

				//load the available template and screen
				$this->chkTemplateImagePathForMusicAndSwitch('music', $this->CFG['html']['template']['default'], $this->CFG['html']['stylesheet']['screen']['default']);

				for($i=0;$i<count($activity_arr);$i++)
					{
						$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
						$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
						switch($activity_arr[$i]['action_key'])
							{
								case 'music_uploaded':
										/*	0.music_id
											1.upload_user_id
											2.upload_user_name
											3.music_title
											4.music_server_url
											5.music_ext
											6.music_thumb_ext
										*/
										$generateActivities_arr[$i]['music_uploaded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_uploaded']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_uploaded']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_uploaded']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_uploaded']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
                                                $generateActivities_arr[$i]['music_uploaded']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_uploaded']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_uploaded']['lang'] = $LANG['musicactivity_upload_text'];
												$generateActivities_arr[$i]['music_uploaded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'music_comment':
										/*	0.music_id
											1.comment_user_id
											2.user_name
											3.music_title
											4.music_server_url
											5.music_thumb_ext
										*/

										$generateActivities_arr[$i]['music_comment'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_comment']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_comment']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_comment']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['music_comment']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_comment']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_comment']['lang'] = $LANG['musicactivity_comment_text'];
												$generateActivities_arr[$i]['music_comment']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'music_rated':
										/*	0.music_id
											1.rating_user_id
											2.user_name
											3.music_title
											4.music_server_url
											5.music_thumb_ext
											6.rate
										*/
										$generateActivities_arr[$i]['music_rated'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_rated']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_rated']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_rated']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_rated']['rate'] = $value[6];
												$generateActivities_arr[$i]['music_rated']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['music_rated']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_rated']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_rated']['lang'] = str_replace('VAR_RATE',$value[6],$LANG['musicactivity_rating_text']);
												$generateActivities_arr[$i]['music_rated']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'music_favorite':
										/*	0.music_id
											1.favorite_user_id
											2.user_name
											3.music_title
											4.music_server_url
											5.music_thumb_ext
										*/
										$generateActivities_arr[$i]['music_favorite'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_favorite']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];

													}
												else
													{
														$generateActivities_arr[$i]['music_favorite']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_favorite']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['music_favorite']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_favorite']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.
																													  $value[0].'&amp;title='.$this->changeTitle($value[3]),
																													    $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_favorite']['lang'] = $LANG['musicactivity_favorite_text'];
												$generateActivities_arr[$i]['music_favorite']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
									break;

								case 'music_featured':
										/*	0.music_id
											1.favorite_user_id
											2.user_name
											3.music_title
											4.music_server_url
											5.music_thumb_ext
										*/
										$generateActivities_arr[$i]['music_featured'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_featured']['user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_featured']['user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_featured']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['music_featured']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_featured']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.
																														$this->changeTitle($value[3]), $value[0].'/'.
																															$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_featured']['lang'] = $LANG['musicactivity_featured_text'];
												$generateActivities_arr[$i]['music_featured']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'music_responded':
										/*	0.music_id
											1.responses_user_id
											2.responses_name
											3.music_title
											4.music_server_url
											5.is_external_embed_music
											6.embed_music_image_ext
											7.user_id
											8.user_name
											9.old_music_id
											10.old_music_title
										*/
										$generateActivities_arr[$i]['music_responded'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$value[10] = $this->strReplace($value[10], 'display');
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_responded']['responses_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_responded']['responses_user_name'] = $value[2];
													}
												$generateActivities_arr[$i]['music_responded']['music_title'] = $value[3];
												$generateActivities_arr[$i]['music_responded']['responses_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['music_responded']['old_user_name'] = $value[8];
												$generateActivities_arr[$i]['music_responded']['old_user']['url'] = getMemberProfileUrl($value[7], $value[8]);
												$generateActivities_arr[$i]['music_responded']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_responded']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_responded']['old_music_title'] = $value[10];
												$generateActivities_arr[$i]['music_responded']['old_viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[9].'&amp;title='.$this->changeTitle($value[10]), $value[9].'/'.$this->ChangeTitle($value[10]).'/', '', 'music');
												$generateActivities_arr[$i]['music_responded']['lang'] = $LANG['musicactivity_responded_text'];
												$generateActivities_arr[$i]['music_responded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'music_share':
										/*	0.music_id
											1.user_id
											2.user_name
											3.music_title
											4.music_server_url
											5.is_external_embed_music
											6.embed_music_image_ext
											7.sender_user_id
											8.sender_user_name
											9.firend_list
										*/
										$generateActivities_arr[$i]['music_share'] = array();
										$value = explode('~', $activity_arr[$i]['action_value']);
										$value[3] = $this->strReplace($value[3], 'display');
										$generateActivities_arr[$i]['music_share']['music_title'] = $value[3];
										$generateActivities_arr[$i]['music_share']['sender']['url'] = getMemberProfileUrl($value[5], $value[6]);
										$user_details['user'] = getUserDetail('user_id', $value[1]);
										if(!empty($user_details['user']))
											{
												if($this->CFG['admin']['display_first_last_name'])
													{
														$generateActivities_arr[$i]['music_share']['sender_user_name'] = $user_details['user']['first_name'].' '.
																														$user_details['user']['last_name'];
													}
												else
													{
														$generateActivities_arr[$i]['music_share']['sender_user_name'] = $value[6];
													}


												$generateActivities_arr[$i]['music_share']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['music_share']['firend_list'] = array();
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
																$generateActivities_arr[$i]['music_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
																if($this->CFG['admin']['display_first_last_name'])
																	{
																		$generateActivities_arr[$i]['music_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].
																																						' '.$row['last_name'];
																	}
																else
																	{
																		$generateActivities_arr[$i]['music_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
																	}
															}
													}

												$generateActivities_arr[$i]['music_share']['viewmusic']['url'] = getUrl('viewmusic', '?music_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['music_share']['lang1'] = $LANG['musicactivity_shared_text1'];
												$generateActivities_arr[$i]['music_share']['lang2'] = $LANG['musicactivity_shared_text2'];
												$generateActivities_arr[$i]['music_share']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'playlist_comment':
										/*	0.playlist_id
											1.comment_user_id
											2.user_name
											3.playlist_name
											4.music_server_url
											5.music_thumb_ext
											6.music_id
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
												$generateActivities_arr[$i]['playlist_comment']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_comment']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_comment']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['playlist_comment']['lang'] = $LANG['musicplaylistactivity_comment_text'];
												$generateActivities_arr[$i]['playlist_comment']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;
								case 'playlist_rated':
										/*	0.playlist_id
											1.rating_user_id
											2.user_name
											3.playlist_name
											4.music_server_url
											5.music_thumb_ext
											6.rate
											7.music_id
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
												$generateActivities_arr[$i]['playlist_rated']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_rated']['rate'] = $value[6];
												$generateActivities_arr[$i]['playlist_rated']['rate_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_rated']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_rated']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['playlist_rated']['lang'] = str_replace('VAR_RATE',$value[6],$LANG['musicplaylistactivity_rating_text']);
												$generateActivities_arr[$i]['playlist_rated']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'playlist_featured':
										/*	0.playlist_id
											1.favorite_user_id
											2.user_name
											3.playlist_name
											4.music_server_url
											5.music_thumb_ext
											6.music_id
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
												$generateActivities_arr[$i]['playlist_featured']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_featured']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_featured']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['playlist_featured']['lang'] = $LANG['musicplaylistactivity_featured_text'];
												$generateActivities_arr[$i]['playlist_featured']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;

								case 'playlist_favorite':
										/*	0.playlist_id
											1.favorite_user_id
											2.user_name
											3.playlist_name
											4.music_server_url
											5.music_thumb_ext
											6.music_id
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
												$generateActivities_arr[$i]['playlist_favorite']['playlist_name'] = $value[3];
												$generateActivities_arr[$i]['playlist_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
												$generateActivities_arr[$i]['playlist_favorite']['profileIcon'] = getMemberAvatarDetails($value[1]);
												$generateActivities_arr[$i]['playlist_favorite']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['playlist_favorite']['lang'] = $LANG['musicplaylistactivity_favorite_text'];
												$generateActivities_arr[$i]['playlist_favorite']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
									break;
								case 'playlist_share':
										/*	0.playlist_id
											1.user_id
											2.user_name
											3.playlist_name
											4.music_server_url
											5.sender_user_id
											6.sender_user_name
											7.firend_list
											8.music_thumb_ext
											9.music_id
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
												$generateActivities_arr[$i]['playlist_share']['profileIcon'] = getMemberAvatarDetails($value[1]);
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
												$generateActivities_arr[$i]['playlist_share']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
												$generateActivities_arr[$i]['playlist_share']['lang1'] = $LANG['musicplaylistactivity_shared_text1'];
												$generateActivities_arr[$i]['playlist_share']['lang2'] = $LANG['musicplaylistactivity_shared_text2'];
												$generateActivities_arr[$i]['playlist_share']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
											}
								break;
								case 'playlist_create':
									/*	0.playlist_id
										1.user_id
										2.user_name
										3.playlist_name
										4.music_server_url
										5.music_thumb_ext
										6.music_id
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
											$generateActivities_arr[$i]['playlist_create']['playlist_name'] = $value[3];
											$generateActivities_arr[$i]['playlist_create']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
											$generateActivities_arr[$i]['playlist_create']['profileIcon'] = getMemberAvatarDetails($value[1]);
											$generateActivities_arr[$i]['playlist_create']['viewmusic']['url'] = getUrl('viewplaylist', '?playlist_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'music');
											$generateActivities_arr[$i]['playlist_create']['lang'] = $LANG['musicplaylistactivity_upload_text'];
											$generateActivities_arr[$i]['playlist_create']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
										}
								break;
							}
					}
				$smartyObj->assign('musicActivity_arr', $generateActivities_arr);
			}
	}
?>