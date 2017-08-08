<?php
/**
 * Class to handle the Blog Activities module
 *
 * This is having class blogActivity to handle
 * IMP action_value format: first letter must be blog_post_id
 *
 * @category	Rayzz
 * @package		Common/Classes
 */

class blogActivityHandler extends FormHandler
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
	 * blogActivityHandler::addActivity()
	 * To add blog post activities
	 *
	 * @param array $activity_arr
	 * @return void
	 */
	public function addActivity($activity_arr)
	{
		  /*1.	blog_created
		  	2.	blog_post_created
			3.	blog_post_comment
			4.	blog_post_rated
			5.	blog_post_favorite
			6.	blog_post_featured
			7.	blog_post_share
			8.	delete_blog_post_favorite
			9.	delete_blog_post_featured*/
		switch($activity_arr['action_key'])
		{
			case 'blog_created':
				$activity_arr['blog_name'] = $this->strReplace($activity_arr['blog_name']);
				$action_value = $activity_arr['blog_id'].'~'.
									$activity_arr['upload_user_id'].'~'.
									$activity_arr['upload_user_name'].'~'.
									$activity_arr['blog_name'];

				$activity_val_arr = array($activity_arr['upload_user_id'],$activity_arr['upload_user_id']);
				$blog_activity_val_arr = array($activity_arr['blog_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['upload_user_id'],
												$activity_arr['upload_user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'blog\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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

			case 'blog_post_created':
				$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
				$action_value = $activity_arr['blog_post_id'].'~'.
									$activity_arr['upload_user_id'].'~'.
									$activity_arr['upload_user_name'].'~'.
									$activity_arr['blog_post_name'];

				$activity_val_arr = array($activity_arr['upload_user_id'],$activity_arr['upload_user_id']);
				$blog_activity_val_arr = array($activity_arr['blog_post_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['upload_user_id'],
												$activity_arr['upload_user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'blog\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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


			case 'blog_post_comment':
				$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
				$action_value = $activity_arr['blog_post_id'].'~'.
									$activity_arr['comment_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['blog_post_name'];
				$activity_val_arr = array($activity_arr['user_id'],
											$activity_arr['comment_user_id']);
				$blog_activity_val_arr = array($activity_arr['blog_comment_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['comment_user_id'],
													$activity_arr['user_id']);
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'blog\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('comment_user_id').','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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

			case 'blog_post_rated':
				$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
				$action_value = $activity_arr['blog_post_id'].'~'.
									$activity_arr['rating_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['blog_post_name'].'~'.
									$activity_arr['rate'];

				//Cheack actor already rate same content..
				$sql = 'SELECT content_id FROM '.$this->CFG['db']['tbl']['blog_activity'].
						' WHERE action_key= \'blog_post_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
						' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['blog_rating_id'].'\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row['content_id'] = $rs->FetchRow();

				if(empty($row['content_id']))
				{
					$activity_val_arr = array($activity_arr['user_id'],
												$activity_arr['rating_user_id']);

					$blog_activity_val_arr = array($activity_arr['blog_rating_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['rating_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'blog\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('rating_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					$parent_id = $this->dbObj->Insert_ID();
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_activity'].
							' SET date_added = NOW(), '.
							' action_value = \''.$action_value.'\' '.
							' WHERE action_key= \'blog_post_rated\' AND actor_id=\''.$activity_arr['rating_user_id'].'\' '.
							' AND owner_id=\''.$activity_arr['user_id'].'\' AND  content_id=\''.$activity_arr['blog_rating_id'].'\' ';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				}
				break;

				case 'blog_post_favorite':
					$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
					$action_value = $activity_arr['blog_post_id'].'~'.
									$activity_arr['favorite_user_id'].'~'.
									$activity_arr['user_name'].'~'.
									$activity_arr['blog_post_name'];

					$activity_val_arr = array($activity_arr['user_id'],
												$activity_arr['favorite_user_id']);
					$blog_activity_val_arr = array($activity_arr['blog_favorite_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['favorite_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'blog\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('favorite_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					$parent_id = $this->dbObj->Insert_ID();

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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

				case 'blog_post_featured':
					$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
					$action_value = $activity_arr['blog_post_id'].'~'.
										$activity_arr['featured_user_id'].'~'.
										$activity_arr['user_name'].'~'.
										$activity_arr['blog_post_name'];

					$activity_val_arr = array($activity_arr['user_id'],
												$activity_arr['featured_user_id']);

					$blog_activity_val_arr = array($activity_arr['blog_featured_id'],
													$activity_arr['action_key'],
													$action_value,
													$activity_arr['featured_user_id'],
													$activity_arr['user_id']);

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
							' SET module = \'blog\','.
							' owner_id = '.$this->dbObj->Param('user_id').','.
							' actor_id = '.$this->dbObj->Param('featured_user_id').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					$parent_id = $this->dbObj->Insert_ID();

					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
							' SET parent_id = '.$parent_id.','.
							' content_id = '.$this->dbObj->Param('content_id').','.
							' action_key = '.$this->dbObj->Param('action_key').','.
							' action_value = '.$this->dbObj->Param('action_value').','.
							' actor_id = '.$this->dbObj->Param('actor_id').','.
							' owner_id = '.$this->dbObj->Param('action_value').','.
							' date_added = NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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

			case 'blog_post_share':
				$activity_arr['blog_post_name'] = $this->strReplace($activity_arr['blog_post_name']);
				$action_value = $activity_arr['blog_post_id'].'~'.
								$activity_arr['user_id'].'~'.
								$activity_arr['user_name'].'~'.
								$activity_arr['blog_post_name'].'~'.
								$activity_arr['sender_user_id'].'~'.
								$activity_arr['sender_user_name'].'~'.
								$activity_arr['firend_list'];

				$activity_val_arr = array($activity_arr['user_id'],
											$activity_arr['sender_user_id']);

				$blog_activity_val_arr = array($activity_arr['blog_post_id'],
												$activity_arr['action_key'],
												$action_value,
												$activity_arr['sender_user_id'],
												$activity_arr['user_id']);

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['activity'].
						' SET module = \'blog\','.
						' owner_id = '.$this->dbObj->Param('user_id').','.
						' actor_id = '.$this->dbObj->Param('featured_user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $activity_val_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$parent_id = $this->dbObj->Insert_ID();

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_activity'].
						' SET parent_id = '.$parent_id.','.
						' content_id = '.$this->dbObj->Param('content_id').','.
						' action_key = '.$this->dbObj->Param('action_key').','.
						' action_value = '.$this->dbObj->Param('action_value').','.
						' actor_id = '.$this->dbObj->Param('actor_id').','.
						' owner_id = '.$this->dbObj->Param('action_value').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $blog_activity_val_arr);
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

			case 'delete_blog_post_favorite';
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_activity'].
						' SET status = \'Deleted\' '.
						' WHERE action_key= \'blog_post_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['blog_favorite_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].
						' WHERE action_key= \'blog_post_favorite\' AND actor_id= '.$activity_arr['favorite_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['blog_favorite_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
						' SET status = \'Deleted\' '.
						' WHERE parent_id= '.$row['parent_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			break;

			case 'delete_blog_post_featured';
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_activity'].
						' SET status = \'Deleted\' '.
						' WHERE action_key= \'blog_post_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['blog_featured_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].
						' WHERE action_key= \'blog_post_featured\' AND actor_id= '.$activity_arr['featured_user_id'].' '.
						' AND owner_id= '.$activity_arr['user_id'].' AND  content_id= '.$activity_arr['blog_featured_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['activity'].
						' SET status = \'Deleted\' '.
						' WHERE parent_id= '.$row['parent_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			break;
			}
		}

	/**
	 * blogActivityHandler::getActivities()
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
				' actor_id, parent_id, TIMEDIFF(NOW(), date_added) as date_added FROM '.$this->CFG['db']['tbl']['blog_activity'].
				' WHERE status=\'Yes\' AND id IN ('.$activityIDs.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);

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
	 * blogActivityHandler::generateActivities()
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
		//$rayzz = new RayzzHandler($this->dbObj, $this->CFG);
		$blogs_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/';
		require_once($this->CFG['site']['project_path'].'languages/'.$this->CFG['lang']['default'].'/blog/blogActivity.php');
		for($i=0;$i<count($activity_arr);$i++)
		{
			$generateActivities_arr[$i]['action_key'] = $activity_arr[$i]['action_key'];
			$generateActivities_arr[$i]['parent_id'] = $activity_arr[$i]['parent_id'];
			switch($activity_arr[$i]['action_key'])
			{
				case 'blog_created':
					/*	0.blog_id
						1.upload_user_id
						2.upload_user_name
						3.blog_name
					*/
					$generateActivities_arr[$i]['blog_created'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					//echo '<pre>'; print_r($value); echo '</pre>';
					$value[3] = $this->strReplace($value[3], 'display');
					$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['blog_created']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['blog_created']['user_name'] = $value[2];
						$generateActivities_arr[$i]['blog_created']['user_blog']['imgsrc'] = $user_details['icon'];
						$generateActivities_arr[$i]['blog_created']['blog_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
						$generateActivities_arr[$i]['blog_created']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
                        $thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/';

						$generateActivities_arr[$i]['blog_created']['viewblog']['url'] = getUrl('viewblog',$value[3], $value[3].'/', '', 'blog');
						$generateActivities_arr[$i]['blog_created']['lang1'] = $LANG['blogactivity_blog_created_text1'];
						$generateActivities_arr[$i]['blog_created']['lang2'] = $LANG['blogactivity_blog_created_text2'];
						$generateActivities_arr[$i]['blog_created']['lang'] = $LANG['blogactivity_blog_created_text1'].$LANG['blogactivity_blog_created_text2'];
						$generateActivities_arr[$i]['blog_created']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['blog_created']['profileIcon'] = getMemberAvatarDetails($value[1]);

					}
			break;

				case 'blog_post_created':
					/*	0.blog_post_id
						1.upload_user_id
						2.upload_user_name
						3.blog_name
					*/
					$generateActivities_arr[$i]['blog_post_created'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					//echo '<pre>'; print_r($value); echo '</pre>';
					$value[3] = $this->strReplace($value[3], 'display');
					$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['blog_post_created']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['blog_post_created']['user_name'] = $value[2];
						$generateActivities_arr[$i]['blog_post_created']['user_blog']['imgsrc'] = $user_details['icon'];
						$generateActivities_arr[$i]['blog_post_created']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
						$generateActivities_arr[$i]['blog_post_created']['uploaded_user']['url'] = getMemberProfileUrl($value[1], $value[2]);
                        $thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/';

						$generateActivities_arr[$i]['blog_post_created']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'blog');
						$generateActivities_arr[$i]['blog_post_created']['lang'] = $LANG['blogactivity_upload_text'];
						$generateActivities_arr[$i]['blog_post_created']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['blog_post_created']['profileIcon'] = getMemberAvatarDetails($value[1]);

					}
			break;

			case 'blog_post_comment':
				/*	0.blog_post_id
					1.comment_user_id
					2.user_name
					3.blog_post_name
				*/

				$generateActivities_arr[$i]['blog_post_comment'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['blog_post_comment']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['blog_post_comment']['user_name'] = $value[2];
					$generateActivities_arr[$i]['blog_post_comment']['user_blog']['imgsrc'] = $user_details['icon'];
					$generateActivities_arr[$i]['blog_post_comment']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
					$generateActivities_arr[$i]['blog_post_comment']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);


					$generateActivities_arr[$i]['blog_post_comment']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'blog');
					$generateActivities_arr[$i]['blog_post_comment']['lang'] = $LANG['blogactivity_comment_text'];
					$generateActivities_arr[$i]['blog_post_comment']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['blog_post_comment']['profileIcon'] = getMemberAvatarDetails($value[1]);

				}
			break;

			case 'blog_post_rated':
				/*	0.blog_post_id
					1.rating_user_id
					2.user_name
					3.blog_post_name
					4.rate
				*/

				$generateActivities_arr[$i]['blog_post_rated'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['blog_post_rated']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['blog_post_rated']['user_name'] = $value[2];
					$generateActivities_arr[$i]['blog_post_rated']['user_blog']['imgsrc'] = $user_details['icon'];
					$generateActivities_arr[$i]['blog_post_rated']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
					$generateActivities_arr[$i]['blog_post_rated']['rate'] = $value[4];
					$generateActivities_arr[$i]['blog_post_rated']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

					$generateActivities_arr[$i]['blog_post_rated']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'blog');
					$generateActivities_arr[$i]['blog_post_rated']['lang1'] = str_replace('{rate}',$value[4],$LANG['blogactivity_rating_text1']);
					$generateActivities_arr[$i]['blog_post_rated']['lang2'] = $LANG['blogactivity_rating_text2'];
					$generateActivities_arr[$i]['blog_post_rated']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['blog_post_rated']['profileIcon'] = getMemberAvatarDetails($value[1]);

				}
			break;

			case 'blog_post_favorite':
				/*	0.blog_post_id
					1.favorite_user_id
					2.user_name
					3.blog_post_name
				*/
				$generateActivities_arr[$i]['blog_post_favorite'] = array();
				$value = explode('~', $activity_arr[$i]['action_value']);
				$value[3] = $this->strReplace($value[3], 'display');
				$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
				if(!empty($user_details['user']))
				{
					if($this->CFG['admin']['display_first_last_name'])
						$generateActivities_arr[$i]['blog_post_favorite']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
					else
						$generateActivities_arr[$i]['blog_post_favorite']['user_name'] = $value[2];
					$generateActivities_arr[$i]['blog_post_favorite']['user_blog']['imgsrc'] = $user_details['icon'];
					$generateActivities_arr[$i]['blog_post_favorite']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
					$generateActivities_arr[$i]['blog_post_favorite']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

					$generateActivities_arr[$i]['blog_post_favorite']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.
																						  $value[0].'&amp;title='.$this->changeTitle($value[3]),
																						    $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'blog');
					$generateActivities_arr[$i]['blog_post_favorite']['lang1'] = $LANG['blogactivity_favorite_text1'];
					$generateActivities_arr[$i]['blog_post_favorite']['lang2'] = $LANG['blogactivity_favorite_text2'];
					$generateActivities_arr[$i]['blog_post_favorite']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
					$generateActivities_arr[$i]['blog_post_favorite']['profileIcon'] = getMemberAvatarDetails($value[1]);

				}
				break;

				case 'blog_post_featured':
					/*	0.blog_post_id
						1.favorite_user_id
						2.user_name
						3.blog_post_name
					*/
					$generateActivities_arr[$i]['blog_post_featured'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					$value[3] = $this->strReplace($value[3], 'display');
					$user_details = $this->getUserDetail('user_id',$value[1], 'user_name');
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['blog_post_featured']['user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['blog_post_featured']['user_name'] = $value[2];
						$generateActivities_arr[$i]['blog_post_featured']['user_blog']['imgsrc'] = $user_details['icon'];
						$generateActivities_arr[$i]['blog_post_featured']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
						$generateActivities_arr[$i]['blog_post_featured']['comment_user']['url'] = getMemberProfileUrl($value[1], $value[2]);

						$generateActivities_arr[$i]['blog_post_featured']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.$value[0].'&amp;title='.
																								$this->changeTitle($value[3]), $value[0].'/'.
																									$this->changeTitle($value[3]).'/', '', 'blog');
						$generateActivities_arr[$i]['blog_post_featured']['lang1'] = $LANG['blogactivity_featured_text1'];
						$generateActivities_arr[$i]['blog_post_featured']['lang2'] = $LANG['blogactivity_featured_text2'];
						$generateActivities_arr[$i]['blog_post_featured']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['blog_post_featured']['profileIcon'] = getMemberAvatarDetails($value[1]);

					}
				break;

				case 'blog_post_share':
					/*	0.blog_post_id
						1.user_id
						2.user_name
						3.blog_post_name
						4.sender_user_id
						5.sender_user_name
						6.firend_list
					*/
					$generateActivities_arr[$i]['blog_post_share'] = array();
					$value = explode('~', $activity_arr[$i]['action_value']);
					$value[3] = $this->strReplace($value[3], 'display');
					$generateActivities_arr[$i]['blog_post_share']['blog_post_name'] = wordWrap_mb_ManualWithSpace($value[3], $this->CFG['admin']['blog']['activity_title_length'], $this->CFG['admin']['blog']['activity_title_total_length']);
					$generateActivities_arr[$i]['blog_post_share']['sender']['url'] = getMemberProfileUrl($value[4], $value[5]);
					$user_details = $this->getUserDetail('user_id',$value[4], 'user_name');
					if(!empty($user_details['user']))
					{
						if($this->CFG['admin']['display_first_last_name'])
							$generateActivities_arr[$i]['blog_post_share']['sender_user_name'] = $user_details['user']['first_name'].' '.$user_details['user']['last_name'];
						else
							$generateActivities_arr[$i]['blog_post_share']['sender_user_name'] = $value[5];
						$generateActivities_arr[$i]['blog_post_share']['user_blog']['imgsrc'] = $user_details['icon'];

						$generateActivities_arr[$i]['blog_post_share']['firend_list'] = array();
						$firend_list = explode(',', $value[6]);

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
								$generateActivities_arr[$i]['blog_post_share']['firend_list'][$inc]['url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
								if($this->CFG['admin']['display_first_last_name'])
									$generateActivities_arr[$i]['blog_post_share']['firend_list'][$inc]['firend_name'] = $row['first_name'].' '.$row['last_name'];
								else
									$generateActivities_arr[$i]['blog_post_share']['firend_list'][$inc]['firend_name'] = $row['user_name'];
							}
						}

						$generateActivities_arr[$i]['blog_post_share']['viewpost']['url'] = getUrl('viewpost', '?blog_post_id='.$value[0].'&amp;title='.$this->changeTitle($value[3]), $value[0].'/'.$this->changeTitle($value[3]).'/', '', 'blog');
						$generateActivities_arr[$i]['blog_post_share']['lang1'] = $LANG['blogactivity_shared_text1'];
						$generateActivities_arr[$i]['blog_post_share']['lang2'] = $LANG['blogactivity_shared_text2'];
						$generateActivities_arr[$i]['blog_post_share']['date_added'] = getTimeDiffernceFormat($activity_arr[$i]['date_added']);
						$generateActivities_arr[$i]['blog_post_share']['profileIcon'] = getMemberAvatarDetails($value[1]);

					}
				break;
			}
		}
		$smartyObj->assign('blogActivity_arr', $generateActivities_arr);
	}
}
?>