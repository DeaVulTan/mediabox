<?php
//--------------class ArticleCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		ArticleCategoryFormHandler
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-06-23
 **/
class ArticleCategoryFormHandler extends ArticleHandler
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
		$type=getCategoryFilter('article_category_type', 'article');
		$this->sql_condition = ' parent_category_id=\'0\' AND article_category_status=\'Yes\' '.$type;
	}

	public function getTodayCategory($category_id)
	{
		$sql = 'SELECT COUNT(article_id) AS count '.
				'FROM '.$this->CFG['db']['tbl']['article'].' '.
				'WHERE article_category_id = '.$this->dbObj->Param('article_category_id').' AND '.
				'DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND article_status=\'Ok\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['count'];
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
		$catergoryPerRow = $this->CFG['admin']['articles']['catergory_list_per_row'];
		$count = 0;
		$rowInc=0;
		$sql = 'SELECT a.article_category_id, COUNT(a.article_id)'.
				' AS total_articles FROM '.$this->CFG['db']['tbl']['article'].
				' AS a WHERE a.article_status=\'Ok\' GROUP'.
				' BY article_category_id HAVING total_articles>0';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$category_count_arr = array();
		while($row = $rs->FetchRow())
			$category_count_arr[$row['article_category_id']] = $row['total_articles'];

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

			$row['article_category_type']	= $this->LANG[strtolower($row['article_category_type'])];
			$row['article_category_count']= isset($row['article_category_count'])?$row['article_category_count']:0;
			$row['article_category_name']	= nl2br(stripslashes($row['article_category_name']));
			$row['article_category_count']= isset($category_count_arr[$row['article_category_id']])?$category_count_arr[$row['article_category_id']]:0;
			$row['article_category_name'] = $row['article_category_name'];
			$row['article_category_description'] = $row['article_category_description'];
			$return[$count]['record']			= $row;
			$return[$count]['category_image'] = '';
			if($row['article_category_ext'] != '')
			{
				$return[$count]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['articles']['category_folder'].$row['article_category_id'].'.'.$row['article_category_ext'];
			}
			if(!file_exists($return[$count]['category_image']))
			{
				$return[$count]['category_image'] =  $this->CFG['site']['url'] . 'article/design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no_image/icon-nocategory.jpg';
			}
			else
			{
				$return[$count]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$return[$count]['category_image']);
			}
			$return[$count]['article_link']			= getUrl('articlelist','?pg=articlenew&cid='.$row['article_category_id'], 'articlenew/?cid='.$row['article_category_id'],'','article');
			$return[$count]['today_category_count']	= $this->getTodayCategory($row['article_category_id']);
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
//<<<<<<<--------------class ArticleCategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$articlecategory = new ArticleCategoryFormHandler();
$articlecategory->setDBObject($db);
$articlecategory->makeGlobalize($CFG,$LANG);
//article catagory List order by Priority on / off features
if($CFG['admin']['articles']['article_category_list_priority'])
	$articlecategory->setFormField('orderby_field', 'priority');
else
	$articlecategory->setFormField('orderby_field', 'article_category_name');
$articlecategory->setFormField('orderby', 'ASC');
$articlecategory->setFormField('bname', '');
$articlecategory->setFormField('tags', '');
$articlecategory->setFormField('user_id', '0');
$articlecategory->setFormField('start', '0');
$articlecategory->setFormField('numpg', '20');
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$articlecategory->setPageBlockNames(array('form_show_category'));
$articlecategory->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$articlecategory->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$articlecategory->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$articlecategory->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$articlecategory->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$articlecategory->setTableNames(array($CFG['db']['tbl']['article_category'].' as gc '));
$articlecategory->setReturnColumns(array('gc.article_category_id','gc.article_category_name', 'article_category_type','article_category_description','article_category_status','article_category_ext','gc.date_added'));
$articlecategory->setPageBlockShow('block_show_category');
$articlecategory->setAllPageBlocksHide();
$articlecategory->setPageBlockShow('form_show_category');
$articlecategory->sanitizeFormInputs($_REQUEST);


//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($articlecategory->isShowPageBlock('form_show_category'))
{
	$articlecategory->buildSelectQuery();
	$articlecategory->buildConditionQuery();
	$articlecategory->buildSortQuery();
	$articlecategory->buildQuery();
//		$articlecategory->printQuery();
	$articlecategory->executeQuery();

	$smartyObj->assign('smarty_paging_list', $articlecategory->populatePageLinksGET($articlecategory->getFormField('start')));

	if($articlecategory->isResultsFound())
	{
		$articlecategory->form_show_category=$articlecategory->showCategory();
	}
}


//include the header file
$articlecategory->includeHeader();
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
$smartyObj->display('articleCategory.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$articlecategory->includeFooter();
?>