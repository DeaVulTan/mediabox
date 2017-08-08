<?php
//--------------class photoCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		photoCategoryFormHandler
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-06-23
 **/
class photoCategoryFormHandler extends PhotoHandler
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
		$type=getCategoryFilter('photo_category_type', 'photo');
		if($this->fields_arr['category_id'] == '')
			$this->sql_condition = ' parent_category_id=\'0\' AND photo_category_status=\'Yes\' '.$type;
		else
			$this->sql_condition = ' parent_category_id='.$this->fields_arr['category_id'].' AND photo_category_status=\'Yes\' '.$type;
		if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $this->fields_arr['pg'] == 'mysubscriptions')
		{
			$this->sql_condition .= ' AND s.module = \'photo\' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' AND s.status=\'Yes\'';
		}
		//$this->sql_condition = ' parent_category_id=\'0\' AND photo_category_status=\'Yes\' '.$type;
	}

	public function getTodayCategory($category_id)
	{
		$sql = 'SELECT COUNT(photo_id) AS count '.
				'FROM '.$this->CFG['db']['tbl']['photo'].' '.
				'WHERE photo_category_id = '.$this->dbObj->Param('photo_category_id').' AND '.
				'DATE_FORMAT(date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\') AND photo_status=\'Ok\'';

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
	public function getphotoTags($category_id)
	{
		$return = array();
		$sql = 'SELECT photo_tags '.
				'FROM '.$this->CFG['db']['tbl']['photo'].' '.
				'WHERE photo_category_id = '.$this->dbObj->Param('photo_category_id').' AND photo_status=\'Ok\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if ($row = $rs->FetchRow())
		{
			$tagArr = explode(' ', $row['photo_tags']);
			$tagArr = array_unique($tagArr);
			$countArr = array();
			foreach($tagArr as $tag)
			{
				##strlen function has to be replace for Arabic language. In getStringLength() fucntion Multi byte String is checked and returing the string length.
				if (!$tag || getStringLength($tag) < $this->CFG['admin']['tag_minimum_size']) continue;
				$countArr[$tag] = substr_count($row['photo_tags'], $tag);
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
					$return[$i]['link']=getUrl('photolist','?pg=photonew&tags='.$key, 'photonew/?tags='.$key,'','photo');
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
	 * PhotoHandler::getCategoryName()
	 *
	 * @param mixed $category_id
	 * @return string
	 */
	public function getCategoryName($category_id)
	{
		$sql = 'SELECT photo_category_name '.
					'FROM '.$this->CFG['db']['tbl']['photo_category'].' '.
					'WHERE photo_category_id = '.$this->dbObj->Param('photo_category_id').
					' AND photo_category_status=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $row['photo_category_name'];
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
		$catergoryPerRow = $this->CFG['admin']['photos']['catergory_list_per_row'];
		$count = 0;
		$rowInc=0;
		$sql = 'SELECT P.photo_category_id, COUNT(P.photo_id)'.
				' AS total_photos FROM '.$this->CFG['db']['tbl']['photo'].
				' AS P WHERE P.photo_status=\'Ok\' GROUP'.
				' BY photo_category_id HAVING total_photos>0';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$category_count_arr = array();
		while($row = $rs->FetchRow())
			$category_count_arr[$row['photo_category_id']] = $row['total_photos'];

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
			$row['photo_sub_url']		= getUrl('photocategory', '?category_id='.$row['photo_category_id'], '?category_id='.$row['photo_category_id'], '', 'photo');
			$row['photo_category_type']	= $this->LANG[strtolower($row['photo_category_type'])];
			$row['photo_category_count']= isset($row['photo_category_count'])?$row['photo_category_count']:0;
			$row['photo_category_name']	= nl2br(stripslashes($row['photo_category_name']));
			$row['photo_category_count']= isset($category_count_arr[$row['photo_category_id']])?$category_count_arr[$row['photo_category_id']]:0;
			$row['photo_category_name'] = $row['photo_category_name'];
			$row['photo_category_description'] = $row['photo_category_description'];
			$return[$count]['record']			= $row;
			$return[$count]['category_image'] = '';
			if($row['photo_category_ext'] != '')
			{
				$return[$count]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['photos']['category_folder'].$row['photo_category_id'].'.'.$row['photo_category_ext'];
			}
			if(!file_exists($return[$count]['category_image']))
			{
				$return[$count]['category_image'] =  $this->CFG['site']['url'] . 'photo/design/templates/' . $this->CFG['html']['template']['default'] . '/root/images/' . $this->CFG['html']['stylesheet']['screen']['default'] . '/no_image/icon-nocategory.jpg';
			}
			else
			{
				$return[$count]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$return[$count]['category_image']);
			}
			$return[$count]['photo_link']			= getUrl('photolist','?pg=photonew&cid='.$row['photo_category_id'], 'photonew/?cid='.$row['photo_category_id'],'','photo');
			$return[$count]['today_category_count']	= $this->getTodayCategory($row['photo_category_id']);
			$return[$count]['photo_tag']= $this->getphotoTags($row['photo_category_id']);
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
//<<<<<<<--------------class photoCategoryFormHandler---------------//
//--------------------Code begins-------------->>>>>//
$photocategory = new photoCategoryFormHandler();
$photocategory->setDBObject($db);
$photocategory->makeGlobalize($CFG,$LANG);
//photo catagory List order by Priority on / off features
if($CFG['admin']['photos']['photo_category_list_priority'])
	$photocategory->setFormField('orderby_field', 'priority');
else
	$photocategory->setFormField('orderby_field', 'photo_category_name');
$photocategory->setFormField('orderby', 'ASC');
$photocategory->setFormField('bname', '');
$photocategory->setFormField('tags', '');
$photocategory->setFormField('user_id', '0');
$photocategory->setFormField('start', '0');
$photocategory->setFormField('numpg', '20');
$photocategory->setFormField('category_id', '');
$photocategory->setFormField('pg', '');
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$photocategory->setPageBlockNames(array('form_show_category'));
$photocategory->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$photocategory->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$photocategory->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$photocategory->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$photocategory->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$photocategory->setTableNames(array($CFG['db']['tbl']['photo_category'].' as gc '));
$photocategory->setReturnColumns(array('gc.photo_category_id','gc.photo_category_name', 'photo_category_type','photo_category_description','photo_category_status','photo_category_ext','gc.date_added'));
$photocategory->setPageBlockShow('block_show_category');
$photocategory->setAllPageBlocksHide();
$photocategory->setPageBlockShow('form_show_category');
$photocategory->sanitizeFormInputs($_REQUEST);
if($photocategory->getFormField('category_id') == '')
	{
		$photocategory->my_subscription_url = getUrl('photocategory', '?pg=mysubscriptions', 'mysubscriptions/', '', 'photo');
		if($photocategory->getFormField('pg') == 'mysubscriptions')
			$photocategory->LANG['photocategory_page_title'] = $LANG['photocategory_my_subscribed_categories'];

	}
else
	{
		$photocategory->my_subscription_url = getUrl('photocategory', '?pg=mysubscriptions&category_id='.$photocategory->getFormField('category_id'), 'mysubscriptions/?category_id='.$photocategory->getFormField('category_id'), '', 'photo');
		$photocategory->LANG['photocategory_page_title'] = str_replace('{category}', $photocategory->getCategoryName($photocategory->getFormField('category_id')), $LANG['photocategory_cate_subcategory']);
		if($photocategory->getFormField('pg') == 'mysubscriptions')
			$photocategory->LANG['photocategory_page_title'] = str_replace('{category}', $photocategory->getCategoryName($photocategory->getFormField('category_id')), $LANG['photocategory_my_subscribed_sub_categories']);
	}

if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $photocategory->getFormField('pg') == 'mysubscriptions')
	{
		$photocategory->setTableNames(array($CFG['db']['tbl']['photo_category'].' as gc JOIN '.$CFG['db']['tbl']['subscription'].' as s ON gc.photo_category_id = s.category_id'));
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
if ($photocategory->isShowPageBlock('form_show_category'))
{
	$photocategory->buildSelectQuery();
	$photocategory->buildConditionQuery();
	$photocategory->buildSortQuery();
	$photocategory->buildQuery();
//		$photocategory->printQuery();
	$photocategory->executeQuery();

	$smartyObj->assign('smarty_paging_list', $photocategory->populatePageLinksGET($photocategory->getFormField('start')));

	if($photocategory->isResultsFound())
	{
		$photocategory->form_show_category=$photocategory->showCategory();
	}
}


//include the header file
$photocategory->includeHeader();
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
$smartyObj->display('photoCategory.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$photocategory->includeFooter();
?>