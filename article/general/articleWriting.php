<?php
/**
 * File to allow the users to add/edit article
 *
 * Provides an interface to get article details such as
 * title, description, attachment, tags, category, sub category,
 * sharing, comment setting for the article, rating setting for
 * the article.
 */

/**
 * ArticleWriting
 *
 *
 * @category	Rayzz
 * @package		General
 **/
class ArticleWriting extends ArticleHandler
{
	public $ARTICLE_ID		  = '';
	public $ARTICLE_TITLE 		  = '';
	public $ARTICLE_CATEGORY_ID   = '';
	public $ARTICLE_USER_NAME 	  = '';
	public $ARTICLE_USER_EMAIL 	  = '';
	public $ARTICLE_USER_ID 	  = '';
	public $ARTICLE_RELATION_ID   = '';
	public $ARTICLE_DESCRIPTION   = '';
	/**
	 * ArticleWriting::updateArticleTable()
	 *
	 * @param Integer $article_id
	 * @return void
	 */
	public function updateArticleTable($article_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET '.
				'article_attachment=1 '.
				'WHERE article_id='.$this->dbObj->Param('article_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$this->updateArticleAttachmentsTable($article_id);
	}

	/**
	 * ArticleWriting::updateArticleAttachmentsTable()
	 *
	 * @param Integer $article_id
	 * @return void
	 */
	public function updateArticleAttachmentsTable($article_id)
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_attachments'].' SET '.
				'article_id='.$this->dbObj->Param('article_id').', file_name='.$this->dbObj->Param('file_name').', '.
				'file_ext='.$this->dbObj->Param('file_ext').', file_type='.$this->dbObj->Param('file_type').', '.
				'server_url='.$this->dbObj->Param('server_url').', date_added=now()';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id, $this->fields_arr['file_name'], $this->fields_arr['article_ext'], $this->fields_arr['file_type'], $this->fields_arr['server_url']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
	}

	/**
	 * ArticleWriting::populateArticleCatagory()
	 *
	 * @param string $err_tip
	 * @return array
	 **/
	public function populateArticleCatagory($type = 'General', $err_tip='')
	{
		$sql = 'SELECT article_category_id, article_category_name FROM '.
				$this->CFG['db']['tbl']['article_category'].
				' WHERE parent_category_id=0 AND article_category_status=\'Yes\''.
				' AND article_category_type='.$this->dbObj->Param('article_category_type').
				' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($type));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if(!$rs->PO_RecordCount())
			return;

		$names = array('article_category_name');
		$value = 'article_category_id';
		$highlight_value = $this->fields_arr['article_category_id'];

		$inc = 0;
		while($row = $rs->FetchRow())
		{
			$out = '';
			foreach($names as $name)
				$out .= $row[$name];
			$selected = $highlight_value == $row[$value]?' selected="selected"':'';
			?><option value="<?php echo $row[$value];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
			$inc++;
		}
	}

	/**
	 * ArticleWriting::populateArticleSubCategory()
	 *
	 * @param string $err_tip
	 * @return string
	 **/
	public function populateArticleSubCategory()
	{
		if (!$this->fields_arr['article_category_id'])
			return ;

		$populateArticleSubCategory = '';
		$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
				' WHERE parent_category_id='.$this->dbObj->Param('article_category_id').' AND article_category_status=\'Yes\' ORDER BY article_category_name';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_category_id']));
		if (!$rs)
			    trigger_db_error($this->dbObj);

		$names = array('article_category_name');
		$value = 'article_category_id';
		$highlight_value = $this->fields_arr['article_sub_category_id'];
		?>
		<select name="article_sub_category_id" id="article_sub_category_id" tabindex="1060">
			<option value=""><?php echo $this->LANG['articlewriting_select_sub_category'];?></option>
		<?php

		while($row = $rs->FetchRow())
		{
			$out = '';
			$selected = $highlight_value == $row[$value]?' selected="selected"':'';
			foreach($names as $name)
				$out .= $row[$name].' ';
		?>
			<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['article_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
		<?php
		}
		?>
		</select>
		<?php
	}

	/**
	 * ArticleWriting::insertArticleTable()
	 *
	 * @param array $fields_arr
	 * @param string $err_tip
	 * @return Integer
	 **/
	public function insertArticleTable($fields_arr, $err_tip='')
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article'].' SET ';
		$field_values_arr = array();
		foreach($fields_arr as $fieldname)
		{
			if($this->fields_arr[$fieldname]!='NOW()')
			{
				$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
				$field_values_arr[] = $this->fields_arr[$fieldname];
			}
			else
			{
				$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
			}
		}
		$sql = substr($sql, 0, strrpos($sql, ','));

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, $field_values_arr);
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$return = $this->dbObj->Insert_ID();
		return $return;
	}

	/**
	 * ArticleWriting::getReferrerUrl()
	 *
	 * @return void
	 **/
	public function getReferrerUrls()
	{
		if(!$this->fields_arr['gpukey'])
		{
			if(isset($_SERVER['HTTP_REFERER']) and !strstr($_SERVER['HTTP_REFERER'],'articleWriting'))
			{
				$key = substr(md5(microtime()),0,10);
				$_SESSION['gpukey'][$key] = $_SERVER['HTTP_REFERER'];
				$this->fields_arr['gpukey'] = $key;
			}
			else
			{
				$key = substr(md5(microtime()),0,10);
			}
		}
	}

	/**
	 * ArticleWriting::redirecturl()
	 *
	 * @return void
	 **/
	public function redirecturl()
	{
		if($this->fields_arr['gpukey'])
		{
			Redirect2URL($_SESSION['gpukey'][$this->fields_arr['gpukey']]);
		}
	}


	/**
	 * ArticleWriting::checkArticleApprovalForEdit()
	 *
	 * @return void
	 **/
	public function checkAdminApprovalForEditArticle($article_id)
	{

		$admin_approval_article_status = array('Ok', 'InFuture');

		$sql = 'SELECT article_id, article_status'.
				' FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($article_id));

		if (!$rs)
			trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			{
				$this->fields_arr['article_status'] = $row['article_status'];
			}

		//Condition to set the article sttaus as to activate if admin auto activation is false and allow edit article to approve is true
		// and article status is ok or infuture
		if(!$this->CFG['admin']['articles']['auto_activate'] && $this->CFG['admin']['articles']['allow_edit_article_to_approve'])
		{
			if($this->fields_arr['draft_mode'] == 'No')
			{
				if((in_array($this->fields_arr['article_status'], $admin_approval_article_status)))
				{
					return true;
				}
			}
		}
		return false;
	}



	/**
	 * ArticleWriting::updateArticleTableForEdit()
	 *
	 * @param string $fields_arr
	 * @param string $err_tip
	 * @return void
	 */
	public function updateArticleTableForEdit($fields_arr, $err_tip='')
	{
			$articleStatus = '';
			//Condition to check whether the article to be updated should be appoved by admin or not
			if($this->checkAdminApprovalForEditArticle($this->fields_arr['article_id']))
			{
				$articleStatus = 'ToActivate';
				//$this->setFormField('draft_mode', 'No');
			}
			else
			{
				$draftStatus   = $this->fields_arr['draft_mode'];
				$publishDate   = $this->fields_arr['date_of_publish'];
				$articleStatus = 'ToActivate';
				$currentDate   = date("Y-m-d");

				if($draftStatus == 'Yes')
					$articleStatus = 'Draft';
				elseif($publishDate > $currentDate && $this->CFG['admin']['articles']['auto_activate'])
					$articleStatus = 'InFuture';
				else
					$articleStatus = ($this->CFG['admin']['articles']['auto_activate'])?'Ok':($this->CFG['admin']['is_logged_in'])?($publishDate > $currentDate ? 'ToActivate': 'Ok' ):'ToActivate'; //Condition modified not to activate article if publish date is fututre date for admin user
			}
			$this->setFormField('article_status',$articleStatus);

		$this->setCommonFormFields();

		$add = '';
		if(!$this->CFG['admin']['is_logged_in'])
			$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET ';
		$paramFields = array();
		foreach($fields_arr as $fieldname)
		{

			if($this->fields_arr[$fieldname]!='NOW()')
			{
				$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).',';
				$paramFields[] = $this->fields_arr[$fieldname];
			}
			else
				$sql .= $fieldname.'='.$this->fields_arr[$fieldname].', ';
		}
		$sql = substr($sql, 0, strrpos($sql, ','));
		$sql .= ' WHERE article_id='.$this->dbObj->Param('article_id').$add;
		$paramFields[] = $this->fields_arr['article_id'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $paramFields);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$this->ARTICLE_ID = $this->fields_arr['article_id'];
		if($articleStatus == 'Ok' && !$this->chkArticleExistInActivity($this->ARTICLE_ID)){
			$this->increaseTotalArticleCount($this->CFG['user']['user_id']);
			$this->addArticleUploadActivity($this->ARTICLE_ID);
			$this->sendMailToUserForActivate($this->ARTICLE_ID);
			if($this->fields_arr['relation_id'])
			{
				$this->shareArticleDetails($this->ARTICLE_ID);
			}
		}
	}


	/**
	 * ArticleWriting::fileUpload()
	 *
	 * @param Integer $article_id
	 * @return boolean
	 */
	public function fileUpload($article_id)
	{
		if($this->chkFileUploaded())
		{
			$file_name = $_FILES['article_file']['name'];
			$this->setFormField('file_type', $_FILES['article_file']['type']);
			$this->setFormField('file_size', $_FILES['article_file']['size']);
			$extern = strtolower(substr($_FILES['article_file']['name'], strrpos($_FILES['article_file']['name'], '.')+1));
			$this->setFormField('article_ext',$extern);
			$temp_dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['articles']['temp_folder'].'/';
			$this->chkAndCreateFolder($temp_dir);
			$temp_file = $temp_dir.'/'.$file_name;
			move_uploaded_file($_FILES['article_file']['tmp_name'],$temp_file);

			if($this->getServerDetails())
			{
				if($FtpObj = new FtpHandler($this->fields_arr['ftp_server'],$this->fields_arr['ftp_usrename'],$this->fields_arr['ftp_password']))
				{
					if($this->fields_arr['ftp_folder'])
						$FtpObj->changeDirectory($this->fields_arr['ftp_folder']);

					$dir = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$article_id.'/';

					$FtpObj->makeDirectory($dir);

					if(is_file($temp_file))
					{
						$FtpObj->moveTo($temp_file, $dir.$file_name);
						unlink($temp_file);
					}

					$this->setFormField('server_url',$this->fields_arr['server_url']);
					$this->updateArticleTable($article_id);
					return;
				}
			}
			$dir = $this->media_relative_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$article_id.'/';
			$this->chkAndCreateFolder($dir);
			$uploadUrl = $dir.$file_name;
			if(is_file($temp_file))
			{
				copy($temp_file, $uploadUrl);
				unlink($temp_file);
			}
			$server_url = $this->CFG['site']['url'];
			$this->setFormField('server_url',$server_url);
			$this->setFormField('file_name',$file_name);
			$this->updateArticleTable($article_id);
		}
	}

	/**
	 * ArticleWriting::addNewArticle()
	 *
	 * @return void
	 */
	public function addNewArticle()
	{
		$draftStatus   = $this->fields_arr['draft_mode'];
		$publishDate   = $this->fields_arr['date_of_publish'];
		$articleStatus = 'ToActivate';
		$currentDate   = date("Y-m-d");

		if($draftStatus == 'Yes')
			$articleStatus = 'Draft';
		elseif($publishDate > $currentDate && $this->CFG['admin']['articles']['auto_activate'])
			$articleStatus = 'InFuture';
		else
			$articleStatus = ($this->CFG['admin']['articles']['auto_activate'])?'Ok':($this->CFG['admin']['is_logged_in'])?($publishDate > $currentDate ? 'ToActivate': 'Ok' ):'ToActivate'; //Condition modified not to activate article if publish date is fututre date for admin user

		if($this->fields_arr['article_category_type']=='Porn')
		{
			$this->fields_arr['article_category_id'] = $this->fields_arr['article_category_id_porn'];
		}

		$this->setFormField('article_status',$articleStatus);
		$this->setFormField('user_id',$this->CFG['user']['user_id']);
		$this->setFormField('date_added','NOW()');

		/**
		 *
		 *  Get The article content image and save into article folder Start Here
		 *
		 **/
		$cont = $this->fields_arr['article_caption'];
		$search = $this->CFG['admin']['articles']['temp_article_image_folder'];
		$pattern = '/'.str_replace('/','\/',$search).'[0-9]{1,20}\/[0-9]{10,20}[.][a-zA-Z]{3,4}/';
		preg_match_all($pattern, $cont, $matches);
		$temp_image_file_arr=$matches[0];
		for($imag_count=0;$imag_count<count($temp_image_file_arr);$imag_count++)
		{
			$temp_image_file=$temp_image_file_arr[$imag_count];
			$temp_image_file=$this->media_relative_path.$temp_image_file;
			$avatarFilPath=$this->media_relative_path.$this->CFG['admin']['articles']['article_image_folder'].$this->CFG['user']['user_id'].'/';
			if(is_file($temp_image_file))
			{
				$avatarfile = basename($temp_image_file);
				$avatarFilPath = $avatarFilPath.$avatarfile;
				copy($temp_image_file, $avatarFilPath);
				unlink($temp_image_file);
			}
		}
		$replace = $this->CFG['admin']['articles']['article_image_folder'];
		/**** End Here ****/

		$this->setFormField('article_caption', str_replace($search, $replace, $this->fields_arr['article_caption']));
		$this->setCommonFormFields();
		$this->setFormField('article_caption', html_entity_decode($this->fields_arr['article_caption']));
		$this->setFormField('article_server_url', $this->CFG['site']['url']);
		$article_id = $this->ARTICLE_ID = $this->insertArticleTable(array('user_id','article_category_id','article_sub_category_id','article_title','article_summary','article_caption','article_tags','article_access_type','date_added','allow_comments','allow_ratings','relation_id', 'article_status','date_of_publish','draft_mode', 'article_server_url'));
		if($this->CFG['admin']['articles']['article_attachment'])
		{
			$this->fileUpload($article_id);
		}

		if($articleStatus == 'Ok'){
			$this->increaseTotalArticleCount($this->CFG['user']['user_id']);
			$this->addArticleUploadActivity($this->ARTICLE_ID);
			$this->sendMailToUserForActivate($this->ARTICLE_ID);
			if($this->fields_arr['relation_id'] && !$this->chkIsEditMode())
			{
				$this->shareArticleDetails($this->ARTICLE_ID);
			}
		}
	}

	/**
	 * ArticleWriting::chkNoOfFreeUploads()
	 *
	 * @return boolean
	 */
	public function chkNoOfFreeUploads()
	{
		$sql = 'SELECT count(article_id) as total_articles FROM '.$this->CFG['db']['tbl']['article'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' AND (article_status != \'Deleted\') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$total_article_uploaded = $row['total_articles'];
			$this->TOTAL_ARTICLE_UPLOADED =$total_article_uploaded;
		}
		if($this->CFG['admin']['articles']['no_of_free_uploads']!='')
		{
			if($this->CFG['admin']['articles']['no_of_free_uploads']=='0')
			{
				return false;
			}
			if($total_article_uploaded >= $this->CFG['admin']['articles']['no_of_free_uploads'])
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * ArticleWriting::populateArticleDetailsForEdit()
	 *
	 * @return boolean
	 */
	public function populateArticleDetailsForEdit()
	{
		$add = '';
		if(!$this->CFG['admin']['is_logged_in'])
			$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

		$sql = 'SELECT a.user_id, a.relation_id, a.article_id, a.article_title, a.article_summary, a.article_caption, a.article_tags, a.article_access_type,'.
				' a.article_category_id,a.allow_comments, a.allow_ratings, a.draft_mode, a.date_of_publish, a.article_status,'.
				' a.article_server_url, a.article_category_id, a.article_sub_category_id, c.article_category_type,'.
				' DATE_FORMAT(date_of_publish, \'%Y\') as publish_year, DATE_FORMAT(date_of_publish, \'%c\') as publish_month, DATE_FORMAT(date_of_publish, \'%e\') as publish_date,'.
				' DATE_FORMAT(date_of_publish, \'%e-%b-%Y\') as article_published_date'.
				' FROM '.$this->CFG['db']['tbl']['article'].' as a LEFT JOIN '.
				$this->CFG['db']['tbl']['article_category'].' as c ON a.article_category_id=c.article_category_id AND c.article_category_status=\'Yes\''.
				' WHERE a.article_status IN (\'Ok\', \'Draft\', \'ToActivate\', \'Not Approved\', \'InFuture\' )'.$add.
				' AND a.article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
		{
			$this->ARTICLE_CATEGORY_ID = $row['article_category_id'];
			$this->ARTICLE_SUB_CATEGORY_ID = $row['article_sub_category_id'];
			$this->fields_arr['article_id'] = $row['article_id'];
			$this->fields_arr['article_title'] = $row['article_title'];
			$this->fields_arr['article_summary'] = $row['article_summary'];
			$this->fields_arr['article_server_url'] = $row['article_server_url'];
			$this->fields_arr['article_caption'] = $row['article_caption'];
			$this->fields_arr['article_tags'] = $row['article_tags'];
			$this->fields_arr['article_access_type'] = $row['article_access_type'];
			$this->fields_arr['draft_mode'] = $row['draft_mode'];
			$this->fields_arr['article_status'] = $row['article_status'];
			$this->fields_arr['date_of_publish'] = $row['date_of_publish'];
			$this->fields_arr['article_published_date'] = $row['article_published_date'];

			if($row['relation_id'])
				$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);

			$this->fields_arr['article_category_id'] = $row['article_category_id'];
			$this->fields_arr['article_sub_category_id'] = $row['article_sub_category_id'];
			$this->fields_arr['allow_comments'] = $row['allow_comments'];
			$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
			$this->fields_arr['article_category_type'] = $row['article_category_type'];

			if($this->CFG['admin']['is_logged_in'])
				$this->CFG['user']['user_id'] = $row['user_id'];

			//Condiiton to allow user to edit articles if admin auto activation is set to true and allow admin user to edit
			//if($this->CFG['admin']['articles']['auto_activate'] || $this->CFG['admin']['is_logged_in'])

			return true;

		}
		return false;
	}

	/**
		 * ArticleWriting::getChannelOfThisArticle()
		 *
		 * @return array
		 **/
		public function getChannelOfThisArticle()
			{
				$getChannelOfThisArticle_arr = array();
				$sql = 'SELECT article_category_name, article_category_type FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id').
						' AND article_category_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_category_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$getChannelOfThisArticle_arr['article_category_name'] = $row['article_category_name'];
						$getChannelOfThisArticle_arr['article_category_type'] = $row['article_category_type'];
					}
				return $getChannelOfThisArticle_arr;
			}

	/**
	 * ArticleWriting::resetFieldsArray()
	 *
	 * @return void
	 */
	public function resetFieldsArray()
	{
		$this->setFormField('article_id', '');
		$this->setFormField('article_category_id', '');
		$this->setFormField('article_category_id_porn', '');
		$this->setFormField('article_category_type', '');
		$this->setFormField('article_sub_category_id', '');
		$this->setFormField('article_category_type', 'General');
		$this->setFormField('article_title', '');
		$this->setFormField('article_summary', '');
		$this->setFormField('article_caption', '');
		$this->setFormField('article_tags', '');
		$this->setFormField('gpukey', '');
		$this->setFormField('article_access_type', 'Public');
		$this->setFormField('allow_comments', 'Yes');
		$this->setFormField('allow_ratings', 'Yes');
		$this->setFormField('draft_mode', 'No');
		$this->setFormField('date_of_publish', date('Y-m-d'));
		$this->setFormField('article_status', '');
		$this->setFormField('article_published_date', '');
		$this->setFormField('relation_id',array());
		$this->setFormField('article_server_url', '');
	}

	/**
	 * ArticleWriting::validationFormFields1()
	 *
	 * @return void
	 */
	public function validationFormFields1()
	{
		if($this->fields_arr['article_category_type'] != 'General')
		{
			$this->ARTICLE_CATEGORY_ID = $this->fields_arr['article_category_id_porn'];
			$this->setFormField('article_category_id',$this->fields_arr['article_category_id_porn']);
		}
		else
		{
			$this->ARTICLE_CATEGORY_ID = $this->fields_arr['article_category_id'];
		}
		$this->chkIsNotEmpty('article_category_id', $this->LANG['common_err_tip_required']);
		$this->chkIsNotEmpty('article_title', $this->LANG['common_err_tip_required']);
		$this->chkIsNotEmpty('article_summary', $this->LANG['common_err_tip_required']);
		$this->chkIsNotEmpty('article_tags', $this->LANG['common_err_tip_required']) and
			$this->chkValidTagList('article_tags','article_tags',$this->LANG['common_err_tip_invalid_tag']);

	}

	/**
	 * ArticleWriting::chkIsEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsEditMode()
	{
		if($this->fields_arr['article_id'])
			return true;
		return false;
	}

	/**
	 * ArticleWriting::setCommonFormFields()
	 *
	 * @return boolean
	 */
	public function setCommonFormFields()
	{
		if($this->fields_arr['article_access_type']=='Private')
		{
			$relation_id = implode(',',$this->fields_arr['relation_id']);
			$this->setFormField('relation_id',$relation_id);
		}
		else
			$this->setFormField('relation_id','');
	}

	/**
	 * ArticleWriting::checkIsCorrectDate()
	 * Verifies the date value
	 *
	 * @param string $date date
	 * @param string $month month
	 * @param string $year year
	 * @param string $field form field for the date
	 * @param $err_tip error tip
	 * @return
	 **/
	public function checkIsCorrectDate($field='', $err_tip_invalid='')
		{
			$current_date   = date("Y-m-d");
			$publish_date = $this->fields_arr[$field];

			if (!empty($field))
			    {
					if($publish_date < $current_date)
					{
						$this->fields_err_tip_arr[$field] = $this->LANG['articlewriting_err_tip_invalid_date'];
						return false;
					}
				    return true;
			    }
			else
				{
					$this->fields_err_tip_arr[$field] = $err_tip_invalid;
					return false;
				}
		}

	/**
	 * ArticleWriting::changeTagTable()
	 *
	 * @return boolean
	 */
	public function changeTagTable()
	{
		$tag_arr = explode(' ', $this->fields_arr['article_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value)<$this->CFG['fieldsize']['tags']['min']) or (strlen($value)>$this->CFG['fieldsize']['tags']['max']))
				continue;

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_tags'].' SET result_count=result_count+1'.
					' WHERE tag_name=\''.addslashes($value).'\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if(!$this->dbObj->Affected_Rows())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_tags'].' SET'.
						' tag_name=\''.addslashes($value).'\', result_count=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}
		}
	}

	/**
	 * ArticleWriting::changeTagTableForEdit()
	 *
	 * @return void
	 */
	public function changeTagTableForEdit()
	{
		$tag_arr = explode(' ', $this->fields_arr['article_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value)<$this->CFG['admin']['tag_minimum_size']) or (strlen($value)>$this->CFG['admin']['tag_maximum_size']))
				continue;

			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['article_tags'].
					' WHERE tag_name=\''.addslashes($value).'\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if(!$rs->PO_RecordCount())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_tags'].' SET'.
						' tag_name=\''.addslashes($value).'\', result_count=1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}
		}
	}

	/**
	 * ArticleWriting::checkTinyMode()
	 *
	 * @return boolean
	 */
	public function checkTinyMode()
	{
		$sql  = 'SELECT article_status FROM '.$this->CFG['db']['tbl']['article'].' WHERE article_id = '.$this->dbObj->Param('article_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
		{
			if($row['article_status'] == 'Ok')
				return true;
		}
		return false;
	}
}
//<<<<<-------------- Class ArticleWriting begins ---------------//
//-------------------- Code begins -------------->>>>>//
$articlewriting = new ArticleWriting();
$articlewriting->article_writinged_success = true;

if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$articlewriting->setPageBlockNames(array('article_writing_form', 'block_articleupload_paidmembership_upgrade_form'));
$LANG['msg_success_writing'] = ($CFG['admin']['articles']['auto_activate'])?$LANG['articlewriting_msg_success_writing_auto']:$LANG['articlewriting_msg_success_writing_admin'];

//Set media path
$articlewriting->setMediaPath('../');
$articlewriting->resetFieldsArray();
//$articlewriting->setAllPageBlocksHide();
//$articlewriting->setPageBlockShow('article_writing_form');
$articlewriting->setMonthsListArr($LANG_LIST_ARR['months']);
$articlewriting->sanitizeFormInputs($_REQUEST);
$paidmembership_upgrade_form = 0;

$common_err_tip_invalid_tag_min = str_replace('VAR_MIN', $CFG['fieldsize']['tags']['min'],
													$LANG['common_err_tip_invalid_tag']);
$LANG['common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['tags']['max'],
													$common_err_tip_invalid_tag_min);

//Condition to check whether paid membership is turned on and restrict the user to allow no of free uploads
if($CFG['feature']['membership_payment'] && !isPaidMember())
{

	if($articlewriting->chkIsEditMode())
	{
		$articlewriting->setAllPageBlocksHide();
		$articlewriting->setPageBlockShow('article_writing_form');
	}
	elseif($articlewriting->chkNoOfFreeUploads())
	{
		$articlewriting->setAllPageBlocksHide();
		$articlewriting->setPageBlockShow('article_writing_form');
	}
	else
	{
		$articlewriting->setAllPageBlocksHide();
		$upgrade_link = '<a href='.$articlewriting->getUrl('upgrademembership').' alt='.$LANG['articlewriting_upgrade_membership_link'].' title='.$LANG['articlewriting_upgrade_membership_link'].'>'.$LANG['articlewriting_upgrade_membership_link'].'</a>';
		$LANG['articlewriting_upgrade_membership'] = str_replace('{value}', $CFG['admin']['articles']['no_of_free_uploads'],$LANG['articlewriting_upgrade_membership']);
		$articlewriting->articleupload_upgrade_membership = str_replace('{link}', $upgrade_link, $LANG['articlewriting_upgrade_membership']);
		$articlewriting->setPageBlockShow('block_articleupload_paidmembership_upgrade_form');
		$paidmembership_upgrade_form = 1;
	}
}
else
{
	$articlewriting->setAllPageBlocksHide();
	$articlewriting->setPageBlockShow('article_writing_form');
}

$articlewriting->article_writing_form['page_break_url'] = getUrl('pagebreak', '', '', 'members', 'article');
$articlewriting->article_writing_form['insert_image_url'] = getUrl('insertimage', '', '', 'members', 'article');

if(isAjaxPage())
{
	if($articlewriting->isFormPOSTed($_POST, 'article_category_id')) //Populate SubCategory
	{
		$articlewriting->includeAjaxHeaderSessionCheck();
		$articlewriting->populateArticleSubCategory($articlewriting->getFormField('article_category_id'));
		$articlewriting->includeAjaxFooter();
		exit;
	}
}

//Condition to check the user allow article permission and allow to upload/update article based on condition
if($articlewriting->chkThisUserAllowedToPostArticle())
	{
		if($articlewriting->isFormPOSTed($_POST, 'cancel'))
			{
				$articlewriting->redirecturl();
			}
		if($articlewriting->isFormPOSTed($_POST, 'submit') && $paidmembership_upgrade_form == 0)
			{
				if($CFG['admin']['articles']['article_attachment'])
					{
						if($articlewriting->chkFileNameIsNotEmpty('article_file', $LANG['common_err_tip_required']))
							{
								$articlewriting->chkValidFileType('article_file', $CFG['admin']['articles']['attachment_format_arr'], $LANG['articlewriting_err_tip_invalid_file_type']) and
								$articlewriting->chkValideFileSize('article_file',$LANG['articlewriting_err_tip_invalid_file_size']) and
								$articlewriting->chkErrorInFile('article_file',$LANG['articlewriting_err_tip_invalid_file']);
							}
					}

				$articlewriting->validationFormFields1();
				$articlewriting->chkIsNotEmpty('date_of_publish', $LANG['common_err_tip_required']);
				$articlewriting->chkIsValidDate('date_of_publish',$LANG['common_err_tip_date_invalid']);
				$articlewriting->checkIsCorrectDate('date_of_publish', $LANG['articlewriting_err_tip_publish_date_invalid']);
				if($articlewriting->isValidFormInputs())
					{
						$articlewriting->addNewArticle();
						if(!$CFG['admin']['tagcloud_based_search_count'])
							$articlewriting->changeTagTable();
						$articlewriting->resetFieldsArray();
						$articlewriting->setCommonSuccessMsg($LANG['msg_success_writing']);
						$articlewriting->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$articlewriting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$articlewriting->setPageBlockShow('block_msg_form_error');
					}
			}
		else if($articlewriting->isFormPOSTed($_POST, 'update') || $articlewriting->isFormPOSTed($_POST, 'updateConfirm') || $articlewriting->isFormPOSTed($_POST, 'confirmSubmit'))
			{
				$articlewriting->validationFormFields1();
				if(!$articlewriting->checkTinyMode())
				{
					$articlewriting->chkIsNotEmpty('date_of_publish', $LANG['common_err_tip_required']);
					$articlewriting->chkIsValidDate('date_of_publish',$LANG['common_err_tip_date_invalid']);
					$articlewriting->checkIsCorrectDate('date_of_publish', $LANG['articlewriting_err_tip_publish_date_invalid']);
				}

				if($articlewriting->isValidFormInputs())
					{
						$articlewriting->setFormField('article_caption', html_entity_decode($articlewriting->getFormField('article_caption')));
						$articlewriting->updateArticleTableForEdit(array('article_title', 'article_summary', 'article_caption','article_tags','article_access_type','article_category_id','article_sub_category_id','allow_comments', 'allow_ratings','relation_id', 'date_of_publish', 'draft_mode', 'article_status'));
						if(!$CFG['admin']['tagcloud_based_search_count'])
							$articlewriting->changeTagTableForEdit();
						$articlewriting->redirecturl();
						$articlewriting->setFormField('relation_id',explode(',',$articlewriting->getFormField('relation_id')));
						$articlewriting->setCommonSuccessMsg($LANG['articlewriting_msg_success_updated']);
						$articlewriting->setPageBlockShow('block_msg_form_success');
						$articlewriting->view_article_url= getUrl('viewarticle', '?article_id='.$articlewriting->getFormField('article_id').'&title='.$articlewriting->getFormField('article_title').'&msg=updated', $articlewriting->getFormField('article_id').'/'.$articlewriting->getFormField('article_title').'/?msg=updated', '', 'article');
						Redirect2URL($articlewriting->view_article_url);
					}
				else
					{
						$articlewriting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$articlewriting->setPageBlockShow('block_msg_form_error');
					}
			}
		else if($articlewriting->chkIsEditMode())
			{
				$articlewriting->article_writing_form['form_action'] = getUrl('articlewriting', '?article_id='.$articlewriting->getFormField('article_id'), $articlewriting->getFormField('article_id').'/', 'members', 'article');
				$articlewriting->article_writing_form['manage_attachments_url'] = getUrl('manageattachments', '?article_id='.$articlewriting->getFormField('article_id'), $articlewriting->getFormField('article_id').'/', 'members', 'article');
				if(!$articlewriting->populateArticleDetailsForEdit())
					{
						$articlewriting->setAllPageBlocksHide();
						$articlewriting->setCommonErrorMsg($LANG['articlewriting_msg_error_update_article_permission_denied']);
						$articlewriting->setPageBlockShow('block_msg_form_error');
					}
			}
		//$articlewriting->getReferrerUrls();
		if($articlewriting->isShowPageBlock('article_writing_form'))
			{
				$LANG['articlewriting_title'] = $LANG['articlewriting_title'];
			}
		else
			{
				$LANG['articlewriting_title'] = $LANG['articlewriting_title'].' '.$LANG['articlewriting_page2'];
			}
	}
else
	{
		$articlewriting->setAllPageBlocksHide();
		$articlewriting->setCommonErrorMsg($LANG['articlewriting_msg_error_permission_denied']);
		$articlewriting->setPageBlockShow('block_msg_form_error');
	}
//<<<<<-------------------- Code ends----------------------//
if ($articlewriting->isShowPageBlock('article_writing_form'))
	{
		$articlewriting->LANG['articlewriting_tags_msg'] = str_replace('{min}', $CFG['fieldsize']['tags']['min'], $articlewriting->LANG['articlewriting_tags_msg']);
		$articlewriting->LANG['articlewriting_tags_msg'] = str_replace('{max}', $CFG['fieldsize']['tags']['max'], $articlewriting->LANG['articlewriting_tags_msg']);
		$articlewriting->LANG['articlewriting_tags_errormsg'] = str_replace('{min}', $CFG['fieldsize']['tags']['min'], $LANG['common_err_tip_invalid_character_size']);
		$articlewriting->LANG['articlewriting_tags_errormsg'] = str_replace('{max}', $CFG['fieldsize']['tags']['max'], $articlewriting->LANG['articlewriting_tags_errormsg']);

		//$articlewriting->articleCategory_arr = $articlewriting->populateArticleCatagory();

		$articlewriting->content_filter = false;

		if($articlewriting->chkAllowedModule(array('content_filter')))
		{
			$articlewriting->content_filter = true;
			$articlewriting->Porn = $articlewriting->General = 'none';
			$article_category_type = $articlewriting->getFormField('article_category_type');
			$$article_category_type = '';
		}
		else
		{
			$articlewriting->Porn = $articlewriting->General = '';
		}
		if($articlewriting->getFormField('article_category_type') == 'General')
		{
			$articlewriting->General ='';
		}
		else
		{
			$articlewriting->Porn = '';
		}

		if($articlewriting->chkIsEditMode())
			{
				$articlewriting->article_writing_form['form_action'] = getUrl('articlewriting', '?article_id='.$articlewriting->getFormField('article_id'), $articlewriting->getFormField('article_id').'/', 'members', 'article');
				$articlewriting->article_writing_form['manage_attachments_url'] = getUrl('manageattachments', '?article_id='.$articlewriting->getFormField('article_id'), $articlewriting->getFormField('article_id').'/', 'members', 'article');
			}
		$articlewriting->hidden_arr = array('gpukey');
	}
setPageTitle($articlewriting->LANG['articlewriting_title']);
setMetaKeywords('Article Upload');
setMetaDescription('Article Upload');
/** --- Set the tinymce editor as Editable or viewable based on admin settings---- **/
$articlewriting->tinyReadMode = '0';

if($articlewriting->checkTinyMode() && $articlewriting->chkIsEditMode() && !$CFG['admin']['articles']['allow_edit_article_description'])
{
	$articlewriting->tinyReadMode = '1';
}
$smartyObj->assign('confirm_submit_onclick', 'if(getMultiCheckBoxValue(\'article_writing_form\', \'check_all\', \''.$LANG['articlewriting_article_editing_admin_approval'].'\')){Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'msgConfirmText\'), Array(\''.$LANG['articlewriting_article_editing_admin_approval'].'\'), Array(\'innerHTML\'));}');

$calendar_options_arr = array('minDate'=> -1,
							  'maxDate'=> '+100M +100D',
							  'yearRange'=> '-100:+20'
							 );
$smartyObj->assign('dob_calendar_opts_arr', $calendar_options_arr);

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$articlewriting->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['article_url']; ?>js/readmore.js"></script>
<script type="text/javascript">
function populateArticleSubCategory(cat)
{
	var url = '<?php echo $CFG['site']['article_url'].'articleWriting.php';?>';
	var pars = 'ajax_page=true&article_category_id='+cat;
	<?php if($articlewriting->getFormField('article_sub_category_id')){?>
		pars = pars+'&article_sub_category_id=<?php echo $articlewriting->getFormField('article_sub_category_id');?>';
	<?php }?>
	var method_type = 'post';
	populateSubCategoryRequest(url, pars, method_type);
}

<?php if($articlewriting->getFormField('article_category_id')){?>
	populateArticleSubCategory('<?php echo $articlewriting->getFormField('article_category_id'); ?>');
<?php }?>
</script>
<?php
//include the content of the page
setTemplateFolder('general/', 'article');
$smartyObj->display('articleWriting.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
//Added jquery validation for required fileds in article upload page
if ($articlewriting->isShowPageBlock('article_writing_form') and $CFG['feature']['jquery_validation'])
{
$allowed_file_formats = implode("|", $CFG['admin']['articles']['attachment_format_arr']);
?>
<script type="text/javascript">
var tag_min='<?php echo  $CFG['fieldsize']['article_tags']['min']; ?>';
var tag_max='<?php echo  $CFG['fieldsize']['article_tags']['max']; ?>';
$Jq("#article_writing_form").validate({
	rules: {
		article_title: {
			required: true
	    },
	    article_summary: {
			required: true,
			maxlength: <?php echo $CFG['admin']['articles']['summary_length']; ?>

	    },
	    <?php
		if($CFG['admin']['articles']['article_attachment_compulsory'])
		{
		?>
	    article_file: {
	    	required: true,
	    	isValidFileFormat: "<?php echo $allowed_file_formats; ?>"
	    },
		<?php
		}
		?>
	    article_tags: {
			required: true,
			chkValidTags: Array(tag_min, tag_max)
		},
		article_category_id: {
            required: "div#selGeneralCategory:visible"
		 },
		article_category_id_porn: {
            required: "div#selPornCategory:visible"
		 }
		<?php
		if(!$articlewriting->checkTinyMode())
		{
		?>
		,
		date_of_publish: {
	    	required: true,
	    	isValidDate: true,
	    	dateISO: true,
	    	isValidDateVal: true
	    }
	    <?php
	    }
	    ?>
	},
	messages: {
		article_title: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		article_summary: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			maxlength: jQuery.format("<?php echo $LANG['common_err_tip_max_characters'];?> {0}")
		},
		<?php
		if($CFG['admin']['articles']['article_attachment_compulsory'])
		{
		?>
	    article_file: {
	    	required: "<?php echo $LANG['common_err_tip_required'];?>",
	    	isValidFileFormat: "<?php echo $LANG['common_err_tip_invalid_file_type']; ?>"
	    },
		<?php
		}
		?>
		article_tags: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			chkValidTags: "<?php echo $LANG['common_err_tip_invalid_tag'];?>"
		},
		article_category_id: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		article_category_id_porn: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
		<?php
		if(!$articlewriting->checkTinyMode())
		{
		?>
		,
		date_of_publish: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
		    isValidDate: "<?php echo $LANG['common_err_tip_date_formate'];?>",
		    dateISO: "<?php echo $LANG['common_err_tip_date_invalid'];?>",
		    isValidDateVal: "<?php echo $LANG['common_err_tip_date_invalid'];?>"
		}
		<?php
		}
		?>

	}
});
</script>
<?php
}
$articlewriting->includeFooter();
?>