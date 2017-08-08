<?php
/**
 * This file is to manage deleted article
 * This file is having ManageDeleted class to manage deleted article
 * 1. IF $type is either article_id or user_id(Delete user or article)
 * 2.Article file removeArticleFiles function (chkIsLocalServer or other server)
 * 		# REMOVE THUMBNAILS
 * 		# REMOVE ORIGINAL FILES
 * 3. clearArticleCommented, clearArticleFavorited, clearArticleRated, clearArticleViewed, resetRelatedArticleDetails,
 * 	  deleteArticlesTable, sendMailToUserForDelete.
 *
 * Modification
 * 	article activity
 *
 * CronDeleteArticleHandler
 *
 * @package
 * @author sathish_040at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class CronDeleteArticleHandler extends CronHandler
{

	public $deletedArticleIds;
	public $userArticle = array();

	/**
	 * CronDeleteArticleHandler::removeArticleRelatedEntries()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function removeArticleRelatedEntries($id = 0, $type)
	{

		$this->deletedArticleIds='';
		//CLEAR ARTICLE RELATED ENTRIES//
		if($type == 'user_id')//IF ARTICLE OWNER//
		{
			$id_equal_to = ' user_id='.$this->dbObj->Param('id');
			$this->updateTable($this->CFG['db']['tbl']['article'], 'article_status=\'Deleted\'', $id_equal_to, array($id));
			$sql = 'SELECT article_id FROM '.$this->CFG['db']['tbl']['article'].' WHERE user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			while($row = $rs->FetchRow())
			{
				$this->fields_arr['article_id']=$row['article_id'];
				//1. CLEAR ARTICLE FILES //
				$this->removeArticleFiles($row['article_id'],$type);
			}
		}
		elseif($type=='article_id')
		{
			$this->fields_arr['article_id'] = $id;
			//1. CLEAR ARTICLE FILES //
			$this->removeArticleFiles($id,$type);
		}
		//2. CLEAR ARTICLE COMMENT //
		$this->clearArticleCommented($id, $type);
		//3. CLEAR ARTICLE FAVORITED //
		$this->clearArticleFavorited($id, $type);
		//4. CLEAR ARTICLE RATED //
		$this->clearArticleRated($id, $type);
		//5. CLEAR ARTICLE VIEW //
		$this->clearArticleViewed($id, $type);
		//6. RESET ARTICLE RELATED //
		$this->resetRelatedArticleDetails();
		//7. ARTICLE ACTIVITY TABEL //
		$this->clearArticleActivity($id, $type);
		//8. CLEAR ARTICLE TABEL //
		$this->deleteArticlesTable();
		return true;
	}

	/**
	 * CronDeleteArticleHandler::removeArticleFiles()
	 *
	 * @param mixed $article_id
	 * @param mixed $type
	 * @return
	 */
	public function removeArticleFiles($article_id,$type)
	{
		//$temp_article_folder  = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['articles']['temp_folder'].'/';
		$original_article_file_folder    = '../'.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';

		if($this->getArticleDetails())
		{
			$this->deleteArticleAttachments($article_id);
			$this->populateArticleDetails();
			$article_attachment_files_folder_id = $original_article_file_folder.$article_id.'/';

			if($this->chkIsLocalServer())
			{
				//Code to remove article files contents and its directory for the corresponding article
				$this->removeDirectory($article_attachment_files_folder_id);

				if($type=='article_id')
					$this->sendMailToUserForDelete();
			}
			else
			{
				if($this->getServerDetails())
				{
					if($FtpObj = new FtpHandler($this->fields_arr['ftp_server'],$this->fields_arr['ftp_usrename'],$this->fields_arr['ftp_password']))
					{
						if($this->fields_arr['ftp_folder'])
							$FtpObj->changeDirectory($this->fields_arr['ftp_folder']);

						$dir_article = $original_article_file_folder.$article_id.'/';

						//Code to remove article files contents and its directory for the corresponding article
						$FtpObj->removeFolder($dir_article);

						$FtpObj->ftpClose();
						if($type=='article_id')
							$this->sendMailToUserForDelete();
					}
				}
			}
				$this->deletedArticleIds.=$article_id.',';
		}
		return true;
	}

	/**
	 * CronDeleteArticleHandler::getArticleDetails()
	 *
	 * @return
	 */
	public function getArticleDetails()
	{
		$sql = 'SELECT user_id, article_server_url, article_category_id FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->fields_arr['user_id'] 		  = $row['user_id'];
			$this->fields_arr['article_server_url'] = $row['article_server_url'];
			$this->ARTICLE_CATEGORY_ID 			  = $row['article_category_id'];
			return true;
		}
		return false;
	}

	/**
	 * CronDeleteArticleHandler::sendMailToUserForDelete()
	 *
	 * @return
	 */
	public function sendMailToUserForDelete()
	{
		if(isset($this->ARTICLE_USER_EMAIL) and $this->ARTICLE_USER_EMAIL)
		{
			$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['article_delete_subject']);
			$body = $this->LANG['article_delete_content'];
			$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
			$body = str_replace('VAR_USER_NAME', $this->ARTICLE_USER_NAME, $body);
			$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
			$body = str_replace('VAR_ARTICLE_TITLE', $this->ARTICLE_TITLE, $body);
			//echo $this->ARTICLE_USER_EMAIL;
			$this->_sendMail($this->ARTICLE_USER_EMAIL, $subject, nl2br($body), $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			return true;
		}
		else
			return true;
	}

	/**
	 * CronDeleteArticleHandler::getServerDetails()
	 *
	 * @return
	 */
	public function getServerDetails()
	{
		$server_url = str_replace($this->CFG['admin']['articles']['folder'].'/','',$this->fields_arr['article_server_url']);
		$cid = $this->ARTICLE_CATEGORY_ID.',0';

		$sql = 'SELECT ftp_server, ftp_folder, ftp_usrename, ftp_password, category FROM'.
				' '.$this->CFG['db']['tbl']['server_settings'].
				' WHERE server_for=\'article\' AND server_url='.$this->dbObj->Param('server_url').
				' AND category IN('.$cid.') LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($server_url));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return false;

		while($row = $rs->FetchRow())
		{
			$this->fields_arr['ftp_server']   = $row['ftp_server'];
			$this->fields_arr['ftp_folder']   = $row['ftp_folder'];
			$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
			$this->fields_arr['ftp_password'] = $row['ftp_password'];

			if($row['category']==$this->ARTICLE_CATEGORY_ID)
				return true;
		}
		if(isset($this->fields_arr['ftp_server']) and $this->fields_arr['ftp_server'])
			return true;
		return false;
	}

	/**
	 * CronDeleteArticleHandler::populateArticleDetails()
	 *
	 * @return
	 */
	public function populateArticleDetails()
	{
		$this->ARTICLE_USER_NAME = '';
		$this->ARTICLE_USER_EMAIL = '';
		$this->ARTICLE_USER_ID = '';
		$sql = 'SELECT article_title, article_category_id, user_id FROM'.
				' '.$this->CFG['db']['tbl']['article'].' WHERE'.
				' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->ARTICLE_TITLE       = $row['article_title'];
			$this->ARTICLE_CATEGORY_ID = $row['article_category_id'];
			$sql = 'SELECT user_name, email, user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE'.
					' user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs1 = $this->dbObj->Execute($stmt, array($row['user_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row1 = $rs1->FetchRow())
			{
				$this->ARTICLE_USER_NAME  = $row1['user_name'];
				$this->ARTICLE_USER_EMAIL = $row1['email'];
				$this->ARTICLE_USER_ID    = $row1['user_id'];
			}
			return true;
		}
		return false;
	}

	/**
	 * CronDeleteArticleHandler::removeFiles()
	 *
	 * @param mixed $file
	 * @return
	 */
	public function removeFiles($file)
	{
		if(is_file($file))
		{
			unlink($file);
			return true;
		}
		return false;
	}

	/**
	 * CronDeleteArticleHandler::removeFiles()
	 *
	 * @param mixed $file
	 * @return
	 */
	public function removeDirectory($dir)
	{
		if(is_dir($dir))
		{
			$d = dir($dir);
			while($entry = $d->read())
			{
 				if ($entry!= "." && $entry!= "..")
				{
 					unlink($entry);
 				}
			}
			$d->close();
			rmdir($dir);
			return true;
		}
		return false;
	}


	/**
	 * CronDeleteArticleHandler::clearArticleCommented()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearArticleCommented($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'article_id';
			$condition = 'comment_user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'article_id')
		{
			$field = 'comment_user_id';
			$condition = 'article_id='.$this->dbObj->Param('id');
		}
		$sql = 'SELECT article_comment_id, '.$field.' FROM '.$this->CFG['db']['tbl']['article_comments'].' WHERE '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userArticle[($type=='article_id')?$id:$row['article_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['article_comments'], 'article_comment_id', $row['article_comment_id']);
		    }
		}
		return true;
	}

	/**
	 * CronDeleteArticleHandler::clearArticleFavorited()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearArticleFavorited($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'article_id';
			$condition = 'user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'article_id')
		{
			$field = 'user_id';
			$condition = 'article_id='.$this->dbObj->Param('id');
		}
		$sql  = 'SELECT article_favorite_id, '.$field.' FROM '.$this->CFG['db']['tbl']['article_favorite'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userArticle[($type=='article_id')?$id:$row['article_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['article_favorite'], 'article_favorite_id', $row['article_favorite_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeleteArticleHandler::clearArticleRated()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearArticleRated($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'article_id';
			$condition = 'user_id='.$this->dbObj->Param('id');
		}
		elseif($type == 'article_id')
		{
			$field = 'user_id';
			$condition = 'article_id='.$this->dbObj->Param('id');
		}
		$sql  = 'SELECT rating_id, '.$field.' FROM '.$this->CFG['db']['tbl']['article_rating'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userArticle[($type=='article_id')?$id:$row['article_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['article_rating'], 'rating_id', $row['rating_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeleteArticleHandler::clearArticleViewed()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearArticleViewed($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$field = 'article_id';
			$condition = 'user_id='.$this->dbObj->Param('user_id').
							' OR article_owner_id='.$this->dbObj->Param('article_owner_id');
			$value_arr = array($id, $id);
		}
		elseif($type == 'article_id')
		{
			$field = 'user_id';
			$condition = 'article_id='.$this->dbObj->Param('article_id');
			$value_arr = array($id);
		}
		$sql  = 'SELECT article_viewed_id, '.$field.' FROM '.$this->CFG['db']['tbl']['article_viewed'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, $value_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
    		while($row = $rs->FetchRow())
		    {
				$this->userArticle[($type=='article_id')?$id:$row['article_id']] = '1';
				$this->deleteFromTableWithPrimaryKey($this->CFG['db']['tbl']['article_viewed'], 'article_viewed_id', $row['article_viewed_id']);
		    } // while
		}
		return true;
	}

	/**
	 * CronDeleteArticleHandler::resetRelatedArticleDetails()
	 *
	 * @return
	 */
	public function resetRelatedArticleDetails()
	{
		if ($this->userArticle)
	    {
			$userArticle = array_keys($this->userArticle);
			foreach($userArticle as $articleId)
			{
				$totalComments 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['article_comments'], 'article_id='.$this->dbObj->Param($articleId), array($articleId));
				$totalFavorites = $this->getNumRowsForThisSql($this->CFG['db']['tbl']['article_favorite'], 'article_id='.$this->dbObj->Param($articleId), array($articleId));
				$totalViews	 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['article_viewed'], 'article_id='.$this->dbObj->Param($articleId), array($articleId));
				$ratingCount 	= $this->getNumRowsForThisSql($this->CFG['db']['tbl']['article_rating'], 'article_id='.$this->dbObj->Param($articleId), array($articleId));
				$ratingTotal	= $this->getTotalRatingForThisArticle($articleId);
				$sql  = 'UPDATE '.$this->CFG['db']['tbl']['article'].
						' SET '.
						' total_comments='.$this->dbObj->Param($totalComments).','.
						' total_favorites='.$this->dbObj->Param($totalFavorites).','.
						' total_views='.$this->dbObj->Param($totalViews).','.
						' rating_count='.$this->dbObj->Param($ratingCount).','.
						' rating_total='.$this->dbObj->Param($ratingTotal).
						' WHERE article_id='.$this->dbObj->Param($articleId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt, array($totalComments, $totalFavorites, $totalViews, $ratingCount, $ratingTotal, $articleId));
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		    }
		}
	}

	/**
	 * CronDeleteArticleHandler::deleteArticlesTable()
	 *
	 * @return
	 */
	public function deleteArticlesTable()
	{
		$article_id = $this->deletedArticleIds;
		$articleId_arr = explode(',',$article_id);
		$articleId_arr = array_filter($articleId_arr);
		$article_id = implode(',',$articleId_arr);
		if($article_id)
		{
			$tablename_arr = array('article');
			for($i=0;$i<sizeof($tablename_arr);$i++)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].' WHERE article_id IN ('.$article_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}

	/**
	 * CronDeleteArticleHandler::getTotalRatingForThisArticle()
	 *
	 * @param integer $article_id
	 * @return
	 */
	public function getTotalRatingForThisArticle($article_id = 0)
	{
		$ratingTotal = 0;
		$sql = 'SELECT SUM(rate) AS rating_total '.
				'FROM '.$this->CFG['db']['tbl']['article_rating'].
				' WHERE article_id='.$this->dbObj->Param($article_id);

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			$ratingTotal = $row['rating_total'];
	    }
		return $ratingTotal?$ratingTotal:0;
	}

	/**
	 * CronDeleteArticleHandler::chkIsLocalServer()
	 *
	 * @return
	 */
	public function chkIsLocalServer()
	{
		$server_url = $this->fields_arr['article_server_url'];
		if(strstr($server_url,$this->CFG['site']['url']))
		{
			$server_url = str_replace($this->CFG['site']['url'],'',$server_url);
			if(trim($server_url)=='')
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * CronDeleteArticleHandler::clearArticleActivity()
	 *
	 * @param integer $id
	 * @param mixed $type
	 * @return
	 */
	public function clearArticleActivity($id = 0, $type)
	{
		if($type == 'user_id')
		{
			$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['article_activity'].' WHERE actor_id='.$this->dbObj->Param('actor_id').
					' OR owner_id='.$this->dbObj->Param('owner_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($id, $id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
		}
		elseif($type == 'article_id')
		{
			$action_key = array('article_uploaded', 'article_comment', 'article_rated', 'article_favorite', 'article_share');
			$article_ids = substr($this->deletedArticleIds,0,-1);
			for($inc=0;$inc<count($action_key);$inc++)
			{
				//$condition = ' SUBSTRING(action_value, 1, 1 ) IN ('.substr($this->deletedArticleIds,0,-1).') AND action_key = \''.$action_key[$inc].'\'';
				//$condition = '  content_id IN ('.$article_ids.') AND action_key = \''.$action_key[$inc].'\'';
				$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$article_ids.') AND action_key = \''.$action_key[$inc].'\'';
				$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['article_activity'].' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}
		}
		return true;
	}


	function deleteArticleAttachments($article_id)
	{

			$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['article_attachments'].' WHERE article_id='.$this->dbObj->Param('article_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($article_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

	}
}
?>