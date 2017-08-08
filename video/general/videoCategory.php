<?php
//--------------class VideoCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		VideoCategoryFormHandler
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-06-23
 **/
class VideoCategoryFormHandler extends VideoHandler
	{
		/**
		 *
		 * @access public
		 * @return void
		 **/

		 public function buildSortQuery()
		{
			$this->sql_sort =$this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
		}

		public function buildConditionQuery()
		{
			$type=getCategoryFilter('video_category_type');
			if($this->fields_arr['category_id'] == '')
				$this->sql_condition = ' parent_category_id=\'0\' AND video_category_status=\'Yes\' '.$type;
			else
				$this->sql_condition = ' parent_category_id='.$this->fields_arr['category_id'].' AND video_category_status=\'Yes\' '.$type;

			if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $this->fields_arr['pg'] == 'mysubscriptions')
				{
					$this->sql_condition .= ' AND s.module = \'video\' AND s.subscriber_id='.$this->CFG['user']['user_id'].
								' AND s.status=\'Yes\'';
				}
		}

		public function getTodayCategory($category_id)
			{
				$sql = 'SELECT COUNT(video_id) AS count '.
						'FROM '.$this->CFG['db']['tbl']['video'].' '.
						'WHERE video_category_id = '.$this->dbObj->Param('video_category_id').' AND '.
						'DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND video_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['count'];
			}


		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getVideoTags($category_id)
		{
			$return = array();
			$sql = 'SELECT video_tags '.
					'FROM '.$this->CFG['db']['tbl']['video'].' '.
					'WHERE video_category_id = '.$this->dbObj->Param('video_category_id').' AND video_status=\'Ok\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($category_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if ($row = $rs->FetchRow())
				{
					$tagArr = explode(' ', $row['video_tags']);
					$tagArr = array_unique($tagArr);
					$countArr = array();
					foreach($tagArr as $tag)
					{
						##strlen function has to be replace for Arabic language. In getStringLength() fucntion Multi byte String is checked and returing the string length.
						if (!$tag || getStringLength($tag) < $this->CFG['admin']['tag_minimum_size']) continue;
						$countArr[$tag] = substr_count($row['video_tags'], $tag);
					}
					$result_tag = '';
					$i = 0;
					if ($countArr)
						{
							arsort($countArr);
							while (list($key, $val) = each($countArr))
							{
								$key = strtolower($key);
								$return[$i]['key']=$key;
								$return[$i]['link']=getUrl('videolist','?pg=videonew&tags='.$key, 'videonew/?tags='.$key,'','video');
								$i++;
								if ($i == 4) break;
							}
						}
						else
						{
							while (list($key, $val) = each($tagArr))
							{
								$return[$i]['key']=$key;
								$return[$i]['link']=$val.' ';
								$i++;
								if ($i == 4) break;
							}
						}
					return $return;
			    }
			return $return;
		}

	/**
	 * VideoHandler::getCategoryName()
	 *
	 * @param mixed $category_id
	 * @return string
	 */
	public function getCategoryName($category_id)
	{
		$sql = 'SELECT video_category_name '.
					'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
					'WHERE video_category_id = '.$this->dbObj->Param('video_category_id').
					' AND video_category_status=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['video_category_name'];
	}
		/**
		 * To display the forums titles
		 *
		 * @access public
		 * @return void
		 **/
		public function showCategory()
			{
				$return=array();
				$catergoryPerRow = $this->CFG['admin']['videos']['catergory_list_per_row'];
				$count = 0;
				$rowInc=0;

				 $default_cond = '(u.user_id = v.user_id'.
								 ' AND u.usr_status=\'Ok\') AND '.
								 ' v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								 ' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								 ' video_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$sql = 'SELECT v.video_category_id, COUNT(v.video_id)'.
						' AS total_videos FROM '.$this->CFG['db']['tbl']['video'].
						' AS v, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE v.video_status=\'Ok\' AND '.$default_cond.
						' GROUP BY video_category_id HAVING total_videos>0';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$category_count_arr = array();
				while($row = $rs->FetchRow())
					$category_count_arr[$row['video_category_id']] = $row['total_videos'];

				while($row = $this->fetchResultRecord())
				{
					$return[$count]['open_tr'] = false;
					$found = true;
					if ($rowInc%$catergoryPerRow==0)
			   		{
						$return[$count]['open_tr'] = true;
				    }

					if(chkAllowedModule(array('content_filter')))
					{
						$return[$count]['content_filter'] = true;
					}
					else
					{
						$return[$count]['content_filter'] = false;
					}
					$row['video_sub_url']		= getUrl('videocategory', '?category_id='.$row['video_category_id'], '?category_id='.$row['video_category_id'], '', 'video');	
					$row['video_category_type']	= $this->LANG[strtolower($row['video_category_type'])];
					$row['video_category_count']= isset($row['video_category_count'])?$row['video_category_count']:0;
					$row['video_category_name']	= nl2br(stripslashes($row['video_category_name']));
					$row['video_category_count']= isset($category_count_arr[$row['video_category_id']])?$category_count_arr[$row['video_category_id']]:0;
					$row['video_category_name'] = wordWrap_mb_ManualWithSpace($row['video_category_name'], $this->CFG['admin']['videos']['member_video_category_name_length'], $this->CFG['admin']['videos']['member_video_category_name_total_length']);
					$row['video_category_description'] = wordWrap_mb_ManualWithSpace($row['video_category_description'], $this->CFG['admin']['videos']['member_video_category_description_length'], $this->CFG['admin']['videos']['member_video_category_description_total_length']);
					$return[$count]['record']			= $row;
					$return[$count]['category_image'] = '';
					if($row['video_category_ext'])
					{
						$return[$count]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['videos']['category_folder'].$row['video_category_id'].'.'.$row['video_category_ext'];
					}
					if(!file_exists($return[$count]['category_image']))
					{
						$return[$count]['category_image'] =  $this->CFG['site']['video_url'].'design/templates/'.
																$this->CFG['html']['template']['default'].'/root/images/'.
																	$this->CFG['html']['stylesheet']['screen']['default'].
																		'/no_image/noImageVideo_S.jpg';
					}
					else
					{
						$return[$count]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$return[$count]['category_image']);
					}
					if($this->fields_arr['category_id'] == '')
						{
							$return[$count]['video_link']			= getUrl('videolist','?pg=videonew&cid='.$row['video_category_id'], 'videonew/?cid='.$row['video_category_id'],'','video');
						}
					else
						{
							$return[$count]['video_link']			= getUrl('videolist','?pg=videonew&cid='.$this->fields_arr['category_id'].'&sid='.$row['video_category_id'], 'videonew/?cid='.$this->fields_arr['category_id'].'&sid='.$row['video_category_id'],'','video');
						}
					$return[$count]['today_category_count']	= $this->getTodayCategory($row['video_category_id']);
					$return[$count]['video_tag']= $this->getVideoTags($row['video_category_id']);
					$return[$count]['sub_category_count']= $this->getTotalSubCategory($row['video_category_id']);
					$return[$count]['sub_category_url']= getUrl('videocategory', '?category_id='.$row['video_category_id'], '?category_id='.$row['video_category_id'], '', 'video');
					$rowInc++;
					$return[$count]['end_tr'] = false;
					if ($rowInc%$catergoryPerRow==0)
					    {
							$rowInc = 0;
							$return[$count]['end_tr'] = true;
			    		}
				$count++;

				}
				$this->category_list['extra_td_tr'] = false;
				if ($found and $rowInc and $rowInc<$catergoryPerRow)
				    {
						$this->category_list['extra_td_tr'] = true;
						$this->category_list['records_per_row'] = $catergoryPerRow - $rowInc;
					}

				return $return;
			}

		/**
		 * VideoCategoryFormHandler::getTotalSubCategory()
		 *
		 * @param mixed $category_id
		 * @return Integer
		 */
		public function getTotalSubCategory($category_id)
			{
				$sql = 'SELECT COUNT(*) AS total '.
						'FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE parent_category_id = '.$this->dbObj->Param('video_category_id').
						' AND video_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total'];
			}

	}
//<<<<<<<--------------class VideoCategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$videocategory = new VideoCategoryFormHandler();

//Video catagory List order by Priority on / off features
if($CFG['admin']['videos']['video_category_list_priority'])
	$videocategory->setFormField('orderby_field', 'priority');
else
	$videocategory->setFormField('orderby_field', 'video_category_name');
$videocategory->setFormField('orderby', 'ASC');
$videocategory->setFormField('bname', '');
$videocategory->setFormField('tags', '');
$videocategory->setFormField('user_id', '0');
$videocategory->setFormField('start', '0');
$videocategory->setFormField('numpg', '20');
$videocategory->setFormField('pg', '');
$videocategory->setFormField('category_id', '');
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$videocategory->setTableNames(array($CFG['db']['tbl']['video_category'].' as gc '));
$videocategory->setReturnColumns(array('gc.video_category_id','gc.video_category_name',
									'video_category_type','video_category_description',
									'video_category_status','video_category_ext','gc.date_added'));


$videocategory->setAllPageBlocksHide();
$videocategory->setPageBlockShow('form_show_category');
$videocategory->sanitizeFormInputs($_REQUEST);

if($videocategory->getFormField('category_id') == '')
	{
		$videocategory->my_subscription_url = getUrl('videocategory', '?pg=mysubscriptions', 'mysubscriptions/', '', 'video');
		if($videocategory->getFormField('pg') == 'mysubscriptions')
			$videocategory->LANG['videocategory_page_title'] = $LANG['videocategory_my_subscribed_categories'];

	}
else
	{
		$videocategory->my_subscription_url = getUrl('videocategory', '?pg=mysubscriptions&category_id='.$videocategory->getFormField('category_id'), 'mysubscriptions/?category_id='.$videocategory->getFormField('category_id'), '', 'video');
		$videocategory->LANG['videocategory_page_title'] = str_replace('{category}', $videocategory->getCategoryName($videocategory->getFormField('category_id')), $LANG['videocategory_cate_subcategory']);
		if($videocategory->getFormField('pg') == 'mysubscriptions')
			$videocategory->LANG['videocategory_page_title'] = str_replace('{category}', $videocategory->getCategoryName($videocategory->getFormField('category_id')), $LANG['videocategory_my_subscribed_sub_categories']);
	}

if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $videocategory->getFormField('pg') == 'mysubscriptions')
	{
		$videocategory->setTableNames(array($CFG['db']['tbl']['video_category'].' as gc JOIN '.$CFG['db']['tbl']['subscription'].' as s ON gc.video_category_id = s.category_id'));
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($videocategory->isShowPageBlock('form_show_category'))
{
		$videocategory->buildSelectQuery();
		$videocategory->buildConditionQuery();
		$videocategory->buildSortQuery();
		$videocategory->buildQuery();
		//$videocategory->printQuery();
		$videocategory->executeQuery();

		$smartyObj->assign('smarty_paging_list', $videocategory->populatePageLinksGET($videocategory->getFormField('start')));

		$videocategory->form_show_category = array();

		if($videocategory->isResultsFound())
		{
			$videocategory->form_show_category = $videocategory->showCategory();
		}
}


//include the header file
$videocategory->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
function loadUrl(element)
{
	window.location=element.value;
}
</script>
<?php

setTemplateFolder('general/','video');
$smartyObj->display('videoCategory.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$videocategory->includeFooter();
?>