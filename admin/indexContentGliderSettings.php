<?php
/**
 * Admin to manage index page content glider settings
 *
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Admin###
 * @author 		naveenkumar_126at09
 * @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version
 * @since 		2010-07-06
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/indexContentGliderSettings.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
if(isset($_POST['search_submit']) || isset($_POST['seachKeyword']) || (isset($_GET['act']) && $_GET['act']=='search'))
{
	$CFG['html']['header'] = 'admin/html_header_no_header.php';
	$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
}
else
{
	$CFG['html']['header'] = 'admin/html_header.php';
	$CFG['html']['footer'] = 'admin/html_footer.php';
}
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class EditTemplateSettings begins -------------------->>>>>//
/**
 * This class is handling the index content gldier settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class indexFeaturedGliderContent extends ListRecordsHandler
{

	public $indexFeaturedGliderId;

	/**
	 * indexFeaturedGliderContent::insertMediaFeaturedContent()
	 * To add/update media featured content for index page
	 *
	 * @param null
	 * @return boolean
	 */
	 public function insertMediaFeaturedContent()
	 	{
	 		if ($this->fields_arr['glider_id'])
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' SET '.
						'media_type = '.$this->dbObj->Param('media_type').', '.
						'media_id = '.$this->dbObj->Param('media_id').', '.
						'glider_title = '.$this->dbObj->Param('glider_title').', '.
						'rollover_text = '.$this->dbObj->Param('rollover_text').', '.
						'sidebar_content = '.$this->dbObj->Param('sidebar_content').', '.
						'is_use_default = '.$this->dbObj->Param('default_content').', '.
						'custom_image_target_url = '.$this->dbObj->Param('custom_image_url').' '.
						'WHERE index_glider_id = '.$this->dbObj->Param('glider_id');

				$fields_value_arr = array($this->fields_arr['media_type'],
											$this->fields_arr['media_id'],
											$this->fields_arr['glider_title'],
											$this->fields_arr['rollover_text'],
											$this->fields_arr['sidebar_content'],
											$this->fields_arr['media_default_content'],
											$this->fields_arr['custom_image_url'],
											$this->fields_arr['glider_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
			        trigger_db_error($this->dbObj);

			    $this->indexFeaturedGliderId = $this->fields_arr['glider_id'];
				return true;
			}
			else
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' SET '.
						'media_type = '.$this->dbObj->Param('media_type').', '.
						'media_id = '.$this->dbObj->Param('media_id').', '.
						'glider_title = '.$this->dbObj->Param('glider_title').', '.
						'rollover_text = '.$this->dbObj->Param('rollover_text').', '.
						'sidebar_content = '.$this->dbObj->Param('sidebar_content').', '.
						'is_use_default = '.$this->dbObj->Param('default_content').', '.
						'custom_image_target_url = '.$this->dbObj->Param('custom_image_url').', '.
						'date_added = now()';

				$fields_value_arr = array($this->fields_arr['media_type'],
											$this->fields_arr['media_id'],
											$this->fields_arr['glider_title'],
											$this->fields_arr['rollover_text'],
											$this->fields_arr['sidebar_content'],
											$this->fields_arr['media_default_content'],
											$this->fields_arr['custom_image_url']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
			        trigger_db_error($this->dbObj);

			    $this->indexFeaturedGliderId = $this->dbObj->Insert_ID();
				return true;
			}
		}

	 /**
   	  * indexFeaturedGliderContent::setIHObject()
   	  *
   	  * @param mixed $imObj
   	  * @return
   	  */
	 public function setIHObject($imObj)
		{
			$this->imageObj = $imObj;
		}

	/**
	 * indexFeaturedGliderContent::storeImagesTempServer()
	 *
	 * @param string $uploadUrl
	 * @param string $extern
	 * @return void
	 */
	 public function storeImagesTempServer($uploadUrl, $extern)
		{
			//GET LARGE IMAGE
			@chmod($uploadUrl.'.'.$extern, 0777);
			if($this->CFG['admin']['glider']['custom_image_width'] or $this->CFG['admin']['glider']['custom_image_height'])
				{
					$this->imageObj->resize($this->CFG['admin']['glider']['custom_image_width'], $this->CFG['admin']['glider']['custom_image_height'], '-');
					$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
				}
			else
				{
					$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
				}
		}

		/**
		 * indexFeaturedGliderContent::buildSortQuery()
		 * To build the sort query
		 *
		 * @return
		 * @access 	public
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = '';
				$sort = $this->fields_arr['orderby_field'];
				$orderBy = $this->fields_arr['orderby'];
				if ($sort AND $orderBy)
					{
						$this->sql_sort = ' '.$sort.' '.$orderBy;
					}
			}

	/**
	 * indexFeaturedGliderContent::updateReorderFeaturedContent()
	 * To update the menu settings
	 *
	 * @return
	 * @access 	public
	 */
	 public function updateReorderFeaturedContent()
		{
			foreach($_POST as $post=>$value)
				{
					if($post=='left')
						{
							$inc=1;
							$glider_arr = explode(',',$value);
							foreach($glider_arr as $glider_id)
								{
									$sql ='UPDATE '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
											' SET featured_order='.$this->dbObj->Param('featured_order').
											' WHERE index_glider_id='.$this->dbObj->Param('glider_id');
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, array($inc,$glider_id));
									if (!$rs)
										trigger_db_error($this->dbObj);
									$inc++;
								}
						}
				}
		}


	/**
	 * indexFeaturedGliderContent::populateFeaturedContentReorderList()
	 *
	 * @return
	 **/
	 public function populateFeaturedContentReorderList()
		{
			global $smartyObj;
			$this->reorder_keys = array();
			$this->reorder_arr = array();

			$sql='SELECT index_glider_id, glider_title FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
				' WHERE status=\'Active\' ORDER BY featured_order';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array());

			if (!$rs)
				trigger_db_error($this->dbObj);

			if($rs->PO_RecordCount())
				{
					while($row = $rs->FetchRow())
						{
							$row['glider_title'] = wordWrap_mb_ManualWithSpace($row['glider_title'], $this->CFG['admin']['glider']['slide_title_length'], $this->CFG['admin']['glider']['slide_title_total_length'], 0);
							$this->reorder_arr[$row['index_glider_id']]=$row;
						}
					$this->reorder_keys = array_keys($this->reorder_arr);
				}
		}


	/**
	 * indexFeaturedGliderContent::populateGliderFeaturedContentList()
	 *
	 * @return
	 **/
	 public function populateGliderFeaturedContentList()
		{
			global $smartyObj;
			$data_arr = array();
			$inc = 0;
			while($row = $this->fetchResultRecord()){
					$data_arr[$inc] = $row;
					$data_arr[$inc]['glider_id'] 	= $row['index_glider_id'];
					$data_arr[$inc]['media_type'] 	= $row['media_type'];
					$data_arr[$inc]['media_id'] 	= $row['media_id'];
					$data_arr[$inc]['glider_title'] = wordWrap_mb_ManualWithSpace($row['glider_title'], $this->CFG['admin']['glider']['slide_title_length'], $this->CFG['admin']['glider']['slide_title_total_length'], 0);
					$data_arr[$inc]['status']		= $row['status'];
					$data_arr[$inc]['edit_link'] = $this->CFG['site']['url'].'admin/indexContentGliderSettings.php?glider_id='.$row['index_glider_id'];
					$inc++;
				}
			$smartyObj->assign('populateContent_arr', $data_arr);
		}

	/**
	 * indexFeaturedGliderContent::deleteFeaturedContent()
	 *
	 * @return bollean
	 **/
	public function deleteFeaturedContent()
	{

		$this->removeFeaturedContentImage($this->fields_arr['gid']);
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' WHERE'.
				' index_glider_id IN('.$this->fields_arr['gid'].')';

		$stmt 	= $this->dbObj->Prepare($sql);
		$rs 	= $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($this->dbObj->Affected_Rows())
		{
			return true;
		}
		return false;
	}

	/**
	 * indexFeaturedGliderContent::updateFeaturedContentStatus()
	 *
	 * @param $status
	 * @return boolean
	 **/
	public function updateFeaturedContentStatus($status)
	{
		//echo $status.'='.$this->fields_arr['gid'];exit;
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' SET'.
				' status='.$this->dbObj->Param('status').' WHERE'.
				' index_glider_id IN('.$this->fields_arr['gid'].')';

		$stmt 	= $this->dbObj->Prepare($sql);
		$rs 	= $this->dbObj->Execute($stmt, array($status));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($this->dbObj->Affected_Rows())
			return true;
		return false;
	}

	/**
	 * indexFeaturedGliderContent::deleteFeaturedContent()
	 *
	 * @return boolean
	 **/
	public function removeFeaturedContentImage($gliderId)
	{
		$sql = 'SELECT index_glider_id, custom_image_ext FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' WHERE'.
					' index_glider_id='.$this->dbObj->Param('gliderId').' AND media_type=\'custom\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($gliderId));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if ($row = $rs->FetchRow())
		{
			$imagePath	= '../'.$this->CFG['admin']['glider']['custom_image_folder'].$row['index_glider_id'].'.'.$row['custom_image_ext'];
			if(file_exists($imagePath))
				@unlink($imagePath);
			return true;
		}
	}


	/**
	 * indexFeaturedGliderContent::populateSearchContent()
	 *
	 * @return void
	 * @access public
	 */
	 public function populateSearchContent($keyword, $media_type)
		{
			global $smartyObj;
			$data_arr	= array();
			$inc	= 0;
			if($media_type && $media_type!='custom')
			{
				if($media_type == 'photo')
				{
					$sql = 'SELECT p.photo_id AS media_id, p.photo_title AS media_title FROM '.
							$this->CFG['db']['tbl']['photo'].' as p WHERE p.photo_title like \'%'.$keyword.'%\'';
				}
				elseif($media_type == 'music')
				{
					$sql = 'SELECT m.music_id AS media_id, m.music_title AS media_title FROM '.
							$this->CFG['db']['tbl']['music'].' as m WHERE m.music_title like \'%'.$keyword.'%\'';
				}
				elseif($media_type == 'video')
				{
					$sql = 'SELECT v.video_id AS media_id, v.video_title AS media_title FROM '.
							$this->CFG['db']['tbl']['video'].' as v WHERE v.video_title like \'%'.$keyword.'%\'';
				}

				$stmt 	= $this->dbObj->Prepare($sql);
				$rs 	= $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				$inc	= 0;
				while($row = $rs->FetchRow())
				{
					$data_arr[$inc] = $row;
					$inc++;
				}
			}
			return $data_arr;
		}

	/**
	 * indexFeaturedGliderContent::chkIsEditMode()
	 *
	 * @return boolean
	 */
	 public function chkIsEditMode()
		{
			if($this->fields_arr['glider_id'])
				return true;
			return false;
		}

	/**
	 * indexFeaturedGliderContent::changeArrayToCommaSeparator()
	 *
	 * @param array $arry_value
	 * @return
	 */
	 public function changeArrayToCommaSeparator($arry_value = array())
		{
			return implode(',',$arry_value);
		}

	/**
	 * indexFeaturedGliderContent::chkFileNameIsNotEmpty()
	 *
	 * @param mixed $field_name
	 * @param string $err_tip
	 * @return
	 */
	 public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
		{
			if(!$_FILES[$field_name]['name'])
				{
					$this->setFormFieldErrorTip($field_name,$err_tip);
					return false;
				}
			return true;
		}

	/**
	 * indexFeaturedGliderContent::chkValideFileSize()
	 *
	 * @param mixed $field_name
	 * @param string $err_tip
	 * @return
	 */
	 public function chkValideFileSize($field_name, $err_tip='')
		{
			$max_size = $this->CFG['admin']['glider']['custom_image_max_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
				{
					$this->fields_err_tip_arr[$field_name] = $err_tip;
					return false;
				}
			return true;
		}

	/**
		* indexFeaturedGliderContent::updateCategoryImageExt()
		* To Update category image ext
		*
		* @param string $category_ext
		* @access public
		* @return void
		**/
		public function updateCustomImageExt($gliderId, $image_ext)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].' SET '.
			'custom_image_ext = '.$this->dbObj->Param('custom_image_ext').' '.
			'WHERE index_glider_id = '.$this->dbObj->Param('glider_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($image_ext, $gliderId));
			if (!$rs)
				trigger_db_error($this->dbObj);
			return true;
		}

	/**
	 * indexFeaturedGliderContent::chkIsValidMediaId()
	 * To check whether given media is valid or not
	 *
	 * @param Integer $glider_id
	 * @param string $err_tip
	 * @return boolean
	 */
	 public function chkIsValidMediaId($media_id, $media_type, $err_tip='')
		{

			if($media_type && $media_id)
			{
				if($media_type == 'photo')
				{
					$sql = 'SELECT photo_id FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_status=\'Ok\' AND photo_id=\''.$media_id.'\'';
				}
				elseif($media_type == 'music')
				{
					$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_status=\'Ok\' AND music_id=\''.$media_id.'\'';
				}
				elseif($media_type == 'video')
				{
					$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_status=\'Ok\' AND video_id=\''.$media_id.'\'';
				}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
			        trigger_db_error($this->dbObj);

				if ($rs->FetchRow())
					return true;

				$this->fields_err_tip_arr['media_id'] = $err_tip;
				return false;
			}
			$this->fields_err_tip_arr['media_id'] = $err_tip;
			return false;
		}


	/**
	 * indexFeaturedGliderContent::resetFieldsArray()
	 *
	 * @return void
	 */
	 public function resetFieldsArray()
		{
			$this->setFormField('media_type', '');
			$this->setFormField('media_id', '');
			$this->setFormField('rollover_text', '');
			$this->setFormField('sidebar_content', '');
			$this->setFormField('media_default_content', 'Yes');
			$this->setFormField('max_rollovers_allowed', '10');
			$this->setFormField('glider_id', '');
			$this->setFormField('glider_title', '');
			$this->setFormField('custom_image', '');
			$this->setFormField('custom_image_url', '');
			$this->setFormField('custom_image_ext', '');
			$this->setFormField('act', '');
		}

	/**
	 * indexFeaturedGliderContent::populateFeatureContentActiveCount()
	 *
	 * @return boolean
	 */
	 public function populateFeatureContentActiveCount()
		{
			$sql = 'SELECT COUNT(index_glider_id) AS cnt FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
						' WHERE status=\'Active\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				if($count < $this->fields_arr['max_rollovers_allowed'])
				{
					return true;
				}
				return false;
		}

	/**
	 * indexFeaturedGliderContent::isValidGliderId()
	 * To check the glider_id id is valid or not
	 *
	 * @param Integer $glider_id
	 * @param string $err_tip
	 * @return boolean
	 */
	 public function isValidGliderId($glider_id, $err_tip='')
		{
			$sql = 'SELECT index_glider_id'.
					' FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
					' WHERE index_glider_id = '.$this->dbObj->Param('glider_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$glider_id]));
			if (!$rs)
		        trigger_db_error($this->dbObj);

			if ($rs->FetchRow())
				return true;

			$this->setCommonErrorMsg($err_tip);
			return false;
		}

	/**
	 * indexFeaturedGliderContent::populateFeaturedContentById()
	 *
	 * @return boolean
	 */
	 public function populateFeaturedContentById()
		{
			$sql = 'SELECT index_glider_id, media_type, media_id, glider_title, is_use_default, rollover_text, sidebar_content, custom_image_target_url, custom_image_ext'.
					' FROM '.$this->CFG['db']['tbl']['index_root_featured_glider_details'].
					' WHERE index_glider_id='.$this->dbObj->Param('glider_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['glider_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
				{
					$this->fields_arr['media_type'] = $row['media_type'];
					$this->fields_arr['media_id'] = $row['media_id'];
					$this->fields_arr['rollover_text'] = $row['rollover_text'];
					$this->fields_arr['sidebar_content'] = $row['sidebar_content'];
					$this->fields_arr['media_default_content'] = $row['is_use_default'];
					$this->fields_arr['glider_title'] = $row['glider_title'];
					$this->fields_arr['custom_image_url'] = $row['custom_image_target_url'];
					$this->fields_arr['custom_image_ext'] = $row['custom_image_ext'];
					$this->fields_arr['glider_id'] = $row['index_glider_id'];
					if($row['media_type'] == 'custom' && $row['custom_image_ext'] != '')
						$this->custom_media_image = $this->CFG['site']['url'].$this->CFG['admin']['glider']['custom_image_folder'].$row['index_glider_id'].'.'.$row['custom_image_ext'];
					return true;
				}
			return false;
		}
}
//<<<<<-------------- Class index content gldier settings ends ---------------//
//-------------------- Code begins -------------->>>>>//
$indexContentGliderSetting = new indexFeaturedGliderContent();
$indexContentGliderSetting->setPageBlockNames(array('block_form_add_glider_content', 'block_form_list_glider_content', 'block_form_reorder_glider_content'));
$indexContentGliderSetting->setAllPageBlocksHide();
$indexContentGliderSetting->CFG['admin']['glider']['custom_image_format_arr'] = array('jpg', 'jpeg', 'png');
$indexContentGliderSetting->CFG['admin']['glider']['custom_image_max_size'] = 500;
$indexContentGliderSetting->CFG['admin']['glider']['custom_image_folder'] = 'files/index_glider_image/';
$indexContentGliderSetting->CFG['admin']['glider']['custom_image_width']  = 366;
$indexContentGliderSetting->CFG['admin']['glider']['custom_image_height'] = 275;
$indexContentGliderSetting->CFG['admin']['glider']['slide_title_length'] = 15;
$indexContentGliderSetting->CFG['admin']['glider']['slide_title_total_length'] = 18;
$indexContentGliderSetting->CFG['admin']['glider']['slide_title_max_length'] = 150;
$indexContentGliderSetting->CFG['admin']['glider']['rollover_text_max_length'] = 200;
$indexContentGliderSetting->CFG['admin']['glider']['custom_target_url_max_length'] = 150;
//default form fields and values...
$indexContentGliderSetting->resetFieldsArray();
$indexContentGliderSetting->setFormField('gid', '');
$indexContentGliderSetting->setFormField('action', '');
$indexContentGliderSetting->setFormField('start', '');
$indexContentGliderSetting->setFormField('left','');
$indexContentGliderSetting->left_navigation_div = 'generalIndexSetting';
$indexContentGliderSetting->setFormField('orderby_field', 'index_glider_id');
$indexContentGliderSetting->setFormField('orderby', 'DESC');
$indexContentGliderSetting->setTableNames(array($CFG['db']['tbl']['index_root_featured_glider_details']));
$indexContentGliderSetting->setReturnColumns(array('index_glider_id', 'media_id' ,'media_type', 'glider_title', 'is_use_default', 'status', 'date_added'));
$indexContentGliderSetting->sanitizeFormInputs($_REQUEST);

$indexContentGliderSetting->setPageBlockShow('block_form_add_glider_content');
$indexContentGliderSetting->setPageBlockShow('block_form_list_glider_content');
$indexContentGliderSetting->setPageBlockShow('block_form_reorder_glider_content');

// Code to search media id for selected media type starts here
$smartyObj->assign('searchResultCount',0);
$smartyObj->assign('searchSelectTemplate','');
$smartyObj->assign('searchKeyword','');
$noOfRecs = 10;
$start	= 0;
if($indexContentGliderSetting->isFormPOSTed($_POST, 'search_submit') || $indexContentGliderSetting->isFormPOSTed($_POST, 'seachKeyword'))
{
	if($CFG['admin']['is_demo_site'])
		{
			$indexContentGliderSetting->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
		}
	else
		{
			if($indexContentGliderSetting->isFormPOSTed($_POST, 'search_submit'))
			{
				$smartyObj->assign('searchKeyword',$_POST['search_input']);
				$searchResult	= $indexContentGliderSetting->populateSearchContent($_POST['search_input'], $_POST['search_media_type']);
				$_SESSION['searchResult']	= $searchResult;
			}
			elseif($indexContentGliderSetting->isFormPOSTed($_POST, 'seachKeyword'))
			{
				$smartyObj->assign('searchKeyword',$_POST['seachKeyword']);
				if($_POST['srch_feature']==1)
					$start	= 0;
				if($_POST['srch_feature']>1)
					$start	= ($_POST['srch_feature'] - 1 )* $noOfRecs;
			}

			if(is_array($_SESSION['searchResult']) && !empty($_SESSION['searchResult']))
			{
				$resultCount	= count($_SESSION['searchResult']);
				$totPages		= $resultCount/$noOfRecs;
				$totPagesReminder		= $resultCount%$noOfRecs;
				if($totPagesReminder>0)
					$totPages++;
				if($totPages>1)
				{
					$selectTemplate	='<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}" onchange="document.featured_content_search_form.submit();">';
					for($i=1;$i<=$totPages;$i++)
					{
						if($indexContentGliderSetting->isFormPOSTed($_POST, 'seachKeyword') && ($_POST['srch_feature']==$i))
							$selectTemplate	.= '<option value="'.$i.'" selected>'.$i.'</option>';
						else
							$selectTemplate	.= '<option value="'.$i.'">'.$i.'</option>';
					}
					$selectTemplate	.= '</select>';
					$smartyObj->assign('searchSelectTemplate',$selectTemplate);
				}
				$newSearchResult	= array_slice($_SESSION['searchResult'],$start,$noOfRecs);
			}
			else
			{
				$newSearchResult = array();
				$resultCount	= 0;
				$totPages		= 0;
				$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_featured_content_no_results_found']);
				$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
			}
			$smartyObj->assign('searchResultCount',$resultCount);
			$smartyObj->assign('searchResult',$newSearchResult);

			$indexContentGliderSetting->includeHeader();
			//include the content of the page
			setTemplateFolder('admin/');
			$smartyObj->display('featuredContentSearch.tpl');
			$indexContentGliderSetting->includeFooter();
			exit;
		}
}
// Code to search media id for selected media type ends here

if ($indexContentGliderSetting->isFormPOSTed($_POST, 'add_submit'))
{
		if($CFG['admin']['is_demo_site'])
		{
			$indexContentGliderSetting->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
		}
	else
		{
			$indexContentGliderSetting->chkIsNotEmpty('glider_title', $LANG['common_err_tip_required']);
			if($indexContentGliderSetting->getFormField('media_type')!='custom')
			{
				$indexContentGliderSetting->chkIsNotEmpty('media_id', $LANG['common_err_tip_required']) AND
					$indexContentGliderSetting->chkIsNumeric('media_id', $LANG['common_err_tip_numeric']) AND
						$indexContentGliderSetting->chkIsValidMediaId($indexContentGliderSetting->getFormField('media_id'), $indexContentGliderSetting->getFormField('media_type'), $LANG['index_glidersetting_invalid_media_id']);
			}
			//Validate rollover text and sidebar content if media defualt content is set as 'No' or media type is custom
			if($indexContentGliderSetting->getFormField('media_default_content') == 'No' || $indexContentGliderSetting->getFormField('media_type') == 'custom')
			{
				$indexContentGliderSetting->chkIsNotEmpty('rollover_text', $LANG['common_err_tip_required']);
				$indexContentGliderSetting->chkIsNotEmpty('sidebar_content', $LANG['common_err_tip_required']);
			}

			if($indexContentGliderSetting->getFormField('media_type') == 'custom')
			{
				$indexContentGliderSetting->chkFileNameIsNotEmpty('custom_image', $LANG['common_err_tip_required']) and
					$indexContentGliderSetting->chkValidFileType('custom_image', $indexContentGliderSetting->CFG['admin']['glider']['custom_image_format_arr'], $LANG['common_err_tip_invalid_image_format']) and
						$indexContentGliderSetting->chkValideFileSize('custom_image',$LANG['common_err_tip_invalid_file_size']) and
							$indexContentGliderSetting->chkErrorInFile('custom_image',$LANG['common_err_tip_invalid_image']);
				if($indexContentGliderSetting->getFormField('custom_image_url'))
					$indexContentGliderSetting->chkIsValidURL('custom_image_url', $LANG['common_err_tip_invalid_url_format']);
			}

			if($indexContentGliderSetting->isValidFormInputs())
			{
				if($CFG['admin']['is_demo_site'])
				{
					$indexContentGliderSetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
					$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
				}
				else
				{
					if($indexContentGliderSetting->getFormField('media_type') == 'custom')
					{
						$indexContentGliderSetting->setFormField('media_id', '');
						$indexContentGliderSetting->setFormField('media_default_content', 'No');
					}
					//Insert new index featured content
					$indexContentGliderSetting->insertMediaFeaturedContent();
					$imageId = $indexContentGliderSetting->indexFeaturedGliderId;

					//Code to upload custom image to corresponding folder
					if($indexContentGliderSetting->getFormField('media_type') == 'custom')
					{
						$extern = strtolower(substr($_FILES['custom_image']['name'], strrpos($_FILES['custom_image']['name'], '.')+1));
						$imageObj = new ImageHandler($_FILES['custom_image']['tmp_name']);
						$indexContentGliderSetting->setIHObject($imageObj);
						$temp_dir = '../'.$indexContentGliderSetting->CFG['admin']['glider']['custom_image_folder'];
						$indexContentGliderSetting->chkAndCreateFolder($temp_dir);
						$image_storePath = $temp_dir.$imageId;
						$indexContentGliderSetting->storeImagesTempServer($image_storePath, $extern);
						$indexContentGliderSetting->setFormField('custom_image_ext', $extern);
						$indexContentGliderSetting->updateCustomImageExt($imageId, $extern);
					}

					$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
					$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_featured_content_add_success']);
					$indexContentGliderSetting->resetFieldsArray();
				}
			}
			else
			{
				$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
				$indexContentGliderSetting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
		}
}
else if($indexContentGliderSetting->isFormPOSTed($_POST, 'update_submit'))
{
		if($CFG['admin']['is_demo_site'])
		{
			$indexContentGliderSetting->setCommonErrorMsg($LANG['general_config_not_allow_demo_site']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
		}
	else
		{
			$indexContentGliderSetting->chkIsNotEmpty('glider_title', $LANG['common_err_tip_required']);
			$indexContentGliderSetting->chkIsNumeric('glider_id', $LANG['index_glidersetting_invalid_glider_id'])and
					$indexContentGliderSetting->isValidGliderId('glider_id', $LANG['index_glidersetting_invalid_glider_id']);

			if($indexContentGliderSetting->getFormField('media_type')!='custom')
			{
				$indexContentGliderSetting->chkIsNotEmpty('media_id', $LANG['common_err_tip_required']) AND
					$indexContentGliderSetting->chkIsNumeric('media_id', $LANG['common_err_tip_numeric']) AND
						$indexContentGliderSetting->chkIsValidMediaId($indexContentGliderSetting->getFormField('media_id'), $indexContentGliderSetting->getFormField('media_type'), $LANG['index_glidersetting_invalid_media_id']);
			}

			//Validate rollover text and sidebar content if media defualt content is set as 'No' or media type is custom
			if($indexContentGliderSetting->getFormField('media_default_content') == 'No' || $indexContentGliderSetting->getFormField('media_type') == 'custom')
			{
				$indexContentGliderSetting->chkIsNotEmpty('rollover_text', $LANG['common_err_tip_required']);
				$indexContentGliderSetting->chkIsNotEmpty('sidebar_content', $LANG['common_err_tip_required']);
			}

			if($indexContentGliderSetting->getFormField('media_type') == 'custom')
			{
				if((isset($_FILES['custom_image']['name']) && trim($_FILES['custom_image']['name']!='')) || $indexContentGliderSetting->getFormField('custom_image_ext') == '')
				{
					$indexContentGliderSetting->chkValidFileType('custom_image', $indexContentGliderSetting->CFG['admin']['glider']['custom_image_format_arr'], $LANG['common_err_tip_invalid_image_format']) and
						$indexContentGliderSetting->chkValideFileSize('custom_image',$LANG['common_err_tip_invalid_file_size']) and
							$indexContentGliderSetting->chkErrorInFile('custom_image',$LANG['common_err_tip_invalid_image']);
				}

			}

			if($indexContentGliderSetting->getFormField('media_type') == 'custom')
			{
				if($indexContentGliderSetting->getFormField('custom_image_url'))
					$indexContentGliderSetting->chkIsValidURL('custom_image_url', $LANG['common_err_tip_invalid_url_format']);
			}


			if($indexContentGliderSetting->isValidFormInputs())
			{
				if($CFG['admin']['is_demo_site'])
				{
					$indexContentGliderSetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
					$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
				}
				else
				{
					if($indexContentGliderSetting->getFormField('media_type') == 'custom')
					{
						$indexContentGliderSetting->setFormField('media_id', '');
						$indexContentGliderSetting->setFormField('media_default_content', 'No');
					}
					else
					{
						$indexContentGliderSetting->setFormField('custom_image_url', '');
						$indexContentGliderSetting->updateCustomImageExt($indexContentGliderSetting->getFormField('glider_id'), '');
					}

					//Update existing index featured content
					$indexContentGliderSetting->insertMediaFeaturedContent();
					$imageId = $indexContentGliderSetting->indexFeaturedGliderId;

					//Code to upload custom image to corresponding folder
					if($indexContentGliderSetting->getFormField('media_type') == 'custom')
					{
						if((isset($_FILES['custom_image']['name']) && trim($_FILES['custom_image']['name']!='')) || $indexContentGliderSetting->getFormField('custom_image_ext') == '')
						{
							$extern = strtolower(substr($_FILES['custom_image']['name'], strrpos($_FILES['custom_image']['name'], '.')+1));
							$imageObj = new ImageHandler($_FILES['custom_image']['tmp_name']);
							$indexContentGliderSetting->setIHObject($imageObj);
							$temp_dir = '../'.$indexContentGliderSetting->CFG['admin']['glider']['custom_image_folder'];
							$indexContentGliderSetting->chkAndCreateFolder($temp_dir);
							$image_storePath = $temp_dir.$imageId;
							$indexContentGliderSetting->storeImagesTempServer($image_storePath, $extern);
							$indexContentGliderSetting->setFormField('custom_image_ext', $extern);
							$indexContentGliderSetting->updateCustomImageExt($imageId, $extern);
						}
					}

					$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
					$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_featured_content_update_success']);
					$indexContentGliderSetting->resetFieldsArray();
				}
			}
			else
			{
				$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
				$indexContentGliderSetting->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
		}

}
elseif ($indexContentGliderSetting->isFormGETed($_GET, 'glider_id'))
{
	if($indexContentGliderSetting->chkIsNumeric('glider_id', $LANG['index_glidersetting_invalid_glider_id'])and
			$indexContentGliderSetting->isValidGliderId('glider_id', $LANG['index_glidersetting_invalid_glider_id']))
	{
		$indexContentGliderSetting->populateFeaturedContentById();
	}
	else
	{
		$indexContentGliderSetting->setCommonErrorMsg($LANG['index_glidersetting_invalid_glider_id']);
		$indexContentGliderSetting->setPageBlockShow('block_msg_form_error');
	}
}

if($indexContentGliderSetting->isFormPOSTed($_POST, 'action'))
{
	if($CFG['admin']['is_demo_site'])
		{
			$indexContentGliderSetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
		}
	else
		{
			if($indexContentGliderSetting->getFormField('action')=='delete')
				{
					if($indexContentGliderSetting->deleteFeaturedContent())
						{
							$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
							$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_success_deleted']);
						}
				}
			else if($indexContentGliderSetting->getFormField('action')=='activate')
				{
					if($indexContentGliderSetting->updateFeaturedContentStatus('Active'))
						{
							$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
							$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_success_activated']);
						}
				}
			else if($indexContentGliderSetting->getFormField('action')=='deactivate')
				{
					if($indexContentGliderSetting->updateFeaturedContentStatus('Inactive'))
						{
							$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
							$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_success_deactivated']);
						}
				}

		}
}

//Code to reorder featured content
if($indexContentGliderSetting->isFormPOSTed($_POST, 'update_order'))
{
	if($CFG['admin']['is_demo_site'])
		{
			$indexContentGliderSetting->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
		}
	else
		{
			$indexContentGliderSetting->updateReorderFeaturedContent();
			$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_reorder_susccess']);
			$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
		}
}
//Functuion invokes reorder featured content list
if($indexContentGliderSetting->isShowPageBlock('block_form_reorder_glider_content'))
{
	$indexContentGliderSetting->populateFeaturedContentReorderList();
	$indexContentGliderSetting->dom_element=implode('\',\'',$indexContentGliderSetting->reorder_keys);
?>
<script type="text/javascript">
	var modules = Array('<?php echo $indexContentGliderSetting->dom_element;?>');
	var reorder_section_count = 1;
</script>
<?php
}

//Condition to hide add featured content glider form if total active status record count > maximum rollovers allowed
if(!$indexContentGliderSetting->chkIsEditMode())
{
	if(!$indexContentGliderSetting->populateFeatureContentActiveCount())
	{
		$indexContentGliderSetting->setPageBlockHide('block_form_add_glider_content');
		//$indexContentGliderSetting->setCommonSuccessMsg($LANG['index_glidersetting_max_rollowvers_reached']);
		//$indexContentGliderSetting->setPageBlockShow('block_msg_form_success');
	}
}

if ($indexContentGliderSetting->isFormPOSTed($_POST, 'cancel_submit'))
{
	$indexContentGliderSetting->resetFieldsArray();
	Redirect2URL(getCurrentUrl(false));
}

if ($indexContentGliderSetting->isFormGETed($_GET, 'act'))
{
	if($indexContentGliderSetting->getFormField('act')=='search')
	{
		$indexContentGliderSetting->includeHeader();
		//include the content of the page
		setTemplateFolder('admin/');
		$smartyObj->display('featuredContentSearch.tpl');
		$indexContentGliderSetting->includeFooter();
		exit;
	}
}

if($indexContentGliderSetting->isShowPageBlock('block_form_list_glider_content'))
{
	$indexContentGliderSetting->buildSelectQuery();
	$indexContentGliderSetting->buildConditionQuery();
	$indexContentGliderSetting->buildSortQuery();
	$indexContentGliderSetting->buildQuery();
	$indexContentGliderSetting->executeQuery();
	//$indexContentGliderSetting->printQuery();
}

$indexContentGliderSetting->deleteForm_hidden_arr = array('start', 'gid', 'action');
if ($indexContentGliderSetting->isShowPageBlock('block_form_list_glider_content'))
	{
		$indexContentGliderSetting->populateGliderFeaturedContentList();
		$smartyObj->assign('smarty_paging_list', $indexContentGliderSetting->populatePageLinksGET($indexContentGliderSetting->getFormField('start')));
		$smartyObj->assign('delete_submit_onclick', 'if(getMultiCheckBoxValue(\'selListFeaturedContentForm\', \'check_all\', \''.$LANG['index_glidersetting_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'msgConfirmform\', Array(\'gid\', \'action\', \'confirmationMsg\'), Array(multiCheckValue, \'delete\', \''.nl2br($LANG['index_glidersetting_delete_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
		$smartyObj->assign('activate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListFeaturedContentForm\', \'check_all\', \''.$LANG['index_glidersetting_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'msgConfirmform\', Array(\'gid\', \'action\', \'confirmationMsg\'), Array(multiCheckValue, \'activate\', \''.nl2br($LANG['index_glidersetting_activate_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
		$smartyObj->assign('deactivate_submit_onclick', 'if(getMultiCheckBoxValue(\'selListFeaturedContentForm\', \'check_all\', \''.$LANG['index_glidersetting_check_atleast_one'].'\')){Confirmation(\'selMsgConfirmWindow\', \'msgConfirmform\', Array(\'gid\', \'action\', \'confirmationMsg\'), Array(multiCheckValue, \'deactivate\', \''.nl2br($LANG['index_glidersetting_deactivate_confirmation']).'\'), Array(\'value\', \'value\', \'innerHTML\'));}');
	}
//include the header file
$indexContentGliderSetting->includeHeader();
?>
<script type="text/javascript">
function showCustomBlock(val){
	if(val == 'custom')
	{
		$Jq('#id_custom_image').removeAttr('disabled');
		$Jq('#id_custom_image_url').removeAttr('disabled');
		$Jq('#media_default_content1').attr('disabled', 'disabled');
		$Jq('#media_default_content2').attr('disabled', 'disabled');
		$Jq('#id_media_id').val('');
		$Jq('#id_media_id').attr('disabled', 'disabled');
		$Jq('#sidebarMandatory').css('display', 'block');
		$Jq('#rolloverMandatory').css('display', 'block');
		$Jq('#selSearchMedia').css('display', 'none');
		$Jq('#selCustomImage').css('display', 'block');
		$Jq('#selCustomTargetUrl').css('display', 'block');
		$Jq('#selMediaId').css('display', 'none');
	}
	else
	{
		$Jq('#id_custom_image').attr('disabled', 'disabled');
		$Jq('#id_custom_image_url').attr('disabled', 'disabled');
		$Jq('#media_default_content1').removeAttr('disabled');
		$Jq('#media_default_content2').removeAttr('disabled');
		$Jq('#id_media_id').removeAttr('disabled');
		$Jq('#id_media_id').val('');
		$Jq('#sidebarMandatory').css('display', 'none');
		$Jq('#rolloverMandatory').css('display', 'none');
		$Jq('#id_custom_image_url').val('');
		$Jq('#selSearchMedia').css('display', 'block');
		$Jq('#selCustomImage').css('display', 'none');
		$Jq('#selCustomTargetUrl').css('display', 'none');
		$Jq('#selMediaId').css('display', 'block');
	}
}
function showMediaBlock(val){
	if(val == 'No')
	{
		$Jq('#sidebarMandatory').css('display', 'block');
		$Jq('#rolloverMandatory').css('display', 'block');
	}
	else
	{
		$Jq('#sidebarMandatory').css('display', 'none');
		$Jq('#rolloverMandatory').css('display', 'none');
	}

}
function openSearchPage(id){
	contentUrl = '<?php echo $CFG['site']['url'];?>admin/indexContentGliderSettings.php?act=search';
	searchWindow	= window.open(contentUrl, "","status=0,resizeable=yes,scrollbars=1,width=700,height=600");
	searchWindow.moveTo(600,200);
}
</script>
<?php
//include the content of the page
setTemplateFolder('admin/');
$smartyObj->display('indexContentGliderSettings.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$indexContentGliderSetting->includeFooter();
?>