<?php
//--------------class MusicCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		MusicCategoryFormHandler
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-06-23
 **/
class MusicCategoryFormHandler extends MusicHandler
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
			$type=getCategoryFilter('music_category_type', 'music');
			if($this->fields_arr['category_id'] == '')
				$this->sql_condition = ' parent_category_id=\'0\' AND music_category_status=\'Yes\' '.$type;
			else
				$this->sql_condition = ' parent_category_id='.$this->fields_arr['category_id'].' AND music_category_status=\'Yes\' '.$type;
		}

		public function getTodayCategory($category_id)
			{
				$sql = 'SELECT COUNT(music_id) AS count '.
						'FROM '.$this->CFG['db']['tbl']['music'].' '.
						'WHERE music_category_id = '.$this->dbObj->Param('music_category_id').' AND '.
						'DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND music_status=\'Ok\'';

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
		public function getMusicTags($category_id)
		{
			$return = array();
			$sql = 'SELECT music_tags '.
					'FROM '.$this->CFG['db']['tbl']['music'].' '.
					'WHERE music_category_id = '.$this->dbObj->Param('music_category_id').' AND music_status=\'Ok\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($category_id));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if ($row = $rs->FetchRow())
				{
					$tagArr = explode(' ', $row['music_tags']);
					$tagArr = array_unique($tagArr);
					$countArr = array();
					foreach($tagArr as $tag)
					{
						##strlen function has to be replace for Arabic language. In getStringLength() fucntion Multi byte String is checked and returing the string length.
						if (!$tag || getStringLength($tag) < $this->CFG['admin']['tag_minimum_size']) continue;
						$countArr[$tag] = substr_count($row['music_tags'], $tag);
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
								$return[$i]['link']=getUrl('musiclist','?pg=musicnew&tags='.$key, 'musicnew/?tags='.$key,'','music');
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
	 * MusicHandler::getCategoryName()
	 *
	 * @param mixed $category_id
	 * @return string
	 */
	public function getCategoryName($category_id)
	{
		$sql = 'SELECT music_category_name '.
					'FROM '.$this->CFG['db']['tbl']['music_category'].' '.
					'WHERE music_category_id = '.$this->dbObj->Param('music_category_id').
					' AND music_category_status=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['music_category_name'];
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
				$catergoryPerRow = $this->CFG['admin']['musics']['catergory_list_per_row'];
				$count = 0;
				$rowInc=0;
				$sql = 'SELECT P.music_category_id, COUNT(P.music_id)'.
						' AS total_musics FROM '.$this->CFG['db']['tbl']['music'].
						' AS P WHERE P.music_status=\'Ok\' GROUP'.
						' BY music_category_id HAVING total_musics>0';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$category_count_arr = array();
				while($row = $rs->FetchRow())
					$category_count_arr[$row['music_category_id']] = $row['total_musics'];

				while($row = $this->fetchResultRecord())
				{
					$return[$count]['open_tr'] = '';
					if ($rowInc%$catergoryPerRow==0)
			   		{
						$return[$count]['open_tr'] = '<tr>';
				    }

					if(chkAllowedModule(array('content_filter')))
					{
						$return[$count]['content_filter'] = true;
					}
					else
					{
						$return[$count]['content_filter'] = false;
					}
					$row['music_sub_url']		= getUrl('musiccategory', '?category_id='.$row['music_category_id'], '?category_id='.$row['music_category_id'], '', 'music');
					$row['music_category_type']	= $this->LANG[strtolower($row['music_category_type'])];
					$row['music_category_count']= isset($row['music_category_count'])?$row['music_category_count']:0;
					$row['music_category_name']	= nl2br(stripslashes($row['music_category_name']));
					$row['music_category_count']= isset($category_count_arr[$row['music_category_id']])?$category_count_arr[$row['music_category_id']]:0;
					$row['music_category_name'] = $row['music_category_name'];
					$row['music_category_description'] = $row['music_category_description'];
					$return[$count]['record']			= $row;
					$return[$count]['category_image'] = '';
					if($row['music_category_ext'] != '')
						{
							$return[$count]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['musics']['category_folder'].$row['music_category_id'].'.'.$row['music_category_ext'];
						}
					if(!file_exists($return[$count]['category_image']))
						{
							$return[$count]['category_image'] =  $this->CFG['site']['url'] . 'music/design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no_image/noGenereImage_audio_T.jpg';
						}
					else
						{
							$return[$count]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$return[$count]['category_image']);
						}
					$return[$count]['music_link']			= getUrl('musiclist','?pg=musicnew&cid='.$row['music_category_id'], 'musicnew/?cid='.$row['music_category_id'],'','music');
					$return[$count]['today_category_count']	= $this->getTodayCategory($row['music_category_id']);
					$return[$count]['music_tag']= $this->getMusicTags($row['music_category_id']);
					$rowInc++;
					$return[$count]['end_tr'] = '';
					if ($rowInc%$catergoryPerRow==0)
					    {
							$rowInc = 0;
							$return[$count]['end_tr'] = '</tr>';
			    		}
				$count++;

				}
				return $return;
			}

	}
//<<<<<<<--------------class MusicCategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$musiccategory = new MusicCategoryFormHandler();
$musiccategory->setDBObject($db);
$musiccategory->makeGlobalize($CFG,$LANG);
//Music catagory List order by Priority on / off features
if($CFG['admin']['musics']['music_category_list_priority'])
	$musiccategory->setFormField('orderby_field', 'priority');
else
	$musiccategory->setFormField('orderby_field', 'music_category_name');
$musiccategory->setFormField('orderby', 'ASC');
$musiccategory->setFormField('bname', '');
$musiccategory->setFormField('tags', '');
$musiccategory->setFormField('user_id', '0');
$musiccategory->setFormField('start', '0');
$musiccategory->setFormField('numpg', '20');
$musiccategory->setFormField('category_id', '');
$musiccategory->setFormField('pg', '');
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$musiccategory->setPageBlockNames(array('form_show_category'));
$musiccategory->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$musiccategory->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$musiccategory->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$musiccategory->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$musiccategory->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$musiccategory->setTableNames(array($CFG['db']['tbl']['music_category'].' as gc '));
$musiccategory->setReturnColumns(array('gc.music_category_id','gc.music_category_name', 'music_category_type','music_category_description','music_category_status','music_category_ext','gc.date_added'));
$musiccategory->setPageBlockShow('block_show_category');
$musiccategory->setAllPageBlocksHide();
$musiccategory->setPageBlockShow('form_show_category');
$musiccategory->sanitizeFormInputs($_REQUEST);
if($musiccategory->getFormField('category_id'))
	$musiccategory->LANG['musiccategory_page_title'] = str_replace('{category}', $musiccategory->getCategoryName($musiccategory->getFormField('category_id')), $LANG['musiccategory_cate_subcategory']);




//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($musiccategory->isShowPageBlock('form_show_category'))
{
		$musiccategory->buildSelectQuery();
		$musiccategory->buildConditionQuery();
		$musiccategory->buildSortQuery();
		$musiccategory->buildQuery();
//		$musiccategory->printQuery();
		$musiccategory->executeQuery();

		$smartyObj->assign('smarty_paging_list', $musiccategory->populatePageLinksGET($musiccategory->getFormField('start')));

		if($musiccategory->isResultsFound())
		{
			$musiccategory->form_show_category=$musiccategory->showCategory();
		}
}


//include the header file
$musiccategory->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
function loadUrl(element)
{
	window.location=element.value;
}
</script>
<?php

setTemplateFolder('general/','music');
$smartyObj->display('musicCategory.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$musiccategory->includeFooter();
?>