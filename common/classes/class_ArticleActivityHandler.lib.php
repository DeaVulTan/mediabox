<?php
/**
 * Class to handle the article Activities module
 *
 * This is having class articleActivity to handle
 * IMP action_value format: first letter must be article_id
 *
 * @category	Rayzz
 * @package		Common/Classes
 */

class articleActivityHandler extends FormHandler
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
	 * articleActivityHandler::addActivity()
	 * To add article activities
	 *
	 * @param array $activity_arr
	 * @return void
	 */
	public function addActivity($activity_arr)
	{
		  /*1.	article_uploaded
			2.	article_comment
			3.	article_rated
			4.	article_favorite
			5.	article_featured
			6.	article_share
			7.	delete_article_favorite
			8.	delete_article_featured*/
		switch($activity_arr['action_key'])
		{
			case 'article_uploaded':
				$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
				$action_value = $activity_arr['article_id'].'~'.
									$activity_arr['upload_user_id'].'~'.
									$activity_arr['upload_user_name'].'~'.
									$activity_arr['article_title'].'~'.
									$activity_arr['article_server_url'];

				$activity_val_arr = array($activity_arr['upload_user_id'],$activity_arr['upload_user_id']);
				$article_activity_val_arr = array($activity_arr['article_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['upload_user_id'],
												$activity_arr['upload_user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'article\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

			case 'article_comment':
				$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
				$action_value = $activity_arr['article_id'].'~'.
									$activity_arr['comment_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['article_title'].'~'.
									$activity_arr['article_server_url'];

				$activity_val_arr = array($activity_arr['user_id'],
											$activity_arr['comment_user_id']);
				$article_activity_val_arr = array($activity_arr['article_comment_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['comment_user_id'],
													$activity_arr['user_id']);
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'article\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('comment_user_id').','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

			case 'article_rated':
				$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
				$action_value = $activity_arr['article_id'].'~'.
									$activity_arr['rating_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['article_title'].'~'.
									$activity_arr['article_server_url'].'~'.
									$activity_arr['rate'].'~';

				//Cheack actor already rate same content..
				$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['article_activity'].
						' WHERE action_key= \'article_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
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

					$article_activity_val_arr = array($activity_arr['rating_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['rating_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'article\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('rating_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);
					$parent_id = $this->dbObj->Insert_ID();
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_activity'].
							' SET date_added = NOW(), '.
							' action_value = \''.$action_value.'\' '.
							' WHERE action_key= \'article_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
							' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['rating_id'].'\' ';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
				break;

				case 'article_favorite':
					$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
					$action_value = $activity_arr['article_id'].'~'.
									$activity_arr['favorite_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['article_title'].'~'.
									$activity_arr['article_server_url'];

					$activity_val_arr = array($activity_arr['user_id'],
												$activity_arr['favorite_user_id']);
					$article_activity_val_arr = array($activity_arr['article_favorite_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['favorite_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'article\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

					$parent_id = $this->dbObj->Insert_ID();

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

				case 'article_featured':
					$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
					$action_value = $activity_arr['article_id'].'~'.
										$activity_arr['featured_user_id'].'~'.
										$activity_arr['user_name'].'~'.
										$activity_arr['article_title'];

					$activity_val_arr = array($activity_arr['user_id'],
												$activity_arr['featured_user_id']);

					$article_activity_val_arr = array($activity_arr['article_featured_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['featured_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'article\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('featured_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_db_error($this->dbObj);

					$parent_id = $this->dbObj->Insert_ID();

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

			case 'article_responded':
				$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
				$activity_arr['old_article_title'] = $this->strReplace($activity_arr['old_article_title']);
				$action_value = $activity_arr['article_id'].'~'.
								$activity_arr['responses_user_id'].'~'.
								$activity_arr['responses_name'].'~'.
								$activity_arr['article_title'].'~'.
								$activity_arr['user_id'].'~'.
								$activity_arr['user_name'].'~'.
								$activity_arr['old_article_id'].'~'.
								$activity_arr['old_article_title'].'~';

				$activity_val_arr = array($activity_arr['user_id'],
											$activity_arr['responses_user_id']);

				$article_activity_val_arr = array($activity_arr['article_responses_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['responses_user_id'],
												$activity_arr['user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'article\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('responses_user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

			case 'article_share':
				$activity_arr['article_title'] = $this->strReplace($activity_arr['article_title']);
				$action_value = $activity_arr['article_id'].'~'.
								$activity_arr['user_id'].'~'.
								$activity_arr['user_name'].'~'.
								$activity_arr['article_title'].'~'.
								$activity_arr['article_server_url'].'~'.
								$activity_arr['sender_user_id'].'~'.
								$activity_arr['sender_user_name'].'~'.
								$activity_arr['firend_list'];

				$activity_val_arr = array($activity_arr['user_id'],
											$activity_arr['sender_user_id']);

				$article_activity_val_arr = array($activity_arr['article_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['sender_user_id'],
												$activity_arr['user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'article\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('featured_user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $article_activity_val_arr);
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

			case 'delete_article_favorite';
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_activity'].
						' SET status = \'Deleted\' '.
						' WHERE action_key= \'article_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['article_favorite_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['article_activity'].
						' WHERE action_key= \'article_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['article_favorite_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();

				if($row['parent_id'])
				{
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
							' SET status = \'Deleted\' '.
							' WHERE parent_id= '.$row['parent_id'];


					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
			break;

			case 'delete_article_featured';
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_activity'].
						' SET status = \'Deleted\' '.
						' WHERE action_key= \'article_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['article_featured_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['article_activity'].
						' WHERE action_key= \'article_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['article_featured_id'];

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
			}
		}

	/**
	 * articleActivityHandler::getActivities()
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
				' actor_id, parent_id, TIMEDIFF(NOW(), date_added) as added_date, date_added, NOW() as date_current FROM '.$this->CFG['db']['tbl']['article_activity'].
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
	 * articleActivityHandler::generateActivities()
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
		$articles_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';
		require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/article/articleActivity.php');
		for($i=0;$i<count($activity_arr);$i++)
		{
			$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
			$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
			switch($activity_arr[$i]['action_key'])
			{
				case 'article_uploaded':
					/*	0.article_id
						1.upload_user_id
						2.upload_user_name
						3.article_title
						4.article_server_url
						5.article_ext

					*/
					$generateActivities_arr[$i]['article_uploaded'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					//echo '<pre>'; print_r($value); echo '</pre>';
					$value[3] = $this->strReplace($value[3], 'display');
					$user_details['user'] = getUserDetail('user_id', $value[1]);
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['article_uploaded']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['article_uploaded']['user_name'] = $value[2];
						$generateActivities_arr[$i]['article_uploaded']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
						$generateActivities_arr[$i]['article_uploaded']['article_title'] = $value[3];
						$generateActivities_arr[$i]['article_uploaded']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
                        $thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';
						/*if(empty($value[5]))
							$generateActivities_arr[$i]['article_uploaded']['article']['imgsrc'] = $this->CFG['site']['url'].
																								'article/design/templates/'.
																									$this->CFG['html']['template']['default'].
																										'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																											'/no_image/noImage_S.jpg';
						else
							$generateActivities_arr[$i]['article_uploaded']['article']['imgsrc'] = $this->CFG['site']['url'].$articles_folder.
																								getarticleName($value[0]).
																									$this->CFG['admin']['articles']['small_name'].'.'.
																										$value[5];*/

						$generateActivities_arr[$i]['article_uploaded']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
						$generateActivities_arr[$i]['article_uploaded']['lang'] = $LANG['articleactivity_upload_text'];
						//$generateActivities_arr[$i]['article_uploaded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['article_uploaded']['date_added'] = ($activity_arr[$i]['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current'])):'';
					}
			break;

			case 'article_comment':
				/*	0.article_id
					1.comment_user_id
					2.user_name
					3.article_title
					4.article_server_url
					5.article_ext
				*/

				$generateActivities_arr[$i]['article_comment'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details['user'] = getUserDetail('user_id', $value[1]);
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['article_comment']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['article_comment']['user_name'] = $value[2];
					$generateActivities_arr[$i]['article_comment']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
					$generateActivities_arr[$i]['article_comment']['article_title'] = $value[3];
					$generateActivities_arr[$i]['article_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
					//$generateActivities_arr[$i]['article_comment']['article']['imgsrc'] = $value[4] . $articles_folder . getarticleName($value[0]) . $this->CFG['admin']['articles']['small_name'] . '.' . $value[5];

					//if ($value[5] == '')
					/*	$generateActivities_arr[$i]['article_comment']['article']['imgsrc'] = $this->CFG['site']['url'].
																							'article/design/templates/'.
																								$this->CFG['html']['template']['default'].
																									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																										'/no_image/noImage_S.jpg';*/

					$generateActivities_arr[$i]['article_comment']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
					$generateActivities_arr[$i]['article_comment']['lang'] = $LANG['articleactivity_comment_text'];
					//$generateActivities_arr[$i]['article_comment']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['article_comment']['date_added'] = ($activity_arr[$i]['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current'])):'';
				}
			break;

			case 'article_rated':
				/*	0.article_id
					1.rating_user_id
					2.user_name
					3.article_title
					4.article_server_url
					5.article_ext
					6.rate
				*/
				$generateActivities_arr[$i]['article_rated'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details['user'] = getUserDetail('user_id', $value[1]);
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['article_rated']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['article_rated']['user_name'] = $value[2];
					$generateActivities_arr[$i]['article_rated']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
					$generateActivities_arr[$i]['article_rated']['article_title'] = $value[3];
					$generateActivities_arr[$i]['article_rated']['rate'] = $value[5];
					$generateActivities_arr[$i]['article_rated']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
					/*$generateActivities_arr[$i]['article_rated']['article']['imgsrc'] = $value[4].$articles_folder.
																						getarticleName($value[0]).
																							$this->CFG['admin']['articles']['small_name'].
																							'.'.$value[5];

					if (empty($value[5]))
						$generateActivities_arr[$i]['article_rated']['article']['imgsrc'] = $this->CFG['site']['url'].
																							'article/design/templates/'.
																							$this->CFG['html']['template']['default'].
																								'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																								'/no_image/noImage_S.jpg';*/

					$generateActivities_arr[$i]['article_rated']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
					$generateActivities_arr[$i]['article_rated']['lang'] = str_replace('{rate}',$value[5],$LANG['articleactivity_rating_text']);
					//$generateActivities_arr[$i]['article_rated']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['article_rated']['date_added'] = ($activity_arr[$i]['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current'])):'';
				}
			break;

			case 'article_favorite':
				/*	0.article_id
					1.favorite_user_id
					2.user_name
					3.article_title
					4.article_server_url
					5.article_ext
				*/
				$generateActivities_arr[$i]['article_favorite'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details['user'] = getUserDetail('user_id', $value[1]);
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['article_favorite']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['article_favorite']['user_name'] = $value[2];
					$generateActivities_arr[$i]['article_favorite']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
					$generateActivities_arr[$i]['article_favorite']['article_title'] = $value[3];
					$generateActivities_arr[$i]['article_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

					/*if(empty($value[5]))
						$generateActivities_arr[$i]['article_favorite']['article']['imgsrc'] = $this->CFG['site']['url'].
																							'article/design/templates/'.
																								$this->CFG['html']['template']['default'].
																									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																										'/no_image/noImage_S.jpg';
					else
						$generateActivities_arr[$i]['article_favorite']['article']['imgsrc'] = $this->CFG['site']['url'].$articles_folder.
																							 getarticleName($value[0]).
																							  $this->CFG['admin']['articles']['small_name'].'.'.
																								$value[5];*/

					$generateActivities_arr[$i]['article_favorite']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.
																						  $value[0].'&amp;title='.$this->changeTitle($value[3]),
																						    $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
					$generateActivities_arr[$i]['article_favorite']['lang'] = $LANG['articleactivity_favorite_text'];
					//$generateActivities_arr[$i]['article_favorite']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['article_favorite']['date_added'] = ($activity_arr[$i]['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current'])):'';
				}
				break;

				case 'article_featured':
					/*	0.article_id
						1.favorite_user_id
						2.user_name
						3.article_title
						4.article_server_url
						5.article_ext
					*/
					$generateActivities_arr[$i]['article_featured'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					$value[3] = $this->strReplace($value[3], 'display');
					$user_details['user'] = getUserDetail('user_id', $value[1]);
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['article_featured']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['article_featured']['user_name'] = $value[2];
						$generateActivities_arr[$i]['article_featured']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
						$generateActivities_arr[$i]['article_featured']['article_title'] = $value[3];
						$generateActivities_arr[$i]['article_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
						/*if(!empty($value[5]))
							$generateActivities_arr[$i]['article_featured']['article']['imgsrc'] = $this->CFG['site']['url'].$articles_folder.
																							     getarticleName($value[0]).
																								   $this->CFG['admin']['articles']['small_name'].'.'.
																								     $value[5];
						else
							$generateActivities_arr[$i]['article_featured']['article']['imgsrc'] = $this->CFG['site']['url'].'article/design/templates/'.
																								 $this->CFG['html']['template']['default'].'/root/images/'.
																								 	$this->CFG['html']['stylesheet']['screen']['default'].
																									 '/no_image/noImage_S.jpg';*/

						$generateActivities_arr[$i]['article_featured']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.
																								$this->changeTitle($value[3]), $value[0].'/'.
																									$this->changeTitle($value[3]).'/', '', 'article');
						$generateActivities_arr[$i]['article_featured']['lang'] = $LANG['articleactivity_featured_text'];
						$generateActivities_arr[$i]['article_featured']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					}
				break;

				case 'article_responded':
					/*	0.article_id
						1.responses_user_id
						2.responses_name
						3.article_title
						4.article_server_url
						5.is_external_embed_article
						6.embed_article_image_ext
						7.user_id
						8.user_name
						9.old_article_id
						10.old_article_title
					*/
					$generateActivities_arr[$i]['article_responded'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					$value[3] = $this->strReplace($value[3], 'display');
					$value[10] = $this->strReplace($value[10], 'display');
					$user_details['user'] = getUserDetail('user_id', $value[1]);
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['article_responded']['responses_user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
								$generateActivities_arr[$i]['article_responded']['responses_user_name'] = $value[2];
						$generateActivities_arr[$i]['article_responded']['user_article']['imgsrc'] = getMemberAvatarDetails($value[1]);
						$generateActivities_arr[$i]['article_responded']['article_title'] = $value[3];
						$generateActivities_arr[$i]['article_responded']['responses_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
						$generateActivities_arr[$i]['article_responded']['old_user_name'] = $value[8];
						$generateActivities_arr[$i]['article_responded']['old_user']['url'] = getMemberProfileUrl($value[7], $value[8]);
						$generateActivities_arr[$i]['article_responded']['article']['imgsrc'] = $value[4] . $articles_folder . getarticleImageName($value[0]) . $this->CFG['admin']['articles']['small_name'] . '.' . $this->CFG['article']['image']['extensions'];

						if ($value[4] == 'Yes' && $value[5] == '')
							$generateActivities_arr[$i]['article_responded']['article']['imgsrc'] = $this->CFG['site']['url'] . 'design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no-article.gif';

						$generateActivities_arr[$i]['article_responded']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
						$generateActivities_arr[$i]['article_responded']['old_article_title'] = $value[10];
						$generateActivities_arr[$i]['article_responded']['old_viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[9].'&amp;title='.$this->changeTitle($value[10]), $value[9].'/'.$this->ChangeTitle($value[10]).'/', '', 'article');
						$generateActivities_arr[$i]['article_responded']['lang'] = $LANG['articleactivity_responded_text'];
						$generateActivities_arr[$i]['article_responded']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					}
				break;

				case 'article_share':
					/*	0.article_id
						1.user_id
						2.user_name
						3.article_title
						4.article_server_url
						5.is_external_embed_article
						6.embed_article_image_ext
						7.sender_user_id
						8.sender_user_name
						9.firend_list
					*/
					$generateActivities_arr[$i]['article_share'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					$value[3] = $this->strReplace($value[3], 'display');
					$generateActivities_arr[$i]['article_share']['article_title'] = $value[3];
					$generateActivities_arr[$i]['article_share']['sender']['url'] = getMemberProfileUrl($value[5], $value[6]);
					$user_details['user'] = getUserDetail('user_id', $value[5]);
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['article_share']['sender_user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['article_share']['sender_user_name'] = $value[6];
						$generateActivities_arr[$i]['article_share']['user_article']['imgsrc'] = getMemberAvatarDetails($value[5]);
						/*if(empty($value[8]))
							$generateActivities_arr[$i]['article_share']['article']['imgsrc'] = $this->CFG['site']['url'].
																								'article/design/templates/'.
																									$this->CFG['html']['template']['default'].
																										'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
																										'/no_image/noImage_S.jpg';
						else
							$generateActivities_arr[$i]['article_share']['article']['imgsrc'] = $this->CFG['site']['url'].$articles_folder.
																								getarticleName($value[0]).
																									$this->CFG['admin']['articles']['small_name'].'.'.
																										$value[8];*/

						$generateActivities_arr[$i]['article_share']['firend_list'] = array();
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
								$generateActivities_arr[$i]['article_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
								if($this->CFG['admin']['display_first_last_name'])
									$generateActivities_arr[$i]['article_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].' '.$row['last_name'];
								else
									$generateActivities_arr[$i]['article_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
							}
						}

						$generateActivities_arr[$i]['article_share']['viewarticle']['url'] = getUrl('viewarticle', '?article_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'article');
						$generateActivities_arr[$i]['article_share']['lang1'] = $LANG['articleactivity_shared_text1'];
						$generateActivities_arr[$i]['article_share']['lang2'] = $LANG['articleactivity_shared_text2'];
						//$generateActivities_arr[$i]['article_share']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['article_share']['date_added'] = ($activity_arr[$i]['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($activity_arr[$i]['date_added'],$activity_arr[$i]['date_current'])):'';
					}
				break;
			}
		}
		$smartyObj->assign('articleActivity_arr', $generateActivities_arr);
	}
}
?>