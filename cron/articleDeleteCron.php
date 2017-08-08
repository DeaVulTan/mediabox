<?php
/**
 * This file is to manage auto delete articles
 *
 * This file is having ManageDeleted class to auto delete the articles
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CronHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleRelatedCron.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
set_time_limit(0);
/**
 * ManageDeleted
 *
 * @package
 * @author sathish_040at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class ManageDeleted extends CronDeleteArticleHandler
{
	public function deleteArticles()
	{
		$sql = 'SELECT article_id, article_category_id FROM '.$this->CFG['db']['tbl']['article'].' WHERE'.
				' article_id=\'31\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				$this->ARTICLE_CATEGORY_ID = $row['article_category_id'];
				$this->fields_arr['article_id'] = $row['article_id'];
				$this->removeArticleRelatedEntries($row['article_id'], 'article_id');
			}
		}
	}
}
//<<<<<-------------- Class ManageDeleted begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageDeleted = new ManageDeleted();
$ManageDeleted->setDBObject($db);
$ManageDeleted->makeGlobalize($CFG,$LANG);
$ManageDeleted->deleteArticles();
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>