<?php
//--------------class blogCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		blogCategoryFormHandler
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-06-23
 **/
class blogCategoryFormHandler extends BlogHandler
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
		$type=getCategoryFilter('blog_category_type', 'blog');
		$this->sql_condition = ' parent_category_id=\'0\' AND blog_category_status=\'Yes\' '.$type;
	}

	public function getTodayCategory($category_id)
	{
		$sql = 'SELECT COUNT(blog_post_id) AS count '.
				'FROM '.$this->CFG['db']['tbl']['blog_posts'].' '.
				'WHERE blog_category_id = '.$this->dbObj->Param('blog_category_id').' AND '.
				'DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND status=\'Ok\'';

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
	public function getBlogTags($category_id)
	{
		$return = array();
		$sql = 'SELECT blog_tags '.
				'FROM '.$this->CFG['db']['tbl']['blog_posts'].' '.
				'WHERE blog_category_id = '.$this->dbObj->Param('blog_category_id').' AND status=\'Ok\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if ($row = $rs->FetchRow())
		{
			$tagArr = explode(' ', $row['blog_tags']);
			$tagArr = array_unique($tagArr);
			$countArr = array();
			foreach($tagArr as $tag)
			{
				##strlen function has to be replace for Arabic language. In getStringLength() fucntion Multi byte String is checked and returing the string length.
				if (!$tag || getStringLength($tag) < $this->CFG['admin']['tag_minimum_size']) continue;
				$countArr[$tag] = substr_count($row['blog_tags'], $tag);
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
					$return[$i]['link']=getUrl('blogpostlist','?pg=postnew&tags='.$key, 'postnew/?tags='.$key,'','blog');
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
	 * To display the forums titles
	 *
	 * @access public
	 * @return void
	 **/
	public function showCategory()
	{
		$return=array();
		$catergoryPerRow = $this->CFG['admin']['blog']['catergory_list_per_row'];
		$count = 0;
		$rowInc=0;
		$sql = 'SELECT bp.blog_category_id, COUNT(bp.blog_post_id)'.
				' AS total_posts FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' AS bp WHERE bp.status=\'Ok\' GROUP'.
				' BY blog_category_id ';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$category_count_arr = array();
		while($row = $rs->FetchRow())
			$category_count_arr[$row['blog_category_id']] = $row['total_posts'];

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

			$row['blog_category_type']	= $this->LANG[strtolower($row['blog_category_type'])];
			$row['blog_category_count']= isset($row['blog_category_count'])?$row['blog_category_count']:0;
			$row['blog_category_name']	= nl2br(stripslashes($row['blog_category_name']));
			$row['blog_category_count']= isset($category_count_arr[$row['blog_category_id']])?$category_count_arr[$row['blog_category_id']]:0;
			$row['blog_category_name'] = wordWrap_mb_ManualWithSpace($row['blog_category_name'], $this->CFG['admin']['blog']['member_blog_category_name_length'], $this->CFG['admin']['blog']['member_blog_category_name_total_length']);
			$row['blog_category_description'] = wordWrap_mb_ManualWithSpace($row['blog_category_description'], $this->CFG['admin']['blog']['member_blog_category_description_length'], $this->CFG['admin']['blog']['member_blog_category_description_total_length']);
			$return[$count]['record']			= $row;
			$return[$count]['category_image'] = '';
			if($row['blog_category_ext'] != '')
			{
				$return[$count]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['blog']['category_folder'].$row['blog_category_id'].'.'.$row['blog_category_ext'];
			}
			if(!file_exists($return[$count]['category_image']))
			{
				$return[$count]['category_image'] =  $this->CFG['site']['url'] . 'blog/design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no_image/icon-nocategory.jpg';
			}
			else
			{
				$return[$count]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$return[$count]['category_image']);
			}
			$return[$count]['blogpost_link']			= getUrl('blogpostlist','?pg=postnew&cid='.$row['blog_category_id'], 'postnew/?cid='.$row['blog_category_id'],'','blog');
			$return[$count]['today_category_count']	= $this->getTodayCategory($row['blog_category_id']);
			$return[$count]['blog_tag']= $this->getBlogTags($row['blog_category_id']);
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
//<<<<<<<--------------class blogCategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$blogcategory = new blogCategoryFormHandler();
if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$blogcategory->setDBObject($db);
$blogcategory->makeGlobalize($CFG,$LANG);
//blog catagory List order by Priority on / off features
if($CFG['admin']['blog']['blog_category_list_priority'])
	$blogcategory->setFormField('orderby_field', 'priority');
else
	$blogcategory->setFormField('orderby_field', 'blog_category_name');
$blogcategory->setFormField('orderby', 'ASC');
$blogcategory->setFormField('bname', '');
$blogcategory->setFormField('tags', '');
$blogcategory->setFormField('user_id', '0');
$blogcategory->setFormField('start', '0');
$blogcategory->setFormField('numpg', '20');

$blogcategory->setPageBlockNames(array('form_show_category'));
$blogcategory->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$blogcategory->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$blogcategory->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$blogcategory->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$blogcategory->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$blogcategory->setTableNames(array($CFG['db']['tbl']['blog_category'].' as bc '));
$blogcategory->setReturnColumns(array('bc.blog_category_id','bc.blog_category_name', 'blog_category_type','blog_category_description','blog_category_status','blog_category_ext','bc.date_added'));
$blogcategory->setPageBlockShow('block_show_category');
$blogcategory->setAllPageBlocksHide();
$blogcategory->setPageBlockShow('form_show_category');
$blogcategory->sanitizeFormInputs($_REQUEST);


//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($blogcategory->isShowPageBlock('form_show_category'))
{
	$blogcategory->buildSelectQuery();
	$blogcategory->buildConditionQuery();
	$blogcategory->buildSortQuery();
	$blogcategory->buildQuery();
//		$blogcategory->printQuery();
	$blogcategory->executeQuery();

	$smartyObj->assign('smarty_paging_list', $blogcategory->populatePageLinksGET($blogcategory->getFormField('start')));

	if($blogcategory->isResultsFound())
	{
		$blogcategory->form_show_category=$blogcategory->showCategory();
	}
}


//include the header file
$blogcategory->includeHeader();
//include the content of the page
?>
<script type="text/javascript">
function loadUrl(element)
{
	window.location=element.value;
}
</script>
<?php

setTemplateFolder('general/',$CFG['site']['is_module_page']);
$smartyObj->display('blogCategory.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$blogcategory->includeFooter();
?>