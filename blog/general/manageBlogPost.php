<?php
/**
 * File to allow the users to add/edit blog post
 *
 * Provides an interface to get blog post details such as
 * title, description, tags, category, sub category,
 * sharing, comment setting for the blog post, rating setting for
 * the blog post.
 */

/**
 * ManageBlogPost
 *
 *
 * @category	Rayzz
 * @package		General
 **/
class ManageBlogPost extends BlogHandler
{
	public $BLOG_ID				  = '';
	public $BLOG_POST_ID		  = '';
	public $BLOG_POST_NAME 		  = '';
	public $BLOG_CATEGORY_ID  	  = '';
	public $BLOG_USER_NAME 	  	  = '';
	public $BLOG_USER_EMAIL 	  = '';
	public $BLOG_USER_ID 	  	  = '';
	public $BLOG_RELATION_ID      = '';
	public $BLOG_DESCRIPTION      = '';

	/**
	 * ManageBlogPost::populateBlogCatagory()
	 *
	 * @param string $err_tip
	 * @return array
	 **/
	public function populateBlogCatagory($type = 'General', $err_tip='')
	{
		$sql = 'SELECT blog_category_id, blog_category_name FROM '.
				$this->CFG['db']['tbl']['blog_category'].
				' WHERE parent_category_id=0 AND blog_category_status=\'Yes\''.
				' AND blog_category_type='.$this->dbObj->Param('blog_category_type').
				' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($type));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return;

		$names = array('blog_category_name');
		$value = 'blog_category_id';
		$highlight_value = $this->fields_arr['blog_category_id'];

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
	 * ManageBlogPost::populateBlogSubCategory()
	 *
	 * @param string $err_tip
	 * @return string
	 **/
	public function populateBlogSubCategory()
	{
		if (!$this->fields_arr['blog_category_id'])
			return ;

		$sql = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
				' WHERE parent_category_id='.$this->dbObj->Param('blog_category_id').' AND blog_category_status=\'Yes\' ORDER BY blog_category_name';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_category_id']));
		if (!$rs)
			    trigger_db_error($this->dbObj);

		$names = array('blog_category_name');
		$value = 'blog_category_id';
		$highlight_value = $this->fields_arr['blog_sub_category_id'];
		?>
		<select name="blog_sub_category_id" id="blog_sub_category_id" tabindex="1060">
			<option value=""><?php echo $this->LANG['manageblogpost_select_sub_category'];?></option>
		<?php

		while($row = $rs->FetchRow())
		{
			$out = '';
			$selected = $highlight_value == $row[$value]?' selected="selected"':'';
			foreach($names as $name)
				$out .= $row[$name].' ';
		?>
			<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['blog_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
		<?php
		}
		?>
		</select>
		<?php
	}

	/**
	 * ManageBlogPost::insertBlogPostTable()
	 *
	 * @param array $fields_arr
	 * @param string $err_tip
	 * @return Integer
	 **/
	public function insertBlogPostTable($fields_arr, $err_tip='')
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_posts'].' SET ';
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
	 * ManageBlogPost::getReferrerUrl()
	 *
	 * @return void
	 **/
	public function getReferrerUrls()
	{
		if(!$this->fields_arr['gpukey'])
		{
			if(isset($_SERVER['HTTP_REFERER']) and !strstr($_SERVER['HTTP_REFERER'],'manageBlogPost'))
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
	 * ManageBlogPost::redirecturl()
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
	 * ManageBlogPost::checkAdminApprovalForEditBlogPost()
	 *
	 * @return void
	 **/
	public function checkAdminApprovalForEditBlogPost($blog_post_id)
	{

		$admin_approval_blog_post_status = array('Ok', 'InFuture');

		$sql = 'SELECT blog_post_id, status'.
				' FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_id));

		if (!$rs)
			trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			{
				$this->fields_arr['status'] = $row['status'];
			}

		//Condition to set the blo post sttaus as to activate if admin auto activation is false and allow edit blog post to approve is true
		// and blog post status is ok or infuture
		if(!$this->CFG['admin']['blog']['blog_post_auto_activate'] && $this->CFG['admin']['blog']['allow_edit_blog_post_to_approve'])
		{
			if($this->fields_arr['draft_mode'] == 'No')
			{
				if((in_array($this->fields_arr['status'], $admin_approval_blog_post_status)))
				{
					return true;
				}
			}
		}
		return false;
	}



	/**
	 * ManageBlogPost::updateBlogPostTableForEdit()
	 *
	 * @param string $fields_arr
	 * @param string $err_tip
	 * @return void
	 */
	public function updateBlogPostTableForEdit($fields_arr, $err_tip='')
	{
			$blogPostStatus = '';
			//Condition to check whether the blog post to be updated should be appoved by admin or not
			if($this->checkAdminApprovalForEditBlogPost($this->fields_arr['blog_post_id']))
			{
				$blogPostStatus = 'ToActivate';
			}
			else
			{
				$draftStatus   = $this->fields_arr['draft_mode'];
				$publishDate   = $this->fields_arr['date_of_publish'];
				$blogPostStatus = 'ToActivate';
				$currentDate   = date("Y-m-d");

				if($draftStatus == 'Yes')
					$blogPostStatus = 'Draft';
				elseif($publishDate > $currentDate && $this->CFG['admin']['blog']['blog_post_auto_activate'])
					$blogPostStatus = 'InFuture';
				else
					$blogPostStatus = ($this->CFG['admin']['blog']['blog_post_auto_activate'])?'Ok':($this->CFG['admin']['is_logged_in'])?'Ok':'ToActivate';
			}
			$this->setFormField('status',$blogPostStatus);

		$this->setCommonFormFields();

		$add = '';
		if(!$this->CFG['admin']['is_logged_in'])
			$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET ';
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
		$sql .= ' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').$add;
		$paramFields[] = $this->fields_arr['blog_post_id'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $paramFields);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$this->BLOG_POST_ID = $this->fields_arr['blog_post_id'];
		if($blogPostStatus == 'Ok' && !$this->chkPostExistInActivity($this->BLOG_POST_ID)){
			$this->increaseTotalBlogPostCount($this->CFG['user']['user_id']);
			$this->addBlogPostCreatedActivity($this->BLOG_POST_ID);
			$this->sendMailToUserForActivate($this->BLOG_POST_ID);
			if($this->fields_arr['relation_id'])
			{
				$this->shareBlogPostDetails($this->BLOG_POST_ID);
			}
		}
	}

	/**
	 * ManageBlogPost::addNewBlogPost()
	 *
	 * @return void
	 */
	public function addNewBlogPost()
	{
		$draftStatus   = $this->fields_arr['draft_mode'];
		$publishDate   = $this->fields_arr['date_of_publish'];
		$blogPostStatus = 'ToActivate';
		$currentDate   = date("Y-m-d");

		if($draftStatus == 'Yes')
			$blogPostStatus = 'Draft';
		elseif($publishDate > $currentDate && $this->CFG['admin']['blog']['blog_post_auto_activate'])
			$blogPostStatus = 'InFuture';
		else
			//$blogPostStatus = ($this->CFG['admin']['blog']['blog_post_auto_activate'])?'Ok':($this->CFG['admin']['is_logged_in'])?'Ok':'ToActivate';
			$blogPostStatus = ($this->CFG['admin']['blog']['blog_post_auto_activate'])?'Ok':($this->CFG['admin']['is_logged_in'])?($publishDate > $currentDate ? 'ToActivate': 'Ok' ):'ToActivate'; //Condition modified not to activate post if publish date is fututre date for admin user


		if($this->fields_arr['blog_category_type']=='Porn')
		{
			$this->fields_arr['blog_category_id'] = $this->fields_arr['blog_category_id_porn'];
		}

		$this->setFormField('status',$blogPostStatus);
		$this->setFormField('user_id',$this->CFG['user']['user_id']);
		$this->setFormField('date_added','NOW()');

		/**
		 *
		 *  Get The blog content image and save into blog folder Start Here
		 *
		 **/
		$cont = $this->fields_arr['message'];
		$search = $this->CFG['admin']['blog']['temp_blog_post_image_folder'];
		$pattern = '/'.str_replace('/','\/',$search).'[0-9]{1,20}\/[0-9]{10,20}[.][a-zA-Z]{3}/';
		preg_match_all($pattern, $cont, $matches);
		$temp_image_file_arr=$matches[0];
		for($imag_count=0;$imag_count<count($temp_image_file_arr);$imag_count++)
		{
			$temp_image_file=$temp_image_file_arr[$imag_count];
			$temp_image_file=$this->media_relative_path.$temp_image_file;
			$avatarFilPath=$this->media_relative_path.$this->CFG['admin']['blog']['blog_post_image_folder'].$this->CFG['user']['user_id'].'/';
			if(is_file($temp_image_file))
			{
				$avatarfile = basename($temp_image_file);
				$avatarFilPath = $avatarFilPath.$avatarfile;
				copy($temp_image_file, $avatarFilPath);
				unlink($temp_image_file);
			}
		}
		$replace = $this->CFG['admin']['blog']['blog_post_image_folder'];
		/**** End Here ****/

		$this->setFormField('message', str_replace($search, $replace, $this->fields_arr['message']));
		$this->setCommonFormFields();
		$this->setFormField('message', html_entity_decode($this->fields_arr['message']));
		$blog_post_id = $this->BLOG_POST_ID = $this->insertBlogPostTable(array('blog_id','user_id','blog_category_id','blog_sub_category_id','blog_post_name','message','blog_tags','blog_access_type','date_added','allow_comments','allow_ratings','relation_id', 'status','date_of_publish','draft_mode'));
		if($blogPostStatus == 'Ok'){
			$this->increaseTotalBlogPostCount($this->CFG['user']['user_id']);
			$this->addBlogPostCreatedActivity($this->BLOG_POST_ID);
			$this->sendMailToUserForActivate($this->BLOG_POST_ID);
			if($this->fields_arr['relation_id'] && !$this->chkIsEditMode())
			{
				$this->shareBlogPostDetails($this->BLOG_POST_ID);
			}
		}
	}

	/**
	 * ManageBlogPost::chkNoOfFreeUploads()
	 *
	 * @return boolean
	 */
	public function chkNoOfFreeUploads()
	{
		$sql = 'SELECT count(blog_post_id) as total_posts FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' AND (status != \'Deleted\') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$total_post_added = $row['total_posts'];
			$this->TOTAL_POST_ADDED =$total_post_added;
		}
		if($this->CFG['admin']['blog']['no_of_free_blog_posting']!='')
		{
			if($this->CFG['admin']['blog']['no_of_free_blog_posting']=='0')
			{
				return false;
			}
			if($total_post_added >= $this->CFG['admin']['blog']['no_of_free_blog_posting'])
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * ManageBlogPost::populateBlogPostDetailsForEdit()
	 *
	 * @return boolean
	 */
	public function populateBlogPostDetailsForEdit()
	{
		$add = '';
		if(!$this->CFG['admin']['is_logged_in'])
			$add =' AND user_id=\''.$this->CFG['user']['user_id'].'\'';

		$sql = 'SELECT b.user_id, b.relation_id, b.blog_post_id, b.blog_post_name, b.message, b.blog_tags, b.blog_access_type,'.
				' b.blog_category_id,b.allow_comments, b.allow_ratings, b.draft_mode, b.date_of_publish, b.status,'.
				' b.blog_category_id, b.blog_sub_category_id, bc.blog_category_type,'.
				' DATE_FORMAT(date_of_publish, \'%Y\') as publish_year, DATE_FORMAT(date_of_publish, \'%c\') as publish_month, DATE_FORMAT(date_of_publish, \'%e\') as publish_date,'.
				' DATE_FORMAT(date_of_publish, \'%e-%b-%Y\') as blog_published_date'.
				' FROM '.$this->CFG['db']['tbl']['blog_posts'].' as b LEFT JOIN '.
				$this->CFG['db']['tbl']['blog_category'].' as bc ON b.blog_category_id=bc.blog_category_id AND bc.blog_category_status=\'Yes\''.
				' WHERE b.status IN (\'Ok\', \'Draft\', \'ToActivate\', \'Not Approved\', \'InFuture\' )'.$add.
				' AND b.blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
		{
			$this->BLOG_CATEGORY_ID = $row['blog_category_id'];
			$this->BLOG_SUB_CATEGORY_ID = $row['blog_sub_category_id'];
			$this->fields_arr['blog_post_id'] = $row['blog_post_id'];
			$this->fields_arr['blog_post_name'] = $row['blog_post_name'];
			$this->fields_arr['message'] = $row['message'];
			$this->fields_arr['blog_tags'] = $row['blog_tags'];
			$this->fields_arr['blog_access_type'] = $row['blog_access_type'];
			$this->fields_arr['draft_mode'] = $row['draft_mode'];
			$this->fields_arr['status'] = $row['status'];
			$this->fields_arr['date_of_publish'] = $row['date_of_publish'];
			$this->fields_arr['blog_published_date'] = $row['blog_published_date'];

			if($row['relation_id'])
				$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);

			$this->fields_arr['blog_category_id'] = $row['blog_category_id'];
			$this->fields_arr['blog_sub_category_id'] = $row['blog_sub_category_id'];
			$this->fields_arr['allow_comments'] = $row['allow_comments'];
			$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
			$this->fields_arr['blog_category_type'] = $row['blog_category_type'];

			if(!$this->checkTinyMode())
			{
				$this->fields_arr['publish_date'] = $row['publish_date'];
				$this->fields_arr['publish_month'] = $row['publish_month'];
				$this->fields_arr['publish_year'] = $row['publish_year'];
				$this->populatePublishDate=$this->populateDateYearValue(1, 31, $this->fields_arr['publish_date']);
				$this->populatePublishYear=$this->populateDateYearValue(2010, date("Y")+10, $this->fields_arr['publish_year']);
			}


			if($this->CFG['admin']['is_logged_in'])
				$this->CFG['user']['user_id'] = $row['user_id'];

			return true;

		}
		return false;
	}

	/**
	 * ManageBlogPost::resetFieldsArray()
	 *
	 * @return void
	 */
	public function resetFieldsArray()
	{
		$this->setFormField('blog_id', $this->BLOG_ID);
		$this->setFormField('blog_post_id', '');
		$this->setFormField('blog_category_id', '');
		$this->setFormField('blog_category_id_porn', '');
		$this->setFormField('blog_category_type', '');
		$this->setFormField('blog_sub_category_id', '');
		$this->setFormField('blog_category_type', 'General');
		$this->setFormField('blog_post_name', '');
		$this->setFormField('message', '');
		$this->setFormField('blog_tags', '');
		$this->setFormField('gpukey', '');
		$this->setFormField('blog_access_type', 'Public');
		$this->setFormField('allow_comments', 'Yes');
		$this->setFormField('allow_ratings', 'Yes');
		$this->setFormField('draft_mode', 'No');
		$this->setFormField('date_of_publish', '');
		$this->setFormField('status', '');
		$this->setFormField('dob', '');
		$this->setFormField('publish_date', date('j'));
		$this->setFormField('publish_month', date('n'));
		$this->setFormField('publish_year', date('Y'));
		$this->setFormField('blog_published_date', '');
		$this->setFormField('relation_id',array());
	}

	/**
	 * ManageBlogPost::validationFormFields1()
	 *
	 * @return void
	 */
	public function validationFormFields1()
	{
		if($this->fields_arr['blog_category_type'] != 'General')
		{
			$this->BLOG_CATEGORY_ID = $this->fields_arr['blog_category_id_porn'];
			$this->setFormField('blog_category_id',$this->fields_arr['blog_category_id_porn']);
		}
		else
		{
			$this->BLOG_CATEGORY_ID = $this->fields_arr['blog_category_id'];
		}
		$this->chkIsNotEmpty('blog_category_id', $this->LANG['common_err_tip_required']);
		$this->chkIsNotEmpty('blog_post_name', $this->LANG['common_err_tip_required']);
		$this->chkIsNotEmpty('blog_tags', $this->LANG['common_err_tip_required']) and
			$this->chkValidTagList('blog_tags','blog_tags',$this->LANG['common_err_tip_invalid_tag']);

	}

	/**
	 * ManageBlogPost::chkIsEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsEditMode()
	{
		if($this->fields_arr['blog_post_id'])
			return true;
		return false;
	}

	/**
	 * ManageBlogPost::setCommonFormFields()
	 *
	 * @return boolean
	 */
	public function setCommonFormFields()
	{
		if($this->fields_arr['blog_access_type']=='Private')
		{
			$relation_id = implode(',',$this->fields_arr['relation_id']);
			$this->setFormField('relation_id',$relation_id);
		}
		else
			$this->setFormField('relation_id','');
	}

	/**
	 * Verifies the date value
	 *
	 * @param string $date date
	 * @param string $month month
	 * @param string $year year
	 * @param string $field form field for the date
	 * @param $err_tip error tip
	 * @return
	 **/
	public function chkIsCorrectDate($date=0, $month=0, $year=0, $field='', $err_tip_empty='', $err_tip_invalid='')
		{

			$check_date_fields=explode('-',$this->fields_arr[$field]);
			$year=$check_date_fields[0];
			$month=$check_date_fields[1];
			$date=$check_date_fields[2];
			if (empty($date) or empty($month) or empty($year))
			    {
					$this->fields_err_tip_arr[$field] = $err_tip_empty;
					return false;
			    }
			if (checkdate(intval($month), intval($date), intval($year)))
			    {
			    	$current_date   = date("Y-m-d");
					//$publish_date  = $year.'-'.$month.'-'.$date;
					$publish_date = strftime("%Y-%m-%d", strtotime($year.'-'.$month.'-'.$date));


					if($publish_date < $current_date)
					{
						$this->fields_err_tip_arr[$field] = $this->LANG['manageblogpost_err_tip_invalid_date'];
						return false;
					}

					$this->fields_arr[$field] = $publish_date;
				    return true;
			    }
			else
				{
					$this->fields_err_tip_arr[$field] = $err_tip_invalid;
					return false;
				}
		}

	/**
	 * ManageBlogPost::changeTagTable()
	 *
	 * @return boolean
	 */
	public function changeTagTable()
	{
		$tag_arr = explode(' ', $this->fields_arr['blog_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value)<$this->CFG['fieldsize']['tags']['min']) or (strlen($value)>$this->CFG['fieldsize']['tags']['max']))
				continue;

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_tags'].' SET result_count=result_count+1'.
					' WHERE tag_name=\''.addslashes($value).'\' AND blog_id='.$this->fields_arr['blog_id'];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if(!$this->dbObj->Affected_Rows())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].' SET'.
						' tag_name=\''.addslashes($value).'\', result_count=1,blog_id='.$this->fields_arr['blog_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					   trigger_db_error($this->dbObj);
			}
		}
	}

	/**
	 * ManageBlogPost::changeTagTableForEdit()
	 *
	 * @return void
	 */
	public function changeTagTableForEdit()
	{
		$tag_arr = explode(' ', $this->fields_arr['blog_tags']);
		$tag_arr = array_unique($tag_arr);
		if($key = array_search('', $tag_arr))
			unset($tag_arr[$key]);

		foreach($tag_arr as $key=>$value)
		{
			if((strlen($value)<$this->CFG['admin']['tag_minimum_size']) or (strlen($value)>$this->CFG['admin']['tag_maximum_size']))
				continue;

			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['blog_tags'].
					' WHERE tag_name=\''.addslashes($value).'\' AND blog_id='.$this->fields_arr['blog_id'];
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if(!$rs->PO_RecordCount())
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_tags'].' SET'.
						' tag_name=\''.addslashes($value).'\', result_count=1, blog_id='.$this->fields_arr['blog_id'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}
		}
	}

	/**
	 * ManageBlogPost::checkTinyMode()
	 *
	 * @return boolean
	 */
	public function checkTinyMode()
	{
		$sql  = 'SELECT status FROM '.$this->CFG['db']['tbl']['blog_posts'].' WHERE blog_post_id = '.$this->dbObj->Param('blog_post_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
		{
			if($row['status'] == 'Ok')
				return true;
		}
		return false;
	}
}
//<<<<<-------------- Class ManageBlogPost begins ---------------//
//-------------------- Code begins -------------->>>>>//
$manageblogpost = new ManageBlogPost();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$manageblogpost->setPageBlockNames(array('blog_post_form', 'block_blogposting_paidmembership_upgrade_form','block_not_allowed_to_post'));
if(isAdmin())
$LANG['msg_success_writing'] =$LANG['manageblogpost_admin_msg_success_updated'];
else
$LANG['msg_success_writing'] = ($CFG['admin']['blog']['blog_post_auto_activate'])?$LANG['manageblogpost_msg_success_posting_auto']:$LANG['manageblogpost_msg_success_posting_admin'];

//Set media path
$manageblogpost->setMediaPath('../');
if(!isMember())
{
	Redirect2URL($manageblogpost->getUrl('login','',''));
}
$blog_created=$manageblogpost->chkThisUserAllowedToPost();


$manageblogpost->resetFieldsArray();
$manageblogpost->setMonthsListArr($LANG_LIST_ARR['months']);
$manageblogpost->sanitizeFormInputs($_REQUEST);
$manageblogpost->populatePublishDate=$manageblogpost->populateDateYearValue(1, 31, $manageblogpost->getFormField('publish_date'));
$manageblogpost->populatePublishYear=$manageblogpost->populateDateYearValue(date("Y"), date("Y")+10, $manageblogpost->getFormField('publish_year'));

$paidmembership_upgrade_form = 0;
$calendar_options_arr = array('minDate'=> -1,
							  'maxDate'=> '+100M +100D',
							  'yearRange'=> '-100:+20'
							 );
$smartyObj->assign('dob_calendar_opts_arr', $calendar_options_arr);
//Condition to check whether paid membership is turned on and restrict the user to allow no of free uploads
if($CFG['feature']['membership_payment'] && !isPaidMember() && $blog_created)
{

	if($manageblogpost->chkIsEditMode())
	{
		$manageblogpost->setAllPageBlocksHide();
		$manageblogpost->setPageBlockShow('blog_post_form');
	}
	elseif($manageblogpost->chkNoOfFreeUploads())
	{
		$manageblogpost->setAllPageBlocksHide();
		$manageblogpost->setPageBlockShow('blog_post_form');
	}
	else if($blog_created=='')
	{
		$manageblogpost->setAllPageBlocksHide();
		$create_blog_link  = '<a href='.$manageblogpost->getUrl('manageblog','','','','blog').' alt='.$LANG['manageblogpost_create_blog_link'].' title='.$LANG['manageblogpost_create_blog_link'].'>'.$LANG['manageblogpost_click_here_link'].'</a>';
		$manageblogpost->setPageBlockShow('block_msg_form_error');
		$LANG['manageblogpost_msg_error_blog_not_created'] = str_replace('{link}', $create_blog_link, $LANG['manageblogpost_msg_error_blog_not_created']);
		$manageblogpost->setCommonErrorMsg($LANG['manageblogpost_msg_error_blog_not_created']);
	}
	else
	{
		$manageblogpost->setAllPageBlocksHide();
		$upgrade_link = '<a href='.$manageblogpost->getUrl('upgrademembership').' alt='.$LANG['manageblogpost_upgrade_membership_link'].' title='.$LANG['manageblogpost_upgrade_membership_link'].'>'.$LANG['manageblogpost_upgrade_membership_link'].'</a>';
		$LANG['manageblogpost_upgrade_membership'] = str_replace('{value}', $CFG['admin']['blog']['no_of_free_blog_posting'],$LANG['manageblogpost_upgrade_membership']);
		$manageblogpost->blogposting_upgrade_membership = str_replace('{link}', $upgrade_link, $LANG['manageblogpost_upgrade_membership']);
		$manageblogpost->setPageBlockShow('block_blogposting_paidmembership_upgrade_form');
		$paidmembership_upgrade_form = 1;
	}
}
else if($blog_created)
{
	$manageblogpost->setAllPageBlocksHide();
	$manageblogpost->setPageBlockShow('blog_post_form');
}
else
{
	$manageblogpost->setAllPageBlocksHide();
	$create_blog_link  = '<a href='.$manageblogpost->getUrl('manageblog','','','','blog').' alt='.$LANG['manageblogpost_create_blog_link'].' title='.$LANG['manageblogpost_create_blog_link'].'>'.$LANG['manageblogpost_click_here_link'].'</a>';
	$manageblogpost->setPageBlockShow('block_msg_form_error');
	$LANG['manageblogpost_msg_error_blog_not_created'] = str_replace('{link}', $create_blog_link, $LANG['manageblogpost_msg_error_blog_not_created']);
	$manageblogpost->setCommonErrorMsg($LANG['manageblogpost_msg_error_blog_not_created']);
}

if(isAjaxPage())
{
	if($manageblogpost->isFormPOSTed($_POST, 'blog_category_id')) //Populate SubCategory
	{
		$manageblogpost->includeAjaxHeaderSessionCheck();
		$manageblogpost->populateBlogSubCategory($manageblogpost->getFormField('blog_category_id'));
		$manageblogpost->includeAjaxFooter();
		exit;
	}
}

if($manageblogpost->isFormPOSTed($_POST, 'cancel'))
	{
		$manageblogpost->redirecturl();
	}
if($manageblogpost->isFormPOSTed($_POST, 'submit') && $paidmembership_upgrade_form == 0)
	{
		$manageblogpost->validationFormFields1();
		$manageblogpost->chkIsNotEmpty('date_of_publish', '') ;
		$manageblogpost->chkIsCorrectDate($manageblogpost->getFormField('publish_date'), $manageblogpost->getFormField('publish_month'), $manageblogpost->getFormField('publish_year'), 'date_of_publish', $manageblogpost->LANG['manageblogpost_err_tip_publish_date_empty'], $manageblogpost->LANG['manageblogpost_err_tip_publish_date_invalid']);
		if($manageblogpost->isValidFormInputs())
			{
				$manageblogpost->addNewBlogPost();
				if(!$CFG['admin']['tagcloud_based_search_count'])
					$manageblogpost->changeTagTable();
				$manageblogpost->resetFieldsArray();
				$manageblogpost->setCommonSuccessMsg($LANG['msg_success_writing']);
				$manageblogpost->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$manageblogpost->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$manageblogpost->setPageBlockShow('block_msg_form_error');
			}
	}
else if($manageblogpost->isFormPOSTed($_POST, 'update') || $manageblogpost->isFormPOSTed($_POST, 'confirm') || $manageblogpost->isFormPOSTed($_POST, 'confirmSubmit'))
	{

		$manageblogpost->validationFormFields1();
		if(!$manageblogpost->checkTinyMode())
		{
			$manageblogpost->chkIsNotEmpty('date_of_publish', '') ;
			$manageblogpost->chkIsCorrectDate($manageblogpost->getFormField('publish_date'), $manageblogpost->getFormField('publish_month'), $manageblogpost->getFormField('publish_year'), 'date_of_publish', $manageblogpost->LANG['manageblogpost_err_tip_publish_date_empty'], $manageblogpost->LANG['manageblogpost_err_tip_publish_date_invalid']);
		}

		if($manageblogpost->isValidFormInputs())
			{
				$manageblogpost->setFormField('message', html_entity_decode($manageblogpost->getFormField('message')));
				$manageblogpost->updateBlogPostTableForEdit(array('blog_post_name','message','blog_tags','blog_access_type','blog_category_id','blog_sub_category_id','allow_comments', 'allow_ratings','relation_id', 'date_of_publish', 'draft_mode', 'status'));
				if(!$CFG['admin']['tagcloud_based_search_count'])
					$manageblogpost->changeTagTableForEdit();
				$manageblogpost->redirecturl();
				$manageblogpost->setFormField('relation_id',explode(',',$manageblogpost->getFormField('relation_id')));
				$manageblogpost->setCommonSuccessMsg($LANG['manageblogpost_msg_success_updated']);
				$manageblogpost->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$manageblogpost->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$manageblogpost->setPageBlockShow('block_msg_form_error');
			}
	}
else if($manageblogpost->chkIsEditMode())
	{
		$manageblogpost->blog_post_form['form_action'] = getUrl('manageblogpost', '?blog_post_id='.$manageblogpost->getFormField('blog_post_id'), $manageblogpost->getFormField('blog_post_id').'/', 'members', 'blog');
		if(!$manageblogpost->populateBlogPostDetailsForEdit())
			{
				$manageblogpost->setAllPageBlocksHide();
				$manageblogpost->setCommonErrorMsg($LANG['manageblogpost_msg_error_update_blog_permission_denied']);
				$manageblogpost->setPageBlockShow('block_msg_form_error');
			}
	}
$manageblogpost->getReferrerUrls();
if($manageblogpost->isShowPageBlock('blog_post_form'))
	{
		$LANG['manageblogpost_title'] = $LANG['manageblogpost_title'];
	}
else
	{
		$LANG['manageblogpost_title'] = $LANG['manageblogpost_title'].' '.$LANG['manageblogpost_page2'];
	}


//<<<<<-------------------- Code ends----------------------//
if ($manageblogpost->isShowPageBlock('blog_post_form'))
	{
		$manageblogpost->LANG['manageblogpost_tags_msg'] = str_replace('{min}', $CFG['fieldsize']['tags']['min'], $manageblogpost->LANG['manageblogpost_tags_msg']);
		$manageblogpost->LANG['manageblogpost_tags_msg'] = str_replace('{max}', $CFG['fieldsize']['tags']['max'], $manageblogpost->LANG['manageblogpost_tags_msg']);
		$manageblogpost->LANG['manageblogpost_tags_errormsg'] = str_replace('{min}', $CFG['fieldsize']['tags']['min'], $LANG['common_err_tip_invalid_character_size']);
		$manageblogpost->LANG['manageblogpost_tags_errormsg'] = str_replace('{max}', $CFG['fieldsize']['tags']['max'], $manageblogpost->LANG['manageblogpost_tags_errormsg']);

		$manageblogpost->content_filter = false;

		if($manageblogpost->chkAllowedModule(array('content_filter')))
		{
			$manageblogpost->content_filter = true;
			$manageblogpost->Porn = $manageblogpost->General = 'none';
			$blog_category_type = $manageblogpost->getFormField('blog_category_type');
			$$blog_category_type = '';
		}
		else
		{
			$manageblogpost->Porn = $manageblogpost->General = '';
		}
		if($manageblogpost->getFormField('blog_category_type') == 'General')
		{
			$manageblogpost->General ='';
		}
		else
		{
			$manageblogpost->Porn = '';
		}

		if($manageblogpost->chkIsEditMode())
			{
				$manageblogpost->blog_post_form['form_action'] = getUrl('manageblogpost', '?blog_post_id='.$manageblogpost->getFormField('blog_post_id'), $manageblogpost->getFormField('blog_post_id').'/', 'members', 'blog');
			}
		$manageblogpost->hidden_arr = array('gpukey');
	}
setPageTitle($manageblogpost->LANG['manageblogpost_title']);
setMetaKeywords('Blog Upload');
setMetaDescription('Blog Upload');
/** --- Set the tinymce editor as Editable or viewable based on admin settings---- **/
$manageblogpost->tinyReadMode = '0';

if($manageblogpost->checkTinyMode() && $manageblogpost->chkIsEditMode() && !$CFG['admin']['blog']['allow_edit_blog_post_description'])
{
	$manageblogpost->tinyReadMode = '1';
}
$smartyObj->assign('confirm_submit_onclick', 'if(getMultiCheckBoxValue(\'blog_post_form\', \'check_all\', \''.$LANG['manageblogpost_blog_editing_admin_approval'].'\')){Confirmation(\'selMsgConfirm\', \'msgConfirmform\', Array(\'msgConfirmText\'), Array(\''.$LANG['manageblogpost_blog_editing_admin_approval'].'\'), Array(\'innerHTML\'));}');

//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$manageblogpost->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
var common_err_tip_date_formate='<?php echo $manageblogpost->LANG['common_err_tip_date_formate'];?>';
var tag_min='<?php echo $CFG['fieldsize']['tags']['min']; ?>';
var tag_max='<?php echo $CFG['fieldsize']['tags']['max']; ?>';
function populateBlogPostSubCategory(cat)
{
	var url = '<?php echo $CFG['site']['blog_url'].'members/manageBlogPost.php';?>';
	var pars = 'ajax_page=true&amp;blog_category_id='+cat;
	<?php if($manageblogpost->getFormField('blog_sub_category_id')){?>
		pars = pars+'&blog_sub_category_id=<?php echo $manageblogpost->getFormField('blog_sub_category_id');?>';
	<?php }?>
	var method_type = 'post';
	populateSubCategoryRequest(url, pars, method_type);
}

<?php if($manageblogpost->getFormField('blog_category_id')){?>
	populateBlogPostSubCategory('<?php echo $manageblogpost->getFormField('blog_category_id'); ?>');
<?php }?>
</script>

<?php
//include the content of the page
setTemplateFolder('general/', 'blog');
$smartyObj->display('manageBlogPost.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$manageblogpost->includeFooter();
?>