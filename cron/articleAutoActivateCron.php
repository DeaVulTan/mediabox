<?php
/**
 * This file is to auto activate the uploaded  article based on publish date
 *
 * This file is handling Articles to be activated which has infuture article status
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
set_time_limit(0);
class ArticleActivate extends ArticleHandler
{
	/**
	 * ArticleActivate::populateArticleDetailsForActivate()
	 *
	 * @return
	 */
	public function populateArticleDetailsForActivate()
	{
		$sql  = 'SELECT a.article_id, a.user_id, a.article_title, a.relation_id,'.
				 'u.user_name, u.first_name, u.last_name, a.article_status FROM'.
				 ' '.$this->CFG['db']['tbl']['article'].' as a LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				 ' as u ON a.user_id=u.user_id WHERE a.article_status IN ( \'ToActivate\',  \'InFuture\') '.
				 ' AND DATE_SUB(NOW(),INTERVAL '.$this->CFG['admin']['articles']['article_auto_activate_time'].' HOUR) > a.date_added';

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
		    {
		    	$this->ARTICLE_ID  = $row['article_id'];
		    	$this->ARTICLE_USER_ID  = $row['user_id'];
				if($this->activateArticle() && !$this->chkArticleExistInActivity($this->ARTICLE_ID))
				{
					$this->increaseTotalArticleCount($this->ARTICLE_USER_ID );
					$this->addArticleUploadActivity($this->ARTICLE_ID);
					$this->sendMailToUserForActivate($this->ARTICLE_ID);
					if($row['relation_id'])
						{
							$this->shareArticleDetails($this->ARTICLE_ID);
						}
			    }

			}
		}
	}
	/**
	 * ArticleActivate::activateArticle()
	 *
	 * @return
	 */
	public function activateArticle()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET'.
					' article_status=\'Ok\' WHERE'.
					' article_id='.$this->dbObj->Param('article_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->ARTICLE_ID));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);


		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET total_articles=total_articles+1'.
				' WHERE user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->ARTICLE_USER_ID));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		return true;
	}
}
//<<<<<-------------- Class MusicActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//

$articleactivate = new ArticleActivate();
$articleactivate->setDBObject($db);
$articleactivate->makeGlobalize($CFG, $LANG);
$articleactivate->setMediaPath('../');
$articleactivate->setFormField('relation_id','');
//default form fields and values...
$articleactivate->populateArticleDetailsForActivate();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>